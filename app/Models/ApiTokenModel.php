<?php
namespace App\Models;

use CodeIgniter\Model;

class ApiTokenModel extends Model
{
    protected $table = 'api_tokens';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'service_name',
        'access_token',
        'refresh_token',
        'expires_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    /**
     * Get token by service name
     */
    public function getToken($serviceName = 'constant_contact')
    {
        return $this->where('service_name', $serviceName)->first();
    }
    
    /**
     * Update or create token
     */
    public function updateToken($serviceName, $accessToken, $refreshToken, $expiresIn)
    {
        $expiresAt = date('Y-m-d H:i:s', time() + $expiresIn);
        
        $existing = $this->getToken($serviceName);
        
        $data = [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_at' => $expiresAt
        ];
        
        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            $data['service_name'] = $serviceName;
            return $this->insert($data);
        }
    }
    
    /**
     * Check if token is expired or about to expire
     */
    public function isTokenExpired($serviceName = 'constant_contact', $bufferSeconds = 300)
    {
        $tokenData = $this->getToken($serviceName);
        
        if (!$tokenData || !$tokenData['expires_at']) {
            return true;
        }
        
        $expiresAt = strtotime($tokenData['expires_at']);
        $now = time();
        
        // Consider expired if less than buffer time remaining (default 5 minutes)
        return ($expiresAt - $now) < $bufferSeconds;
    }
}