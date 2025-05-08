<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'contacts';
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

    public function DataPaginations()
    {

        $show = 15;
        if ($this->request->getGet('show')) {
            $show = $this->request->getGet('show');
        }


        $paginateData = $this->select('contacts.*');


        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');

        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('contacts.from_name', clean_str($search))   
                ->orLike('contacts.from_email', clean_str($search))              
                ->groupEnd();
        }

        $status = trim($this->request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('contacts.status', clean_number($status));
        }
		$this->builder()->orderBy('created_at','DESC');
        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'contacts'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
			'per_page_no' => $show,
			'total' => $this->pager->gettotal()
        ];
    }

	public function get_contacts()
    {
		
         return $this->asObject()->where('status',1)->findAll();
		 //echo $this->db->getLastQuery(); die;
        
    }
    //add county
    public function add_contacts()
    {
        $data = array(
            'name' => $this->request->getVar('name'),            
            'status' => $this->request->getVar('status')
        );

        return $this->insert($data);
    }

    //update contacts
    public function update_contacts($id)
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

    //delete contacts
    public function delete_contacts($id)
    {
        $id = clean_number($id);
        $contacts = $this->asObject()->find($id);
        if (!empty($contacts)) {
            return $this->delete($contacts->id);
        }
        return false;
    }
}
