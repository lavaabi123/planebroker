<?php

namespace App\Controllers\Admin;

use App\Models\RolesPermissionsModel;
use App\Models\SubscriptionModel;

class Subscription extends AdminController
{

    public function __construct()
    {
        $this->subscriptionModel = new SubscriptionModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title' => trans('Subscription Plans'),
        ]);

        //paginate
        $data['paginate'] = $this->subscriptionModel->subscriptionPaginate();
        $data['pager'] =  $data['paginate']['pager'];


        return view('admin/subscription/subscription', $data);
    }

    public function add_subscription()
    {
        $data = array_merge($this->data, [
            'title' => trans('Add Subscription'),
        ]);

        return view('admin/subscription/add_subscription', $data);
    }

    /**
     * Add Email Template Post
     */
    public function add_subscription_post()
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
            $id =  $this->subscriptionModel->add_subscription();
            if ($id) {
                $this->session->setFlashData('success', trans("Subscription Added Successfully"));
                return redirect()->to(admin_url().'subscription');
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
    public function edit_subscription($id)
    {

        $data = array_merge($this->data, [
            'title' => trans('Update subscription'),
            'subscription'  => $this->subscriptionModel->get_subscription_by_id($id),
        ]);

        if (empty($data['subscription']->id)) {
            return redirect()->back();
        }

        return view('admin/subscription/edit_subscription', $data);
    }

    /**
     * Edit Email Template Post
     */
    public function edit_subscription_post()
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
        ];

        if ($this->validate($rules)) {
			
             $data = array(
                'id' => $this->request->getVar('id')
            );
            if ($this->subscriptionModel->edit_subscription($data["id"])) {
                $this->session->setFlashData('success', trans("Plan Updated Successfully"));
                return redirect()->to(admin_url().'subscription');
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
    public function delete_subscription_post()
    {

        $id = $this->request->getVar('id');
        $emailtemplate = $this->subscriptionModel->asObject()->find($id);


        if ($this->subscriptionModel->delete_subscription($id)) {
            $this->session->setFlashData('success', trans("Subscription Deleted Successfully"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }


}
