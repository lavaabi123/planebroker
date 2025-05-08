<?php

namespace App\Models\Locations;

use CodeIgniter\Model;

class StateModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'states';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name','code'];

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

        $paginateData = $this->select('states.*');

        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('states.name', clean_str($search))
                ->orLike('states.code', clean_str($search))
                ->groupEnd();
        }



        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'state'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }

    public function add_state()
    {
        $data = array(
            'name' => $this->request->getVar('name'),
            'code' => $this->request->getVar('code')
        );

        return $this->insert($data);
    }

    //update state
    public function update_state($id)
    {
        $data = array(
            'name' => $this->request->getVar('name'),
            'code' => $this->request->getVar('code')
        );


        return $this->update($id, $data);
    }

    //get states by county
    /*public function get_states_by_county($county_id)
    {
        return $this->asObject()->where('county_id', clean_number($county_id))->findAll();
    }*/

    //delete county
    public function delete_state($id)
    {
        $id = clean_number($id);
        $state = $this->asObject()->find($id);
        if (!empty($state)) {
            return $this->delete($state->id);
        }
        return false;
    }
}
