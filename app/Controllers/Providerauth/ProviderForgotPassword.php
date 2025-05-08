<?php

namespace App\Controllers\Providerauth;

use App\Models\EmailModel;
use App\Models\UsersModel;

class ProviderForgotPassword extends ProviderauthController
{
    public function index()
    {
        if ($this->session->get('vr_sess_logged_in') == TRUE) {
            return redirect()->to(base_url('/'));
        }

        $data['title'] = trans('forgot_password');
		$data['meta_title'] = !empty(get_seo('Forgot Password')) ? get_seo('Forgot Password')->meta_title : 'Forgot Password | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Forgot Password')) ? get_seo('Forgot Password')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Forgot Password')) ? get_seo('Forgot Password')->meta_keywords : '';

        return view('Providerauth/ProviderForgotPassword', $data);
    }

    /**
     * Forgot Password Post
     */
    public function forgot_password_post()
    {
        $userModel = new UsersModel();

        $email = clean_str($this->request->getVar('email'));
        //get user
        $user =   $userModel->get_user_by_email($email);
        //if user not exists
        if (empty($user)) {
            $this->session->setFlashData('error_form', html_escape(trans("reset_password_error")));
            return redirect()->to($this->agent->getReferrer())->withInput();
        } else {
            $emailModel = new EmailModel();
            $emailModel->send_email_reset_password_provider($user->id);
            $this->session->setFlashData('success_form', trans("reset_password_success"));
            return redirect()->to($this->agent->getReferrer());
        }
    }
}
