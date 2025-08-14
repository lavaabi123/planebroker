<?php

namespace App\Controllers\Admin;

use App\Models\RolesPermissionsModel;
use App\Models\AdModel;

class Ad extends AdminController
{
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
    public $file_count;
    public $file_per_page;
    protected $RolesPermissionsModel;
    public $data;
    protected $adModel;
    
    public function __construct()
    {
        $this->adModel = new AdModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title' => trans('Ads'),
        ]);

        //paginate
        $data['ads'] = $this->adModel->ads_list();


        return view('admin/ad/ad', $data);
    }

    public function add_ad()
    {
        $data = array_merge($this->data, [
            'title' => trans('Add Ad'),
        ]);

        return view('admin/ad/add_ad', $data);
    }

    /**
     * Add Email Template Post
     */
    public function add_ad_post()
    {
		$img_name = '';
		if(!empty($_FILES) && !empty($_FILES['image']['name'])){
			$img = $this->request->getFile('image');
			$img->move(FCPATH . 'uploads/ad');
			$img_name = $img->getName();
		}
		//add email template
		$id =  $this->adModel->add_ad($img_name);
		if ($id) {
			$this->session->setFlashData('success', trans("Ad Added Successfully"));
			return redirect()->to(admin_url().'ad');
		} else {
			$this->session->setFlashData('error', trans("msg_error"));
			return redirect()->back();
		}
        
    }

    /**
     * Edit Email Template
     */
    public function edit_ad($id)
    {

        $data = array_merge($this->data, [
            'title' => trans('Update Ad'),
            'ad'  => $this->adModel->get_ad_by_id($id),
        ]);

        if (empty($data['ad']->id)) {
            return redirect()->back();
        }

        return view('admin/ad/edit_ad', $data);
    }

    /**
     * Edit Email Template Post
     */
    public function edit_ad_post()
    {        			
		$img_name = '';
		if(!empty($_FILES) && !empty($_FILES['image']['name'])){
			$img = $this->request->getFile('image');
			$img->move(FCPATH . 'uploads/ad');
			$img_name = $img->getName();
		}
		if($img_name == ''){
			$img_name = $this->request->getVar('image_name');
		}
		 $data = array(
			'id' => $this->request->getVar('id')
		);
		if ($this->adModel->edit_ad($data["id"],$img_name)) {
			$this->session->setFlashData('success', trans("Ad Updated Successfully"));
			return redirect()->to(admin_url().'ad');
		} else {
			$this->session->setFlashData('errors', trans("msg_error"));
			return redirect()->back();
		}       
    }

    /**
     * Delete Email Template Post
     */
    public function delete_ad_post()
    {

        $id = $this->request->getVar('id');
        $emailtemplate = $this->adModel->asObject()->find($id);


        if ($this->adModel->delete_ad($id)) {
            $this->session->setFlashData('success', trans("Ad Deleted Successfully"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }


}
