<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Models\ContactsModel;

class Contacts extends AdminController
{
    protected $ContactsModel;

    public function __construct()
    {
        $this->ContactsModel = new ContactsModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title'     => trans('Contacts'),
            'active_tab'     => 'Contacts',
        ]);

        // Paginations
        $paginate = $this->ContactsModel->DataPaginations();
        $data['contacts'] =   $paginate['contacts'];
		$data['paginate'] =   $paginate;

        $data['paginations'] =  $paginate['pager']->Links('default', 'custom_pager');


        return view('admin/contacts/contacts', $data);
    }

    public function saved_contacts_post()
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
                if ($this->contactsModel->update_contacts($id)) {
                    $this->session->setFlashData('success', trans("msg_updated"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            } else {
                if ($this->contactsModel->add_contacts()) {
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

    public function delete_contacts_post()
    {
        $id = $this->request->getVar('id');

        if ($this->contactsModel->delete_contacts($id)) {
            $this->session->setFlashData('success', trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    //activate inactivate countries
    public function activate_inactivate_contacts()
    {
        $action = $this->request->getVar('action');

        $status = 1;
        if ($action == "inactivate") {
            $status = 0;
        }
        $data = array(
            'status' => $status
        );
        return $this->contactsModel->update(null, $data);
    }
}
