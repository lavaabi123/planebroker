<?php

namespace App\Controllers\Admin;

use App\Models\RolesPermissionsModel;
use App\Models\SupportModel;

class Support extends AdminController
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
    protected $supportModel;

    public function __construct()
    {
        $this->supportModel = new SupportModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title' => trans('Support'),
        ]);

        //paginate
        $data['supports'] = $this->supportModel->support_list();


        return view('admin/support/support', $data);
    }

    public function add_support()
    {
        $data = array_merge($this->data, [
            'title' => trans('Add Support'),
        ]);

        return view('admin/support/add_support', $data);
    }

    /**
     * Add Email Template Post
     */
    public function add_support_post()
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
            $id =  $this->supportModel->add_support();
            if ($id) {
                $this->session->setFlashData('success', trans("Support Added Successfully"));
                return redirect()->to(admin_url().'support');
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
    public function edit_support($id)
    {

        $data = array_merge($this->data, [
            'title' => trans('Update Support'),
            'support'  => $this->supportModel->get_support_by_id($id),
        ]);

        if (empty($data['support']->id)) {
            return redirect()->back();
        }

        return view('admin/support/edit_support', $data);
    }

    /**
     * Edit Email Template Post
     */
    public function edit_support_post()
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
            if ($this->supportModel->edit_support($data["id"])) {
                $this->session->setFlashData('success', trans("Support Updated Successfully"));
                return redirect()->to(admin_url().'support');
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
    public function delete_support_post()
    {

        $id = $this->request->getVar('id');
        $emailtemplate = $this->supportModel->asObject()->find($id);


        if ($this->supportModel->delete_support($id)) {
            $this->session->setFlashData('success', trans("Support Deleted Successfully"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }


}
