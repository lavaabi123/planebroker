<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'report_profiles';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['report_type'];

    // Custom 
    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
    }

    public function DataPaginations()
    {

        $show = 15;
        if ($this->request->getGet('show')) {
            $show = $this->request->getGet('show');
        }


        $paginateData = $this->select('report_profiles.*');


        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');

        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('report_profiles.report_type', clean_str($search))                
                ->groupEnd();
        }


        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'report_profiles'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }

    //delete county
    public function delete_report_profiles($id)
    {
        $id = clean_number($id);
        $county = $this->asObject()->find($id);
        if (!empty($county)) {
            return $this->delete($county->id);
        }
        return false;
    }
	
    //bulk delete county
    public function bulk_delete_report_profiles($ids)
    {		
		if($this->whereIn('id', explode(',',$ids))->delete()) {
			return TRUE;
		} else {
			return FALSE;
		}
    }
}
