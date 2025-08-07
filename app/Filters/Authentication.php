<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Authentication implements FilterInterface
{

	public function before(RequestInterface $request, $arguments = null)
	{
		
		if (!session()->get('vr_sess_logged_in') && !session()->get('admin_sess_logged_in')) {
			$currentPath = $request->getPath(); // e.g., "admin/dashboard"

			if (str_starts_with($currentPath, '/admin')) {
				return redirect()->to(base_url('auth/login'));
			} else {
				return redirect()->to(base_url('login'));
			}
		}
		
	}
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		//

	}
}
