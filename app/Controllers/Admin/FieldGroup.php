<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Models\CategoriesModel;
use App\Models\FieldGroupModel;

class FieldGroup extends AdminController
{
    protected $FieldGroupModel;

    public function __construct()
    {
        $this->FieldGroupModel = new FieldGroupModel();
        $this->categoriesModel = new CategoriesModel();
    }

    public function index()
    {
        $categoryId = $this->request->uri->getSegment(4);
        if ($categoryId == '') {
            return redirect()->to(admin_url().'/categories');
        }
        $categoryData = $this->categoriesModel->get_categories_by_id($categoryId);

        $data = array_merge($this->data, [
            'title'       =>  $categoryData->name.' - '.trans('Fields Group'),
            'active_tab'  => 'fields_group',
            'categoryId'  => $categoryId
        ]);

        // Paginations
        $paginate = $this->FieldGroupModel->DataPaginations($categoryId);
        $data['fields_group'] =   $paginate['fields_group'];

        $data['paginations'] =  $paginate['pager']->Links('default', 'custom_pager');

        return view('admin/categories/fields_group', $data);
    }

    public function saved_fields_group_post()
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
            'category_id' => [
               'label'  => trans('category'),
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
                if ($this->FieldGroupModel->update_fields_group($id)) {
                    $this->session->setFlashData('success', trans("msg_updated"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            } else {
                if ($this->FieldGroupModel->add_fields_group()) {
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

    public function delete_fields_group_post()
    {
        $id = $this->request->getVar('id');

        if ($this->FieldGroupModel->delete_fields_group($id)) {
            $this->session->setFlashData('success', trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }
	
	public function update_order_post(){
		foreach ($_POST['order'] as $item) {
			$this->FieldGroupModel->update($item['id'], ['sort_order' => $item['sort_order']]);
		}
		return $this->response->setJSON(['status' => 'success']);
	}

    //activate inactivate fields_group
    public function activate_inactivate_fields_group()
    {
        $action = $this->request->getVar('action');

        $status = 1;
        if ($action == "inactivate") {
            $status = 0;
        }
        $data = array(
            'status' => $status
        );
        return $this->FieldGroupModel->update(null, $data);
    }
}
