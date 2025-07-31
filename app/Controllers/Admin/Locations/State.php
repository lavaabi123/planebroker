<?php

namespace App\Controllers\Admin\Locations;

use App\Controllers\Admin\AdminController;
use App\Models\Locations\CityModel;
use App\Models\Locations\StateModel;

class State extends AdminController
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
    protected $stateModel;
    protected $cityModel;

    public function __construct()
    {
        $this->stateModel = new StateModel();
        $this->cityModel = new CityModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title'     => trans('state'),
            'active_tab'     => 'state',
        ]);

        // Paginations
        $paginate = $this->stateModel->DataPaginations();
        $data['state'] =   $paginate['state'];

        $data['paginations'] =  $paginate['pager']->Links('default', 'custom_pager');

        return view('admin/locations/state', $data);
    }

    public function saved_state_post()
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
            'code' => [
                'label'  => trans('code'),
                'rules'  => 'required|max_length[2]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $id = $this->request->getVar('id');
            if (!empty($id)) {
                if ($this->stateModel->update_state($id)) {
                    $this->session->setFlashData('success', trans("msg_updated"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            } else {
                if ($this->stateModel->add_state()) {
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

    public function delete_state_post()
    {
        $id = $this->request->getVar('id');

        if (count($this->cityModel->get_cities_by_state($id)) > 0) {
            $this->session->setFlashData('error', trans("msg_error_row"));
        } else {
            if ($this->cityModel->delete_city($id)) {
                $this->session->setFlashData('success', trans("msg_suc_deleted"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }
    }
}
