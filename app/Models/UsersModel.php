<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Locations\CityModel;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = false;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    public $session; 
    public $request;

    public function __construct()
    {
        parent::__construct();

        $this->session = session();
        $this->db = db_connect();
        $this->request = \Config\Services::request();
        $this->db->query("SET sql_mode = ''");
    }

    //input values
    public function input_values()
    {
        $data = array(
            'username' => strtolower(remove_special_characters(trim($this->request->getVar('username', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? ''))),
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );
        return $data;
    }

    //add user
    public function add_user()
    {
        $data = $this->input_values();

        $data['first_name'] = $this->request->getVar('first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['last_name'] = $this->request->getVar('last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['fullname'] = $this->request->getVar('first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS).' '.$this->request->getVar('last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['email'] = $this->request->getVar('email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['mobile_no'] = $this->request->getVar('mobile_no', FILTER_SANITIZE_FULL_SPECIAL_CHARS);	
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['user_type'] = "registered";
        $data['role'] = 2;
        $data['status'] = 1;
        $data['email_status'] = 1;
        $data['user_level'] = !empty( $this->request->getVar('user_level') ) ? 1 : 0 ;
        $data['token'] = generate_unique_id();
        $data['created_at'] = date('Y-m-d H:i:s');        
        $id = $this->protect(false)->insert($data);
        
        return $id;
    }
    //add user
    public function add_listing()
    {

        $data = $this->input_values();

        $data['first_name'] = $this->request->getVar('first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['last_name'] = $this->request->getVar('last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['fullname'] = $this->request->getVar('first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS).' '.$this->request->getVar('last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['email'] = $this->request->getVar('email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['category_id'] = $this->request->getVar('category_id');
        $data['sub_category_id'] = $this->request->getVar('sub_category_id');
        $data['business_name'] = !empty($this->request->getVar('business_name')) ? $this->request->getVar('business_name') : '';
		$data['clean_url'] = '';
		
		$data['address'] = !empty($this->request->getVar('address')) ? $this->request->getVar('address') : '';
		$data['question1'] = !empty($this->request->getVar('question1')) ? $this->request->getVar('question1') : '';	
		$data['question2'] = !empty($this->request->getVar('question2')) ? $this->request->getVar('question2') : '';
		$data['facebook_link'] = !empty($this->request->getVar('facebook_link')) ? $this->request->getVar('facebook_link') : '';
		$data['insta_link'] = !empty($this->request->getVar('insta_link')) ? $this->request->getVar('insta_link') : '';	
		$data['twitter_link'] = !empty($this->request->getVar('twitter_link')) ? $this->request->getVar('twitter_link') : '';
		$data['miles'] = !empty($this->request->getVar('miles')) ? $this->request->getVar('miles') : '15';
		$data['suite'] = !empty($this->request->getVar('suite')) ? $this->request->getVar('suite') : '';
		$data['city'] = !empty($this->request->getVar('locality')) ? $this->request->getVar('locality') : '';
		$data['state'] = !empty($this->request->getVar('state')) ? $this->request->getVar('state') : '';
		$data['zipcode'] = !empty($this->request->getVar('postcode')) ? $this->request->getVar('postcode') : '';
		$data['city_lat'] = !empty($this->request->getVar('city_lat')) ? $this->request->getVar('city_lat') : '';
		$data['city_lng'] = !empty($this->request->getVar('city_lng')) ? $this->request->getVar('city_lng') : '';
		
        $data['location_id'] = $this->request->getVar('location_id');
        $data['mobile_no'] = $this->request->getVar('mobile_no', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['referredby'] = $this->request->getVar('referredby');
        $data['gender'] = $this->request->getVar('gender');
        $data['licensenumber'] = $this->request->getVar('licensenumber');
        $data['experience'] = $this->request->getVar('experience');
        $data['website'] = $this->request->getVar('website');
        $data['offering'] = json_encode($this->request->getVar('offering'));
        $data['clientele'] = json_encode($this->request->getVar('clientele'));
        $data['categories_skills'] = json_encode($this->request->getVar('categories_skills'));
        $data['about_me'] = !empty($this->request->getVar('about_me')) ? $this->request->getVar('about_me') : '';

        $data['plan_id'] = $this->request->getVar('plan_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		
		if($this->request->getVar('plan_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) >= 2){
			$data['admin_plan_update'] = 1;
			$data['admin_plan_end_date'] = !empty($this->request->getVar('admin_plan_end_date')) ? date("Y-m-d",strtotime($this->request->getVar('admin_plan_end_date'))) : NULL;
		}
			

        //secure password
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['user_type'] = "registered";
        //$data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['role'] = $this->request->getVar('role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['status'] = 1;
        $data['email_status'] = 1;
        $data['token'] = generate_unique_id();
        //$data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');

		$data['dynamic_fields'] = ($this->request->getVar('dynamic_fields') != null && count($this->request->getVar('dynamic_fields')) > 0) ? json_encode($this->request->getVar('dynamic_fields')) : '';
        
        $id = $this->protect(false)->insert($data);
        //add user rates if any
        if (!empty($this->request->getVar('price'))) {
            foreach($this->request->getVar('price') as $i => $row){
                $this->db->query("INSERT INTO user_rates SET user_id='" . $id . "', price='" . str_replace('$', '', ($this->request->getVar('price')[$i])) . "', duration_amount='" . ($this->request->getVar('duration_amount')[$i]) . "', duration='" . ($this->request->getVar('duration')[$i]) . "'");
            }
        }
        
        /* HOURS OF OPERATION */
        for ($i = 1; $i <= 7; $i++) {
            if (!empty($this->request->getVar('hoo_' . $i . '_a'))) {
                $this->db->query("INSERT INTO hours_of_operation SET user_id='" . $id . "', closed_all_day='1', weekday='$i'");
            } else {
                if(!empty($this->request->getVar('hoo_' . $i . '_o')) && !empty($this->request->getVar('hoo_' . $i . '_c'))){
                    $this->db->query("INSERT INTO hours_of_operation SET user_id='" . $id . "', opens_at='" . date('H:i',strtotime(($this->request->getVar('hoo_' . $i . '_o')))) . "', closes_at='" . date('H:i',strtotime(($this->request->getVar('hoo_' . $i . '_c')))) . "', weekday='$i'");
                }
            }
        }

        return $id;
    }

    //edit user
    public function edit_user($id)
    {
        $user = $this->get_user($id);
        if (!empty($user)) {
            $data = array(
                'first_name' => $this->request->getVar('first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'last_name' => $this->request->getVar('last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'fullname' => $this->request->getVar('first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS).' '.$this->request->getVar('last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),         
                'email' => $this->request->getVar('email', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'password' => empty($this->request->getVar('password')) ? $user->password : password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
				'user_level' => !empty( $this->request->getVar('user_level') ) ? 1 : 0,				
            );			
            return $this->protect(false)->update($user->id, $data);
        }
    }
    //edit user
    public function edit_listing($id)
    {
        $user = $this->get_user($id);
        if (!empty($user)) {
			
			
			
            $data = array(
                'first_name' => $this->request->getVar('first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'last_name' => $this->request->getVar('last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'fullname' => $this->request->getVar('first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS).' '.$this->request->getVar('last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                //'username' => strtolower(remove_special_characters(trim($this->request->getVar('username') ?? ''))),                
                'email' => $this->request->getVar('email', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'password' => empty($this->request->getVar('password')) ? $user->password : password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                'role' => $this->request->getVar('role', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'plan_id' => $this->request->getVar('plan_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS),				
				'category_id' => $this->request->getVar('category_id'),				
				'sub_category_id' => $this->request->getVar('sub_category_id')
                /*'slug' => $this->request->getVar('slug'),
                'about_me' => $this->request->getVar('about_me'),
                'mobile_no' => $this->request->getVar('mobile_no', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'country_id' => $this->request->getVar('country_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'state_id' => $this->request->getVar('state_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'city_id' => $this->request->getVar('city_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'address' => $this->request->getVar('address'),
                'zip_code' => $this->request->getVar('zip_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS)*/
            );
			
			if($this->request->getVar('plan_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) >= 2 && $this->request->getVar('old_plan_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) == 1){
				$data['admin_plan_update'] = 1;
				$data['admin_plan_end_date'] = ($this->request->getVar('admin_plan_end_date') != NULL) ? date("Y-m-d",strtotime($this->request->getVar('admin_plan_end_date'))) : NULL;
			}else if($this->request->getVar('plan_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) >= 2 && $this->request->getVar('old_plan_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) >= 2){
				$data['admin_plan_end_date'] = ($this->request->getVar('admin_plan_end_date') != NULL) ? date("Y-m-d",strtotime($this->request->getVar('admin_plan_end_date'))) : NULL;
			}else if($this->request->getVar('plan_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) == 1 && $this->request->getVar('old_plan_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) == 1){
				$data['admin_plan_update'] = NULL;
				$data['admin_plan_end_date'] = NULL;
			}else if($this->request->getVar('plan_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) == 1 && $this->request->getVar('old_plan_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) >= 2){
				$data['admin_plan_update'] = 0;
				$data['admin_plan_end_date'] = NULL;
			}
			
		$data['dynamic_fields'] = ($this->request->getVar('dynamic_fields') != null && count($this->request->getVar('dynamic_fields')) > 0) ? json_encode($this->request->getVar('dynamic_fields')) : '';
			
//echo "<pre>";print_r($data);exit;
            /*$_image_id = $this->request->getVar('newimage_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!empty($_image_id)) {
                $imageModel = new ImagesModel();
                $image =  $imageModel->get_image($_image_id);
                if (!empty($image)) {
                    $uploadModel = new UploadModel();
                    $data["avatar"] = $uploadModel->avatar_upload($user->id, FCPATH . $image->image_default);
                    //delete old
                     if($user->avatar){
                        delete_file_from_server($user->avatar);
                    }   
                }
            }*/

            return $this->protect(false)->update($user->id, $data);
        }
    }

    //ban user
    public function ban_user($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);
        if (!empty($user)) {

            $data = array(
                'status' => 0
            );
            return $this->protect(false)->update($user->id, $data);
        } else {
            return false;
        }
    }

    //remove user ban
    public function remove_user_ban($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);

        if (!empty($user)) {

            $data = array(
                'status' => 1
            );

            return $this->protect(false)->update($user->id, $data);
        } else {
            return false;
        }
    }

    //change user role
    public function change_user_role($id, $role)
    {
        $id = clean_number($id);
        $data = array(
            'role' => $role
        );

        return $this->protect(false)->update($id, $data);
    }



    //login
    public function login()
    {
        $data = $this->input_values();
        $user = $this->get_user_by_email($data['email']);

        if (!empty($user)) {
            //check password
            if (!password_verify($data['password'], $user->password)) {
                $this->session->setFlashData('errors_form', 'Wrong password!');
                return false;
            }

            if ($user->status == 0) {
                $this->session->setFlashData('errors_form', 'Banned');
                return false;
            }
			
			if($user->role == 1){
			
				//set user data
				$user_data = array(
					'admin_sess_user_id' => $user->id,
					'admin_sess_user_email' => $user->email,
					'admin_sess_user_role' => $user->role,
					'admin_sess_logged_in' => true,
					'admin_sess_user_ps' => md5($user->password),
					'admin_sess_app_key' => config('app')->AppKey,
					'admin_sess_email_status' => $user->email_status,
				);
				$this->session->set($user_data);
			
			}else{
			
				//set user data
				$user_data = array(
					'vr_sess_user_id' => $user->id,
					'vr_sess_user_email' => $user->email,
					'vr_sess_user_role' => $user->role,
					'vr_sess_logged_in' => true,
					'vr_sess_user_ps' => md5($user->password),
					'vr_sess_app_key' => config('app')->AppKey,
					'vr_sess_email_status' => $user->email_status,
				);
				$this->session->set($user_data);
				
			}
			
            return true;
        } else {
            $this->session->setFlashData('errors_form', 'Wrong username or password!');
            return false;
        }
    }

    //login with google
    public function login_with_google($g_user)
    {
        if (!empty($g_user)) {
            $user = $this->get_user_by_email($g_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($g_user->name)) {
                    $g_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($g_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'google_id' => $g_user->id,
                    'email' => $g_user->email,
                    'email_status' => 1,
                    'token' => generate_unique_id(),
                    'username' => $username,
                    'slug' => $slug,
                    'avatar' => "",
                    'user_type' => "google",
                    'status' => 1,
                    'role' => 1,
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                //download avatar
                $avatar = $g_user->avatar;
                if (!empty($avatar)) {
                    $uploadModel = new UploadModel();
                    $save_to = WRITEPATH . "uploads/tmp/avatar-" . uniqid() . ".jpg";
                    @copy($avatar, $save_to);
                    if (!empty($save_to) && file_exists($save_to)) {
                        $data["avatar"] = $uploadModel->avatar_upload(0, $save_to);
                    }
                    @unlink($save_to);
                }
                if (!empty($data['email'])) {
                    $this->protect(false)->insert($data);
                    $user = $this->get_user_by_email($g_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
                $this->login_direct($user);
            }
        }
    }

    //login with github
    public function login_with_github($g_user)
    {

        if (!empty($g_user)) {
            $user = $this->get_user_by_email($g_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($g_user->name)) {
                    $g_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($g_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'github_id' => $g_user->id,
                    'email' => $g_user->email,
                    'email_status' => 1,
                    'token' => generate_unique_id(),
                    'username' => $username,
                    'slug' => $slug,
                    'avatar' => "",
                    'user_type' => "github",
                    'status' => 1,
                    'role' => 1,
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                //download avatar
                $avatar = $g_user->avatar;
                if (!empty($avatar)) {
                    $uploadModel = new UploadModel();
                    $save_to = WRITEPATH . "uploads/tmp/avatar-" . uniqid() . ".jpg";
                    @copy($avatar, $save_to);
                    if (!empty($save_to) && file_exists($save_to)) {
                        $data["avatar"] = $uploadModel->avatar_upload(0, $save_to);
                    }
                    @unlink($save_to);
                }
                if (!empty($data['email'])) {
                    $this->protect(false)->insert($data);
                    $user = $this->get_user_by_email($g_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
                $this->login_direct($user);
            }
        }
    }

    //login direct
    public function login_direct($user)
    {
		if($user->role == 1){			
			//set user data
			$user_data = array(
				'admin_sess_user_id' => $user->id,
				'admin_sess_user_email' => $user->email,
				'admin_sess_user_role' => $user->role,
				'admin_sess_logged_in' => true,
				'admin_sess_user_ps' => md5($user->password),
				'admin_sess_app_key' => config('app')->AppKey,
				'admin_sess_email_status' => $user->email_status,
			);
			
		}else{				
			//set user data
			$user_data = array(
				'vr_sess_user_id' => $user->id,
				'vr_sess_user_email' => $user->email,
				'vr_sess_user_role' => $user->role,
				'vr_sess_logged_in' => true,
				'vr_sess_user_ps' => md5($user->password),
				'vr_sess_app_key' => config('app')->AppKey,
				'vr_sess_email_status' => $user->email_status,
			);
		}

        $this->session->set($user_data);
    }

    //register
    public function register()
    {
        $data = $this->input_values();
        $data['role'] = $this->request->getVar('role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);        
        $data['fullname'] = $this->request->getVar('first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS).' '.$this->request->getVar('last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$data['first_name'] = $this->request->getVar('first_name');
		$data['last_name'] = $this->request->getVar('last_name');
		$data['category_id'] = '';//$this->request->getVar('category_id');
		
        $data['business_name'] = !empty($this->request->getVar('business_name')) ? $this->request->getVar('business_name') : '';
		$data['clean_url'] = '';
		
		$data['address'] = !empty($this->request->getVar('address')) ? $this->request->getVar('address') : '';	
		$data['question1'] = !empty($this->request->getVar('question1')) ? $this->request->getVar('question1') : '';	
		$data['question2'] = !empty($this->request->getVar('question2')) ? $this->request->getVar('question2') : '';	
		$data['facebook_link'] = !empty($this->request->getVar('facebook_link')) ? $this->request->getVar('facebook_link') : '';
		$data['insta_link'] = !empty($this->request->getVar('insta_link')) ? $this->request->getVar('insta_link') : '';	
		$data['twitter_link'] = !empty($this->request->getVar('twitter_link')) ? $this->request->getVar('twitter_link') : '';
		$data['register_plan'] = !empty($this->request->getVar('register_plan')) ? $this->request->getVar('register_plan') : '2';
		$data['miles'] = !empty($this->request->getVar('miles')) ? $this->request->getVar('miles') : '15';
		$data['suite'] = !empty($this->request->getVar('suite')) ? $this->request->getVar('suite') : '';
		$data['city'] = !empty($this->request->getVar('locality')) ? $this->request->getVar('locality') : '';
		$data['state'] = !empty($this->request->getVar('state')) ? $this->request->getVar('state') : '';
		$data['zipcode'] = !empty($this->request->getVar('postcode')) ? $this->request->getVar('postcode') : '';
		$data['city_lat'] = !empty($this->request->getVar('city_lat')) ? $this->request->getVar('city_lat') : '';
		$data['city_lng'] = !empty($this->request->getVar('city_lng')) ? $this->request->getVar('city_lng') : '';
		
		$data['location_id'] = '';//$this->request->getVar('location_id');
		$data['mobile_no'] = $this->request->getVar('mobile_no');
		$data['referredby'] = '';//$this->request->getVar('referredby');
		$data['gender'] = '';//$this->request->getVar('gender');
		$data['licensenumber'] = '';//$this->request->getVar('licensenumber');
		$data['experience'] = '';//$this->request->getVar('experience');
		$data['offering'] = '';//json_encode($this->request->getVar('offering'));
		$data['clientele'] = '';//json_encode($this->request->getVar('clientele'));
		$data['categories_skills'] = '';//json_encode($this->request->getVar('categories_skills'));
		
        //secure password
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['status'] = 1;
        $data['token'] = generate_unique_id();
        $data['role'] = $data['role'] ? $data['role'] : '2';
        $data['email_status'] = 1;

        $data['last_seen'] = date('Y-m-d H:i:s');
		
        $save_id = $this->protect(false)->insert($data);
		
        if ($save_id) {
			
			$get_email_content = $this->db->table('email_templates')->where('email_title', 'welcome_email')->get()->getRowArray();
			$emailContent = $get_email_content['content'];
			$placeholders = [
				'{user_name}' => $data['fullname'],
				'{login_url}'     => base_url('login'),
				'{site_url}'     => base_url(),
			];

			foreach ($placeholders as $key => $value) {
				$emailContent = str_replace($key, $value, $emailContent);
			}
			$emailModel = new EmailModel();
			$data_email = array(
				'subject' => $get_email_content['name'],
				'content' => $emailContent,
				'to' => $data['email'],
				'template_path' => "email/email_content",
			);
			$emailModel->send_email($data_email);

            return $this->get_user($save_id);
        } else {
            return false;
        }
    }
	
	
    //add
    public function add_product()
    {
        $data = array();
		$data['user_id'] = !empty($_POST['user_id']) ? $_POST['user_id'] : $this->session->get('vr_sess_user_id');
		$data['added_by'] = !empty($_POST['added_by']) ? $_POST['added_by'] :0;
		$data['category_id'] = $this->request->getVar('category_id');
		$data['sub_category_id'] = $this->request->getVar('sub_category_id');
		$id = $this->request->getVar('product_id');
		
        $data['business_name'] = !empty($this->request->getVar('business_name')) ? $this->request->getVar('business_name') : '';
		$data['email'] = !empty($this->request->getVar('email')) ? $this->request->getVar('email') : '';
		$data['clean_url'] = '';
				
		$data['address'] = !empty($this->request->getVar('address')) ? $this->request->getVar('address') : '';	
		$data['suite'] = !empty($this->request->getVar('suite')) ? $this->request->getVar('suite') : '';
		$data['city'] = !empty($this->request->getVar('locality')) ? $this->request->getVar('locality') : '';
		$data['state'] = !empty($this->request->getVar('state')) ? $this->request->getVar('state') : '';
		$data['zipcode'] = !empty($this->request->getVar('postcode')) ? $this->request->getVar('postcode') : '';
		$data['phone'] = !empty($this->request->getVar('phone')) ? $this->request->getVar('phone') : '';
		$data['plan_id'] = !empty($this->request->getVar('plan_id')) ? $this->request->getVar('plan_id') : '';
        $data['status'] = !empty($this->request->getVar('status')) ? $this->request->getVar('status') : 0;
        $data['token'] = generate_unique_id();
		
		$uploadedFiles = array();
		$upload_path = str_replace('writable/' , '', FCPATH .'uploads/userimages/'.$data['user_id'].'/');

		// Create the folder if it doesn't exist
		if (!is_dir($upload_path)) {
			//mkdir($upload_path, 0777, true);
		}
		//echo "<pre>";print_r($_POST['dynamic_fields']);print_r($_FILES['dynamic_fields']);exit;
		/*
		if (isset($_FILES['dynamic_fields']['name']) && is_array($_FILES['dynamic_fields']['name'])) {
			foreach ($_FILES['dynamic_fields']['name'] as $key => $filename) {
				if ($_FILES['dynamic_fields']['error'][$key] === 0) {
					$tmp_name = $_FILES['dynamic_fields']['tmp_name'][$key];
					$filename = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $filename);
					$destination = $upload_path . basename($filename);

					if (move_uploaded_file($tmp_name, $destination)) {
						//echo "Uploaded: $filename $key<br>";
						$uploadedFiles[$key] = $filename;
					} else {
						//echo "Failed to upload: $filename<br>";
					}
				} else {
					//echo "Upload error on file key $key<br>";
					if(!empty($_POST['dynamic_fields_old'][$key])){
						$uploadedFiles[$key] = $_POST['dynamic_fields_old'][$key];
					}
				}
			}
		}
		*/
		$uploadedFiles = [];
		$filesForDB = []; // To store comma-separated values for DB insert
		$dynamic_titles = $this->request->getVar('dynamic_fields_titles') ?? [];
		if (isset($_FILES['dynamic_fields']['name']) && is_array($_FILES['dynamic_fields']['name'])) {
			foreach ($_FILES['dynamic_fields']['name'] as $groupKey => $fileGroup) {
				foreach ($fileGroup as $fileIndex => $filename) {
					$title = $dynamic_titles[$groupKey][$fileIndex] ?? ''; // Get title for this file
					if (!empty($filename) && $_FILES['dynamic_fields']['error'][$groupKey][$fileIndex] === 0) {
						$tmp_name = $_FILES['dynamic_fields']['tmp_name'][$groupKey][$fileIndex];
						$safeFilename = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $filename);
						$destination = $upload_path . basename($safeFilename);

						if (move_uploaded_file($tmp_name, $destination)) {
							$uploadedFiles[$groupKey][$fileIndex]['field_value'] = $safeFilename;
							$uploadedFiles[$groupKey][$fileIndex]['file_field_title'] = $title;
						}
					}
					
				}
			}
		}
		$uploadedFiles_old = [];
		if (!empty($_POST['dynamic_fields_old'])) {
			foreach ($_POST['dynamic_fields_old'] as $groupKey => $fileGroup) {
				if(!empty($_POST['dynamic_fields_old'][$groupKey]) && is_array($_POST['dynamic_fields_old'][$groupKey])){
					foreach ($_POST['dynamic_fields_old'][$groupKey] as $fileIndexs => $filenames) {
						$uploadedFiles_old[$groupKey][$fileIndexs]['field_value'] = $_POST['dynamic_fields_old'][$groupKey][$fileIndexs];
						$uploadedFiles_old[$groupKey][$fileIndexs]['file_field_title'] = $_POST['dynamic_fields_titles_old'][$groupKey][$fileIndexs];
					}
				}else{						
					if (!empty($_POST['dynamic_fields_old'][$groupKey][$fileIndex])) {
						$uploadedFiles_old[$groupKey][$fileIndex]['field_value'] = $_POST['dynamic_fields_old'][$groupKey][$fileIndex];
						$uploadedFiles_old[$groupKey][$fileIndex]['file_field_title'] = $_POST['dynamic_fields_titles_old'][$groupKey][$fileIndex];
					}
				}
			}
		}
		
		//echo "<pre>";
		//print_r($uploadedFiles);
		//print_r($uploadedFiles_old);
		$mergedFiles = $uploadedFiles_old; // Start with old files

		foreach ($uploadedFiles as $groupKey => $fileGroup) {
			foreach ($fileGroup as $newFile) {
				$alreadyExists = false;
				if (!empty($mergedFiles[$groupKey])) {
					foreach ($mergedFiles[$groupKey] as $existingFile) {
						if ($existingFile['field_value'] === $newFile['field_value']) {
							$alreadyExists = true;
							break;
						}
					}
				}

				if (!$alreadyExists) {
					$mergedFiles[$groupKey][] = $newFile;
				}
			}
		}

		//print_r($mergedFiles);
		
		$d_fields_array = ($this->request->getVar('dynamic_fields') != null && count($this->request->getVar('dynamic_fields')) > 0) ? $this->request->getVar('dynamic_fields') : array();
		$d_fields_array = $d_fields_array+$mergedFiles;	
		$data['dynamic_fields'] = json_encode($d_fields_array);
		//print_r($d_fields_array);
		//exit;
		if(!empty($id)){
			//send email if product is sold
			if(!empty($d_fields_array[51]) && $d_fields_array[51] == 'Sold' ){
				$productModel = new ProductModel();
				$p_detail = $productModel->get_product_detail(' AND p.id='.$id);
				$get_email_content = $this->db->table('email_templates')->where('email_title', 'favorite_sold')->get()->getRowArray();
				$emailContent = $get_email_content['content'];
				$placeholders = [
					'{user_name}' => $p_detail['fullname'],
					'{login_url}'     => base_url('login'),
					'{listing_name}'    =>$p_detail['display_name'],
					'{listing_url}'     =>base_url().'/listings/'.$p_detail['permalink'].'/'.$p_detail['id'].'/'.(!empty($p_detail['display_name'])?str_replace(' ','-',strtolower($p_detail['display_name'])):''),
				];

				foreach ($placeholders as $key => $value) {
					$emailContent = str_replace($key, $value, $emailContent);
				}
				$emailModel = new EmailModel();
				$data_email = array(
					'subject' => $get_email_content['name'],
					'content' => $emailContent,
					'to' => $p_detail['email'],
					'template_path' => "email/email_content",
				);
				$emailModel->send_email($data_email);
			}
			$update_data = $this->db->table('products')->where('id', $id)->update($data);
			$save_id = $id;
		}else{
			$user_detail = $this->get_user($data['user_id']);
			if($user_detail->user_level == 1){	
				$data_insert = [
					'user_id'                         => $user_detail->id,
					'stripe_subscription_start_date'  => date("Y-m-d H:i:s"),
					'stripe_subscription_end_date'    => NULL,
					'stripe_invoice_status'           => 'paid',
					'created_at'                      => date("Y-m-d H:i:s"),
					'trial_id' 						  => 0,
					'plan_id'                         => 999,
					'category_id'                     => 0,
					'stripe_subscription_status'      => 'active',
					'admin_plan_update'               => 1,
					'admin_plan_end_date'             => NULL,
					'is_cancel'						  => 0,
					'is_trial' => 0
				];
				$data['sale_id'] = $this->insert_sales($data_insert);
				$data['payment_type'] = 'none';
				$data['plan_id'] = 999;
			}else{
				$data['sale_id'] = $_POST['sale_id'];
			}
			
			
			$data['payment_type'] = $this->request->getVar('payment_type');
			$save_id = $this->db->table('products')->insert($data);	
			$save_id = $this->db->insertID();	
			if ($save_id) {
				//update sale table with product id
				$this->db->table('sales')->where('id', $data['sale_id'])->update(['product_id'=>$save_id,'category_id'=>$this->request->getVar('category_id')]);
				
			}
		}
		
		if ($save_id) {
			//delete all entries for that product id
			$this->db->table('products_dynamic_fields')->where('product_id', $id)->delete();
			//insert dynamic fields	
			if(!empty($d_fields_array)){
				foreach($d_fields_array as $kd => $df){
					if(is_array($df)){
						foreach($df as $rt){							
							$data_df = array();
							$data_df['field_id'] = $kd;
							$data_df['field_value'] = !empty($rt['field_value']) ? $rt['field_value'] : $rt;
							$data_df['file_field_title'] = !empty($rt['file_field_title']) ? $rt['file_field_title']:'';
							$data_df['product_id'] = $save_id;
							$this->db->table('products_dynamic_fields')->insert($data_df);
						}
					}else{
						$data_df = array();
						$data_df['field_id'] = $kd;
						$data_df['field_value'] = $df;
						$data_df['file_field_title'] = '';
						$data_df['product_id'] = $save_id;
						$this->db->table('products_dynamic_fields')->insert($data_df);
					}
				}
			}			
			if(!empty($this->request->getVar('image_ids'))){
				$this->db->table('user_images')->where('product_id',$save_id)->whereNotIn('id', explode(',',$this->request->getVar('image_ids')))->delete();
				return $this->db->query("UPDATE user_images SET product_id='".$save_id."' WHERE id IN (".$this->request->getVar('image_ids').")");
			}
            return $save_id;
        } else {
            return false;
        }
    }
	
	public function update_user_profile_photo($image,$id){		
		$data['avatar'] = $image;
        $save_id = $this->protect(false)->update($id,$data);
	}
    //update
    public function update_user($id)
    {
        $data = $this->input_values();        
        
		$data['email'] = $this->request->getVar('email');
		$data['category_id'] = $this->request->getVar('category_id');
		$data['sub_category_id'] = $this->request->getVar('sub_category_id');
        $data['business_name'] = !empty($this->request->getVar('business_name')) ? $this->request->getVar('business_name') : '';
		$data['clean_url'] = '';
		
		$data['address'] = !empty($this->request->getVar('address')) ? $this->request->getVar('address') : '';	
		$data['facebook_link'] = !empty($this->request->getVar('facebook_link')) ? $this->request->getVar('facebook_link') : '';
		$data['insta_link'] = !empty($this->request->getVar('insta_link')) ? $this->request->getVar('insta_link') : '';	
		$data['twitter_link'] = !empty($this->request->getVar('twitter_link')) ? $this->request->getVar('twitter_link') : '';
		$data['question1'] = !empty($this->request->getVar('question1')) ? $this->request->getVar('question1') : '';	
		$data['question2'] = !empty($this->request->getVar('question2')) ? $this->request->getVar('question2') : '';	
		$data['yelp_name'] = !empty($this->request->getVar('yelp_name')) ? $this->request->getVar('yelp_name') : '';
		$data['miles'] = !empty($this->request->getVar('miles')) ? $this->request->getVar('miles') : '15';
		$data['suite'] = !empty($this->request->getVar('suite')) ? $this->request->getVar('suite') : '';
		$data['city'] = !empty($this->request->getVar('locality')) ? $this->request->getVar('locality') : '';
		$data['state'] = !empty($this->request->getVar('state')) ? $this->request->getVar('state') : '';
		$data['zipcode'] = !empty($this->request->getVar('postcode')) ? $this->request->getVar('postcode') : '';
		$data['city_lat'] = !empty($this->request->getVar('city_lat')) ? $this->request->getVar('city_lat') : '';
		$data['city_lng'] = !empty($this->request->getVar('city_lng')) ? $this->request->getVar('city_lng') : '';
		
		$data['location_id'] = $this->request->getVar('location_id');
		$data['mobile_no'] = $this->request->getVar('mobile_no');
		$data['referredby'] = $this->request->getVar('referredby');
		$data['gender'] = $this->request->getVar('gender');
		$data['licensenumber'] = $this->request->getVar('licensenumber');
		$data['experience'] = $this->request->getVar('experience');
        $data['website'] = $this->request->getVar('website');
		$data['offering'] = json_encode($this->request->getVar('offering'));
		$data['clientele'] = json_encode($this->request->getVar('clientele'));		
		$data['categories_skills'] = json_encode($this->request->getVar('categories_skills'));
		$data['about_me'] = !empty($this->request->getVar('about_me')) ? $this->request->getVar('about_me') : '';
		$data['google_location'] = !empty($this->request->getVar('google_location')) ? $this->request->getVar('google_location') : '';
		$data['place_id'] = !empty($this->request->getVar('place_id')) ? $this->request->getVar('place_id') : '';
		$data['google_rating'] = !empty($this->request->getVar('google_rating')) ? $this->request->getVar('google_rating') : '';
		$data['about_me'] = !empty($this->request->getVar('about_me')) ? strip_tags($this->request->getVar('about_me')) : '';	
		
		$data['dynamic_fields'] = ($this->request->getVar('dynamic_fields') != null && count($this->request->getVar('dynamic_fields')) > 0) ? json_encode($this->request->getVar('dynamic_fields')) : '';
		
		unset($data['password']);
		unset($data['username']);
		unset($data['email']);
        $save_id = $this->protect(false)->update($id,$data);
		//update user rates if any
		$this->db->query("DELETE FROM user_rates WHERE user_id='" . $id . "'");
		if (!empty($this->request->getVar('price'))) {
			foreach($this->request->getVar('price') as $i => $row){
				$this->db->query("INSERT INTO user_rates SET user_id='" . $id . "', price='" . str_replace('$', '', ($this->request->getVar('price')[$i])) . "', duration_amount='" . ($this->request->getVar('duration_amount')[$i]) . "', duration='" . ($this->request->getVar('duration')[$i]) . "'");
			}
		}
		
		/* HOURS OF OPERATION */
		$this->db->query("DELETE FROM hours_of_operation WHERE user_id='" . $id . "'");
		for ($i = 1; $i <= 7; $i++) {
			if (!empty($this->request->getVar('hoo_' . $i . '_a'))) {
				$this->db->query("INSERT INTO hours_of_operation SET user_id='" . $id . "', closed_all_day='1', weekday='$i'");
			} else {
				if(!empty($this->request->getVar('hoo_' . $i . '_o')) && !empty($this->request->getVar('hoo_' . $i . '_c'))){
					$this->db->query("INSERT INTO hours_of_operation SET user_id='" . $id . "', opens_at='" . date('H:i',strtotime($this->request->getVar('hoo_' . $i . '_o'))) . "', closes_at='" . date('H:i',strtotime(($this->request->getVar('hoo_' . $i . '_c')))) . "', weekday='$i'");
				}
			}
		}
		//echo date('H:i',strtotime($this->request->getVar('hoo_2_c')));
		//exit;
        if ($save_id) {
            return $this->get_user($id);
        } else {
            return false;
        }
    }
	
    //update
    public function update_user_account($id)
    {
        $data = $this->input_values();        
        
		$data['email'] = $this->request->getVar('email');
		$data['first_name'] = $this->request->getVar('first_name');
		$data['last_name'] = $this->request->getVar('last_name');
		$data['fullname'] = $this->request->getVar('first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS).' '.$this->request->getVar('last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$data['mobile_no'] = $this->request->getVar('mobile_no');
		
		
		$data['city'] = !empty($this->request->getVar('city')) ? $this->request->getVar('city') : '';
		$data['state'] = !empty($this->request->getVar('state')) ? $this->request->getVar('state') : '';
		$data['website'] = !empty($this->request->getVar('website')) ? $this->request->getVar('website') : '';
		$data['facebook_link'] = !empty($this->request->getVar('facebook_link')) ? $this->request->getVar('facebook_link') : '';
		$data['insta_link'] = !empty($this->request->getVar('insta_link')) ? $this->request->getVar('insta_link') : '';	
		$data['linkedin_link'] = !empty($this->request->getVar('linkedin_link')) ? $this->request->getVar('linkedin_link') : '';
		$data['about_me'] = !empty($this->request->getVar('about_me')) ? $this->request->getVar('about_me') : '';
		
		
		unset($data['password']);
		unset($data['username']);
        $save_id = $this->protect(false)->update($id,$data);		
		
        if ($save_id) {
            return $this->get_user($id);
        } else {
            return false;
        }
    }
	
    //update
    public function update_user_password($id)
    {
		$udetail= $this->get_user($id);
        $data = $this->input_values(); 
        $data['password'] = password_hash($this->request->getVar('new_password'), PASSWORD_BCRYPT);
		unset($data['username']);
		unset($data['email']);
        $save_id = $this->protect(false)->update($id,$data);	
		if($udetail->role == 1){
			$this->session->set("admin_sess_user_ps", md5($data['password']));	
		}else{
			$this->session->set("vr_sess_user_ps", md5($data['password']));	
		}
		
        if ($save_id) {
            return $udetail;
        } else {
            return false;
        }
    }
	
	public function update_user_plan($id,$data)
    {
        $save_id = $this->protect(false)->update($id,$data);		
		
        if ($save_id) {
            return $this->get_user($id);
        } else {
            return false;
        }
    }
	
	public function insert_user_trial($data){		
        $this->db->table('trials')->insert($data);		
		return $this->db->insertID();
	}
	
	public function get_trial($user_id,$plan_id){
		$sql = "SELECT * FROM trials WHERE user_id = ? and plan_id = ?";
        $query = $this->db->query($sql, array($user_id, $plan_id));
        return $query->getRow();
	}
	
	public function get_trials_by_user_id($user_id){
		$sql = "SELECT GROUP_CONCAT(plan_id) as plan_ids FROM `trials` where user_id = ? group by user_id;";
        $query = $this->db->query($sql, array($user_id));
        return $query->getRow();
	}
	
	public function get_rate_details($id){
		$sql = "SELECT * FROM user_rates WHERE user_rates.user_id = ? order by price asc";
        $query = $this->db->query($sql, array($id));
        return $query->getResult();
	}
	
	public function get_hours_of_operation($id){
		$sql = "SELECT * FROM hours_of_operation WHERE hours_of_operation.user_id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->getResultArray();
	}
	
	public function get_user_photos_live($id,$plan_id='',$product_id=0){
		if($plan_id == 1 || $plan_id == 2){
			$sql = "SELECT * FROM user_images WHERE user_images.user_id = ? AND product_id=? order by user_images.order asc LIMIT 1";
		}else{
			$sql = "SELECT * FROM user_images WHERE user_images.user_id = ? AND product_id=? order by user_images.order asc";
		}		
        $query = $this->db->query($sql, array($id,$product_id));
        return $query->getResultArray();
	}
	
	public function get_user_photos($id,$plan_id='',$product_id=0){		
		$sql = "SELECT *,(SELECT GROUP_CONCAT(id ORDER BY user_images.order ASC) FROM user_images WHERE user_id = ? AND product_id = ?) AS all_ids FROM user_images WHERE user_images.user_id = ? AND product_id=? order by file_type,user_images.order asc";				
        $query = $this->db->query($sql, array($id,$product_id,$id,$product_id));
        return $query->getResultArray();
	}
	public function get_user_photos_isimage($id,$plan_id='',$product_id=0){
		if($plan_id == 1 || $plan_id == 2){
			$sql = "SELECT *,(SELECT GROUP_CONCAT(id ORDER BY user_images.order ASC) FROM user_images WHERE user_id = ? AND product_id = ?) AS all_ids FROM user_images WHERE user_images.user_id = ? AND product_id=? AND file_type='image' order by user_images.order asc LIMIT 10";
		}else{
			$sql = "SELECT *,(SELECT GROUP_CONCAT(id ORDER BY user_images.order ASC) FROM user_images WHERE user_id = ? AND product_id = ?) AS all_ids FROM user_images WHERE user_images.user_id = ? AND product_id=? AND file_type='image' order by user_images.order asc";
		}		
        $query = $this->db->query($sql, array($id,$product_id,$id,$product_id));
        return $query->getResultArray();
	}
	public function get_user_photos_isvideo($id,$plan_id='',$product_id=0){
		if($plan_id == 1 || $plan_id == 2){
			$sql = "SELECT *,(SELECT GROUP_CONCAT(id ORDER BY user_images.order ASC) FROM user_images WHERE user_id = ? AND product_id = ?) AS all_ids FROM user_images WHERE user_images.user_id = ? AND product_id=? AND file_type='video' order by user_images.order asc LIMIT 10";
		}else{
			$sql = "SELECT *,(SELECT GROUP_CONCAT(id ORDER BY user_images.order ASC) FROM user_images WHERE user_id = ? AND product_id = ?) AS all_ids FROM user_images WHERE user_images.user_id = ? AND product_id=? AND file_type='video' order by user_images.order asc";
		}		
        $query = $this->db->query($sql, array($id,$product_id,$id,$product_id));
        return $query->getResultArray();
	}
	
	public function get_uer_by_business_name($business_name){
		
		$sql = "SELECT * FROM users WHERE clean_url = ?";
				
        $query = $this->db->query($sql, array($business_name));
        return $query->getRow();
	}
	
	public function insert_user_photos($image,$user_id,$image_tag,$product_id,$file_type=''){
		return $this->db->query("INSERT INTO user_images SET user_id='" . $user_id . "',product_id='" . $product_id . "', file_name='".$image."', image_tag = '".$image_tag."', file_type = '".$file_type."'");
	}
	
	public function update_user_photos($p_id,$user_id,$image_tag,$image,$file_type=''){
		if(!empty($image)){
			return $this->db->query("UPDATE user_images SET file_name='".$image."', image_tag = '".$image_tag."', file_type = '".$file_type."' WHERE id = '".$p_id."'");
		}else{
			return $this->db->query("UPDATE user_images SET image_tag = '".$image_tag."' WHERE id = '".$p_id."'");
		}
		
	}
	
	public function insert_sales($data){
		$this->db->table('sales')->insert($data);
		return $this->db->insertID();
	}
	public function insert_paypal_sales($data){
		$this->db->table('paypal_sales')->insert($data);
		return $this->db->insertID();
	}
	public function insert_paypal_sales_cron($data){
		
		$sql = 'INSERT INTO paypal_sales (user_id, plan_id, transaction_id, transaction_amount, transaction_status, transaction_initiation_date, paypal_reference_id, payer_id, payer_email, subscription_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE 
            payer_id=VALUES(payer_id), 
            payer_email=VALUES(payer_email), 
            paypal_reference_id=VALUES(paypal_reference_id), 
            transaction_amount=VALUES(transaction_amount)';
		return $query = $this->db->query($sql, array($data['user_id'],$data['plan_id'],$data['transaction_id'],$data['transaction_amount'],$data['transaction_status'],$data['transaction_initiation_date'],$data['paypal_reference_id'],$data['payer_id'],$data['payer_email'],$data['subscription_id']));	
		
	}
	
	
	
	public function update_user_photos_order($id,$order){
		return $this->db->query("UPDATE user_images SET user_images.order='" . $order . "' WHERE user_images.id = '".$id."'");
	}
	
	public function delete_user_photos($photo_id){
		return $this->db->query("DELETE FROM user_images WHERE user_images.id='" . $photo_id . "'");
	}
	
	public function delete_user_photos_id($user_id){
		
		$sql = "SELECT * FROM user_images WHERE user_images.user_id = ? AND product_id=0 order by user_images.order asc";$query =$this->db->query($sql, array($user_id));
        $arr = $query->getResultArray();
		
		// Deleting file
		if (!empty($arr)) {
			foreach($arr as $ar){
				$filename = basename($ar['file_name']); // Secure: prevent path traversal
				//$filePath = base_url('/uploads/userimages/'.$user_id) .'/'.$filename;
				$filePath = FCPATH .'uploads/userimages/'.$user_id .'/'.$filename;

				if (file_exists($filePath) && !empty($filename)) {
					if (unlink($filePath)) {
						$response = [
							'deleted' => 1,
							'message' => 'File deleted successfully'
						];
					} else {
						$response = [
							'deleted' => 0,
							'error' => 'Failed to delete file'
						];
					}
				} else {
					$response = [
						'deleted' => 0,
						'error' => 'File not found'
					];
				}
			}
		} else {
			$response = [
				'deleted' => 0,
				'error' => 'cd Filename not provided'
			];
		}
		
		
		return $this->db->query("DELETE FROM user_images WHERE product_id = 0 AND user_id='" . $user_id . "'");
	}
    //reset password
    public function reset_password($token)
    {
        $user = $this->get_user_by_token($token);
        if (!empty($user)) {

            $new_password = $this->request->getVar('password');
            $data = array(
                'password' => password_hash($new_password, PASSWORD_BCRYPT),
                //'token' => generate_unique_id()
            );
            //change password
            $this->builder()->where('id', $user->id);
            return $this->builder()->update($data);
        }
        return false;
    }

    //check slug
    public function check_is_slug_unique($slug, $id)
    {

        $sql = "SELECT * FROM users WHERE users.slug = ? AND users.id != ?";
        $query = $this->db->query($sql, array(clean_str($slug), clean_number($id)));
        if (!empty($query->getRow())) {
            return true;
        }
        return false;
    }

    //check if email is unique
    public function is_unique_email($email, $user_id = 0)
    {
        $user = $this->get_user_by_email($email);
        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }
        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //email taken
                return false;
            } else {
                return true;
            }
        }
    }

    //check if username is unique
    public function is_unique_username($username, $user_id = 0)
    {
        $user = $this->get_user_by_username($username);
        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }
        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //username taken
                return false;
            } else {
                return true;
            }
        }
    }

    public function getUser($username = false, $userID = false)
    {
        if ($username) {
            return $this->db->table('users')
                ->select('*,users.id AS userID,user_role.id AS role_id')
                ->join('user_role', 'users.role = user_role.id')
                ->where(['username' => $username])
                ->get()->getRow();
        } elseif ($userID) {
            return $this->db->table('users')
                ->select('*,users.id AS userID,user_role.id AS role_id')
                ->join('user_role', 'users.role = user_role.id')
                ->where(['users.id' => $userID])
                ->get()->getRow();
        } else {
            return $this->db->table('users')
                ->select('*,users.id AS userID,user_role.id AS role_id')
                ->join('user_role', 'users.role = user_role.id')
                ->get()->getRow();
        }
    }

    //get user by email
    public function get_user_by_email($email)
    {

        $sql = "SELECT * FROM users WHERE users.email = ?";
        $query = $this->db->query($sql, array(clean_str($email)));
        return $query->getRow();
    }
    public function get_user_by_sid($sid)
    {

        $sql = "SELECT * FROM users WHERE users.stripe_subscription_id = ?";
        $query = $this->db->query($sql, array(clean_str($sid)));
        return $query->getRow();
    }

    //get user by username
    public function get_user_by_username($username)
    {
        $sql = "SELECT * FROM users WHERE users.username = ? ";
        $query = $this->db->query($sql, array(clean_str($username)));
        return $query->getRow();
    }

    //get user by slug
    public function get_user_by_slug($slug)
    {
        $sql = "SELECT * FROM users WHERE users.slug = ?";
        $query = $this->db->query($sql, array(clean_str($slug)));
        return $query->getRow();
    }

    //get user by token
    public function get_user_by_token($token)
    {
        $sql = "SELECT * FROM users WHERE users.token = ?";
        $query = $this->db->query($sql, array(clean_str($token)));
        return $query->getRow();
    }

    //get user by id
    public function get_user($id)
    {
        $sql = "SELECT users.*, zipcodes.city as zcity, zipcodes.zipcode as zcode, states.code as state_code,categories.name as category_name,categories.skill_name,categories.permalink,categories.rate_type FROM users LEFT JOIN zipcodes ON users.location_id = zipcodes.id LEFT JOIN states ON zipcodes.state_id = states.id LEFT JOIN categories ON categories.id = users.category_id WHERE users.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->getRow();
    }

    //is logged in
    public function is_logged_in()
    {
		if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {	
			//check if user logged in
			if ($this->session->get('admin_sess_logged_in') == true && $this->session->get('admin_sess_app_key') == config('app')->AppKey) {
				$sess_user_id = @clean_number($this->session->get('admin_sess_user_id'));
				if (!empty($sess_user_id) && !empty($this->get_user($sess_user_id))) {
					return true;
				}
			}
		}else{
			if ($this->session->get('vr_sess_logged_in') == true && $this->session->get('vr_sess_app_key') == config('app')->AppKey) {
				$sess_user_id = @clean_number($this->session->get('vr_sess_user_id'));
				if (!empty($sess_user_id) && !empty($this->get_user($sess_user_id))) {
					return true;
				}
			}			
		}
        return false;
    }


    //function get user
    public function get_logged_user()
    {
		if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {			
			if ($this->session->get('admin_sess_logged_in') == true && $this->session->get('admin_sess_app_key') == config('app')->AppKey && !empty($this->session->get('admin_sess_user_id'))) {
				$sess_user_id = @clean_number($this->session->get('admin_sess_user_id'));
				if (!empty($sess_user_id)) {
					$sess_pass = $this->session->get("admin_sess_user_ps");
					$user = $this->get_user($sess_user_id);
					if (!empty($user) && !empty($sess_pass) && md5($user->password) == $sess_pass) {
						return $user;
					}
				}
			}
		}else{				
			if ($this->session->get('vr_sess_logged_in') == true && $this->session->get('vr_sess_app_key') == config('app')->AppKey && !empty($this->session->get('vr_sess_user_id'))) {
				$sess_user_id = @clean_number($this->session->get('vr_sess_user_id'));
				if (!empty($sess_user_id)) {
					$sess_pass = $this->session->get("vr_sess_user_ps");
					$user = $this->get_user($sess_user_id);
					if (!empty($user) && !empty($sess_pass) && md5($user->password) == $sess_pass) {
						return $user;
					}
				}
			}
		}
        return false;
    }

    //generate uniqe slug
    public function generate_uniqe_slug($username)
    {
        $slug = str_slug($username);
        if (!empty($this->get_user_by_slug($slug))) {
            $slug = str_slug($username . "-1");
            if (!empty($this->get_user_by_slug($slug))) {
                $slug = str_slug($username . "-2");
                if (!empty($this->get_user_by_slug($slug))) {
                    $slug = str_slug($username . "-3");
                    if (!empty($this->get_user_by_slug($slug))) {
                        $slug = str_slug($username . "-" . uniqid());
                    }
                }
            }
        }
        return $slug;
    }

    //generate uniqe username
    public function generate_uniqe_username($username)
    {
        $new_username = $username;
        if (!empty($this->get_user_by_username($new_username))) {
            $new_username = $username . " 1";
            if (!empty($this->get_user_by_username($new_username))) {
                $new_username = $username . " 2";
                if (!empty($this->get_user_by_username($new_username))) {
                    $new_username = $username . " 3";
                    if (!empty($this->get_user_by_username($new_username))) {
                        $new_username = $username . "-" . uniqid();
                    }
                }
            }
        }
        return $new_username;
    }

    //is admin
    public function is_admin()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }
        //check role
        if (user()->role == 1) {
            return true;
        } else {
            return false;
        }
    }

    //is superadmin
    public function is_superadmin()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }
        //check role
        if (user()->role == 1 && user()->id == 1) {
            return true;
        } else {
            return false;
        }
    }

    //verify email
    public function verify_email($user)
    {
        if (!empty($user)) {

            $data = array(
                'email_status' => 1,
                //'token' => generate_unique_id()
            );

            return $this->protect(false)->update($user->id, $data);
        }
        return false;
    }

    //delete user
    public function delete_user($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);
        if (!empty($user)) {
            if (file_exists(FCPATH . $user->avatar)) {
                @unlink(FCPATH . $user->avatar);
            }
            //delete account
            return $this->where('id', $id)->delete();
        }
        return false;
    }

    //update last seen time
    public function update_last_seen()
    {
		//check logged in
        if (!$this->is_logged_in()) {
            return false;
        }
        if (auth_check()) {
            //update last seen
            $data = array(
                'last_seen' => date("Y-m-d H:i:s"),
            );
            return $this->protect(false)->update(user()->id, $data);
        }
    }

    public function userPaginate()
    {
        $request = service('request');
        $show = 25;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }

        $paginateData = $this->select('users.*')
          ->orderBy('users.id','DESC');

        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('users.username', clean_str($search))
                ->orLike('users.fullname', clean_str($search))
                ->orLike('users.email', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('users.status', clean_number($status));
        }
        $user_level = trim($request->getGet('user_level') ?? '');
        if ($user_level != null && ($user_level == 1 || $user_level == 0)) {
            $this->builder()->where('users.user_level', clean_number($user_level));
        }

        $email_status = trim($request->getGet('email_status') ?? '');
        if ($email_status != null && ($email_status == 1 || $email_status == 0)) {
            $this->builder()->where('users.email_status', clean_number($email_status));
        }

        $created_at_start = trim($request->getGet('created_at_start') ?? '');
        $created_at_end = trim($request->getGet('created_at_end') ?? '');
        if ($created_at_start != null && $created_at_end != null && ($created_at_start != '' && $created_at_end != '')) {
            $this->builder()->where("DATE(users.created_at) >=", $created_at_start)
                    ->where("DATE(users.created_at) <=", $created_at_end);
        }
        $this->builder()->where('users.id !=', 1);
		$result = $paginateData->paginate($show, 'default');
        return [
            'users'  =>  $result,
            'pager'     => $this->pager,
			'per_page_no' => $show,
			'total' => $this->pager->gettotal()
        ];
    }

    //get paginated users
    public function get_paginated_admin($per_page, $offset)
    {
        $this->builder()->select('users.*, user_role.role_name as role')
            ->join('user_role', 'users.role = user_role.id')
            ->where('users.role', 1)
            ->where('users.deleted_at', null)
            ->orderBy('users.id', 'ASC');
        $this->filter_admin();

        $query = $this->builder()->get($per_page, $offset);

        return $query->getResultArray();
    }

    //get paginated users count
    public function get_paginated_admin_count()
    {
        $this->builder()->selectCount('id');
        $this->builder()->where('role', 'admin');
        $this->builder()->where('deleted_at', NULL);
        $this->filter_admin();
        $query = $this->builder()->get();
        return $query->getRow()->id;
    }

    public function filter_admin()
    {
        $request = service('request');
        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('users.username', clean_str($search))
                ->orLike('users.fullname', clean_str($search))
                ->orLike('users.email', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status') ?? '');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('users.status', clean_number($status));
        }

        $email_status = trim($request->getGet('email_status') ?? '');
        if ($email_status != null && ($email_status == 1 || $email_status == 0)) {
            $this->builder()->where('users.email_status', clean_number($email_status));
        }
    }

    public function logout()
    {
        //unset user data
        $this->session->remove('vr_sess_user_id');
        $this->session->remove('vr_sess_user_email');
        $this->session->remove('vr_sess_user_role');
        $this->session->remove('vr_sess_logged_in');
        $this->session->remove('vr_sess_app_key');
        $this->session->remove('vr_sess_user_ps');
        helper_deletecookie("remember_user_id");
        helper_deletecookie("_remember_user_id");
    }

    public function logout_admin()
    {
        //unset user data
        $this->session->remove('admin_sess_user_id');
        $this->session->remove('admin_sess_user_email');
        $this->session->remove('admin_sess_user_role');
        $this->session->remove('admin_sess_logged_in');
        $this->session->remove('admin_sess_app_key');
        $this->session->remove('admin_sess_user_ps');
        helper_deletecookie("remember_user_id_admin");
        helper_deletecookie("_remember_user_id_admin");
    }
	
	

    //get paginated provider messages
    public function get_paginated_provider_messages($per_page='', $offset='', $id='')
    {
        
		if($id != ''){
			$query = $this->db->table('provider_messages AS pm')
            ->select('pm.*, u.fullname AS to_provider')
            ->join('users AS u', 'u.id = pm.to_user_id', 'left')			
            ->join('products AS p', 'p.id = pm.product_id', 'right')
            ->where('u.deleted_at', null)
            ->where('pm.deleted_at', NULL)
			->where('pm.to_user_id', $id)
            ->orderBy('pm.id', 'DESC');
		}else{
			$query = $this->db->table('provider_messages AS pm')
            ->select('pm.*, u.fullname AS to_provider')
            ->join('users AS u', 'u.id = pm.to_user_id', 'left')			
            ->join('products AS p', 'p.id = pm.product_id', 'right')
            ->where('u.deleted_at', null)
            ->where('pm.deleted_at', NULL)
            ->orderBy('pm.id', 'DESC');
		}
		

        $query = $this->filter_provider_messages($query);

        return $query->get($per_page, $offset)->getResultArray();
    }

    //get paginated provider messages count
    public function get_paginated_provider_messages_count($id='')
    {        
        
		if($id != ''){
			$query = $this->db->table('provider_messages AS pm')->select('pm.id')			
            ->join('products AS p', 'p.id = pm.product_id', 'right')->where('pm.deleted_at', null)->where('pm.to_user_id', $id);
		}else{
			$query = $this->db->table('provider_messages AS pm')->select('pm.id')			
            ->join('products AS p', 'p.id = pm.product_id', 'right')->where('pm.deleted_at', null);
		}
        $query = $this->filter_provider_messages($query);
        $count = $query->countAllResults();
        return $count;
    }
    
    
    //get paginated provider messages
    public function get_paginated_provider_messages_admin($per_page='', $offset='', $id='')
    {
        
		if($id != ''){
			$query = $this->db->table('provider_messages AS pm')
            ->select('pm.*, u.fullname AS to_provider')
            ->join('users AS u', 'u.id = pm.to_user_id', 'left')
            ->where('u.deleted_at', null)
			->where('pm.to_user_id', $id)
            ->orderBy('pm.id', 'DESC');
		}else{
			$query = $this->db->table('provider_messages AS pm')
            ->select('pm.*, u.fullname AS to_provider')
            ->join('users AS u', 'u.id = pm.to_user_id', 'left')
            ->where('u.deleted_at', null)
            ->orderBy('pm.id', 'DESC');
		}
		

        $query = $this->filter_provider_messages($query);

        return $query->get($per_page, $offset)->getResultArray();
    }

    //get paginated provider messages count
    public function get_paginated_provider_messages_count_admin($id='')
    {        
        
		if($id != ''){
			$query = $this->db->table('provider_messages AS pm')->select('pm.id')	
			->where('pm.deleted_at', null)->where('pm.to_user_id', $id);
		}else{
			$query = $this->db->table('provider_messages AS pm')->select('pm.id')
			->where('pm.deleted_at', null);
		}
        $query = $this->filter_provider_messages($query);
        $count = $query->countAllResults();
        return $count;
    }
	
	
	public function get_recent_provider_messages($id='')
    {
		return $this->db->table('provider_messages AS pm')->select('pm.*')		
            ->join('products AS p', 'p.id = pm.product_id', 'right')->where('pm.deleted_at', null)->where('pm.to_user_id', $id)->orderBy('pm.id','desc')->get()->getRowArray();		
    }
	
    public function filter_provider_messages($query)
    {
        $request = service('request');
        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $query->groupStart()
             ->orLike('pm.from_name', $search)
             ->orLike('pm.from_email', $search)
             ->orLike('pm.from_phone', $search)
             ->groupEnd();
        }

		$created_at_start = trim($request->getGet('created_at_start') ?? '');
        $created_at_end = trim($request->getGet('created_at_end') ?? '');
        if ($created_at_start != null && $created_at_end != null && ($created_at_start != '' && $created_at_end != '')) {
            $query->where("DATE(pm.created_at) >=", $created_at_start)
                    ->where("DATE(pm.created_at) <=", $created_at_end);
        }
		
        $provider_id = trim($request->getGet('provider_id') ?? '');
        if ($provider_id != null && !empty($provider_id)) {
            $query->where('pm.to_user_id', $provider_id);
        }
        return $query;
    }

    public function get_users()
    {
        $sql = "SELECT * FROM users WHERE deleted_at IS NULL";
        $query = $this->db->query($sql);
        return $query->getResult();        
    }

    public function getProviderMessages($message_id){
          $query = $this->db->table('provider_messages AS pm')
            ->select('pm.*, u.fullname AS to_provider,IFNULL(`u1`.`fullname`,"-") AS logged_user,c.permalink,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR " ") AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = "title") t ON t.field_id = pd.field_id WHERE pd.product_id = pr.id) as display_name')
            ->join('users AS u', 'u.id = pm.to_user_id', 'left')
            ->join('users AS u1', 'u1.id = pm.logged_user_id', 'left')
            ->join('products AS pr', 'pr.id = pm.product_id', 'left')
            ->join('categories AS c', 'c.id = pr.category_id', 'left')
            ->where('pm.id', $message_id)
            ->where('u.deleted_at', null)
            ->orderBy('pm.id', 'DESC');
        return $query->get()->getRow();
    }
	
    public function deleteProviderMessages($message_id){
          return $this->db->query("UPDATE provider_messages SET deleted_at=NOW() WHERE id = '".$message_id."'");
    }

    public function getContactMessages($message_id){
          $query = $this->db->table('contacts AS pm')
            ->select('pm.*')
            ->where('pm.id', $message_id)
            ->orderBy('pm.id', 'DESC');
        return $query->get()->getRow();
    }
	
    public function getCaptainMessages($message_id){
          $query = $this->db->table('captains_club_request AS pm')
            ->select('pm.*')
            ->where('pm.id', $message_id)
            ->orderBy('pm.id', 'DESC');
        return $query->get()->getRow();
    }
	public function get_active_stripe_subscriptions(){
		$query = $this->db->table('sales AS s')
            ->select('s.*,u.fullname as first_name,u.email')
			->join('users u','u.id = s.user_id','left')
			->where('s.is_cancel', 0)
            ->orderBy('s.id', 'DESC');
		return $query->get()->getResult();
	}
    public function get_stripe_subscribed_expired_users($gracePeriod = false)
    {
        $sql = "SELECT id, fullname, first_name, email,plan_id,stripe_subscription_customer_id,stripe_invoice_id,stripe_subscription_price_id,
                    stripe_subscription_id,stripe_subscription_start_date,stripe_subscription_end_date,stripe_subscription_status FROM users 
                WHERE deleted_at IS NULL  
                AND payment_type = 'Stripe' 
                AND admin_plan_update = '0'           
                AND stripe_subscription_id != '' 
                AND stripe_subscription_status = 'active'
                AND stripe_subscription_end_date < NOW()";

        if($gracePeriod){
            $sql .=" AND NOW() > DATE_ADD(stripe_subscription_end_date, INTERVAL 5 DAY)"; //GRACE PERIOD OF 5 DAYS
        }        

        $query = $this->db->query($sql);
        return $query->getResult();        
    }

    public function get_stripe_subscribed_trial_users($gracePeriod = false)
    {
        $sql = "SELECT id, fullname, first_name, email,plan_id,stripe_subscription_customer_id,stripe_invoice_id,stripe_subscription_price_id,
                    stripe_subscription_id,stripe_subscription_start_date,stripe_subscription_end_date,stripe_subscription_status FROM users 
                WHERE deleted_at IS NULL   
                AND payment_type = 'Stripe' 
                AND admin_plan_update = '0'           
                AND stripe_subscription_id != '' 
                AND stripe_subscription_status = 'active'
                AND DATE_FORMAT(stripe_subscription_end_date, '%Y-%m-%d') = DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 3 DAY), '%Y-%m-%d')";

        $query = $this->db->query($sql);
        return $query->getResult();        
    }
     public function process_admin_upgraded_users()
    {
        $sql = "UPDATE users
                SET plan_id = '1', admin_plan_update = '0', admin_plan_end_date = NULL
                WHERE id IN (
                    SELECT subquery.id FROM (
                        SELECT id FROM users 
                        WHERE deleted_at IS NULL  
                        AND admin_plan_update = '1'           
                        AND admin_plan_end_date IS NOT NULL  
                        AND admin_plan_end_date != ''
                        AND admin_plan_end_date != '0000-00-00'
                        AND admin_plan_end_date < CURDATE()
                    ) AS subquery
                )";             

        $query = $this->db->query($sql);
        return true;        
    }
	
	//get paginated sales count
	public function get_paginated_sales($per_page='', $offset='')
    {
        /*$query = $this->db->table('sales AS s')
            ->select('s.*, u.fullname AS provider')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->where('u.deleted_at', null)
            ->orderBy('s.id', 'DESC');*/
			
		$query = $this->db->table('sales AS s')
            ->select('s.*, u.fullname AS provider,u.user_level,p.name as plan_name,p.price as plan_price,pr.id as product_id,c.permalink,pr.category_id,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR " ") AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = "title") t ON t.field_id = pd.field_id WHERE pd.product_id = pr.id) as display_name')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->join('plans AS p', 'p.id = s.plan_id', 'left')
            ->join('products AS pr', 'pr.id = s.product_id', 'left')
            ->join('categories AS c', 'c.id = pr.category_id', 'left')
            ->orderBy('s.id', 'DESC');

        $query = $this->filter_sales($query);

        return $query->get($per_page, $offset)->getResultArray();
    }
	public function get_paginated_paypal_sales($per_page='', $offset='')
    {
        $query = $this->db->table('paypal_sales AS s')
            ->select('s.*, u.fullname AS provider,u.stripe_subscription_start_date, u.stripe_subscription_end_date')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->where('u.deleted_at', null)
            ->orderBy('s.id', 'DESC');

        $query = $this->filter_paypal_sales($query);

        return $query->get($per_page, $offset)->getResultArray();
    }
	
	public function get_paypal_sales()
    {
        $query = $this->db->table('paypal_sales AS s')
            ->select('s.*, u.fullname AS provider')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->where('u.deleted_at', null)
            ->orderBy('s.id', 'DESC');

        return $query->get()->getResultArray();
    }
	public function get_paypal_sales_user($id)
    {
        $query = $this->db->table('paypal_sales AS s')
            ->select('s.*, u.fullname AS provider')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->where('u.deleted_at', null)
            ->where('s.user_id', $id)
            ->orderBy('s.id', 'DESC');

        return $query->get()->getResult();
    }
	public function get_sales_user($id)
    {
        $query = $this->db->table('sales AS s')
            ->select('s.*, u.fullname AS provider,p.name as plan_name,p.price as plan_price,pr.id as product_id,pr.status as product_status,c.permalink,pr.category_id,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR " ") AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = "title") t ON t.field_id = pd.field_id WHERE pd.product_id = pr.id) as display_name')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->join('plans AS p', 'p.id = s.plan_id', 'left')
            ->join('products AS pr', 'pr.id = s.product_id', 'left')
            ->join('categories AS c', 'c.id = pr.category_id', 'left')
            ->where('u.deleted_at', null)
            ->where('s.user_id', $id)
            ->orderBy('s.id', 'DESC');
		$query = $this->filter_provider_subs($query);
        return $query->get()->getResult();
    }
	public function get_paginated_sales_user($id,$per_page='', $offset='')
    {
        $query = $this->db->table('sales AS s')
            ->select('s.*, u.fullname AS provider,p.name as plan_name,p.price as plan_price,pr.id as product_id,c.permalink,pr.category_id,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR " ") AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = "title") t ON t.field_id = pd.field_id WHERE pd.product_id = pr.id) as display_name')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->join('plans AS p', 'p.id = s.plan_id', 'left')
            ->join('products AS pr', 'pr.id = s.product_id', 'left')
            ->join('categories AS c', 'c.id = pr.category_id', 'left')
            ->where('u.deleted_at', null)
            ->where('s.user_id', $id)
            ->orderBy('s.id', 'DESC');
		$query = $this->filter_provider_subs($query);
		//echo $this->db->getLastQuery();exit;
        return $query->get($per_page, $offset)->getResult();
    }
	public function get_paginated_sales_user_count($id){
		$query = $this->db->table('sales AS s')
            ->select('s.*, u.fullname AS provider,p.name as plan_name,p.price as plan_price,pr.id as product_id,c.permalink,pr.category_id,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR " ") AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = "title") t ON t.field_id = pd.field_id WHERE pd.product_id = pr.id) as display_name')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->join('plans AS p', 'p.id = s.plan_id', 'left')
            ->join('products AS pr', 'pr.id = s.product_id', 'left')
            ->join('categories AS c', 'c.id = pr.category_id', 'left')
            ->where('u.deleted_at', null)
            ->where('s.user_id', $id)
            ->orderBy('s.id', 'DESC');

        $query = $this->filter_provider_subs($query);
        $count = $query->countAllResults();
        return $count;
	}
	public function get_sales_user_with_cus_id($id)
    {
        $query = $this->db->table('sales AS s')
            ->select('s.*, u.fullname AS provider,p.name as plan_name,p.price as plan_price,pr.id as product_id,c.permalink,pr.category_id,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR " ") AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = "title") t ON t.field_id = pd.field_id WHERE pd.product_id = pr.id) as display_name')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->join('plans AS p', 'p.id = s.plan_id', 'left')
            ->join('products AS pr', 'pr.id = s.product_id', 'left')
            ->join('categories AS c', 'c.id = pr.category_id', 'left')
            ->where('u.deleted_at', null)
            ->where('s.user_id', $id)
            ->where('s.stripe_subscription_customer_id !=', NULL)
            ->orderBy('s.id', 'DESC');
		$query = $this->filter_provider_subs($query);
        return $query->get()->getResult();
    }
	
    public function filter_provider_subs($query)
    {
        $request = service('request');
        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $query->groupStart()
             ->orLike('p.name', $search)
			 ->orLike('(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR " ") AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = "title") t ON t.field_id = pd.field_id WHERE pd.product_id = pr.id)', $search)
             ->groupEnd();
        }

		$created_at_start = trim($request->getGet('created_at_start') ?? '');
        $created_at_end = trim($request->getGet('created_at_end') ?? '');
        if ($created_at_start != null && $created_at_end != null && ($created_at_start != '' && $created_at_end != '')) {
            $query->where("DATE(s.stripe_subscription_start_date) >=", $created_at_start)
                    ->where("DATE(s.stripe_subscription_start_date) <=", $created_at_end);
        }
		
        return $query;
    }

	public function get_sales_by_id($id)
    {
        $query = $this->db->table('sales AS s')
            ->select('s.*, u.fullname AS provider,p.name as plan_name,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR " ") AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = "title") t ON t.field_id = pd.field_id WHERE pd.product_id = pr.id) as display_name')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->join('plans AS p', 'p.id = s.plan_id', 'left')
            ->join('products AS pr', 'pr.id = s.product_id', 'left')
            ->where('u.deleted_at', null)
            ->where('s.id', $id)
            ->orderBy('s.id', 'DESC');

        return $query->get()->getRow();
    }
	public function get_paypal_sales_by_id($id)
    {
        $query = $this->db->table('paypal_sales AS s')
            ->select('s.*, u.fullname AS provider,p.name as plan_name,(SELECT GROUP_CONCAT(pd.field_value ORDER BY t.sort_order SEPARATOR " ") AS field_values FROM products_dynamic_fields pd JOIN ( SELECT t.field_id, t.sort_order FROM title_fields t LEFT JOIN fields f ON f.id = t.field_id WHERE t.title_type = "title") t ON t.field_id = pd.field_id WHERE pd.product_id = pr.id) as display_name')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->join('plans AS p', 'p.id = s.plan_id', 'left')
            ->join('products AS pr', 'pr.id = s.product_id', 'left')
            ->where('u.deleted_at', null)
            ->where('s.id', $id)
            ->orderBy('s.id', 'DESC');

        return $query->get()->getRow();
    }
	
    public function get_paginated_sales_count()
    {        
        $query = $this->db->table('sales AS s')->join('users AS u', 'u.id = s.user_id', 'left')
                    ->select('s.id');

        $query = $this->filter_sales($query);
        $count = $query->countAllResults();
        return $count;
    }
    public function get_paginated_paypal_sales_count()
    {        
        $query = $this->db->table('paypal_sales AS s')->join('users AS u', 'u.id = s.user_id', 'left')
                    ->select('s.id');

        $query = $this->filter_paypal_sales($query);
        $count = $query->countAllResults();
        return $count;
    }
	
	//get paginated sales count
	public function get_total_amount_sales()
    {
        $query = $this->db->table('sales AS s')
            ->select('s.*, u.fullname AS provider,SUM(s.stripe_subscription_amount_paid) as total_amount')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->where('u.deleted_at', null)
            ->orderBy('s.id', 'DESC');

        $query = $this->filter_sales($query);

        return $query->get()->getRowArray();
    }
	public function get_total_amount_paypal_sales()
    {
        $query = $this->db->table('paypal_sales AS s')
            ->select('s.*, u.fullname AS provider,SUM(s.transaction_amount) as total_amount')
            ->join('users AS u', 'u.id = s.user_id', 'left')
            ->where('u.deleted_at', null)
            ->orderBy('s.id', 'DESC');

        $query = $this->filter_paypal_sales($query);

        return $query->get()->getRowArray();
    }
	
    public function filter_sales($query)
    {
        $request = service('request');
        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $query->groupStart()
             ->orLike('u.fullname', $search)
             ->orLike('s.stripe_invoice_id', $search)
             ->orLike('s.stripe_subscription_id', $search)
             ->groupEnd();
        }
		
		$created_at_start = trim($request->getGet('created_at_start') ?? '');
        $created_at_end = trim($request->getGet('created_at_end') ?? '');
        if ($created_at_start != null && $created_at_end != null && ($created_at_start != '' && $created_at_end != '')) {
            $query->where("DATE(s.created_at) >=", $created_at_start)
                    ->where("DATE(s.created_at) <=", $created_at_end);
        }

        $user_id = trim($request->getGet('user_id') ?? '');
        if ($user_id != null && !empty($user_id)) {
            $query->where('s.user_id', $user_id);
        }
		
		$plan_id = trim($request->getGet('plan_id') ?? '');
        if ($plan_id != null && !empty($plan_id)) {
            $query->where('s.plan_id', $plan_id);
        }
		
        return $query;
    }	
    public function filter_paypal_sales($query)
    {
        $request = service('request');
        $search = trim($request->getGet('search') ?? '');
        if (!empty($search)) {
            $query->groupStart()
             ->orLike('u.fullname', $search)
             ->orLike('s.subscription_id', $search)
             ->orLike('s.transaction_id', $search)
             ->groupEnd();
        }
		
		$created_at_start = trim($request->getGet('created_at_start') ?? '');
        $created_at_end = trim($request->getGet('created_at_end') ?? '');
        if ($created_at_start != null && $created_at_end != null && ($created_at_start != '' && $created_at_end != '')) {
            $query->where("DATE(s.created_at) >=", $created_at_start)
                    ->where("DATE(s.created_at) <=", $created_at_end);
        }

        $provider_id = trim($request->getGet('provider_id') ?? '');
        if ($provider_id != null && !empty($provider_id)) {
            $query->where('s.user_id', $provider_id);
        }
        return $query;
    }	
	
    //get user by email status
    public function get_user_by_email_status($email_status)
    {

        $sql = "SELECT * FROM users WHERE users.email_status = ? AND users.created_at >= DATE(NOW() - INTERVAL 7 DAY) AND users.deleted_at IS NULL";
        $query = $this->db->query($sql, array(clean_str($email_status)));
        return $query->getResult();
    }
	
	public function save_report($data){
		return $this->db->table('report_profiles')->insert($data);
	}
	
	public function report_profiles(){
		$query = $this->db->table('report_profiles AS s')->select('s.*,u.business_name')->join('users u','u.id = s.user_id')->orderBy('s.id', 'DESC');
        return $query->get()->getResult();
	}
	
	public function update_hiring_status($hiring_status,$id){
		$id = clean_number($id);
        $data = array(
            'hiring_status' => $hiring_status
        );

        return $this->protect(false)->update($id, $data);
	}

    public function get_users_condition($where=array())
    {
		$query = "";
		if(!empty($where)){
			$query .= " AND (";
			foreach($where as $row){
				if($row == 'about_me'){
					$query .= "u.about_me = '' OR u.about_me IS NULL ";
				}else if($row == 'hours'){
					$query .= " OR h.id = '' OR h.id IS NULL ";
				}else if($row == 'images'){
					$query .= " OR i.id = '' OR i.id IS NULL ";
				}
			}
			$query .= ")";
		}
        $sql = "SELECT u.id,u.fullname,u.email,u.about_me,h.id as hid,i.id as imgid FROM users u LEFT JOIN hours_of_operation h ON h.user_id = u.id LEFT JOIN user_images i ON i.user_id = u.id WHERE u.id != 1 AND u.deleted_at IS NULL".$query." GROUP BY u.id";
        $query = $this->db->query($sql);
        return $query->getResult();        
    }
	
	public function get_cc_reminder_users()
    {

        $sql = "SELECT * FROM `users` WHERE `plan_id` = 1 AND ((users.email_cc_first = 0 AND users.created_at <= (NOW() - INTERVAL 2 HOUR)) OR (users.email_cc_sec = 0 AND users.created_at <= (NOW() - INTERVAL 2 DAY))) AND users.deleted_at IS NULL";
        $query = $this->db->query($sql);
        return $query->getResult();
    }
	
	public function get_first_listing_users()
    {
        $sql = "SELECT u.id, u.fullname, u.email, COUNT(p.id) AS total_products FROM users u LEFT JOIN products p ON p.user_id = u.id where u.email_cc_first = 0 AND u.created_at <= (NOW() - INTERVAL 1 HOUR) AND u.id != 1 GROUP BY u.id, u.fullname, u.email HAVING total_products = 0";
        $query = $this->db->query($sql);
        return $query->getResult();
    }
	
	public function get_first_listing_reminder_users()
    {
        $sql = "SELECT u.id, u.fullname, u.email, COUNT(p.id) AS total_products FROM users u LEFT JOIN products p ON p.user_id = u.id where u.id != 1 GROUP BY u.id, u.fullname, u.email HAVING total_products = 0";
        $query = $this->db->query($sql);
        return $query->getResult();
    }
	
	public function get_favorite_still_available_users()
	{
		$sql = "SELECT u.id, u.fullname, u.email, COUNT(p.product_id) AS total_products FROM users u LEFT JOIN user_favorites p ON p.user_id = u.id where u.id != 1 GROUP BY u.id, u.fullname, u.email HAVING total_products > 0";
        $query = $this->db->query($sql);
        return $query->getResult();
		
	}
	public function send_for_inactive_user_email()
	{
		$sql = "SELECT * FROM users WHERE last_seen <= NOW() - INTERVAL 1 MONTH AND deleted_at IS NULL AND id!=1";
        $query = $this->db->query($sql);
        return $query->getResult();
		
	}
	
	public function update_user_cc_reminder($id,$field){
		$id = clean_number($id);
        $data = array(
            $field => 1
        );

        return $this->protect(false)->update($id, $data);
	}
	public function get_canceled_users()
    {

        $sql = "SELECT * FROM `users` WHERE `plan_id` = 1 AND is_cancel = 1 AND users.deleted_at IS NULL";
        $query = $this->db->query($sql);
        return $query->getResult();
    }
}
