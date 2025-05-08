<?php

namespace App\Models\Locations;

use CodeIgniter\Model;

class CityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'zipcodes';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['city', 'zipcode','lat','long', 'county_id', 'state_id'];

    // Custom 
    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
    }

    public function DataPaginations()
    {

        $show = 15;
        if ($this->request->getGet('show')) {
            $show = $this->request->getGet('show');
        }

        $paginateData = $this->select('zipcodes.*, county.name as county_name, states.name as state_name')
            ->join('county', 'zipcodes.county_id = county.id')
            ->join('states', 'zipcodes.state_id = states.id')
            ->orderBy('zipcodes.id', 'ASC');;

        $county = trim($this->request->getGet('county') ?? '');
        if ($county > 0) {
            $this->builder()->where('zipcodes.county_id', clean_number($county));
        }

        $state = trim($this->request->getGet('state') ?? '');
        if ($state > 0) {
            $this->builder()->where('zipcodes.state_id', clean_number($state));
        }
        
        $search = trim($this->request->getGet('search') ?? '') ?: trim($this->request->getGet('q') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('zipcodes.city', clean_str($search))
                ->orLike('zipcodes.zipcode', clean_str($search))
                ->groupEnd();
        }

        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'city'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }

    public function get_cities($param,$from)
    {
		if($from == 'home'){
			return $this->asObject()->select('zipcodes.*, county.name as county_name, states.name as state_name, states.code as state_code')->join('county', 'zipcodes.county_id = county.id')->join('states', 'zipcodes.state_id = states.id')->like('zipcodes.city', clean_str($param), 'after')->orLike('zipcodes.zipcode', $param, 'both')->orLike('states.code', $param, 'after')->orLike('states.name', $param, 'after')->orderBy('zipcodes.city', 'ASC')->groupBy(array('zipcodes.city', "state_code"))->findAll();
		}else{
			return $this->asObject()->select('zipcodes.*, county.name as county_name, states.name as state_name, states.code as state_code')->join('county', 'zipcodes.county_id = county.id')->join('states', 'zipcodes.state_id = states.id')->like('zipcodes.city', clean_str($param), 'after')->orLike('zipcodes.zipcode', $param, 'both')->orLike('states.code', $param, 'after')->orLike('states.name', $param, 'after')->orderBy('zipcodes.city', 'ASC')->findAll();
		}
         
		 //echo $this->db->getLastQuery(); die;
        
    }
	
    //add city
    public function add_city()
    {
        $data = array(
            'city' => $this->request->getVar('city'),
            'zipcode' => $this->request->getVar('zipcode'),
            'lat' => $this->request->getVar('lat'),
            'long' => $this->request->getVar('long'),
            'county_id' => $this->request->getVar('county_id'),
            'state_id' => $this->request->getVar('state_id')
        );

        return $this->insert($data);
    }

    //update city
    public function update_city($id)
    {
        $data = array(
            'city' => $this->request->getVar('city'),
            'zipcode' => $this->request->getVar('zipcode'),
            'lat' => $this->request->getVar('lat'),
            'long' => $this->request->getVar('long'),
            'county_id' => $this->request->getVar('county_id'),
            'state_id' => $this->request->getVar('state_id')
        );


        return $this->update($id, $data);
    }

    //get cities by state
    public function get_cities_by_state($state_id)
    {
        return $this->asObject()->where('state_id', clean_number($state_id))->findAll();
    }
	//get cities by id
    public function get_cities_by_id($id)
    {
        return $this->asObject()->where('id', clean_number($id))->find();
    }
	
	public function get_state_by_code($state_code)
    {
        return $this->select('states.id')->from('states')->where('states.code', $state_code)->find();
    }
    public function get_cities_by_state_city($state_id,$city_name)
    {
        return $this->where('city',$city_name)->where('state_id', clean_number($state_id))->find();
    }
    public function get_id_by_zipcode($zipcode)
    {
        return $this->where('zipcode',clean_number($zipcode))->find();
    }
    //delete county
    public function delete_city($id)
    {
        $id = clean_number($id);
        $city = $this->asObject()->find($id);
        if (!empty($city)) {
            return $this->delete($city->id);
        }
        return false;
    }
	public function get_groomers($location_id='all',$category='all',$radius=1,$featured=''){
		
		if($location_id != 'all'){
			$lat_long = $this->asObject()->where('id', clean_number($location_id))->find();
		}
		if(!empty($lat_long) || $location_id == 'all'){
			if($location_id != 'all'){
				$zipcode_ids = $this->get_nearest_zipcodes($lat_long[0]->lat,$lat_long[0]->long,$radius)['zipcode_ids'];
			}		
		$categories = array();
		$limit = '';
		if($category == null || $category == 'all'){
			$limit = 'LIMIT 0,10';
			$types = $this->db->query("SELECT id, name,skill_name,permalink FROM categories ORDER BY name ASC", 'r')->getResultArray();
		}else{
			$limit = '';
			$types = $this->db->query("SELECT id, name,skill_name,permalink FROM categories WHERE permalink LIKE '".$category."' ORDER BY name ASC", 'r')->getResultArray();
		}
		//echo $this->db->getLastQuery()->getQuery();exit;
		$cli_array = array();
		foreach($_GET as $k1=>$v1){
			$k1 = explode('_', $k1);
			if(!empty($k1[0]) && $k1[0] == 'client-types'){
				$cli_array[] = $k1[1];					
			}
		}
		
			$providers = array();
			if($location_id != 'all'){
				if(!in_array(1,$cli_array)){
					$sql = "(location_id IN ($zipcode_ids)  OR ( 3959 * acos( cos( radians(".$lat_long[0]->lat.") ) * cos( radians( u.city_lat ) ) * cos( radians( u.city_lng ) - radians(".$lat_long[0]->long.") ) + sin( radians(".$lat_long[0]->lat.") ) * sin( radians( u.city_lat ) ) ) ) <= u.miles) AND u.status='1'";
				}else{
					$sql = "location_id IN ($zipcode_ids) AND u.status='1'";
				}
			}else{
				$sql = " u.status='1'";
			}
			$sql .= " AND u.email_status = 1 AND u.deleted_at IS NULL ";
			$joins = '';
			
			if(!empty($_GET['male']) && empty($_GET['female'])){
				$sql .= " AND u.gender='Male'";
			}elseif(empty($_GET['male']) && !empty($_GET['female'])){
				$sql .= " AND u.gender='Female'";
			}elseif(!empty($_GET['male']) && !empty($_GET['female'])){
				$sql .= " AND (u.gender='Female' OR u.gender='Male')";
			}			

			$cl_array = array();
			foreach($_GET as $k=>$v){
				$k = explode('_', $k);
				if(!empty($k[0]) && $k[0] == 'skill'){
					$skills[] = $k[1];
					$sql .= ' AND JSON_SEARCH(u.categories_skills,"one", "'.$k[1].'") IS NOT NULL';
				}
				if(!empty($k[0]) && $k[0] == 'client-types'){
					$cl_array[] = $k[1];					
				}
				if(!empty($k[0]) && $k[0] == 'offering'){
					$sql .= ' AND (JSON_SEARCH(u.offering,"one", "'.$k[1].'") IS NOT NULL OR JSON_SEARCH(u.offering,"one", "3") IS NOT NULL)';
				}
			}
			
			if(!empty($cl_array)){
				$sql .= ' AND (';
				foreach($cl_array as $cl){
					$sql .= ' JSON_SEARCH(u.clientele,"one", "'.$cl.'") IS NOT NULL OR ';
				}
				$sql .= ' JSON_SEARCH(u.clientele,"one", "3") IS NOT NULL ) ';
			}
			
			if(!empty($featured)){
				$sql .= ' AND u.plan_id = 3';				
			}else{
				$sql .= ' AND u.plan_id != 1';	
			}
			
			if(!empty($_GET['availableNow'])){
				$joins .= " INNER JOIN hours_of_operation as h ON u.id = h.user_id AND weekday='".date("N")."' AND closed_all_day='0' AND opens_at <= '".date("H:i")."' AND closes_at > '".date("H:i")."'";
			}

			if(!empty($_GET['hasPhoto'])){
				$joins .= " INNER JOIN user_images as p ON u.id=p.user_id";
			}
			
			$orders = array('created_at', 'location_id', 'name');
			$order = !empty($_GET['order']) && in_array($_GET['order'], $orders) ? 'u.'.$_GET['order']:'u.created_at';
			if($order == 'u.name'){ $order = 'name'; $dir = 'asc'; }elseif($order == 'u.created_at'){ $dir = 'desc'; }else{ $dir = 'asc'; }

			//echo $sql;echo $joins;exit;
			$get = $this->db->query("SELECT 
							t.id, t.name as cat_name,z.city,z.zipcode,
							u.fullname as name,u.business_name,u.clean_url,s.code as state_code,t.permalink,
							u.id as u_id, u.gender,u.avatar
							FROM categories as t
							LEFT OUTER JOIN users as u ON t.id = u.category_id 
							LEFT OUTER JOIN zipcodes as z ON z.id = u.location_id 
							LEFT OUTER JOIN states as s ON s.id = z.state_id 
							$joins
							WHERE $sql  GROUP BY u.id
							ORDER BY u.plan_id DESC, $order $dir
							 $limit", 'r')->getResultArray();
			//echo $this->db->getLastQuery()->getQuery();exit;							 
			$total = $this->db->query("SELECT u.id FROM users u $joins WHERE $sql GROUP BY u.id", 'n')->getResultArray();
			//echo $this->db->getLastQuery()->getQuery();exit;		
			if(count($total) > 0){
				$found = true;
				if(!empty($get)){
					foreach($get as $user){
						$pic = $this->db->query("SELECT file_name FROM user_images WHERE user_id='".$user['u_id']."' ORDER BY `order` ASC LIMIT 1", 'a')->getRowArray();
                        if(!empty($user['avatar'])){ 
					$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$user['avatar'];
				}else{ if(empty($pic['file_name'])){ 
						if($user['gender'] == 'Female'){
							$pic['file_name'] = base_url().'/assets/frontend/images/female_user.png';
						}else{
							$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
						}							 
						}else{
							$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$pic['file_name'];
					}}
						$providers[] = array(
							'image' => $pic['file_name'],
							'id' => $user['u_id'],
							'name' => $user['name'],
							'business_name' => $user['business_name'],
							'cat_name' => $user['cat_name'],
							'permalink' => $user['permalink'],
							'city' => $user['city'],
							'state_code' => $user['state_code'],
							'zipcode' => $user['zipcode'],
							'clean_url' => $user['clean_url'],
							'avatar' => $user['avatar'],
						);
						
						$query3 =  $this->db->query("UPDATE users SET impression_count = impression_count + 1 WHERE id = ".$user['u_id']);
						$user_latitude = !empty($this->session->get('user_latitude')) ? $this->session->get('user_latitude') : '';
						$user_longitude = !empty($this->session->get('user_longitude')) ? $this->session->get('user_longitude') : '';
						$user_zipcode = !empty($this->session->get('user_zipcode')) ? $this->session->get('user_zipcode') : '';
						$query2 =  $this->db->query("INSERT INTO website_stats (user_id,impression_count,customer_lat,customer_long,customer_zipcode) VALUES (".$user['u_id'].",1,'".$user_latitude."','".$user_longitude."','".$user_zipcode."')");
					}
				}
			}
		
		//echo "<pre>";print_r($providers);exit;
		return $providers;
		}else{
			return array();
		}
	}
	
	public function get_categories($location_id='all',$category='all',$radius=1,$featured=''){
		
		if($location_id != 'all'){
			$lat_long = $this->asObject()->where('id', clean_number($location_id))->find();
		}
		if(!empty($lat_long) || $location_id == 'all'){
			if($location_id != 'all'){
				$zipcode_ids = $this->get_nearest_zipcodes($lat_long[0]->lat,$lat_long[0]->long,$radius)['zipcode_ids'];
			}		
		$categories = array();
		$limit = '';
		if($category == null || $category == 'all'){
			$limit = 'LIMIT 0,10';
			$types = $this->db->query("SELECT id, name,skill_name,permalink FROM categories ORDER BY name ASC", 'r')->getResultArray();
		}else{
			$limit = '';
			$types = $this->db->query("SELECT id, name,skill_name,permalink FROM categories WHERE permalink LIKE '".$category."' ORDER BY name ASC", 'r')->getResultArray();
		}
		$cli_array = array();
		foreach($_GET as $k1=>$v1){
			$k1 = explode('_', $k1);
			if(!empty($k1[0]) && $k1[0] == 'client-types'){
				$cli_array[] = $k1[1];					
			}
		}
		//echo $this->db->getLastQuery()->getQuery();exit;
		foreach($types as $row){ 
			$providers = array();
			if($location_id != 'all'){
				
				if(!in_array(1,$cli_array)){
					$sql = "(location_id IN ($zipcode_ids)  OR ( 3959 * acos( cos( radians(".$lat_long[0]->lat.") ) * cos( radians( u.city_lat ) ) * cos( radians( u.city_lng ) - radians(".$lat_long[0]->long.") ) + sin( radians(".$lat_long[0]->lat.") ) * sin( radians( u.city_lat ) ) ) ) <= u.miles) AND u.status='1'";
				}else{
					$sql = "location_id IN ($zipcode_ids) AND u.status='1'";
				}
				
			}else{
				$sql = "category_id='".$row['id']."' AND u.status='1'";
			}
			$sql .= " AND u.email_status = 1 AND u.deleted_at IS NULL ";
			$joins = '';
			
			if(!empty($_GET['male']) && empty($_GET['female'])){
				$sql .= " AND u.gender='Male'";
			}elseif(empty($_GET['male']) && !empty($_GET['female'])){
				$sql .= " AND u.gender='Female'";
			}elseif(!empty($_GET['male']) && !empty($_GET['female'])){
				$sql .= " AND (u.gender='Female' OR u.gender='Male')";
			}			

			
			foreach($_GET as $k=>$v){
				$k = explode('_', $k);
				if(!empty($k[0]) && $k[0] == 'skill'){
					$skills[] = $k[1];
					$sql .= ' AND JSON_SEARCH(u.categories_skills,"one", "'.$k[1].'") IS NOT NULL';
				}
				if(!empty($k[0]) && $k[0] == 'client-types'){
					$sql .= ' AND (JSON_SEARCH(u.clientele,"one", "'.$k[1].'") IS NOT NULL OR JSON_SEARCH(u.clientele,"one", "3") IS NOT NULL)';
				}
				if(!empty($k[0]) && $k[0] == 'offering'){
					$sql .= ' AND (JSON_SEARCH(u.offering,"one", "'.$k[1].'") IS NOT NULL OR JSON_SEARCH(u.offering,"one", "3") IS NOT NULL)';
				}
			}
			if(!empty($featured)){
				$sql .= ' AND u.plan_id = 3';				
			}else{
				$sql .= ' AND u.plan_id != 1';	
			}
			
			if(!empty($_GET['availableNow'])){
				$joins .= " INNER JOIN hours_of_operation as h ON u.id = h.user_id AND weekday='".date("N")."' AND closed_all_day='0' AND opens_at <= '".date("H:i")."' AND closes_at > '".date("H:i")."'";
			}

			if(!empty($_GET['hasPhoto'])){
				$joins .= " INNER JOIN user_images as p ON u.id=p.user_id";
			}
			
			$orders = array('created_at', 'location_id', 'name');
			$order = !empty($_GET['order']) && in_array($_GET['order'], $orders) ? 'u.'.$_GET['order']:'u.created_at';
			if($order == 'u.name'){ $order = 'name'; $dir = 'asc'; }elseif($order == 'u.created_at'){ $dir = 'desc'; }else{ $dir = 'asc'; }

			//echo $sql;echo $joins;exit;
			$get = $this->db->query("SELECT 
							t.id, t.name as cat_name,z.city,z.zipcode,
							u.business_name,u.clean_url, u.fullname as name,s.code as state_code,t.permalink,
							u.id as u_id, u.gender,u.avatar
							FROM categories as t
							LEFT OUTER JOIN users as u ON t.id = u.category_id 
							LEFT OUTER JOIN zipcodes as z ON z.id = u.location_id 
							LEFT OUTER JOIN states as s ON s.id = z.state_id 
							$joins
							WHERE $sql  GROUP BY u.id
							ORDER BY u.plan_id DESC, $order $dir
							 $limit", 'r')->getResultArray();
//echo $this->db->getLastQuery()->getQuery();exit;							 
			$total = $this->db->query("SELECT u.id FROM users u $joins WHERE $sql GROUP BY u.id", 'n')->getResultArray();
			//echo $this->db->getLastQuery()->getQuery();exit;		
			if(count($total) > 0){
				$found = true;
				if(!empty($get)){
					foreach($get as $user){
						$pic = $this->db->query("SELECT file_name FROM user_images WHERE user_id='".$user['u_id']."' ORDER BY `order` ASC LIMIT 1", 'a')->getRowArray();
                        if(!empty($user['avatar'])){ 
					$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$user['avatar'];
				}else{ if(empty($pic['file_name'])){ 
						if($user['gender'] == 'Female'){
							$pic['file_name'] = base_url().'/assets/frontend/images/female_user.png';
						}else{
							$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
						}							 
						}else{
							$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$pic['file_name'];
						}
				}
						$providers[] = array(
							'image' => $pic['file_name'],
							'id' => $user['u_id'],
							'name' => $user['name'],
							'business_name' => $user['business_name'],
							'cat_name' => $user['cat_name'],
							'permalink' => $user['permalink'],
							'city' => $user['city'],
							'state_code' => $user['state_code'],
							'zipcode' => $user['zipcode'],
							'clean_url' => $user['clean_url'],
							'avatar' => $user['avatar'],
						);
					}
				}
			}
				$categories[] = array(
					'id' => $row['id'],
					'name' => $row['name'],
					'skill_name' => $row['skill_name'],
					'permalink' => $row['permalink'],
					'total_users' => count($total),
					'providers' => $providers
				);
		}
		echo "<pre>";print_r($categories);exit;
		return $categories;
		}else{
			return array();
		}
	}
	public function get_categories2($location_id,$radius=1,$featured=''){
		
		
		$lat_long = $this->asObject()->where('id', clean_number($location_id))->find();
		if(!empty($lat_long)){
		$zipcode_ids = $this->get_nearest_zipcodes($lat_long[0]->lat,$lat_long[0]->long,$radius)['zipcode_ids'];
		$categories = array();
		$limit = '';
			$providers = array();
			$sql = "(location_id IN ($zipcode_ids) OR ( 3959 * acos( cos( radians(".$lat_long[0]->lat.") ) * cos( radians( u.city_lat ) ) * cos( radians( u.city_lng ) - radians(".$lat_long[0]->long.") ) + sin( radians(".$lat_long[0]->lat.") ) * sin( radians( u.city_lat ) ) ) ) <= u.miles) AND u.status='1'";
			$joins = '';
			
			if(!empty($_GET['male']) && empty($_GET['female'])){
				$sql .= " AND u.gender='Male'";
			}elseif(empty($_GET['male']) && !empty($_GET['female'])){
				$sql .= " AND u.gender='Female'";
			}elseif(!empty($_GET['male']) && !empty($_GET['female'])){
				$sql .= " AND (u.gender='Female' OR u.gender='Male')";
			}
			
			$sql .= " AND u.email_status = 1  AND u.deleted_at IS NULL ";
			

			foreach($_GET as $k=>$v){
				$k = explode('_', $k);
				if(!empty($k[0]) && $k[0] == 'skill'){
					$skills[] = $k[1];
					$sql .= ' AND JSON_SEARCH(u.categories_skills,"one", "'.$k[1].'") IS NOT NULL';
				}
				if(!empty($k[0]) && $k[0] == 'client-types'){
					$sql .= ' AND (JSON_SEARCH(u.clientele,"one", "'.$k[1].'") IS NOT NULL OR JSON_SEARCH(u.clientele,"one", "3") IS NOT NULL)';
				}
				if(!empty($k[0]) && $k[0] == 'offering'){
					$sql .= ' AND (JSON_SEARCH(u.offering,"one", "'.$k[1].'") IS NOT NULL OR JSON_SEARCH(u.offering,"one", "3") IS NOT NULL)';
				}
			}
			if(!empty($featured)){
				$sql .= ' AND u.plan_id = 3';				
			}else{
				$sql .= ' AND u.plan_id != 1';	
			}
			
			if(!empty($_GET['availableNow'])){
				$joins .= " INNER JOIN hours_of_operation as h ON u.id = h.user_id AND weekday='".date("N")."' AND closed_all_day='0' AND opens_at <= '".date("H:i")."' AND closes_at > '".date("H:i")."'";
			}

			if(!empty($_GET['hasPhoto'])){
				$joins .= " INNER JOIN user_images as p ON u.id=p.user_id";
			}
			
			$orders = array('created_at', 'location_id', 'name');
			$order = !empty($_GET['order']) && in_array($_GET['order'], $orders) ? 'u.'.$_GET['order']:'u.created_at';
			if($order == 'u.name'){ $order = 'name'; $dir = 'asc'; }elseif($order == 'u.created_at'){ $dir = 'desc'; }else{ $dir = 'asc'; }

			//echo $sql;echo $joins;exit;
			$get = $this->db->query("SELECT 
							t.id, t.name as cat_name,z.city,z.zipcode,
							u.business_name,u.clean_url,u.fullname as name,s.code as state_code,t.permalink,
							u.id as u_id, u.gender,u.avatar
							FROM categories as t
							LEFT OUTER JOIN users as u ON t.id = u.category_id 
							LEFT OUTER JOIN zipcodes as z ON z.id = u.location_id 
							LEFT OUTER JOIN states as s ON s.id = z.state_id 
							$joins
							WHERE $sql  GROUP BY u.id
							ORDER BY u.plan_id DESC, $order $dir
							 $limit", 'r')->getResultArray();
//echo $this->db->getLastQuery()->getQuery();exit;							 
			$total = $this->db->query("SELECT u.id FROM users u $joins WHERE $sql GROUP BY u.id", 'n')->getResultArray();
			//echo $this->db->getLastQuery()->getQuery();exit;		
			if(count($total) > 0){
				$found = true;
				if(!empty($get)){
					foreach($get as $user){
						$pic = $this->db->query("SELECT file_name FROM user_images WHERE user_id='".$user['u_id']."' ORDER BY `order` ASC LIMIT 1", 'a')->getRowArray();
                        if(!empty($user['avatar'])){ 
					$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$user['avatar'];
				}else{ if(empty($pic['file_name'])){ 
						if($user['gender'] == 'Female'){
							$pic['file_name'] = base_url().'/assets/frontend/images/female_user.png';
						}else{
							$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
						}							 
						}else{
							$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$pic['file_name'];
						}
				}
						$providers[] = array(
							'image' => $pic['file_name'],
							'id' => $user['u_id'],
							'name' => $user['name'],
							'business_name' => $user['business_name'],
							'cat_name' => $user['cat_name'],
							'permalink' => $user['permalink'],
							'city' => $user['city'],
							'state_code' => $user['state_code'],
							'zipcode' => $user['zipcode'],
							'clean_url' => $user['clean_url'],
							'avatar' => $user['avatar'],
							
						);
					}
				}
			}
				$categories[] = array(
					'id' => '',
					'name' => '',
					'skill_name' => '',
					'permalink' => '',
					'total_users' => count($total),
					'providers' => $providers
				);
		
		return $categories;
		}else{
			return array();
		}
	}
	
	public function get_categories1($category,$radius=1,$featured=''){
		
		
		$categories = array();
		$limit = '';
		if($category == null){
			$limit = 'LIMIT 0,10';
			$types = $this->db->query("SELECT id, name,skill_name,permalink FROM categories ORDER BY name ASC", 'r')->getResultArray();
		}else{
			$limit = '';
			$types = $this->db->query("SELECT id, name,skill_name,permalink FROM categories WHERE permalink LIKE '".$category."' ORDER BY name ASC", 'r')->getResultArray();
		}
		//echo $this->db->getLastQuery()->getQuery();exit;
		foreach($types as $row){ 
			$providers = array();
			$sql = "category_id='".$row['id']."' AND u.status='1'";
			$joins = '';
			
			if(!empty($_GET['male']) && empty($_GET['female'])){
				$sql .= " AND u.gender='Male'";
			}elseif(empty($_GET['male']) && !empty($_GET['female'])){
				$sql .= " AND u.gender='Female'";
			}elseif(!empty($_GET['male']) && !empty($_GET['female'])){
				$sql .= " AND (u.gender='Female' OR u.gender='Male')";
			}			
			
			$sql .= " AND u.email_status = 1  AND u.deleted_at IS NULL ";
				
			
			foreach($_GET as $k=>$v){
				$k = explode('_', $k);
				if(!empty($k[0]) && $k[0] == 'skill'){
					$skills[] = $k[1];
					$sql .= ' AND JSON_SEARCH(u.categories_skills,"one", "'.$k[1].'") IS NOT NULL';
				}
				if(!empty($k[0]) && $k[0] == 'client-types'){
					$sql .= ' AND (JSON_SEARCH(u.clientele,"one", "'.$k[1].'") IS NOT NULL OR JSON_SEARCH(u.clientele,"one", "3") IS NOT NULL)';
				}
				if(!empty($k[0]) && $k[0] == 'offering'){
					$sql .= ' AND JSON_SEARCH(u.offering,"one", "'.$k[1].'") IS NOT NULL';
				}
			}
			
			if(!empty($featured)){
				$sql .= ' AND u.plan_id = 3';				
			}else{
				$sql .= ' AND u.plan_id != 1';	
			}
			if(!empty($_GET['availableNow'])){
				$joins .= " INNER JOIN hours_of_operation as h ON u.id = h.user_id AND weekday='".date("N")."' AND closed_all_day='0' AND opens_at <= '".date("H:i")."' AND closes_at > '".date("H:i")."'";
			}

			if(!empty($_GET['hasPhoto'])){
				$joins .= " INNER JOIN user_images as p ON u.id=p.user_id";
			}
			
			$orders = array('created_at', 'location_id', 'name');
			$order = !empty($_GET['order']) && in_array($_GET['order'], $orders) ? 'u.'.$_GET['order']:'u.created_at';
			if($order == 'u.name'){ $order = 'name'; $dir = 'asc'; }elseif($order == 'u.created_at'){ $dir = 'desc'; }else{ $dir = 'asc'; }

			//echo $sql;echo $joins;exit;
			$get = $this->db->query("SELECT 
							t.id, t.name as cat_name,z.city,z.zipcode,
							u.business_name,u.clean_url, u.fullname as name,s.code as state_code,t.permalink,
							u.id as u_id, u.gender,u.avatar
							FROM categories as t
							LEFT OUTER JOIN users as u ON t.id = u.category_id 
							LEFT OUTER JOIN zipcodes as z ON z.id = u.location_id
							LEFT OUTER JOIN states as s ON s.id = z.state_id 
							$joins
							WHERE $sql  GROUP BY u.id
							ORDER BY u.plan_id DESC, $order $dir
							 $limit", 'r')->getResultArray();
//echo $this->db->getLastQuery()->getQuery();exit;							 
			$total = $this->db->query("SELECT u.id FROM users u $joins WHERE $sql GROUP BY u.id", 'n')->getResultArray();
			//echo $this->db->getLastQuery()->getQuery();exit;		
			if(count($total) > 0){
				$found = true;
				if(!empty($get)){
					foreach($get as $user){
						$pic = $this->db->query("SELECT file_name FROM user_images WHERE user_id='".$user['u_id']."' ORDER BY `order` ASC LIMIT 1", 'a')->getRowArray();
                        if(!empty($user['avatar'])){ 
					$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$user['avatar'];
				}else{ if(empty($pic['file_name'])){ 
						if($user['gender'] == 'Female'){
							$pic['file_name'] = base_url().'/assets/frontend/images/female_user.png';
						}else{
							$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
						}							 
						}else{
							$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$pic['file_name'];
				}}
						$providers[] = array(
							'image' => $pic['file_name'],
							'id' => $user['u_id'],
							'name' => $user['name'],
							'business_name' => $user['business_name'],
							'cat_name' => $user['cat_name'],
							'permalink' => $user['permalink'],
							'city' => $user['city'],
							'state_code' => $user['state_code'],
							'zipcode' => $user['zipcode'],
							'clean_url' => $user['clean_url'],
							'avatar' => $user['avatar'],
						);
					}
				}
			}
				$categories[] = array(
					'id' => $row['id'],
					'name' => $row['name'],
					'skill_name' => $row['skill_name'],
					'permalink' => $row['permalink'],
					'total_users' => count($total),
					'providers' => $providers
				);
		}
		return $categories;
		
	}
	
	public function get_categories3($yes=null,$radius=1,$featured=''){
		
		
		$categories = array();
		$limit = '';
			$providers = array();
			$sql = " u.status='1'";
			$joins = '';
			
			if(!empty($_GET['male']) && empty($_GET['female'])){
				$sql .= " AND u.gender='Male'";
			}elseif(empty($_GET['male']) && !empty($_GET['female'])){
				$sql .= " AND u.gender='Female'";
			}elseif(!empty($_GET['male']) && !empty($_GET['female'])){
				$sql .= " AND (u.gender='Female' OR u.gender='Male')";
			}			
			
			$sql .= " AND u.email_status = 1  AND u.deleted_at IS NULL ";
						
			
			foreach($_GET as $k=>$v){
				$k = explode('_', $k);
				if(!empty($k[0]) && $k[0] == 'skill'){
					$skills[] = $k[1];
					$sql .= ' AND JSON_SEARCH(u.categories_skills,"one", "'.$k[1].'") IS NOT NULL';
				}
				if(!empty($k[0]) && $k[0] == 'client-types'){
					$sql .= ' AND (JSON_SEARCH(u.clientele,"one", "'.$k[1].'") IS NOT NULL OR JSON_SEARCH(u.clientele,"one", "3") IS NOT NULL)';
				}
				if(!empty($k[0]) && $k[0] == 'offering'){
					$sql .= ' AND (JSON_SEARCH(u.offering,"one", "'.$k[1].'") IS NOT NULL OR JSON_SEARCH(u.offering,"one", "3") IS NOT NULL)';
				}
			}
			if(!empty($featured)){
				$sql .= ' AND u.plan_id = 3';				
			}else{
				$sql .= ' AND u.plan_id != 1';	
			}
			if(!empty($_GET['availableNow'])){
				$joins .= " INNER JOIN hours_of_operation as h ON u.id = h.user_id AND weekday='".date("N")."' AND closed_all_day='0' AND opens_at <= '".date("H:i")."' AND closes_at > '".date("H:i")."'";
			}

			if(!empty($_GET['hasPhoto'])){
				$joins .= " INNER JOIN user_images as p ON u.id=p.user_id";
			}
			
			$orders = array('created_at', 'location_id', 'name');
			$order = !empty($_GET['order']) && in_array($_GET['order'], $orders) ? 'u.'.$_GET['order']:'u.created_at';
			if($order == 'u.name'){ $order = 'name'; $dir = 'asc'; }elseif($order == 'u.created_at'){ $dir = 'desc'; }else{ $dir = 'asc'; }

			//echo $sql;echo $joins;exit;
			$get = $this->db->query("SELECT 
							t.id, t.name as cat_name,z.city,z.zipcode,
							u.business_name,u.clean_url,u.fullname as name,s.code as state_code,t.permalink,
							u.id as u_id, u.gender,u.avatar
							FROM categories as t
							LEFT OUTER JOIN users as u ON t.id = u.category_id 
							LEFT OUTER JOIN zipcodes as z ON z.id = u.location_id 
							LEFT OUTER JOIN states as s ON s.id = z.state_id 
							$joins
							WHERE $sql  GROUP BY u.id
							ORDER BY u.plan_id DESC, $order $dir
							 $limit", 'r')->getResultArray();
//echo $this->db->getLastQuery()->getQuery();exit;							 
			$total = $this->db->query("SELECT u.id FROM users u $joins WHERE $sql GROUP BY u.id", 'n')->getResultArray();
			//echo $this->db->getLastQuery()->getQuery();exit;		
			if(count($total) > 0){
				$found = true;
				if(!empty($get)){
					foreach($get as $user){
						$pic = $this->db->query("SELECT file_name FROM user_images WHERE user_id='".$user['u_id']."' ORDER BY `order` ASC LIMIT 1", 'a')->getRowArray();
                        if(!empty($user['avatar'])){ 
							$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$user['avatar'];
						}else{ if(empty($pic['file_name'])){ 
						if($user['gender'] == 'Female'){
							$pic['file_name'] = base_url().'/assets/frontend/images/female_user.png';
						}else{
							$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
						}							 
						}else{
							$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$pic['file_name'];
						}}
						$providers[] = array(
							'image' => $pic['file_name'],
							'id' => $user['u_id'],
							'name' => $user['name'],
							'business_name' => $user['business_name'],
							'cat_name' => $user['cat_name'],
							'permalink' => $user['permalink'],
							'city' => $user['city'],
							'state_code' => $user['state_code'],
							'zipcode' => $user['zipcode'],
							'clean_url' => $user['clean_url'],
							'avatar' => $user['avatar'],
							
						);
					}
				}
			}
				$categories[] = array(
					'id' => '',
					'name' => '',
					'skill_name' => '',
					'permalink' => 'all',
					'total_users' => count($total),
					'providers' => $providers
				);
		
		return $categories;
		
	}
	
	public function get_featured($location_id,$category=null,$radius=1){
		
		
		$lat_long = $this->asObject()->where('id', clean_number($location_id))->find();
		if(!empty($lat_long)){
		$zipcode_ids = $this->get_nearest_zipcodes($lat_long[0]->lat,$lat_long[0]->long,$radius)['zipcode_ids'];
		$categories = array();
		$limit = '';
		if($category == null){
			$limit = 'LIMIT 0,10';
			$types = $this->db->query("SELECT id, name,skill_name,permalink FROM categories ORDER BY name ASC", 'r')->getResultArray();
		}else{
			$limit = '';
			$types = $this->db->query("SELECT id, name,skill_name,permalink FROM categories WHERE permalink LIKE '".$category."' ORDER BY name ASC", 'r')->getResultArray();
		}
		//echo $this->db->getLastQuery()->getQuery();exit;
		foreach($types as $row){ 
			$providers = array();
			$get = $this->db->query("SELECT t.*,
							u.fullname as name, u.id as u_id, u.business_name,u.clean_url,u.gender,u.avatar,
							z.city, s.code as state_code,z.zipcode
							FROM categories as t
							LEFT OUTER JOIN users as u ON t.id = u.category_id AND u.plan_id = 3 AND u.status='1'
							LEFT OUTER JOIN zipcodes as z ON u.location_id = z.id
							INNER JOIN states as s ON z.state_id = s.id
							WHERE (u.location_id IN ($zipcode_ids) OR ( 3959 * acos( cos( radians(".$lat_long[0]->lat.") ) * cos( radians( u.city_lat ) ) * cos( radians( u.city_lng ) - radians(".$lat_long[0]->long.") ) + sin( radians(".$lat_long[0]->lat.") ) * sin( radians( u.city_lat ) ) ) ) <= u.miles) AND t.id='".$row['id']."' AND u.email_status = 1 AND u.deleted_at IS NULL GROUP BY u.id ORDER BY RAND()
							LIMIT 0, 10", 'r')->getResultArray();		
				//echo $this->db->getLastQuery()->getQuery();exit;
				if(!empty($get)){
					foreach($get as $user){
						$pic = $this->db->query("SELECT file_name FROM user_images WHERE user_id='".$user['u_id']."' ORDER BY `order` ASC LIMIT 1", 'a')->getRowArray();
                        if(!empty($user['avatar'])){ 
							$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$user['avatar'];
						}else{ if(empty($pic['file_name'])){ 
							if($user['gender'] == 'Female'){
								$pic['file_name'] = base_url().'/assets/frontend/images/female_user.png';
							}else{
								$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
							}							 
						}else{
							$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$pic['file_name'];
						}}
						$providers[] = array(
							'image' => $pic['file_name'],
							'id' => $user['u_id'],
							'name' => $user['name'],
							'business_name' => $user['business_name'],
							'city' => $user['city'],
							'state_code' => $user['state_code'],
							'zipcode' => $user['zipcode'],
							'clean_url' => $user['clean_url'],
							'avatar' => $user['avatar'],
						);
					}
				}
			
				$categories[] = array(
					'id' => $row['id'],
					'name' => $row['name'],
					'skill_name' => $row['skill_name'],
					'permalink' => $row['permalink'],
					'total_users' => count($get),
					'providers' => $providers
				);
		}
		return $categories;
		}else{
			return array();
		}
	}
	
	public function get_featured_home($limit=12){
		$providers = array();
		$get = $this->db->query("SELECT t.*,
								u.fullname as name, u.id as u_id, u.business_name,u.clean_url,u.gender,u.avatar,
								t.name as cat_name,
								z.city, s.code as state_code,z.zipcode
								FROM users as u 
								INNER JOIN categories as t ON u.category_id = t.id
								INNER JOIN zipcodes as z ON u.location_id = z.id
								INNER JOIN states as s ON z.state_id = s.id
								WHERE u.plan_id = 3 AND u.status='1' AND u.email_status = 1 AND u.deleted_at IS NULL 
								ORDER BY RAND() DESC
								LIMIT $limit", 'r')->getResultArray();	
		if(!empty($get)){
			foreach($get as $user){
				$pic = $this->db->query("SELECT file_name FROM user_images WHERE user_id='".$user['u_id']."' ORDER BY `order` ASC LIMIT 1", 'a')->getRowArray();
				if(!empty($user['avatar'])){ 
					$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$user['avatar'];
				}else{ if(empty($pic['file_name'])){ 
					if($user['gender'] == 'Female'){
						$pic['file_name'] = base_url().'/assets/frontend/images/female_user.png';
					}else{
						$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
					}
					
				}else{
					$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$pic['file_name'];
				}}
				$providers[] = array(
					'image' => $pic['file_name'],
					'id' => $user['u_id'],
					'permalink' => $user['permalink'],
					'cat_name' => $user['cat_name'],
					'city' => $user['city'],
					'state_code' => $user['state_code'],
					'name' => $user['name'],
					'business_name' => $user['business_name'],
					'zipcode' => $user['zipcode'],
					'clean_url' => $user['clean_url'],
				);
			}
		}
		if(!empty($providers)){
		return $providers;
		}else{
			return array();
		}
	}
	public function get_featured_home_ajax($limit,$lat,$long){
		$providers = array();
		$r = 1000;
		$zipcode_ids = $this->get_nearest_zipcodes($lat,$long,$r)['zipcode_ids'];
		if(!empty($zipcode_ids)){
		$get = $this->db->query("SELECT t.*,
								u.fullname as name, u.id as u_id, u.business_name, u.clean_url,u.gender,u.avatar,
								t.name as cat_name,
								z.city, s.code as state_code,z.zipcode, acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(`long`)-$long)) * $r As distance
								FROM users as u 
								INNER JOIN categories as t ON u.category_id = t.id
								INNER JOIN zipcodes as z ON u.location_id = z.id
								INNER JOIN states as s ON z.state_id = s.id
								WHERE u.plan_id = 3 AND u.status='1' AND u.email_status = 1 AND u.deleted_at IS NULL AND (u.location_id IN ($zipcode_ids) OR ( 3959 * acos( cos( radians(".$lat.") ) * cos( radians( u.city_lat ) ) * cos( radians( u.city_lng ) - radians(".$long.") ) + sin( radians(".$lat.") ) * sin( radians( u.city_lat ) ) ) ) <= u.miles) GROUP BY u.id 
								ORDER BY distance ASC
								LIMIT $limit", 'r')->getResultArray();	
								//echo $this->db->getLastQuery(); die;
		if(!empty($get)){
			foreach($get as $user){
				$pic = $this->db->query("SELECT file_name FROM user_images WHERE user_id='".$user['u_id']."' ORDER BY `order` ASC LIMIT 1", 'a')->getRowArray();
				if(!empty($user['avatar'])){ 
					$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$user['avatar'];
				}else{ if(empty($pic['file_name'])){ 
					if($user['gender'] == 'Female'){
						$pic['file_name'] = base_url().'/assets/frontend/images/female_user.png';
					}else{
						$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
					}
					
				}else{
					$pic['file_name'] = base_url().'/uploads/userimages/'.$user['u_id'].'/'.$pic['file_name'];
				}}
				$providers[] = array(
					'image' => $pic['file_name'],
					'id' => $user['u_id'],
					'permalink' => $user['permalink'],
					'cat_name' => $user['cat_name'],
					'city' => $user['city'],
					'state_code' => $user['state_code'],
					'name' => $user['name'],
					'business_name' => $user['business_name'],
					'distance' => $user['distance'],
					'zipcode' => $user['zipcode'],
					'clean_url' => $user['clean_url'],
				);
			}
		}
		if(!empty($providers)){
		return $providers;
		}else{
			return array();
		}
		}else{
			return array();
		}
	}
	public function get_nearest_zipcodes($lat,$lon,$rad){
		//earth's radius in miles
		$r = 3959;
	  
		// first-cut bounding box (in degrees)
		$maxLat = $lat + rad2deg($rad/$r);
		$minLat = $lat - rad2deg($rad/$r);
		// compensate for degrees longitude getting smaller with increasing latitude
		$maxLon = $lon + rad2deg($rad/$r/cos(deg2rad($lat)));
		$minLon = $lon - rad2deg($rad/$r/cos(deg2rad($lat)));
		$lat = deg2rad($lat);
		$long = deg2rad($lon);

		$zipcodes = $this->db->query("SELECT id, zipcode, lat, `long`, 
		   acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(`long`)-$long)) * $r As D
		FROM (
		SELECT id, zipcode, lat, `long`
		From zipcodes
		Where lat Between $minLat And $maxLat
		And `long` Between $minLon And $maxLon
		) As FirstCut 
		WHERE acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(`long`)-$long)) * $r < $rad
		ORDER BY D", 'r')->getResultArray();
		$zSql = '';
		$zSqlid = '';
		foreach($zipcodes as $row){
		$zSql .= $row['zipcode'].',';
		$zSqlid .= $row['id'].',';
		}
		
		return array('zipcodes'=>rtrim($zSql, ','),'zipcode_ids'=>rtrim($zSqlid, ','));
		
	}
}
