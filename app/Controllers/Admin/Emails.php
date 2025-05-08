<?php

namespace App\Controllers\Admin;

use App\Models\RolesPermissionsModel;
use App\Models\MailsModel;
use App\Models\EmailModel;
use App\Models\EmailTemplatesModel;
use App\Models\CategoriesModel;

class Emails extends AdminController
{

    public function __construct()
    {
        $this->mailsModel = new MailsModel();
        $this->emailTemplatesModel = new EmailTemplatesModel();
    }

    public function emails()
    {
        $data  = array_merge($this->data, [
            'title'   => trans('emails'),
            'user'    => user()
        ]);

        //paginate
        $data['paginate'] = $this->mailsModel->emailPaginate();
        $data['pager'] =  $data['paginate']['pager'];
        
        return view('admin/emails/emails', $data);
    }

    public function send_email()
    {
        $users = $this->mailsModel->getUsersData();
        $data  = array_merge($this->data, [
            'title'      => trans('add_email'),
            'users'      => $users,
            'loggeduser' => user()
        ]);

        $data['emailtemplates'] = $this->emailTemplatesModel->asObject()->findAll();

        $this->CategoriesModel = new CategoriesModel();
        $data['categories']    = $this->CategoriesModel->get_categories();

        return view('admin/emails/send_email', $data);
    }

    /**
     * Send Email Post
     */
    public function send_email_post()
    {        
        $num            = $this->request->getVar('num');
        $show           = $this->request->getVar('show');
        $email_verified = $this->request->getVar('email_verified');
        $plans          = $this->request->getVar('plan');
        $toEmails       = $this->request->getVar('toEmails');
        $toNames        = $this->request->getVar('toNames');
        $subject        = $this->request->getVar('name');
        $message        = $this->request->getVar('content');
        $from_email     = $this->request->getVar('from_email');
        $from_name      = $this->request->getVar('from_name');
        $category_id    = $this->request->getVar('category_id');
        $arrLocationIds = $this->request->getVar('location_id') ?? array();

        $users = $this->mailsModel->getRecipients($email_verified,$plans,$category_id,$arrLocationIds);

        $sendTo = array();

        foreach ($users as $user) {
            $user->email = trim(strtolower($user->email));
            $user->name = ucwords(strtolower(trim($user->name)));
            
            $sendTo[$user->email] = $user->name;
        }

        if(!empty($toEmails))
        {
            $toEmails = explode(',', $toEmails);
            $toNames = explode(',', $toNames);
            
            $count = count($toEmails);
            
            for($i=0;$i<$count;$i++)
            {           
                if(!empty(trim($toEmails[$i]))){
                    $toEmail = strtolower(trim($toEmails[$i]));
                    $toName = ucwords(strtolower(trim($toNames[$i])));
                
                    $sendTo[$toEmail] = $toName;                
                }                 
            }
        }

        if(!empty($num) && $num == 'y')
        {
            echo count($sendTo);
            exit();
        }

        if(!empty($show) && $show == 'y')
        {
            echo "<table class='table table-striped'>";
            foreach($sendTo as $email=>$name){
                echo "<tr><td>".$name."</td><td>".$email."</td></tr>";
            }
            if(count($sendTo) < 1){
                echo "<tr><td colspan='2'>No recipients</td></tr>";
            }
            echo "</table>";
            exit();
        }

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
             'from_email'    => [
                'label'  => trans('from_email'),
                'rules'  => 'required|max_length[200]|valid_email',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                ],
            ],
            'from_name' => [
                'label'  => trans('from_name'),
                'rules'  => 'required|min_length[4]|max_length[255]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'name' => [
                'label'  => trans('subject'),
                'rules'  => 'required|min_length[4]|max_length[255]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'content' => [
                'label'  => trans('content'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],
        ];


        if ($this->validate($rules)) {
            $usersList = $this->mailsModel->getUsersData();

            $arrUsersList = array();
            foreach ($usersList as $userdata) {
                $arrUsersList[$userdata->email] = $userdata->id;
            }

            $insertData = array();
            $replace = array('[NAME]', '[F_NAME]', '[EMAIL]', '[SITE_URL]');

            foreach($sendTo as $email=>$name)
            {
                if($email == 'admin@admin.com'){
                    continue;
                }
                $tempArr = array();
                if(array_key_exists($email, $arrUsersList)){
                    $tempArr['id'] = $arrUsersList[$email];
                }
                $tempArr['email']    = $email;
                $tempArr['fullname'] = $name;

                $replaceWith  = array($name, strtok($name, ' '), $email, base_url());
                $user_subject = str_ireplace($replace, $replaceWith, $subject);
                $user_message = str_ireplace($replace, $replaceWith, $message);

                $data = array(
                    'subject'           => $user_subject,
                    //'mail_body_content' => $user_message,
                    'user_message'      => $user_message,
                    'template_path'     => "email/email_admin_to_providers",
                    'to'                => $email,
                    'from_email'        => $from_email,
                    'from_name'         => $from_name
                );
                $emailModel = new EmailModel();
                $emailModel->send_email($data);

                $insertData[] = $tempArr;                
            }
            $id =  $this->mailsModel->email_log($insertData);
            if ($id) {
                $this->session->setFlashData('success', trans("msg_email_sent"));
                return $this->response->setJSON([
                    'success' => true,
                    'message' => trans("msg_email_sent")
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'error' => true,
                    'message' => trans("msg_error")
                ]);
            }
        } else {
            $errors = $validation->getErrors();
            return $this->response->setJSON([
                'success' => false,
                'errors_form' => true,
                'errors' => $errors
            ]);
        }
        exit;
    }
}
