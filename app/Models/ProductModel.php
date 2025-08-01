<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['status'];

    // Custom 
    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
    }
	
	public function get_filters($category='all',$where=''){
		$category_detail = $this->db->query("SELECT id, name,skill_name,permalink FROM categories WHERE permalink LIKE '".$category."' ORDER BY name ASC", 'r')->getRowArray();
		$result = $this->db->query("SELECT id,name,filter_type,LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, '/', '_'), ' ', '_'), '-', '_'), '(', '_'), ')', '_'), '&', '_')) as slug FROM `fields` f LEFT JOIN field_categories c ON c.field_id=f.id WHERE c.category_id = ".$category_detail['id']." and f.is_filter = 1 group by name order by f.filter_order asc")->getResultArray();
		$filters = array();
		if(!empty($result)){
			foreach($result as $filter){
				$values = array();
				if($filter['filter_type'] == 'checkbox'){
					$values = $this->db->query("SELECT field_value as name, field_id as id, product_id FROM `products_dynamic_fields` where field_id in (SELECT id FROM `fields` where name='".$filter['name']."') and product_id in (SELECT id FROM `products` where category_id = (select id from categories where permalink='".$category."')) group by field_value")->getResultArray();
				}
				$filter['values'] = $values;
				$filters[] = $filter;				
			}
		}
		
		return $filters;	
	}
	
    public function productPaginate()
{
    $request = service('request');
    $show = $request->getGet('show') ?? 25;

    $builder = $this->db->table('products p');
    $builder->select("
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
        ) as price
    ");
    $builder->join('categories c', 'c.id = p.category_id', 'left');
    $builder->join('categories_sub sc', 'sc.id = p.sub_category_id', 'left');
    $builder->join('users u', 'u.id = p.user_id', 'left');
    $builder->join('plans pl', 'pl.id = p.plan_id', 'left');
    $builder->join('sales s', 's.id = p.sale_id', 'left');

    if (!empty($where)) {
        $builder->where($where); // ensure $where is an associative array or valid condition
    }
	
	$status = trim($request->getGet('status') ?? '');
	if ($status != null && ($status == 1 || $status == 0)) {
		$builder->where('p.status', clean_number($status));
	}
	
	$is_cancel = trim($request->getGet('is_cancel') ?? '');
	if ($is_cancel != null && ($is_cancel == 1 || $is_cancel == 0)) {
		$builder->where('p.is_cancel', clean_number($is_cancel));
	}
	
	$plan_id = trim($request->getGet('plan_id') ?? '');
	if ($plan_id != null && $plan_id > 0) {
		$builder->where('p.plan_id', clean_number($plan_id));
	}
	
	$user_id = trim($request->getGet('user_id') ?? '');
	if ($user_id != null && $user_id > 0) {
		$builder->where('p.user_id', clean_number($user_id));
	}
	
	$created_at_start = trim($request->getGet('created_at_start') ?? '');
	$created_at_end = trim($request->getGet('created_at_end') ?? '');
	if ($created_at_start != null && $created_at_end != null && ($created_at_start != '' && $created_at_end != '')) {
		$builder->where("DATE(p.created_at) >=", $created_at_start)
				->where("DATE(p.created_at) <=", $created_at_end);
	}
	$builder->orderBy('p.id','DESC');
    $pager = \Config\Services::pager();
    $result = $builder->get()->getResultArray(); // You cannot paginate here directly

    // Manual Pagination (less flexible):
    $page = (int) $request->getGet('page') ?? 1;
    $offset = ($page - 1) * $show;
    $total = count($result);
    $pagedData = array_slice($result, $offset, $show);
    return [
        'users'       => $pagedData,
        'pager' => $pager,
        'per_page_no' => $show,
        'total'       => $total
    ];
	
}
	public function get_products($category='all',$where='',$orderby='p.is_cancel ASC,p.status DESC,p.plan_id DESC'){
		
		if($category == 'all'){
			$products = $this->db->query("SELECT p.*,pl.is_premium_listing,pl.name as package_name,pl.price as package_price,u.fullname,c.name as category_name,sc.name as sub_category_name,c.permalink,s.admin_plan_update,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR ' ') AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = 'title') t ON t.field_id = pd.field_id WHERE pd.product_id = p.id) as display_name, (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT fi.id FROM `fields` fi  join field_categories fc on fc.field_id=fi.id where fi.name = 'price' and fc.category_id=p.category_id LIMIT 1)LIMIT 1) as price, (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT fi.id FROM `fields` fi  join field_categories fc on fc.field_id=fi.id where fi.name = 'Aircraft Status' and fc.category_id=p.category_id LIMIT 1)LIMIT 1) as aircraft_status, (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` where name = 'Price Notes ex. OBO, FIRM, MAKE AN OFFER, etc.' LIMIT 1)LIMIT 1) as price_notes FROM products p LEFT JOIN categories c ON c.id=p.category_id LEFT JOIN categories_sub sc ON sc.id=p.sub_category_id LEFT JOIN users u ON u.id=p.user_id left join plans pl on pl.id = p.plan_id left join sales s on s.product_id=p.id  WHERE p.id > 0 ".$where." order by ".$orderby." ")->getResultArray();
		}else{
			$category_detail = $this->db->query("SELECT id, name,skill_name,permalink FROM categories WHERE permalink LIKE '".$category."' ORDER BY name ASC", 'r')->getRowArray();
			$products = $this->db->query("SELECT p.*,pl.is_premium_listing,pl.name as package_name,pl.price as package_price,u.fullname,c.name as category_name,sc.name as sub_category_name,c.permalink,s.admin_plan_update,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR ' ') AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.category_id = ".$category_detail['id']." and t.title_type = 'title') t ON t.field_id = pd.field_id WHERE pd.product_id = p.id) as display_name, (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT fi.id FROM `fields` fi  join field_categories fc on fc.field_id=fi.id where fi.name = 'price' and fc.category_id=p.category_id LIMIT 1) LIMIT 1) as price,(SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT fi.id FROM `fields` fi  join field_categories fc on fc.field_id=fi.id where fi.name = 'Aircraft Status' and fc.category_id=p.category_id LIMIT 1)LIMIT 1) as aircraft_status, (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` where name = 'Price Notes ex. OBO, FIRM, MAKE AN OFFER, etc.' LIMIT 1)LIMIT 1) as price_notes FROM products p LEFT JOIN categories c ON c.id=p.category_id LEFT JOIN categories_sub sc ON sc.id=p.sub_category_id LEFT JOIN users u ON u.id=p.user_id left join plans pl on pl.id = p.plan_id left join sales s on s.product_id=p.id  WHERE p.category_id = ".$category_detail['id']." ".$where." order by ".$orderby."")->getResultArray();
		}
		
		//echo $this->db->getLastQuery();exit;
		$providers = array();
		if(!empty($products)){
			foreach($products as $product){
				$pic = $this->db->query("SELECT file_name FROM user_images WHERE product_id='".$product['id']."' ORDER BY file_type,`order` ASC LIMIT 1", 'a')->getRowArray();
				 
				if(empty($pic['file_name'])){ 
					$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
				}else{
					$pic['file_name'] = base_url().'/uploads/userimages/'.$product['user_id'].'/'.$pic['file_name'];
				}
				
				$providers[] = array(
					'image' => $pic['file_name'],
					'id' => $product['id'],
					'name' => $product['display_name'],
					'user_name' => $product['fullname'],					
					'business_name' => $product['business_name'],
					'price' => ($product['price'] != NULL) ? (float)preg_replace('/[^\d.]/', '', $product['price']) : 0,
					'cat_name' => $product['category_name'],
					'cat_id' => $product['category_id'],
					'sub_cat_name' => $product['sub_category_name'],
					'permalink' => $product['permalink'],
					'city' => $product['city'],
					'state_code' => $product['state'],
					'zipcode' => $product['zipcode'],
					'clean_url' => $product['clean_url'],
					'avatar' => '',
					'user_id' => $product['user_id'],
					'plan_id' => $product['plan_id'],
					'sale_id' => $product['sale_id'],
					'status' => $product['status'],
					'is_premium_listing' => $product['is_premium_listing'],
					'package_name' => $product['package_name'],
					'package_price' => $product['package_price'],
					'address' =>$product['address'],
					'phone' =>$product['phone'],
					'is_cancel' =>$product['is_cancel'],
					'wishlist_added' => !empty($this->session->get('vr_sess_user_id')) ? $this->wishlist_check($this->session->get('vr_sess_user_id'),$product['id']) : 0,
					'aircraft_status' => check_aircraft_status($product['id']),
					'admin_plan_update' => $product['admin_plan_update'],
					'price_notes' => $product['price_notes']
				);
				
			}
		}
			
		
		//echo "<pre>";print_r($providers);exit;
		return $providers;
	}
		
	public function wishlist_check($user_id,$product_id){
		$wishlist = $this->db->query('SELECT count(*) fav_count FROM `user_favorites` where user_id = '.$user_id.' AND product_id = "'.$product_id.'" ')->getRow();
		return !empty($wishlist->fav_count) ? $wishlist : 0;
		
	}
	
	public function get_manufacturers($category){
		//$manufacturers = $this->db->query("SELECT field_value as name, field_id as id, product_id FROM `products_dynamic_fields` where field_id in (SELECT id FROM `fields` where name='manufacturer') and product_id in (SELECT id FROM `products` where category_id = (select id from categories where permalink='".$category."')) group by field_value")->getResult();
		$manufacturers = $this->db->query("select field_options from fields where id in (SELECT f.id FROM `fields` f join field_categories c on f.id=c.field_id where f.name='manufacturer' and c.category_id IN (select id from categories where permalink='".$category."'))")->getResult();
		$man = [];
		if(!empty($manufacturers[0]->field_options)){
			$mm = json_decode($manufacturers[0]->field_options,true);
			foreach($mm as $op){
				$man[] = array('name' => $op);
			}
		}
		return json_decode(json_encode($man));
		
	}
	
	public function get_models($category){
		$manufacturers = $this->db->query("SELECT field_value as name, field_id as id, product_id FROM `products_dynamic_fields` where field_id in (SELECT id FROM `fields` where name like '%model%') and product_id in (SELECT id FROM `products` where category_id = (select id from categories where permalink='".$category."')) group by field_value")->getResult();
		return $manufacturers;
		
	}
		
	public function title_fields($category,$title_type = 'title',$productId=''){
		$category_detail = $this->db->query("SELECT id, name,skill_name,permalink FROM categories WHERE permalink LIKE '".$category."' ORDER BY name ASC", 'r')->getRowArray();
		if(!empty($productId)){
			$title_fields = $this->db->query("SELECT p.field_value as field_value, p.field_id as id, p.product_id,f.name as field_name FROM `products_dynamic_fields` p left join fields f on f.id = p.field_id where product_id = ".$productId." and p.field_id = (SELECT t.field_id FROM `title_fields` t left join fields f on f.id = t.field_id where t.category_id=".$category_detail['id']." and t.title_type ='".$title_type."')")->getRow();
		}else{
			$title_fields = $this->db->query("SELECT t.field_id,f.name FROM `title_fields` t left join fields f on f.id = t.field_id where t.category_id=".$category_detail['id']." and t.title_type = ".$title_type)->getResult();
		}
		
		return $title_fields;
	}
	
	public function get_product_dynamic_fields($category,$product_id){
		$category_detail = $this->db->query("SELECT id, name,skill_name,permalink FROM categories WHERE permalink LIKE '".$category."' ORDER BY name ASC", 'r')->getRowArray();
		$values = $this->db->query("		
		SELECT p.field_value as name, p.field_id as id,p.file_field_title, p.product_id,f.name as field_name,fg.fields_group_id,g.name as group_name,f.field_type,f.frontend_show,pd.sub_category_id FROM `products_dynamic_fields` p left join fields f on f.id = p.field_id left join field_groups fg on fg.field_id = f.id left join fields_group g on g.id = fg.fields_group_id left join products pd on p.product_id=pd.id left join field_sub_categories fs on fs.sub_category_id=pd.sub_category_id where product_id = ".$product_id." and NOT EXISTS (
          SELECT 1
          FROM   title_fields t
          WHERE  t.field_id   = p.field_id
            AND  t.category_id = ".$category_detail['id']."
            AND  t.title_type  = 'description'
        ) and fs.sub_category_id = pd.sub_category_id and p.field_value != '' group by f.id,p.field_value order by g.sort_order,f.field_order;
		")->getResultArray();
		$fields = array();
		if(!empty($values)){
			foreach($values as $value){
				if($value['field_name'] == 'Price'){
					$value['name'] = ($value['name'] != NULL) ? 'USD $'.number_format((float)preg_replace('/[^\d.]/', '', $value['name']), 2, '.', ',') : 0;
				}
				$fields[$value['group_name']][] = $value;				
			}
		}
		return $fields;
	}
	
	public function delete_product($id)
    {
        return $this->delete($id);
    }
	public function product_status_change($id,$status){
		return $this->delete($id);
	}
	
	
	public function get_product_detail($where=''){		
		
		$product_detail = $this->db->query("SELECT p.*,u.fullname,c.name as category_name,sc.name as sub_category_name,c.permalink,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR ' ') AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = 'title') t ON t.field_id = pd.field_id WHERE pd.product_id = p.id) as display_name, (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT fi.id FROM `fields` fi  join field_categories fc on fc.field_id=fi.id where fi.name = 'price' and fc.category_id=p.category_id LIMIT 1)  limit 1) as price, (SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` where name = 'Price Notes ex. OBO, FIRM, MAKE AN OFFER, etc.' limit 1)  limit 1) as price_notes FROM products p LEFT JOIN categories c ON c.id=p.category_id LEFT JOIN categories_sub sc ON sc.id=p.sub_category_id LEFT JOIN users u ON u.id=p.user_id WHERE p.id >= 1 ".$where."")->getRowArray();
		
		$product_detail['price'] = ($product_detail['price'] != NULL) ? (float)preg_replace('/[^\d.]/', '', $product_detail['price']) : 0;
		
		return $product_detail;
	}
}
