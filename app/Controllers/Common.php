<?php

namespace App\Controllers;

use App\Models\GeneralSettingModel;
use App\Models\Locations\CityModel;
use App\Models\Locations\CountyModel;
use App\Models\Locations\StateModel;
use App\Libraries\GoogleAnalytics;
use App\Models\UsersModel;
use App\Models\EmailTemplatesModel;
use App\Models\CategoriesModel;
use App\Models\EmailModel;
use App\Models\FieldsModel;
use App\Models\FieldGroupModel;
use App\Models\CategoriesSubModel;

class Common extends BaseController
{
    protected $stateModel;
    protected $countyModel;
    protected $cityModel;
    protected $userModel;
    protected $emailTemplatesModel;
    protected $fieldsModel;
    protected $FieldGroupModel;

    public function __construct()
    {
        $this->stateModel = new StateModel();
        $this->countyModel = new CountyModel();
        $this->cityModel = new CityModel();
        $this->GeneralSettingModel = new GeneralSettingModel();
        $this->analytics = new GoogleAnalytics();
        $this->userModel = new UsersModel();
        $this->emailTemplatesModel = new EmailTemplatesModel();
        $this->categoriesModel = new CategoriesModel();
        $this->fieldsModel = new FieldsModel();
        $this->FieldGroupModel = new FieldGroupModel();
		$this->categoriessubModel = new CategoriesSubModel();
    }

    public function run_internal_cron()
    {
        if (!$this->request->isAJAX()) {
            // ...
            exit();
        }

        //delete old sessions
        $db = db_connect();
        $db->query("DELETE FROM ci_sessions WHERE timestamp < DATE_SUB(NOW(), INTERVAL 3 DAY)");
        //add last update
        $this->GeneralSettingModel->builder()->where('id', 1)->update(['last_cron_update' => date('Y-m-d H:i:s')]);
    }

    public function switch_visual_mode()
    {

        $vr_dark_mode = 0;
        $dark_mode = $this->request->getVar('dark_mode');
        if ($dark_mode == 1) {
            $vr_dark_mode = 1;
        }

        set_cookie([
            'name' => '_vr_dark_mode',
            'value' =>  $vr_dark_mode,
            'expire' => time() + (86400 * 30),


        ]);

        return redirect()->to($this->agent->getReferrer())->withCookies();
        exit();
    }

    //get countries by continent
    public function get_countries_by_continent()
    {
        $key = $this->request->getVar('key');
        $countries = $this->countyModel->get_countries_by_continent($key);
        if (!empty($counties)) {
            foreach ($counties as $county) {
                echo "<option value='" . $county->id . "'>" . html_escape($county->name) . "</option>";
            }
        }
    }

    //get states by county
    /*public function get_states_by_county()
    {
        $county_id = $this->request->getVar('county_id');
        $states = $this->stateModel->get_states_by_county($county_id);
        $status = 0;
        $content = '';
        if (!empty($states)) {
            $status = 1;
            $content = '<option value="">' . trans("state") . '</option>';
            foreach ($states as $state) {
                $content .= "<option value='" . $state->id . "'>" . html_escape($state->name) . "</option>";
            }
        }

        $data = array(
            'result' => $status,
            'content' => $content
        );
        echo json_encode($data);
    }*/



    //get states
    public function get_states()
    {
        $county_id = $this->request->getVar('county_id');
        $states = $this->stateModel->get_states_by_county($county_id);
        $status = 0;
        $content = '';
        if (!empty($states)) {
            $status = 1;
            $content = '<option value="">' . trans("state") . '</option>';
            foreach ($states as $item) {
                $content .= '<option value="' . $item->id . '">' . html_escape($item->name) . '</option>';
            }
        }
        $data = array(
            'result' => $status,
            'content' => $content
        );
        echo json_encode($data);
    }

    //get cities
    public function get_cities()
    {
        $state_id = $this->request->getVar('state_id');
        $cities = $this->cityModel->get_cities_by_state($state_id);
        $status = 0;
        $content = '';
        if (!empty($cities)) {
            $status = 1;
            $content = '<option value="">' . trans("city") . '</option>';
            foreach ($cities as $item) {
                $content .= '<option value="' . $item->id . '">' . html_escape($item->name) . '</option>';
            }
        }
        $data = array(
            'result' => $status,
            'content' => $content
        );
        echo json_encode($data);
    }

