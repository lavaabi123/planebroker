<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $allowedFields = [];

    // Custom 
    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
    }

	public function get_products($category='all',$where=''){
		
		
		$category_detail = $this->db->query("SELECT id, name,skill_name,permalink FROM categories WHERE permalink LIKE '".$category."' ORDER BY name ASC", 'r')->getRowArray();
		
		
		$products = $this->db->query("SELECT p.*,c.name as category_name,sc.name as sub_category_name,c.permalink,(SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` where name = 'year')) as year,(SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` where name = 'manufacturer')) as manufacturer,(SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` where name = 'Make/Model')) as model,(SELECT field_value FROM `products_dynamic_fields` where product_id = p.id and field_id = (SELECT id FROM `fields` where name = 'price')) as price FROM products p LEFT JOIN categories c ON c.id=p.category_id LEFT JOIN categories_sub sc ON sc.id=p.sub_category_id WHERE p.category_id = ".$category_detail['id']." ".$where." ")->getResultArray();
		$providers = array();
		if(!empty($products)){
			foreach($products as $product){
				$pic = $this->db->query("SELECT file_name FROM user_images WHERE product_id='".$product['id']."' ORDER BY `order` ASC LIMIT 1", 'a')->getRowArray();
				 
				if(empty($pic['file_name'])){ 
					$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
				}else{
					$pic['file_name'] = base_url().'/uploads/userimages/'.$product['user_id'].'/'.$pic['file_name'];
				}
				$display_name = '';
				if($category == 'aircraft-for-sale' && (!empty($product['year']) || !empty($product['manufacturer']) || !empty($product['model']))){
					$display_name = $product['year'].' '.$product['manufacturer'].' '.$product['model'];
				}
				
				$providers[] = array(
					'image' => $pic['file_name'],
					'id' => $product['id'],
					'name' => $display_name,
					'business_name' => $product['business_name'],
					'price' => $product['price'],
					'cat_name' => $product['category_name'],
					'sub_cat_name' => $product['sub_category_name'],
					'permalink' => $product['permalink'],
					'city' => $product['city'],
					'state_code' => $product['state'],
					'zipcode' => $product['zipcode'],
					'clean_url' => $product['clean_url'],
					'avatar' => '',
				);
				
				//$query3 =  $this->db->query("UPDATE users SET impression_count = impression_count + 1 WHERE id = ".$user['u_id']);
				//$user_latitude = !empty($this->session->get('user_latitude')) ? $this->session->get('user_latitude') : '';
				//$user_longitude = !empty($this->session->get('user_longitude')) ? $this->session->get('user_longitude') : '';
				//$user_zipcode = !empty($this->session->get('user_zipcode')) ? $this->session->get('user_zipcode') : '';
				//$query2 =  $this->db->query("INSERT INTO website_stats (user_id,impression_count,customer_lat,customer_long,customer_zipcode) VALUES (".$user['u_id'].",1,'".$user_latitude."','".$user_longitude."','".$user_zipcode."')");
			}
		}
			
		
		//echo "<pre>";print_r($providers);exit;
		return $providers;
	}
	
}
