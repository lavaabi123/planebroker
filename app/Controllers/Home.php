<?php

namespace App\Controllers;
use App\Models\Locations\CityModel;
use App\Models\UsersModel;
use App\Models\EmailModel;
use App\Models\CategoriesModel;
use App\Models\BlogModel;

class Home extends BaseController
{


    public function index()
    {
    	$data['title'] = trans('Home');
		$this->CityModel = new CityModel();
		$data['featured'] = $this->CityModel->get_featured_home(15);
		//echo "<pre>";print_r($data['featured']);exit;
        $this->CategoriesModel = new CategoriesModel();
		$data['categories_list'] = $this->CategoriesModel->get_categories();
        $this->BlogModel = new BlogModel();
		$data['blogs'] = $this->BlogModel->get_all_blog();
		
		//Meta
		$data['meta_title'] = !empty(get_seo('Home')) ? get_seo('Home')->meta_title :'Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Home')) ? get_seo('Home')->meta_description :"Looking for the best Plane Broker? Look no further! Discover experts who cater to your needs.";
		$data['meta_keywords'] = !empty(get_seo('Home')) ? get_seo('Home')->meta_keywords : '';
		
    	return view('pages/home', $data);
        //return view('welcome_message');
    }

    public function aboutus()
    {
        $data['title'] = trans('About Us');
		$data['meta_title'] = !empty(get_seo('About Us')) ? get_seo('About Us')->meta_title : 'About Us | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('About Us')) ? get_seo('About Us')->meta_description : "From mobile to traditional planes, Plane Broker helps you connect with experts.";
		$data['meta_keywords'] = !empty(get_seo('About Us')) ? get_seo('About Us')->meta_keywords : '';
    	return view('pages/aboutus', $data);
    }

    public function faq()
    {
        $data['title'] = trans('F.A.Qs');
		$data['meta_title'] = !empty(get_seo('FAQ')) ? get_seo('FAQ')->meta_title : 'FAQs | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('FAQ')) ? get_seo('FAQ')->meta_description : "";
		$data['meta_keywords'] = !empty(get_seo('FAQ')) ? get_seo('FAQ')->meta_keywords : '';
    	return view('pages/faq', $data);
    }

    public function howitworks()
    {
        $data['title'] = trans('How it works');
		$data['meta_title'] = !empty(get_seo('How It Works')) ? get_seo('How It Works')->meta_title : 'How it works | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('How It Works')) ? get_seo('How It Works')->meta_description : "From mobile to traditional planes, Plane Broker helps you connect with experts.";
		$data['meta_keywords'] = !empty(get_seo('How It Works')) ? get_seo('How It Works')->meta_keywords : '';
        return view('pages/howitworks', $data);
    }

    public function terms()
    {
        $data['title'] = trans('Terms');
		$data['meta_title'] = !empty(get_seo('Terms and Conditions')) ? get_seo('Terms and Conditions')->meta_title : 'Terms | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Terms and Conditions')) ? get_seo('Terms and Conditions')->meta_description : "";
		$data['meta_keywords'] = !empty(get_seo('Terms and Conditions')) ? get_seo('Terms and Conditions')->meta_keywords : '';
        return view('pages/terms', $data);
    }

    public function privacy()
    {
        $data['title'] = trans('Privacy Policy');
		$data['meta_title'] = !empty(get_seo('Privacy Policy')) ? get_seo('Privacy Policy')->meta_title : 'Privacy Policy | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Privacy Policy')) ? get_seo('Privacy Policy')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Privacy Policy')) ? get_seo('Privacy Policy')->meta_keywords : '';
        return view('pages/privacy', $data);
    }

    public function testimonials()
    {
        $data['title'] = trans('Testimonials');
		$data['meta_title'] = !empty(get_seo('Testimonials')) ? get_seo('Testimonials')->meta_title : 'Testimonials | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Testimonials')) ? get_seo('Testimonials')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Testimonials')) ? get_seo('Testimonials')->meta_keywords : '';
        return view('pages/testimonials', $data);
    }

    public function blog()
    {
        $data['title'] = trans('Blog');
        $this->BlogModel = new BlogModel();
		$data['blogs'] = $this->BlogModel->get_all_blog();
		$data['meta_title'] = !empty(get_seo('Blog')) ? get_seo('Blog')->meta_title : 'Blog | Find My Groomer';
		$data['meta_desc'] = !empty(get_seo('Blog')) ? get_seo('Blog')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Blog')) ? get_seo('Blog')->meta_keywords : '';
        return view('pages/blog', $data);
    }
	
    public function blog_detail($clean_url)
    {
        $data['title'] = trans('Blog');
        $this->BlogModel = new BlogModel();
		$data['blogs'] = $this->BlogModel->get_all_blog();
		$data['blog'] = (array)$this->BlogModel->get_blog($clean_url);
		$data['meta_title'] = !empty(get_seo('Blog')) ? get_seo('Blog')->meta_title : 'Blog | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Blog')) ? get_seo('Blog')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Blog')) ? get_seo('Blog')->meta_keywords : '';
        return view('pages/blog_detail', $data);
    }
	
    //maintenance mode
    public function maintenance()
    {
        return view('maintenance');
    }

    public function contact()
    {
        $data['title'] = trans('Contact Us');
		$data['meta_title'] = !empty(get_seo('Contact Us')) ? get_seo('Contact Us')->meta_title : 'Contact Us | Plane Broker';
		$data['meta_desc'] = !empty(get_seo('Contact Us')) ? get_seo('Contact Us')->meta_description : '';
		$data['meta_keywords'] = !empty(get_seo('Contact Us')) ? get_seo('Contact Us')->meta_keywords : '';
        return view('pages/contact', $data);
    }
	
    public function pricing()
    {
        $data['title'] = trans('Pricing');
		
		$data['user_plan_details'] = array();
		$data['standard_trial'] = array();
		$data['premium_trial'] = array();
		$this->UsersModel = new UsersModel();
		if ($this->session->get('vr_sess_logged_in') == TRUE) {
			$data['user_plan_details'] = $this->UsersModel->get_user($this->session->get('vr_sess_user_id'));
			$data['standard_trial'] = $this->UsersModel->get_trial($this->session->get('vr_sess_user_id'),2);
			$data['premium_trial'] = $this->UsersModel->get_trial($this->session->get('vr_sess_user_id'),3);
		}
		
		$data['meta_title'] = !empty(get_seo('Pricing')) ? get_seo('Pricing')->meta_title : 'Mobile dog grooming Las Vegas | Best dog groomers in las vegas';
		$data['meta_desc'] = !empty(get_seo('Pricing')) ? get_seo('Pricing')->meta_description : "Need Plane Brokers? Find Them Here - From mobile to traditional planes, connect with professionals.";
		$data['meta_keywords'] = !empty(get_seo('Pricing')) ? get_seo('Pricing')->meta_keywords : '';
		
        return view('Providerauth/ProviderPlan', $data);
    }
	
	public function submit_contact(){
		
		// Validation
		
		$rules = [
            'name' => [
                'rules'  => 'required|min_length[4]|max_length[100]'
            ],
			'email' => [
                'rules'  => 'required|valid_email|max_length[100]'
            ],
			'subject' => [
                'rules'  => 'required'
            ],
			'message' => [
                'rules'  => 'required'
            ]
			,
			'recaptcha_response' => [
				'rules'  => 'required',
				'errors' => [
                    'required' => 'You are not a human!',
				]
			]
		];
			
		if ($this->validate($rules)) {
			//echo '1';exit;     
			$email          = $this->request->getVar('email');
			$phone          = $this->request->getVar('phone');
			$name           = $this->request->getVar('name');
			$siteName       = get_general_settings()->application_name;
			$subject        = $siteName.' Contact Form';
			$userMessage    = $this->request->getVar('message');
			$message        = "<b>You received this message from a customer who visited the contact page of ".$siteName." .</b><br><br>Name: ".$name."<br>Email: ".$email."<br>Phone: ".$phone."<br>Message:<br>".$userMessage;
			$data = array(
				'subject'           => $subject,
				'message_text'      => $message,
				'from_email' => get_general_settings()->admin_email,
				'to'                => get_general_settings()->mail_reply_to,
				'template_path'     => "email/email_to_provider",
			);
			
			
			$message1 = "Thank you for contacting ".$siteName.". our team will reach out soon.";
			$data1 = array(
				'subject'           => "Thank you for contacting ".$siteName,
				'message_text'      => $message1,
				'to'                => get_general_settings()->mail_reply_to,
				'template_path'     => "email/email_to_provider",
			);
			
			$emailModel = new EmailModel();
			$emailModel->send_email($data1);
			$emailModel = new EmailModel();
			$emailModel->send_email($data);
			
			$insertData     = array();
			$insertData['from_name']         = $name;
			$insertData['from_email']        = $email;
			$insertData['from_phone']        = $phone;
			$insertData['from_message']      = $userMessage;
			$insertData['subject']    		 = $subject;
			$insertData['created_at']        = date('Y-m-d H:i:s');

			$id = $this->db->table('contacts')->insert($insertData);
			
			$this->session->setFlashData('success_form', 'Successfully Sent!');
			return redirect()->to(base_url('/contact'));
		} else {
			//echo '2';exit;
            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->to($this->agent->getReferrer())->withInput()->with('error', $this->validator->getErrors());
        }
		
     }
	public function update_call_count($user_id)
    {		
		if(!empty($user_id)){
		$query2 =  $this->userModel->db->query("UPDATE users SET call_count = call_count + 1 WHERE id = ".$user_id);
		$user_latitude = !empty($this->session->get('user_latitude')) ? $this->session->get('user_latitude') : '';
		$user_longitude = !empty($this->session->get('user_longitude')) ? $this->session->get('user_longitude') : '';
		$user_zipcode = !empty($this->session->get('user_zipcode')) ? $this->session->get('user_zipcode') : '';
		$query2 =  $this->userModel->db->query("INSERT INTO website_stats (user_id,call_count,customer_lat,customer_long,customer_zipcode) VALUES (".$user_id.",1,'".$user_latitude."','".$user_longitude."','".$user_zipcode."')");
		}
		echo "success";exit;
	}
	public function update_direction_count($user_id)
    {		
		if(!empty($user_id)){
		$query2 =  $this->userModel->db->query("UPDATE users SET direction_count = direction_count + 1 WHERE id = ".$user_id);
		$user_latitude = !empty($this->session->get('user_latitude')) ? $this->session->get('user_latitude') : '';
		$user_longitude = !empty($this->session->get('user_longitude')) ? $this->session->get('user_longitude') : '';
		$user_zipcode = !empty($this->session->get('user_zipcode')) ? $this->session->get('user_zipcode') : '';
		$query2 =  $this->userModel->db->query("INSERT INTO website_stats (user_id,direction_count,customer_lat,customer_long,customer_zipcode) VALUES (".$user_id.",1,'".$user_latitude."','".$user_longitude."','".$user_zipcode."')");
		}
		echo "success";exit;
	}
}
