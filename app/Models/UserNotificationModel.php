<?php
namespace App\Models;

use CodeIgniter\Model;

class UserNotificationModel extends Model
{
    protected $table          = 'user_notifications';
    protected $primaryKey     = 'id';
    protected $useTimestamps  = true;
    protected $allowedFields  = ['notification_id','user_id','is_read','read_at'];

    public function unreadCountFor(int $userId): int
    {
        return $this->where(['user_id'=>$userId, 'is_read'=>0])->countAllResults();
    }
}
