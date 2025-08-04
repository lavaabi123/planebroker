<?php

namespace App\Controllers;

use App\Libraries\Recaptcha;
use App\Models\UsersModel;
use App\Models\Locations\CityModel;
use App\Models\CategoriesModel;
use App\Models\CategoriesSkillsModel;
use App\Models\ClientTypesModel;
use App\Models\EmailModel;
use App\Models\FieldsModel;
use App\Models\ProductModel;
use App\Models\CategoriesSubModel;

class Providers extends BaseController
{
    protected $userModel;
    protected $ProductModel;
    protected $categoriessubModel;
    protected $CategoriesModel;
    protected $UsersModel;
    protected $CityModel;
    protected $CategoriesSkillsModel;
    protected $ClientTypesModel;
    protected $EmailModel;
    protected $FieldsModel;
    public $session; 
    public $segment; 
    public $db; 
    public $validation; 
    public $encrypter; 
    public $lang_base_url;
    public $selected_lang;
    public $general_settings;
    public $agent;
    public function index()
    {
		$data = array();
        if ($this->session->get('vr_sess_logged_in') != TRUE) {
            //return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$data['title'] = trans('Dashboard');
        //return view('\Providersearch/ProviderDashboard', $data);
    }
	
	public function view_profile($category_name = null, $productId = null){
		$data = array();
		$data['fromuserId'] = !empty($this->session->get('vr_sess_user_id')) ? $this->session->get('vr_sess_user_id') : 0;
		$data['share_url'] = str_replace('index.php/','',current_url(true));
		$data['productId'] = $productId;
		
		//get product_detail
		$this->ProductModel = new ProductModel();
		$where = ' AND p.id = '.$productId;
		$data['product_detail'] = $this->ProductModel->get_products($category_name,$where);
		$data['product_detail'] = !empty($data['product_detail']) ? $data['product_detail'][0] : array();		
		$data['userId'] = !empty($data['product_detail']['user_id']) ? $data['product_detail']['user_id'] : 0;
		$this->UsersModel = new UsersModel();
		$data['user_detail']    = $this->UsersModel->get_user($data['userId']);
		$this->UsersModel = new UsersModel();
		$data['user_photos'] = $this->UsersModel->get_user_photos($data['userId'],'',$productId);
		$this->ProductModel = new ProductModel();
		$data['product_dynamic_fields'] = $this->ProductModel->get_product_dynamic_fields($category_name,$productId);
		//get fields to show				
		$this->ProductModel = new ProductModel();
		$data['product_description'] = $this->ProductModel->title_fields($category_name,'description',$productId);
		//echo "<pre>";print_r($data['product_dynamic_fields']);exit;
		
		$user_latitude = !empty($this->session->get('user_latitude')) ? $this->session->get('user_latitude') : '';
		$user_longitude = !empty($this->session->get('user_longitude')) ? $this->session->get('user_longitude') : '';
		$user_zipcode = !empty($this->session->get('user_zipcode')) ? $this->session->get('user_zipcode') : '';
		$query2 =  $this->UsersModel->db->query("INSERT INTO website_stats (user_id,product_id,view_count,customer_lat,customer_long,customer_zipcode) VALUES (".$data['userId'].",".$productId.",1,'".$user_latitude."','".$user_longitude."','".$user_zipcode."')");
		
		$data['wishlist_added'] = !empty($this->session->get('vr_sess_user_id')) ? $this->ProductModel->wishlist_check($this->session->get('vr_sess_user_id'),$productId) : 0;
		
		
		return view('Providers/ProviderViewProfile', $data);
	}
	
	public function view_profile_old($category_name = null, $userId = null){
		
		
		$this->UsersModel = new UsersModel();
		$uri = current_url(true);	
		
		
		if(empty($uri->getSegment(env('urlsegment')+1))){
			$u_det = $this->UsersModel->get_uer_by_business_name($uri->getSegment(env('urlsegment')));
			$paramUserId = !empty($u_det) ? $u_det->id : '';
		}else{
			$paramUserId = !empty($uri->getSegment(env('urlsegment')+1)) ? base64_decode($uri->getSegment(env('urlsegment')+1)) : '';
		}
		if((!empty($paramUserId) && is_numeric($paramUserId))){
			$or_url = str_replace('index.php/','',current_url(true));
			$data['share_url'] = base_url().'/provider/'.$uri->getSegment(env('urlsegment'));
		}else{
			if($userId == null && empty($paramUserId) && !empty($this->session->get('vr_sess_user_id'))){
			$data['share_url'] = str_replace('index.php/','',current_url(true));
			}else{
				$data['share_url'] = str_replace('index.php/','',current_url(true));
			}
		}
		
		
		if($userId == null && (!empty($paramUserId) && !is_numeric($paramUserId))){
			$userId = $this->session->get('vr_sess_user_id');
		}else if((!empty($paramUserId) && is_numeric($paramUserId))){
			$userId = $paramUserId;		
			$query2 =  $this->UsersModel->db->query("UPDATE users SET view_count = view_count + 1 WHERE id = ".$userId);
			$user_latitude = !empty($this->session->get('user_latitude')) ? $this->session->get('user_latitude') : '';
			$user_longitude = !empty($this->session->get('user_longitude')) ? $this->session->get('user_longitude') : '';
			$user_zipcode = !empty($this->session->get('user_zipcode')) ? $this->session->get('user_zipcode') : '';
			$query2 =  $this->UsersModel->db->query("INSERT INTO website_stats (user_id,view_count,customer_lat,customer_long,customer_zipcode) VALUES (".$userId.",1,'".$user_latitude."','".$user_longitude."','".$user_zipcode."')");
			$query3 =  $this->UsersModel->db->query("UPDATE users SET impression_count = impression_count + 1 WHERE id = ".$userId);
			$query3 =  $this->UsersModel->db->query("INSERT INTO website_stats (user_id,impression_count,customer_lat,customer_long,customer_zipcode) VALUES (".$userId.",1,'".$user_latitude."','".$user_longitude."','".$user_zipcode."')");
		}elseif($userId == null && empty($paramUserId) && !empty($this->session->get('vr_sess_user_id'))){
			$userId = $this->session->get('vr_sess_user_id');
		}
		
		$data['userId'] = $userId;
		$data['user_detail'] = $this->UsersModel->get_user($userId);
		$data['user_photos'] = array();//$this->UsersModel->get_user_photos($userId,$data['user_detail']->plan_id);
		$data['rate_details'] = $this->UsersModel->get_rate_details($userId);
		$data['hours_of_operation'] = $this->UsersModel->get_hours_of_operation($userId);
        $this->ClientTypesModel = new ClientTypesModel();
		$data['client_types'] = $this->ClientTypesModel->get_client_types();
        $this->CategoriesModel = new CategoriesModel();
		$data['categories'] = $this->CategoriesModel->get_categories();
		$this->CityModel = new CityModel();
		$data['featured'] = array();//$this->CityModel->get_featured($data['user_detail']->location_id,$data['user_detail']->permalink,$radius=1);
		$data['search_location_name'] = '';//$data['user_detail']->city.', '.$data['user_detail']->state_code;
		if(!empty($data['user_detail']->category_id)){
			$this->CategoriesSkillsModel = new CategoriesSkillsModel();
			$data['categories_skills'] = $this->CategoriesSkillsModel->get_categories_skills_by_category_id(1);
			//$this->OfferingModel = new OfferingModel();
			$data['offering'] = array();//$this->OfferingModel->get_offering_category_based(1);
		}else{
			$data['categories_skills'] = array();
			$data['offering'] = array();
		}
		$data['rating'] = '';
		if(!empty($data['user_detail']->yelp_name)){
			$data['rating'] = $this->get_yelp_rating(str_replace('www.yelp.com/biz/','',$data['user_detail']->yelp_name));
		}
		$data['title'] = trans('Profile');
		
		$data['meta_title'] = !empty(get_seo('Profile')) ? get_seo('Profile')->meta_title : 'Profile | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Profile')) ? get_seo('Profile')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Profile')) ? get_seo('Profile')->meta_keywords : '';
		
		
		//get dynamic fields
        $this->FieldsModel = new FieldsModel();
        $dynamic_fields = $this->FieldsModel->get_fields();
		$data['dynamic_fields_right'] = array();
		$data['dynamic_fields_left'] = array();
		if(!empty($dynamic_fields)){
			$dynamic_fields_values = array();//json_decode($data['user_detail']->dynamic_fields,true);
			foreach($dynamic_fields as $field){
				if(!empty($field->field_position) && $field->field_position == 'Right' && !empty($field->category_ids) && in_array($data['user_detail']->category_id,explode(',',$field->category_ids))){
					$field->value = !empty($dynamic_fields_values[$field->name]) ? ( is_array($dynamic_fields_values[$field->name]) ? implode(', ',$dynamic_fields_values[$field->name]) : $dynamic_fields_values[$field->name]) : '';
					$data['dynamic_fields_right'][] = $field;
				}else{
					if(!empty($field->category_ids) && in_array($data['user_detail']->category_id,explode(',',$field->category_ids))){
					$field->value = !empty($dynamic_fields_values[$field->name]) ? ( is_array($dynamic_fields_values[$field->name]) ? implode(', ',$dynamic_fields_values[$field->name]) : $dynamic_fields_values[$field->name]) : '';
					$data['dynamic_fields_left'][] = $field;
					}
				}
			}
		}		
		//echo '<pre>';print_r($data);exit;
    	return view('Providers/ProviderViewProfile', $data);
		exit;
	}
	public function view_gallery($category_name = null, $userId = null){
		$this->UsersModel = new UsersModel();
		$paramUserId = $this->request->uri->getSegment(2) ?? '';
		
		if($userId == null && (!empty($paramUserId) && !is_numeric($paramUserId))){
			$userId = $this->session->get('vr_sess_user_id');
		}else if((!empty($paramUserId) && is_numeric($paramUserId))){
			$userId = $paramUserId;
		}
		$data['userId'] = $userId;
		$data['user_detail'] = $this->UsersModel->get_user($userId);
		$data['user_photos'] = $this->UsersModel->get_user_photos($userId,$data['user_detail']->plan_id);
		$name = !empty($data['user_detail']->business_name) ? $data['user_detail']->business_name : $data['user_detail']->fullname ;
		$data['title'] = trans('Photos of '.$name);
		$data['meta_title'] = !empty(get_seo('Gallery')) ? get_seo('Gallery')->meta_title : 'Gallery | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Gallery')) ? get_seo('Gallery')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Gallery')) ? get_seo('Gallery')->meta_keywords : '';
    	return view('Providers/ProviderGallery', $data);
		exit;
	}
	public function providers_list($category = null, $location = null)
    {
		$data['meta_title'] = !empty(get_seo('Plane Broker')) ? get_seo('Plane Broker')->meta_title : 'Plane Broker las vegas | Plane Broker in las vegas';
		$data['meta_desc'] = !empty(get_seo('Plane Broker')) ? get_seo('Plane Broker')->meta_description : "Find the perfect planes in Las Vegas with Plane Broker's extensive listings. From mobile to the best in town, we've got you covered!";
		$data['meta_keywords'] = !empty(get_seo('Plane Broker')) ? get_seo('Plane Broker')->meta_keywords : '';
		
		//echo "<pre>";print_r($_GET);exit;
		$where = '';
		$filter_texts['category'] = array();
		$filter_ids['category_ids'] = array();
		$filter_ids['manufacturer'] = array();
		$filter_texts['manufacturer'] = array();
		$filter_texts['keywords'] = '';
		$filter_texts['model'] = array();
		$filter_ids['model'] = array();
		$filter_texts['year'] = '';
		$filter_ids['year'] = array();
		$data['is_get'] = 0;
		
		
		//get products list
		$this->ProductModel = new ProductModel();
		$raw_filters = $this->ProductModel->get_filters($category,$where);
		//echo "<pre>";print_r($data['filters']);exit;
		
		if(!empty($_GET)){
			$realFilters = $_GET;
			unset($realFilters['sort_by']);          // ignore the sort radio

			// Remove keys that are empty or contain only empty strings
			$realFilters = array_filter($realFilters, function ($v) {
				if (is_array($v)) {                 // drop arrays like [''] or []
					return count(array_filter($v, fn($x) => $x !== '' && $x !== null)) > 0;
				}
				return $v !== '' && $v !== null;
			});

			// --------------------------------------------------
			// 1)  Now set the flag
			// --------------------------------------------------
			$data['is_get'] = empty($realFilters) ? 0 : 1;
			if(!empty($_GET['category']) && !empty($_GET['category'][0])){
				$where .= ' AND p.sub_category_id IN ('.implode(',',explode('|',$_GET['category'])).')';
				$filter_texts['category'] = explode(', ',getSubcategoryName(explode('|',$_GET['category'])));
				$filter_ids['category_ids'] = explode('|',$_GET['category']);
			}
			if(!empty($_GET['keywords'])){
				//get fields to show				
				$this->ProductModel = new ProductModel();
				//$data['title_fields'] = $this->ProductModel->title_fields($category,'title');
				$where .= ' AND ((SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` where name = "manufacturer")) like "%'.$_GET['keywords'].'%" OR (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` where name = "Make/Model")) like "%'.$_GET['keywords'].'%" OR (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` where name = "year")) like "%'.$_GET['keywords'].'%")';
				$filter_texts['keywords'] = 'Keywords';
			}
			if(!empty($_GET['created_at'])){
				$created_at = explode('|',$_GET['created_at']);
				if(!empty($created_at[0])){
					$where .= ' AND (p.created_at >= "'.$created_at[0].' 00:00:00"';
				}
				if(!empty($created_at[1])){
					$where .= ' AND p.created_at <= "'.$created_at[1].' 23:59:59"';
				}
				$where .= ')';
				$filter_texts['created_at'] = 'Date';
				$filter_ids['created_at'] = explode('|',$_GET['created_at']);
			}
			
			if(!empty($_GET['featured'])){
				$where .= " AND pl.is_featured_listing = 1";
				$filter_texts['featured'] = 'Featured';
				$filter_ids['featured'] = 'yes';
			}
			foreach($_GET as $g => $getparam){
				if($g != 'category' && $g != 'created_at' && $g != 'featured'){
					
					$slugToFind = $g;
					$slugText = $g;
					$check_filter_type = null;
					foreach ($raw_filters as $item) {
						if ($item['slug'] === $slugToFind) {
							$check_filter_type = $item['filter_type'];
							$slugText = $item['name'];
							break;
						}
					}

					if($check_filter_type == 'checkbox'){
						$whereIn = explode('|', $getparam);
						$whereIn = array_map(function($val) {
							return "'" . addslashes($val) . "'";
						}, $whereIn);
						
						$where .= " AND (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` join field_categories fc on fc.field_id=id where LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', '_'), ' ', '_'), '-', '_'), '(', '_'), ')', '_'), '&', '_')) = '".$g."' and fc.category_id=p.category_id LIMIT 1)) IN (" . implode(",", $whereIn) . ")";
						
						$filter_texts[$g] = explode('|',$getparam);
						$filter_ids[$g] = explode('|',$getparam);
					}
					if($check_filter_type == 'number'){
						$time = explode('|',$getparam);
						
						$where .= 'AND (';
						$time[0] = !empty($time[0]) ? $time[0] : 0 ;
						$time[1] = !empty($time[1]) ? $time[1] : 0 ;
						if(!empty($time[0])){
							if($g == 'price'){
								$where .= " (SELECT REPLACE(field_value, ',', '') FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` join field_categories fc on fc.field_id=id where LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', '_'), ' ', '_'), '-', '_'), '(', '_'), ')', '_'), '&', '_')) = '".$g."' and fc.category_id=p.category_id LIMIT 1)) >= ".(int)$time[0];
							}else{
								$where .= " (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` join field_categories fc on fc.field_id=id where LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', '_'), ' ', '_'), '-', '_'), '(', '_'), ')', '_'), '&', '_')) = '".$g."' and fc.category_id=p.category_id LIMIT 1)) >= ".(int)$time[0];
							}
						}
						if(!empty($time[0]) && !empty($time[1])){
							$where .= " AND ";
						}
						if(!empty($time[1])){
							if($g == 'price'){								
								$where .= " (SELECT REPLACE(field_value, ',', '') FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` join field_categories fc on fc.field_id=id where LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', '_'), ' ', '_'), '-', '_'), '(', '_'), ')', '_'), '&', '_')) = '".$g."' and fc.category_id=p.category_id LIMIT 1)) <= ".(int)$time[1];
							}else{
								$where .= " (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` join field_categories fc on fc.field_id=id where LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', '_'), ' ', '_'), '-', '_'), '(', '_'), ')', '_'), '&', '_')) = '".$g."' and fc.category_id=p.category_id LIMIT 1)) <= ".(int)$time[1];
							}
						}
						$where .= ')';
						
						$filter_texts[$g] = $slugText;
						$filter_ids[$g] = explode('|',$getparam);
					}
					if($check_filter_type == 'text'){
						if(!empty($getparam)){
							$where .= " AND (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` join field_categories fc on fc.field_id=id WHERE LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', '_'), ' ', '_'), '-', '_'), '(', '_'), ')', '_'), '&', '_')) = '".$g."' and fc.category_id=p.category_id LIMIT 1)) like '%".$getparam."%'";
						}
						$filter_texts[$g] = $slugText;
						$filter_ids[$g] = $getparam;
					}
				}
			}
		}
		$where .= ' AND p.status=1 AND (p.is_cancel = 0 || s.stripe_subscription_end_date >= NOW()) and p.sale_id > 0';
		
				
		$sort_by = $this->request->getGet('sort_by') ?? '';   // '' when not present
		$orderBy = '';                      // default → newest first

		switch ($sort_by) {
			case 'price_asc':        // Price (Low → High)
				$orderBy = "
					CAST(
						REPLACE(
							(SELECT field_value
							 FROM   products_dynamic_fields
							 WHERE  product_id = p.id
							   AND  field_id   = (SELECT id FROM fields WHERE name = 'price' LIMIT 1)
							 LIMIT  1
							), ',', ''
						) AS UNSIGNED
					) ASC";
				break;

			case 'price_desc':       // Price (High → Low)
				$orderBy = "
					CAST(
						REPLACE(
							(SELECT field_value
							 FROM   products_dynamic_fields
							 WHERE  product_id = p.id
							   AND  field_id   = (SELECT id FROM fields WHERE name = 'price' LIMIT 1)
							 LIMIT  1
							), ',', ''
						) AS UNSIGNED
					) DESC";
				break;

			case 'oldest':           // Oldest first
				$orderBy = 'p.created_at ASC';
				break;

			case 'newest':           // explicit newest (same as default)
			default:
				$orderBy = 'p.created_at DESC';
				break;
		}
		
		$data['filters'] = $this->ProductModel->get_filters($category,$where);
		//get products list
		$this->ProductModel = new ProductModel();
		if(!empty($orderBy)){
			$data['categories'] = $this->ProductModel->get_products($category,$where,$orderBy);
		}else{
			$data['categories'] = $this->ProductModel->get_products($category,$where);
		}
		
		//get subcategory list
		$this->categoriessubModel = new CategoriesSubModel();
        $data['categories_list'] = $this->categoriessubModel->get_categories_by_link($category,' AND categories_sub.id IN (SELECT DISTINCT sub_category_id FROM products)');
		//get manufacturers List
		$this->ProductModel = new ProductModel();
		$data['manufacturers'] = $this->ProductModel->get_manufacturers($category, $where);
		//get models List
		$this->ProductModel = new ProductModel();
		$data['models'] = $this->ProductModel->get_models($category, $where);
		
		$data['category'] = $category;
		$data['filter_texts'] = $filter_texts;
		//print_r($data['categories_list']);exit;
		$data['filter_ids'] = $filter_ids;
		
		$price_range_array = array('Under $20,000'=>array('','20000',0),'$20,000 to $49,999'=>array('20000','49999',0),'$50,000 to $99,999'=>array('50000','99999',0),'$100,000 to $249,999'=>array('100000','249999',0),'$250,000 to $499,999'=>array('250000','499999',0),'$500,000 and Over'=>array('500000','',0));
		
		if(!empty($data['categories'])){
			foreach($data['categories'] as $prod){
				if($prod['price'] > 0 && $prod['price'] < 20000){
					$price_range_array['Under $20,000'][2]++;
				}elseif($prod['price'] >= 20000 && $prod['price'] <= 49999){
					$price_range_array['$20,000 to $49,999'][2]++;
				}elseif($prod['price'] >= 50000 && $prod['price'] <= 99999){
					$price_range_array['$50,000 to $99,999'][2]++;
				}elseif($prod['price'] <= 100000 && $prod['price'] <= 249999){
					$price_range_array['$100,000 to $249,999'][2]++;
				}elseif($prod['price'] >= 250000 && $prod['price'] <= 499999){
					$price_range_array['$250,000 to $499,999'][2]++;
				}elseif($prod['price'] >= 500000){
					$price_range_array['$500,000 and Over'][2]++;
				}
			}
		}
		$new_pr_arr = [];
		foreach($price_range_array as $th => $pr){
			//if($pr[2] > 0){
				$new_pr_arr[$th] = $pr;
			//}
		}
		$data['price_range_array'] = $new_pr_arr;
		//echo "<pre>";print_r($data);exit;
		$data['result_count'] = count($data['categories']);
        $this->CategoriesModel = new CategoriesModel();
		$data['category_detail'] = $this->CategoriesModel->get_categories_link($category);
		if ($this->request->isAJAX()) {
			return $this->response->setJSON([
				'grid'    => view('Providers/product_cards',   $data, ['saveData' => false]),
				'filters' => view('Providers/applied_filters', $data, ['saveData' => false]),
				'sidebar'  => view('Providers/filter_sidebar', $data, ['saveData' => false]),
				'count'   => $data['result_count'],
			]);
		}
		return view('Providers/Providers', $data);
	}
	
	public function providers_list_old($location = null, $category = null)
    {	
	
		$data = array();
		$uri = current_url(true);
		$this->CityModel = new CityModel();
		$location_id = '';
		$location_name = '';
		if(!empty($_GET) && !empty($_GET['category'])){
			$category = $_GET['category'];
		}
		$this->UsersModel = new UsersModel();
		
		if($uri->getTotalSegments() >= env('urlsegment') && $uri->getSegment(env('urlsegment')) != 'all') {
			$locParts = explode('-', $uri->getSegment(env('urlsegment')));
			$num = count($locParts);
			if($num <= 1){
				//msgExit('r', RELATIVE);
			}
			$last = $num-1;
			$city = '';
			for($i=0; $i<$last; $i++){
				$city .= $locParts[$i].' ';
			}
			$city = ucwords(strtolower(trim($city)));
			$state = strtoupper(strtolower($locParts[$last]));
			$location_name = $uri->getSegment(env('urlsegment'));//$city.', '.$state;
			//$state_id = $this->CityModel->get_state_by_code($state);
			//$location_id_arr = $this->CityModel->get_cities_by_state_city($state_id[0]['id'],$city);
			$location_id_arr = $this->CityModel->get_id_by_zipcode($uri->getSegment(env('urlsegment')));
			$location_id = !empty($location_id_arr[0]['id']) ? $location_id_arr[0]['id'] : '';
			if(!empty($location_id_arr[0]['id'])){
				$query2 =  $this->UsersModel->db->query("UPDATE users SET zipcode_count = zipcode_count + 1 WHERE location_id = ".$location_id);
			}
			
			$user_latitude = !empty($this->session->get('user_latitude')) ? $this->session->get('user_latitude') : '';
			$user_longitude = !empty($this->session->get('user_longitude')) ? $this->session->get('user_longitude') : '';
			$user_zipcode = !empty($this->session->get('user_zipcode')) ? $this->session->get('user_zipcode') : '';
			if(!empty($location_id_arr[0]['id'])){
				
			$query2 =  $this->UsersModel->db->query("INSERT INTO website_stats (zipcode_count,zipcode_search,location_id,customer_lat,customer_long,customer_zipcode) VALUES (1,".$location_name.",".$location_id.",'".$user_latitude."','".$user_longitude."','".$user_zipcode."')");
			}
		}
		if($uri->getTotalSegments() >= env('urlsegment') && $uri->getSegment(env('urlsegment')) == 'all') {
			$location_id = 'all';
		}
		
		$location_url = '';
		if($uri->getTotalSegments() >= env('urlsegment')) {
			$location_url = $uri->getSegment(env('urlsegment'));
		}
		$radius = 1;
		if(!empty($this->request->getVar('radius'))){
			$radius = $this->request->getVar('radius');
		}
		//Get Categories List based on city state
        $this->CategoriesModel = new CategoriesModel();
		$data['categories_list'] = $this->CategoriesModel->get_categories();
		
		
		if(($location_id == 'all' && $category == 'all') || (empty($location_id) && empty($category)) ){
			$data['featured'] = $this->CityModel->get_categories3(null,$radius,'yes');
		}elseif(!empty($location_id) && !empty($category) && $location_id != 'all' && $category != 'all'){
			$data['featured'] = $this->CityModel->get_categories($location_id,$category,$radius,'yes');
		}else if((empty($location_id) || $location_id == 'all') && !empty($category) ){
			$data['featured'] = $this->CityModel->get_categories1($category,$radius,'yes');
		}else if(!empty($location_id) && (empty($category) || $category == 'all') ){
			$data['featured'] = $this->CityModel->get_categories2($location_id,$radius,'yes');
		}else{
			if(empty($location_id) && empty($category) && (array_key_exists("availableNow",$_GET) || array_key_exists("hasPhoto",$_GET) || array_key_exists("gender",$_GET) || array_key_exists("client_types",$_GET) || array_key_exists("offering",$_GET))){
				$data['featured'] = $this->CityModel->get_categories3(null,$radius,'yes');
			}
		}
		
		if(!empty($location_id) && !empty($category) && $location_id != 'all' && $category != 'all'){
			$data['categories'] = $this->CityModel->get_groomers($location_id,$category,$radius);
		}else if((empty($location_id) || $location_id == 'all') && !empty($category) && $uri->getTotalSegments() != env('urlsegment') ){
			$data['categories'] = $this->CityModel->get_groomers('all',$category,$radius);
		}else if(!empty($location_id) && (empty($category) || $category == 'all') && $uri->getTotalSegments() != env('urlsegment') ){
			$data['categories'] = $this->CityModel->get_groomers($location_id,$category,$radius);
		}else if($uri->getTotalSegments() == env('urlsegment') && $uri->getSegment(env('urlsegment')) != '' && $uri->getSegment(env('urlsegment')) == 'all'){
			$data['categories'] = $this->CityModel->get_groomers($location_id='all',$category,$radius);
		}else if($uri->getTotalSegments() == env('urlsegment') && $uri->getSegment(env('urlsegment')) != ''){
			$data['categories'] = $this->CityModel->get_groomers($location_id,$category,$radius);
		}else{
			if(empty($location_id) && empty($category) && (array_key_exists("availableNow",$_GET) || array_key_exists("hasPhoto",$_GET) || array_key_exists("gender",$_GET) || array_key_exists("client_types",$_GET) || array_key_exists("offering",$_GET))){
				
				$data['categories'] = $this->CityModel->get_groomers('all','all',$radius);
			}else{
				$data['categories'] = $this->CityModel->get_groomers('all','all',$radius);
			}
		}
		
		$data['search_location_name'] = $location_name;
		$data['search_location_url'] = $location_url;
		$data['search_location_id'] = ($location_id != 'all') ? $location_id : '';
		//echo "<pre>";print_r($data['categories']);exit;
        $this->ClientTypesModel = new ClientTypesModel();
		$data['client_types'] = $this->ClientTypesModel->get_client_types();		
		
		if(!empty($data['categories'])){
			$this->CategoriesSkillsModel = new CategoriesSkillsModel();
			$data['categories_skills'] = $this->CategoriesSkillsModel->get_categories_skills_by_category_id(1);
			$data['offering'] = array();//$this->OfferingModel->get_offering_category_based(1);
		}else{
			$data['categories_skills'] = array();
			$data['offering'] = array();
		}
		
		$data['title'] = trans('Plane Broker');
		$data['radius'] = $radius;
		
		$data['category'] = $category;
		
		
		$data['meta_title'] = !empty(get_seo('Plane Broker')) ? get_seo('Plane Broker')->meta_title : 'Plane Broker las vegas | Plane Broker in las vegas';
		$data['meta_desc'] = !empty(get_seo('Plane Broker')) ? get_seo('Plane Broker')->meta_description : "Find the perfect planes in Las Vegas with Plane Broker's extensive listings. From mobile to the best in town, we've got you covered!";
		$data['meta_keywords'] = !empty(get_seo('Plane Broker')) ? get_seo('Plane Broker')->meta_keywords : '';
		
		if((($uri->getTotalSegments() == 4 && $uri->getSegment(4) != '') ) || (!empty($_GET) && !empty($_GET['category']))){
			return view('Providers/Providers', $data);
			//return view('Providers/Categories', $data);
		}else{
			return view('Providers/Providers', $data);
		}
        
    }
		
	public function get_yelp_rating($business_name)
    {
		
		$postData = "grant_type=client_credentials&".
			"client_id=RuEp2gNE0nddVC-b_4RxSg&".  "client_secret=otOfV5r5nx1U031VhL2Di1sNrsnXUqLSxAW03LboB-xxbSUeSPSTeJ1hQy9TfqH0JrWrwtViZQoICzvkVIWR5JN3c_ylg1EZ0ZBVxKznVoJrJkQQqw97O1WmBYtTZXYx";

		// GET TOKEN
		$curl = curl_init();

		// GET RESTAURANT INFO
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.yelp.com/v3/businesses/".$business_name,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"authorization: Bearer LxVFc7T9FonMjyvbgU0Rr_-ZkDIpRHN-FeDIPsvGcl3yUnOpeowmoajAfDEbTRNZQ0op2ZrkjFHfVpqoRJQFkA4DUM6jxTbRUjFRQgcTM85bgUSXUQ70aFKOw_1MZXYx"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		//close connection
		curl_close($curl);

		if ($err) {
			//echo "cURL Error #:" . $err;
			return '';
		} else {
			$res = json_decode($response);
			if(!empty($res->rating)){
				return $res->rating;
			}else{
				return '';
			}
		}
		   
	}
	
	public function confirm_mail()
    {	
		$data = array(	
			'subject' => "Payment Confirmation",
			'to' => 'jamolphp24@gmail.com',
			'to_name'           => 'Rafael',
			'template_path' => "email/email_activation_reminder",
			'token' => ''	
		);
		$emailModel = new EmailModel();
		$emailModel->send_email($data);
		echo view("email/email_activation_reminder", $data);exit;
	}
	
	public function welcome_mail()
    {	
		$data = array(	
			'subject' => "Payment Confirmation",
			'to' => 'vadamalai@royalinkdesign.com',
			'to_name'           => 'vadamalai',
			'first_name' => 'Plane Broker',
			'business_name' => 'Plane Broker',
			'id' => '56',
			'fullname' => 'test',
			'template_path' => "email/email_confirmation",
			'token' => ''	
		);
		echo view("email/email_confirmation", $data);exit;
	}
	public function reminder_mail()
    {	
		$data = array(	
			'subject' => "Payment Confirmation",
			'to' => 'vadamalai@royalinkdesign.com',
			'to_name'           => 'vadamalai',
			'template_path' => "email/email_subscription_failed",
			'token' => ''	
		);
		echo view("email/email_subscription_failed", $data);exit;
	}
	
	
}
