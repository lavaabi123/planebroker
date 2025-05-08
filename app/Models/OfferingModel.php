<?php

namespace App\Models;

use CodeIgniter\Model;

class OfferingModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'offering';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name', 'category_id'];

    // Custom 
    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
    }

    public function DataPaginations($categoryId)
    {

        $show = 15;
        if ($this->request->getGet('show')) {
            $show = $this->request->getGet('show');
        }


        $paginateData = $this->select('offering.*');


        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');

        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('offering.name', clean_str($search))                
                ->groupEnd();
        }
		$this->builder()->where('offering.category_id', clean_number($categoryId));
        $status = trim($this->request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('offering.status', clean_number($status));
        }

        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'offering'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }

	public function get_offering()
    {
		
         return $this->asObject()->where('status',1)->findAll();
		 //echo $this->db->getLastQuery(); die;
        
    }
	public function get_offering_category_based($category_id)
    {
		
         return $this->asObject()->where('category_id',$category_id)->where('status',1)->findAll();
		 //echo $this->db->getLastQuery(); die;
        
    }
    //add county
    public function add_offering()
    {
        $data = array(
            'name' => $this->request->getVar('name'), 
            'category_id' => $this->request->getVar('category_id')
        );
        //return 
		$this->insert($data);
    }

    //update offering
    public function update_offering($id)
    {
        $data = array(
            'name' => $this->request->getVar('name'), 
            'category_id' => $this->request->getVar('category_id')
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
    public function delete_offering($id)
    {
        $id = clean_number($id);
        $offering = $this->asObject()->find($id);
        if (!empty($offering)) {
            return $this->delete($offering->id);
        }
        return false;
    }
}
