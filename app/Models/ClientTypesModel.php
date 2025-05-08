<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientTypesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'client_types';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name', 'status'];

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


        $paginateData = $this->select('client_types.*');


        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');

        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('client_types.name', clean_str($search))                
                ->groupEnd();
        }

        $status = trim($this->request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('client_types.status', clean_number($status));
        }

        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'client_types'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }

	public function get_client_types()
    {
		
         return $this->asObject()->where('status',1)->findAll();
		 //echo $this->db->getLastQuery(); die;
        
    }
    //add county
    public function add_client_types()
    {
        $data = array(
            'name' => $this->request->getVar('name'),            
            'status' => $this->request->getVar('status')
        );

        return $this->insert($data);
    }

    //update offering
    public function update_client_types($id)
    {
        $data = array(
            'name' => $this->request->getVar('name'),            
            'status' => $this->request->getVar('status')
        );


        return $this->update($id, $data);
    }

    //get countries by continent
    public function get_countries_by_continent($continent_code)
    {
        return $this->asObject()->where('continent_code', clean_str($continent_code))->findAll();
        // return $this->db->where('continent_code', clean_str($continent_code))->order_by('name')->get('location_countries')->result();
    }

    //delete offering
    public function delete_client_types($id)
    {
        $id = clean_number($id);
        $offering = $this->asObject()->find($id);
        if (!empty($offering)) {
            return $this->delete($offering->id);
        }
        return false;
    }
}
