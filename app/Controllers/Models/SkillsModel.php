<?php

namespace App\Models;

use CodeIgniter\Model;

class SkillsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'categories_skills';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'category_id'];

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


        $paginateData = $this->select('categories_skills.*');


        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');

        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('categories_skills.name', clean_str($search))                
                ->groupEnd();
        }
        $this->builder()->where('categories_skills.category_id', clean_number($categoryId));

        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'skills'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }
	public function get_skills($categoryId)
    {
		
         return $this->asObject()->where('category_id',$categoryId)->findAll();
		 //echo $this->db->getLastQuery(); die;
        
    }
	public function get_skills_by_id($categoryId)
    {
		$sql = "SELECT * FROM categories_skills WHERE categories.id = ?";
        $query = $this->db->query($sql, array($categoryId));
        return $query->getRow();
        
    }
    //add county
    public function add_skills()
    {
        $data = array(
            'name' => $this->request->getVar('name'), 
            'category_id' => $this->request->getVar('category_id')
        );

        return $this->insert($data);
    }

    //update categories
    public function update_skills($id)
    {
        $data = array(
            'name' => $this->request->getVar('name'), 
            'category_id' => $this->request->getVar('category_id')
        );

        return $this->update($id, $data);
    }

    //delete categories
    public function delete_skills($id)
    {
        $id = clean_number($id);
        $skills = $this->asObject()->find($id);
        if (!empty($skills)) {
            return $this->delete($skills->id);
        }
        return false;
    }
}
