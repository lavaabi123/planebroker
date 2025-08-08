<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Authentication implements FilterInterface
{

	public function before(RequestInterface $request, $arguments = null)
	{		
		$currentPath = $request->getPath(); // e.g., "admin/dashboard"

		if (str_starts_with($currentPath, '/admin')) {
			if (!session()->get('admin_sess_logged_in')) {
				return redirect()->to(base_url('auth/login'));
			}
		} else {
			if (!session()->get('vr_sess_logged_in')) {
				//return redirect()->to(base_url('login'));
			}
		}		
		
	}
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		//

	}
}
