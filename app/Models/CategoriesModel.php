<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name', 'category_icon','seo_title','seo_keywords','seo_description','status'];

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


        $paginateData = $this->select('categories.*');


        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');

        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('categories.name', clean_str($search))                
                ->groupEnd();
        }

        $status = trim($this->request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('categories.status', clean_number($status));
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
		$sql = "SELECT * FROM categories WHERE categories.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->getRow();
        
    }
	public function get_categories_link($id)
    {
		$sql = "SELECT * FROM categories WHERE categories.permalink = ?";
        $query = $this->db->query($sql, array($id));
        return $query->getRow();
        
    }
    //add county
    public function add_categories($img_name = '')
    {
        $data = array(
            'name' => $this->request->getVar('name'), 
            'rate_type' => $this->request->getVar('rate_type'), 
            'skill_name' => $this->request->getVar('skill_name'), 
            'in_house' => $this->request->getVar('in_house'), 
            'seo_title' => $this->request->getVar('seo_title'), 
            'seo_keywords' => $this->request->getVar('seo_keywords'), 
            'seo_description' => $this->request->getVar('seo_description'),
			'category_icon' => $img_name
        );

        return $this->insert($data);
    }

    //update categories
    public function update_categories($id,$img_name='')
    {
        $data = array(
            'name' => $this->request->getVar('name'), 
            'rate_type' => $this->request->getVar('rate_type'), 
            'skill_name' => $this->request->getVar('skill_name'), 
            'in_house' => $this->request->getVar('in_house'), 
            'seo_title' => $this->request->getVar('seo_title'), 
            'seo_keywords' => $this->request->getVar('seo_keywords'), 
            'seo_description' => $this->request->getVar('seo_description'),       
            'status' => $this->request->getVar('status'),
			'category_icon' => $img_name
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
