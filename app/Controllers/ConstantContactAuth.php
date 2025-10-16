<?php

namespace App\Controllers;

class ConstantContactAuth extends BaseController
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    
    public function __construct()
    {
        $this->clientId = env('CONSTANT_CONTACT_CLIENT_ID');
        $this->clientSecret = env('CONSTANT_CONTACT_CLIENT_SECRET');
        $this->redirectUri = base_url('constant-contact/callback');
    }
    
    /**
     * Step 1: Redirect to Constant Contact authorization page
     */
    public function authorize()
    {
        $authUrl = 'https://authz.constantcontact.com/oauth2/default/v1/authorize';
        
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => 'contact_data offline_access',
            'state' => bin2hex(random_bytes(16)) // CSRF protection
        ];
        
        session()->set('oauth_state', $params['state']);
        
        $url = $authUrl . '?' . http_build_query($params);
        return redirect()->to($url);
    }
    
    /**
     * Step 2: Handle callback and exchange code for access token
     */
    public function callback()
    {
        $code = $this->request->getGet('code');
        $state = $this->request->getGet('state');
        
        // Verify state for CSRF protection
        if (!$code || $state !== session()->get('oauth_state')) {
            return 'Authorization failed or invalid state';
        }
        
        // Exchange authorization code for access token
        $tokenUrl = 'https://authz.constantcontact.com/oauth2/default/v1/token';
        
        $data = [
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret)
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            $tokens = json_decode($response, true);
            
            // Display tokens
            echo '<h2>Authorization Successful!</h2>';
            echo '<p>Copy these values to your .env file:</p>';
            echo '<pre>';
            echo 'CONSTANT_CONTACT_ACCESS_TOKEN=' . $tokens['access_token'] . "\n";
            echo 'CONSTANT_CONTACT_REFRESH_TOKEN=' . $tokens['refresh_token'] . "\n";
            echo 'Token expires in: ' . ($tokens['expires_in'] / 3600) . ' hours';
            echo '</pre>';
            
            // Optionally save to a file for backup
            $tokenFile = WRITEPATH . 'constant_contact_tokens.json';
            file_put_contents($tokenFile, json_encode($tokens, JSON_PRETTY_PRINT));
            echo '<p><strong>Tokens also saved to:</strong> ' . $tokenFile . '</p>';
            
        } else {
            echo '<h2>Token Exchange Failed</h2>';
            echo '<pre>' . $response . '</pre>';
        }
    }
    
    /**
     * Refresh access token when it expires
     */
    public function refreshToken()
    {
        $refreshToken = env('CONSTANT_CONTACT_REFRESH_TOKEN');
        
        if (!$refreshToken) {
            return 'No refresh token found';
        }
        
        $tokenUrl = 'https://authz.constantcontact.com/oauth2/default/v1/token';
        
        $data = [
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret)
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            $tokens = json_decode($response, true);
            
            echo '<h2>Token Refreshed Successfully!</h2>';
            echo '<p>Update your .env file with the new access token:</p>';
            echo '<pre>';
            echo 'CONSTANT_CONTACT_ACCESS_TOKEN=' . $tokens['access_token'] . "\n";
            echo '</pre>';
            
            // Save to file
            $tokenFile = WRITEPATH . 'constant_contact_tokens.json';
            file_put_contents($tokenFile, json_encode($tokens, JSON_PRETTY_PRINT));
            
        } else {
            echo '<h2>Token Refresh Failed</h2>';
            echo '<pre>' . $response . '</pre>';
        }
    }
	// Add this method to your ConstantContactAuth controller
	public function getLists()
	{
		$accessToken = env('CONSTANT_CONTACT_ACCESS_TOKEN');
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.cc.email/v3/contact_lists');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Authorization: Bearer ' . $accessToken,
			'Content-Type: application/json'
		]);
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		$lists = json_decode($response, true);
		
		echo '<h2>Your Contact Lists:</h2>';
		echo '<pre>' . print_r($lists, true) . '</pre>';
	}
	
	public function migrateToDatabase()
	{
		$tokenModel = new \App\Models\ApiTokenModel();
		
		$accessToken = env('CONSTANT_CONTACT_ACCESS_TOKEN');
		$refreshToken = env('CONSTANT_CONTACT_REFRESH_TOKEN');
		
		if (!$accessToken || !$refreshToken) {
			echo '<h2>Error</h2>';
			echo '<p>No tokens found in .env file. Please run the authorization flow first.</p>';
			return;
		}
		
		$result = $tokenModel->updateToken(
			'constant_contact',
			$accessToken,
			$refreshToken,
			86400 // 24 hours
		);
		
		if ($result) {
			echo '<h2>Success!</h2>';
			echo '<p>Tokens have been migrated to the database.</p>';
			echo '<p>You can now optionally remove these lines from your .env file:</p>';
			echo '<pre>';
			echo 'CONSTANT_CONTACT_ACCESS_TOKEN=...' . "\n";
			echo 'CONSTANT_CONTACT_REFRESH_TOKEN=...' . "\n";
			echo '</pre>';
			echo '<p><strong>Note:</strong> Keep CLIENT_ID and CLIENT_SECRET in .env</p>';
		} else {
			echo '<h2>Error</h2>';
			echo '<p>Failed to save tokens to database.</p>';
		}
	}
}