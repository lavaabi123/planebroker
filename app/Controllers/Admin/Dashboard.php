<?php

namespace App\Controllers\Admin;

use App\Libraries\GoogleAnalytics;

class Dashboard extends AdminController
{
    public $session; 
    public $segment; 
    public $db; 
    public $validation; 
    public $encrypter; 
    public $lang_base_url;
    public $selected_lang;
    public $general_settings;
    public $agent;
    public $analytics;
    public $file_count;
    public $file_per_page;
    protected $RolesPermissionsModel;
    public $data;

    public function __construct()
    {
        //$this->analytics = new GoogleAnalytics();
    }

    public function index()
    {
		$query2 =  $this->userModel->db->query("SELECT product_id, SUM(view_count) AS total_views, (
            SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR ' ') 
            FROM products_dynamic_fields pd 
            JOIN (
                SELECT t.field_id, t.sort_order 
                FROM title_fields t 
                LEFT JOIN fields f ON f.id = t.field_id 
                WHERE t.title_type = 'title'
            ) t ON t.field_id = pd.field_id 
            WHERE pd.product_id = p.id
        ) as display_name
FROM website_stats w
join products p on p.id = w.product_id where (
            SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR ' ') 
            FROM products_dynamic_fields pd 
            JOIN (
                SELECT t.field_id, t.sort_order 
                FROM title_fields t 
                LEFT JOIN fields f ON f.id = t.field_id 
                WHERE t.title_type = 'title'
            ) t ON t.field_id = pd.field_id 
            WHERE pd.product_id = p.id
        ) != ''
GROUP BY product_id
ORDER BY total_views DESC
LIMIT 10")->getResult();
$query3 =  $this->userModel->db->query("SELECT product_id, count(product_id) AS total_views, (
            SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR ' ') 
            FROM products_dynamic_fields pd 
            JOIN (
                SELECT t.field_id, t.sort_order 
                FROM title_fields t 
                LEFT JOIN fields f ON f.id = t.field_id 
                WHERE t.title_type = 'title'
            ) t ON t.field_id = pd.field_id 
            WHERE pd.product_id = p.id
        ) as display_name
FROM user_favorites w
join products p on p.id = w.product_id where (
            SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR ' ') 
            FROM products_dynamic_fields pd 
            JOIN (
                SELECT t.field_id, t.sort_order 
                FROM title_fields t 
                LEFT JOIN fields f ON f.id = t.field_id 
                WHERE t.title_type = 'title'
            ) t ON t.field_id = pd.field_id 
            WHERE pd.product_id = p.id
        ) != ''
GROUP BY product_id
ORDER BY total_views DESC
LIMIT 10")->getResult();
$query4 =  $this->userModel->db->table('products p')->select("
        p.*, 
        pl.is_premium_listing,pl.name as package_names,
        u.fullname,
        c.name as category_name,
        sc.name as sub_category_name,
        c.permalink,s.admin_plan_update,
        (
            SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR ' ') 
            FROM products_dynamic_fields pd 
            JOIN (
                SELECT t.field_id, t.sort_order 
                FROM title_fields t 
                LEFT JOIN fields f ON f.id = t.field_id 
                WHERE t.title_type = 'title'
            ) t ON t.field_id = pd.field_id 
            WHERE pd.product_id = p.id
        ) as display_name,
        (
            SELECT field_value 
            FROM products_dynamic_fields 
            WHERE product_id = p.id 
            AND field_id = (
                SELECT fi.id FROM `fields` fi  join field_categories fc on fc.field_id=fi.id where fi.name = 'price' and fc.category_id=p.category_id LIMIT 1
            ) 
            LIMIT 1
        ) as price ")->join('categories c', 'c.id = p.category_id', 'left')
		->join('categories_sub sc', 'sc.id = p.sub_category_id', 'left')
		->join('users u', 'u.id = p.user_id', 'left')
		->join('plans pl', 'pl.id = p.plan_id', 'left')
		->join('sales s', 's.id = p.sale_id', 'left')->orderBy('p.id','DESC')->limit(10)->get()->getResult();
		$query1 =  $this->userModel->db->table('sales AS s')
            ->select('s.*, COALESCE(NULLIF(u.business_name,""), u.fullname) AS provider')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->where('u.deleted_at', null)->where('stripe_subscription_amount_paid >',0)
            ->orderBy('s.id', 'DESC')->limit(10)->get()->getResult();
		//print_r($query1);exit;	
        $data = array_merge($this->data, [
            'title'     => trans('dashboard'),
			'top_locations' => $query2,
			'recent_payments' => $query1,
			'top_favs' => $query3,
			'recent_listings' => $query4,
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
