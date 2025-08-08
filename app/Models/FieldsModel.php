<?php

namespace App\Models;

use CodeIgniter\Model;

class FieldsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'fields';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name', 'rate_type','skill_name','in_house','seo_title','seo_keywords','seo_description','status','field_type','field_order','field_position','field_options','is_filter','filter_order','filter_type'];

    // Custom 
    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
    }

    public function DataPaginations($orderby = 'field_order')
    {

        $show = 15;
        if ($this->request->getGet('show')) {
            $show = $this->request->getGet('show');
        }


        $paginateData = $this->select('fields.*, categories.id as category_id,
			GROUP_CONCAT(DISTINCT field_categories.category_id) AS category_ids,
			GROUP_CONCAT(DISTINCT categories.name) AS category_names,
			GROUP_CONCAT(DISTINCT field_sub_categories.sub_category_id) AS subcategory_ids,
			GROUP_CONCAT(DISTINCT categories_sub.name) AS subcategory_names');
			$this->builder->select("GROUP_CONCAT(DISTINCT CONCAT(fields_group.name, ' (', c.name, ')')) AS group_names", false);

		$this->builder->join('field_categories', 'field_categories.field_id = fields.id', 'left');
		$this->builder->join('categories', 'categories.id = field_categories.category_id', 'left');
		$this->builder->join('field_sub_categories', 'field_sub_categories.field_id = fields.id', 'left');
		$this->builder->join('categories_sub', 'categories_sub.id = field_sub_categories.sub_category_id', 'left');
		$this->builder->join('field_groups', 'field_groups.field_id = fields.id', 'left');
		$this->builder->join('fields_group', 'fields_group.id = field_groups.fields_group_id', 'left');
		$this->builder->join('categories c', 'c.id = fields_group.category_id', 'left');


        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');

        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('fields.name', clean_str($search)) 
                ->orlike('categories.name', clean_str($search)) 
                ->orlike('categories_sub.name', clean_str($search))               
                ->groupEnd();
        }

        $status = trim($this->request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('fields.status', clean_number($status));
        }
		
        $category_id = trim($this->request->getGet('category_id') ?? '');
        if ($category_id != null && $category_id != '') {
            $this->builder()->where('categories.id', clean_number($category_id));
        }		
		
        $field_group = trim($this->request->getGet('field_group') ?? '');
        if ($field_group != null && $field_group != '') {
            $this->builder()->where('fields_group.id', clean_number($field_group));
        }
		
		$this->builder()->groupby('fields.id');
		$this->builder()->orderby('categories.id,fields.'.$orderby);
        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'fields'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }
    public function field_lists($orderby = 'field_order')
    {
       
        $paginateData = $this->select('fields.*, categories.id as category_id,
			GROUP_CONCAT(DISTINCT field_categories.category_id) AS category_ids,
			GROUP_CONCAT(DISTINCT categories.name) AS category_names,
			GROUP_CONCAT(DISTINCT field_sub_categories.sub_category_id) AS subcategory_ids,
			GROUP_CONCAT(DISTINCT categories_sub.name) AS subcategory_names');
			$this->builder->select("GROUP_CONCAT(DISTINCT CONCAT(fields_group.name, ' (', c.name, ')')) AS group_names", false);

		$this->builder->join('field_categories', 'field_categories.field_id = fields.id', 'left');
		$this->builder->join('categories', 'categories.id = field_categories.category_id', 'left');
		$this->builder->join('field_sub_categories', 'field_sub_categories.field_id = fields.id', 'left');
		$this->builder->join('categories_sub', 'categories_sub.id = field_sub_categories.sub_category_id', 'left');
		$this->builder->join('field_groups', 'field_groups.field_id = fields.id', 'left');
		$this->builder->join('fields_group', 'fields_group.id = field_groups.fields_group_id', 'left');
		$this->builder->join('categories c', 'c.id = fields_group.category_id', 'left');


		$this->builder()->groupby('fields.id');
		$this->builder()->orderby('categories.id,fields.'.$orderby);
        
		$query = $this->builder()->get();
		return $query->getResult();

    }
	public function get_fields($category_id=1)
    {
		$db = \Config\Database::connect();

		$builder = $db->table('fields');
		
		/*$builder->select('fields.*, 
			GROUP_CONCAT(DISTINCT field_categories.category_id) AS category_ids, 
			GROUP_CONCAT(DISTINCT field_sub_categories.sub_category_id) AS subcategory_ids, 
			GROUP_CONCAT(DISTINCT field_groups.fields_group_id) AS fields_group_ids');
		$builder->join('field_categories', 'field_categories.field_id = fields.id', 'left');
		$builder->join('field_sub_categories', 'field_sub_categories.field_id = fields.id', 'left');
		$builder->join('field_groups', 'field_groups.field_id = fields.id', 'left');
		$builder->where('fields.status', 1);
		$builder->groupBy('fields.id');*/
		
		
		$builder->select('fields.*,field_categories.category_id,categories.name AS category_name,field_sub_categories.sub_category_id,
		categories_sub.name AS subcategory_name,fields_group.name AS group_name,GROUP_CONCAT(DISTINCT field_categories.category_id) AS category_ids,GROUP_CONCAT(DISTINCT field_sub_categories.sub_category_id) AS subcategory_ids', false);

		$builder->join('field_categories', 'field_categories.field_id = fields.id', 'left');
		$builder->join('categories', 'categories.id = field_categories.category_id', 'left');
		$builder->join('field_sub_categories', 'field_sub_categories.field_id = fields.id', 'left');
		$builder->join('categories_sub', 'categories_sub.id = field_sub_categories.sub_category_id', 'left');
		$builder->join('field_groups', 'field_groups.field_id = fields.id', 'left');
		$builder->join('fields_group', 'fields_group.id = field_groups.fields_group_id', 'left');

		// WHERE conditions
		$builder->where('categories.id', $category_id);
		//$builder->where('categories_sub.id', 1);
		$builder->where('fields_group.name IS NOT NULL', null, false); // Raw condition for IS NOT NULL

		// GROUP BY fields.id
		$builder->groupBy('fields.id');

		// ORDER BY group name and field name
		//$builder->orderBy('fields_group.name');
		$builder->orderBy('fields.field_order');

		$query = $builder->get();
		$results = $query->getResult();
		
		$groupedFields = [];

		// Step 1: Group the fields by group name
		foreach ($results as $row) {
			$group = $row->group_name ?? 'Ungrouped'; // Fallback for NULL group name
			$groupedFields[$group][] = $row;
		}
		return $groupedFields;
         //return $this->asObject()->where('status',1)->findAll();
		 echo $this->db->getLastQuery(); die;
        
    }
	public function get_fields_by_id($id)
    {
		$sql = "SELECT * FROM fields WHERE fields.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->getRow();
        
    }
    //add fields
    public function add_fields()
    {
        $data = array(
            'name' => $this->request->getVar('name'), 
            'field_type' => $this->request->getVar('field_type'), 
            'field_position' => $this->request->getVar('field_position'), 
            'field_order' => $this->request->getVar('field_order'), 
            'field_options' => ($this->request->getVar('field_options') != null && count($this->request->getVar('field_options')) > 0) ? json_encode($this->request->getVar('field_options')) : '',
			'status' => $this->request->getVar('status')
        );
        $inserted_id = $this->insert($data);
	    if(!empty($inserted_id)){
			if(!empty($this->request->getVar('category_id'))){
				$builder = $this->db->table('field_categories');
				foreach($this->request->getVar('category_id') as $row){
					$builder->insert([
					   'field_id' => $inserted_id,
					   'category_id' => $row
					]);			   
				}
			}
			if(!empty($this->request->getVar('sub_category_id'))){
				$builder = $this->db->table('field_sub_categories');
				foreach($this->request->getVar('sub_category_id') as $row){
					$builder->insert([
					   'field_id' => $inserted_id,
					   'sub_category_id' => $row
					]);
				}   
			}
			if(!empty($this->request->getVar('fields_group_id'))){
				$builder = $this->db->table('field_groups');
				foreach($this->request->getVar('fields_group_id') as $row){
					$builder->insert([
					   'field_id' => $inserted_id,
					   'fields_group_id' => $row
					]);
				}   
			}
		}
		return $inserted_id;
		
    }

	public function update_filter($id){
		$data = array(
            'is_filter' => $this->request->getVar('is_filter'),
            'filter_type' => $this->request->getVar('filter_type')
        );
		return $this->update($id, $data);
	}
    //update fields
    public function update_fields($id)
    {
        $data = array(
            'name' => $this->request->getVar('name'), 
            'field_type' => $this->request->getVar('field_type'), 
            'field_position' => $this->request->getVar('field_position'), 
            'field_order' => $this->request->getVar('field_order'),  
            'field_options' => ($this->request->getVar('field_options') != null && count($this->request->getVar('field_options')) > 0) ? json_encode($this->request->getVar('field_options')) : '',
            'status' => $this->request->getVar('status')
        );
		if(!empty($id)){
			$this->db->table('field_categories')->where('field_id', $id)->delete();
			if(!empty($this->request->getVar('category_id'))){
				$builder = $this->db->table('field_categories');
				foreach($this->request->getVar('category_id') as $row){
					$builder->insert([
					   'field_id' => $id,
					   'category_id' => $row
					]);			   
				}
			}
			$this->db->table('field_sub_categories')->where('field_id', $id)->delete();
			if(!empty($this->request->getVar('sub_category_id'))){
				$builder = $this->db->table('field_sub_categories');
				foreach($this->request->getVar('sub_category_id') as $row){
					$builder->insert([
					   'field_id' => $id,
					   'sub_category_id' => $row
					]);
				}   
			}
			$this->db->table('field_groups')->where('field_id', $id)->delete();
			if(!empty($this->request->getVar('fields_group_id'))){
				$builder = $this->db->table('field_groups');
				foreach($this->request->getVar('fields_group_id') as $row){
					$builder->insert([
					   'field_id' => $id,
					   'fields_group_id' => $row
					]);
				}   
			}
		}


        return $this->update($id, $data);
    }

    //delete fields
    public function delete_fields($id)
    {
        $id = clean_number($id);
        $fields = $this->asObject()->find($id);
        if (!empty($fields)) {
			$this->db->table('field_categories')->where('field_id',$id)->delete();
			$this->db->table('field_groups')->where('field_id',$id)->delete();
			$this->db->table('field_sub_categories')->where('field_id',$id)->delete();
			$this->db->table('products_dynamic_fields')->where('field_id',$id)->delete();
			$this->db->table('title_fields')->where('field_id',$id)->delete();
			
			$products = $this->db->table('products')->get()->getResult();
			foreach ($products as $product) {
				$dynamicFields = json_decode($product->dynamic_fields, true);

				if (isset($dynamicFields[$id])) {
					unset($dynamicFields[$id]);

					$this->db->table('products')->where('id', $product->id)->update([
						'dynamic_fields' => json_encode($dynamicFields)
					]);
				}
			}
			
			
            return $this->db->table('fields')->where('id',$id)->delete();
        }
        return false;
    }
}
