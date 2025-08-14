<?php

namespace App\Models;

use CodeIgniter\Model;

class AdModel extends Model
{
    protected $table            = 'ads';
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
    public function add_ad($img_name)
    {
        $data['ad_link'] = $this->request->getVar('ad_link');
		$data['image'] = $img_name;
        $data["page_name"] = $this->request->getVar('page_name');
        $data['page_position'] = $this->request->getVar('page_position');
        $data['status'] = $this->request->getVar('status');
        $data['start_date'] = $this->request->getVar('start_date');
        $data['end_date'] = $this->request->getVar('end_date');
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->protect(false)->insert($data);
    }

    //edit email template
    public function edit_ad($id,$img_name)
    {
        $ad = $this->get_ad_by_id($id);
        if (!empty($ad)) {
            $data['ad_link'] = $this->request->getVar('ad_link');
			$data['image'] = $img_name;
			$data["page_name"] = $this->request->getVar('page_name');
			$data['page_position'] = $this->request->getVar('page_position');
			$data['status'] = $this->request->getVar('status');
			$data['start_date'] = $this->request->getVar('start_date');
			$data['end_date'] = $this->request->getVar('end_date');
			$data['created_at'] = date('Y-m-d H:i:s');

            return $this->protect(false)->update($ad->id, $data);
        }
    }

    //ban email template
    public function ban_ad($id)
    {
        $id = clean_number($id);
        $ad = $this->get_ad_by_id($id);
        if (!empty($ad)) {

            $data = array(
                'status' => 0
            );
            return $this->protect(false)->update($ad->id, $data);
        } else {
            return false;
        }
    }

    //remove email template ban
    public function remove_ad_ban($id)
    {
        $id = clean_number($id);
        $ad = $this->get_ad_by_id($id);

        if (!empty($ad)) {

            $data = array(
                'status' => 1
            );

            return $this->protect(false)->update($ad->id, $data);
        } else {
            return false;
        }
    }

    //get email template by id
    public function get_ad($clean_url)
    {
        $sql = "SELECT * FROM ads WHERE ads.clean_url = ?";
        $query = $this->db->query($sql, array($clean_url));
        return $query->getRow();
    }
    public function get_ad_by_id($id)
    {
        $sql = "SELECT * FROM ads WHERE ads.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }
    public function get_all_ad($cat='')
    {
        if($cat==''){
            $sql = "SELECT * FROM ads WHERE status = 1 AND deleted_at IS NULL";
        }else{
            $sql = "SELECT * FROM ads WHERE category=".$cat." AND status = 1 AND deleted_at IS NULL";
        }
        
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    //delete email template
    public function delete_ad($id)
    {
        $id = clean_number($id);
        $ad = $this->get_ad_by_id($id);
        if (!empty($ad)) {
            //delete email template
            return $this->where('id', $id)->delete();
        }
        return false;
    }

    public function adPaginate()
    {
        $request = service('request');
        $show = 15;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }

        $paginateData = $this->select('ads.*');

        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('ads.name', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 2)) {
            $this->builder()->where('ads.status', clean_number($status));
        }
        $category = trim($request->getGet('category') ?? '');
        if ($category != null && ($category == 1 || $category == 0)) {
            $this->builder()->where('ads.category', clean_number($category));
        }

        $result = $paginateData->paginate($show, 'default');

        return [
            'ad'  =>  $result,
            'pager'     => $this->pager,
        ];
    }
	
    public function ads_list()
    {

        $sql = "SELECT * FROM ads WHERE deleted_at IS NULL";
        
        $query = $this->db->query($sql);
        return $query->getResultArray();

    }
}
