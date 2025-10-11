<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesPermissionsModel extends Model
{
    protected $table            = 'user_role';
    protected $primaryKey       = 'id';

    protected $session;
    public $request;
    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
    }

    public function getRole($role_id = false)
    {
        if ($role_id) {
            return   $this->asObject()->find($role_id);
        }

        return $this->asObject()->findAll();
    }

    public function getRoles()
    {
        $sql = "SELECT * FROM $this->table WHERE role_name != ?";
        $query = $this->db->query($sql, array('Developer'));
        return $query->getResult();
    }

    public function get_role_by_name($role)
    {
        $sql = "SELECT * FROM $this->table WHERE role_name = ?";
        $query = $this->db->query($sql, array(clean_str($role)));
        return $query->getRow();
    }

    public function is_unique_role($role, $role_id = 0)
    {
        $role = $this->get_role_by_name($role);
        //if id doesnt exists
        if ($role_id == 0) {
            if (empty($role)) {
                return true;
            } else {
                return false;
            }
        }
        if ($role_id != 0) {
            if (!empty($role) && $role->id != $role_id) {
                return false;
            } else {
                return true;
            }
        }
    }

    // Add New Role 
    public function AddRole()
    {
        $data = array(
            'role_name' => $this->request->getVar('role_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        );

        return $this->builder()->insert($data);
    }

    //update Role
    public function UpdateRole($id)
    {
        $data = array(
            'role_name' => $this->request->getVar('role_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        );


        return $this->builder()->where('id', $id)->update($data);
    }

    //delete Role
    public function delete_role($id)
    {
        $id = clean_number($id);
        $role = $this->asObject()->find($id);
        if (!empty($role) && $role->id != 1) {
            return $this->delete($role->id);
        }
        return false;
    }

    public function checkUserAccess($id, int $options = 1)
    {
        if ($options === 1) {
            return  $this->db->table('user_access')
                ->where([
                    'role_id' => $id,
                ])
                ->countAllResults();
        }

        if ($options === 2) {
            return  $this->db->table('user_access')
                ->where([
                    'menu_category_id' => $id,
                ])
                ->countAllResults();
        }

        if ($options === 3) {
            return  $this->db->table('user_access')
                ->where([
                    'menu_id' => $id,
                ])
                ->countAllResults();
        }

        if ($options === 4) {
            return  $this->db->table('user_access')
                ->where([
                    'submenu_id' => $id,
                ])
                ->countAllResults();
        }
    }


    public function deleteUserPermission($id, $column = 'role_id')
    {
        return $this->db->table('user_access')->delete([$column => $id]);
    }



    public function getAccessMenuCategory($role)
    {		
		$sql = "SELECT id AS menuCategoryID,position_order from user_menu_category c where c.id in (select menu_category from user_menu where id in (select menu_id from user_access where role_id=? and menu_id>0)) OR c.id=1 order by c.position_order asc";
        $query = $this->db->query($sql, array($role));
        return $query->getResultArray();
    }

	public function getMenuPermission($role,$segment)
	{
        return $url_menu_id = $this->db->query("SELECT * from user_access where role_id = ? AND menu_id = (SELECT id from user_menu where url= ? limit 1)", array($role,$segment))->getRowArray();
    }

	public function getSubMenuPermission($role,$segment)
	{
        return $url_menu_id = $this->db->query("SELECT * from user_access where role_id = ? AND submenu_id = (SELECT id from user_submenu where url= ? )", array($role,$segment))->getRowArray();
    }
    public function getAccessMenu($role)
    {
        return $this->db->table('user_menu')
            ->join('user_access', 'user_menu.id = user_access.menu_id')
            ->where(['user_access.role_id' => $role])
            ->get()->getResultArray();
    }




    // CRUD PERMISSIONS 
    public function checkUserMenuCategoryAccess($dataAccess)
    {
        return  $this->db->table('user_access')
            ->where([
                'role_id' => $dataAccess['roleID'],
                'menu_category_id' => $dataAccess['menuCategoryID']
            ])
            ->countAllResults();
    }

    public function checkUserMenuAccess($dataAccess)
    {
        return  $this->db->table('user_access')
            ->where([
                'role_id' => $dataAccess['roleID'],
                'menu_id' => $dataAccess['menuID']
            ])
            ->countAllResults();
    }

    public function checkUserSubmenuAccess($dataAccess)
    {
        return  $this->db->table('user_access')
            ->where([
                'role_id' => $dataAccess['roleID'],
                'submenu_id' => $dataAccess['submenuID']
            ])
            ->countAllResults();
    }
    public function insertMenuCategoryPermission($dataAccess)
    {
        return $this->db->table('user_access')->insert(['role_id' => $dataAccess['roleID'], 'menu_category_id' => $dataAccess['menuCategoryID'],
                'is_edit' => $dataAccess['is_edit'],
                'is_view' => $dataAccess['is_view']]);
    }
	
    public function updateMenuPermission($dataAccess)
    {
		return $this->db->table('user_access')
        ->where([
            'role_id'    => $dataAccess['roleID'],
            'menu_id' => $dataAccess['menuID']
        ])
        ->update([
            'is_edit' => $dataAccess['is_edit'],
            'is_view' => $dataAccess['is_view']
        ]);
    }
	
    public function updateSubmenuPermission($dataAccess)
    {
        return $this->db->table('user_access')
        ->where([
            'role_id'    => $dataAccess['roleID'],
            'submenu_id' => $dataAccess['submenuID']
        ])
        ->update([
            'is_edit' => $dataAccess['is_edit'],
            'is_view' => $dataAccess['is_view']
        ]);
    }
	
    public function deleteMenuCategoryPermission($dataAccess)
    {
        return $this->db->table('user_access')->delete(['role_id' => $dataAccess['roleID'], 'menu_category_id' => $dataAccess['menuCategoryID'],
                'is_edit' => $dataAccess['is_edit'],
                'is_view' => $dataAccess['is_view']]);
    }

    public function insertMenuPermission($dataAccess)
    {
        return $this->db->table('user_access')->insert(['role_id' => $dataAccess['roleID'], 'menu_id' => $dataAccess['menuID'],
                'is_edit' => $dataAccess['is_edit'],
                'is_view' => $dataAccess['is_view']]);
    }
    public function deleteMenuPermission($dataAccess)
    {
        return $this->db->table('user_access')->delete(['role_id' => $dataAccess['roleID'], 'menu_id' => $dataAccess['menuID'],
                'is_edit' => $dataAccess['is_edit'],
                'is_view' => $dataAccess['is_view']]);
    }

    public function insertSubmenuPermission($dataAccess)
    {
        return $this->db->table('user_access')->insert(['role_id' => $dataAccess['roleID'], 'submenu_id' => $dataAccess['submenuID'],
                'is_edit' => $dataAccess['is_edit'],
                'is_view' => $dataAccess['is_view']]);
    }

    public function deleteSubmenuPermission($dataAccess)
    {
        return $this->db->table('user_access')->delete(['role_id' => $dataAccess['roleID'], 'submenu_id' => $dataAccess['submenuID'],
                'is_edit' => $dataAccess['is_edit'],
                'is_view' => $dataAccess['is_view']]);
    }
}