    //show address on map
    public function show_address_on_map()
    {
        $county_text = $this->request->getVar('county_text');
        $county_val = $this->request->getVar('county_val');
        $state_text = $this->request->getVar('state_text');
        $state_val = $this->request->getVar('state_val');
        $city_text = $this->request->getVar('city_text');
        $city_val = $this->request->getVar('city_val');
        $address = $this->request->getVar('address');
        $zip_code = $this->request->getVar('zip_code');




        $data["map_address"] = "";

        if (!empty($county_val)) {
            $data["map_address"] = $data["map_address"] . $county_text;
        }

        if (!empty($state_val)) {
            $data["map_address"] = $data["map_address"] . ' ' . $state_text . " ";
        }

        if (!empty($city_val)) {
            $data["map_address"] = $data["map_address"] . $city_text . " ";
        }


        if (!empty($address)) {
            $data["map_address"] =  $address . " " . $zip_code;

            if (!empty($zip_code)) {
                $data["map_address"] =  $address . " " . $zip_code;
            }
        }


        return view('admin/includes/_load_map', $data);
    }

    public function getAnalyticsReport()
    {
        $endDate = date('Y-m-d', strtotime("today"));
        $startDate = date('Y-m-d', strtotime("first day of this month"));

        if (!empty($this->request->getVar('startDate'))) {
            $startDate = date('Y-m-d', strtotime($this->request->getVar('startDate')));
        }

        if (!empty($this->request->getVar('endDate'))) {
            $endDate = date('Y-m-d', strtotime($this->request->getVar('endDate')));
        }


        echo json_encode($this->analytics->getReportViews($startDate, $endDate));
    }

    public function getUsersRegister()
    {
        $endDate = date('Y-m-d', strtotime("today"));
        $startDate = date('Y-m-d', strtotime("-1 year"));

        $formatted_endDate = date('m/d/Y', strtotime("today"));
        $formatted_startDate = date('m/d/Y', strtotime("-1 year"));

        if (!empty($this->request->getVar('startDate'))) {
            $startDate = date('Y-m-d', strtotime($this->request->getVar('startDate')));
            $formatted_startDate = date('m/d/Y', strtotime($this->request->getVar('startDate')));
        }

        if (!empty($this->request->getVar('endDate'))) {
            $endDate = date('Y-m-d', strtotime($this->request->getVar('endDate')));
            $formatted_endDate = date('m/d/Y', strtotime($this->request->getVar('endDate')));
        }

        $data['latest'] = $this->getUsers($startDate, $endDate);
        $data['user_type'] = $this->getUsersAuth($startDate, $endDate);
        $data['totalAmountPaid'] = $this->getAmountPaidSum($startDate, $endDate);
        $data['totalStandard'] = $this->getStandard($startDate, $endDate);
        $data['totalPremium'] = $this->getPremium($startDate, $endDate);

        $data['dataforperiod'] = $formatted_startDate .' - '.$formatted_endDate;

        echo json_encode($data);
    }

    private function getUsers($startDate, $endDate)
    {
        $this->userModel->builder('users')
            ->select('count(id) as users, DATE(created_at) as date')
            ->where('DATE(created_at) <=', $endDate)
            ->where('DATE(created_at) >=', $startDate)
            ->groupBy('date');


        $query =  $this->userModel->builder('users')->get();

        if (!empty($query->getResult())) {
            $data = array();
            foreach ($query->getResult() as $row) {

                $data['day'][] = date("M-d", strtotime($row->date));
                $data['user'][] = (int) $row->users;
            }
        } else {
            $data['day'][] =  0;
            $data['user'][] = 0;
        }


        return $data;
    }

