<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {

        /*if (!auth_check()) {
            return redirect()->route('admin/login');
        }*/
		if (!session()->has('user_id')) {
			helper('cookie');
			$token = get_cookie('_remember_user_id');
			$token1 = get_cookie('_remember_user_id_admin');
			if ($token) {
				$userModel = new \App\Models\UserModel();
				$user = $userModel->where('id', $token)->first();

				if ($user) {
					//set user data
					$user_data = array(
						'vr_sess_user_id' => $user->id,
						'vr_sess_user_email' => $user->email,
						'vr_sess_user_role' => $user->role,
						'vr_sess_logged_in' => true,
						'vr_sess_user_ps' => md5($user->password),
						'vr_sess_email_status' => $user->email_status,
					);
					
					session()->set($user_data);
				}
			}
			if ($token1) {
				$userModel = new \App\Models\UserModel();
				$user = $userModel->where('id', $token1)->first();

				if ($user) {
					//set user data
					$user_data = array(
						'admin_sess_user_id' => $user->id,
						'admin_sess_user_email' => $user->email,
						'admin_sess_user_role' => $user->role,
						'admin_sess_logged_in' => true,
						'admin_sess_user_ps' => md5($user->password),
						'admin_sess_email_status' => $user->email_status,
					);
					session()->set($user_data);
				}
			}
		}

		return $request;
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
