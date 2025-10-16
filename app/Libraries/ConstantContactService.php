<?php
namespace App\Libraries;

use App\Models\ApiTokenModel;

class ConstantContactService
{
    private $accessToken;
    private $refreshToken;
    private $clientId;
    private $clientSecret;
    private $apiUrl = 'https://api.cc.email/v3';
    private $listId;
    private $tokenModel;
    
    public function __construct()
    {
        $this->clientId = env('CONSTANT_CONTACT_CLIENT_ID');
        $this->clientSecret = env('CONSTANT_CONTACT_CLIENT_SECRET');
        $this->listId = env('CONSTANT_CONTACT_LIST_ID');
        $this->tokenModel = new ApiTokenModel();
        
        // Load tokens from database
        $this->loadTokens();
    }
    
    /**
     * Load tokens from database or fallback to .env
     */
    private function loadTokens()
    {
        $tokenData = $this->tokenModel->getToken('constant_contact');
        
        if ($tokenData) {
            $this->accessToken = $tokenData['access_token'];
            $this->refreshToken = $tokenData['refresh_token'];
            
            // Check if token is expired or about to expire (within 5 minutes)
            if ($this->tokenModel->isTokenExpired('constant_contact', 300)) {
                log_message('info', 'Constant Contact token is expired or about to expire. Refreshing...');
                $this->refreshAccessToken();
            }
        } else {
            // Fallback to .env for initial setup
            $this->accessToken = env('CONSTANT_CONTACT_ACCESS_TOKEN');
            $this->refreshToken = env('CONSTANT_CONTACT_REFRESH_TOKEN');
            
            // Save to database for future use
            if ($this->accessToken && $this->refreshToken) {
                log_message('info', 'Migrating Constant Contact tokens from .env to database');
                $this->tokenModel->updateToken(
                    'constant_contact',
                    $this->accessToken,
                    $this->refreshToken,
                    86400 // 24 hours default
                );
            }
        }
    }
    
    /**
     * Add contact to Constant Contact list
     */
    public function addContact($email, $firstName = '', $lastName = '')
    {
        // First, check if contact exists
        $existingContact = $this->findContactByEmail($email);
        
        if ($existingContact) {
            // Update existing contact and add to list
            return $this->updateContact($existingContact['contact_id'], $firstName, $lastName);
        }
        
        // Create new contact
        $data = [
            'email_address' => [
                'address' => trim($email),
                'permission_to_send' => 'implicit'
            ],
            'create_source' => 'Contact',
            'list_memberships' => [$this->listId]
        ];
        
        if (!empty(trim($firstName))) {
            $data['first_name'] = trim($firstName);
        }
        
        if (!empty(trim($lastName))) {
            $data['last_name'] = trim($lastName);
        }
        
        $result = $this->makeRequest('/contacts', 'POST', $data);
        
        // If unauthorized, try refreshing token
        if (!$result['success'] && isset($result['http_code']) && $result['http_code'] === 401) {
            if ($this->refreshAccessToken()) {
                // Retry with new token
                return $this->makeRequest('/contacts', 'POST', $data);
            }
        }
        
        return $result;
    }
    
    /**
     * Find contact by email
     */
    public function findContactByEmail($email)
    {
        $result = $this->makeRequest('/contacts?email=' . urlencode($email) . '&status=all', 'GET');
        
        if ($result['success'] && isset($result['data']['contacts']) && count($result['data']['contacts']) > 0) {
            return $result['data']['contacts'][0];
        }
        
        return null;
    }
    
    /**
     * Update existing contact
     */
    private function updateContact($contactId, $firstName, $lastName)
    {
        $currentContact = $this->makeRequest('/contacts/' . $contactId, 'GET');
        
        if (!$currentContact['success']) {
            return $currentContact;
        }
        
        $contactData = $currentContact['data'];
        
        $data = [
            'email_address' => $contactData['email_address'],
            'update_source' => 'Contact',
            'list_memberships' => array_unique(array_merge(
                $contactData['list_memberships'] ?? [],
                [$this->listId]
            ))
        ];
        
        if (!empty(trim($firstName))) {
            $data['first_name'] = trim($firstName);
        } elseif (isset($contactData['first_name'])) {
            $data['first_name'] = $contactData['first_name'];
        }
        
        if (!empty(trim($lastName))) {
            $data['last_name'] = trim($lastName);
        } elseif (isset($contactData['last_name'])) {
            $data['last_name'] = $contactData['last_name'];
        }
        
        return $this->makeRequest('/contacts/' . $contactId, 'PUT', $data);
    }
    
    /**
     * Refresh access token and save to database
     */
    private function refreshAccessToken()
    {
        if (!$this->refreshToken) {
            log_message('error', 'Cannot refresh token: refresh_token is missing');
            return false;
        }
        
        $tokenUrl = 'https://authz.constantcontact.com/oauth2/default/v1/token';
        
        $data = [
            'refresh_token' => $this->refreshToken,
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
            $this->accessToken = $tokens['access_token'];
            
            // Update refresh token if provided (some APIs rotate refresh tokens)
            if (isset($tokens['refresh_token'])) {
                $this->refreshToken = $tokens['refresh_token'];
            }
            
            // Save to database
            $this->tokenModel->updateToken(
                'constant_contact',
                $this->accessToken,
                $this->refreshToken,
                $tokens['expires_in'] ?? 86400
            );
            
            log_message('info', 'Constant Contact token refreshed and saved to database successfully');
            
            return true;
        }
        
        log_message('error', 'Failed to refresh Constant Contact token (HTTP ' . $httpCode . '): ' . $response);
        return false;
    }
    
    /**
     * Make API request to Constant Contact
     */
    private function makeRequest($endpoint, $method = 'GET', $data = null)
    {
        $ch = curl_init();
        
        $headers = [
            'Authorization: Bearer ' . $this->accessToken,
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            log_message('error', 'cURL Error: ' . $error);
            return [
                'success' => false,
                'error' => $error,
                'http_code' => 0
            ];
        }
        
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return [
                'success' => true,
                'data' => json_decode($response, true),
                'http_code' => $httpCode
            ];
        } else {
            return [
                'success' => false,
                'error' => json_decode($response, true),
                'http_code' => $httpCode,
                'raw_response' => $response
            ];
        }
    }
}