<?php

namespace App\Models;

use CodeIgniter\Model;

class PlansModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'plans';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name','status'];

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


        $paginateData = $this->select('plans.*');


        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');

        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('plans.name', clean_str($search))                
                ->groupEnd();
        }

        $status = trim($this->request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('plans.status', clean_number($status));
        }

        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'plans'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }

	public function get_plans()
    {
		
         return $this->asObject()->where('status',1)->findAll();
		 //echo $this->db->getLastQuery(); die;
        
    }
	
	public function get_plans_by_id($id)
    {
		
         return $this->asObject()->where('id',$id)->find();
		 //echo $this->db->getLastQuery(); die;
        
    }
    //add county
    public function add_plans()
    {
        $data = array(
            'name' => $this->request->getVar('name'),            
            'status' => $this->request->getVar('status')
        );

        return $this->insert($data);
    }

    //update plans
    public function update_plans($id)
    {
        $data = array(
            'name' => $this->request->getVar('name'),            
            'status' => $this->request->getVar('status')
        );


        return $this->update($id, $data);
    }

    //delete plans
    public function delete_plans($id)
    {
        $id = clean_number($id);
        $plans = $this->asObject()->find($id);
        if (!empty($plans)) {
            return $this->delete($plans->id);
        }
        return false;
    }
}
