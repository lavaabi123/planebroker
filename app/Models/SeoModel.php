<?php

namespace App\Models;

use CodeIgniter\Model;

class SeoModel extends Model
{
    protected $table            = 'web_seo';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

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
            'page_name' => $this->request->getVar('page_name'),
            'meta_title' => $this->request->getVar('meta_title'),
            'meta_description' => $this->request->getVar('meta_description'),
            'meta_keywords' => $this->request->getVar('meta_keywords'),
        );
        return $data;
    }

    public function add_seo($img_name)
    {

        $data = $this->input_values();

        $data['page_name'] = $this->request->getVar('page_name');
        $data['meta_title'] = $this->request->getVar('meta_title');
        $data["meta_description"] = $this->request->getVar('meta_description');
        $data['meta_keywords'] = $this->request->getVar('meta_keywords');
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->protect(false)->insert($data);
    }

    public function edit_seo($id,$img_name)
    {
        $seo = $this->get_seo_by_id($id);
        if (!empty($seo)) {
            $data = array(
                'page_name' => $this->request->getVar('page_name'),
				'meta_title' => $this->request->getVar('meta_title'),
				'meta_description' => $this->request->getVar('meta_description'),
				'meta_keywords' => $this->request->getVar('meta_keywords'),
            );

            return $this->protect(false)->update($seo->id, $data);
        }
    }

    public function ban_seo($id)
    {
        $id = clean_number($id);
        $seo = $this->get_seo_by_id($id);
        if (!empty($seo)) {

            $data = array(
                'status' => 0
            );
            return $this->protect(false)->update($seo->id, $data);
        } else {
            return false;
        }
    }

    //remove email template ban
    public function remove_seo_ban($id)
    {
        $id = clean_number($id);
        $seo = $this->get_seo_by_id($id);

        if (!empty($seo)) {

            $data = array(
                'status' => 1
            );

            return $this->protect(false)->update($seo->id, $data);
        } else {
            return false;
        }
    }

    public function get_seo_by_id($id)
    {
        $sql = "SELECT * FROM web_seo WHERE web_seo.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }
	
    public function get_all_seo()
    {
        $sql = "SELECT * FROM web_seo WHERE deleted_at IS NULL";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function delete_seo($id)
    {
        $id = clean_number($id);
        $seo = $this->get_seo_by_id($id);
        if (!empty($seo)) {
            return $this->where('id', $id)->delete();
        }
        return false;
    }

    public function seoPaginate()
    {
        $request = service('request');
        $show = 15;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }

        $paginateData = $this->select('web_seo.*');

        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('web_seo.page_name', clean_str($search))
                ->orlike('web_seo.meta_title', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 2)) {
            $this->builder()->where('web_seo.status', clean_number($status));
        }

        $result = $paginateData->paginate($show, 'default');

        return [
            'seo'  =>  $result,
            'pager'     => $this->pager,
        ];
    }
}
