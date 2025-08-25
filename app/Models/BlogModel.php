<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table            = 'blogs';
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
    public function add_blog($img_name)
    {

        $data = $this->input_values();

        //secure password
        $data['name'] = $this->request->getVar('name');
        $data['clean_url'] = cleanURL(str_replace(' ','-',strtolower($this->request->getVar('name'))));
        $data["content"] = $this->request->getVar('content');
        $data['category'] = $this->request->getVar('category');
        $data['status'] = $this->request->getVar('status');
		$data['image'] = $img_name;
        $data['created_at'] = date('Y-m-d H:i:s');
		$data['seo_title'] = $this->request->getVar('seo_title');
		$data['seo_keywords'] = $this->request->getVar('seo_keywords'); 
		$data['seo_description'] = $this->request->getVar('seo_description');

        return $this->protect(false)->insert($data);
    }

    //edit email template
    public function edit_blog($id,$img_name)
    {
        $blog = $this->get_blog_by_id($id);
        if (!empty($blog)) {
            $data = array(
                'name' => $this->request->getVar('name'),
				'clean_url' => cleanURL(str_replace(' ','-',strtolower($this->request->getVar('name')))),
                'content' => $this->request->getVar('content'),
                'category' => $this->request->getVar('category'),
                'status' => $this->request->getVar('status'),
                'image' => $img_name,
				'seo_title' => $this->request->getVar('seo_title'), 
				'seo_keywords' => $this->request->getVar('seo_keywords'), 
				'seo_description' => $this->request->getVar('seo_description'),
            );

            return $this->protect(false)->update($blog->id, $data);
        }
    }

    //ban email template
    public function ban_blog($id)
    {
        $id = clean_number($id);
        $blog = $this->get_blog_by_id($id);
        if (!empty($blog)) {

            $data = array(
                'status' => 0
            );
            return $this->protect(false)->update($blog->id, $data);
        } else {
            return false;
        }
    }

    //remove email template ban
    public function remove_blog_ban($id)
    {
        $id = clean_number($id);
        $blog = $this->get_blog_by_id($id);

        if (!empty($blog)) {

            $data = array(
                'status' => 1
            );

            return $this->protect(false)->update($blog->id, $data);
        } else {
            return false;
        }
    }

    //get email template by id
    public function get_blog($clean_url)
    {
        $sql = "SELECT * FROM blogs WHERE blogs.clean_url = ?";
        $query = $this->db->query($sql, array($clean_url));
        return $query->getRow();
    }
    public function get_blog_by_id($id)
    {
        $sql = "SELECT * FROM blogs WHERE blogs.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }
    public function get_all_blog($cat='')
    {
        if($cat==''){
            $sql = "SELECT * FROM blogs WHERE status = 1 AND deleted_at IS NULL";
        }else{
            $sql = "SELECT * FROM blogs WHERE category=".$cat." AND status = 1 AND deleted_at IS NULL";
        }
        
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    //delete email template
    public function delete_blog($id)
    {
        $id = clean_number($id);
        $blog = $this->get_blog_by_id($id);
        if (!empty($blog)) {
            //delete email template
            return $this->where('id', $id)->delete();
        }
        return false;
    }

    public function blogPaginate()
    {
        $request = service('request');
        $show = 15;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }

        $paginateData = $this->select('blogs.*');

        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('blogs.name', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 2)) {
            $this->builder()->where('blogs.status', clean_number($status));
        }
        $category = trim($request->getGet('category') ?? '');
        if ($category != null && ($category == 1 || $category == 0)) {
            $this->builder()->where('blogs.category', clean_number($category));
        }

        $result = $paginateData->paginate($show, 'default');

        return [
            'blog'  =>  $result,
            'pager'     => $this->pager,
        ];
    }
	
    public function blogs_list()
    {

        $sql = "SELECT * FROM blogs WHERE deleted_at IS NULL";
        
        $query = $this->db->query($sql);
        return $query->getResultArray();

    }
}
