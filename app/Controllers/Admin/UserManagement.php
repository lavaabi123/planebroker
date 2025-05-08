<?php

namespace App\Controllers\Admin;

use App\Models\Locations\CityModel;
use App\Models\Locations\CountyModel;
use App\Models\Locations\StateModel;
use App\Models\RolesPermissionsModel;
use App\Models\UsersModel;
use App\Models\CategoriesModel;
use App\Models\CategoriesSubModel;
use App\Models\CategoriesSkillsModel;
use App\Models\OfferingModel;
use App\Models\ClientTypesModel;
use App\Models\PlansModel;
use App\Models\ReportModel;
use App\Models\FieldsModel;

class UserManagement extends AdminController
{

    protected $cityModel;
    protected $stateModel;
    protected $countyModel;
    protected $ReportModel;
    protected $FieldsModel;

    public function __construct()
    {
        $this->cityModel = new CityModel();
        $this->stateModel = new StateModel();
        $this->countyModel = new CountyModel();
        $this->userModel = new UsersModel();
        $this->RolesPermissionsModel = new RolesPermissionsModel();
        $this->ReportModel = new ReportModel();
        $this->FieldsModel = new FieldsModel();
    }

    public function administrators()
    {


        $data = array_merge($this->data, [
            'title' => trans('administrators'),
        ]);


        $pagination = $this->paginate($this->userModel->get_paginated_admin_count());
        $data['users'] =   $this->userModel->get_paginated_admin($pagination['per_page'], $pagination['offset']);


        $data['paginations'] = $pagination['pagination'];



        return view('admin/users/administrators', $data);
    }

    public function users()
    {
        $request = service('request');
        
        $data = array_merge($this->data, [
            'title' => trans('users'),
        ]);
        $this->CategoriesModel = new CategoriesModel();
        $data['categories'] = $this->CategoriesModel->get_categories();
        //paginate
        $data['paginate'] = $this->userModel->userPaginate();
        $data['pager'] =  $data['paginate']['pager'];
        
        $data['search_location_id']   = '';
        $data['search_location_name'] = '';
        $location_data                = trim($request->getGet('location_id') ?? '');

        if ($location_data != null && $location_data != '') {
            $data['search_location_id'] = $location_data;

            $arrLocationData = explode('||',$location_data);
            $data['search_location_name'] = $arrLocationData[0].', '.$arrLocationData[1];
            
        }

        //$data['user_photos'] = $this->userModel->get_user_photos(12);

        return view('admin/users/users', $data);
    }

    public function add_user()
    {
        $data = array_merge($this->data, [
            'title' => trans('add_user'),
            'roles' => $this->RolesPermissionsModel->getRole(),
            'counties' => array(),//$this->countyModel->asObject()->where('status', 1)->findAll(),
        ]);

        $this->CategoriesModel = new CategoriesModel();
        $data['categories'] = $this->CategoriesModel->get_categories();
        $this->CategoriesSubModel = new CategoriesSubModel();
        $data['sub_categories'] = $this->CategoriesSubModel->get_categories();
        $data['categories_skills'] = array();
        $this->OfferingModel = new OfferingModel();
        $data['offering'] = $this->OfferingModel->get_offering();
        $this->ClientTypesModel = new ClientTypesModel();
        $data['client_types'] = $this->ClientTypesModel->get_client_types();
		
		//get dynamic fields
        $this->FieldsModel = new FieldsModel();
        $data['dynamic_fields'] = $this->FieldsModel->get_fields();
		

        return view('admin/users/add_users', $data);
    }

