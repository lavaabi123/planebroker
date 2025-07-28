<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
    protected $table            = 'testimonials';
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
            'name' => $this->request->getVar('name'),
            'content' => $this->request->getVar('content')
        );
        return $data;
    }

    //add user
    public function add_testimonial()
    {

        $data = $this->input_values();

        //secure password
        $data['name'] = $this->request->getVar('name');
        $data["content"] = $this->request->getVar('content');
        $data['status'] = $this->request->getVar('status');
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->protect(false)->insert($data);
    }

    //edit email template
    public function edit_testimonial($id)
    {
        $testimonial = $this->get_testimonial_by_id($id);
        if (!empty($testimonial)) {
            $data = array(
                'name' => $this->request->getVar('name'),
                'content' => $this->request->getVar('content'),
                'status' => $this->request->getVar('status')
            );

            return $this->protect(false)->update($testimonial->id, $data);
        }
    }

    //ban email template
    public function ban_testimonial($id)
    {
        $id = clean_number($id);
        $testimonial = $this->get_testimonial_by_id($id);
        if (!empty($testimonial)) {

            $data = array(
                'status' => 0
            );
            return $this->protect(false)->update($testimonial->id, $data);
        } else {
            return false;
        }
    }

    //remove email template ban
    public function remove_testimonial_ban($id)
    {
        $id = clean_number($id);
        $testimonial = $this->get_testimonial_by_id($id);

        if (!empty($testimonial)) {

            $data = array(
                'status' => 1
            );

            return $this->protect(false)->update($testimonial->id, $data);
        } else {
            return false;
        }
    }

    //get email template by id
    public function get_testimonial($clean_url)
    {
        $sql = "SELECT * FROM testimonials WHERE testimonials.clean_url = ?";
        $query = $this->db->query($sql, array($clean_url));
        return $query->getRow();
    }
    public function get_testimonial_by_id($id)
    {
        $sql = "SELECT * FROM testimonials WHERE testimonials.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }
    public function get_all_testimonial()
    {
        $sql = "SELECT * FROM testimonials WHERE status = 1 AND deleted_at IS NULL";
        $query = $this->db->query($sql);
        return $query->getResult();
    }

    //delete email template
    public function delete_testimonial($id)
    {
        $id = clean_number($id);
        $testimonial = $this->get_testimonial_by_id($id);
        if (!empty($testimonial)) {
            //delete email template
            return $this->where('id', $id)->delete();
        }
        return false;
    }

    public function testimonialPaginate()
    {
        
        $request = service('request');
        $show = 15;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }

        $paginateData = $this->select('testimonials.*');

        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('testimonials.name', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 2)) {
            $this->builder()->where('testimonials.status', clean_number($status));
        }

        $result = $paginateData->paginate($show, 'default');
//echo $this->db->getLastQuery();exit;
        return [
            'testimonial'  =>  $result,
            'pager'     => $this->pager,
        ];
    }
}
