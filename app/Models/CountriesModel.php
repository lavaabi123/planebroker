<?php

namespace App\Models;

use CodeIgniter\Model;

class CountriesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'countries';
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

    public function get_list()
    {
		return $this->asObject()->orderBy('sort_order','ASC')->findAll();
    }
    public function get_states_list($id)
    {
		$sql = "SELECT * FROM states WHERE country_id = ? order by name asc";
        $query = $this->db->query($sql, array($id));
        return $query->getResult();
    }

}
