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
use App\Models\ProductModel;

class Common extends BaseController
{
    protected $stateModel;
    protected $countyModel;
    protected $cityModel;
    protected $userModel;
    protected $emailTemplatesModel;
    protected $fieldsModel;
    protected $FieldGroupModel;
    protected $GeneralSettingModel;
    protected $categoriesModel;
    protected $categoriessubModel;
    protected $EmailModel;
    protected $ProductModel;
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
			->where('user_level',0)->get()->getRow();
		return !empty($query2) ? (int) $query2->users : 0;

    }
    private function getPremium($startDate, $endDate)
    {        
		
		$query2 =  $this->userModel->builder('users')->select('count(id) as users, plan_id,is_trial,is_cancel')
            ->where('DATE(created_at) <=', $endDate)->where('DATE(created_at) >=', $startDate)
			->where('user_level',1)->get()->getRow();
		return !empty($query2) ? (int) $query2->users : 0;

    }
    private function getUsersAuth($startDate, $endDate)
    {    //$db = \Config\Database::connect();    
		$query =  $this->userModel->builder('plans')->select('id,name')->get();
		$data['type'] = array();
        if (!empty($query->getResult())) {
            $data = array();
            foreach ($query->getResult() as $r => $row) {
                $data['type'][$r] = $row->name;				
				$query = $this->userModel->builder('sales AS s')
				->select('s.*, u.fullname AS provider,u.user_level,p.name as plan_name,p.price as plan_price,pr.id as product_id,c.permalink,pr.category_id,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR " ") AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = "title") t ON t.field_id = pd.field_id WHERE pd.product_id = pr.id) as display_name')
				->join('users AS u', 'u.id = s.user_id', 'left')
				->join('plans AS p', 'p.id = s.plan_id', 'left')
				->join('products AS pr', 'pr.id = s.product_id', 'left')
				->join('categories AS c', 'c.id = pr.category_id', 'left')
				->where('s.plan_id',$row->id)->where('s.is_cancel', 0)->where('u.fullname IS NOT NULL')
				->get()->getResult();
			//echo $db->getLastQuery();exit;	
				$data['user'][$r] = !empty($query) ? (int) count($query) : 0;
            }
        }
		

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
					$option_html .= '<div class="d-flex fieldoption gap-2"><div class="col px-0"><input type="text" class="form-control" placerholder="Option Name" value="'.$option.'" name="field_options[]"></div><a href="javascript:void(0)" class="button tiny alert removeOption p-2"><i class="fas fa-trash"></i></a></div>';
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
                'field_condition' => $field->field_condition, 
                'field_order' => $field->field_order,
                'field_options' => $field->field_options,
				'option_html' => $option_html,
				'allCategories' => $allCategories,
				'allSubcategories' => $allSubcategories,
				'allGroups' => $allGroups,
				'selectedCategories' => array_column($selectedCategories, 'category_id'),
				'selectedSubcategories' => array_column($selectedSubcategories, 'sub_category_id'),	
				'selectedGroups' => array_column($selectedGroups, 'fields_group_id'),	
                'status' => $field->status,
                'is_filter' => $field->is_filter,	
                'filter_type' => $field->filter_type, 		
            );
        }
        echo json_encode($data);
    }
	
	public function send_email_to_friend(){
		
		if(!empty($this->request->getVar('check_bot'))){
        $userId         = $this->request->getVar('userId');   
        $fromuserId     = $this->request->getVar('fromuserId');     
        $productId      = $this->request->getVar('productId');     
        $email          = $this->request->getVar('email');
        $remail         = $this->request->getVar('remail');
        $link         	= $this->request->getVar('link');
        $siteName       = get_general_settings()->application_name;
        $subject        = $siteName.' Sharing Product';
        $userMessage    = $this->request->getVar('message');
        $message        = "<b>You received this message from a customer who visited ".$siteName." product and shared with you.</b><br><br>Email: ".$email."<br>Message:<br>".$userMessage."<br>Product Link:<br>".$link;
		//$message        = "You have received a message from a customer.";
        $user_detail    = $this->userModel->get_user($userId);
		
        
        $data = array(
            'subject'           => "You Have A Message",//$subject,
            'message_text'      => $message,
            'to'                => $remail,
            'template_path'     => "email/email_to_provider",
        );
		$message_admin        = "<b>".$user_detail->business_name." - ".$user_detail->email." received this message from a customer who visited and shared product link via email to friend.</b><br><br>Email: ".$email."<br>Recipients Email: ".$remail."<br>Message:<br>".$userMessage;
		$data_admin = array(
            'subject'           => "Customer Sent Referral Email",//$subject,
            'message_text'      => $message_admin,
			'from_email' => get_general_settings()->admin_email,
			'to' => get_general_settings()->mail_reply_to,
            'template_path'     => "email/admin/new_user",
        );
		
        $emailModel = new EmailModel();
        $emailModel->send_email($data); 
        $emailModel->send_email($data_admin);  

        $insertData     = array();
        $logged_user_id = 0;

        if (auth_check()) {
            $logged_user_id = $this->session->get('vr_sess_user_id');
        }

        $insertData['recipient_email']   = $remail;
        $insertData['from_email']        = $email;		
        $insertData['from_message']      = $userMessage;
        $insertData['logged_user_id']    = $logged_user_id;
        $insertData['to_user_id']        = $userId;
        $insertData['from_user_id']      = $fromuserId;
        $insertData['product_id']        = $productId;
        $insertData['created_at']        = date('Y-m-d H:i:s');

        $id = $this->db->table('email_referral')->insert($insertData);		
			
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
	
    public function send_message_to_provider()
    {
		if(!empty($this->request->getVar('check_bot'))){
        $userId         = $this->request->getVar('userId');   
        $fromuserId     = $this->request->getVar('fromuserId');     
        $productId      = $this->request->getVar('productId');     
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
		
		$this->ProductModel = new ProductModel();
		$where = ' AND p.id = '.$this->request->getVar('productId');
		$product_detail = $this->ProductModel->get_product_detail($where);
        /*
        $data = array(
            'subject'           => "You Have A Message",//$subject,
            'message_text'      => $message,
            'to'                => !empty($product_detail['email']) ? $product_detail['email'] : $user_detail->email,
            'template_path'     => "email/email_to_provider",
        ); */
		$message_admin        = "<b>".( !empty($product_detail['business_name']) ? $product_detail['business_name'] : $user_detail->business_name)." - ".( !empty($product_detail['email']) ? $product_detail['email'] :  $user_detail->email)." received this message from a customer who visited their profile.</b><br><br>Name: ".$name."<br>Email: ".$email."<br>Phone: ".$phone."<br>Best way to reach you?:".$best_way."<br>Message:<br>".$userMessage;
		$data_admin = array(
            'subject'           => "Customer Contacted Seller",//$subject,
            'message_text'      => $message_admin,
			'from_email' => get_general_settings()->admin_email,
			'to' => get_general_settings()->mail_reply_to,
            'template_path'     => "email/admin/new_user",
        );
		/*$message_cus        = "<p>Dear ".$name.",</p><p>Thank you for choosing <a href='".base_url()."'>planebroker.com!</a> Your message has been received, and we are pleased to confirm that your designated owner, ".( !empty($product_detail['business_name']) ? $product_detail['business_name'] : $user_detail->business_name).", will be in touch with you shortly. They will address any questions you may have, discuss your needs, and finalize the details to ensure a seamless buying experience.</p><p>Thank you!</p>";
		
		$additional = $this->ProductModel->get_products($category_name='all',$where='','RAND() LIMIT 3');
		
		$data_customer = array(
            'subject'           => "Message Received - planebroker.com",//$subject,
            'message_text'      => $message_cus,
			'from_email' => get_general_settings()->mail_reply_to,
			'to' => $email,
            'template_path'     => "email/email_send_message",
			'product_detail'=>$product_detail,
			'additional'=>$additional
        );*/
		
        $emailModel = new EmailModel();
		
		
		$get_email_content = $this->db->table('email_templates')->where('email_title', 'message_seller')->get()->getRowArray();
		$emailContent = $get_email_content['content'];
		$placeholders = [
			'{user_name}' => $product_detail['fullname'],
			'{listing_name}'    =>$product_detail['display_name'],
			'{listing_url}'     =>base_url().'/listings/'.$product_detail['permalink'].'/'.$product_detail['id'].'/'.(!empty($product_detail['display_name'])?str_replace(' ','-',strtolower($product_detail['display_name'])):''),
			'{name}'     => $name,
			'{email}'     => $email,
			'{phone}'     => $phone,
			'{best_way}'     => $best_way,
			'{user_message}'     => $userMessage,
		];

		foreach ($placeholders as $key => $value) {
			$emailContent = str_replace($key, $value, $emailContent);
		}
		$emailModel = new EmailModel();
		$data_email = array(
			'subject' => $get_email_content['name'],
			'content' => $emailContent,
			'to' => !empty($product_detail['email']) ? $product_detail['email'] : $user_detail->email,
			'template_path' => "email/email_content",
		);
        $emailModel->send_email($data_email); 
		
		
		$get_email_content = $this->db->table('email_templates')->where('email_title', 'message_customer')->get()->getRowArray();
		$emailContent = $get_email_content['content'];
		$placeholders = [
			'{user_name}' => $name,
			'{site_url}'     => base_url(),
		];

		foreach ($placeholders as $key => $value) {
			$emailContent = str_replace($key, $value, $emailContent);
		}
		$emailModel = new EmailModel();
		$data_customer = array(
			'subject' => $get_email_content['name'],
			'content' => $emailContent,
			'to' => $email,
			'template_path' => "email/email_content",
		);
        $emailModel->send_email($data_customer);
		
		
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
        $insertData['from_user_id']      = $fromuserId;
        $insertData['product_id']        = $productId;
        $insertData['created_at']        = date('Y-m-d H:i:s');

        $id = $this->db->table('provider_messages')->insert($insertData);
		
		$query2 =  $this->userModel->db->query("UPDATE products SET form_count = form_count + 1 WHERE id = ".$productId);
		$query2 =  $this->userModel->db->query("UPDATE users SET form_count = form_count + 1 WHERE id = ".$userId);
		$user_latitude = !empty($this->session->get('user_latitude')) ? $this->session->get('user_latitude') : '';
		$user_longitude = !empty($this->session->get('user_longitude')) ? $this->session->get('user_longitude') : '';
		$user_zipcode = !empty($this->session->get('user_zipcode')) ? $this->session->get('user_zipcode') : '';
		$query2 =  $this->userModel->db->query("INSERT INTO website_stats (user_id,product_id,form_count,customer_lat,customer_long,customer_zipcode) VALUES (".$userId.",".$productId.",1,'".$user_latitude."','".$user_longitude."','".$user_zipcode."')");
		
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
            echo "<tr><td>Email:</td><td><a href='mailto:".$message->from_email."'>".$message->from_email."</a></td></tr>";
            echo "<tr><td>Phone:</td><td><a href='tel:+1".$message->from_phone."'>".$message->from_phone."</a></td></tr>";
            echo "<tr><td>Date / Time:</td><td>".formatted_date($message->created_at,'m/d/Y h:i a')."</td></tr>";          
            echo "<tr><td>Message:</td><td><div class='listing-msg'>".$message->from_message."</div></td></tr>";           
            echo '<tr><td>Listing Name:</td><td><a target="_blank" href="'.base_url().'/listings/'.$message->permalink.'/'.$message->product_id.'/'.(!empty($message->display_name)?str_replace(' ','-',strtolower($message->display_name)):'').'" class=" ">'.$message->display_name.'</td></tr>';        
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

    public function get_captain_messages()
    {
        $message_id = $this->request->getVar('message_id');
        $message = $this->userModel->getCaptainMessages($message_id);
        $status = 0;
        $data = array();
        echo "<table class='table table-striped'>";
        if (!empty($message)) {            
            echo "<tr><td>Name:</td><td>".$message->from_name."</td></tr>";
            echo "<tr><td>Email:</td><td>".$message->from_email."</td></tr>";
            echo "<tr><td>Dealer / Company Name:</td><td>".$message->company_name."</td></tr>";
            echo "<tr><td>Dealer / Company Description:</td><td>".$message->company_des."</td></tr>";
            echo "<tr><td>phone:</td><td>".$message->from_phone."</td></tr>";
            echo "<tr><td>Date:</td><td>".formatted_date($message->created_at)."</td></tr>";         
            echo "<tr><td>Additional Information:</td><td>".$message->from_message."</td></tr>";        
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
		return $row->totalAmountPaid;
		
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
		$product_id = !empty($_GET['product_id']) ? $_GET['product_id'] : '';
        $data['latest'] = $this->getViews($startDate, $endDate,$product_id);
        $data['impression'] = $this->getFavorite($startDate, $endDate, $product_id);
        $data['form_submission'] = $this->getFormSubmission($startDate, $endDate, $product_id);
        $data['called'] = $this->getPeopleCalled($startDate, $endDate, $product_id);
        $data['user_type'] = $this->getTopZip($startDate, $endDate);
        $data['totalAmountPaid'] = $this->getAmountPaidSum($startDate, $endDate);
        $data['totalStandard'] = $this->getStandard($startDate, $endDate);
        $data['totalPremium'] = $this->getPremium($startDate, $endDate);

        $data['dataforperiod'] = $formatted_startDate .' - '.$formatted_endDate;

        echo json_encode($data);
    }
    private function getFavorite($startDate='', $endDate='', $id='')
    {
		
		
		if(!empty($startDate) && !empty($endDate)){
        $query =  $this->userModel->builder('user_favorites')
            ->select('count(product_id) as website_stats, DATE(created_at) as date')
			->where('product_id',$id)
            ->where('DATE(created_at) <=', $endDate)
            ->where('DATE(created_at) >=', $startDate)
            ->groupBy('date')->get();
		}else{
			$query =  $this->userModel->builder('user_favorites')
            ->select('count(product_id) as website_stats, DATE(created_at) as date')
			->where('product_id',$id)
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
    private function getPeopleCalled($startDate='', $endDate='', $id='')
    {	
		if(!empty($startDate) && !empty($endDate)){
        $query =  $this->userModel->builder('website_stats')
            ->select('count(id) as website_stats, DATE(created_at) as date')
			->where('product_id',$id)
			->where('call_count',1)
            ->where('DATE(created_at) <=', $endDate)
            ->where('DATE(created_at) >=', $startDate)
            ->groupBy('date')->get();
		}else{
			$query =  $this->userModel->builder('website_stats')
            ->select('count(id) as website_stats, DATE(created_at) as date')
			->where('product_id',$id)
			->where('call_count',1)
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
	
    private function getFormSubmission($startDate='', $endDate='', $id='')
    {	
		if(!empty($startDate) && !empty($endDate)){
        $query =  $this->userModel->builder('website_stats')
            ->select('count(id) as website_stats, DATE(created_at) as date')
			->where('product_id',$id)
			->where('form_count',1)
            ->where('DATE(created_at) <=', $endDate)
            ->where('DATE(created_at) >=', $startDate)
            ->groupBy('date')->get();
		}else{
			$query =  $this->userModel->builder('website_stats')
            ->select('count(id) as website_stats, DATE(created_at) as date')
			->where('product_id',$id)
			->where('form_count',1)
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
			->where('product_id',$id)
			->where('view_count',1)
            ->where('DATE(created_at) <=', $endDate)
            ->where('DATE(created_at) >=', $startDate)
            ->groupBy('date')->get();
		}else{
			$query =  $this->userModel->builder('website_stats')
            ->select('count(id) as website_stats, DATE(created_at) as date')
			->where('product_id',$id)
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