    private function getStandard($startDate, $endDate)
    {        
		
		$query2 =  $this->userModel->builder('users')->select('count(id) as users, plan_id,is_trial,is_cancel')
            ->where('DATE(created_at) <=', $endDate)->where('DATE(created_at) >=', $startDate)
			->where('plan_id',2)->where('is_trial', 0)->where('is_cancel', 0)
            ->groupBy('plan_id')->get()->getRow();
		return !empty($query2) ? (int) $query2->users : 0;

    }
    private function getPremium($startDate, $endDate)
    {        
		
		$query2 =  $this->userModel->builder('users')->select('count(id) as users, plan_id,is_trial,is_cancel')
            ->where('DATE(created_at) <=', $endDate)->where('DATE(created_at) >=', $startDate)
			->where('plan_id',3)->where('is_trial', 0)->where('is_cancel', 0)
            ->groupBy('plan_id')->get()->getRow();
		return !empty($query2) ? (int) $query2->users : 0;

    }
    private function getUsersAuth($startDate, $endDate)
    {
        /*$this->userModel->builder('users')
            ->select('count(id) as users, user_type')
            ->groupBy('user_type');


        $query =  $this->userModel->builder('users')->get();

        if (!empty($query->getResult())) {
            $data = array();
            foreach ($query->getResult() as $row) {

                $data['type'][] = ucfirst($row->user_type);
                $data['user'][] = (int) $row->users;
            }
        } else {
            $data['type'][] =  0;
            $data['user'][] = 0;
        }*/
		$data['type'] = array('Free Trial','Standard','Premium','Cancelled','No Plan');
        $query1 =  $this->userModel->builder('users')->select('count(id) as users, plan_id,is_trial,is_cancel')
            ->where('DATE(created_at) <=', $endDate)->where('DATE(created_at) >=', $startDate)
			->where('plan_id >',1)->where('is_trial', 1)->where('is_cancel', 0)
            ->get()->getRow();
		$data['user'][0] = !empty($query1) ? (int) $query1->users : 0;
		$query2 =  $this->userModel->builder('users')->select('count(id) as users, plan_id,is_trial,is_cancel')
            ->where('DATE(created_at) <=', $endDate)->where('DATE(created_at) >=', $startDate)
			->where('plan_id',2)->where('is_trial', 0)->where('is_cancel', 0)
            ->groupBy('plan_id')->get()->getRow();
		$data['user'][1] = !empty($query2) ? (int) $query2->users : 0;
		
		$query3 =  $this->userModel->builder('users')->select('count(id) as users, plan_id,is_trial,is_cancel')
            ->where('DATE(created_at) <=', $endDate)->where('DATE(created_at) >=', $startDate)
			->where('plan_id',3)->where('is_trial', 0)->where('is_cancel', 0)
            ->groupBy('plan_id')->get()->getRow();
		$data['user'][2] = !empty($query3) ? (int) $query3->users : 0;
		
		$query4 =  $this->userModel->builder('users')->select('count(id) as users, plan_id,is_trial,is_cancel')
            ->where('DATE(created_at) <=', $endDate)->where('DATE(created_at) >=', $startDate)
			->where('is_cancel', 1)
            ->groupBy('plan_id')->get()->getRow();
		$data['user'][3] = !empty($query4) ? (int) $query4->users : 0;
		
		$query5 =  $this->userModel->builder('users')->select('count(id) as users, plan_id,is_trial,is_cancel')
            ->where('DATE(created_at) <=', $endDate)->where('DATE(created_at) >=', $startDate)
			->where('plan_id', 1)
            ->groupBy('plan_id')->get()->getRow();
		$data['user'][4] = !empty($query5) ? (int) $query5->users : 0;


        return $data;
    }

    public function get_emailtemplate()
    {
        $emailtemplate_id = $this->request->getVar('emailtemplate_id');
        $emailTemplates = $this->emailTemplatesModel->get_emailtemplate($emailtemplate_id);
        $status = 0;
        $data = array();
        if (!empty($emailTemplates)) {
            $data = array(
                'subject' => $emailTemplates->name,
                'content' => $emailTemplates->content
            );
        }
        echo json_encode($data);
    }

    public function get_category()
    {
        $categoryId = $this->request->getVar('categoryId');
        $category = $this->categoriesModel->get_categories_by_id($categoryId);
        $status = 0;
        $data = array();
        if (!empty($category)) {
            $data = array(
                'name' => $category->name,
                'category_icon' => $category->category_icon,
                'seo_title' => $category->seo_title, 
                'seo_keywords' => $category->seo_keywords, 
                'seo_description' => $category->seo_description,            
            );
        }
        echo json_encode($data);
    }
	
