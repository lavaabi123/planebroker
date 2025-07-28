<?php

namespace App\Controllers\Admin;

use App\Models\RolesPermissionsModel;
use App\Models\TestimonialModel;

class Testimonial extends AdminController
{

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title' => trans('Testimonial'),
        ]);

        //paginate
        $data['paginate'] = $this->testimonialModel->testimonialPaginate();
        $data['pager'] =  $data['paginate']['pager'];


        return view('admin/testimonial/testimonial', $data);
    }

    public function add_testimonial()
    {
        $data = array_merge($this->data, [
            'title' => trans('Add Testimonial'),
        ]);

        return view('admin/testimonial/add_testimonial', $data);
    }

    /**
     * Add Email Template Post
     */
    public function add_testimonial_post()
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
            $id =  $this->testimonialModel->add_testimonial();
            if ($id) {
                $this->session->setFlashData('success', trans("Testimonial Added Successfully"));
                return redirect()->to(admin_url().'testimonial');
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
    public function edit_testimonial($id)
    {

        $data = array_merge($this->data, [
            'title' => trans('Update Testimonial'),
            'testimonial'  => $this->testimonialModel->get_testimonial_by_id($id),
        ]);

        if (empty($data['testimonial']->id)) {
            return redirect()->back();
        }

        return view('admin/testimonial/edit_testimonial', $data);
    }

    /**
     * Edit Email Template Post
     */
    public function edit_testimonial_post()
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
            if ($this->testimonialModel->edit_testimonial($data["id"])) {
                $this->session->setFlashData('success', trans("Testimonial Updated Successfully"));
                return redirect()->to(admin_url().'testimonial');
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
    public function delete_testimonial_post()
    {

        $id = $this->request->getVar('id');
        $emailtemplate = $this->testimonialModel->asObject()->find($id);


        if ($this->testimonialModel->delete_testimonial($id)) {
            $this->session->setFlashData('success', trans("Testimonial Deleted Successfully"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }


}
