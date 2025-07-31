<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Models\CategoriesModel;
use App\Models\CategoriesSubModel;

class Categories extends AdminController
{
    protected $categoriesModel;
    protected $CategoriesModel;
    protected $categoriessubModel;
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
    
    public function __construct()
    {
        $this->categoriesModel = new CategoriesModel();
		$this->categoriessubModel = new CategoriesSubModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title'     => trans('Categories'),
            'active_tab'     => 'categories',
        ]);

        // Paginations
        $paginate = $this->categoriesModel->DataPaginations();
        $data['categories'] =   $paginate['categories'];

        $data['paginations'] =  $paginate['pager']->Links('default', 'custom_pager');


        return view('admin/categories/categories', $data);
    }
	
    public function sub_categories()
    {
        $data = array_merge($this->data, [
            'title'     => trans('Sub Categories'),
            'active_tab'     => 'sub-categories',
        ]);

        // Paginations
        $paginate = $this->categoriessubModel->DataPaginations();
        $data['categories'] =   $paginate['categories'];
		
		
        $this->CategoriesModel = new CategoriesModel();
        $data['categories_list'] = $this->CategoriesModel->get_categories();

        $data['paginations'] =  $paginate['pager']->Links('default', 'custom_pager');

        return view('admin/categories/sub_categories', $data);
    }
	

    public function saved_categories_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'name' => [
                'label'  => trans('name'),
                'rules'  => 'required|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $id = $this->request->getVar('id');
            if (!empty($id)) {
				$img_name = '';
				if(!empty($_FILES) && !empty($_FILES['category_icon']['name'])){
					$img = $this->request->getFile('category_icon');
					$img->move(FCPATH . 'uploads/category');
					$img_name = $img->getName();
				}
				if($img_name == ''){
					$img_name = $this->request->getVar('category_icon_name');
				}
                if ($this->categoriesModel->update_categories($id,$img_name)) {
                    $this->session->setFlashData('success', trans("msg_updated"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            } else {
				$img_name = '';
				if(!empty($_FILES) && !empty($_FILES['category_icon']['name'])){
					$img = $this->request->getFile('category_icon');
					$img->move(FCPATH . 'uploads/category');
					$img_name = $img->getName();
				}
                if ($this->categoriesModel->add_categories($img_name)) {
                    $this->session->setFlashData('success', trans("msg_suc_added"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }


    public function saved_sub_categories_post()
    {
        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'name' => [
                'label'  => trans('name'),
                'rules'  => 'required|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $id = $this->request->getVar('id');
            if (!empty($id)) {
                if ($this->categoriessubModel->update_categories($id)) {
                    $this->session->setFlashData('success', trans("msg_updated"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            } else {
                if ($this->categoriessubModel->add_categories()) {
                    $this->session->setFlashData('success', trans("msg_suc_added"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }


    public function delete_categories_post()
    {
        $id = $this->request->getVar('id');

        if ($this->categoriesModel->delete_categories($id)) {
            $this->session->setFlashData('success', trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    public function delete_sub_categories_post()
    {
        $id = $this->request->getVar('id');

        if ($this->categoriessubModel->delete_categories($id)) {
            $this->session->setFlashData('success', trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    //activate inactivate countries
    public function activate_inactivate_categories()
    {
        $action = $this->request->getVar('action');

        $status = 1;
        if ($action == "inactivate") {
            $status = 0;
        }
        $data = array(
            'status' => $status
        );
        return $this->categoriesModel->update(null, $data);
    }
}
