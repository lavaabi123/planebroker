<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PasswordProtect implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Set your password
        $correctPassword = 'planebroker';

        // Check if password is already entered
        if (!$session->get('site_unlocked')) {
            // If form is submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['access_password'])) {
                if ($_POST['access_password'] === $correctPassword) {
                    $session->set('site_unlocked', true);
                    return redirect()->to(str_replace('/index.php','',current_url()));
                } else {
                    $session->setFlashdata('error', 'Incorrect password');
                }
            }

            // Show password form
            echo view('password_protect');
            exit;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do here
    }
}
