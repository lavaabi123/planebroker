<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Models\NewsletterSubscriberModel;

class Newsletter extends AdminController
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
    protected $model;
    
    public function __construct()
    {
        $this->model = new NewsletterSubscriberModel();
        // Add your admin authentication check here
    }
    
    /**
     * Display newsletter subscribers list
     */
    public function index()
    {
        $data = array_merge($this->data,[
            'title' => 'Newsletter Subscribers',
            'contacts' => json_decode(json_encode($this->model->orderBy('subscribed_at', 'DESC')->findAll()))
        ]);
        
        return view('admin/contacts/newsletters', $data);
    }
    
    /**
     * Export subscribers
     */
    public function export($format = 'csv')
    {
        // Add authentication check
        // if (!$this->checkAdminAuth()) {
        //     return redirect()->to('admin/login');
        // }
        
        $subscribers = $this->model->exportSubscribers();
        
        if ($format === 'excel') {
            return $this->exportExcel($subscribers);
        } else {
            return $this->exportCSV($subscribers);
        }
    }
    
    /**
     * Export as CSV
     */
    private function exportCSV($subscribers)
    {
        $filename = 'newsletter_subscribers_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8 (helps with Excel)
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Add headers
        fputcsv($output, [
            'First Name', 
            'Last Name', 
            'Email', 
            'Subscribed Date',
        ]);
        
        // Add data
        foreach ($subscribers as $subscriber) {
            fputcsv($output, [
                $subscriber['first_name'],
                $subscriber['last_name'],
                $subscriber['email'],
                $subscriber['subscribed_at'],
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    /**
     * Export as Excel (HTML table that Excel can open)
     */
    private function exportExcel($subscribers)
    {
        $filename = 'newsletter_subscribers_' . date('Y-m-d_His') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        echo '<?xml version="1.0"?>';
        echo '<ss:Workbook xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">';
        echo '<ss:Worksheet ss:Name="Subscribers">';
        echo '<ss:Table>';
        
        // Header row
        echo '<ss:Row>';
        echo '<ss:Cell><ss:Data ss:Type="String">First Name</ss:Data></ss:Cell>';
        echo '<ss:Cell><ss:Data ss:Type="String">Last Name</ss:Data></ss:Cell>';
        echo '<ss:Cell><ss:Data ss:Type="String">Email</ss:Data></ss:Cell>';
        echo '<ss:Cell><ss:Data ss:Type="String">Subscribed Date</ss:Data></ss:Cell>';
        echo '</ss:Row>';
        
        // Data rows
        foreach ($subscribers as $subscriber) {
            echo '<ss:Row>';
            echo '<ss:Cell><ss:Data ss:Type="String">' . htmlspecialchars($subscriber['first_name']) . '</ss:Data></ss:Cell>';
            echo '<ss:Cell><ss:Data ss:Type="String">' . htmlspecialchars($subscriber['last_name']) . '</ss:Data></ss:Cell>';
            echo '<ss:Cell><ss:Data ss:Type="String">' . htmlspecialchars($subscriber['email']) . '</ss:Data></ss:Cell>';
            echo '<ss:Cell><ss:Data ss:Type="String">' . htmlspecialchars($subscriber['subscribed_at']) . '</ss:Data></ss:Cell>';
            echo '</ss:Row>';
        }
        
        echo '</ss:Table>';
        echo '</ss:Worksheet>';
        echo '</ss:Workbook>';
        
        exit;
    }
    
    /**
     * Delete a subscriber (optional)
     */
    public function delete($id)
    {
        // Add authentication and permission check
        
        if ($this->model->delete($id)) {
            session()->setFlashdata('success', 'Subscriber deleted successfully');
        } else {
            session()->setFlashdata('error', 'Failed to delete subscriber');
        }
        
        return redirect()->to('admin/newsletter');
    }
}