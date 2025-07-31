<?php

namespace App\Controllers\Admin;

use App\Models\RolesPermissionsModel;
use App\Models\VideoModel;

class Video extends AdminController
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
    protected $videoModel;

    public function __construct()
    {
        $this->videoModel = new VideoModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title' => trans('Videos'),
        ]);

        //paginate
        $data['paginate'] = $this->videoModel->videoPaginate();
        $data['pager'] =  $data['paginate']['pager'];


        return view('admin/video/video', $data);
    }

    public function add_video()
    {
        $data = array_merge($this->data, [
            'title' => trans('Add Video'),
        ]);

        return view('admin/video/add_video', $data);
    }

    /**
     * Add Email Template Post
     */
    public function add_video_post()
    {
        $validation =  \Config\Services::validation();
			
        //validate inputs

        $rules = [
            'name' => [
                'label'  => trans('name'),
                'rules'  => 'required|min_length[4]|max_length[255]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'video_url' => [
                'label'  => trans('video_url'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],
        ];


        if ($this->validate($rules)) {
            //add email template
            $id =  $this->videoModel->add_video();
            if ($id) {
                $this->session->setFlashData('success', trans("Video Added Successfully"));
                return redirect()->to(admin_url().'video');
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
     * Edit Email Template
     */
    public function edit_video($id)
    {

        $data = array_merge($this->data, [
            'title' => trans('Update Video'),
            'video'  => $this->videoModel->get_video_by_id($id),
        ]);

        if (empty($data['video']->id)) {
            return redirect()->back();
        }

        return view('admin/video/edit_video', $data);
    }

    /**
     * Edit Email Template Post
     */
    public function edit_video_post()
    {
        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'name' => [
                'label'  => trans('name'),
                'rules'  => 'required|min_length[4]|max_length[255]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'video_url' => [
                'label'  => trans('video_url'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],
        ];

        if ($this->validate($rules)) {
			
             $data = array(
                'id' => $this->request->getVar('id')
            );
            if ($this->videoModel->edit_video($data["id"])) {
                $this->session->setFlashData('success', trans("Video Updated Successfully"));
                return redirect()->to(admin_url().'video');
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
     * Delete Email Template Post
     */
    public function delete_video_post()
    {

        $id = $this->request->getVar('id');
        $emailtemplate = $this->videoModel->asObject()->find($id);


        if ($this->videoModel->delete_video($id)) {
            $this->session->setFlashData('success', trans("Video Deleted Successfully"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }


}
