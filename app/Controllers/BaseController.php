<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url', 'form', 'text', 'security'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    /**
     * Render a view with data
     *
     * @param string $view The view to render
     * @param array $data Data to pass to the view
     * @return string
     */
    protected function render(string $view, array $data = []): string
    {
        $data['title'] = $data['title'] ?? 'Blog';
        $data['description'] = $data['description'] ?? 'A modern blogging platform';
        
        return view($view, $data);
    }

    /**
     * Set a flash message
     *
     * @param string $type The type of message (success, error, etc)
     * @param string $message The message to display
     * @return void
     */
    protected function setFlash(string $type, string $message): void
    {
        session()->setFlashdata('flash', [
            'type' => $type,
            'message' => $message
        ]);
    }

    /**
     * Get flash message
     */
    protected function getFlash(): ?array
    {
        return session()->getFlashdata('flash');
    }
} 