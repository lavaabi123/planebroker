<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoModel extends Model
{
    protected $table            = 'videos';
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
            'video_url' => $this->request->getVar('video_url')
        );
        return $data;
    }

    //add user
    public function add_video()
    {

        $data = $this->input_values();

        //secure password
        $data['name'] = $this->request->getVar('name');
        $data["video_url"] = $this->request->getVar('video_url');
        $data['status'] = $this->request->getVar('status');
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->protect(false)->insert($data);
    }

    //edit email template
    public function edit_video($id)
    {
        $video = $this->get_video_by_id($id);
        if (!empty($video)) {
            $data = array(
                'name' => $this->request->getVar('name'),
                'video_url' => $this->request->getVar('video_url'),
                'status' => $this->request->getVar('status')
            );

            return $this->protect(false)->update($video->id, $data);
        }
    }

    //ban email template
    public function ban_video($id)
    {
        $id = clean_number($id);
        $video = $this->get_video_by_id($id);
        if (!empty($video)) {

            $data = array(
                'status' => 0
            );
            return $this->protect(false)->update($video->id, $data);
        } else {
            return false;
        }
    }

    //remove email template ban
    public function remove_video_ban($id)
    {
        $id = clean_number($id);
        $video = $this->get_video_by_id($id);

        if (!empty($video)) {

            $data = array(
                'status' => 1
            );

            return $this->protect(false)->update($video->id, $data);
        } else {
            return false;
        }
    }

    //get email template by id
    public function get_video($clean_url)
    {
        $sql = "SELECT * FROM videos WHERE videos.clean_url = ?";
        $query = $this->db->query($sql, array($clean_url));
        return $query->getRow();
    }
    public function get_video_by_id($id)
    {
        $sql = "SELECT * FROM videos WHERE videos.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }
    public function get_all_video()
    {
        $sql = "SELECT * FROM videos WHERE status = 1 AND deleted_at IS NULL";
        $query = $this->db->query($sql);
        return $query->getResult();
    }

    //delete email template
    public function delete_video($id)
    {
        $id = clean_number($id);
        $video = $this->get_video_by_id($id);
        if (!empty($video)) {
            //delete email template
            return $this->where('id', $id)->delete();
        }
        return false;
    }

    public function videoPaginate()
    {
        $request = service('request');
        $show = 15;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }

        $paginateData = $this->select('videos.*');

        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('videos.name', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 2)) {
            $this->builder()->where('videos.status', clean_number($status));
        }

        $result = $paginateData->paginate($show, 'default');

        return [
            'video'  =>  $result,
            'pager'     => $this->pager,
        ];
    }
}
