<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsletterSubscriberModel extends Model
{
    protected $table = 'newsletter_subscribers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'email',
        'first_name',
        'last_name',
        'ip_address',
        'user_agent',
        'subscribed_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[newsletter_subscribers.email]',
        'first_name' => 'permit_empty|max_length[100]',
        'last_name' => 'permit_empty|max_length[100]',
    ];
    
    protected $validationMessages = [
        'email' => [
            'required' => 'Email address is required',
            'valid_email' => 'Please provide a valid email address',
            'is_unique' => 'This email is already subscribed to our newsletter'
        ]
    ];
    
    public function exportSubscribers()
    {
        return $this->orderBy('subscribed_at', 'DESC')->findAll();
    }
}