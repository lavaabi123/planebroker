<?php

namespace App\Models;

require APPPATH . "ThirdParty/swiftmailer/vendor/autoload.php";

use CodeIgniter\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MAILER_Exception;


class EmailModel extends Model
{

    protected $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
    }

    //send text email
    public function send_test_email($email, $subject, $message)
    {
        if (!empty($email)) {
            $data = array(
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );

            return $this->send_email($data);
        }
    }

    //send email activation
    public function send_email_activation($user_id, $sess = 'admin')
    {
        $userModel = new UsersModel();
        $user = $userModel->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_unique_id();
                $data = array(
                    'token' => $token
                );
                //$userModel->builder()->where('id', $user->id)->update($data);
            }

            $data = array(
                'subject' => trans("Welcome to Plane Broker"),
                'to' => $user->email,
                'template_path' => "email/email_activation",
                'token' => $token
            );

            if ($sess == 'user') {
                $data['template_path'] = 'email/email_activation';
            }
            $this->send_email($data);
			//To Admin
			$data_admin = array(
                'subject' => "New Plane Broker User Registered",
                'from_email' => get_general_settings()->admin_email,
                'to' => get_general_settings()->mail_reply_to,
				'message_text' => '<p style="color: #000000; font-size:11px; margin-bottom: 5px;">New Plane Broker Registered. Waiting for email verification.<br><br>Name: '.$user->fullname.'<br>Email: '.$user->email.'</p>',
                'template_path' => "email/admin/new_user",
                'token' => $token
            );
			$this->send_email($data_admin);
        }
    }

    //send email activation confirmed
    public function send_email_activation_confirmed($user_id, $sess = 'admin')
    {
        $userModel = new UsersModel();
        $user = $userModel->get_user($user_id);
        if (!empty($user)) {

            $data = array(
                'subject' => trans("Welcome to Plane Broker"),
                'to' => $user->email,
                'first_name' => $user->first_name,
                'business_name' => $user->business_name,
                'id' => $user->id,
				'fullname' => $user->fullname,
                'template_path' => "email/email_confirmation",
            );

            if ($sess == 'user') {
                $data['template_path'] = 'email/email_confirmation';
            }

            $this->send_email($data);
			
			//To Admin
			$data_admin = array(
                'subject' => "New Plane Broker User Registered",
                'from_email' => get_general_settings()->admin_email,
                'to' => get_general_settings()->mail_reply_to,
				'message_text' => '<p style="color: #000000; font-size:11px; margin-bottom: 5px;">Below user registered successfully.<br><br>Name: '.$user->fullname.'<br>Email: '.$user->email.'</p>',
                'template_path' => "email/admin/new_user"
            );
			$this->send_email($data_admin);
        }
    }
	
    //send email contact message
    public function send_email_contact_message($message_name, $message_email, $message_text)
    {
        $data = array(
            'subject' => trans("contact_message"),
            'to' => get_general_settings()->mail_contact,
            'template_path' => "email/email_contact_message",
            'message_name' => $message_name,
            'message_email' => $message_email,
            'message_text' => $message_text
        );
        $this->send_email($data);
		
		//To Admin
		$data_admin = array(
			'subject' => "Customer Contacted Plane Broker",
			'from_email' => get_general_settings()->admin_email,
			'to' => get_general_settings()->mail_reply_to,
			'message_text' => $message_text,
			'template_path' => "email/admin/new_user"
		);
		$this->send_email($data_admin);
    }

    //send email newsletter
    public function send_email_newsletter($subscriber, $subject, $message)
    {
        if (!empty($subscriber)) {
            if (empty($subscriber->token)) {
                $this->newsletter_model->update_subscriber_token($subscriber->email);
                $subscriber = $this->newsletter_model->get_subscriber($subscriber->email);
            }
            $data = array(
                'subject' => $subject,
                'message' => $message,
                'to' => $subscriber->email,
                'template_path' => "email/email_newsletter",
                'subscriber' => $subscriber,
            );
            return $this->send_email($data);
        }
    }

    //send email reset password
    public function send_email_reset_password($user_id)
    {
        $userModel = new UsersModel();
        $user = $userModel->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_unique_id();
                $data = array(
                    'token' => $token
                );
                //$userModel->builder()->where('id', $user->id)->update($data);
            }

            $data = array(
                'subject' => trans("reset_password"),
                'to' => $user->email,
                'template_path' => "email/email_reset_password",
                'token' => $token
            );



            $this->send_email($data);
        }
    }

    //send email reset password to provider
    public function send_email_reset_password_provider($user_id)
    {
        $userModel = new UsersModel();
        $user = $userModel->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_unique_id();
                $data = array(
                    'token' => $token
                );
               //$userModel->builder()->where('id', $user->id)->update($data);
            }

            $data = array(
                'subject' => trans("reset_password"),
                'to' => $user->email,
                'template_path' => "email/email_reset_password_provider",
                'token' => $token
            );



            $this->send_email($data);
        }
    }



    // Proccess

    //send email
    public function send_email($data)
    {
        $protocol = get_general_settings()->mail_protocol;
        if ($protocol != "smtp" && $protocol != "mail") {
            $protocol = "smtp";
        }
        $encryption = get_general_settings()->mail_encryption;
        if ($encryption != "tls" && $encryption != "ssl") {
            $encryption = "tls";
        }
        if (get_general_settings()->mail_library == "swift") {
            return $this->send_email_swift($encryption, $data);
        } else {
            return $this->send_email_php_mailer($protocol, $encryption, $data);
        }
    }

    //send email with swift mailer
    public function send_email_swift($encryption, $data)
    {
        try {
            // Create the Transport
            $transport = (new \Swift_SmtpTransport(get_general_settings()->mail_host, get_general_settings()->mail_port, $encryption))
                ->setUsername(get_general_settings()->mail_username)
                ->setPassword(get_general_settings()->mail_password);

            // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);

            // Create a message
            $message = (new \Swift_Message(get_general_settings()->mail_title))
                ->setFrom(array(get_general_settings()->mail_reply_to => get_general_settings()->mail_title))
                ->setTo([$data['to'] => ''])
                ->setSubject($data['subject'])
                ->setBody(view($data['template_path'], $data), 'text/html');

            //Send the message
            $result = $mailer->send($message);
            if ($result) {
                return true;
            }
        } catch (\Swift_TransportException $Ste) {
            $this->session->setFlashData('errors_form', $Ste->getMessage());
            return false;
        } catch (\Swift_RfcComplianceException $Ste) {
            $this->session->setFlashData('errors_form', $Ste->getMessage());
            return false;
        }
    }

    //send email with php mailer
    public function send_email_php_mailer($protocol, $encryption, $data)
    {
        $to = (is_array($data['to'])) ? implode(',',$data['to']) : $data['to'];
        $ccEmail = $data['cc'] ?? ''; 
        $from = $data['from_email'] ?? get_general_settings()->mail_reply_to; 
        $fromName = $data['from_name'] ?? get_general_settings()->mail_title; 
         
        $subject    = $data['subject']; 
        $htmlContent = $data['mail_body_content'] ?? view($data['template_path'], $data);
        // Set content-type header for sending HTML email 
        $headers = "MIME-Version: 1.0" . "\r\n"; 
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
         
        // Additional headers 
        $headers .= 'From: '.$fromName.' <' .$from. ">\r\n";
        if(!empty($ccEmail)){
            $headers .= 'Cc: ' . $ccEmail . "\r\n"; // Add CC recipient here
        }

        $headers .= 'X-Mailer: PHP/' . phpversion(); 
		if(!empty($data['output'])){
			$html = $htmlContent;
			$path = $data['output'];
			$pdfname='report-'.date("m-d-Y").'.pdf';
			$mail = new PHPMailer(true);
			$mail->isSMTP();
			$mail->Host="smtp.gmail.com";
			$mail->Port=587;
			$mail->SMTPSecure="tls";
			$mail->SMTPAuth=true;
			$mail->Username="testphpdev6@gmail.com";
			$mail->Password="ukfv jfvq uhci jzjz";
			$mail->SetFrom($from,$fromName);
			$mail->addAddress($to);
			$mail->IsHTML(true);
			$mail->Subject=$subject;
			$mail->Body=$html;
			$mail->addAttachment($path, $pdfname);
			$mail->SMTPOptions=array('ssl'=>array(
				'verify_peer'=>false,
				'verify_peer_name'=>false,
				'allow_self_signed'=>false
				));

			if ($mail->send()) {
				return true;
			} else {
				$this->session->setFlashData('errors_form', 'Email sending failed');
				return false;
			}
		}else{		
				 
				// Send email 
				if(mail($to, $subject, $htmlContent, $headers)){ 
					return true;
				}else{ 
				   $this->session->setFlashData('errors_form', 'Email sending failed');
				   return false;
				}
		}
        return false;
        
        /*$mail = new PHPMailer(true);
        try {
            if ($protocol == "mail") {
                $mail->isMail();
                $mail->setFrom(get_general_settings()->mail_reply_to, get_general_settings()->mail_title);
                $mail->addAddress($data['to']);
                $mail->isHTML(true);
                $mail->Subject = $data['subject'];
                $mail->Body = view($data['template_path'], $data);
            } else {
                $mail->isSMTP();
                $mail->Host = get_general_settings()->mail_host;
                $mail->SMTPAuth = true;
                $mail->Username = get_general_settings()->mail_username;
                $mail->Password = get_general_settings()->mail_password;
                $mail->SMTPSecure = $encryption;
                $mail->CharSet = 'UTF-8';
                $mail->Port = get_general_settings()->mail_port;
                $mail->setFrom(get_general_settings()->mail_reply_to, get_general_settings()->mail_title);
                $mail->addAddress($data['to']);
                $mail->isHTML(true);
                // $mail->SMTPDebug  = 1;
                $mail->Subject = $data['subject'];
                $mail->Body = view($data['template_path'], $data);
            }
            $mail->send();
            return true;
        } catch (MAILER_Exception $e) {
            if ($e) {
                $this->session->setFlashData('errors_form', $mail->ErrorInfo);
            }

            return false;
        }
        return false;*/
    }
}
