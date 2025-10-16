<?php
namespace App\Controllers;

use App\Models\NewsletterSubscriberModel;
use App\Libraries\ConstantContactService;

class Newsletter extends BaseController
{
    public function subscribe()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }
        
        $model = new NewsletterSubscriberModel();
        
        $data = [
            'email' => $this->request->getPost('email'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'subscribed_at' => date('Y-m-d H:i:s')
        ];
        
        // Validate and save to database
        if (!$model->save($data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $model->errors()
            ]);
        }
        
        // Add to Constant Contact
        $constantContactSuccess = false;
        $constantContactError = null;
        
        try {
            $constantContact = new ConstantContactService();
            $result = $constantContact->addContact(
                $data['email'],
                $data['first_name'],
                $data['last_name']
            );
            
            if ($result['success']) {
                $constantContactSuccess = true;
                log_message('info', 'Contact added to Constant Contact: ' . $data['email']);
            } else {
                $constantContactError = $result['error'];
                log_message('error', 'Failed to add contact to Constant Contact: ' . json_encode($result));
            }
        } catch (\Exception $e) {
            $constantContactError = $e->getMessage();
            log_message('error', 'Constant Contact Exception: ' . $e->getMessage());
        }
        
        // Set session to prevent popup from showing again
        session()->set('newsletter_subscribed', true);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Thank you for subscribing to our newsletter!',
            'debug' => [
                'database_saved' => true,
                'constant_contact_success' => $constantContactSuccess,
                'constant_contact_error' => $constantContactError
            ]
        ]);
    }
    
    // Add this method to test the API connection
    public function testApi()
	{
		$constantContact = new ConstantContactService();
		
		// Test with a valid email address
		$testEmail = 'john.doe.' . time() . '@example.com';
		
		echo '<h2>Testing Constant Contact API</h2>';
		echo '<p>Test Email: ' . $testEmail . '</p>';
		
		$result = $constantContact->addContact(
			$testEmail,
			'John',
			'Doe'
		);
		
		echo '<h3>API Response:</h3>';
		echo '<pre>';
		print_r($result);
		echo '</pre>';
		
		// Check .env values
		echo '<h2>Environment Variables:</h2>';
		echo '<pre>';
		echo 'ACCESS_TOKEN exists: ' . (env('CONSTANT_CONTACT_ACCESS_TOKEN') ? 'YES' : 'NO') . "\n";
		echo 'ACCESS_TOKEN (first 20 chars): ' . substr(env('CONSTANT_CONTACT_ACCESS_TOKEN'), 0, 20) . '...' . "\n";
		echo 'LIST_ID: ' . env('CONSTANT_CONTACT_LIST_ID') . "\n";
		echo 'CLIENT_ID exists: ' . (env('CONSTANT_CONTACT_CLIENT_ID') ? 'YES' : 'NO') . "\n";
		echo 'CLIENT_SECRET exists: ' . (env('CONSTANT_CONTACT_CLIENT_SECRET') ? 'YES' : 'NO') . "\n";
		echo 'REFRESH_TOKEN exists: ' . (env('CONSTANT_CONTACT_REFRESH_TOKEN') ? 'YES' : 'NO') . "\n";
		echo '</pre>';
		
		// Test finding a contact
		echo '<h2>Test Finding Contact:</h2>';
		echo '<p>Searching for: ' . $testEmail . '</p>';
		echo '<pre>';
		// Make the findContactByEmail method public temporarily or call it through reflection
		echo 'Contact search would be performed here';
		echo '</pre>';
	}
	public function testDatabaseTokens()
{
    $tokenModel = new \App\Models\ApiTokenModel();
    $tokenData = $tokenModel->getToken('constant_contact');
    
    echo '<h2>Token Status in Database:</h2>';
    if ($tokenData) {
        echo '<pre>';
        echo 'Service: ' . $tokenData['service_name'] . "\n";
        echo 'Access Token (first 30 chars): ' . substr($tokenData['access_token'], 0, 30) . '...' . "\n";
        echo 'Refresh Token exists: ' . ($tokenData['refresh_token'] ? 'YES' : 'NO') . "\n";
        echo 'Expires At: ' . $tokenData['expires_at'] . "\n";
        echo 'Is Expired: ' . ($tokenModel->isTokenExpired('constant_contact') ? 'YES' : 'NO') . "\n";
        echo 'Created At: ' . $tokenData['created_at'] . "\n";
        echo 'Updated At: ' . $tokenData['updated_at'] . "\n";
        echo '</pre>';
    } else {
        echo '<p>No tokens found in database.</p>';
    }
    
    // Test API call
    echo '<h2>Testing API Call:</h2>';
    $constantContact = new \App\Libraries\ConstantContactService();
    $result = $constantContact->addContact(
        'dbtest' . time() . '@example.com',
        'Database',
        'Test'
    );
    
    echo '<pre>';
    print_r($result);
    echo '</pre>';
}
    
    public function checkStatus()
    {
        return $this->response->setJSON([
            'subscribed' => session()->get('newsletter_subscribed') ?? false
        ]);
    }
    
    public function export()
    {
        // Add authentication check here
        $model = new NewsletterSubscriberModel();
        $subscribers = $model->exportSubscribers();
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="newsletter_subscribers_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Email', 'First Name', 'Last Name', 'Subscribed At', 'IP Address']);
        
        foreach ($subscribers as $subscriber) {
            fputcsv($output, [
                $subscriber['email'],
                $subscriber['first_name'],
                $subscriber['last_name'],
                $subscriber['subscribed_at'],
                $subscriber['ip_address']
            ]);
        }
        
        fclose($output);
        exit;
    }
}