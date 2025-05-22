<?php

namespace App\Controllers;

class Pages extends BaseController {

    public function index() {
        return view('pages/index');
    }

    public function about() {
        $data = [
            'title' => 'About Us',
            'description' => 'Learn more about our blog and mission',
        ];

        return $this->render('visitor/pages/about', $data);
    }

    public function terms() {
        $data = [
            'title' => 'Terms of Service',
            'description' => 'Read our terms of service',
        ];

        return $this->render('visitor/pages/terms', $data);
    }

    public function privacy() {
        $data = [
            'title' => 'Privacy Policy',
            'description' => 'Read our privacy policy',
        ];

        return $this->render('visitor/pages/privacy', $data);
    }

    public function contact() {
        if ($this->request->is('post')) {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email',
                'message' => 'required|min_length[10]',
            ];

            if ($this->validate($rules)) {
                // Send email
                $email = \Config\Services::email();
                $email->setTo(getenv('admin_email'));
                $email->setFrom($this->request->getPost('email'), $this->request->getPost('name'));
                $email->setSubject('Contact Form Submission');
                $email->setMessage($this->request->getPost('message'));
                $email->send();

                $this->setFlash('success', 'Your message has been sent. We will get back to you soon.');
                return redirect()->to('/contact');
            }
        }

        $data = [
            'title' => 'Contact Us',
            'description' => 'Get in touch with us',
            'validation' => $this->validator,
        ];

        return $this->render('visitor/pages/contact', $data);
    }
}
