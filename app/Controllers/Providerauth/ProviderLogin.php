<?php

namespace App\Controllers\Providerauth;

use App\Models\UsersModel;
use Exception;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\Github;

use stdClass;

class ProviderLogin extends ProviderauthController
{
    protected $userModel;
    public $session; 
    public $segment; 
    public $db; 
    public $validation; 
    public $encrypter; 
    public $lang_base_url;
    public $selected_lang;
    public $general_settings;
    public $agent;
    public function index()
    {
        if ($this->session->get('vr_sess_logged_in') == TRUE) {
            return redirect()->to(base_url('/dashboard'));
        }
		
        $data['title'] = trans('login');
		$data['meta_title'] = !empty(get_seo('Login')) ? get_seo('Login')->meta_title : 'Login | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Login')) ? get_seo('Login')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Login')) ? get_seo('Login')->meta_keywords : '';

        return view('Providerauth/ProviderLogin', $data);
    }

    public function provider_login_post()
    {
        $userModel = new UsersModel();

        $rules = [
            'email' => [
                'label'  => trans('email'),
                'rules'  => 'required|min_length[4]|max_length[100]|valid_email',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                ],
            ],
            'password' => [
                'label'  => trans('password'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],

        ];

        if ($this->validate($rules)) {

            $user = $userModel->get_user_by_email($this->request->getVar('email'));
            if (!empty($user) && $user->role != 1 && get_general_settings()->maintenance_mode_status == 1) {
                $this->session->setFlashData('errors_form', "Site under construction! Please try again later.");
                return redirect()->back();
            }else if (!empty($user) && $user->role != 1 && $user->email_status == 0) {
                $this->session->setFlashData('errors_form', "Error, before you can log in, please validate your account by clicking the verification link we sent to your email address.");
                // return redirect()->back();
                return redirect()->to(base_url('/login'));
            }

            if ($userModel->login()) {
                //remember user
                $remember_me = $this->request->getVar('remember_me');
                if ($remember_me == 1) {
                    $this->response->setCookie('_remember_user_id', user()->id, time() + 86400);
                }
				
				// Redirect to intended page after login
				$redirect = session()->get('redirect_after_login');
				if ($redirect) {
					session()->remove('redirect_after_login');
					return redirect()->to($redirect);
				} else {
					if($this->session->get('vr_sess_user_role') > 1){
						return redirect()->to(base_url('/dashboard'))->withCookies();
					}else{
						return redirect()->to(base_url('/dashboard'))->withCookies();
					}  
				}
				
				              
            } else {
                 return redirect()->to(base_url('/login'));
               // return redirect()->back()->withInput();
            }
        } else {

            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
    }

    /**
     * Logout
     */
    public function Logout()
    {
        //unset user data
        $this->session->remove('vr_sess_user_id');
        $this->session->remove('vr_sess_user_email');
        $this->session->remove('vr_sess_user_role');
        $this->session->remove('vr_sess_logged_in');
        $this->session->remove('vr_sess_app_key');
        $this->session->remove('vr_sess_user_ps');
        helper_deletecookie("remember_user_id");
        helper_deletecookie("_remember_user_id");
        return redirect()->to('/');
    }
}
