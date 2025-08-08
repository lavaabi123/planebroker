<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Models\FieldsModel;
use App\Models\CategoriesModel;
use App\Models\CategoriesSubModel;
use App\Models\FieldGroupModel;

class Fields extends AdminController
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
    
    protected $fieldsModel;
    protected $CategoriesModel;
    protected $categoriessubModel;
    protected $FieldGroupModel;

    public function __construct()
    {
        $this->fieldsModel = new FieldsModel();
		$this->CategoriesModel = new CategoriesModel();
		$this->categoriessubModel = new CategoriesSubModel();
        $this->FieldGroupModel = new FieldGroupModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title'     => trans('Dynamic Fields'),
            'active_tab'     => 'dynamic-fields',
        ]);

        // Paginations
        $data['fields'] = $this->fieldsModel->field_lists();
		
        $data['categories_list'] = $this->CategoriesModel->get_categories();
        $data['sub_categories_list'] = $this->categoriessubModel->get_categories();
		
        $data['field_group'] = $this->FieldGroupModel->get_fields_group();

        return view('admin/fields/fields', $data);
    }

    public function filter_fields()
    {
        $data = array_merge($this->data, [
            'title'     => trans('Filter Fields'),
            'active_tab'     => 'filter-fields',
        ]);

        // Paginations
        $data['fields'] = $this->fieldsModel->field_lists();
        $data['categories_list'] = $this->CategoriesModel->get_categories();
        $data['sub_categories_list'] = $this->categoriessubModel->get_categories();

        return view('admin/fields/filter_fields', $data);
    }
    public function saved_fields_post()
    {
		//echo "<pre>"; print_r($_POST);exit;
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
                if ($this->fieldsModel->update_fields($id)) {
                    $this->session->setFlashData('success', trans("msg_updated"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            } else {
                if ($this->fieldsModel->add_fields()) {
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


    public function saved_filter_fields_post()
    {
		//echo "<pre>"; print_r($_POST);exit;
        $validation =  \Config\Services::validation();
        
		$id = $this->request->getVar('id');
		if (!empty($id)) {
			if ($this->fieldsModel->update_filter($id)) {
				$this->session->setFlashData('success', trans("msg_updated"));
				return redirect()->to($this->agent->getReferrer());
			} else {
				$this->session->setFlashData('error', trans("msg_error"));
				return redirect()->to($this->agent->getReferrer());
			}
		}
        
    }

    public function delete_fields_post()
    {
        $id = $this->request->getVar('id');

        if ($this->fieldsModel->delete_fields($id)) {
            $this->session->setFlashData('success', trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }
	
	public function update_order_post(){
		foreach ($_POST['order'] as $item) {
			$this->fieldsModel->update($item['id'], ['field_order' => $item['sort_order']]);
		}
		return $this->response->setJSON(['status' => 'success']);
	}

	public function update_filter_order_post(){
		foreach ($_POST['order'] as $item) {
			$this->fieldsModel->update($item['id'], ['filter_order' => $item['sort_order']]);
		}
		return $this->response->setJSON(['status' => 'success']);
	}
    //activate inactivate countries
    public function activate_inactivate_fields()
    {
        $action = $this->request->getVar('action');

        $status = 1;
        if ($action == "inactivate") {
            $status = 0;
        }
        $data = array(
            'status' => $status
        );
        return $this->fieldsModel->update(null, $data);
    }
}