    /**
     * Add User Post
     */
    public function add_user_post()
    {
		//echo "<pre>";print_r($_POST);exit;
        $validation =  \Config\Services::validation();

        //validate inputs

        $rules = [
             'first_name' => [
                'label'  => trans('first_name'),
                'rules'  => 'required|max_length[100]|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    'regex_match' => 'The first name field should contain letters only.',
                ],
            ],
            'last_name' => [
                'label'  => trans('last name'),
                'rules'  => 'required|max_length[100]|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    'regex_match' => 'The last name field should contain letters only.',
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
            'location_id'    => [
                'label'  => trans('location'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],
            'mobile_no' => [
                'label'  => trans('telephone number'),
                'rules'  => 'required|numeric|min_length[10]|max_length[10]',
                //'rules'  => 'required|regex_match[/^\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$/]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'numeric' => 'The telephone number must be numeric.',
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    //'regex_match' => 'The telephone number field should be a valid US phone number.',
                ],
            ],
            'gender'    => [
                'label'  => trans('gender'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],        
            'clientele'    => [
                'label'  => trans('clientele'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],         
            'password'    => [
                'label'  => trans('password'),
                'rules'  => 'required|min_length[4]|max_length[200]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'password_confirm'    => [
                'label'  => trans('form_confirm_password'),
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'role'    => [
                'label'  => trans('role'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $email = $this->request->getVar('email');
            /*$username = $this->request->getVar('username');

            //is username unique
            if (!$this->userModel->is_unique_username($username)) {
                $this->session->setFlashData('form_data', $this->userModel->input_values());
                $this->session->setFlashData('error', trans("msg_username_unique_error"));
                return redirect()->back()->withInput();
            }*/
            //is email unique
            if (!$this->userModel->is_unique_email($email)) {
                $this->session->setFlashData('form_data', $this->userModel->input_values());
                $this->session->setFlashData('error', trans("message_email_unique_error"));
                return redirect()->back()->withInput();
            }

            //add user
            $id =  $this->userModel->add_user();
            if ($id) {
                $this->session->setFlashData('success', trans("msg_user_added"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Edit User
     */
    public function edit_user($id,$page)
    {

        $data = array_merge($this->data, [
            'title' => trans('update_profile'),
            'user_detail' => $this->userModel->get_user($id),
            'roles' => $this->RolesPermissionsModel->getRole(),
            //'counties' => $this->countyModel->asObject()->where('status', 1)->findAll(),
        ]);

        //$data["states"] = $this->stateModel->asObject()->where('county_id', $data['user_detail']->county_id)->findAll();
        //$data["cities"] = $this->cityModel->asObject()->where('state_id', $data['user_detail']->state_id)->findAll();

        //$data['user_detail'] = $this->userModel->get_user($this->session->get('vr_sess_user_id'));
        $this->CategoriesModel = new CategoriesModel();
        $data['categories'] = $this->CategoriesModel->get_categories();
        if(!empty($data['user_detail']->category_id)){
            $this->CategoriesSkillsModel = new CategoriesSkillsModel();
            $data['categories_skills'] = $this->CategoriesSkillsModel->get_categories_skills_by_category_id(1);
			$this->OfferingModel = new OfferingModel();
			$data['offering'] = $this->OfferingModel->get_offering_category_based(1);
        }else{
            $data['categories_skills'] = array();
			$data['offering'] = array();
        }
        $data['rate_details'] = $this->userModel->get_rate_details($id);
        $data['hours_of_operation'] = $this->userModel->get_hours_of_operation($id);
        $this->ClientTypesModel = new ClientTypesModel();
        $data['client_types'] = $this->ClientTypesModel->get_client_types();
		$data['page'] = $page;
        $data['user_photos'] = $this->userModel->get_user_photos($id);	
		
        $this->CategoriesSubModel = new CategoriesSubModel();
        $data['sub_categories'] = $this->CategoriesSubModel->get_categories();
		
		//get dynamic fields
        $this->FieldsModel = new FieldsModel();
        $data['dynamic_fields'] = $this->FieldsModel->get_fields();

        if (empty($data['user_detail']->id)) {
            return redirect()->back();
        }

        return view('admin/users/edit_user', $data);
    }

    /**
     * Edit User Post
     */
    public function edit_user_post()
    {


        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'first_name' => [
                'label'  => trans('first_name'),
                'rules'  => 'required|max_length[100]|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    'regex_match' => 'The first name field should contain letters only.',
                ],
            ],
            'last_name' => [
                'label'  => trans('last name'),
                'rules'  => 'required|max_length[100]|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    'regex_match' => 'The last name field should contain letters only.',
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
            'location_id'    => [
                'label'  => trans('location'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],
            'mobile_no' => [
                'label'  => trans('telephone number'),
                'rules'  => 'required|numeric|min_length[10]|max_length[10]',
                //'rules'  => 'required|regex_match[/^\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$/]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'numeric' => 'The telephone number must be numeric.',
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    //'regex_match' => 'The telephone number field should be a valid US phone number.',
                ],
            ],
            'gender'    => [
                'label'  => trans('gender'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],        
            'clientele'    => [
                'label'  => trans('clientele'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],         
            'role'    => [
                'label'  => trans('role'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],
        ];

        if (!empty($this->request->getVar('password'))) {
            $rules['password'] = [
                'label'  => trans('password'),
                'rules'  => 'required|min_length[4]|max_length[50]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ]
            ];

            $rules['password_confirm']    = [
                'label'  => trans('form_confirm_password'),
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),

                ],
            ];
        }

        if ($this->validate($rules)) {
            $data = array(
                'id' => $this->request->getVar('id'),
                'username' => $this->request->getVar('username'),
                'slug' => $this->request->getVar('slug'),
                'email' => $this->request->getVar('email')
            );

            //is email unique
            if (!$this->userModel->is_unique_email($data["email"], $data["id"])) {
                $this->session->setFlashData('errors_form', trans("message_email_unique_error"));
                return redirect()->back()->withInput();
            }
            //is username unique
            /*if (!$this->userModel->is_unique_username($data["username"], $data["id"])) {
                $this->session->setFlashData('errors_form', trans("msg_username_unique_error"));
                return redirect()->back()->withInput();
            }
            //is slug unique
            if ($this->userModel->check_is_slug_unique($data["slug"], $data["id"])) {
                $this->session->setFlashData('errors_form', trans("msg_slug_used"));
                return redirect()->back()->withInput();
            }*/
            $this->userModel->edit_user($data["id"]);
            $user = $this->userModel->update_user($data["id"]);
            if ($user) {
                $this->session->setFlashData('success', trans("msg_updated"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('errors', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Delete User Post
     */
    public function delete_user_post()
    {

        $id = $this->request->getVar('id');
        $user = $this->userModel->asObject()->find($id);



        if ($user->id == 1 || $user->id == user()->id) {
            $this->session->setFlashData('error', trans("msg_error"));
        }


        if ($this->userModel->delete_user($id)) {
            $this->session->setFlashData('success', trans("provider") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    /**
     * Ban User Post
     */
    public function ban_user_post()
    {

        $option = $this->request->getVar('option');
        $id = $this->request->getVar('id');

        $user = $this->userModel->asObject()->find($id);
        if ($user->id == 1 || $user->id == user()->id) {
            $this->session->setFlashData('error', trans("msg_error"));
        }

        //if option ban
        if ($option == 'ban') {
            if ($this->userModel->ban_user($id)) {
                $this->session->setFlashData('success', trans("msg_user_banned"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }

        //if option remove ban
        if ($option == 'remove_ban') {
            if ($this->userModel->remove_user_ban($id)) {
                $this->session->setFlashData('success', trans("msg_ban_removed"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }
    }

    /**
     * Confirm User Email
     */
    public function confirm_user_email()
    {
        $id = $this->request->getVar('id');
        $user = $this->userModel->asObject()->find($id);
        if ($this->userModel->verify_email($user)) {
            $this->session->setFlashData('success', trans("msg_updated"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    /** 
     * Change User Role
     */
    public function change_user_role_post()
    {
        if (!is_admin()) {
            return redirect()->to(admin_url());
        }
        $id = $this->request->getVar('user_id');
        $role = $this->request->getVar('role');
        $user = $this->userModel->asObject()->find($id);

        //check if exists
        if (empty($user)) {
            return redirect()->back();
        } else {
            if ($user->id == 1 || $user->id == user()->id) {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }

            if ($this->userModel->change_user_role($id, $role)) {
                $this->session->setFlashData('success', trans("msg_role_changed"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }
        }
    }

    public function photos(){
        $this->UsersModel = new UsersModel();
        $userId = $this->request->getVar('id');
        $data['user_detail'] = $this->UsersModel->get_user($userId);
        $data['user_photos'] = $this->UsersModel->get_user_photos($userId);
        $data['title'] = trans('Photos');
        return view('Providerauth/ProviderPhotos', $data);
    }
    public function photos_post(){
        if($this->request->getVar('check') == '1'){
            $userId = $this->request->getVar('id');
            $this->UsersModel = new UsersModel();
            $user_detail = $this->UsersModel->get_user($userId);
            $photos = $this->UsersModel->get_user_photos($userId);
            $response = '1';
            if($user_detail->plan_id == 1 || $user_detail->plan_id == 2){
                if(count($photos) > 0){
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
        }else{
            $userId = $this->request->getVar('id');
            $this->UsersModel = new UsersModel();
            $user = $this->UsersModel->insert_user_photos($this->request->getVar('image'),$userId);
            if ($user) {
                $photos = $this->UsersModel->get_user_photos($userId);
                $html = '';
                if(!empty($photos)){
                    if(count($photos) > 1){
						$html .= '<p>('.trans('Drag and drop to organize your photos').')</p>';
					}
					$html .= '<ul class="row" id="imageListId">';
                    foreach($photos as $row){
                        $html .= "<li class='col-4 listitemClass' id='imageNo".$row['id']."'><div class='pic'><img width='100%' height='150px' src='".base_url()."/uploads/userimages/".$userId."/".$row['file_name']."'></div><div class='trash' onclick='deletephotos(".$row['id'].")' data-id='".$row['id']."' style='cursor:pointer'><i class='fas fa-trash' style='color:#0056b3;'></i></div></li>";
                    }
                    $html .= '</ul>';
                }
                echo $html;
            } else {
                echo '2';
            }
        }
    }
    public function photos_delete(){
        if($this->request->getVar('photo_id') != ''){
            $userId = $this->request->getVar('id');
            $this->UsersModel = new UsersModel();
            $user = $this->UsersModel->delete_user_photos($this->request->getVar('photo_id'));
            if ($user) {
                $photos = $this->UsersModel->get_user_photos($userId);
                $html = '';
                if(!empty($photos)){
                    if(count($photos) > 1){
						$html .= '<p>('.trans('Drag and drop to organize your photos').')</p>';
					}
					$html .= '<ul class="row" id="imageListId">';
                    foreach($photos as $row){
                        $html .= "<li class='col-4 listitemClass' id='imageNo".$row['id']."'><div class='pic'><img width='100%' height='150px' src='".base_url()."/uploads/userimages/".$userId."/".$row['file_name']."'></div><div class='trash' onclick='deletephotos(".$row['id'].")' data-id='".$row['id']."' style='cursor:pointer'><i class='fas fa-trash' style='color:#0056b3;'></i></div></li>";
                    }
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

    public function provider_messages()
    {
        $data = array_merge($this->data, [
            'title' => trans('provider_messages'),
        ]);

        $pagination = $this->paginate($this->userModel->get_paginated_provider_messages_count());
        $data['provider_messages'] =   $this->userModel->get_paginated_provider_messages($pagination['per_page'], $pagination['offset']);

        $data['paginations'] = $pagination['pagination'];

        $data['providers'] = $this->userModel->get_users();

        return view('admin/users/provider_messages', $data);
    }
	
    public function sales()
    {
        $data = array_merge($this->data, [
            'title' => trans('Sales'),
        ]);

        $pagination = $this->paginate($this->userModel->get_paginated_sales_count());
        $data['sales'] =   $this->userModel->get_paginated_sales($pagination['per_page'], $pagination['offset']);
		$data['total_amount'] =   $this->userModel->get_total_amount_sales();
		
        $data['paginations'] = $pagination['pagination'];
		
		
		
		$pagination1 = $this->paginate($this->userModel->get_paginated_paypal_sales_count());
        $data['sales1'] =   $this->userModel->get_paginated_paypal_sales($pagination1['per_page'], $pagination1['offset']);
		$data['total_amount1'] =   $this->userModel->get_total_amount_paypal_sales();
		
        $data['paginations1'] = $pagination1['pagination'];
		
		
		

        $data['providers'] = $this->userModel->get_users();

        return view('admin/users/sales', $data);
    }
	
	
	
	
	public function report_profiles(){
		// Paginations
		$data = array_merge($this->data, [
            'title'     => trans('Report Profiles'),
            'active_tab'     => 'county',
        ]);
		
        $paginate = $this->ReportModel->DataPaginations();
        $data['report_profiles'] =   $paginate['report_profiles'];

        $data['paginations'] =  $paginate['pager']->Links('default', 'custom_pager');

		$data['report_profiles'] =   $this->userModel->report_profiles();
        return view('admin/users/report_profiles', $data);
	}
    public function bulk_delete_report_post()
    {
		
        $ids = $this->request->getVar('ids');

		if ($this->ReportModel->bulk_delete_report_profiles($ids)) {
			echo "1";
		} else {
			echo "2";
		}
    }
}
