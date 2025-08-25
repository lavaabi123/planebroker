<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionModel extends Model
{
    protected $table            = 'plans';
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
    public function add_subscription()
    {

        //$data = $this->input_values();

        //secure password
        $data = array(
                'name' => $this->request->getVar('name'),
                'price' => $this->request->getVar('price'),
                'no_of_weeks' => $this->request->getVar('no_of_weeks'),
                'no_of_photos' => $this->request->getVar('no_of_photos'),
                'no_of_videos' => $this->request->getVar('no_of_videos'),
                'is_featured_listing' => $this->request->getVar('is_featured_listing'),
                'is_premium_listing' => $this->request->getVar('is_premium_listing'),
                'is_recommended' => $this->request->getVar('is_recommended'),
                'stripe_price_id' => $this->request->getVar('stripe_price_id'),
                //'paypal_plan_id_with_trial' => $this->request->getVar('paypal_plan_id_with_trial'),
                //'paypal_plan_id_without_trial' => $this->request->getVar('paypal_plan_id_without_trial'),
                'status' => $this->request->getVar('status')
            );

        return $this->protect(false)->insert($data);
    }

    //edit email template
    public function edit_subscription($id)
    {
        $subscription = $this->get_subscription_by_id($id);
        if (!empty($subscription)) {
            $data = array(
                'name' => $this->request->getVar('name'),
                'price' => $this->request->getVar('price'),
                'no_of_weeks' => $this->request->getVar('no_of_weeks'),
                'no_of_photos' => $this->request->getVar('no_of_photos'),
                'no_of_videos' => $this->request->getVar('no_of_videos'),
                'is_featured_listing' => $this->request->getVar('is_featured_listing'),
                'is_premium_listing' => $this->request->getVar('is_premium_listing'),
                'is_recommended' => $this->request->getVar('is_recommended'),
                'stripe_price_id' => $this->request->getVar('stripe_price_id'),
                'paypal_plan_id_with_trial' => $this->request->getVar('paypal_plan_id_with_trial'),
                'paypal_plan_id_without_trial' => $this->request->getVar('paypal_plan_id_without_trial'),
                'status' => $this->request->getVar('status')
            );

            return $this->protect(false)->update($subscription->id, $data);
        }
    }

    //ban email template
    public function ban_subscription($id)
    {
        $id = clean_number($id);
        $subscription = $this->get_subscription_by_id($id);
        if (!empty($subscription)) {

            $data = array(
                'status' => 0
            );
            return $this->protect(false)->update($subscription->id, $data);
        } else {
            return false;
        }
    }

    //remove email template ban
    public function remove_subscription_ban($id)
    {
        $id = clean_number($id);
        $subscription = $this->get_subscription_by_id($id);

        if (!empty($subscription)) {

            $data = array(
                'status' => 1
            );

            return $this->protect(false)->update($subscription->id, $data);
        } else {
            return false;
        }
    }

    //get email template by id
    public function get_subscription($clean_url)
    {
        $sql = "SELECT * FROM plans WHERE plans.clean_url = ?";
        $query = $this->db->query($sql, array($clean_url));
        return $query->getRow();
    }
    public function get_subscription_by_id($id)
    {
        $sql = "SELECT * FROM plans WHERE plans.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }
    public function get_all_subscription()
    {
        $sql = "SELECT * FROM plans WHERE status = 1 AND deleted_at IS NULL";
        $query = $this->db->query($sql);
        return $query->getResult();
    }

    //delete email template
    public function delete_subscription($id)
    {
        $id = clean_number($id);
        $subscription = $this->get_subscription_by_id($id);
        if (!empty($subscription)) {
            //delete email template
            return $this->where('id', $id)->delete();
        }
        return false;
    }

    public function subscriptionPaginate()
    {
        $request = service('request');
        $show = 15;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }

        $paginateData = $this->select('plans.*');

        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('plans.name', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 2)) {
            $this->builder()->where('plans.status', clean_number($status));
        }

        $result = $paginateData->paginate($show, 'default');

        return [
            'subscription'  =>  $result,
            'pager'     => $this->pager,
        ];
    }
}
