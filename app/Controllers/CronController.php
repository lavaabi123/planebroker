<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\EmailModel;
use Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Subscription;
use Stripe\Invoice;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CronController extends BaseController
{
    protected $usersModel;
    protected $EmailModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {        
        //$this->usersModel->process_admin_upgraded_users();
        
        $subscriptions = $this->usersModel->get_active_stripe_subscriptions();
        $this->processStripeSubscriptions($subscriptions);

        //$users = $this->usersModel->get_stripe_subscribed_expired_users(true);
        //$this->processStripeSubscriptions($users, true);
		
        //$users = $this->usersModel->get_stripe_subscribed_trial_users(true);
        //$this->sendReminderEmail($users);                

        //$this->processPaypalSubscriptions();
		
        $arrContent = [
                        '-------------CRON EXECUTED------------------',
                        date('Y-m-d H:i:s'),                  
                        '-------------------------------------------------------'
                        ];
        $this->cron_log($arrContent);
        //$this->send_cron_mail($arrContent);

        echo "DONE";
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
	
	public function sendReminderEmail($users){
		if(!empty($users)){
			foreach($users as $user){
				$message = '<p>Plane Broker will deduct payment for your subscription after 3 days as your trial ends.</p>';
				$subject = 'Processing subscriptions';
				$data = array(
							'subject'           => $subject,
							'template_path' 	=> "email/trial_end_reminder",
							//'mail_body_content' => $message,
							'to'                => $user->email,
							'from_email'        => "lara@planebroker.com",
							'from_name'         => "Plane Broker"
							);
				$emailModel = new EmailModel();
				$emailModel->send_email($data);
			}
		}		
	}
	
	public function processPaypalSubscriptions(){
		$access_token = $this->get_paypal_access_token();
		$curl = curl_init();		
		$s_date = date('Y-m-d').'T00:00:01Z';
		$e_date = date('Y-m-d').'T23:59:59Z';
		
		//$s_date = '2023-12-01T00:00:01Z';
		//$e_date = '2023-12-02T23:59:59Z';
		
		//For trans detail
		curl_setopt($curl, CURLOPT_URL, env('paypalApiUrl')."reporting/transactions?start_date=".$s_date."&end_date=".$e_date."&fields=all");
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
		$results = json_decode($response,true);//echo "<pre>";print_r($results);exit;
		if(!empty($results['transaction_details'])){
			foreach($results['transaction_details'] as $result){	
				if($result['transaction_info']['transaction_subject'] == 'Standard with Trial' || $result['transaction_info']['transaction_subject'] == 'Standard' || $result['transaction_info']['transaction_subject'] == 'Standard with 30 day Trial'){
					$p_id = 2;
				}else{
					$p_id = 3;
				}
				$check_user = $this->usersModel->get_user_by_sid($result['transaction_info']['paypal_reference_id']);if(!empty($check_user)){
					$uid = $check_user->id;
				}	else{
					$uid = 0;
				}	
				$data_insert = [
					'user_id'               		=> $uid,
					'plan_id' 						=> $p_id,
					'transaction_id'        		=> $result['transaction_info']['transaction_id'],
					'transaction_amount' 			=> $result['transaction_info']['transaction_amount']['value'],
					'transaction_status'    		=> ($result['transaction_info']['transaction_status'] == 'S') ? 'Success' :'Failed',
					'transaction_initiation_date' 	=> date('Y-m-d h:i:s',strtotime($result['transaction_info']['transaction_initiation_date'])),
					'payer_email'  					=> $result['payer_info']['email_address'],
					'payer_id'    					=> $result['transaction_info']['paypal_account_id'],
					'paypal_reference_id'			=> $result['transaction_info']['paypal_reference_id'],
					'subscription_id'				=> $result['transaction_info']['paypal_reference_id'],
				];
				
				$user1 = $this->usersModel->insert_paypal_sales_cron($data_insert);
				
				$updateUser = [
					'stripe_subscription_start_date'  => date('Y-m-d h:i:s',strtotime($result['transaction_info']['transaction_initiation_date'])),
					'stripe_subscription_end_date'    => date('Y-m-d h:i:s',strtotime($result['transaction_info']['transaction_initiation_date']. ' +1 month')),
				];
				$this->usersModel->update_user_plan($uid,$updateUser); 
	
			}
		} 		
		
	}

    public function processStripeSubscriptions($subscriptions,$gracePeriod = false){
		
		
		
        Stripe\Stripe::setApiKey(env('stripe.secret'));
        foreach ($subscriptions as $user) {
			if(!empty($user->stripe_subscription_id)){
            $moveToFreePlan = 0;
            // Retrieve the subscription
            try {
                $subscription = Subscription::retrieve($user->stripe_subscription_id);					
            }catch (\Stripe\Exception\ApiErrorException $e) {
                $error_message = $e->getMessage();
                if (strpos($error_message, 'No such subscription') !== false) {
                    $moveToFreePlan = 1;  
					$db = db_connect();
					$db->table('sales')->where('id', $user->id)->delete();                
                } else {                    
                    // LOG
                    $arrContent = [
                        '-------------Subscription fetch error------------------',
                        date('Y-m-d H:i:s'),
                        $user->stripe_subscription_id,
                        $user->id,                       
                        '-------------------------------------------------------'
                        ];
                    $this->cron_log($arrContent);
                    //$this->send_cron_mail($arrContent, $user->id);

                    continue;
                }               
            }

            $mailToProvider  = [
                                'first_name'                      => $user->first_name,
                                'email'                           => $user->email,
                                'stripe_subscription_customer_id' => $user->stripe_subscription_customer_id,
                                'stripe_subscription_end_date'    => $user->stripe_subscription_end_date,
                                'skipsubscription'                => 0
                               ];

            if($moveToFreePlan == 1 || (isset($subscription->status) && $subscription->status != 'active')){
				$db = db_connect();
				//$db->table('sales')->where('id', $user->id)->delete();
				$db->table('sales')->where('id', $user->id)->update(['stripe_subscription_status'=>$subscription->status]);				
            }

            if(!isset($subscription->latest_invoice)){
                continue;
            }

            $latestInvoiceId = $subscription->latest_invoice;
           
            try {
                $invoice = \Stripe\Invoice::retrieve($latestInvoiceId); 	
            }catch (\Stripe\Exception\ApiErrorException $e) {
                $error_message = $e->getMessage();

                // LOG
                $arrContent = [
                    '-------------INVOICE NOT EXISTS------------------',
                    date('Y-m-d H:i:s'),
                    $user->stripe_subscription_id,
                    $latestInvoiceId,
                    $user->id,
                    '-------------------------------------------------------'
                    ];
                $this->cron_log($arrContent);
                $this->send_cron_mail($arrContent, $user->id);


                continue;             
            }
            //print_r($invoice);
            $paymentStatus = $invoice->status;


            if($latestInvoiceId != $user->stripe_invoice_id){
                // new invoice
                if ($paymentStatus === 'paid') {
                    // Payment for the next billing cycle has been made for this subscription
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
                    $sales_created_at                     = date('Y-m-d H:i:s', $invoice->created);

                    $data_insert = [
                        'stripe_subscription_start_date'  => $stripe_subscription_start_date,
                        'stripe_subscription_end_date'    => $stripe_subscription_end_date,
                        'stripe_invoice_id'               => $stripe_invoice_id,
                        'stripe_invoice_charge_id'        => $stripe_invoice_charge_id,
                        'stripe_invoice_status'           => $stripe_invoice_status,
                        'created_at'                      => $sales_created_at,
                    ];
  
					$db = db_connect();
					$db->table('sales')->where('id', $user->id)->update($data_insert);
                    //$this->usersModel->insert_sales($data_insert);

                    // LOG
                    $arrContent = [
                        '-------------PAID------------------',
                        date('Y-m-d H:i:s'),
                        $user->id,
                        $user->stripe_subscription_id,
                        json_encode($data_insert, true),
                        '-------------------------------------------------------'
                        ];
                    $this->cron_log($arrContent);
                    //$this->send_cron_mail($arrContent, $user->id);
    
                } else {
                                       
                }
            }else{                
                //same old invoice                         
            }  
		}			
        }
    }

    public function send_cron_mail($arrContent, $userId = '', $subject = ''){
        

        $message = '';

        foreach ($arrContent as $val) {
            $message .= $val . '<br />';
        }
		if(empty($subject)){
			$subject = 'Cron - Processing subscriptions';
		}
        
        if(!empty($userId)){
            $subject .= ' - USER ID: '. $userId;
        }

        $data = array(
                    'subject'           => $subject,
                    'mail_body_content' => $message,
                    'to'                => get_general_settings()->mail_reply_to,
                    'from_email'        => get_general_settings()->admin_email,
                    'from_name'         => "Plane Broker - CRON"
                    );
        $emailModel = new EmailModel();
        $emailModel->send_email($data);
    }

    public function cron_log($arrContent){
		
       $file = fopen("cron.txt", 'a+');

       if ($file) {
            foreach ($arrContent as $val) {
                fwrite($file, $val . PHP_EOL);
            }
            
            fclose($file); 
       } else {
            echo 'Unable to open the file for writing.';
       }
    }

    public function subscription_failed_mail($data = array()){
        if(count($data) < 1) return;

        $subject = 'Your Payment Was Unsuccessful';

        $subscriptions = $cards = array();
        // Retrieve all subscriptions of the customer
        if($data['stripe_subscription_customer_id'] != '' && $data['skipsubscription'] == 0){
            $customerId = $data['stripe_subscription_customer_id'];

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

        $data = array(
                    'subject'           => $subject,
                    'to_name'           => $data['first_name'],
                    'to'                => $data['email'],
                    'cc'                => "lara@planebroker.com",
                    'from_email'        => "lara@planebroker.com",
                    'from_name'         => "Plane Broker",
                    'template_path'     => "email/email_subscription_failed",
                    'subscriptions'     => $subscriptions,
                    'cards'             => $cards,
                    'enddate'           => $data['stripe_subscription_end_date']
                    );

        $emailModel = new EmailModel();
        $emailModel->send_email($data);
    }
	
	public function send_confirmation_reminder_mail($data=array()){

        $subject = 'Confirm Your Email';
		
		$unconfirmed_users = $this->usersModel->get_user_by_email_status('0');
		
		if(!empty($unconfirmed_users)){
			foreach ($unconfirmed_users as $user) {
				if(!empty($user->email)){
					$data = array(	
						'subject' => "Email Address Validation Reminder",
						'to' => $user->email,
						'to_name'           => !empty($user->fullname) ? $user->fullname : 'Provider',
						'template_path' => "email/email_activation_reminder",
						'token' => $user->token	
					);
					$emailModel = new EmailModel();
					$emailModel->send_email($data);			
				}
			}
		}
		
		// LOG
		$arrContent = [
				'-------------CONFIRM EMAIL REMINDER------------------',
				date('Y-m-d H:i:s'),
				'-------------------------------------------------------'
				];
		$this->cron_log($arrContent);                            
		$this->send_cron_mail($arrContent,'','Cron - Confirm Email Reminder');
		echo "DONE";
	}
	
	public function send_weekly_report_mail($data=array()){
        
		$users = $this->usersModel->get_users();		
		if(!empty($users)){
			foreach ($users as $user) {
				if(!empty($user->email) && $user->id != 1){
					
					
					$this->UsersModel = new UsersModel();
		$data['user_detail'] = $this->UsersModel->get_user($user->id);
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
		
		$data['view_count'] = $this->UsersModel->db->query('SELECT count(*) as view_count FROM `website_stats` where view_count = 1 AND user_id = '.$user->id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->view_count;
		$data['call_count'] = $this->UsersModel->db->query('SELECT count(*) as call_count FROM `website_stats` where call_count = 1 AND user_id = '.$user->id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->call_count;
		$data['form_count'] = $this->UsersModel->db->query('SELECT count(*) as form_count FROM `website_stats` where form_count = 1 AND user_id = '.$user->id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->form_count;
		$data['direction_count'] = $this->UsersModel->db->query('SELECT count(*) as direction_count FROM `website_stats` where direction_count = 1 AND user_id = '.$user->id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->direction_count;
		$data['zipcode_count'] = $this->UsersModel->db->query('SELECT count(*) as zipcode_count FROM `website_stats` where  location_id = '.$data['user_detail']->location_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->zipcode_count;
		$data['impression_count'] = $this->UsersModel->db->query('SELECT count(*) as impression_count FROM `website_stats` where impression_count = 1 AND user_id = '.$user->id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->impression_count;
		
		
		$query2 =  $this->userModel->db->query('SELECT count(*) as user_count, zipcodes.city, zipcodes.zipcode, states.code as state_code FROM `website_stats` w LEFT JOIN zipcodes ON w.customer_zipcode = zipcodes.zipcode LEFT JOIN states ON zipcodes.state_id = states.id where w.customer_zipcode != ""  AND w.user_id = '.$user->id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'" AND city != "" GROUP BY w.customer_zipcode order by user_count desc  limit 10')->getResult();
		$query1 =  $this->UsersModel->db->query('SELECT * FROM `website_stats` where customer_zipcode != ""  AND user_id = '.$user->id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'" GROUP BY created_at order by created_at desc LIMIT 20')->getResult();
		$query3 =  $this->UsersModel->db->query('SELECT * FROM `website_stats` where call_count = 1  AND user_id = '.$user->id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"  order by created_at desc LIMIT 20')->getResult();
		//print_r($query1);exit;	
        $data['top_locations'] = $query2;
        $data['top_calls'] = $query3;
		$data['recent_payments'] = $query1;

		$data['zipcodes'] = json_encode($arr);
        $data['id'] = $user->id;
		$data['from_cron'] = 1;
		
					// Unlink (delete) the PDF file
					$pdfPath = FCPATH.'pdf/output_'.$user->id.'.pdf';
					
					$retryAttempts = 3;
					$retryDelay = 1; // in seconds

					for ($i = 0; $i < $retryAttempts; $i++) {
						if (@unlink($pdfPath)) {
							//echo 'PDF file deleted successfully!';
							break;
						} else {
							sleep($retryDelay);
						}
					}
					
					$data['to_name'] = !empty($user->fullname) ? $user->fullname : 'Plane Broker';
					$data['subject'] = $data['to_name']." - Last Week's Snapshot on your Plane Broker profile";
					$data['to'] = $user->email;
					$data['template_path'] = "email/weekly_report";
					

					// Specify the URL to the view containing the chart
					$url = base_url().'/providerauth/dashboard1?id='.$user->id;
					// Call the Node.js script to generate PDF
					$this->generatePdfFromUrlWithPuppeteer($url,$user->id);
					
					$data['output'] = realpath(FCPATH . 'pdf/output_'.$user->id.'.pdf');
					$emailModel = new EmailModel();
					$emailModel->send_email($data);
					
					// Unlink (delete) the PDF file
					$pdfPath = FCPATH.'pdf/output_'.$user->id.'.pdf';
					
					$retryAttempts = 3;
					$retryDelay = 1; // in seconds

					for ($i = 0; $i < $retryAttempts; $i++) {
						if (@unlink($pdfPath)) {
							//echo 'PDF file deleted successfully!';
							break;
						} else {
							sleep($retryDelay);
						}
					}
											
				}
			}
		}
		
		// LOG
		$arrContent = [
				'-------------CONFIRM EMAIL REMINDER------------------',
				date('Y-m-d H:i:s'),
				'-------------------------------------------------------'
				];
		$this->cron_log($arrContent);                            
		$this->send_cron_mail($arrContent,'','Cron - Sent Weekly Report');
		echo "DONE";
	}
	private function generatePdfFromUrlWithPuppeteer($url,$id) {
        $nodeCommand = 'node';
        $nodeScript = FCPATH . 'generatePdf.js'; // Create this script in the previous step

        // Run the Node.js script with the URL as an argument
        $process = new Process([$nodeCommand, $nodeScript, $url,$id]);
        $process->run();

        // Check for any errors during the execution of the script
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Output success message or handle the generated PDF file as needed
        //echo 'PDF generated successfully!';
    }
	public function send_optimization_reminder_mail($data=array()){
        
		$users = $this->usersModel->get_users_condition($data=array('about_me','hours','images'));	
		
		if(!empty($users)){
			foreach ($users as $user) {
				if(!empty($user->email)){						
					$data['subject'] = "Plane Broker - Reminder for Optimization";
					$data['to'] = $user->email;
					$data['to_name'] = !empty($user->fullname) ? $user->fullname : 'Plane Broker';
					$data['message_text'] = '<h5 style="text-align:center;">Hello, '.$user->fullname.'</h5><p style="color: #000000; font-size:11px;text-align:center; margin-bottom: 5px;">We are requesting you to complete your profile by adding Hours, About Us, Photos to appear in searches and get more customers. Thank you!';
					$data['template_path'] = "email/admin/new_user";
					
					//echo view('email/admin/new_user', $data); exit;
					$emailModel = new EmailModel();
					$emailModel->send_email($data);			
				}
			}
		}
		
		// LOG
		$arrContent = [
				'-------------CONFIRM EMAIL REMINDER------------------',
				date('Y-m-d H:i:s'),
				'-------------------------------------------------------'
				];
		$this->cron_log($arrContent);                            
		$this->send_cron_mail($arrContent,'','Cron - Automatic Reminders for Optimization');
		echo "DONE";
	}
	public function sendCCReminderEmail(){
		$users = $this->usersModel->get_cc_reminder_users();
		//echo "<pre>";print_r($users);exit;
		if(!empty($users)){
			foreach($users as $user){
				$subject = 'Complete Your Registration at planebroker.com';
				$data = array(
							'subject'           => $subject,
							'template_path' 	=> "email/email_cc_reminder",
							'to'                => $user->email,
							'from_email'        => "lara@planebroker.com",
							'from_name'         => "Plane Broker"
							);
							//echo view('email/email_cc_reminder', $data); exit;
				$emailModel = new EmailModel();
				$emailModel->send_email($data);
				if($user->email_cc_first == 0){
					$this->usersModel->update_user_cc_reminder($user->id,$field = 'email_cc_first');
				}
				if($user->email_cc_first == 1 && $user->email_cc_sec == 0){
					$this->usersModel->update_user_cc_reminder($user->id,$field = 'email_cc_sec');
				}
			}
		}		
	}
	public function sendRecoveryEmail(){
		$users = $this->usersModel->get_canceled_users();
		$endDate = date('Y-m-d', strtotime("-1 week")).' 23:59:00';
		$startDate = date('Y-m-d').' 00:00:00';
		//echo "<pre>";print_r($users);exit;
		$this->UsersModel = new UsersModel();
		if(!empty($users)){
			foreach($users as $user){
				
				$recent_searches = $this->UsersModel->db->query('SELECT count(*) as zipcode_count FROM `website_stats` where  location_id = '.$user->location_id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->zipcode_count;
				$recent_connections = $this->UsersModel->db->query('SELECT count(*) as call_count FROM `website_stats` where call_count = 1 AND user_id = '.$user->id.' AND created_at <= "'.$endDate.'" AND created_at >= "'.$startDate.'"')->getRow()->call_count;
				
				$subject = 'Reactivate Your Subscription';
				$data = array(
					'subject'           => $subject,
					'template_path' 	=> "email/email_recovery",
					'to'                => $user->email,
					'from_email'        => "lara@planebroker.com",
					'from_name'         => "Plane Broker",
					'recent_searches' 	=>$recent_searches,
					'recent_connections' =>$recent_connections,							
				);
				//echo view('email/email_recovery', $data); exit;
				$emailModel = new EmailModel();
				$emailModel->send_email($data);
			}
		}		
	}
	
	public function send_add_first_listing_email(){
		//1hr after registration
		$get_email_content = $this->db->table('email_templates')->where('email_title', 'add_first_listing')->get()->getRowArray();
		$emailContent = $get_email_content['content'];
		
		$users = $this->usersModel->get_first_listing_users();
		//echo "<pre>";print_r($users);exit;
		if(!empty($users)){
			foreach($users as $user){
				if($user->email_cc_first == 0){
					$this->usersModel->update_user_cc_reminder($user->id,$field = 'email_cc_first');
				}
		
				$placeholders = [
					'{user_name}' => $user->fullname,
					'{login_url}' => base_url('login'),
				];

				foreach ($placeholders as $key => $value) {
					$emailContent = str_replace($key, $value, $emailContent);
				}
				$emailModel = new EmailModel();
				$data_customer = array(
					'subject' => $get_email_content['name'],
					'content' => $emailContent,
					'to' => $user->email,
					'template_path' => "email/email_content",
				);
				$emailModel->send_email($data_customer);
			}
		}
	}
	public function send_favorite_still_available_email(){
		//2 weeks once
		$get_email_content = $this->db->table('email_templates')->where('email_title', 'favorite_still_available')->get()->getRowArray();
		$emailContent = $get_email_content['content'];
		
		$users = $this->usersModel->get_favorite_still_available_users();
		if(!empty($users)){
			foreach($users as $user){
		
				$placeholders = [
					'{user_name}' => $user->fullname,
					'{login_url}' => base_url('login'),
				];

				foreach ($placeholders as $key => $value) {
					$emailContent = str_replace($key, $value, $emailContent);
				}
				$emailModel = new EmailModel();
				$data_customer = array(
					'subject' => $get_email_content['name'],
					'content' => $emailContent,
					'to' => $user->email,
					'template_path' => "email/email_content",
				);
				$emailModel->send_email($data_customer);
			}
		}
	}
	public function send_for_inactive_user_email(){
		//inactive for a month 
		$get_email_content = $this->db->table('email_templates')->where('email_title', 'favorite_still_available')->get()->getRowArray();
		$emailContent = $get_email_content['content'];
		
		$users = $this->usersModel->send_for_inactive_user_email();
		if(!empty($users)){
			foreach($users as $user){
		
				$placeholders = [
					'{user_name}' => $user->fullname,
					'{login_url}' => base_url('login'),
				];

				foreach ($placeholders as $key => $value) {
					$emailContent = str_replace($key, $value, $emailContent);
				}
				$emailModel = new EmailModel();
				$data_customer = array(
					'subject' => $get_email_content['name'],
					'content' => $emailContent,
					'to' => $user->email,
					'template_path' => "email/email_content",
				);
				$emailModel->send_email($data_customer);
			}
		}
		
	}
}
