<?php

namespace App\Controllers\Admin;

use App\Models\RolesPermissionsModel;
use App\Models\EmailTemplatesModel;

class EmailTemplates extends AdminController
{
    public $session; 
    public $segment; 
    public $db; 
    public $validation; 
    public $encrypter; 
    public $lang_base_url;
    public $selected_lang;
    public $general_settings;
    public $agent;
    public $analytics;
    public $file_count;
    public $file_per_page;
    protected $RolesPermissionsModel;
    public $data;
    protected $emailTemplatesModel;

    public function __construct()
    {
        $this->emailTemplatesModel = new EmailTemplatesModel();
    }

    public function emailtemplates()
    {
        $data = array_merge($this->data, [
            'title' => trans('email templates'),
        ]);

        //paginate
        $data['paginate'] = $this->emailTemplatesModel->emailtemplatePaginate();
        $data['pager'] =  $data['paginate']['pager'];


        return view('admin/emailtemplates/emailtemplates', $data);
    }

    public function add_emailtemplate()
    {
        $data = array_merge($this->data, [
            'title' => trans('add_emailtemplate'),
        ]);

        return view('admin/emailtemplates/add_emailtemplate', $data);
    }

    /**
     * Add Email Template Post
     */
    public function add_emailtemplate_post()
    {
        $validation =  \Config\Services::validation();

        //validate inputs

        $rules = [
            'name' => [
                'label'  => trans('name'),
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
            //add email template
            $id =  $this->emailTemplatesModel->add_emailtemplate();
            if ($id) {
                $this->session->setFlashData('success', trans("msg_emailtemplate_added"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Edit Email Template
     */
    public function edit_emailtemplate($id)
    {

        $data = array_merge($this->data, [
            'title' => trans('update_emailtemplate'),
            'emailtemplate'  => $this->emailTemplatesModel->get_emailtemplate($id),
        ]);

        if (empty($data['emailtemplate']->id)) {
            return redirect()->back();
        }

        return view('admin/emailtemplates/edit_emailtemplate', $data);
    }

    /**
     * Edit Email Template Post
     */
    public function edit_emailtemplate_post()
    {
        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'name' => [
                'label'  => trans('name'),
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
             $data = array(
                'id' => $this->request->getVar('id')
            );
            if ($this->emailTemplatesModel->edit_emailtemplate($data["id"])) {
                $this->session->setFlashData('success', trans("msg_updated"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('errors', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Delete Email Template Post
     */
    public function delete_emailtemplate_post()
    {

        $id = $this->request->getVar('id');
        $emailtemplate = $this->emailTemplatesModel->asObject()->find($id);


        if ($this->emailTemplatesModel->delete_emailtemplate($id)) {
            $this->session->setFlashData('success', trans("email template") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    /**
     * Ban Email Template Post
     */
    public function ban_emailtemplate_post()
    {

        $option = $this->request->getVar('option');
        $id = $this->request->getVar('id');

        $user = $this->userModel->asObject()->find($id);
        if ($user->id == 1 || $user->id == user()->id) {
            $this->session->setFlashData('error', trans("msg_error"));
        }

        //if option ban
        if ($option == 'ban') {
            if ($this->emailTemplatesModel->ban_emailtemplate($id)) {
                $this->session->setFlashData('success', trans("msg_emailtemplate_banned"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }

        //if option remove ban
        if ($option == 'remove_ban') {
            if ($this->emailTemplatesModel->remove_emailtemplate_ban($id)) {
                $this->session->setFlashData('success', trans("msg_ban_removed"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }
    }

}
