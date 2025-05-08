<?php

namespace App\Controllers\Admin;

use App\Models\RolesPermissionsModel;
use App\Models\BlogModel;

class Blog extends AdminController
{

    public function __construct()
    {
        $this->blogModel = new BlogModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title' => trans('Blog'),
        ]);

        //paginate
        $data['paginate'] = $this->blogModel->blogPaginate();
        $data['pager'] =  $data['paginate']['pager'];


        return view('admin/blog/blog', $data);
    }

    public function add_blog()
    {
        $data = array_merge($this->data, [
            'title' => trans('Add Blog'),
        ]);

        return view('admin/blog/add_blog', $data);
    }

    /**
     * Add Email Template Post
     */
    public function add_blog_post()
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
			$img_name = '';
			if(!empty($_FILES) && !empty($_FILES['image']['name'])){
				$img = $this->request->getFile('image');
				$img->move(FCPATH . 'uploads/blog');
				$img_name = $img->getName();
			}
            //add email template
            $id =  $this->blogModel->add_blog($img_name);
            if ($id) {
                $this->session->setFlashData('success', trans("Blog Added Successfully"));
                return redirect()->to(admin_url().'blog');
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
    public function edit_blog($id)
    {

        $data = array_merge($this->data, [
            'title' => trans('Update Blog'),
            'blog'  => $this->blogModel->get_blog_by_id($id),
        ]);

        if (empty($data['blog']->id)) {
            return redirect()->back();
        }

        return view('admin/blog/edit_blog', $data);
    }

    /**
     * Edit Email Template Post
     */
    public function edit_blog_post()
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
			
			$img_name = '';
			if(!empty($_FILES) && !empty($_FILES['image']['name'])){
				$img = $this->request->getFile('image');
				$img->move(FCPATH . 'uploads/blog');
				$img_name = $img->getName();
			}
			if($img_name == ''){
				$img_name = $this->request->getVar('image_name');
			}
             $data = array(
                'id' => $this->request->getVar('id')
            );
            if ($this->blogModel->edit_blog($data["id"],$img_name)) {
                $this->session->setFlashData('success', trans("Blog Updated Successfully"));
                return redirect()->to(admin_url().'blog');
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
    public function delete_blog_post()
    {

        $id = $this->request->getVar('id');
        $emailtemplate = $this->blogModel->asObject()->find($id);


        if ($this->blogModel->delete_blog($id)) {
            $this->session->setFlashData('success', trans("Blog Deleted Successfully"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }


}
