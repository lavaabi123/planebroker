<?php

namespace App\Controllers\Providerauth;

use App\Libraries\Recaptcha;
use App\Models\UsersModel;
use App\Models\CountriesModel;
use App\Models\Locations\CityModel;
use App\Models\CategoriesModel;
use App\Models\ClientTypesModel;
use App\Models\EmailModel;
use App\Models\CategoriesSkillsModel;

class ProviderRegister extends ProviderauthController
{
    public function index()
    {
		
        $this->is_registration_active();

        if ($this->session->get('vr_sess_logged_in') == TRUE) {
            return redirect()->to(base_url('/'));
        }
        $this->CategoriesModel = new CategoriesModel();
		$data['categories'] = $this->CategoriesModel->get_categories();		
        $this->CountriesModel = new CountriesModel();
		$data['countries'] = $this->CountriesModel->get_list();
		$data['offering'] = array();
        $this->ClientTypesModel = new ClientTypesModel();
		$data['client_types'] = $this->ClientTypesModel->get_client_types();
		$data['title'] = trans('register');
        $this->CategoriesSkillsModel = new CategoriesSkillsModel();
		$data['categories_skills'] = $this->CategoriesSkillsModel->get_categories_skills_by_category_id(1);
		
		$data['meta_title'] = !empty(get_seo('Register')) ? get_seo('Register')->meta_title : 'Register | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Register')) ? get_seo('Register')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Register')) ? get_seo('Register')->meta_keywords : '';
        return view('Providerauth/ProviderRegister', $data);
    }
	public function get_states(){
		$this->CountriesModel = new CountriesModel();
		$states = $this->CountriesModel->get_states_list($_POST['country_id']);
		$html = '';
		if(!empty($states)){
			foreach($states as $p => $state ){ 
				$html .= '<option value="'.$state->id.'">'.$state->name.'</option>';
			}		
		}
		echo $html;
	}

    /**
     * Register Post
     */
    public function provider_register_post()
    {

        $this->reset_flash_data();
        $userModel = new UsersModel();


        /*$rules = [
            'fullname' => [
                'label'  => trans('fullname'),
                'rules'  => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'username' => [
                'label'  => trans('username'),
                'rules'  => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],

            'email'    => [
                'label'  => trans('email'),
                'rules'  => 'required|max_length[200]|valid_email',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                ],
            ],
            'password' => [
                'label'  => trans('password'),
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                ],
            ],
            'confirm_password' => [
                'label'  => trans('password'),
                'rules'  => 'required|min_length[4]|matches[password]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'matches' => 'Password Not Match!',

                ],
            ],

        ];*/

			
        if (!empty($this->request->getVar('check_bot'))) {
            $email = $this->request->getVar('email');
            //is email unique
            if (!$userModel->is_unique_email($email)) {
                $this->session->setFlashData('form_data', $userModel->input_values());
                $this->session->setFlashData('errors_form', trans("message_email_unique_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }


            //register
            $user = $userModel->register();

            if ($user) {
				$login = $userModel->login();
                if (get_general_settings()->email_verification == 1) {
                    $this->session->setFlashData('success_form1', trans("msg_send_confirmation_email"));
                } else {
                    $this->session->setFlashData('success_form', trans("msg_register_success"));
                }
                if ($userModel->is_logged_in()) {
                    if($this->session->get('vr_sess_user_role') > 1){
                        return redirect()->to(base_url('plan'));
                    }/*else{
                        return redirect()->to(admin_url());
                    }*/
                }

                return redirect()->to($this->agent->getReferrer());
            } else {
                //error
                $this->session->setFlashData('errors_form', trans("message_register_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }
        } else {
            $this->session->setFlashData('errors_form', 'You are not a human!');
            return redirect()->to($this->agent->getReferrer())->withInput()->with('error', 'You are not a human!');
        }
    }
	
	
    public function product_add_post()
    {

        $this->reset_flash_data();
        $userModel = new UsersModel();
        if (!empty($this->request->getVar('check_bot'))) {      
			//add product
            $user = $userModel->add_product();

			//echo "<pre>";print_r($this->request);exit;      
            if ($user) {
                $this->session->setFlashData('success_form', trans("Product Added Successfully!"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                //error
                $this->session->setFlashData('errors_form', trans("Error while adding product."));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }
        } else {
            $this->session->setFlashData('errors_form', 'You are not a human!');
            return redirect()->to($this->agent->getReferrer())->withInput()->with('error', 'You are not a human!');
        }
    }
	public function check_email(){
		if(!empty($_POST['email'])){
			$userModel = new UsersModel();
			$user = $userModel->get_user_by_email($_POST['email']);
			if(!empty($user)){
				echo 'false';
			}else{
				echo 'true';
			}
		}else{
			echo 'false';
		}
		
	}
	
	public function get_location()
	{
		$this->cityModel = new CityModel();
		$from = '';
		if(!empty($this->request->getVar('from')) && $this->request->getVar('from') == 'home'){
			$from = $this->request->getVar('from');
		}
		$cities = $this->cityModel->get_cities($this->request->getVar('q'),$from);
		$return['locations'] = array();
		if(!empty($cities)){
			foreach($cities as $city){
				$return['locations'][] = array('id'=>$city->id,'location'=>$city->city.', '.$city->state_code.' '.$city->zipcode, 'zipcode'=>$city->zipcode,'homesearch'=>$city->city.'||'.$city->state_code.'||'.$city->lat.'||'.$city->long.'||'.$city->zipcode.'||'.$city->id,'locationhome'=>$city->city.', '.$city->state_code);
			}
		}
		echo json_encode($return);
	}
	
	public function plan()
    {   
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
            return redirect()->to(base_url('/'));
        }     
		$data['user_id'] = $this->session->get('vr_sess_user_id');
        $data['title'] = trans('Congratulations! Just one last step.');
		
		
		$data['user_plan_details'] = array();
		$data['standard_trial'] = array();
		$data['premium_trial'] = array();
		$this->UsersModel = new UsersModel();
		if ($this->session->get('vr_sess_logged_in') == TRUE) {
			$data['user_plan_details'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
			$data['standard_trial'] = $this->UsersModel->get_trial($this->session->get('vr_sess_user_id'),2);
			$data['premium_trial'] = $this->UsersModel->get_trial($this->session->get('vr_sess_user_id'),3);
		}
		
		
        return view('Providerauth/ProviderPlan', $data);
    }	
	
	public function select_plan()
    {  
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
			session()->set('selected_plan_id',$this->request->getVar('id'));
            return redirect()->to(base_url('/user-signup'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		if($data['user_detail']->plan_id == '1' && $this->request->getVar('id') == '1'){
			//$this->session->setFlashData('success_form', trans("You are Already in Free Plan!"));
			return redirect()->to(base_url('/providerauth/dashboard'));
		}else{
			//update plan id
			if($this->request->getVar('id') >= '2'){
				//$user = $this->UsersModel->update_user_plan($this->session->get('vr_sess_user_id'),$this->request->getVar('id'));
				//$this->session->setFlashData('success_form', trans("Your plan has been upgraded, unlocking new features and benefits!"));
				if(!empty($this->request->getVar('type'))){
					return redirect()->to(base_url('/providerauth/checkout?plan_id='.$this->request->getVar('id').'&type='.$this->request->getVar('type')));
				}else{
					return redirect()->to(base_url('/providerauth/checkout?plan_id='.$this->request->getVar('id')));
				}
				
			}else{
				return redirect()->to(base_url('/'));
			}
		}
    }
	
    public function recaptcha_verify_request()
    {
        if (!recaptcha_status()) {
            return true;
        }

        $recaptchaLib = new Recaptcha();

        $recaptcha = $this->request->getVar('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $recaptchaLib->verifyResponse($recaptcha);
            if (isset($response['success']) && $response['success'] === true) {
                return true;
            }
        }
        return false;
    }

    /**
     * Confirm Email
     */
    public function confirm_email()
    {
        $userModel = new UsersModel();
        $data['title'] = trans("confirm_your_email");

        $token = clean_str($this->request->getVar("token"));
        $data["user"] = $userModel->get_user_by_token($token);

        if (empty($data["user"])) {
            return redirect()->to(base_url());
        }

        if ($data["user"]->email_status == 1) {
            return redirect()->to(base_url());
        }

        if ($userModel->verify_email($data["user"])) {
			$emailModel = new EmailModel();
			//$emailModel->send_email_activation_confirmed($data["user"]->id);
            $data["success"] = trans("msg_confirmed");
			$user = $data["user"];
            //set user data
            $user_data = array(
                'vr_sess_user_id' => $user->id,
                'vr_sess_user_email' => $user->email,
                'vr_sess_user_role' => $user->role,
                'vr_sess_logged_in' => true,
                'vr_sess_user_ps' => md5($user->password),
                'vr_sess_email_status' => 1,
            );
            $this->session->set($user_data);
			
        } else {
            $data["error"] = trans("msg_error");
        }


        echo view('Providerauth/providerconfirm_email', $data);
    }

    //check if membership system active
    private function is_registration_active()
    {
        if (get_general_settings()->registration_system != 1) {
            return redirect()->to(lang_base_url());
        }
    }

    //reset flash data
    private function reset_flash_data()
    {
        $this->session->setFlashData('errors_form', "");
        $this->session->setFlashData('errors_form', "");
        $this->session->setFlashData('success_form', "");
    }
	public function set_location(){
		$this->session->set('user_latitude',$_POST['latitude']);
		$this->session->set('user_longitude',$_POST['longitude']);
		$zipcode = (!empty($_POST['latitude']) && !empty($_POST['longitude'])) ? $this->Get_Address_From_Google_Maps($_POST['latitude'], $_POST['longitude']) :'';
		$this->session->set('user_zipcode',$zipcode);
		$this->CityModel = new CityModel();
		if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){
		$featured = $this->CityModel->get_featured_home_ajax(15,$_POST['latitude'],$_POST['longitude']);
		//$featured = $this->CityModel->get_featured_home_ajax(15,'36.1716','-115.1391');
		}
		if(empty($featured)){
			$featured = $this->CityModel->get_featured_home(15);
		}
		$html = '';
		if(!empty($featured)){
		foreach($featured as $p => $provider ){ 
		$busin_name = !empty($provider['business_name']) ? $provider['clean_url'] : cleanURL($provider['permalink']) ;
			$html .= '<div class="item">
				<a href="'.base_url('/provider/'.$busin_name).'">
					<div class="provider-Details mb-4">
						<div class="providerImg mb-3">
							<img class="d-block w-100" alt="..." src="'.$provider['image'].'" >
						</div>
						<div class="pro-content">
							<h5 class="fw-medium title-xs">'.$provider['name'].'</h5>
							<h5 class="fw-medium text-primary title-xs">'.$provider['business_name'].'</h5>
							<p class="text-grey mb-3">'.$provider['city'].', '.$provider['state_code'].'</p>
							<h5 class="fw-medium title-xs">USD $7,299,000</h5>
						</div>
					</div>
				</a>
			</div>';
		}		
		}
		$html .= '';
		echo $html;
	}
	public function get_location_id(){
		if(!empty($_POST['zipcode'])){
			$this->CityModel = new CityModel();
			$location_id_arr = $this->CityModel->get_id_by_zipcode($_POST['zipcode']);
			if(!empty($location_id_arr[0]['id'])){
				echo $location_id_arr[0]['id'];
			}else{
				echo '42742';
			}			
		}else{
			echo '42742';
		}
	}
	
	function Get_Address_From_Google_Maps($lat, $lon) {

	$url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBVOEBebUkCDtSrIMdFekS9T9CcmRECNPo&latlng=$lat,$lon&sensor=false";

	// Make the HTTP request
	$data = @file_get_contents($url);
	// Parse the json response
	$jsondata = json_decode($data,true);
	// If the json data is invalid, return empty array
	if (!$this->check_status($jsondata))   return array();

	$address = $this->google_getPostalCode($jsondata);

	return $address;
	}

	/* 
	* Check if the json data from Google Geo is valid 
	*/

	function check_status($jsondata) {
		if ($jsondata["status"] == "OK") return true;
		return false;
	}

	/*
	* Given Google Geocode json, return the value in the specified element of the array
	*/

	function google_getPostalCode($jsondata) {
		return $this->Find_Long_Name_Given_Type("postal_code", $jsondata["results"][0]["address_components"]);
	}
	/*
	* Searching in Google Geo json, return the long name given the type. 
	* (If short_name is true, return short name)
	*/

	function Find_Long_Name_Given_Type($type, $array, $short_name = false) {
		foreach( $array as $value) {
			if (in_array($type, $value["types"])) {
				if ($short_name)    
					return $value["short_name"];
				return $value["long_name"];
			}
		}
	}
}
