<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Locations\CityModel;

class MailsModel extends Model
{
    protected $table            = 'users_emails';
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
            'user_type' => $this->request->getVar('email_verified'),
            'user_plan' => $this->request->getVar('plan'),
            'from_email' => $this->request->getVar('from_email'),
            'from_name' => $this->request->getVar('from_name'),
            'name' => $this->request->getVar('name'),
            'content' => $this->request->getVar('content')
        );
        return $data;
    }

    //send email
    public function email_log($insertData = array())
    {

        $data = $this->input_values();

        $email_verified = $this->request->getVar('email_verified');
        $data['user_type'] = ($email_verified == '') ? 1 : (($email_verified == 'y') ? 2 : (($email_verified == 'n') ? 3 : 0));

        $data['user_plan'] = $this->request->getVar('plan');
        $data['user_plan'] = ($data['user_plan'] && count($data['user_plan']) > 0) ? implode(',', $data['user_plan']) : '';
        $data['from_email'] = $this->request->getVar('from_email');
        $data['from_name'] = $this->request->getVar('from_name');
        $data['name'] = $this->request->getVar('name');
        $data["content"] = $this->request->getVar('content');
        $data['created_at'] = date('Y-m-d H:i:s');

        $emailInsertId = $this->protect(false)->insert($data);

        $dataEmailLog  = [
                            'users_email_id' => $emailInsertId,
                            'sent_users'     => json_encode($insertData)
                         ];

        $this->db->table('users_emails_log')->insert($dataEmailLog);

        return $emailInsertId;
    }

    //get email by id
    public function get_emails($id)
    {
        $sql = "SELECT * FROM users_emails WHERE users_emails.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }


    public function emailPaginate()
    {
        $request = service('request');
        $show = 15;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }


        $paginateData = $this->select('users_emails.*');


        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('users_emails.name', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('users_emails.status', clean_number($status));
        }

        $result = $paginateData->paginate($show, 'default');

        return [
            'emails'  =>  $result,
            'pager'   => $this->pager,
        ];
    }

     //get users data
    public function getUsersData()
    {
        $sql = "SELECT u.`id`, u.`email`, CONCAT(u.`first_name`,' ', u.`last_name`) as name 
                  FROM users u 
                   WHERE  status = ?
                   ORDER BY name ASC ";
        $query = $this->db->query($sql, array(clean_number(1)));
        return $query->getResult();
    }

     //get recipients data
    public function getRecipients($email_verified, $plans,$category_id,$arrLocationIds=array())
    {
        $andSql = array(" u.id = u.id "); $orSql = array();

        if(!empty($email_verified) && $email_verified == 'y'){
            $andSql[] = " u.`email_status` = '1' ";
        }

        if(!empty($email_verified) && $email_verified == 'n'){
            $andSql[] = " u.`email_status` = '0' ";
        }

        if(!empty($category_id)){
            $andSql[] = " u.`category_id` = '".$category_id."' ";
        }

        if(count($arrLocationIds) > 0){
            $cityModel   = new CityModel();
            
            try{
                $arrLatLong  = $this->getLocationsData($arrLocationIds);
                $zipcode_ids = array();
                $radius      = 100;

                foreach ($arrLatLong as $lat_long) {
                    if(!empty($lat_long)){
                        $zipcode_ids[] = $cityModel->get_nearest_zipcodes($lat_long->lat,$lat_long->long,$radius)['zipcode_ids'];
                    }
                }            

                $zipcode_ids = array_unique(array_reduce($zipcode_ids, function ($carry, $item) {
                    $values = explode(',', $item);
                    return array_merge($carry, $values);
                }, []));
                if(count($zipcode_ids) > 0){
                    $andSql[] = " location_id IN (".implode(',',$zipcode_ids).") ";
                }                
            }catch(Exception $e) {
            }            
        }
        if(!empty($plans)){
            foreach($plans as $plan)
            {
                $orSql[] = " u.`user_level` = '".$plan."' ";            
            }
        }
                                                                                                        
        if(!empty($orSql))
        {
            $andSql[] = '('.implode('OR', $orSql).')';
        }

        $andSql = implode('AND', $andSql);

        $sql    = "SELECT u.`email`, CONCAT(u.`first_name`,' ', u.`last_name`) as name
                          FROM users u 
                          WHERE $andSql AND status = '1'";
                          
        $query  = $this->db->query($sql);
        $users  = $query->getResult();

        return $users;
    }

    /* get locations data
       return latitude and longitude
    */
    public function getLocationsData($arrLocationIds = array())
    {
        if(count($arrLocationIds) < 1) return array();
        
        $query = $this->db->table('zipcodes')
                    ->select('lat, long')
                    ->whereIn('id', $arrLocationIds)
                    ->get();

        $result = $query->getResult();

        return $result;
    }
}
