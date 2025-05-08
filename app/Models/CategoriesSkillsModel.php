<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesSkillsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'categories_skills';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name'];

    // Custom 
    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
    }
	
	public function get_categories_skills_by_category_id($category_id)
    {
		
         return $this->asObject()->where('category_id',$category_id)->orderBy('name', 'asc')->findAll();
		 //echo $this->db->getLastQuery(); die;
        
    }
}
