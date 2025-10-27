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
    $filename = 'newsletter_subscribers_' . date('Y-m-d_His') . '.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    require 'vendor/autoload.php';
    
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Subscribers');
    
    // Header row
    $sheet->setCellValue('A1', 'First Name');
    $sheet->setCellValue('B1', 'Last Name');
    $sheet->setCellValue('C1', 'Email');
    $sheet->setCellValue('D1', 'Subscribed Date');
    
    // Data rows
    $row = 2;
    foreach ($subscribers as $subscriber) {
        $sheet->setCellValue('A' . $row, $subscriber['first_name']);
        $sheet->setCellValue('B' . $row, $subscriber['last_name']);
        $sheet->setCellValue('C' . $row, $subscriber['email']);
        $sheet->setCellValue('D' . $row, $subscriber['subscribed_at']);
        $row++;
    }
    
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    
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