    public function get_sub_category()
    {
        $categoryId = $this->request->getVar('categoryId');
        $category = $this->categoriessubModel->get_categories_by_id($categoryId);
        $status = 0;
        $data = array();
        if (!empty($category)) {
            $data = array(
                'name' => $category->name,
                'category_id' => $category->category_id,
                'status' => $category->status,
                'seo_title' => $category->seo_title, 
                'seo_keywords' => $category->seo_keywords, 
                'seo_description' => $category->seo_description,            
            );
        }
        echo json_encode($data);
    }
	
	
    public function get_sub_category_by_ids()
    {
        $category_ids = $this->request->getVar('category_ids');
        $category = $this->categoriessubModel->get_categories_by_ids($category_ids);
		$selectedSubCategories_ids = array();
		if(!empty($this->request->getVar('field_id'))){
			$db = \Config\Database::connect();
			$selectedSubcategories = $db->table('field_sub_categories')->select('sub_category_id')->where('field_id', $this->request->getVar('field_id'))->get()->getResultArray();
			$selectedSubCategories_ids = array_column($selectedSubcategories, 'sub_category_id');
		}
        $status = 0;
		$html = '';
        $data = array();
        if (!empty($category)) {
			foreach($category as $row){
				$sel = '';
				if(in_array($row->id,$selectedSubCategories_ids)){
					$sel = 'selected';
				}
				$html .= '<option value="' . $row->id . '" '.$sel.'>' . htmlspecialchars($row->name) . ' ('.htmlspecialchars($row->category_name).')</option>';
			}
        }else{
			$html .= '<option value="">No Results Found</option>';
		}
        echo json_encode(array('text'=>$html));
    }
	
    public function get_field_group_by_ids()
    {
        $category_ids = $this->request->getVar('category_ids');
        $category = $this->FieldGroupModel->get_fields_group_by_ids($category_ids);
		$selectedSubCategories_ids = array();
		if(!empty($this->request->getVar('field_id'))){
			$db = \Config\Database::connect();
			$selectedSubcategories = $db->table('field_groups')->select('fields_group_id')->where('field_id', $this->request->getVar('field_id'))->get()->getResultArray();
			$selectedSubCategories_ids = array_column($selectedSubcategories, 'fields_group_id');
		}
        $status = 0;
		$html = '';
        $data = array();
        if (!empty($category)) {
			foreach($category as $row){
				$sel = '';
				if(in_array($row->id,$selectedSubCategories_ids)){
					$sel = 'selected';
				}
				$html .= '<option value="' . $row->id . '" '.$sel.'>' . htmlspecialchars($row->name) . ' ('.htmlspecialchars($row->category_name).')</option>';
			}
        }else{
			$html .= '<option value="">No Results Found</option>';
		}
        echo json_encode(array('text'=>$html));
    }

    public function get_field()
    {
        $fieldId = $this->request->getVar('fieldId');
        $field = $this->fieldsModel->get_fields_by_id($fieldId);
        $status = 0;
        $data = array();
        if (!empty($field)) {
			$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
			$option_html = '';
			if (!empty($decoded_option) && count($decoded_option) > 0) {
				foreach($decoded_option as $option){
					$option_html .= '<div class="d-flex fieldoption gap-2 gap-sm-4"><div class="col"><input type="text" class="form-control" placerholder="Option Name" value="'.$option.'" name="field_options[]"></div><a href="javascript:void(0)" class="button tiny alert removeOption p-2"><i class="fas fa-trash"></i></a></div>';
				}
			}

			$db = \Config\Database::connect();
			$allCategories = $this->categoriesModel->findAll();
			$selectedCategories = $db->table('field_categories')->select('category_id')->where('field_id', $fieldId)->get()->getResultArray();
			$selectedCategories_ids = array_column($selectedCategories, 'category_id');
			if(!empty($selectedCategories_ids)){
			$allSubcategories = $this->categoriessubModel
				->select('categories_sub.*, categories.name as category_name')
				->join('categories', 'categories.id = categories_sub.category_id')
				->whereIn('categories_sub.category_id', $selectedCategories_ids)
				->findAll();
			}else{
				$allSubcategories = array();
			}
			$selectedSubcategories = $db->table('field_sub_categories')->select('sub_category_id')->where('field_id', $fieldId)->get()->getResultArray();
			
			if(!empty($selectedCategories_ids)){
			$allGroups = $this->FieldGroupModel
				->select('fields_group.*, categories.name as category_name')
				->join('categories', 'categories.id = fields_group.category_id')
				->whereIn('fields_group.category_id', $selectedCategories_ids)
				->findAll();
			}else{
				$allGroups = array();
			}
			$selectedGroups = $db->table('field_groups')->select('fields_group_id')->where('field_id', $fieldId)->get()->getResultArray();

	
            $data = array(
				'id' => $fieldId,
                'name' => $field->name,
                'field_type' => $field->field_type, 
                'field_position' => $field->field_position, 
                'field_order' => $field->field_order,
                'field_options' => $field->field_options,
				'option_html' => $option_html,
				'allCategories' => $allCategories,
				'allSubcategories' => $allSubcategories,
				'allGroups' => $allGroups,
				'selectedCategories' => array_column($selectedCategories, 'category_id'),
				'selectedSubcategories' => array_column($selectedSubcategories, 'sub_category_id'),	
				'selectedGroups' => array_column($selectedGroups, 'fields_group_id'),				
            );
        }
        echo json_encode($data);
    }
	
