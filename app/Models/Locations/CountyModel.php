<?php

namespace App\Models\Locations;

use CodeIgniter\Model;

class CountyModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'county';
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


        $paginateData = $this->select('county.*');


        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');

        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('county.name', clean_str($search))                
                ->groupEnd();
        }

        $status = trim($this->request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('county.status', clean_number($status));
        }

        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'county'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }

    //add county
    public function add_county()
    {
        $data = array(
            'name' => $this->request->getVar('name'),            
            'status' => $this->request->getVar('status')
        );

        return $this->insert($data);
    }

    //update county
    public function update_county($id)
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

    //delete county
    public function delete_county($id)
    {
        $id = clean_number($id);
        $county = $this->asObject()->find($id);
        if (!empty($county)) {
            return $this->delete($county->id);
        }
        return false;
    }
	
    //bulk delete county
    public function bulk_delete_county($ids)
    {		
		if($this->whereIn('id', explode(',',$ids))->delete()) {
			return TRUE;
		} else {
			return FALSE;
		}
    }
}
