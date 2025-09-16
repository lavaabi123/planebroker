<?php

namespace App\Controllers\Providerauth;

use App\Models\EmailModel;
use App\Models\UsersModel;

class ProviderResetPassword extends ProviderauthController
{
    protected $userModel;
    protected $EmailModel;
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
        $userModel = new UsersModel();
        if ($this->session->get('vr_sess_logged_in') == TRUE) {
            return redirect()->to(base_url('/'));
        }

        $token = clean_str($this->request->getVar('token'));
        $data['title'] = trans('reset_password');

        $data["user"] =   $userModel->get_user_by_token($token);
        $data["success"] = $this->session->get('success_form');
        if (empty($data["user"]) && empty($data["success"])) {
            return redirect()->to($this->agent->getReferrer());
        }

		$data['meta_title'] = !empty(get_seo('Reset Password')) ? get_seo('Reset Password')->meta_title : 'Reset Password | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Reset Password')) ? get_seo('Reset Password')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Reset Password')) ? get_seo('Reset Password')->meta_keywords : '';
        return view('Providerauth/ProviderResetPassword', $data);
    }

    /**
     * Forgot Password Post
     */
    public function reset_password_post()
    {
        $userModel = new UsersModel();

        $success = $this->request->getVar('success_form');
        if ($success == 1) {
            redirect(lang_base_url());
        }
        $rules = [
            'password' => [
                'label'  => trans('password'),
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                ],
            ],
            'confirm_password' => [
                'label'  => trans('password'),
                'rules'  => 'required|min_length[4]|matches[password]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'matches' => 'Password Not Match!',

                ],
            ],


        ];

        if ($this->validate($rules)) {

            $token = clean_str($this->request->getVar('token'));
            if ($userModel->reset_password($token)) {
                $this->session->setFlashData('success_form', trans("message_change_password_success"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('errors_form', trans("message_change_password_error"));
                return redirect()->to($this->agent->getReferrer());
            }
        } else {
            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->to($this->agent->getReferrer())->withInput()->with('error', $this->validator->getErrors());
        }
    }
	
	
    public function set_password()
    {
        $userModel = new UsersModel();
        if ($this->session->get('vr_sess_logged_in') == TRUE) {
            return redirect()->to(base_url('/'));
        }

        $user_id = clean_str($this->request->getVar('user_id'));
        $data['title'] = trans('Set Password');

        $data["user"] =   $userModel->get_user($user_id);
        $data["success"] = $this->session->get('success_form');
        if (empty($data["user"]) && empty($data["success"])) {
            return redirect()->to($this->agent->getReferrer());
        }

		$data['meta_title'] = !empty(get_seo('Set Password')) ? get_seo('Set Password')->meta_title : 'Set Password | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Set Password')) ? get_seo('Set Password')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Set Password')) ? get_seo('Set Password')->meta_keywords : '';
        return view('Providerauth/ProviderSetPassword', $data);
    }
    public function set_password_post()
    {
        $userModel = new UsersModel();

        $success = $this->request->getVar('success_form');
        if ($success == 1) {
            redirect(lang_base_url());
        }
        $rules = [
            'password' => [
                'label'  => trans('password'),
                'rules'  => 'required|min_length[12]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                ],
            ],
            'confirm_password' => [
                'label'  => trans('password'),
                'rules'  => 'required|min_length[12]|matches[password]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'matches' => 'Password Not Match!',

                ],
            ],


        ];

        if ($this->validate($rules)) {

            $id = clean_str($this->request->getVar('id'));
            if ($userModel->reset_password_by_id($id)) {
                $this->session->setFlashData('success_form', trans("Your password has been successfully updated! Please login to continue."));
                return redirect()->to(base_url('/login'));
            } else {
                $this->session->setFlashData('errors_form', trans("message_change_password_error"));
                return redirect()->to($this->agent->getReferrer());
            }
        } else {
            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->to($this->agent->getReferrer())->withInput()->with('error', $this->validator->getErrors());
        }
    }

}
