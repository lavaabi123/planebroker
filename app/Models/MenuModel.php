<?php
namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table         = 'menus';
    protected $allowedFields = ['name','slug','location','is_active'];
    protected $useTimestamps = true;
}
