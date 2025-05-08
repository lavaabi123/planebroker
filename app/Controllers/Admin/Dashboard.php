<?php

namespace App\Controllers\Admin;

use App\Libraries\GoogleAnalytics;

class Dashboard extends AdminController
{

    public function __construct()
    {
        //$this->analytics = new GoogleAnalytics();
    }

    public function index()
    {
		$query2 =  $this->userModel->db->query("SELECT count(*) as user_count,users.location_id, zipcodes.city, zipcodes.zipcode, states.code as state_code FROM `users` LEFT JOIN zipcodes ON users.location_id = zipcodes.id LEFT JOIN states ON zipcodes.state_id = states.id where users.location_id > 0 group by zipcodes.city,states.code order by user_count desc limit 10")->getResult();
		$query1 =  $this->userModel->db->table('sales AS s')
            ->select('s.*, COALESCE(NULLIF(u.business_name,""), u.fullname) AS provider')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->where('u.deleted_at', null)->where('stripe_subscription_amount_paid >',0)
            ->orderBy('s.id', 'DESC')->limit(10)->get()->getResult();
		//print_r($query1);exit;	
        $data = array_merge($this->data, [
            'title'     => trans('dashboard'),
			'top_locations' => $query2,
			'recent_payments' => $query1
        ]);

        return view('admin/dashboard', $data);
    }

    public function Blocked()
    {
        $data = array_merge($this->data, [
            'title'     => 'Forbiden Page',

        ]);

        return view('admin/blocked', $data);
    }
}
