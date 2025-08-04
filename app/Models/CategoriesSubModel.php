<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesSubModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'categories_sub';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name','category_id','status','seo_title','seo_keywords','seo_description'];

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


        $paginateData = $this->select('categories_sub.*,categories.name as category_name')->join('categories', 'categories_sub.category_id = categories.id','left');


        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');

        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('categories_sub.name', clean_str($search))                
                ->groupEnd();
        }

        $status = trim($this->request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('categories_sub.status', clean_number($status));
        }
        $category_id = trim($this->request->getGet('category_id') ?? '');
        if ($category_id != null && ($category_id >= 1)) {
            $this->builder()->where('categories_sub.category_id', clean_number($category_id));
        }

        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'categories'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }
	
	public function get_categories()
    {
		
         return $this->asObject()->where('status',1)->findAll();
		 //echo $this->db->getLastQuery(); die;
        
    }
	public function get_categories_by_id($id)
    {
		$sql = "SELECT * FROM categories_sub WHERE categories_sub.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->getRow();
        
    }
	public function get_categories_by_ids($ids)
    {
		$ids = is_array($ids) ? $ids : explode(',',$ids) ;
		$sql = "SELECT categories_sub.*,categories.name as category_name FROM categories_sub LEFT JOIN categories ON categories.id = categories_sub.category_id WHERE categories_sub.category_id IN ?";
        $query = $this->db->query($sql, array($ids));
        return $query->getResult();
        
    }
	
	public function get_categories_by_link($link,$where=''){
		$sql = "
			SELECT 
				categories_sub.*, 
				categories.name AS category_name,
				categories.permalink,
				(
					SELECT COUNT(*) 
					FROM products p 
					WHERE p.sub_category_id = categories_sub.id 
					  AND p.status = 1
				) AS product_count
			FROM categories_sub
			LEFT JOIN categories ON categories.id = categories_sub.category_id
			WHERE categories_sub.category_id IN (
				SELECT id FROM categories WHERE permalink = ?
			) {$where}
		";

		$query = $this->db->query($sql, array($link));
		return $query->getResult();

	}
    //add county
    public function add_categories()
    {
        $data = array(
            'name' => $this->request->getVar('name'), 
            'category_id' => $this->request->getVar('category_id'), 
            'seo_title' => $this->request->getVar('seo_title'), 
            'seo_keywords' => $this->request->getVar('seo_keywords'), 
            'seo_description' => $this->request->getVar('seo_description'),
            'status' => $this->request->getVar('status'),
        );

        return $this->insert($data);
    }

    //update categories
    public function update_categories($id)
    {
        $data = array(
            'name' => $this->request->getVar('name'), 
            'category_id' => $this->request->getVar('category_id'),
            'seo_title' => $this->request->getVar('seo_title'), 
            'seo_keywords' => $this->request->getVar('seo_keywords'), 
            'seo_description' => $this->request->getVar('seo_description'),       
            'status' => $this->request->getVar('status')
        );


        return $this->update($id, $data);
    }

    //delete categories
    public function delete_categories($id)
    {
        $id = clean_number($id);
        $categories = $this->asObject()->find($id);
        if (!empty($categories)) {
            return $this->delete($categories->id);
        }
        return false;
    }
}
