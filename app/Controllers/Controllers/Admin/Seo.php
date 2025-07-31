<?php

namespace App\Controllers\Admin;

use App\Models\RolesPermissionsModel;
use App\Models\SeoModel;

class Seo extends AdminController
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
    protected $seoModel;

    public function __construct()
    {
        $this->seoModel = new SeoModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title' => trans('SEO'),
        ]);

        //paginate
        $data['paginate'] = $this->seoModel->seoPaginate();
        $data['pager'] =  $data['paginate']['pager'];


        return view('admin/seo/seo', $data);
    }

    public function add_seo()
    {
        $data = array_merge($this->data, [
            'title' => trans('Add seo'),
        ]);

        return view('admin/seo/add_seo', $data);
    }

    /**
     * Add Email Template Post
     */
    public function add_seo_post()
    {
        $validation =  \Config\Services::validation();
			
        //validate inputs

        $rules = [
            'meta_title' => [
                'label'  => trans('Title'),
                'rules'  => 'required|min_length[4]|max_length[255]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'meta_description' => [
                'label'  => trans('Description'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],
            'page_name' => [
                'label'  => trans('Page'),
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
				$img->move(FCPATH . 'uploads/seo');
				$img_name = $img->getName();
			}
            //add email template
            $id =  $this->seoModel->add_seo($img_name);
            if ($id) {
                $this->session->setFlashData('success', trans("SEO Added Successfully"));
                return redirect()->to(admin_url().'seo');
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
    public function edit_seo($id)
    {

        $data = array_merge($this->data, [
            'title' => trans('Update seo'),
            'seo'  => $this->seoModel->get_seo_by_id($id),
        ]);

        if (empty($data['seo']->id)) {
            return redirect()->back();
        }

        return view('admin/seo/edit_seo', $data);
    }

    /**
     * Edit Email Template Post
     */
    public function edit_seo_post()
    {
        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'meta_title' => [
                'label'  => trans('Title'),
                'rules'  => 'required|min_length[4]|max_length[255]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'meta_description' => [
                'label'  => trans('Description'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],
            'page_name' => [
                'label'  => trans('Page'),
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
				$img->move(FCPATH . 'uploads/seo');
				$img_name = $img->getName();
			}
			if($img_name == ''){
				$img_name = $this->request->getVar('image_name');
			}
             $data = array(
                'id' => $this->request->getVar('id')
            );
            if ($this->seoModel->edit_seo($data["id"],$img_name)) {
                $this->session->setFlashData('success', trans("SEO Updated Successfully"));
                return redirect()->to(admin_url().'seo');
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
    public function delete_seo_post()
    {

        $id = $this->request->getVar('id');
        $emailtemplate = $this->seoModel->asObject()->find($id);


        if ($this->seoModel->delete_seo($id)) {
            $this->session->setFlashData('success', trans("SEO Deleted Successfully"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }


}
