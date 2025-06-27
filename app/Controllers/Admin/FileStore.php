<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostPhotoModel;

class FileStore extends BaseController {
    protected $photoModel;
    protected $sizes;
    protected $basePath;
    protected $uploadPath;

    protected $allowedFields = [
        'user_id',
        'post_id',
        'file_title',
        'file_path',
        'created_at',
        'updated_at',
    ];

    public function __construct() {
        $this->photoModel = new PostPhotoModel();
        $this->basePath   = 'files/' . session()->get('user_id') . '/images/';
        $this->uploadPath = WRITEPATH . "uploads/" . $this->basePath;

        // Define sizes: key => [width, height, keepRatio]
        $this->sizes = [
            'raw'    => [null, null, false],
            'large'  => [1200, 1200, true],
            'medium' => [600, 600, true],
            'thumb'  => [200, 200, true],
        ];
    }

    // Handle image upload
    public function upload() {
        $userId = session()->get('user_id');
        if (! $userId) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }
        $file = $this->request->getFile('file');
        if (! $file || ! $file->isValid()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'No valid file uploaded']);
        }
        $newName    = $file->getRandomName();
        $isFeatured = (bool) $this->request->getPost('is_featured');

        // For featured images, ensure we generate recommended dimensions
        $sizes = $this->sizes;
        if ($isFeatured) {
            $sizes = [
                'raw'    => [null, null, false],
                'large'  => [1200, 630, true],
                'medium' => [600, 315, true],
                'thumb'  => [200, 105, true],
            ];
        }

        $urls        = [];
        $rawFilePath = "";
        foreach ($sizes as $folder => [$w, $h, $keepRatio]) {
            $dir = $this->uploadPath . $folder . '/';
            if (! is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $targetPath = $dir . $newName;
            if ($folder === 'raw') {
                $file->move($dir, $newName);
                $rawFilePath = $this->basePath . $folder . '/' . $newName;
            } else {
                $image = \Config\Services::image()->withFile($this->uploadPath . 'raw/' . $newName);
                if ($w && $h) {
                    $image->resize($w, $h, $keepRatio ? true : false, 'height');
                }
                $image->save($targetPath);
            }
            $urls[$folder] = base_url($this->basePath . $folder . '/' . $newName);
        }

        $fileTitle = $this->request->getPost('title') ?: pathinfo($file->getClientName(), PATHINFO_FILENAME);

        // Get post_id from either POST data or query string (for TinyMCE)
        $postId = $this->request->getPost('post_id') ?: $this->request->getGet('post_id') ?: null;

        $photoId = $this->photoModel->insert([
            'user_id'    => $userId,
            'post_id'    => $postId,
            'file_title' => $fileTitle,
            'file_path'  => $rawFilePath,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ], true);

        // Format for Froala Editor's expected response
        // Ensure we have both 'link' for Froala and 'location' for backwards compatibility
        $fileUrl = base_url($rawFilePath);

        // Build the response
        $response = [
            'success' => true,
            'id'      => $photoId,
            'name'    => $fileTitle,
            'link'    => $fileUrl,
        ];

        // Add all generated image sizes to the response
        foreach ($urls as $size => $url) {
            $response[$size] = $url;
        }

        return $this->response->setJSON($response);
    }

    // List/search user images (API)
    public function list() {
        $userId = session()->get('user_id');
        if (! $userId) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $search  = $this->request->getGet('q');
        $page    = (int) $this->request->getGet('page') ?: 1;
        $perPage = (int) $this->request->getGet('limit') ?: 50;

        $builder = $this->photoModel->where('user_id', $userId);

        if ($search) {
            $builder = $builder->like('file_title', $search);
        }

        $photos = $builder->orderBy('created_at', 'DESC')->paginate($perPage, 'default', $page);

        $formattedPhotos = array_map(function ($photo) {
            $item = [
                'tag' => $photo['file_title'],
                'name' => $photo['file_title'],
                'id'   => $photo['id'],
            ];

            foreach ($this->sizes as $size => $value) {
                $item[$size] = base_url(str_replace('/raw/', '/' . $size . '/', $photo['file_path']));
            }
            $item['url'] = $item["large"] ?? $item["medium"] ?? $item["thumb"] ?? null;
            return $item;
        }, $photos);

        return $this->response->setJSON($formattedPhotos);
    }

    public function delete() {
        $userId = session()->get('user_id');
        if (! $userId) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $data    = $this->request->getRawInput();
        $photoId = $data['data-id'] ?? null;
        $postId  = $data['post_id'] ?? null;
        // $postUserId = $data['user_id'] ?? null;

        if (! $photoId) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Photo ID is required']);
        }

        $photo = $this->photoModel->find($photoId);

        if (! $photo) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Photo not found']);
        }

        if ($photo['user_id'] !== $userId) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Unauthorized']);
        }

        if ($photo['post_id'] !== $postId) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'You can not delete other post images']);
        }

        $deleted = $this->photoModel->delete($photoId);

        if (! $deleted) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to delete photo']);
        }

        // Delete the original file
        $filePath = WRITEPATH . $photo['file_path'];
        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        // Delete all resized versions
        foreach ($this->sizes as $size => $value) {
            $path = str_replace('/raw/', '/' . $size . '/', $filePath);
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        return $this->response->setJSON(['success' => true]);
    }
}