    public function send_message_to_provider()
    {
		if(!empty($this->request->getVar('check_bot'))){
        $userId         = $this->request->getVar('userId');        
        $email          = $this->request->getVar('email');
        $phone          = $this->request->getVar('phone');
        $name           = $this->request->getVar('name');
        $best_way       = $this->request->getVar('best_way');
        $siteName       = get_general_settings()->application_name;
        $subject        = $siteName.' Customer Submission';
        $userMessage    = $this->request->getVar('message');
        $message        = "<b>You received this message from a customer who visited your ".$siteName." profile.</b><br><br>Name: ".$name."<br>Email: ".$email."<br>Phone: ".$phone."<br>Best way to reach you?:".$best_way."<br>Message:<br>".$userMessage;
		//$message        = "You have received a message from a customer.";
        $user_detail    = $this->userModel->get_user($userId);
        
        $data = array(
            'subject'           => "You Have A Message",//$subject,
            'message_text'      => $message,
            'to'                => $user_detail->email,
            'template_path'     => "email/email_to_provider",
        );
		$message_admin        = "<b>Broker(".$user_detail->business_name." - ".$user_detail->email.") received this message from a customer who visited their profile.</b><br><br>Name: ".$name."<br>Email: ".$email."<br>Phone: ".$phone."<br>Best way to reach you?:".$best_way."<br>Message:<br>".$userMessage;
		$data_admin = array(
            'subject'           => "Customer Contacted Broker",//$subject,
            'message_text'      => $message_admin,
			'from_email' => get_general_settings()->admin_email,
			'to' => get_general_settings()->mail_reply_to,
            'template_path'     => "email/admin/new_user",
        );
		$message_cus        = "<p>Dear ".$name.",</p><p>Thank you for choosing <a href='".base_url()."'>planebroker.com!</a> Your message has been received, and we are pleased to confirm that your designated groomer, ".$user_detail->business_name.", will be in touch with you shortly. They will address any questions you may have, discuss your grooming needs, and finalize the details to ensure a seamless grooming experience for your furry friend.</p><p>Thank you!</p>";
		$data_customer = array(
            'subject'           => "Message Received - planebroker.com",//$subject,
            'message_text'      => $message_cus,
			'from_email' => get_general_settings()->mail_reply_to,
			'to' => $email,
            'template_path'     => "email/admin/new_user",
        );
        $emailModel = new EmailModel();
        $emailModel->send_email($data_customer);
        $emailModel->send_email($data); 
        $emailModel->send_email($data_admin);  

        $insertData     = array();
        $logged_user_id = 0;

        if (auth_check()) {
            $logged_user_id = $this->session->get('vr_sess_user_id');
        }

        $insertData['from_name']         = $name;
        $insertData['from_email']        = $email;
        $insertData['from_phone']        = $phone;
        $insertData['best_way']        	 = $best_way;		
        $insertData['from_message']      = $userMessage;
        $insertData['logged_user_id']    = $logged_user_id;
        $insertData['to_user_id']        = $userId;
        $insertData['created_at']        = date('Y-m-d H:i:s');

        $id = $this->db->table('provider_messages')->insert($insertData);
		
		$query2 =  $this->userModel->db->query("UPDATE users SET form_count = form_count + 1 WHERE id = ".$userId);
		$user_latitude = !empty($this->session->get('user_latitude')) ? $this->session->get('user_latitude') : '';
		$user_longitude = !empty($this->session->get('user_longitude')) ? $this->session->get('user_longitude') : '';
		$user_zipcode = !empty($this->session->get('user_zipcode')) ? $this->session->get('user_zipcode') : '';
		$query2 =  $this->userModel->db->query("INSERT INTO website_stats (user_id,form_count,customer_lat,customer_long,customer_zipcode) VALUES (".$userId.",1,'".$user_latitude."','".$user_longitude."','".$user_zipcode."')");
		
        if ($id) {
            return $this->response->setJSON([
                'success' => true,
                'message' => trans("msg_email_sent")
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'error' => true,
                'message' => trans("Something went wrong!. Please try again")
            ]);
        } 
		}else {
            return $this->response->setJSON([
                'success' => false,
                'error' => true,
                'message' => trans("You are not a human!")
            ]);
        }        
        exit;
    }

