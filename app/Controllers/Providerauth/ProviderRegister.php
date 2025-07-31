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
use App\Models\ProductModel;
use App\Models\SubscriptionModel;
use App\Models\PlansModel;

class ProviderRegister extends ProviderauthController
{
    public function __construct()
    {
        $this->subscriptionModel = new SubscriptionModel();
    }
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
						
						// Redirect to intended page after login
						$redirect = (session()->get('redirect_after_login')) ? session()->get('redirect_after_login') : '';
						if ($redirect) {
							session()->remove('redirect_after_login');
							return redirect()->to($redirect);
						} else {
							return redirect()->to(base_url('dashboard')); 
						}
                    
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
		if(!empty($this->request->getVar('listing_from')) && $this->request->getVar('listing_from')== 'admin'){
			
			//insert product
			$user = $userModel->add_product();
			if ($user) {
				if(!empty($this->request->getVar('product_id'))){
					$this->session->setFlashData('success', trans("Listing Updated Successfully!"));
				}else{
					$this->session->setFlashData('success', trans("Listing Added Successfully!"));	
				}
				return redirect()->to(admin_url().'listings');
			} else {
				//error
				$this->session->setFlashData('errors_form', trans("Error while adding listing."));
				return redirect()->to($this->agent->getReferrer())->withInput();
			}
		}else{
			if (!empty($this->request->getVar('check_bot'))) { 
			if($this->request->getVar('payment_type') == 'paypal'){
				$data['sale_detail'] = $userModel->get_paypal_sales_by_id($this->request->getVar('sale_id'));
			}else{
				$data['sale_detail'] = $userModel->get_sales_by_id($this->request->getVar('sale_id'));
			}
			
			$this->UsersModel = new UsersModel();
			$user_id = !empty($_POST['user_id']) ? $_POST['user_id'] : $this->session->get('vr_sess_user_id');
			$data['user_detail'] = $this->UsersModel->get_user($user_id);
			
			if(!empty($this->request->getVar('product_id')) || (!empty($data['sale_detail']) && empty($data['sale_detail']->product_id) && empty($data['is_cancel'])) || $data['user_detail']->user_level == 1){
				//add product
				$user = $userModel->add_product();
			}else{
				$this->session->setFlashData('errors_form', trans("Listing already added for this Subscription!"));
				return redirect()->to(base_url('my-listing'));
			}
					  
				if ($user) {
					if(!empty($this->request->getVar('product_id'))){
						$this->session->setFlashData('success_form', trans("Listing Updated Successfully!"));
					}else{
						$this->session->setFlashData('success_form', trans("Listing Added Successfully!"));
					}
					return redirect()->to(base_url('my-listing'));
				} else {
					//error
					$this->session->setFlashData('errors_form', trans("Error while adding listing."));
					return redirect()->to($this->agent->getReferrer())->withInput();
				}
			} else {
				$this->session->setFlashData('errors_form', 'You are not a human!');
				return redirect()->to($this->agent->getReferrer())->withInput()->with('error', 'You are not a human!');
			}
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
		$data['user_trial_detail'] = array();
		$this->UsersModel = new UsersModel();
		if ($this->session->get('vr_sess_logged_in') == TRUE) {
			$data['user_plan_details'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
			$data['user_trial_detail'] = $this->UsersModel->get_trials_by_user_id($this->session->get('vr_sess_user_id'));
		}
		
		$data['plans'] = $this->subscriptionModel->get_all_subscription();
		$data['sale_id'] = !empty($_GET['sale_id']) ? $_GET['sale_id'] : '' ;
		$data['plan_id'] = !empty($_GET['plan_id']) ? $_GET['plan_id'] : '' ;
		
		
				
		
        return view('Providerauth/ProviderPlan', $data);
    }	
	
	
	public function add_listing(){
		
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		$this->CategoriesModel = new CategoriesModel();
		$data['categories'] = $this->CategoriesModel->get_categories();
		$data['title'] = trans('What do you want to sell?');
		$data['meta_title'] = 'Sell | Plane Broker';
		
		return view('Providerauth/CategoryListALL', $data);	
		
	}
	
	public function select_plan()
    {  
		if ($this->session->get('vr_sess_logged_in') != TRUE) {
			// Save intended URL for redirect after login
			session()->set('redirect_after_login', str_replace('/index.php','',current_url() . '?' . $_SERVER['QUERY_STRING']));
			// Save plan ID if needed
			session()->set('selected_plan_id', $this->request->getVar('id'));

            return redirect()->to(base_url('/login'));
        }
		$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
		/*if($data['user_detail']->plan_id == '1' && $this->request->getVar('id') == '1'){
			//$this->session->setFlashData('success_form', trans("You are Already in Free Plan!"));
			return redirect()->to(base_url('/dashboard'));
		}else{
			//update plan id
			if($this->request->getVar('id') >= 1){
				//$user = $this->UsersModel->update_user_plan($this->session->get('vr_sess_user_id'),$this->request->getVar('id'));
				//$this->session->setFlashData('success_form', trans("Your plan has been upgraded, unlocking new features and benefits!"));
				if(!empty($this->request->getVar('type'))){
					return redirect()->to(base_url('/checkout?plan_id='.$this->request->getVar('id').'&type='.$this->request->getVar('type')));
				}else{
					return redirect()->to(base_url('/checkout?plan_id='.$this->request->getVar('id')));
				}
				
			}else{
				return redirect()->to(base_url('/'));
			}
		} */
		
		if($this->request->getVar('id') >= 1){
			$query = !empty($_GET['sale_id']) ? '&sale_id='.$_GET['sale_id'] : '' ;
			$query .= !empty($_GET['payment_type']) ? '&payment_type='.$_GET['payment_type'] : '' ;
					
			if(!empty($this->request->getVar('type'))){
				return redirect()->to(base_url('/checkout?plan_id='.$this->request->getVar('id').'&type='.$this->request->getVar('type').''.$query));
			}else{
				return redirect()->to(base_url('/checkout?plan_id='.$this->request->getVar('id').''.$query));
			}
			
		}else{
			return redirect()->to(base_url('/'));
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
		//$featured = $this->CityModel->get_featured_home_ajax(15,$_POST['latitude'],$_POST['longitude']);
		//$featured = $this->CityModel->get_featured_home_ajax(15,'36.1716','-115.1391');
		}
		if(empty($featured)){
			//$featured = $this->CityModel->get_featured_home(15);
		}
		
		$this->ProductModel = new ProductModel();
		$featured = $this->ProductModel->get_products($category_name='aircraft-for-sale',$where=' AND pl.is_featured_listing = 1','RAND() LIMIT 4');
		
		$html = '';
		if(!empty($featured)){
		foreach($featured as $p => $provider ){ 
		$busin_name = !empty($provider['business_name']) ? $provider['clean_url'] : cleanURL($provider['permalink']) ;
			$html .= '<div class="item">
				<a href="'.base_url('/listings/'.$provider['permalink'].'/'.$provider['id'].'/'.(!empty($provider['name'])?str_replace(' ','-',strtolower($provider['name'])):'')).'">
					<div class="provider-Details mb-4">
						<div class="providerImg mb-3">
							<img class="d-block w-100" alt="..." src="'.$provider['image'].'" >
						</div>
						<div class="pro-content">
							<h5 class="fw-medium title-xs">'.$provider['name'].'</h5>
							<h5 class="fw-medium text-primary title-xs">'.$provider['business_name'].'</h5>
							<p class="text-grey mb-3">'.$provider['address'].'</p>
							<h5 class="fw-medium title-xs">'.(($provider['price'] != NULL) ? 'USD $'.number_format($provider['price'], 2, '.', ',') : 'Call for Price').'</h5>
						</div>
					</div>
				</a>
			</div>';
			if($p > 2){
				break;
			}
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
