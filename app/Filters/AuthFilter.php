<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (! session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Get the current URI segments to determine the section
        $uri      = service('uri');
        $segment1 = $uri->getSegment(1);

        // Get user role from session
        $role = session()->get('user_role');

        // Check permissions based on URI and role
        if ($segment1 === 'admin') {
            // Only admin, manager, and editor can access admin routes
            if (! in_array($role, ['admin', 'manager', 'editor'])) {
                session()->setFlashdata('error', 'You do not have permission to access admin area');
                return redirect()->to(base_url('users'));
            }
        } elseif ($segment1 === 'users') {
            // All logged in users can access user routes
            // This is optional since all logged in users can access user area
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
