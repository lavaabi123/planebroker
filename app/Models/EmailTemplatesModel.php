<?php

namespace App\Models;

use CodeIgniter\Model;

class EmailTemplatesModel extends Model
{
    protected $table            = 'email_templates';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    public $session;
    public $request;

    public function __construct()
    {
        parent::__construct();

        $this->session = session();
        $this->db = db_connect();
        $this->request = \Config\Services::request();
        $this->db->query("SET sql_mode = ''");
    }

    //input values
    public function input_values()
    {
        $data = array(
            'name' => $this->request->getVar('name'),
            'content' => $this->request->getVar('content')
        );
        return $data;
    }

    //add user
    public function add_emailtemplate()
    {

        $data = $this->input_values();

        //secure password
        $data['name'] = $this->request->getVar('name');
        $data["content"] = $this->request->getVar('content');
        $data['status'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->protect(false)->insert($data);
    }

    //edit email template
    public function edit_emailtemplate($id)
    {
        $emailtemplate = $this->get_emailtemplate($id);
        if (!empty($emailtemplate)) {
            $data = array(
                'name' => $this->request->getVar('name'),
                'content' => $this->request->getVar('content')
            );

            return $this->protect(false)->update($emailtemplate->id, $data);
        }
    }

    //ban email template
    public function ban_emailtemplate($id)
    {
        $id = clean_number($id);
        $emailtemplate = $this->get_emailtemplate($id);
        if (!empty($emailtemplate)) {

            $data = array(
                'status' => 0
            );
            return $this->protect(false)->update($emailtemplate->id, $data);
        } else {
            return false;
        }
    }

    //remove email template ban
    public function remove_emailtemplate_ban($id)
    {
        $id = clean_number($id);
        $emailtemplate = $this->get_emailtemplate($id);

        if (!empty($emailtemplate)) {

            $data = array(
                'status' => 1
            );

            return $this->protect(false)->update($emailtemplate->id, $data);
        } else {
            return false;
        }
    }

    //get email template by id
    public function get_emailtemplate($id)
    {
        $sql = "SELECT * FROM email_templates WHERE email_templates.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }

    //delete email template
    public function delete_emailtemplate($id)
    {
        $id = clean_number($id);
        $emailtemplate = $this->get_emailtemplate($id);
        if (!empty($emailtemplate)) {
            //delete email template
            return $this->where('id', $id)->delete();
        }
        return false;
    }

    public function emailtemplatePaginate()
    {
        $request = service('request');
        $show = 15;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }

        $paginateData = $this->select('email_templates.*');

        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('email_templates.name', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('email_templates.status', clean_number($status));
        }

        $result = $paginateData->paginate($show, 'default');

        return [
            'emailtemplates'  =>  $result,
            'pager'     => $this->pager,
        ];
    }

    //get paginated users
    /*public function get_paginated_admin($per_page, $offset)
    {
        $this->builder()->select('users.*, user_role.role_name as role')
            ->join('user_role', 'users.role = user_role.id')
            ->where('users.role', 1)
            ->where('users.deleted_at', null)
            ->orderBy('users.id', 'ASC');
        $this->filter_admin();

        $query = $this->builder()->get($per_page, $offset);

        return $query->getResultArray();
    }

    //get paginated users count
    public function get_paginated_admin_count()
    {
        $this->builder()->selectCount('id');
        $this->builder()->where('role', 'admin');
        $this->builder()->where('deleted_at', NULL);
        $this->filter_admin();
        $query = $this->builder()->get();
        return $query->getRow()->id;
    }

    public function filter_admin()
    {
        $request = service('request');
        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('users.username', clean_str($search))
                ->orLike('users.fullname', clean_str($search))
                ->orLike('users.email', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('users.status', clean_number($status));
        }

        $email_status = trim($request->getGet('email_status') ?? '');
        if ($email_status != null && ($email_status == 1 || $email_status == 0)) {
            $this->builder()->where('users.email_status', clean_number($email_status));
        }
    }*/
}
