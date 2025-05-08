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
use Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Subscription;
use Stripe\Invoice;
use Stripe\Token;
use Stripe\PaymentIntent;

class ProviderDashboard extends ProviderauthController
{
	
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
		
		$data['view_count'] = $this->UsersModel->db->query('SELECT count(*) as view_count FROM `website_stats` where view_count = 1 AND user_id = '.$this->session->get('vr_sess_user_id').' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->view_count;
		$data['call_count'] = $this->UsersModel->db->query('SELECT count(*) as call_count FROM `website_stats` where call_count = 1 AND user_id = '.$this->session->get('vr_sess_user_id').' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->call_count;
		$data['form_count'] = $this->UsersModel->db->query('SELECT count(*) as form_count FROM `website_stats` where form_count = 1 AND user_id = '.$this->session->get('vr_sess_user_id').' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->form_count;
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
		$data['meta_title'] = 'Dashboard | Plane Broker';
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
		if($this->request->getVar('check') == '1'){
			$this->UsersModel = new UsersModel();
			$user_detail = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
			$photos = $this->UsersModel->get_user_photos($this->session->get('vr_sess_user_id'));
			$response = '1';
			if($user_detail->plan_id == 1 || $user_detail->plan_id == 2){
				if(count($photos) > 10){
					$response = '2';
				}
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
			if(!empty($this->session->get('vr_sess_user_id'))){
				$user = $this->UsersModel->update_user_profile_photo($this->request->getVar('image'),$this->session->get('vr_sess_user_id'));
			}
			echo '1';
		}else{
			$this->UsersModel = new UsersModel();
			$user = $this->UsersModel->insert_user_photos($this->request->getVar('image'),$this->session->get('vr_sess_user_id'),$this->request->getVar('image_tag'));
			if ($user) {
				$photos = $this->UsersModel->get_user_photos($this->session->get('vr_sess_user_id'));
				$html = '';
				if(!empty($photos)){
					$html .= '<input name="image_ids" class="form-control" type="hidden" value="'.$photos[0]['all_ids'].'" />';
					if(count($photos) > 1){
						$html .= '<p>('.trans('Drag and drop to organize your photos').')</p>';
					}
					$html .= '<ul class="row" id="imageListId">';
					$html .= $this->photo_arrange($photos);
					$html .= '</ul>';
				}
				echo $html;
			} else {
				echo '2';
			}
		}
	}
	public function photosedit_post(){
			$this->UsersModel = new UsersModel();
			$image = !empty($this->request->getVar('image')) ? $this->request->getVar('image') : '';
			$user = $this->UsersModel->update_user_photos($this->request->getVar('p_id'),$this->session->get('vr_sess_user_id'),$this->request->getVar('image_tag'),$image);
			if ($user) {
				$photos = $this->UsersModel->get_user_photos($this->session->get('vr_sess_user_id'));
				$html = '';
				if(!empty($photos)){
					$html .= '<input name="image_ids" class="form-control" type="hidden" value="'.$photos[0]['all_ids'].'" />';
					if(count($photos) > 1){
						$html .= '<p>('.trans('Drag and drop to organize your photos').')</p>';
					}
					$html .= '<ul class="row" id="imageListId">';
					$html .= $this->photo_arrange($photos);
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
			if ($user) {
				$photos = $this->UsersModel->get_user_photos($this->session->get('vr_sess_user_id'));
				$html = '';
				if(!empty($photos)){
					$html .= '<input name="image_ids" class="form-control" type="hidden" value="'.$photos[0]['all_ids'].'" />';
					if(count($photos) > 1){
						$html .= '<p>('.trans('Drag and drop to organize your photos').')</p>';
					}
					$html .= '<ul class="row" id="imageListId">';
					$html .= $this->photo_arrange($photos);
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
	public  function photo_arrange($photos){
		$html = '';
		foreach($photos as $r => $row){
			$html .= "<li class='col-6 col-md-3 listitemClass' id='imageNo".$row['id']."'><div class='pic'>";
			
			$html .="<img width='100%' height='150px' src='".base_url()."/uploads/userimages/".$this->session->get('vr_sess_user_id')."/".$row['file_name']."'></div><div class=' d-flex  justify-content-between bg-orange'><div class='trash' onclick='editphotos(".$row['id'].",this)' data-id='".$row['id']."' data-tags='".$row['image_tag']."' style='cursor:pointer'><i class='fa fa-pen'></i></div><div class='trash' onclick='deletephotos(".$row['id'].")' data-id='".$row['id']."' style='cursor:pointer'><i class='fa fa-trash-o'></i></div></div></li>";
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
			if($data['user_detail']->plan_id <= 1 && $data['user_detail']->id > 1){
				//$this->session->setFlashData('error_form1', "Please select your plan to proceed further!");
				return redirect()->to(base_url('/plan'));
			}else{	
				$this->CategoriesModel = new CategoriesModel();
				$data['categories'] = $this->CategoriesModel->get_categories();
				$data['title'] = trans('What do you want to sell?');
				$data['meta_title'] = 'Sell | Plane Broker';
				if(!empty($_GET) && !empty($_GET['type'])){
					$data['title'] = trans('Add New Listing');			
					$this->CategoriesSubModel = new CategoriesSubModel();
					$data['sub_categories'] = $this->CategoriesSubModel->get_categories_by_ids($_GET['type']);
					
					//get dynamic fields
					$this->FieldsModel = new FieldsModel();
					$data['dynamic_fields'] = $this->FieldsModel->get_fields();
					
					//delete old uploaded photos
					$this->UsersModel->delete_user_photos_id($this->session->get('vr_sess_user_id'));
					
					
					return view('Providerauth/ProductAdd', $data);			
				}else{
					return view('Providerauth/CategoryList', $data);			
				}
			}			
		}else{
			return redirect()->to(base_url('/'));
		}
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
			return redirect()->to(base_url('providerauth/account-settings'));
		} else {
			//error
			$this->session->setFlashData('errors_form', trans("There was a problem during update. Please try again!"));
			return redirect()->to($this->agent->getReferrer())->withInput();
		}
	}
	
	public function edit_password_post(){
		//echo "<pre>";print_r($this->request);exit;
		$userModel = new UsersModel();
		$user = $userModel->update_user_password($this->request->getVar('id'));
		if ($user) {
			$this->session->setFlashData('success_form', trans("Password Updated Successfully!"));
			return redirect()->to(base_url('providerauth/account-settings'));
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
		
		if($data['user_detail']->stripe_subscription_customer_id != '' && $data['user_detail']->payment_type == 'Stripe'){
			$customerId = $data['user_detail']->stripe_subscription_customer_id;
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
	
	public function checkout_post(){
		//print_r($_POST);exit;
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$this->PlansModel = new PlansModel();
		$data['plan_detail'] = $this->PlansModel->get_plans_by_id($this->request->getVar('plan_id'));
		//echo $this->request->getVar('type');exit;
		$rules = [		
			/*'stripeToken' => [
                'label'  => trans('stripeToken'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required')
                ],
            ],
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
            ], */

        ];
		$customerId = '';
        if (!empty($_POST['stripeToken']) || !empty($_POST['card_id'])) {
			$error_message = '';
			
			if($this->request->getVar('plan_id') == 2){
				$priceid = env('standard.price.id');//'price_1O4mGMAssRXDS6f05MxJ9Wgq';
			}else{
				$priceid = env('premium.price.id');//'price_1O4mIkAssRXDS6f0DlKFeEAk';
			}
			
		
			try {
				// Set your Stripe secret key
				Stripe\Stripe::setApiKey(env('stripe.secret'));
				if (!empty($_POST['stripeToken'])){
				$token = $_POST['stripeToken'];
				}	
				if($data['user_detail']->plan_id > 1 && !empty($data['user_detail']->stripe_subscription_customer_id) && !empty($data['user_detail']->stripe_subscription_id) && !empty($data['user_detail']->stripe_subscription_item_id)){			
					

					if($data['user_detail']->payment_type == 'Paypal'){
						$subscriptionId = $data['user_detail']->stripe_subscription_id;
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
						if (!empty($_POST['stripeToken'])){
							// Get the Stripe customer ID
							$customerId = $this->createStripeCustomer($token);	
						}
					}else{
						$customerId = $data['user_detail']->stripe_subscription_customer_id;
						$subscriptionId = $data['user_detail']->stripe_subscription_id;
						$subscription_cancel = Subscription::retrieve($subscriptionId,[]);
						$subscription_cancel->cancel();	
					}	
				}else{
					if (!empty($_POST['stripeToken'])){
						// Get the Stripe customer ID
						$customerId = $this->createStripeCustomer($token);	
					}					
				}
					//print_r($customerId);exit;
					/*
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

					// Update the customer's default payment method
					$customer = \Stripe\Customer::retrieve($customerId);
					$customer->invoice_settings->default_payment_method = $paymentMethod->id;
					$customer->save();
					*/	
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
/*
					if(!empty($this->request->getVar('paymentid'))){
						// Attach the payment method to the customer
						$pm = \Stripe\PaymentMethod::retrieve($this->request->getVar('paymentid'));
						$pm->attach(['customer' => $customerId]);

						// Update the customer's default payment method
						$customer = \Stripe\Customer::retrieve($customerId);
						$customer->invoice_settings->default_payment_method = $this->request->getVar('paymentid');
						$customer->save();
					}	*/				
					
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
					'user_id'                         => $this->session->get('vr_sess_user_id'),
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
				];

				$user1 = $this->UsersModel->insert_sales($data_insert);

				$updateUser = [
								'plan_id'                         => $this->request->getVar('plan_id'),
								'stripe_subscription_customer_id' => $stripe_subscription_customer_id,
								'stripe_invoice_id'               => $stripe_invoice_id,
								'stripe_subscription_price_id'    => $stripe_subscription_price_id,
								'stripe_subscription_id'          => $stripe_subscription_id,
								'stripe_subscription_item_id'     => $subscriptionItemId,
								'stripe_subscription_start_date'  => $stripe_subscription_start_date,
								'stripe_subscription_end_date'    => $stripe_subscription_end_date,
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
				$user = $this->UsersModel->update_user_plan($this->session->get('vr_sess_user_id'),$updateUser);
				if(!empty($this->request->getVar('type')) && $this->request->getVar('type') == 'trial'){
					$this->session->setFlashData('success_form', trans("Your Free Trial plan has been selected, unlocking new features and benefits! payment will be deducted after 30 days."));
				}else{
					$this->session->setFlashData('success_form', trans("Your plan has been upgraded, unlocking new features and benefits!"));
				}
				
				$user_detail = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
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
				//return redirect()->to(base_url('providerauth/billing'));
				return redirect()->to(base_url('providerauth/thankyou'));

			} catch (\Stripe\Exception\ApiErrorException $e) {
				$error_message = $e->getMessage();
			}
			

		    if(!empty($error_message)){
				$this->session->setFlashData('errors_form', $error_message);
				return redirect()->to(base_url('providerauth/checkout?plan_id='.$this->request->getVar('plan_id').'&type='.$this->request->getVar('type')));
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
		
		$data['payment_history']         = $this->payment_history();
		$data['payment_methods']         = $this->update_card();
		
		$data['title'] = trans('Billing');
		$data['meta_title'] = 'Billing | Plane Broker';
        return view('Providerauth/ProviderBilling', $data);
	}

	public function billing_cancel(){
		// Set your Stripe secret key
		$subscriptionId = $this->request->uri->getSegment(3);
		if(empty($subscriptionId)){
			 return redirect()->to(base_url('/'));
		}
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		
		if($data['user_detail']->payment_type == 'Stripe'){
			Stripe\Stripe::setApiKey(env('stripe.secret'));

			try {
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
								'is_cancel'						  => 1,
								'plan_id'=>1
							  ];
				$updateUser['payment_type'] = "Stripe";
				$this->UsersModel = new UsersModel();							  
				$user = $this->UsersModel->update_user_plan($this->session->get('vr_sess_user_id'),$updateUser);

				$emailModel = new EmailModel();	
				$data = array(	
					'subject' => "Confirmation: Your Subscription Cancellation",
					'to' => $data['user_detail']->email,
					'to_name' => !empty($data['user_detail']->fullname) ? $data['user_detail']->fullname : 'User',
					'template_path' => "email/email_subs_cancellation"
				);
				$emailModel->send_email($data);
				
				// Handle the cancellation success
				$this->session->setFlashData('success_form', trans("Subscription canceled successfully!"));
				return redirect()->to(base_url('providerauth/billing'));
			} catch (\Stripe\Exception\ApiErrorException $e) {
				// Handle the cancellation error
				$error_message = 'Failed to cancel the subscription: ' . $e->getMessage();
				$this->session->setFlashData('errors_form', $error_message);
				return redirect()->to(base_url('providerauth/billing'));
			}
		}else{
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
			$user = $this->UsersModel->update_user_plan($this->session->get('vr_sess_user_id'),$updateUser);

			$emailModel = new EmailModel();	
			$data = array(	
				'subject' => "Confirmation: Your Subscription Cancellation",
				'to' => $data['user_detail']->email,
				'to_name' => !empty($data['user_detail']->fullname) ? $data['user_detail']->fullname : 'User',
				'template_path' => "email/email_subs_cancellation"
			);
			$emailModel->send_email($data);
			
			// Handle the cancellation success
			$this->session->setFlashData('success_form', trans("Subscription canceled successfully!"));
			return redirect()->to(base_url('providerauth/billing'));
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

		$subscriptions = $cards = $customer = array();
		// Retrieve all subscriptions of the customer
		if($data['user_detail']->stripe_subscription_customer_id != ''){
			$customerId = $data['user_detail']->stripe_subscription_customer_id;

			$data['customerId'] = $customerId;

			if($data['user_detail']->payment_type=='Stripe'){
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
			}else{
				
			}
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
				return redirect()->to(base_url('providerauth/billing'));

		    } catch (\Stripe\Exception\ApiErrorException $e) {
		        $error_message = $e->getMessage();
		    }

		    if(!empty($error_message)){
				$this->session->setFlashData('errors_form', $error_message);
				return redirect()->to(base_url('providerauth/billing'));
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
			$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
			if($data['user_detail']->plan_id > 1 && !empty($data['user_detail']->stripe_subscription_customer_id) && !empty($data['user_detail']->stripe_subscription_id) && !empty($data['user_detail']->stripe_subscription_item_id)){
				if($data['user_detail']->payment_type == 'Paypal'){
					$subscriptionId = $data['user_detail']->stripe_subscription_id;
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
				}else{
					// Set your Stripe secret key
					Stripe\Stripe::setApiKey(env('stripe.secret'));
					$customerId = $data['user_detail']->stripe_subscription_customer_id;
					$subscriptionId = $data['user_detail']->stripe_subscription_id;
					$subscription_cancel = Subscription::retrieve($subscriptionId,[]);
					$subscription_cancel->cancel();	
				}	
			}else{
				
			}			
			
			if(!empty($_POST['type']) && $_POST['type'] == 'trial'){
				$insertTrial = [
					'user_id' => $this->session->get('vr_sess_user_id'),
					'plan_id' => $_POST['plan_id']
				];
				$usertrial = $this->UsersModel->insert_user_trial($insertTrial);
				$data_insert = [
					'user_id'               		=> $this->session->get('vr_sess_user_id'),
					'plan_id' 						=> $_POST['plan_id'],
					'transaction_id'        		=> '',
					'transaction_amount' 			=> 0.00,
					'transaction_status'    		=> 'Success',
					'transaction_initiation_date' 	=> date('Y-m-d h:i:s',strtotime($result['status_update_time'])),
					'payer_email'  					=> $result['subscriber']['email_address'],
					'payer_id'    					=> $result['subscriber']['payer_id'],
					'paypal_reference_id'			=> $result['id'],
					'subscription_id'				=> $result['id'],
				];
			}else{
				$data_insert = [
					'user_id'               		=> $this->session->get('vr_sess_user_id'),
					'plan_id' 						=> $_POST['plan_id'],
					'transaction_id'        		=> '',
					'transaction_amount' 			=> $result['shipping_amount']['value'],
					'transaction_status'    		=> $result['status'],
					'transaction_initiation_date' 	=> date('Y-m-d h:i:s',strtotime($result['status_update_time'])),
					'payer_email'  					=> $result['subscriber']['email_address'],
					'payer_id'    					=> $result['subscriber']['payer_id'],
					'paypal_reference_id'			=> $result['id'],
					'subscription_id'				=> $result['id'],
				];
			}
			$user1 = $this->UsersModel->insert_paypal_sales($data_insert);
			
			$paypalPriceId = '';
			if($_POST['plan_id'] == 2 && $_POST['type'] == 'trial'){
				$paypalPriceId = env('paypalPriceId2t');
			}else if($_POST['plan_id'] == 2 && $_POST['type'] != 'trial'){
				$paypalPriceId = env('paypalPriceId2');
			}else if($_POST['plan_id'] == 3 && $_POST['type'] == 'trial'){
				$paypalPriceId = env('paypalPriceId3t');
			}else if($_POST['plan_id'] == 3 && $_POST['type'] != 'trial'){
				$paypalPriceId = env('paypalPriceId3');
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
			$user = $this->UsersModel->update_user_plan($this->session->get('vr_sess_user_id'),$updateUser);
			if(!empty($_POST['type']) && $_POST['type'] == 'trial'){
				$data = array('type'=>'success', 'message' => trans("Your Free Trial plan has been selected, unlocking new features and benefits! payment will be deducted after 30 days."));
			}else{
				$data = array('type'=>'success', 'message' => trans("Your plan has been upgraded, unlocking new features and benefits!"));
			}
			
			$user_detail = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
			if(!empty($user_detail->email)){
				$emailModel = new EmailModel();
				if(empty($data['user_detail']->stripe_subscription_id)){
					$emailModel->send_email_activation_confirmed($data["user_detail"]->id);
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
