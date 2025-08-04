<?php

namespace App\Controllers\Providerauth;

use App\Libraries\Recaptcha;
use App\Models\UsersModel;
use App\Models\EmailModel;
use App\Models\Locations\CityModel;
use App\Models\CategoriesModel;
use App\Models\CategoriesSubModel;
use App\Models\CategoriesSkillsModel;
use App\Models\ClientTypesModel;
use App\Models\PlansModel;
use App\Models\FieldsModel;
use App\Models\ProductModel;
use Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Subscription;
use Stripe\Invoice;
use Stripe\Token;
use Stripe\PaymentIntent;
use App\Models\SupportModel;

class ProviderDashboard extends ProviderauthController
{
	protected $UsersModel;
    protected $userModel;
    protected $CategoriesModel;
    protected $CategoriesSubModel;
    protected $ProductModel;
    protected $FieldsModel;
    protected $PlansModel;
    protected $SupportModel;
    protected $EmailModel;
    protected $CategoriesSkillsModel;
    protected $ClientTypesModel;
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
            return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$uri = current_url(true);
		$data['title'] = trans('Dashboard');
		$latlngs = $this->UsersModel->db->query('SELECT u.location_id,sum(u.zipcode_count) as count,z.lat,z.long  FROM `users` u JOIN zipcodes z ON u.location_id = z.id WHERE u.zipcode_count > 0 group by u.location_id order by count desc;')->getResult();
		$arr = array();
		if(!empty($latlngs)){
			foreach($latlngs as $lat){
				for($i=1;$i<=$lat->count;$i++){
					$arr[] = array(
					  $lat->lat, $lat->long,
					); 
				}
			}
		}
		if(!empty($_GET['start']) && !empty($_GET['end'])){
			$endDate = $_GET['end'].' 23:59:00';
			$startDate = $_GET['start'].' 00:00:00';
		}else{
			$endDate = date('Y-m-d', strtotime("+1 day")).' 23:59:00';
			$startDate = date('Y-m-d', strtotime("-1 month")).' 00:00:00';
		}		
		
