<?php

namespace App\Controllers\Admin\Locations;

use App\Controllers\Admin\AdminController;
use App\Models\Locations\CountyModel;
use App\Models\Locations\StateModel;

class County extends AdminController
{
    protected $countyModel;

    public function __construct()
    {
        $this->countyModel = new CountyModel();
        $this->stateModel = new StateModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title'     => trans('county'),
            'active_tab'     => 'county',
        ]);

        // Paginations
        $paginate = $this->countyModel->DataPaginations();
        $data['county'] =   $paginate['county'];

        $data['paginations'] =  $paginate['pager']->Links('default', 'custom_pager');


        return view('admin/locations/county', $data);
    }

    public function saved_county_post()
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
                if ($this->countyModel->update_county($id)) {
                    $this->session->setFlashData('success', trans("msg_updated"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            } else {
                if ($this->countyModel->add_county()) {
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

    public function delete_county_post()
    {
        $id = $this->request->getVar('id');

        /*if (count($this->stateModel->get_states_by_county($id)) > 0) {
            $this->session->setFlashData('error', trans("msg_error_row"));
        } else {*/
            if ($this->countyModel->delete_county($id)) {
                $this->session->setFlashData('success', trans("msg_suc_deleted"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        //}
    }
	
    public function bulk_delete_county_post()
    {
		
        $ids = $this->request->getVar('ids');

		if ($this->countyModel->bulk_delete_county($ids)) {
			echo "1";
		} else {
			echo "2";
		}
    }

    //activate inactivate countries
    public function activate_inactivate_countries()
    {
        $action = $this->request->getVar('action');

        $status = 1;
        if ($action == "inactivate") {
            $status = 0;
        }
        $data = array(
            'status' => $status
        );
        return $this->countyModel->update(null, $data);
    }
}
