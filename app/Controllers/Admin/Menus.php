<?php

namespace App\Controllers\Admin;

use App\Models\RolesPermissionsModel;
use App\Models\MenuModel;
use App\Models\MenuItemModel;

class Menus extends AdminController
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
    
    public function index()
    {
		$data = array_merge($this->data, [
            'title' => 'Navigation Menu',
			'menus' => model(MenuModel::class)->orderBy('name')->findAll(),
        ]);
        return view('admin/menus/index', $data);
    }

    public function edit($slug)
    {
        $menu = model(MenuModel::class)->where('slug',$slug)->first();
        if (!$menu) return redirect()->back()->with('error','Menu not found');

        $items = model(MenuItemModel::class)->where('menu_id',$menu['id'])
                    ->orderBy('parent_id')->orderBy('sort_order')->findAll();

        return view('admin/menus/edit', compact('menu','items'));
    }

    public function createItem()
{
    $data = $this->request->getPost([
      'menu_id','parent_id','type','title','url','route','entity_id','sort_order'
    ]);
    $data['parent_id'] = $data['parent_id'] ?: null;
    $id = model(\App\Models\MenuItemModel::class)->insert($data, true);
    return $this->response->setJSON(['id'=>$id, 'csrf'=>csrf_hash()]);
}

public function deleteItem()
{
    $id = (int)$this->request->getPost('id');
    if ($id) model(\App\Models\MenuItemModel::class)->delete($id, true);
    return $this->response->setJSON(['ok'=>1, 'csrf'=>csrf_hash()]);
}

public function reorder()
{
    $payload = $this->request->getJSON(true) ?: $this->request->getPost();
    $tree = $payload['tree'] ?? $payload; // accept either
    $items = model(\App\Models\MenuItemModel::class);

    $apply = function($nodes,$parent=null) use (&$apply,$items){
      $i=1; foreach($nodes as $n){
        $items->update((int)$n['id'], ['parent_id'=>$parent,'sort_order'=>$i++]);
        if (!empty($n['children'])) $apply($n['children'], (int)$n['id']);
      }
    };
    $apply($tree, null);
    return $this->response->setJSON(['ok'=>1, 'csrf'=>csrf_hash()]);
}
}