    public function get_provider_messages()
    {
        $message_id = $this->request->getVar('message_id');
        $message = $this->userModel->getProviderMessages($message_id);
        $status = 0;
        $data = array();
        echo "<table class='table table-striped'>";
        if (!empty($message)) {            
            //echo "<tr><td>Provider:</td><td>".$message->to_provider."</td></tr>";
            //echo "<tr><td>Logged User:</td><td>".$message->logged_user."</td></tr>";
            echo "<tr><td>Name:</td><td>".$message->from_name."</td></tr>";
            echo "<tr><td>Email:</td><td>".$message->from_email."</td></tr>";
            echo "<tr><td>Phone:</td><td>".$message->from_phone."</td></tr>";
            echo "<tr><td>Date / Time:</td><td>".formatted_date($message->created_at,'m/d/Y h:i a')."</td></tr>";         
            echo "<tr><td>Message:</td><td>".$message->from_message."</td></tr>";        
        }else{
             echo "<tr><td colspan='2'>No data</td></tr>";
        }
        echo "</table>";
        exit();
    }
	
    public function delete_provider_messages()
    {
        $message_id = $this->request->getVar('message_id');
        $message = $this->userModel->deleteProviderMessages($message_id);
		echo 'success';exit();
    }
    public function get_contact_messages()
    {
        $message_id = $this->request->getVar('message_id');
        $message = $this->userModel->getContactMessages($message_id);
        $status = 0;
        $data = array();
        echo "<table class='table table-striped'>";
        if (!empty($message)) {            
            echo "<tr><td>Subject:</td><td>".$message->subject."</td></tr>";
            echo "<tr><td>Name:</td><td>".$message->from_name."</td></tr>";
            echo "<tr><td>Email:</td><td>".$message->from_email."</td></tr>";
            echo "<tr><td>phone:</td><td>".$message->from_phone."</td></tr>";
            echo "<tr><td>Date:</td><td>".formatted_date($message->created_at)."</td></tr>";         
            echo "<tr><td>Message:</td><td>".$message->from_message."</td></tr>";        
        }else{
             echo "<tr><td colspan='2'>No data</td></tr>";
        }
        echo "</table>";
        exit();
    }