		$data['view_count'] = $this->UsersModel->db->query('SELECT count(*) as view_count FROM website_stats w right join products p on p.id = w.product_id where w.view_count = 1 AND w.user_id = '.$this->session->get('vr_sess_user_id').' AND w.created_at <= "'.$endDate.'" AND w.created_at >= "'.$startDate.'"')->getRow()->view_count;
		$data['favorites_count'] = $this->UsersModel->db->query('SELECT count(*) as favorites_count FROM `user_favorites` where user_id = '.$this->session->get('vr_sess_user_id').' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->favorites_count;
		$data['call_count'] = $this->UsersModel->db->query('SELECT count(*) as call_count FROM website_stats w right join products p on p.id = w.product_id where w.call_count = 1 AND w.user_id = '.$this->session->get('vr_sess_user_id').' AND w.created_at <= "'.$endDate.'" AND w.created_at >= "'.$startDate.'"')->getRow()->call_count;
		$data['form_count'] = $this->UsersModel->db->query('SELECT count(*) as form_count FROM website_stats w right join products p on p.id = w.product_id where w.form_count = 1 AND w.user_id = '.$this->session->get('vr_sess_user_id').' AND w.created_at <= "'.$endDate.'" AND w.created_at >= "'.$startDate.'"')->getRow()->form_count;
		$data['direction_count'] = $this->UsersModel->db->query('SELECT count(*) as direction_count FROM website_stats w right join products p on p.id = w.product_id where w.direction_count = 1 AND w.user_id = '.$this->session->get('vr_sess_user_id').' AND w.created_at <= "'.$endDate.'" AND w.created_at >= "'.$startDate.'"')->getRow()->direction_count;
		$data['zipcode_count'] = $this->UsersModel->db->query('SELECT count(*) as zipcode_count FROM website_stats w right join products p on p.id = w.product_id where  w.location_id = '.$data['user_detail']->location_id.' AND w.created_at <= "'.$endDate.'" AND w.created_at >= "'.$startDate.'"')->getRow()->zipcode_count;
		$data['impression_count'] = $this->UsersModel->db->query('SELECT count(*) as impression_count FROM website_stats w right join products p on p.id = w.product_id where w.impression_count = 1 AND w.user_id = '.$this->session->get('vr_sess_user_id').' AND w.created_at <= "'.$endDate.'" AND w.created_at >= "'.$startDate.'"')->getRow()->impression_count;
		
		
		$query2 =  $this->userModel->db->query('SELECT count(*) as user_count, zipcodes.city, zipcodes.zipcode, states.code as state_code FROM `website_stats` w LEFT JOIN zipcodes ON w.customer_zipcode = zipcodes.zipcode LEFT JOIN states ON zipcodes.state_id = states.id where w.customer_zipcode != ""  AND w.user_id = '.$this->session->get('vr_sess_user_id').' AND w.created_at <= "'.$endDate.'" AND w.created_at >= "'.$startDate.'" AND city != "" GROUP BY w.customer_zipcode order by user_count desc  limit 10')->getResult();
		$query1 =  $this->UsersModel->db->query('SELECT * FROM `website_stats` where customer_zipcode != ""  AND user_id = '.$this->session->get('vr_sess_user_id').' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'" GROUP BY created_at order by created_at desc LIMIT 20')->getResult();
		$query3 =  $this->UsersModel->db->query('SELECT * FROM `website_stats` where call_count = 1  AND user_id = '.$this->session->get('vr_sess_user_id').' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"  order by created_at desc LIMIT 20')->getResult();
		//print_r($query1);exit;	
        $data['top_locations'] = $query2;
        $data['top_calls'] = $query3;
		$data['recent_payments'] = $query1;

		$data['zipcodes'] = json_encode($arr);
		$data['meta_title'] = 'Dashboard | Plane Broker';
		
		$data['provider_message'] = $this->UsersModel->get_recent_provider_messages($this->session->get('vr_sess_user_id'));
		//print_r($data['provider_message']);exit;
        return view('Providerauth/ProviderDashboard', $data);
    }
    public function index1()
    {
		$data = array();
		$uid=$_GET['id'];
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($uid);
		$data['title'] = trans('Dashboard');
		$latlngs = $this->UsersModel->db->query('SELECT u.location_id,sum(u.zipcode_count) as count,z.lat,z.long  FROM `users` u JOIN zipcodes z ON u.location_id = z.id WHERE u.zipcode_count > 0 group by u.location_id order by count desc;')->getResult();
		$arr = array();
		if(!empty($latlngs)){
			foreach($latlngs as $lat){
				for($i=1;$i<=$lat->count;$i++){
					$arr[] = array(
					  $lat->lat, $lat->long,
					); 
				}
			}
		}
		if(!empty($_GET['start']) && !empty($_GET['end'])){
			$endDate = $_GET['end'].' 23:59:00';
			$startDate = $_GET['start'].' 00:00:00';
		}else{
			$endDate = date('Y-m-d', strtotime("+1 day")).' 23:59:00';
			$startDate = date('Y-m-d', strtotime("-1 week")).' 00:00:00';
		}		
		
		$data['view_count'] = $this->UsersModel->db->query('SELECT count(*) as view_count FROM `website_stats` where view_count = 1 AND user_id = '.$uid.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->view_count;
		$data['call_count'] = $this->UsersModel->db->query('SELECT count(*) as call_count FROM `website_stats` where call_count = 1 AND user_id = '.$uid.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->call_count;
		$data['form_count'] = $this->UsersModel->db->query('SELECT count(*) as form_count FROM `website_stats` where form_count = 1 AND user_id = '.$uid.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->form_count;
		$data['direction_count'] = $this->UsersModel->db->query('SELECT count(*) as direction_count FROM `website_stats` where direction_count = 1 AND user_id = '.$uid.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->direction_count;
		$data['zipcode_count'] = $this->UsersModel->db->query('SELECT count(*) as zipcode_count FROM `website_stats` where  location_id = '.$data['user_detail']->location_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->zipcode_count;
		$data['impression_count'] = $this->UsersModel->db->query('SELECT count(*) as impression_count FROM `website_stats` where impression_count = 1 AND user_id = '.$uid.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->impression_count;
		
		
		$query2 =  $this->userModel->db->query('SELECT count(*) as user_count, zipcodes.city, zipcodes.zipcode, states.code as state_code FROM `website_stats` w LEFT JOIN zipcodes ON w.customer_zipcode = zipcodes.zipcode LEFT JOIN states ON zipcodes.state_id = states.id where w.customer_zipcode != ""  AND w.user_id = '.$uid.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'" AND city != "" GROUP BY w.customer_zipcode order by user_count desc  limit 10')->getResult();
		$query1 =  $this->UsersModel->db->query('SELECT * FROM `website_stats` where customer_zipcode != ""  AND user_id = '.$uid.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'" GROUP BY created_at order by created_at desc LIMIT 20')->getResult();
		$query3 =  $this->UsersModel->db->query('SELECT * FROM `website_stats` where call_count = 1  AND user_id = '.$uid.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"  order by created_at desc LIMIT 20')->getResult();
		//print_r($query1);exit;	
        $data['top_locations'] = $query2;
        $data['id'] = $uid;
		$data['id_load'] = isset($uid) ? "id=".$uid."&" : "";
		$data['from_cron'] = 1;
        $data['top_calls'] = $query3;
		$data['recent_payments'] = $query1;
        $data['startDate'] = $startDate;
		$data['endDate'] = $endDate;

		$data['zipcodes'] = json_encode($arr);
        return view('Providerauth/ProviderDashboardMail', $data);
    }
    public function groomer_dashboard()
    {
		$data = array();
        if (empty($_GET['name'])) {
            return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$u_det = $this->UsersModel->get_uer_by_business_name($_GET['name']);
		$vr_sess_user_id = !empty($u_det) ? $u_det->id : '';
		$data['user_detail'] = $this->UsersModel->get_user($vr_sess_user_id);
		$data['title'] = trans('Dashboard');
		$latlngs = $this->UsersModel->db->query('SELECT u.location_id,sum(u.zipcode_count) as count,z.lat,z.long  FROM `users` u JOIN zipcodes z ON u.location_id = z.id WHERE u.zipcode_count > 0 group by u.location_id order by count desc;')->getResult();
		$arr = array();
		if(!empty($latlngs)){
			foreach($latlngs as $lat){
				for($i=1;$i<=$lat->count;$i++){
					$arr[] = array(
					  $lat->lat, $lat->long,
					); 
				}
			}
		}
		if(!empty($_GET['start']) && !empty($_GET['end'])){
			$endDate = $_GET['end'].' 23:59:00';
			$startDate = $_GET['start'].' 00:00:00';
		}else{
			$endDate = date('Y-m-d', strtotime("+1 day")).' 23:59:00';
			$startDate = date('Y-m-d', strtotime("-1 month")).' 00:00:00';
		}		
		
		$data['view_count'] = $this->UsersModel->db->query('SELECT count(*) as view_count FROM `website_stats` where view_count = 1 AND user_id = '.$vr_sess_user_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->view_count;
		$data['call_count'] = $this->UsersModel->db->query('SELECT count(*) as call_count FROM `website_stats` where call_count = 1 AND user_id = '.$vr_sess_user_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->call_count;
		$data['form_count'] = $this->UsersModel->db->query('SELECT count(*) as form_count FROM `website_stats` where form_count = 1 AND user_id = '.$vr_sess_user_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->form_count;
		$data['direction_count'] = $this->UsersModel->db->query('SELECT count(*) as direction_count FROM `website_stats` where direction_count = 1 AND user_id = '.$vr_sess_user_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->direction_count;
		$data['zipcode_count'] = $this->UsersModel->db->query('SELECT count(*) as zipcode_count FROM `website_stats` where  location_id = '.$data['user_detail']->location_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->zipcode_count;
		$data['impression_count'] = $this->UsersModel->db->query('SELECT count(*) as impression_count FROM `website_stats` where impression_count = 1 AND user_id = '.$vr_sess_user_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->impression_count;
		
		
		$query2 =  $this->userModel->db->query('SELECT count(*) as user_count, zipcodes.city, zipcodes.zipcode, states.code as state_code FROM `website_stats` w LEFT JOIN zipcodes ON w.customer_zipcode = zipcodes.zipcode LEFT JOIN states ON zipcodes.state_id = states.id where w.customer_zipcode != ""  AND w.user_id = '.$vr_sess_user_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'" AND city != "" GROUP BY w.customer_zipcode order by user_count desc  limit 10')->getResult();
		$query1 =  $this->UsersModel->db->query('SELECT * FROM `website_stats` where customer_zipcode != ""  AND user_id = '.$vr_sess_user_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'" GROUP BY created_at order by created_at desc LIMIT 20')->getResult();
		$query3 =  $this->UsersModel->db->query('SELECT * FROM `website_stats` where call_count = 1  AND user_id = '.$vr_sess_user_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'" order by created_at desc LIMIT 20')->getResult();
		//print_r($query1);exit;	
        $data['top_locations'] = $query2;
        $data['top_calls'] = $query3;
		$data['recent_payments'] = $query1;
		$data['id'] = isset($vr_sess_user_id) ? "id=".$vr_sess_user_id."&" : "";
		$data['zipcodes'] = json_encode($arr);
		$data['meta_title'] = 'Dashboard | Plane Broker';
        return view('Providerauth/ProviderDashboard', $data);
    }
	
	public function edit_profile(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
        $this->CategoriesModel = new CategoriesModel();
		$data['categories'] = $this->CategoriesModel->get_categories();
		if(!empty($data['user_detail']->category_id)){
			$this->CategoriesSkillsModel = new CategoriesSkillsModel();
			$data['categories_skills'] = $this->CategoriesSkillsModel->get_categories_skills_by_category_id(1);
			$data['offering'] = array();
		}else{
			$data['categories_skills'] = array();
			$data['offering'] = array();
		}
		$data['rate_details'] = $this->UsersModel->get_rate_details($this->session->get('vr_sess_user_id'));
		$data['hours_of_operation'] = $this->UsersModel->get_hours_of_operation($this->session->get('vr_sess_user_id'));
        $this->ClientTypesModel = new ClientTypesModel();
		$data['client_types'] = $this->ClientTypesModel->get_client_types();
		$data['title'] = trans('Edit My Profile');
		$data['meta_title'] = 'Edit My Profile | Plane Broker';
		
		//get dynamic fields
        $this->FieldsModel = new FieldsModel();
        $data['dynamic_fields'] = array();//$this->FieldsModel->get_fields();
		
		
        return view('Providerauth/ProviderEditProfile', $data);
	}

	public function edit_profile_post(){
		//echo "<pre>";print_r($this->request);exit;
		$userModel = new UsersModel();
		$user = $userModel->update_user($this->request->getVar('id'));
		if ($user) {
			$this->session->setFlashData('success_form', trans("Profile Updated Successfully!"));
			return redirect()->to(base_url('providerauth/edit-profile'));
		} else {
			//error
			$this->session->setFlashData('errors_form', trans("There was a problem during update. Please try again!"));
			return redirect()->to($this->agent->getReferrer())->withInput();
		}
	}
	
	public function get_categories_skills(){
		$this->CategoriesSkillsModel = new CategoriesSkillsModel();
		$categories_skills = $this->CategoriesSkillsModel->get_categories_skills_by_category_id(1);
        $this->CategoriesModel = new CategoriesModel();
		$category_detail = $this->CategoriesModel->get_categories_by_id($this->request->getVar('category_id'));
		$html = '';
		//check if category id is already selected one
		$this->UsersModel = new UsersModel();
		
		if($this->request->getPost('edit_user_id') === null) {
			$userId = $this->session->get('vr_sess_user_id');
		}else{
			$userId = $this->request->getVar('edit_user_id');
		}

		$user_detail = '';
		if(!empty($userId)){
			$user_detail = $this->UsersModel->get_user($userId);
		}		
		
		if(!empty($categories_skills)){
			$html .= '<h4 class="title-md dblue mt-3 mt-lg-5 border-bottom">'.$category_detail->skill_name.':</h4>
			<div class="form-group row row-cols-1 row-cols-md-3 row-cols-xl-4 mb-3 mb-lg-5">';
			foreach($categories_skills as $row){
				$checked = '';
				if(!empty($userId)){
					if($user_detail->category_id == $this->request->getVar('category_id')){
						if(!empty($user_detail->categories_skills) && $user_detail->categories_skills != 'null' && is_array(json_decode($user_detail->categories_skills,true)) && in_array($row->id, json_decode($user_detail->categories_skills,true))){
							$checked = 'checked';
						}				
					}
			    }
				$html .= '<label class="col"><input type="checkbox" name="categories_skills[]" '.$checked.' value="'.$row->id.'">'.$row->name.'</label>';
			}
			$html .= '</div>';
		}
		echo $html;exit;
	}
	
	public function get_category_offering(){
		$category_offering = array();
		$html = '';		
		//check if category id is already selected one
		$this->UsersModel = new UsersModel();
		if(!empty($this->request->getVar('from')) && $this->request->getVar('from') == 'register'){
			$userId = '';
		}else{
			if($this->request->getPost('edit_user_id') === null) {
				$userId = $this->session->get('vr_sess_user_id');
			}else{
				$userId = $this->request->getVar('edit_user_id');
			}
		}
		$user_detail = '';
		if(!empty($userId)){
			$user_detail = $this->UsersModel->get_user($userId);
		}
		if(!empty($category_offering)){
			if(!empty($this->request->getVar('from')) && $this->request->getVar('from') == 'register'){
				$html .= '<h4 class="title-md dblue mt-3 mt-lg-5">'.trans('Services').':</h4>
				<div class="form-group">';
			}else if(!empty($this->request->getVar('from')) && $this->request->getVar('from') == 'admin'){
				$html .= '<h4 class="border-bottom pb-2 mb-3">'.trans('Services').':</h4>
				<div class="form-group row row-cols-1 row-cols-md-3 row-cols-xl-4">';
			}else{
				$html .= '<h4 class="title-sm dblue mt-3 mt-lg-5 border-bottom">'.trans('Services').':</h4>
				<div class="form-group row row-cols-1 row-cols-md-3 row-cols-xl-4">';
			}
			foreach($category_offering as $row){
				$checked = '';
				if(!empty($userId)){
					if($user_detail->category_id == $this->request->getVar('category_id')){
						if(!empty($user_detail->offering) && $user_detail->offering != 'null' && is_array(json_decode($user_detail->offering,true)) && in_array($row->id, json_decode($user_detail->offering,true))){
							$checked = 'checked';
						}				
					}
			    }
				$html .= '<label class="col"><input type="checkbox" name="offering[]" '.$checked.' value="'.$row->id.'">'.$row->name.'</label>
				';
			}
			$html .= '</div>';
		}
		echo $html;exit;
	}
	public function photos(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$data['user_photos'] = $this->UsersModel->get_user_photos($this->session->get('vr_sess_user_id'));
		$data['title'] = trans('Photos');
		$data['meta_title'] = 'Photos | Plane Broker';
        return view('Providerauth/ProviderPhotos', $data);
	}
	public function photos_post(){
		//print_r($_POST);
		//print_r($file);exit;
		$user_id = !empty($this->request->getVar('user_id')) ? $this->request->getVar('user_id') : $this->session->get('vr_sess_user_id');
		if($this->request->getVar('check') == '1'){
			$this->UsersModel = new UsersModel();
			$user_detail = $this->UsersModel->get_user($user_id);
			$photos = $this->UsersModel->get_user_photos_isimage($user_id,'',$this->request->getVar('product_id'));
			$videos = $this->UsersModel->get_user_photos_isvideo($user_id,'',$this->request->getVar('product_id'));
			$response = '8';
			if(!empty($this->request->getVar('plan_id'))){
				$this->PlansModel = new PlansModel();
				$plan_detail = $this->PlansModel->get_plans_by_id($this->request->getVar('plan_id'));
				
				$file = $this->request->getFile('upload');
				if ($file && $file->isValid()) {
					$mimeType = $file->getMimeType(); // e.g. image/jpeg, video/mp4
					$extension = $file->getExtension(); // fallback if needed
					$isImage = str_starts_with($mimeType, 'image/');
					$isVideo = str_starts_with($mimeType, 'video/');
					$response = 1;					
					if ($isImage) {
						if(count($photos)+1 > $plan_detail[0]->no_of_photos){
							$response = json_encode(['status' => 'error', 'message' => 'Please upgrade your plan to upload more photos.']);
						}
					}
					if ($isVideo) {
						if(count($videos)+1 > $plan_detail[0]->no_of_videos){
							$response = json_encode(['status' => 'error', 'message' => 'Please upgrade your plan to upload more videos.']);
						}
					}
				}		
			}else{
				$response = json_encode(['status' => 'error', 'message' => 'not valid.']);
			}
			echo $response;
		}else if($this->request->getVar('check') == '3'){
			$this->UsersModel = new UsersModel();
			if(!empty($this->request->getVar('ids'))){
				foreach($this->request->getVar('ids') as $k => $id){
					$user = $this->UsersModel->update_user_photos_order($id,($k+1));
				}
			}
			echo '1';
		}else if($this->request->getVar('check') == '5'){
			$this->UsersModel = new UsersModel();
			if(!empty($user_id)){
				$user = $this->UsersModel->update_user_profile_photo($this->request->getVar('image'),$user_id);
			}
			echo '1';
		}else{
			
			$mainImageUrl = FCPATH .'uploads/userimages/' . $user_id . '/' . $this->request->getVar('image');
			$watermarkUrl = FCPATH .'uploads/sample-watermark.png';
			$savePath = FCPATH .'uploads/userimages/' . $user_id . '/' . $this->request->getVar('image');

			try {
				addWatermarkFromUrls($mainImageUrl, $watermarkUrl, $savePath, 20, 0.2);
				//echo "Watermark applied successfully. Saved to: $savePath";
			} catch (\Exception $e) {
				//echo "Error: " . $e->getMessage();
			}
			
			$this->UsersModel = new UsersModel();
			$user = $this->UsersModel->insert_user_photos($this->request->getVar('image'),$user_id,$this->request->getVar('image_tag'),$this->request->getVar('product_id'),$this->request->getVar('file_type'));
			if ($user) {
				$photos = $this->UsersModel->get_user_photos($user_id,'',$this->request->getVar('product_id'));
				$html = '';
				if(!empty($photos)){
					$html .= '<input name="image_ids" class="form-control" type="hidden" value="'.$photos[0]['all_ids'].'" />';
					if(count($photos) > 1){
						$html .= '<p>('.trans('Drag and drop to organize your photos').')</p>';
					}
					$html .= '<ul class="row" id="imageListId">';
					$html .= $this->photo_arrange($photos,$user_id);
					$html .= '</ul>';
				}
				echo $html;
			} else {
				echo '2';
			}
		}
	}
	public function upload_profile_photo(){
			$this->UsersModel = new UsersModel();
		$user = $this->UsersModel->update_user_profile_photo($this->request->getVar('image'),$this->session->get('vr_sess_user_id'));
		echo 'success';
	}
	public function photosedit_post(){
		
			
			$this->UsersModel = new UsersModel();
			$image = !empty($this->request->getVar('image')) ? $this->request->getVar('image') : '';
			$user_id = !empty($this->request->getVar('user_id')) ? $this->request->getVar('user_id') : $this->session->get('vr_sess_user_id');
			$user = $this->UsersModel->update_user_photos($this->request->getVar('p_id'),$user_id,$this->request->getVar('image_tag'),$image,$this->request->getVar('file_type'));
			
			$mainImageUrl = FCPATH .'uploads/userimages/' . $user_id . '/' . $this->request->getVar('image');
			$watermarkUrl = FCPATH .'uploads/sample-watermark.png';
			$savePath = FCPATH .'uploads/userimages/' . $user_id . '/' . $this->request->getVar('image');

			try {
				addWatermarkFromUrls($mainImageUrl, $watermarkUrl, $savePath, 20, 0.2);
				//echo "Watermark applied successfully. Saved to: $savePath";
			} catch (\Exception $e) {
				//echo "Error: " . $e->getMessage();
			}
			
			
			if ($user) {
				$photos = $this->UsersModel->get_user_photos($user_id,'',$this->request->getVar('product_id'));
				$html = '';
				if(!empty($photos)){
					$html .= '<input name="image_ids" class="form-control" type="hidden" value="'.$photos[0]['all_ids'].'" />';
					if(count($photos) > 1){
						$html .= '<p>('.trans('Drag and drop to organize your photos').')</p>';
					}
					$html .= '<ul class="row" id="imageListId">';
					$html .= $this->photo_arrange($photos,$user_id);
					$html .= '</ul>';
				}
				echo $html;
			} else {
				echo '2';
			}
		
	}
	public function photos_delete(){
		if($this->request->getVar('photo_id') != ''){
			$this->UsersModel = new UsersModel();
			$user = $this->UsersModel->delete_user_photos($this->request->getVar('photo_id'));
			$user_id = !empty($this->request->getVar('user_id')) ? $this->request->getVar('user_id') : $this->session->get('vr_sess_user_id');
			if ($user) {
				$photos = $this->UsersModel->get_user_photos($user_id,'',$this->request->getVar('product_id'));
				$html = '';
				if(!empty($photos)){
					$html .= '<input name="image_ids" class="form-control" type="hidden" value="'.$photos[0]['all_ids'].'" />';
					if(count($photos) > 1){
						$html .= '<p>('.trans('Drag and drop to organize your photos').')</p>';
					}
					$html .= '<ul class="row" id="imageListId">';
					$html .= $this->photo_arrange($photos,$user_id);
					$html .= '</ul>';
				}else{
					$html .= 'please upload.';
				}
				echo $html;
			} else {
				echo '2';
			}
		}
	}
	public  function photo_arrange($photos,$user_id){
		$html = '';
		foreach($photos as $r => $row){
			$html .= "<li class='col-6 col-md-3 listitemClass' id='imageNo".$row['id']."'><div class='pic'>";
			if($row['file_type']=='image'){
				$html .="<img width='100%' height='100px' style='display:block;' src='".base_url()."/uploads/userimages/".$user_id."/".$row['file_name']."'>";
			}else{
				$html .='
				<div class="video__wrapper" data-state="pause">
				  <button type="button" class="video__fullscreen-button"><svg class="video__fullscreen-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"><polygon points="0 0 0 5 2 5 2 2 5 2 5 0 "/><polygon points="14 0 9 0 9 2 12 2 12 5 14 5 "/><polygon points="14 14 14 9 12 9 12 12 9 12 9 14 "/><polygon points="0 14 5 14 5 12 2 12 2 9 0 9 "/></svg></button>
				  <a href="'.base_url().'/uploads/userimages/'.$user_id.'/'.$row["file_name"].'"
				   class="glightbox-video"
				   data-type="video"
				   data-width="1280"
				   data-height="720">
				   <button type="button" class="video__play-button" data-button-state="pause">
					<svg class="video__play-button-icon video__play-button-icon--play" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 140"><path fill-rule="evenodd" clip-rule="evenodd" fill="white" d="M70 140L70 140c-38.7 0-70-31.3-70-70l0 0C0 31.3 31.3 0 70 0l0 0c38.7 0 70 31.3 70 70l0 0C140 108.7 108.7 140 70 140z"/><polygon fill-rule="evenodd" clip-rule="evenodd" points="57 50.9 57 89.4 88.5 70.2 "/></svg>
					<svg class="video__play-button-icon video__play-button-icon--pause" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 140"><path fill-rule="evenodd" clip-rule="evenodd" fill="white" d="M70 140L70 140c-38.7 0-70-31.3-70-70v0C0 31.3 31.3 0 70 0h0c38.7 0 70 31.3 70 70v0C140 108.7 108.7 140 70 140z"/><rect fill-rule="evenodd" clip-rule="evenodd" x="56" y="50.8" class="st1" width="8.8" height="38.5"/><rect fill-rule="evenodd" clip-rule="evenodd" x="75.2" y="50.8" class="st1" width="8.8" height="38.5"/></svg>
				    </button>
					<video  muted playsinline preload="metadata" style="cursor: pointer;">
						<source src="'.base_url().'/uploads/userimages/'.$user_id.'/'.$row["file_name"].'" type="video/mp4">
						Your browser does not support the video tag.
					</video>
				</a>
				</div>';
			}
			$html .="<div class='d-flex justify-content-between bg-orange text-white py-1 px-3'><div class='trash' onclick='editphotos(".$row['id'].",this)' data-id='".$row['id']."' data-file-type='".$row['file_type']."' data-tags='".$row['image_tag']."' style='cursor:pointer'><i class='fa fa-pen'></i></div><div class='trash' onclick='deletephotos(".$row['id'].")' data-id='".$row['id']."' style='cursor:pointer'><i class='fa fa-trash-o'></i></div></div></div></li>
			";
		}
		return $html;
	}
	
	public function add_listing(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		if ($this->session->get('vr_sess_logged_in') == TRUE) {
			//if($data['user_detail']->plan_id <= 1 && $data['user_detail']->id > 1){
				//$this->session->setFlashData('error_form1', "Please select your plan to proceed further!");
				//return redirect()->to(base_url('/plan'));
			//}else{	
				$this->CategoriesModel = new CategoriesModel();
				$data['categories'] = $this->CategoriesModel->get_categories();
				$data['title'] = trans('What do you want to sell?');
				$data['meta_title'] = 'Sell | Plane Broker';
				
				$this->ProductModel = new ProductModel();
				$where = ' AND p.user_id = '.$data['user_detail']->id;
				$data['product_count'] = count($this->ProductModel->get_products($category_name='all',$where));
				
				if(!empty($_GET) && !empty($_GET['category'])){
					$data['title'] = trans('Create New Listing');			
					$this->CategoriesSubModel = new CategoriesSubModel();
					$data['sub_categories'] = $this->CategoriesSubModel->get_categories_by_ids($_GET['category']);
					
					//get dynamic fields
					$this->FieldsModel = new FieldsModel();
					$data['dynamic_fields'] = $this->FieldsModel->get_fields($_GET['category']);
					
					//delete old uploaded photos
					$this->UsersModel->delete_user_photos_id($this->session->get('vr_sess_user_id'));
					$data['product_detail'] = array();
					if(!empty($_GET) && !empty($_GET['category']) && !empty($_GET['id'])){
						//get product detail
						$where = ' AND p.id = '.$_GET['id'];
						$data['product_detail'] = $this->ProductModel->get_product_detail($where);
						$data['user_photos'] = $this->UsersModel->get_user_photos($this->session->get('vr_sess_user_id'),'',$_GET['id']);
					}
						
					$sale_id = !empty($_GET['sale_id']) ? $_GET['sale_id'] : '';	
					$payment_type = !empty($_GET['payment_type']) ? $_GET['payment_type'] : '';	
					$data['selected_sale_id'] = !empty(session()->get('selected_sale_id')) ? session()->get('selected_sale_id') : $sale_id ;
					$data['selected_payment'] = !empty(session()->get('selected_payment')) ? session()->get('selected_payment') : $payment_type ;
					$data['sale_detail'] = array();
					$data['sale_detail'] = $this->UsersModel->get_sales_by_id($this->request->getVar('sale_id'));
					
					
					return view('Providerauth/ProductAdd', $data);			
				}else{
					if($data['user_detail']->user_level == 1){	
						$data['sale_id'] = '';
						$data['payment_type'] = 'none';
					}
					return view('Providerauth/CategoryList', $data);			
				}
			//}			
		}else{
			return redirect()->to(base_url('/'));
		}
	}
	
	public function my_listing(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		if ($this->session->get('vr_sess_logged_in') == TRUE) {
				
			$this->CategoriesModel = new CategoriesModel();
			$data['categories'] = $this->CategoriesModel->get_categories();
			$data['title'] = trans('My Listing');
			$data['meta_title'] = 'My Listing | Plane Broker';
			
			$this->ProductModel = new ProductModel();
			$where = ' AND p.user_id = '.$data['user_detail']->id;
			$data['results'] = $this->ProductModel->get_products($category_name='all',$where);
			
			return view('Providerauth/ProductList', $data);
						
		}else{
			return redirect()->to(base_url('/'));
		}
	}
	
	public function change_plan_status(){
		$this->db->table('sales')->where('id', $_POST['sale_id'])->update(['is_cancel' => 0]);
		$this->db->table('products')->where('id', $_POST['product_id'])->update(['is_cancel' => 0]);
		echo 'success';
	}
	
	public function product_delete(){
		$id = $_POST['p_id'];
		$this->ProductModel = new ProductModel();
			
		$where = ' AND p.id = '.$id;
		$product = $this->ProductModel->get_products($category_name='all',$where);
		
		$this->UsersModel = new UsersModel();
		$user_detail = $this->UsersModel->get_user($product[0]['user_id']);
		if($user_detail->user_level == 1){
			//delete subs
			$this->db->table('sales')->where('id', $product[0]['sale_id'])->delete();
		}else{
			$this->db->table('sales')->where('id', $product[0]['sale_id'])->update(['product_id' => 0]);
		}	
		$this->ProductModel->delete_product($id);
	}
	
	public function product_status_change(){
		$id = $_POST['listing_id'];
		$status = $_POST['status'];
		$this->ProductModel = new ProductModel();
		$this->ProductModel->update($id, ['status' => $status]);		
	}
	
	public function favorites(){
		$data['title'] = trans('Favorites');
		$data['meta_title'] = 'Favorites | Plane Broker';
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		
        $this->CategoriesModel = new CategoriesModel();
		$data['categories'] = $this->CategoriesModel->get_categories();
		
		//get favorite product based on looged in user
		$this->ProductModel = new ProductModel();
		$where = ' AND p.id IN (select product_id from user_favorites where user_id = '.$data['user_detail']->id.') AND p.status=1 AND (p.is_cancel = 0 || s.stripe_subscription_end_date >= NOW()) and p.sale_id > 0';
		$data['results'] = $this->ProductModel->get_products($category_name=$data['categories'][0]->permalink,$where);
		
		return view('Providerauth/Favorites', $data);
	}
	public function analytics(){
		
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		if ($this->session->get('vr_sess_logged_in') == TRUE) {
				
			$this->CategoriesModel = new CategoriesModel();
			$data['categories'] = $this->CategoriesModel->get_categories();
			$data['title'] = trans('Analytics');
			$data['meta_title'] = 'Analytics | Plane Broker';
			
			$this->ProductModel = new ProductModel();
			
			if(!empty($_GET['id'])){
				$where = ' AND p.id = '.$_GET['id'];
				$data['results'] = $this->ProductModel->get_products($category_name='all',$where);
				
				
				if(!empty($_GET['start']) && !empty($_GET['end'])){
					$endDate = $_GET['end'].' 23:59:00';
					$startDate = $_GET['start'].' 00:00:00';
				}else{
					$endDate = date('Y-m-d', strtotime("+1 day")).' 23:59:00';
					$startDate = date('Y-m-d', strtotime("-1 month")).' 00:00:00';
				}		
				$data['view_count'] = $this->UsersModel->db->query('SELECT count(*) as view_count FROM `website_stats` where view_count = 1 AND product_id = '.$_GET['id'].' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->view_count;
		
				$data['call_count'] = $this->UsersModel->db->query('SELECT count(*) as call_count FROM `website_stats` where call_count = 1 AND product_id = '.$_GET['id'].' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->call_count;
		
				$data['form_count'] = $this->UsersModel->db->query('SELECT count(*) as form_count FROM `website_stats` where form_count = 1 AND product_id = '.$_GET['id'].' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->form_count;
				
				$data['favorites_count'] = $this->UsersModel->db->query('SELECT count(*) as favorites_count FROM `user_favorites` where product_id = '.$_GET['id'].' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->favorites_count;
								
				$data['share_count'] = $this->UsersModel->db->query('SELECT count(*) as share_count FROM `website_stats` where share_count = 1 AND product_id = '.$_GET['id'].' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->share_count;	
				
				$data['reveal_count'] = $this->UsersModel->db->query('SELECT count(*) as reveal_count FROM `website_stats` where reveal_count = 1 AND product_id = '.$_GET['id'].' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->reveal_count;
				
				
				//echo "<pre>";print_r($data['results']);exit;
				$uri = current_url(true);
		$data['title'] = trans('Dashboard');
		$latlngs = $this->UsersModel->db->query('SELECT u.location_id,sum(u.zipcode_count) as count,z.lat,z.long  FROM `users` u JOIN zipcodes z ON u.location_id = z.id WHERE u.zipcode_count > 0 group by u.location_id order by count desc;')->getResult();
		$arr = array();
		if(!empty($latlngs)){
			foreach($latlngs as $lat){
				for($i=1;$i<=$lat->count;$i++){
					$arr[] = array(
					  $lat->lat, $lat->long,
					); 
				}
			}
		}
		
		$data['direction_count'] = $this->UsersModel->db->query('SELECT count(*) as direction_count FROM `website_stats` where direction_count = 1 AND user_id = '.$this->session->get('vr_sess_user_id').' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->direction_count;
		$data['zipcode_count'] = $this->UsersModel->db->query('SELECT count(*) as zipcode_count FROM `website_stats` where  location_id = '.$data['user_detail']->location_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->zipcode_count;
		$data['impression_count'] = $this->UsersModel->db->query('SELECT count(*) as impression_count FROM `website_stats` where impression_count = 1 AND user_id = '.$this->session->get('vr_sess_user_id').' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->impression_count;
		
		
		$query2 =  $this->userModel->db->query('SELECT count(*) as user_count, zipcodes.city, zipcodes.zipcode, states.code as state_code FROM `website_stats` w LEFT JOIN zipcodes ON w.customer_zipcode = zipcodes.zipcode LEFT JOIN states ON zipcodes.state_id = states.id where w.customer_zipcode != ""  AND w.user_id = '.$this->session->get('vr_sess_user_id').' AND w.created_at <= "'.$endDate.'" AND w.created_at >= "'.$startDate.'" AND city != "" GROUP BY w.customer_zipcode order by user_count desc  limit 10')->getResult();
		$query1 =  $this->UsersModel->db->query('SELECT * FROM `website_stats` where customer_zipcode != ""  AND user_id = '.$this->session->get('vr_sess_user_id').' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'" GROUP BY created_at order by created_at desc LIMIT 20')->getResult();
		$query3 =  $this->UsersModel->db->query('SELECT * FROM `website_stats` where call_count = 1  AND user_id = '.$this->session->get('vr_sess_user_id').' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"  order by created_at desc LIMIT 20')->getResult();
		//print_r($query1);exit;	
        $data['top_locations'] = $query2;
        $data['top_calls'] = $query3;
		$data['recent_payments'] = $query1;

		$data['zipcodes'] = json_encode($arr);
		
				return view('Providerauth/AnalyticsDetail', $data);
			}else{
				$where = ' AND p.user_id = '.$data['user_detail']->id;
				$data['results'] = $this->ProductModel->get_products($category_name='all',$where);
				return view('Providerauth/Analytics', $data);
			}
						
		}else{
			return redirect()->to(base_url('/'));
		}
	}
	public function help(){
		$data['title'] = trans('Help/Support');
		$data['meta_title'] = 'Help | Plane Broker';
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$this->SupportModel = new SupportModel();
		$data['supports'] = $this->SupportModel->get_all_support();
		
		
		return view('Providerauth/Help', $data);
	}
	public function account_settings(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$data['title'] = trans('Account Settings');
		$data['meta_title'] = 'Account Settings | Plane Broker';
        return view('Providerauth/ProviderAccountSettings', $data);
	}
	
	public function edit_account_post(){
		//echo "<pre>";print_r($this->request);exit;
		$userModel = new UsersModel();
		$user = $userModel->update_user_account($this->request->getVar('id'));
		if ($user) {
			$this->session->setFlashData('success_form', trans("Account Updated Successfully!"));
			return redirect()->to(base_url('account-settings'));
		} else {
			//error
			$this->session->setFlashData('errors_form', trans("There was a problem during update. Please try again!"));
			return redirect()->to($this->agent->getReferrer())->withInput();
		}
	}
	
	public function edit_password_post(){
		//echo "<pre>";print_r($this->request);exit;
		$userModel = new UsersModel();
		//check current Password
		$check_current = $userModel->get_user($this->request->getVar('id'));
		
		if (!password_verify($this->request->getVar('current_password'), $check_current->password)) {
			$this->session->setFlashData('errors_form', 'Wrong current password!');
			$this->session->setFlashData('activeTab', 'update-password');
			return redirect()->to($this->agent->getReferrer())->withInput();
		}
			
		$user = $userModel->update_user_password($this->request->getVar('id'));
		if ($user) {
			$this->session->setFlashData('success_form', trans("Password Updated Successfully!"));
			return redirect()->to(base_url('account-settings'));
		} else {
			//error
			$this->session->setFlashData('errors_form', trans("There was a problem during update. Please try again!"));
			return redirect()->to($this->agent->getReferrer())->withInput();
		}
	}
	
	public function checkout(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$this->PlansModel = new PlansModel();
		$data['plan_detail'] = $this->PlansModel->get_plans_by_id($this->request->getVar('plan_id'));
		$data['customer']         ='';
		
		$card_existing = array();
		if(!empty($_GET['sale_id'])){
			$card_existing = $this->UsersModel->get_sales_by_id($_GET['sale_id']);
		}else{
			$card_existing_res = $this->UsersModel->get_sales_user_with_cus_id($this->session->get('vr_sess_user_id'));
			$card_existing = (count($card_existing_res) > 0) ? $card_existing_res[0] : array() ;
		}
		if(!empty($card_existing) && $card_existing->stripe_subscription_customer_id != '' && $card_existing->payment_type=='Stripe'){
			$customerId = $card_existing->stripe_subscription_customer_id;
			$data['customerId'] = $customerId;
			//get all payment methods
			Stripe\Stripe::setApiKey(env('stripe.secret'));			
			$cards = \Stripe\Customer::allSources($customerId);	
			$data['cards']         = $cards;	
			$customer = Customer::retrieve($customerId);	
			$data['customer']         = $customer;
		}
				
		$data['title'] = trans('Checkout');
		$data['type'] = !empty($this->request->getVar('type')) ? $this->request->getVar('type') : '';
		
		$data['meta_title'] = !empty(get_seo('Checkout')) ? get_seo('Checkout')->meta_title : 'Checkout | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Checkout')) ? get_seo('Checkout')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Checkout')) ? get_seo('Checkout')->meta_keywords : '';
        return view('Providerauth/ProviderCheckout', $data);
	}
	
	public function upgrade_stripe(){
		// Example values - replace with real values from your DB or form
		$subscriptionId = 'sub_123456789'; // stored in your DB
		$newPriceId = 'price_ABCDEF123';   // ID of the new upgraded plan

		// Retrieve current subscription
		$subscription = Subscription::retrieve($subscriptionId);

		// Update the subscription's items
		Subscription::update($subscriptionId, [
			'items' => [
				[
					'id' => $subscription->items->data[0]->id,
					'price' => $newPriceId, // the upgraded plan's price ID
				],
			],
			'proration_behavior' => 'create_prorations', // to prorate cost differences
		]);
	}
	
	public function checkout_post(){
		//print_r($_POST);exit;
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$user_id = !empty($_POST['user_id']) ? $_POST['user_id'] : $this->session->get('vr_sess_user_id') ;
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($user_id);
		$this->PlansModel = new PlansModel();
		$data['plan_detail'] = $this->PlansModel->get_plans_by_id($this->request->getVar('plan_id'));
		$data['sale_detail'] = array();
		$data['sale_detail'] = $this->UsersModel->get_sales_by_id($this->request->getVar('sale_id'));
		
						
		//echo $this->request->getVar('type');exit;
		$rules = [
        ];
		$customerId = '';
        if (!empty($_POST['stripeToken']) || !empty($_POST['card_id'])) {
			$error_message = '';
			$priceid = $data['plan_detail'][0]->stripe_price_id;
					
			try {
				// Set your Stripe secret key
				Stripe\Stripe::setApiKey(env('stripe.secret'));
				if (!empty($_POST['stripeToken'])){
				$token = $_POST['stripeToken'];
				}	
				if(!empty($data['sale_detail']) && $data['sale_detail']->plan_id >= 1 && !empty($data['sale_detail']->stripe_subscription_customer_id) && !empty($data['sale_detail']->stripe_subscription_id) && $data['sale_detail']->is_cancel == 0){

					if(strtolower($this->request->getVar('payment_type')) == 'paypal'){
						$subscriptionId = $data['sale_detail']->stripe_subscription_id;
						$access_token = $this->get_paypal_access_token();
						$curl = curl_init();
						//To Cancel subs
						curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl')."billing/subscriptions/".$subscriptionId."/cancel");		
						curl_setopt($curl, CURLOPT_POST, true);
						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($curl, CURLOPT_HEADER, false);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($curl, CURLOPT_HTTPHEADER, array(
							'Authorization: Bearer ' . $access_token,
							'Accept: application/json',
							'Content-Type: application/json'
						));
						$response = curl_exec($curl);
						$result = json_decode($response,true);
						//$this->db->table('sales')->where('id', $data['sale_detail']->id)->update(['is_cancel' => 1]);
						$this->db->table('sales')->where('id', $data['sale_detail']->id)->update(['plan_id' => $this->request->getVar('plan_id')]);
						$this->db->table('products')->where('id', $data['sale_detail']->product_id)->update(['plan_id' => $this->request->getVar('plan_id')]);
						if (!empty($_POST['stripeToken'])){
							// Get the Stripe customer ID
							$customerId = $this->createStripeCustomer($token);	
						}
					}else{
						$customerId = $data['sale_detail']->stripe_subscription_customer_id;
						$subscriptionId = $data['sale_detail']->stripe_subscription_id;
						$subscription_cancel = Subscription::retrieve($subscriptionId,[]);
						Subscription::update($subscriptionId, [
							'items' => [
								[
									'id' => $subscription_cancel->items->data[0]->id,
									'price' => $priceid,
								],
							],
							'proration_behavior' => 'create_prorations',
						]);
						//$subscription_cancel->cancel();	
						$this->db->table('sales')->where('id', $data['sale_detail']->id)->update(['plan_id' => $this->request->getVar('plan_id')]);	
						$this->db->table('products')->where('id', $data['sale_detail']->product_id)->update(['plan_id' => $this->request->getVar('plan_id')]);
						if(!empty($_POST['from_end']) && $_POST['from_end'] == 'admin'){
							$this->session->setFlashData('success', trans("Subscription Upgraded Successfully!"));
							return redirect()->to(admin_url().'listings/sales');
						}else{
							$this->session->setFlashData('success_form', trans("Subscription Upgraded Successfully!"));
							return redirect()->to(base_url('subscriptions'));
						}
					}
				}else{
					if (!empty($_POST['stripeToken'])){
						// Get the Stripe customer ID
						$customerId = $this->createStripeCustomer($token);	
					}else{
					    $customerId = $_POST['customer_id'];
					}					
				}
					if (!empty($_POST['stripeToken'])){
						$token_detail = \Stripe\Token::retrieve( $token );
						$card = '';
						$customer = \Stripe\Customer::allSources($customerId);
						$card_id = '';
						foreach ( $customer->data as $source ) {
							if ( $source->fingerprint == $token_detail->card->fingerprint ) {
								$card = $source;
								$card_id = $source->id;
							}
						}
						if(empty($card)){
							$attachsource = \Stripe\Customer::createSource($customerId,
							  [
								'source' => $token,
							  ]);
							$card_id = $attachsource->id;
						}
						if(!empty($card_id)){
							// Update the customer's default payment method
							$customer = \Stripe\Customer::retrieve($customerId);
							$customer->default_source = $card_id;
							$customer->save();
						}
					}
					if(!empty($_POST['card_id']) && $_POST['card_id'] != 'new'){
						// Update the customer's default payment method
						$customer = \Stripe\Customer::retrieve($customerId);
						$customer->default_source = $_POST['card_id'];
						$customer->save();
					}				
					$usertrial = 0;
					if(!empty($this->request->getVar('type')) && $this->request->getVar('type') == 'trial'){
						// Create the subscription
						$subscription = Subscription::create([
							'customer' => $customerId,
							'items' => [
								['price' => $priceid],
							],		            
							'cancel_at_period_end' => false,
							'metadata' => [
								'title' => 'Plane Broker '.$data['plan_detail'][0]->name.' Plan',
								'description' => $data['plan_detail'][0]->name.' Plan',
							],
							'trial_period_days' => 30,
						]);
						$insertTrial = [
							'user_id' => $data['user_detail']->id,
							'plan_id' => $this->request->getVar('plan_id')
						];
						$usertrial = $this->UsersModel->insert_user_trial($insertTrial);						
					}else{
						// Create the subscription
						$subscription = Subscription::create([
							'customer' => $customerId,
							'items' => [
								['price' => $priceid],
							],		            
							'cancel_at_period_end' => false,
							'metadata' => [
								'title' => 'Plane Broker '.$data['plan_detail'][0]->name.' Plan',
								'description' => $data['plan_detail'][0]->name.' Plan',
							],
						]);					
					}
				
				// Retrieve the subscription ID
				$subscriptionId = $subscription->id;
				// Retrieve the subscription Item ID
				$subscriptionItemId = $subscription->items->data[0]->id;

				// Retrieve the invoice associated with the subscription
				$invoice = \Stripe\Invoice::retrieve($subscription->latest_invoice);
				
				$stripe_subscription_id               = $invoice->subscription;
				$stripe_subscription_customer_id      = $invoice->customer;
				$stripe_subscription_price_id         = $invoice->lines->data[0]->price->id;

				$stripe_subscription_amount_paid      = $invoice->amount_paid;
				$stripe_subscription_amount_paid      = number_format($stripe_subscription_amount_paid / 100, 2, '.', '');

				$stripe_subscription_start_date       = $invoice->lines->data[0]->period->start;
				$stripe_subscription_end_date         = $invoice->lines->data[0]->period->end;
				$stripe_subscription_start_date       = date('Y-m-d H:i:s', $stripe_subscription_start_date);
				$stripe_subscription_end_date         = date('Y-m-d H:i:s', $stripe_subscription_end_date);

				$stripe_invoice_id                    = $subscription->latest_invoice;
				$stripe_invoice_charge_id             = $invoice->charge;
				$stripe_invoice_status                = $invoice->status;
				$sales_created_at                     = date('Y-m-d H:i:s');
				
				$data_insert = [
					'user_id'                         => $user_id,
					'stripe_subscription_id'          => $stripe_subscription_id,
					'stripe_subscription_customer_id' => $stripe_subscription_customer_id,
					'stripe_subscription_price_id'    => $stripe_subscription_price_id,
					'stripe_subscription_amount_paid' => $stripe_subscription_amount_paid,
					'stripe_subscription_start_date'  => $stripe_subscription_start_date,
					'stripe_subscription_end_date'    => $stripe_subscription_end_date,
					'stripe_invoice_id'               => $stripe_invoice_id,
					'stripe_invoice_charge_id'        => $stripe_invoice_charge_id,
					'stripe_invoice_status'           => $stripe_invoice_status,
					'created_at'                      => $sales_created_at,
					'trial_id' 						  => $usertrial,
					'plan_id'                         => $this->request->getVar('plan_id'),
					'category_id'                     => (!empty($data['sale_detail'])) ? $data['sale_detail']->category_id :0,
					'stripe_subscription_item_id'     => $subscriptionItemId,
					'stripe_subscription_status'      => $subscription->status,
					'admin_plan_update'               => 0,
					'admin_plan_end_date'             => NULL,
					'is_cancel'						  => 0
				];
				if(!empty($this->request->getVar('type')) && $this->request->getVar('type') == 'trial'){
					$data_insert['is_trial'] = 1;
				}else{
					$data_insert['is_trial'] = 0;
				}
				if(!empty($data['sale_detail'])){
					$user1 = $this->db->table('sales')->where('id', $data['sale_detail']->id)->update($data_insert);
				}else{
					$user1 = $this->UsersModel->insert_sales($data_insert);
				}
				session()->set('selected_payment', 'stripe');
				session()->set('selected_sale_id', $user1);

				$updateUser = [
								'plan_id'                         => $this->request->getVar('plan_id'),
								'stripe_subscription_customer_id' => $stripe_subscription_customer_id,
								'stripe_invoice_id'               => $stripe_invoice_id,
								'stripe_subscription_price_id'    => $stripe_subscription_price_id,
								'stripe_subscription_id'          => $stripe_subscription_id,
								'stripe_subscription_start_date'  => $stripe_subscription_start_date,
								'stripe_subscription_end_date'    => $stripe_subscription_end_date,
								'stripe_subscription_item_id'     => $subscriptionItemId,
								'stripe_subscription_status'      => $subscription->status,
								'admin_plan_update'               => 0,
								'admin_plan_end_date'             => NULL,
								'is_cancel'						  => 0
							  ];
				if(!empty($this->request->getVar('type')) && $this->request->getVar('type') == 'trial'){
					$updateUser['is_trial'] = 1;
				}else{
					$updateUser['is_trial'] = 0;
				}
				$updateUser['payment_type'] = "Stripe";
				$user = $this->UsersModel->update_user_plan($user_id,$updateUser);
				if(!empty($this->request->getVar('type')) && $this->request->getVar('type') == 'trial'){
					$this->session->setFlashData('success_form', trans("Your Free Trial plan has been selected, unlocking new features and benefits! payment will be deducted after 30 days."));
				}else{
					$this->session->setFlashData('success_form', trans("Your plan has been selected, unlocking new features and benefits!"));
				}
				
				$user_detail = $this->UsersModel->get_user($user_id);
				if(!empty($user_detail->email)){
					$emailModel = new EmailModel();	
					if(empty($data['user_detail']->stripe_subscription_id)){
						$emailModel->send_email_activation_confirmed($data['user_detail']->id);
					}
					$data = array(	
						'subject' => "Payment Confirmation",
						'to' => $user_detail->email,
						'to_name'           => !empty($user_detail->fullname) ? $user_detail->fullname : 'User',
						'template_path' => "email/email_payment_confirmation",
						'token' => $user_detail->token	
					);
					$emailModel->send_email($data);	
					$data_admin = array(	
						'subject' => "New Subscription by Plane Broker",
						'from_email' => get_general_settings()->admin_email,
						'to' => get_general_settings()->mail_reply_to,
						'message_text'  => $user_detail->business_name.' - '.$user_detail->email. ' has been created new subscription(Stripe).',
						'template_path' => "email/admin/new_user"	
					);	
					$emailModel->send_email($data_admin);
				}
				//return redirect()->to(base_url('billing'));
				
					if(!empty($_POST['from_end']) && $_POST['from_end'] == 'admin'){
						return redirect()->to(admin_url().'listings/add?user_id='.$this->request->getVar('user_id').'&sale_id='.$user1.'&plan_id='.$this->request->getVar('plan_id').'&payment_type=stripe&proceed=listing');
					}else{
						return redirect()->to(base_url('add-listing?sale_id='.$user1.'&payment_type=stripe'));
					}

			} catch (\Stripe\Exception\ApiErrorException $e) {
				$error_message = $e->getMessage();
			}
			

		    if(!empty($error_message)){
				if(!empty($this->request->getVar('type'))){
					if(!empty($_POST['from_end']) && $_POST['from_end'] == 'admin'){
						$this->session->setFlashData('error', $error_message);
						return redirect()->to(admin_url().'listings/change_plan?new_plan_id='.$this->request->getVar('plan_id').'&user_id='.$this->request->getVar('user_id').'&sale_id='.$this->request->getVar('sale_id').'&type='.$this->request->getVar('type'));
					}else{
						$this->session->setFlashData('errors_form', $error_message);
						return redirect()->to(base_url('checkout?plan_id='.$this->request->getVar('plan_id').'&type='.$this->request->getVar('type')));
					}
				}else{
					if(!empty($_POST['from_end']) && $_POST['from_end'] == 'admin'){
						return redirect()->to(admin_url().'listings/change_plan?new_plan_id='.$this->request->getVar('plan_id').'&user_id='.$this->request->getVar('user_id').'&sale_id='.$this->request->getVar('sale_id'));
					}else{
						return redirect()->to(base_url('checkout?plan_id='.$this->request->getVar('plan_id')));	
					}
				}
			}
		} else {
            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->to($this->agent->getReferrer())->withInput();
        }			
	}

	private function createStripeCustomer($token)
    {
        // Create a new customer in Stripe
        $customer = Customer::create([
            'email' => $this->session->get('vr_sess_user_email'),
			'source' => $token,
			'name' => 'Amit Sharma',
			'address' => [
				'line1' => '123 MG Road',
				'city' => 'Mumbai',
				'state' => 'MH',
				'postal_code' => '400001',
				'country' => 'IN',
			],
			
        ]);

        // Get and return the customer ID
        return $customer->id;
    }
	public function thankyou(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$data = array();
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$data['title'] = trans('Thank You');
		$data['meta_title'] = !empty(get_seo('Thank You')) ? get_seo('Thank You')->meta_title : 'Thank You | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Thank You')) ? get_seo('Thank You')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Thank You')) ? get_seo('Thank You')->meta_keywords : '';
        return view('pages/thankyou', $data);        
		
	}
	public function crop(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$data = array();
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$data['title'] = trans('Thank You');
		$data['meta_title'] = 'Thank You | Plane Broker';
        return view('pages/crop', $data);        
		
	}
	
	public function subscriptions(){

		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		/*if($data['user_detail']->payment_type == 'Stripe'){
			// Set your Stripe secret key
			Stripe\Stripe::setApiKey(env('stripe.secret'));
			
			$subscriptions = $cards = array();
			// Retrieve all subscriptions of the customer
			if($data['user_detail']->stripe_subscription_customer_id != ''){
				$customerId = $data['user_detail']->stripe_subscription_customer_id;

				$subscriptions = Subscription::all([
				'customer' => $customerId,
				]);

				$customer = Customer::retrieve($customerId);
				$paymentMethods = PaymentMethod::all([
					'customer' => $customerId,
					'type' => 'card',
				]);
				$cards = $paymentMethods->data[0] ?? array();
			}
		}else{
			$subscriptions = $cards = array();
			$access_token = $this->get_paypal_access_token();
		
			$curl = curl_init();		
			//For subs detail
			curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl')."billing/subscriptions/".$data['user_detail']->stripe_subscription_id."?fields=plan");
			curl_setopt($curl, CURLOPT_POST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Authorization: Bearer ' . $access_token,
				'Accept: application/json',
				'Content-Type: application/json'
			));
			$response = curl_exec($curl);
			$subscriptions = $result = json_decode($response);
			//echo "<pre>";print_r($result);exit;
			
		} */
		$data['subscriptions'] = array();//$subscriptions;
		$data['cards']         = array();//$cards;
		
		$data['payment_history']         = $this->payment_history();
		//$data['payment_methods']         = $this->update_card();
		
		
		$this->ProductModel = new ProductModel();
		$where = ' AND p.user_id = '.$data['user_detail']->id;
		$data['results'] = $this->ProductModel->get_products($category_name='all',$where);
		
		$data['title'] = trans('Subscriptions');
		$data['meta_title'] = 'Subscriptions | Plane Broker';
        return view('Providerauth/ProviderSubscriptions', $data);
	}
	
	public function remove_favorite(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$productId = $_POST['p_id'];
		$this->db->table('user_favorites')->where('product_id', $productId)->where('user_id', $this->session->get('vr_sess_user_id'))->delete();
		echo 'success';
	}
	
	public function favorites_add(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
			session()->set('redirect_after_login', $this->request->getPost('current_url'));
            return $this->response->setJSON([
                'status' => 'redirect',
                'url' => base_url('login?redirect=' . $this->request->getPost('current_url'))
            ]);
        }
		$productId = $this->request->getPost('product_id');
        $userId = $this->session->get('vr_sess_user_id');

        $db = \Config\Database::connect();
        if($this->request->getPost('wish') == 0){
            $builder = $db->table('user_favorites');
            $builder->ignore(true)->insert([
                'user_id'    => $userId,
                'product_id' => $productId
            ]);
             return $this->response->setJSON(['status' => 'added']);
        }else{
            $db->table('user_favorites')->where('user_id', $userId)->where('product_id', $productId)->delete();
             return $this->response->setJSON(['status' => 'removed']);
        }

       
	}
	
    public function billing(){

		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		if($data['user_detail']->payment_type == 'Stripe'){
			// Set your Stripe secret key
			Stripe\Stripe::setApiKey(env('stripe.secret'));
			
			$subscriptions = $cards = array();
			// Retrieve all subscriptions of the customer
			if($data['user_detail']->stripe_subscription_customer_id != ''){
				$customerId = $data['user_detail']->stripe_subscription_customer_id;

				$subscriptions = Subscription::all([
				'customer' => $customerId,
				]);

				$customer = Customer::retrieve($customerId);
				$paymentMethods = PaymentMethod::all([
					'customer' => $customerId,
					'type' => 'card',
				]);
				$cards = $paymentMethods->data[0] ?? array();
			}
		}else{
			$subscriptions = $cards = array();
			$access_token = $this->get_paypal_access_token();
		
			$curl = curl_init();		
			//For subs detail
			curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl')."billing/subscriptions/".$data['user_detail']->stripe_subscription_id."?fields=plan");
			curl_setopt($curl, CURLOPT_POST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Authorization: Bearer ' . $access_token,
				'Accept: application/json',
				'Content-Type: application/json'
			));
			$response = curl_exec($curl);
			$subscriptions = $result = json_decode($response);
			//echo "<pre>";print_r($result);exit;
			
		}
		$data['subscriptions'] = $subscriptions;
		$data['cards']         = $cards;
		
		$data['payment_history']         = $this->payment_history_billing();
		$data['payment_methods']         = $this->update_card();
		
		$data['title'] = trans('Billing');
		$data['meta_title'] = 'Billing | Plane Broker';
        return view('Providerauth/ProviderBilling', $data);
	}

	public function billing_cancel(){
		// Set your Stripe secret key
		$subscriptionId = $this->request->uri->getSegment(3);
		$payment_type = $this->request->uri->getSegment(4);
		$request_from = !empty($this->request->uri->getSegment(5)) ? $this->request->uri->getSegment(5) : '';
		if(empty($subscriptionId)){
			 //return redirect()->to(base_url('/'));
		}
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$sale_detail = $this->UsersModel->get_sales_by_id($subscriptionId);
		if($payment_type == 'Stripe'){
			
			
			if(!empty($sale_detail) && $sale_detail->stripe_subscription_customer_id != NULL){
			Stripe\Stripe::setApiKey(env('stripe.secret'));
			try {
				$subscriptionId = $sale_detail->stripe_subscription_id;
				// Retrieve the subscription from Stripe
				$subscription = Subscription::retrieve($subscriptionId);

				// Cancel the subscription at the end of the billing period
				$subscription->cancel();

				$updateUser = [
								'stripe_subscription_customer_id' => NULL,
								'stripe_invoice_id'				  => NULL,
								'stripe_subscription_price_id'    => NULL,
								'stripe_subscription_id'          => NULL,
								'stripe_subscription_start_date'  => NULL,
								'stripe_subscription_end_date'    => NULL,
								'stripe_subscription_end_date'    => NULL,
								'stripe_subscription_status'      => NULL,
								'is_cancel'						  => 1
							  ];
				$updateUser['payment_type'] = "Stripe";
				$this->UsersModel = new UsersModel();							
				$s_detail = $this->db->table('sales')->where('stripe_subscription_id',$subscriptionId)->get()->getRow();  
				$user = $this->UsersModel->update_user_plan($this->session->get('vr_sess_user_id'),$updateUser);
				$this->db->table('sales')->where('stripe_subscription_id',$subscriptionId)->update(['is_cancel' => 1]);
				$this->db->table('products')->where('id', $s_detail->product_id)->update(['is_cancel' => 1]);
				$emailModel = new EmailModel();	
				$data = array(	
					'subject' => "Confirmation: Your Subscription Cancellation",
					'to' => $data['user_detail']->email,
					'to_name' => !empty($data['user_detail']->fullname) ? $data['user_detail']->fullname : 'User',
					'template_path' => "email/email_subs_cancellation"
				);
				$emailModel->send_email($data);
				
				// Handle the cancellation success
				if($request_from == 'admin'){
					$this->session->setFlashData('success', trans("Subscription canceled successfully!"));
					return redirect()->to(admin_url().'listings/sales');
				}else{
					$this->session->setFlashData('success_form', trans("Subscription canceled successfully!"));
					return redirect()->to(base_url('subscriptions'));
				}
			} catch (\Stripe\Exception\ApiErrorException $e) {
				// Handle the cancellation error
				$error_message = 'Failed to cancel the subscription: ' . $e->getMessage();
				$this->session->setFlashData('errors_form', $error_message);
				if($request_from == 'admin'){
					return redirect()->to(admin_url().'listings/sales');
				}else{
					return redirect()->to(base_url('subscriptions'));
				}
			}
			}else{
				$this->db->table('sales')->where('id',$subscriptionId)->update(['is_cancel' => 1]);
				$this->db->table('products')->where('id', $sale_detail->product_id)->update(['is_cancel' => 1]);
				$emailModel = new EmailModel();	
				$data = array(	
					'subject' => "Confirmation: Your Subscription Cancellation",
					'to' => $data['user_detail']->email,
					'to_name' => !empty($data['user_detail']->fullname) ? $data['user_detail']->fullname : 'User',
					'template_path' => "email/email_subs_cancellation"
				);
				$emailModel->send_email($data);
				
				// Handle the cancellation success
				if($request_from == 'admin'){
					$this->session->setFlashData('success', trans("Subscription canceled successfully!"));
					return redirect()->to(admin_url().'listings/sales');
				}else{
					$this->session->setFlashData('success_form', trans("Subscription canceled successfully!"));
					return redirect()->to(base_url('subscriptions'));
				}
			}
		}else{
			if(!empty($sale_detail) && $sale_detail->stripe_subscription_customer_id != NULL){
				$subscriptionId = $sale_detail->stripe_subscription_id;
			}
			$access_token = $this->get_paypal_access_token();
			$curl = curl_init();			
			
			//To Cancel subs
			curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl')."billing/subscriptions/".$subscriptionId."/cancel");		
			curl_setopt($curl, CURLOPT_POST, true);			
			
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Authorization: Bearer ' . $access_token,
				'Accept: application/json',
				'Content-Type: application/json'
			));
			$response = curl_exec($curl);
			$result = json_decode($response,true);
			//echo "<pre>";print_r($result);exit;
			$updateUser = [
							'stripe_subscription_customer_id' => NULL,
							'stripe_invoice_id'				  => NULL,
							'stripe_subscription_price_id'    => NULL,
							'stripe_subscription_id'          => NULL,
							'stripe_subscription_start_date'  => NULL,
							'stripe_subscription_end_date'    => NULL,
							'stripe_subscription_end_date'    => NULL,
							'stripe_subscription_status'      => NULL,
							'is_cancel'						  => 1,
							'plan_id'=>1
						  ];
			$updateUser['payment_type'] = "Paypal";
			$this->UsersModel = new UsersModel();			
			$s_detail = $this->db->table('sales')->where('stripe_subscription_id',$subscriptionId)->get()->getRow();				  
			$user = $this->UsersModel->update_user_plan($this->session->get('vr_sess_user_id'),$updateUser);
			$this->db->table('sales')->where('stripe_subscription_id',$subscriptionId)->update(['is_cancel' => 1]);
			$this->db->table('products')->where('id', $s_detail->product_id)->update(['is_cancel' => 1]);
			$emailModel = new EmailModel();	
			$data = array(	
				'subject' => "Confirmation: Your Subscription Cancellation",
				'to' => $data['user_detail']->email,
				'to_name' => !empty($data['user_detail']->fullname) ? $data['user_detail']->fullname : 'User',
				'template_path' => "email/email_subs_cancellation"
			);
			$emailModel->send_email($data);
			
			// Handle the cancellation success
			
			if($request_from == 'admin'){
				$this->session->setFlashData('success', trans("Subscription canceled successfully!"));
				return redirect()->to(admin_url().'listings/sales');
			}else{
				$this->session->setFlashData('success_form', trans("Subscription canceled successfully!"));
				return redirect()->to(base_url('subscriptions'));
			}
		}
	}
	
	
	public function billing_cancel_refund(){
		// Set your Stripe secret key
		$subscriptionId = $this->request->uri->getSegment(3);
		$payment_type = $this->request->uri->getSegment(4);
		$request_from = !empty($this->request->uri->getSegment(5)) ? $this->request->uri->getSegment(5) : '';
		if(empty($subscriptionId)){
			 //return redirect()->to(base_url('/'));
		}
		$this->UsersModel = new UsersModel();
		$sale_detail = $this->UsersModel->get_sales_by_id($subscriptionId);
		$user_detail = $this->UsersModel->get_user($sale_detail->user_id);
		if($payment_type == 'Stripe'){
			
			if(!empty($sale_detail) && $sale_detail->stripe_subscription_customer_id != NULL){
			Stripe\Stripe::setApiKey(env('stripe.secret'));
			try {
				$subscriptionId = $sale_detail->stripe_subscription_id;
				// Retrieve the subscription from Stripe
				$subscription = Subscription::retrieve($subscriptionId);
				$start = $subscription->current_period_start; // UNIX timestamp
				$end   = $subscription->current_period_end;
				$now   = time();
				$totalSeconds     = $end - $start;
				$remainingSeconds = $end - $now;
				$ratio            = $remainingSeconds / $totalSeconds;
				
				$invoice = \Stripe\Invoice::retrieve($subscription->latest_invoice);
				$amountPaid = $invoice->amount_paid; // in cents
				$paymentIntentId = $invoice->payment_intent;
				
				$refundAmount = intval($amountPaid * $ratio); // in cents
				
				$refund = \Stripe\Refund::create([
					'payment_intent' => $paymentIntentId,
					'amount' => $refundAmount, // optional if full refund
				]);
				
				// Cancel the subscription immediately
				\Stripe\Subscription::update($subscriptionId, [
					'cancel_at_period_end' => false,
				]);
				//\Stripe\Subscription::cancel($subscriptionId);
				$subscription->cancel();

				$updateUser = [
								'stripe_subscription_customer_id' => NULL,
								'stripe_invoice_id'				  => NULL,
								'stripe_subscription_price_id'    => NULL,
								'stripe_subscription_id'          => NULL,
								'stripe_subscription_start_date'  => NULL,
								'stripe_subscription_end_date'    => NULL,
								'stripe_subscription_status'      => NULL,
								'is_cancel'						  => 1
							  ];
				//$updateUser['payment_type'] = "Stripe";
				$this->UsersModel = new UsersModel();			
				$s_detail = $this->db->table('sales')->where('stripe_subscription_id',$subscriptionId)->get()->getRow();				  
				//$user = $this->UsersModel->update_user_plan($this->session->get('vr_sess_user_id'),$updateUser);
				$this->db->table('sales')->where('stripe_subscription_id',$subscriptionId)->update($updateUser);
				$this->db->table('products')->where('id', $s_detail->product_id)->update(['is_cancel' => 1]);
				$emailModel = new EmailModel();	
				$data = array(	
					'subject' => "Confirmation: Your Subscription Cancellation",
					'to' => $user_detail->email,
					'to_name' => !empty($user_detail->fullname) ? $user_detail->fullname : 'User',
					'template_path' => "email/email_subs_cancellation"
				);
				$emailModel->send_email($data);
				
				// Handle the cancellation success
				if($request_from == 'admin'){
					$this->session->setFlashData('success', trans("Subscription canceled and refund initiated successfully!"));
					return redirect()->to(admin_url().'listings/sales');
				}else{
					$this->session->setFlashData('success_form', trans("Subscription canceled and refund initiated successfully!"));
					return redirect()->to(base_url('subscriptions'));
				}
			} catch (\Stripe\Exception\ApiErrorException $e) {
				// Handle the cancellation error
				$error_message = 'Failed to cancel the subscription: ' . $e->getMessage();
				if($request_from == 'admin'){
					$this->session->setFlashData('error', $error_message);
					return redirect()->to(admin_url().'listings/sales');
				}else{
					$this->session->setFlashData('errors_form', $error_message);
					return redirect()->to(base_url('subscriptions'));
				}
			}
			}else{
				$this->db->table('sales')->where('id',$subscriptionId)->update(['is_cancel' => 1]);
				$this->db->table('products')->where('id', $sale_detail->product_id)->update(['is_cancel' => 1]);
				$emailModel = new EmailModel();	
				$data = array(	
					'subject' => "Confirmation: Your Subscription Cancellation",
					'to' => $user_detail->email,
					'to_name' => !empty($user_detail->fullname) ? $user_detail->fullname : 'User',
					'template_path' => "email/email_subs_cancellation"
				);
				$emailModel->send_email($data);
				
				// Handle the cancellation success
				if($request_from == 'admin'){
					$this->session->setFlashData('success', trans("Subscription canceled successfully!"));
					return redirect()->to(admin_url().'listings/sales');
				}else{
					$this->session->setFlashData('success_form', trans("Subscription canceled successfully!"));
					return redirect()->to(base_url('subscriptions'));
				}
			}
		}else{
			$subscriptionId = $sale_detail->stripe_subscription_id;
			$access_token = $this->get_paypal_access_token();
			
				// 1. Get subscription details
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl') . "billing/subscriptions/$subscriptionId");
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER, [
					'Authorization: Bearer ' . $access_token,
					'Accept: application/json',
				]);
				$response = curl_exec($curl);
				curl_close($curl);
				$subscription = json_decode($response, true);
				$amount = $subscription['billing_info']['last_payment']['amount']['value'] ?? null;
				$currency = $subscription['billing_info']['last_payment']['amount']['currency_code'] ?? 'USD';
				$payer_email = $subscription['subscriber']['email_address'] ?? null;
				$last_payment_time = $subscription['billing_info']['last_payment']['time'] ?? null;
				//PayPal does not return capture_id directly in the subscription object, so you must search transactions via:
				$startDate = gmdate('Y-m-d\TH:i:s\Z', strtotime($last_payment_time . ' -1 day'));
				$endDate   = gmdate('Y-m-d\TH:i:s\Z', strtotime($last_payment_time . ' +2 day'));
				$start = urlencode($startDate); // 2025-06-25T11%3A06%3A30Z
				$end   = urlencode($endDate); 
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl')."reporting/transactions?start_date=$start&end_date=$end&transaction_status=S&fields=all&page_size=20");
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER, [
					'Authorization: Bearer ' . $access_token,
					'Accept: application/json',
				]);
				$response = curl_exec($curl);
				curl_close($curl);
				$data = json_decode($response, true);
				$capture_id = null;
				foreach ($data['transaction_details'] ?? [] as $txn) {
					if (
						isset($txn['payer_info']['email_address']) &&
						$txn['payer_info']['email_address'] === $payer_email &&
						abs(strtotime($txn['transaction_info']['transaction_initiation_date']) - strtotime($last_payment_time)) < 3600
					) {
						$capture_id = $txn['transaction_info']['transaction_id'];
						break;
					}
				}
				
				if($capture_id == null){
					$this->session->setFlashData('error', trans("Transaction ID is not found, Please wait and then cancel for refund!"));
					return redirect()->to(admin_url().'listings/sales');
				}else{
					$this->session->setFlashData('errors_form', trans("Transaction ID is not found, Please wait and then cancel for refund!"));
					return redirect()->to(base_url('subscriptions'));
				}
				
				//Refund Using Capture ID
				$paidAmount = floatval($subscription['billing_info']['last_payment']['amount']['value']);
				$startDate = strtotime($subscription['billing_info']['last_payment']['time']);
				$endDate = !empty($subscription['billing_info']['next_billing_time']) ? strtotime($subscription['billing_info']['next_billing_time']) : strtotime($sale_detail->stripe_subscription_end_date) ;
				$now = time(); // current time or cancellation time

				// Clamp the time to not exceed billing cycle
				if ($now > $endDate) {
					$now = $endDate;
				}

				$totalDays = ($endDate - $startDate) / (60 * 60 * 24);
				$remainingDays = ($endDate - $now) / (60 * 60 * 24);

				// Protect against division by zero
				if ($totalDays <= 0) {
					$proratedRefund = 0;
				} else {
					$proratedRefund = round($paidAmount * ($remainingDays / $totalDays), 2);
				}	
				
				$curl = curl_init();			
				
				//To Cancel subs
				curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl')."billing/subscriptions/".$subscriptionId."/cancel");		
				curl_setopt($curl, CURLOPT_POST, true);			
				
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array(
					'Authorization: Bearer ' . $access_token,
					'Accept: application/json',
					'Content-Type: application/json'
				));
				$response = curl_exec($curl);
				$result = json_decode($response,true);
				
				if($sale_detail->stripe_subscription_amount_paid > 0){
					if ($capture_id && $amount > 0) {
						$curl = curl_init();
						curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl')."payments/captures/$capture_id/refund");
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($curl, CURLOPT_POST, true);
						curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
							'amount' => [
								'value' => $amount,
								'currency_code' => $currency
							]
						]));
						curl_setopt($curl, CURLOPT_HTTPHEADER, [
							'Authorization: Bearer ' . $access_token,
							'Content-Type: application/json',
						]);
						$refundResponse = curl_exec($curl);
						curl_close($curl);

						$refundResult = json_decode($refundResponse, true);
						print_r($refundResult); // log or save this
					} else {
						echo "Capture ID not found, refund not possible.";
					}		
				}
			//echo "<pre>";print_r($result);exit;
			$updateUser = [
							'stripe_subscription_customer_id' => NULL,
							'stripe_invoice_id'				  => NULL,
							'stripe_subscription_price_id'    => NULL,
							'stripe_subscription_id'          => NULL,
							'stripe_subscription_start_date'  => NULL,
							'stripe_subscription_end_date'    => NULL,
							'stripe_subscription_end_date'    => NULL,
							'stripe_subscription_status'      => NULL,
							'is_cancel'						  => 1,
							'plan_id'=>1
						  ];
			$updateUser['payment_type'] = "Paypal";
			$this->UsersModel = new UsersModel();							  
			//$user = $this->UsersModel->update_user_plan($this->session->get('vr_sess_user_id'),$updateUser);
			$this->db->table('sales')->where('stripe_subscription_id',$subscriptionId)->update(['is_cancel' => 1]);
			$s_detail = $this->db->table('sales')->where('stripe_subscription_id',$subscriptionId)->get()->getRow();
			$this->db->table('products')->where('id', $s_detail->product_id)->update(['is_cancel' => 1]);
			$emailModel = new EmailModel();	
			$data = array(	
				'subject' => "Confirmation: Your Subscription Cancellation",
				'to' => $user_detail->email,
				'to_name' => !empty($user_detail->fullname) ? $user_detail->fullname : 'User',
				'template_path' => "email/email_subs_cancellation"
			);
			//$emailModel->send_email($data);
			
			// Handle the cancellation success
			
			if($request_from == 'admin'){
				$this->session->setFlashData('success', trans("Subscription canceled successfully!"));
				return redirect()->to(admin_url().'listings/sales');
			}else{
				$this->session->setFlashData('success_form', trans("Subscription canceled successfully!"));
				return redirect()->to(base_url('subscriptions'));
			}
		}
	}

	public function update_card(){		
		/*
		$access_token = $this->get_paypal_access_token();
		$curl = curl_init();
		//To Cancel subs
		curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payment?customer_id=testphpdev6@gmail.com");		
		curl_setopt($curl, CURLOPT_POST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $access_token,
			'Accept: application/json',
			'Content-Type: application/json'
		));
		$response = curl_exec($curl);
		$result = json_decode($response,true);
		print_r($result);exit;
		*/
    	if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
        $this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$data['sale_detail'] = $this->UsersModel->get_sales_user_with_cus_id($this->session->get('vr_sess_user_id'));

		$subscriptions = $cards = $customer = array();
		// Retrieve all subscriptions of the customer
		if(!empty($data['sale_detail']) && $data['sale_detail'][0]->stripe_subscription_customer_id != ''){
			$customerId = $data['sale_detail'][0]->stripe_subscription_customer_id;

			$data['customerId'] = $customerId;

			Stripe\Stripe::setApiKey(env('stripe.secret'));

			// Retrieve all subscriptions of the customer
			$subscriptions = Subscription::all([
		    'customer' => $customerId,
			]);
			if(count($subscriptions) < 1){
				return redirect()->to(base_url('/'));
			}
			/*$customer = Customer::retrieve($customerId);
			$paymentMethods = PaymentMethod::all([
			    'customer' => $customerId,
			    'type' => 'card',
			]);
			$cards = $paymentMethods->data[0] ?? array();*/
			$customer = Customer::retrieve($customerId);
			$cards = \Stripe\Customer::allSources($customerId);			
			//echo "<pre>";print_r($cards);exit;
			$data['subscriptions'] = $subscriptions;
			$data['cards']         = $cards;
			$data['customer']         = $customer;
			
			$data['title'] = trans('Payment Methods');
	        return view('Providerauth/UpdateCard', $data);
		}else{
			$data['title'] = trans('Payment Methods');
	        return view('Providerauth/UpdateCard', $data);
		}
		
	}

	public function update_card_post(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$rules = [		
			'stripeToken' => [
                'label'  => trans('stripeToken'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required')
                ],
            ],/*
            'cc_type' => [
                'label'  => trans('Card Type'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required')
                ],
            ],
            'cc_number' => [
                'label'  => trans('Card Number'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required')
                ],
            ],
            'cc_exp_month' => [
                'label'  => trans('Expiry Month'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required')
                ],
            ],
            'cc_exp_year' => [
                'label'  => trans('Expiry Year'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required')
                ],
            ],
            'cc_name' => [
                'label'  => trans('Card Name'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required')
                ],
            ],
            'cc_cvc' => [
                'label'  => trans('CVC'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required')
                ],
            ],*/

        ];

        if ($this->validate($rules)) {	
        	$error_message = '';
	        try {
		        // Set your Stripe secret key
		        Stripe\Stripe::setApiKey(env('stripe.secret'));
				
		        // Get the Stripe customer ID
		        $customerId = $_POST['customerId'];
		        $token = $_POST['stripeToken'];
				
				$token_detail = \Stripe\Token::retrieve( $token );
				$card = '';
				$customer = \Stripe\Customer::allSources($customerId);
				$card_id = '';
				foreach ( $customer->data as $source ) {
					if ( $source->fingerprint == $token_detail->card->fingerprint ) {
						$card = $source;
						$card_id = $source->id;
					}
				}
				if(empty($card)){
					$attachsource = \Stripe\Customer::createSource($customerId,
					  [
						'source' => $token,
					  ]);
					$card_id = $attachsource->id;
				}

				/*
		        $customer = \Stripe\Customer::retrieve($customerId);
				
		        // Create a payment method using the customer's payment information
	            $paymentMethod = PaymentMethod::create([
	                'type' => 'card',
	                'card' => [
						"number" => ($this->request->getVar('cc_number')),
						"exp_month" => $this->request->getVar('cc_exp_month'),
						"exp_year" => $this->request->getVar('cc_exp_year'),
						"cvc" => ($this->request->getVar('cc_cvc'))
	                ],
	            ]);

	            // Attach the payment method to the customer
		        $paymentMethod->attach(['customer' => $customerId]);
				
	            $customer->invoice_settings->default_payment_method = $paymentMethod->id;
				$customer->save();
	           */
				$this->session->setFlashData('success_form', trans("Added Successfully!"));
				return redirect()->to(base_url('billing'));

		    } catch (\Stripe\Exception\ApiErrorException $e) {
		        $error_message = $e->getMessage();
		    }

		    if(!empty($error_message)){
				$this->session->setFlashData('errors_form', $error_message);
				return redirect()->to(base_url('billing'));
			}
		} else {
            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->to($this->agent->getReferrer())->withInput();
        }			
	}
	
    public function payment_history(){
    	// Set your Stripe secret key
		Stripe\Stripe::setApiKey(env('stripe.secret'));

		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));

		$payments = array();
		$paypal_payments = array();
		// Retrieve all payments of the customer
		/*if($data['user_detail']->payment_type == 'Stripe' && $data['user_detail']->stripe_subscription_customer_id != ''){
			$customerId = $data['user_detail']->stripe_subscription_customer_id;
			$payments = PaymentIntent::all([
		    'customer' => $customerId,
			]);
			$payments = $this->UsersModel->get_sales_user($this->session->get('vr_sess_user_id'));
		}else{
			$data['paypal_payments'] = $this->UsersModel->get_paypal_sales_user($this->session->get('vr_sess_user_id'));
		} */
		$data['paypal_payments'] = $this->UsersModel->get_paypal_sales_user($this->session->get('vr_sess_user_id'));
		$payments = $this->UsersModel->get_sales_user($this->session->get('vr_sess_user_id'));
		//echo '<pre>';print_r($payments);exit;
		$data['payments'] = $payments;
		$data['title'] = trans('Payment History');
		$data['meta_title'] = 'Payment History | Plane Broker';
        return $var = view('Providerauth/ProviderPayments', $data);
	}
	
    public function payment_history_billing(){
    	// Set your Stripe secret key
		Stripe\Stripe::setApiKey(env('stripe.secret'));

		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user(session()->get('vr_sess_user_id'));

		$payments = array();
		$paypal_payments = array();
		// Retrieve all payments of the customer
		/*if($data['user_detail']->payment_type == 'Stripe' && $data['user_detail']->stripe_subscription_customer_id != ''){
			$customerId = $data['user_detail']->stripe_subscription_customer_id;
			$payments = PaymentIntent::all([
		    'customer' => $customerId,
			]);
			$payments = $this->UsersModel->get_sales_user(session()->get('vr_sess_user_id'));
		}else{
			$data['paypal_payments'] = $this->UsersModel->get_paypal_sales_user(session()->get('vr_sess_user_id'));
		} */
		$data['paypal_payments'] = $this->UsersModel->get_paypal_sales_user(session()->get('vr_sess_user_id'));
		
		
		$pagination = $this->paginate($this->UsersModel->get_paginated_sales_user_count($this->session->get('vr_sess_user_id')));
		$payments = $this->UsersModel->get_paginated_sales_user(session()->get('vr_sess_user_id'),$pagination['per_page'], $pagination['offset']);
		//echo '<pre>';print_r($payments);exit;
		$data['payments'] = $payments;
        $data['paginations'] = $pagination['pagination'];
        $data['total_count'] = $pagination['total'];
		
		$data['title'] = trans('Payment History');
		$data['meta_title'] = 'Payment History | Plane Broker';
        return $var = view('Providerauth/ProviderBillingPayments', $data);
	}
    public function payment_history_admin(){
    	// Set your Stripe secret key
		Stripe\Stripe::setApiKey(env('stripe.secret'));

		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($_POST['user_id']);

		$payments = array();
		// Retrieve all payments of the customer
		if($data['user_detail']->stripe_subscription_customer_id != ''){
			$customerId = $data['user_detail']->stripe_subscription_customer_id;

			$payments = PaymentIntent::all([
		    'customer' => $customerId,
			]);

		}
		//echo '<pre>';print_r($payments->data);exit;
		$data['payments'] = $payments;
		$data['title'] = trans('Payment History');
        echo view('admin/users/payments', $data);
	}
	
	public function messages(){
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$data['title'] = trans('My Messages');

        $pagination = $this->paginate($this->UsersModel->get_paginated_provider_messages_count($this->session->get('vr_sess_user_id')));
        $data['provider_messages'] =   $this->UsersModel->get_paginated_provider_messages($pagination['per_page'], $pagination['offset'],$this->session->get('vr_sess_user_id'));

        $data['paginations'] = $pagination['pagination'];
		$data['meta_title'] = 'Messages | Plane Broker';
        $data['providers'] = $this->UsersModel->get_users();
		
        return view('Providerauth/ProviderMessages', $data);
	}
	
    public function paginate($total_rows)
    {
        $per_page = 5;
        $pager = service('pager');
        //initialize pagination
        $page = $this->request->getGet('page');
        $page = clean_number($page);


        $page = $page >= 1 ? $page : $pager->getCurrentPage('default');
        $offset      = ($pager->getCurrentPage('default') - 1) * $per_page;

        $data = array(
            'per_page' => $per_page,
            'offset' =>  $offset,
            'current_page' => $pager->getCurrentPage('default'),
            'total' => $total_rows
        );

        $data['pagination'] = $pager->makeLinks($page, $per_page, $data['total'], 'custom_pager');

        return $data;
    }
	public function save_report(){
		$this->UsersModel = new UsersModel();
		$this->UsersModel->save_report(array('user_id' => $_POST['user_id'], 'report_type' => $_POST['report_type']));
		echo 'success';
	}
	public function get_paypal_access_token(){
		$curl = curl_init();		
		//For subs detail
		curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl')."oauth2/token/");
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERPWD, env('paypal.client').":".env('paypal.secret'));
		curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'Content-Type: application/x-www-form-urlencoded'
		));
		$response = curl_exec($curl);
		$result = json_decode($response,true);
		return $result['access_token'];
	}
	public function paypal_success()
    {
		//print_r($_POST);
		$order_id = $_POST['response']['orderID'];
		$subs_id = $_POST['response']['subscriptionID'];
		
		$userModel = new UsersModel();	
		$data['sale_detail'] = $userModel->get_sales_by_id($this->request->getVar('sale_id'));	
		
		$access_token = $this->get_paypal_access_token();
		
		$curl = curl_init();		
		//For subs detail
		curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl')."billing/subscriptions/".$subs_id);
		curl_setopt($curl, CURLOPT_POST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $access_token,
			'Accept: application/json',
			'Content-Type: application/json'
		));
		$response = curl_exec($curl);
		$result = json_decode($response,true);
		//echo "<pre>";print_r($result);exit;
		$this->UsersModel = new UsersModel();
		if(!empty($result)){
			//Cancel Previously created subs
			$data['user_detail'] = $this->UsersModel->get_user($_POST['user_id']);
			if(!empty($data['sale_detail']) && $data['sale_detail']->plan_id >= 1 && !empty($data['sale_detail']->stripe_subscription_customer_id) && !empty($data['sale_detail']->stripe_subscription_id) && $data['sale_detail']->is_cancel == 0){
				if($data['sale_detail']->payment_type == 'Paypal'){
					$subscriptionId = $data['sale_detail']->stripe_subscription_id;
					$curl = curl_init();
					//To Cancel subs
					curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl')."billing/subscriptions/".$subscriptionId."/cancel");		
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curl, CURLOPT_HEADER, false);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_HTTPHEADER, array(
						'Authorization: Bearer ' . $access_token,
						'Accept: application/json',
						'Content-Type: application/json'
					));
					$response = curl_exec($curl);
					$resultss = json_decode($response,true);
				}else{
					// Set your Stripe secret key
					Stripe\Stripe::setApiKey(env('stripe.secret'));
					$customerId = $data['sale_detail']->stripe_subscription_customer_id;
					$subscriptionId = $data['sale_detail']->stripe_subscription_id;
					$subscription_cancel = Subscription::retrieve($subscriptionId,[]);
					$subscription_cancel->cancel();	
				}	
			}else{
				
			}			
			$usertrial = 0;
			$plan_amount = 0.00;
			$this->PlansModel = new PlansModel();
			$plan_detail = $this->PlansModel->get_plans_by_id($this->request->getVar('plan_id'));
			$paypalPriceId = '';				
			if($this->request->getVar('type') == 'trial'){
				$paypalPriceId = $plan_detail[0]->paypal_plan_id_with_trial;
			}else{
				$paypalPriceId = $plan_detail[0]->paypal_plan_id_without_trial;
			}
			if(!empty($_POST['type']) && $_POST['type'] == 'trial'){
				$insertTrial = [
					'user_id' => $_POST['user_id'],
					'plan_id' => $_POST['plan_id']
				];
				$usertrial = $this->UsersModel->insert_user_trial($insertTrial);
				$data_insert = [
					'user_id'               		=> $_POST['user_id'],
					'plan_id' 						=> $_POST['plan_id'],
					'transaction_id'        		=> '',
					'transaction_amount' 			=> 0.00,
					'transaction_status'    		=> 'Success',
					'transaction_initiation_date' 	=> date('Y-m-d h:i:s',strtotime($result['status_update_time'])),
					'payer_email'  					=> $result['subscriber']['email_address'],
					'payer_id'    					=> $result['subscriber']['payer_id'],
					'paypal_reference_id'			=> $result['id'],
					'subscription_id'				=> $result['id'],
					'trial_id' 						=> $usertrial,
				];
				$data_insert1 = [
					'user_id'                         => $_POST['user_id'],
					'trial_id' 						  => $usertrial,
					'plan_id'                         => $_POST['plan_id'],					
					'stripe_subscription_id'          => $result['id'],
					'stripe_subscription_customer_id' => $result['subscriber']['payer_id'],
					'stripe_subscription_price_id'    => $paypalPriceId,
					'stripe_subscription_amount_paid' => 0.00,
					'stripe_subscription_start_date'  => date('Y-m-d h:i:s',strtotime($result['status_update_time'])),
					'stripe_subscription_end_date'    => date('Y-m-d h:i:s',strtotime($result['billing_info']['next_billing_time'])),
					'stripe_invoice_id'               => $result['id'],
					'stripe_invoice_charge_id'        => $result['subscriber']['email_address'],
					'stripe_invoice_status'           => 'Success',
					'created_at'                      => date('Y-m-d h:i:s'),
					'category_id'                     => !empty($_POST['category']) ? $_POST['category'] : 0,
					'stripe_subscription_item_id'     => '',
					'stripe_subscription_status'      => strtolower($result['status']),
					'admin_plan_update'               => 0,
					'admin_plan_end_date'             => NULL,
					'is_cancel'						  => 0,
					'payment_type' => 'Paypal'
				];
			}else{
				$data_insert = [
					'user_id'               		=> $_POST['user_id'],
					'plan_id' 						=> $_POST['plan_id'],
					'transaction_id'        		=> '',
					'transaction_amount' 			=> $result['billing_info']['last_payment']['amount']['value'] ?? null,
					'transaction_status'    		=> $result['status'],
					'transaction_initiation_date' 	=> date('Y-m-d h:i:s',strtotime($result['status_update_time'])),
					'payer_email'  					=> $result['subscriber']['email_address'],
					'payer_id'    					=> $result['subscriber']['payer_id'],
					'paypal_reference_id'			=> $result['id'],
					'subscription_id'				=> $result['id'],
					'trial_id' 						=> $usertrial,
					'category_id'                   => !empty($_POST['category']) ? $_POST['category'] : 0
				];
				$data_insert1 = [
					'user_id'                         => $_POST['user_id'],
					'trial_id' 						  => $usertrial,
					'plan_id'                         => $_POST['plan_id'],					
					'stripe_subscription_id'          => $result['id'],
					'stripe_subscription_customer_id' => $result['subscriber']['payer_id'],
					'stripe_subscription_price_id'    => $paypalPriceId,
					'stripe_subscription_amount_paid' => $result['billing_info']['last_payment']['amount']['value'] ?? null,
					'stripe_subscription_start_date'  => date('Y-m-d h:i:s',strtotime($result['status_update_time'])),
					'stripe_subscription_end_date'    => date('Y-m-d h:i:s',strtotime($result['billing_info']['next_billing_time'])),
					'stripe_invoice_id'               => $result['id'],
					'stripe_invoice_charge_id'        => $result['subscriber']['email_address'],
					'stripe_invoice_status'           => 'Success',
					'created_at'                      => date('Y-m-d h:i:s'),
					'category_id'                     => !empty($_POST['category']) ? $_POST['category'] : 0,
					'stripe_subscription_item_id'     => '',
					'stripe_subscription_status'      => strtolower($result['status']),
					'admin_plan_update'               => 0,
					'admin_plan_end_date'             => NULL,
					'is_cancel'						  => 0,
					'payment_type' => 'Paypal'
				];
			}
			
				
				if(!empty($this->request->getVar('type')) && $this->request->getVar('type') == 'trial'){
					$data_insert['is_trial'] = 1;
				}else{
					$data_insert['is_trial'] = 0;
				}
			
			
			$updateUser = [
				'plan_id'                         => $_POST['plan_id'],
				'stripe_subscription_id'  		  => $result['id'],
				'stripe_subscription_customer_id' => $result['subscriber']['payer_id'],
				'stripe_subscription_price_id'	  => $paypalPriceId,
				'stripe_subscription_start_date'  => date('Y-m-d h:i:s',strtotime($result['status_update_time'])),
				'stripe_subscription_end_date'    => date('Y-m-d h:i:s',strtotime($result['billing_info']['next_billing_time'])),
				'stripe_subscription_status'      => strtolower($result['status']),
				'admin_plan_update'               => 0,
				'admin_plan_end_date'             => NULL,
				'is_cancel'						  => 0,
				'payment_type' 					  => 'Paypal'
			  ];
			if(!empty($_POST['type']) && $_POST['type'] == 'trial'){
				$updateUser['is_trial'] = 1;
			}else{
				$updateUser['is_trial'] = 0;
			}		
					
			
			if(!empty($data['sale_detail'])){
				$this->db->table('sales')->where('id', $data['sale_detail']->id)->update($data_insert1);
				$user1 = $data['sale_detail']->id;
			}else{
				$user1 = $this->UsersModel->insert_sales($data_insert1);
				//$user1 = $this->UsersModel->insert_paypal_sales($data_insert);
			}
						
			session()->set('selected_payment', 'paypal');
			session()->set('selected_sale_id', $user1);
			
			//$user = $this->UsersModel->update_user_plan($_POST['user_id'],$updateUser);
			if(!empty($_POST['type']) && $_POST['type'] == 'trial'){
				$data = array('type'=>'success', 'message' => trans("Your Free Trial plan has been selected, unlocking new features and benefits! payment will be deducted after 30 days."),'sale_id'=>$user1);
			}else{
				$data = array('type'=>'success', 'message' => trans("Your plan has been upgraded, unlocking new features and benefits!"),'sale_id'=>$user1);
			}
			
			$user_detail = $this->UsersModel->get_user($_POST['user_id']);
			$data["user_detail"] = $user_detail;
			if(!empty($user_detail->email)){
				$emailModel = new EmailModel();
				if(empty($data['user_detail']->stripe_subscription_id)){
					//$emailModel->send_email_activation_confirmed($data["user_detail"]->id);
				}
				$datae = array(	
					'subject' => "Payment Confirmation",
					'to' => $user_detail->email,
					'to_name'           => !empty($user_detail->fullname) ? $user_detail->fullname : 'User',
					'template_path' => "email/email_payment_confirmation",
					'token' => $user_detail->token	
				);
				$emailModel->send_email($datae);
				$data_admin = array(	
					'subject' => "New Subscription by Plane Broker",
					'from_email' => get_general_settings()->admin_email,
					'to' => get_general_settings()->mail_reply_to,
					'message_text'  => $user_detail->business_name.' - '.$user_detail->email. ' has been created new subscription(Paypal).',
					'template_path' => "email/admin/new_user"	
				);
				$emailModel->send_email($data_admin);	
				
			}
		}else{
			$data = array('type'=>'error', 'message' => trans("Details not found!"));
		}
		echo json_encode($data);
	}
	
	function stripe_set_default(){
		
		if(!empty($_POST['customer_id']) && !empty($_POST['source_id'])){
			// Set your Stripe secret key
			Stripe\Stripe::setApiKey(env('stripe.secret'));
			// Update the customer's default payment method
			$customer = \Stripe\Customer::retrieve($_POST['customer_id']);
			$customer->default_source = $_POST['source_id'];
			$customer->save();
			echo 'success';
		}else{
			echo 'failed';
		}
		
	}
	
	function stripe_delete_card(){
		
		if(!empty($_POST['customer_id']) && !empty($_POST['source_id'])){
			// Set your Stripe secret key
			Stripe\Stripe::setApiKey(env('stripe.secret'));
			// Update the customer's default payment method
			$customer = \Stripe\Customer::deleteSource($_POST['customer_id'],$_POST['source_id']);
			echo 'success';
		}else{
			echo 'failed';
		}
		
	}
	
	function stripe_add_card(){
		
		if(!empty($_POST['customer_id']) && !empty($_POST['source_id'])){
			// Set your Stripe secret key
			Stripe\Stripe::setApiKey(env('stripe.secret'));
			// Update the customer's default payment method
			$customer = \Stripe\Customer::createSource($_POST['customer_id'],$_POST['source_id']);
			echo 'success';
		}else{
			echo 'failed';
		}
		
	}
	
	function check_email_verified(){
		
		if(!empty($this->session->get('vr_sess_user_id'))){
			$this->UsersModel = new UsersModel();
			$user_detail = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
			if($user_detail->email_status == 1){
				session()->remove('vr_sess_email_status');
				session()->set('vr_sess_email_status',1);
				echo 'success';
			}else{
				echo 'failed';
			}			
		}else{
			echo 'failed';
		}		
	}
	
	function update_hiring_status(){
		if(!empty($this->session->get('vr_sess_user_id'))){
			$this->UsersModel = new UsersModel();
			$user_detail = $this->UsersModel->update_hiring_status($_POST['hiring_status'],$this->session->get('vr_sess_user_id'));
			echo 'success';			
		}else{
			echo 'failed';
		}
	}
}
