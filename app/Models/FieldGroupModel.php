<?php

namespace App\Models;

use CodeIgniter\Model;

class FieldGroupModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'fields_group';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name', 'category_id','sort_order'];

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

        $show = 10;
        if ($this->request->getGet('show')) {
            $show = $this->request->getGet('show');
        }


        $paginateData = $this->select('fields_group.*');


        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');

        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('fields_group.name', clean_str($search))                
                ->groupEnd();
        }
		$this->builder()->where('fields_group.category_id', clean_number($categoryId));
        $status = trim($this->request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('fields_group.status', clean_number($status));
        }
		$this->builder()->orderby('sort_order','asc');
        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'fields_group'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }

	public function get_fields_group()
    {
		
         return $this->asObject()->where('status',1)->orderby('sort_order','asc')->findAll();
		 //echo $this->db->getLastQuery(); die;
        
    }
	public function get_fields_group_by_ids($ids)
    {
		$ids = is_array($ids) ? $ids : explode(',',$ids) ;
		$sql = "SELECT fields_group.*,categories.name as category_name FROM fields_group LEFT JOIN categories ON categories.id = fields_group.category_id WHERE fields_group.category_id IN ?";
        $query = $this->db->query($sql, array($ids));
        return $query->getResult();
        
    }
	public function get_fields_group_category_based($category_id)
    {
		
         return $this->asObject()->where('category_id',$category_id)->orderby('sort_order','asc')->where('status',1)->findAll();
		 //echo $this->db->getLastQuery(); die;
        
    }
    //add county
    public function add_fields_group()
    {
        $data = array(
            'name' => $this->request->getVar('name'), 
            'category_id' => $this->request->getVar('category_id')
        );
        //return 
		if ($this->insert($data)) {
			$insertID = $this->getInsertID();
			// Count total rows after insert
			$totalRows = $this->where('category_id', $this->request->getVar('category_id'))->countAllResults();

			// Now update sort_order = total number of rows
			$this->update($insertID, ['sort_order' => $totalRows]);
			return true;
		} else {
			return false;
		}
    }

    //update fields_group
    public function update_fields_group($id)
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
        // return $this->db->where('continent_code', clean_str($continent_code))->orderby('name')->get('location_countries')->result();
    }

    //delete fields_group
    public function delete_fields_group($id)
    {
        $id = clean_number($id);
        $fields_group = $this->asObject()->find($id);
        if (!empty($fields_group)) {
            return $this->delete($fields_group->id);
        }
        return false;
    }
}