    public function getAmountPaidSum($startDate, $endDate)
    {
        $query = $this->db->table('sales')
            ->selectSum('stripe_subscription_amount_paid', 'totalAmountPaid')
            ->where('DATE(created_at) >=', $startDate)
            ->where('DATE(created_at) <=', $endDate)
            ->get();
        
        $row = $query->getRow();
		
		$query1 = $this->db->table('paypal_sales')
            ->selectSum('transaction_amount', 'totalAmountPaid')
            ->where('DATE(created_at) >=', $startDate)
            ->where('DATE(created_at) <=', $endDate)
            ->get();
        
        $row1 = $query1->getRow();
		
		$sum_amount = 0;
		if ($row1) {
            $sum_amount = ($sum_amount + $row1->totalAmountPaid);
        }
        
        if ($row) {
            return  ($sum_amount + $row->totalAmountPaid);
        } else {
            return $sum_amount;
        }
    }
    public function getProfileViews()
    {
        $endDate = date('Y-m-d', strtotime("+1 day"));
        $startDate = date('Y-m-d', strtotime("-1 month"));

        $formatted_endDate = date('m/d/Y', strtotime("today"));
        $formatted_startDate = date('m/d/Y', strtotime("-1 month"));
		
        if (!empty($_GET['start'])) {
            $startDate = date('Y-m-d', strtotime($_GET['start']));
            $formatted_startDate = date('m/d/Y', strtotime($_GET['start']));
        }

        if (!empty($_GET['end'])) {
            $endDate = date('Y-m-d', strtotime($_GET['end']));
            $formatted_endDate = date('m/d/Y', strtotime($_GET['end']));
        }
		$id = !empty($_GET['id']) ? $_GET['id'] : $this->session->get('vr_sess_user_id');
        $data['latest'] = $this->getViews($startDate, $endDate,$id);
        $data['impression'] = $this->getImpression($startDate, $endDate, $id);
        $data['user_type'] = $this->getTopZip($startDate, $endDate);
        $data['totalAmountPaid'] = $this->getAmountPaidSum($startDate, $endDate);
        $data['totalStandard'] = $this->getStandard($startDate, $endDate);
        $data['totalPremium'] = $this->getPremium($startDate, $endDate);

        $data['dataforperiod'] = $formatted_startDate .' - '.$formatted_endDate;

        echo json_encode($data);
    }
    private function getImpression($startDate='', $endDate='', $id='')
    {
		
		
		if(!empty($startDate) && !empty($endDate)){
        $query =  $this->userModel->builder('website_stats')
            ->select('count(id) as website_stats, DATE(created_at) as date')
			->where('user_id',$id)
			->where('impression_count',1)
            ->where('DATE(created_at) <=', $endDate)
            ->where('DATE(created_at) >=', $startDate)
            ->groupBy('date')->get();
		}else{
			$query =  $this->userModel->builder('website_stats')
            ->select('count(id) as website_stats, DATE(created_at) as date')
			->where('user_id',$id)
			->where('impression_count',1)
            ->groupBy('date')->get();
		}

        if (!empty($query->getResult())) {
            $data = array();
            foreach ($query->getResult() as $row) {

                $data['day'][] = date("M-d", strtotime($row->date));
                $data['user'][] = (int) $row->website_stats;
            }
        } else {
            $data['day'][] =  0;
            $data['user'][] = 0;
        }


        return $data;
    }
    private function getViews($startDate='', $endDate='',$id='')
    {
		
		if(!empty($startDate) && !empty($endDate)){
        $query =  $this->userModel->builder('website_stats')
            ->select('count(id) as website_stats, DATE(created_at) as date')
			->where('user_id',$id)
			->where('view_count',1)
            ->where('DATE(created_at) <=', $endDate)
            ->where('DATE(created_at) >=', $startDate)
            ->groupBy('date')->get();
		}else{
			$query =  $this->userModel->builder('website_stats')
            ->select('count(id) as website_stats, DATE(created_at) as date')
			->where('user_id',$id)
			->where('view_count',1)
            ->groupBy('date')->get();
		}

        if (!empty($query->getResult())) {
            $data = array();
            foreach ($query->getResult() as $row) {

                $data['day'][] = date("M-d", strtotime($row->date));
                $data['user'][] = (int) $row->website_stats;
            }
        } else {
            $data['day'][] =  0;
            $data['user'][] = 0;
        }


        return $data;
    }
    private function getTopZip($startDate='', $endDate='')
    { 
		$data['type'] = array();
		$data['user'] = array();	
		$query1 =  $this->userModel->builder('website_stats')->select('zipcode_search, count(*) as count')
            ->where('DATE(created_at) <=', $endDate)->where('DATE(created_at) >=', $startDate)
			->where('zipcode_search !=','')
            ->groupBy('zipcode_search')->orderBy('count','DESC')->limit(5)->get()->getResult();
		if(!empty($query1)){
			foreach($query1 as $q){
				$data['type'][] = $q->zipcode_search;
				$data['user'][] = $q->count;
			}
		}
        return $data;
    }

}
