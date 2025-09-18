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
      'menu_id','parent_id','type','title','url','entity_id','sort_order'
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
/*
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
}*/
public function reorder()
{
    $payload = $this->request->getJSON(true) ?: $this->request->getPost();
    $tree    = $payload['tree']    ?? [];
    $menu_id = (int)($payload['menu_id'] ?? 0);

    /** @var \App\Models\MenuItemModel $items */
    $items = model(\App\Models\MenuItemModel::class);

    $idMap = []; // "new-xxx" => real_int_id

    // Insert a node if needed; return its real id
    $ensureId = function(array $node, ?int $parentId) use ($items, $menu_id, &$idMap): int {
        $rawId = (string)($node['id'] ?? '');

        // New item? create it now using metadata from client
        if (strpos($rawId, 'new-') === 0) {
            $meta = $node['_new'] ?? [];
            $data = [
                'menu_id'    => $menu_id,
                'parent_id'  => $parentId,
                'sort_order' => 0, // set below
                'type'       => $meta['type'] ?? 'custom',
                'title'      => $meta['title'] ?? 'Untitled',
                'url'        => $meta['url'] ?? '',
                'entity_id'  => ($meta['entity_id'] ?? '') ?: null,
            ];
            $realId         = (int)$items->insert($data, true);
            $idMap[$rawId]  = $realId;
            return $realId;
        }

        // Existing
        return (int)$rawId;
    };

    // Recursively apply parents & sort_order
    $apply = function(array $nodes, ?int $parentId = null) use (&$apply, $ensureId, $items): void {
        $i = 1;
        foreach ($nodes as $node) {
            $id = $ensureId($node, $parentId);
            // set parent & sort for this node
            $items->update($id, ['parent_id' => $parentId, 'sort_order' => $i++]);
            // children
            if (!empty($node['children'])) {
                $apply($node['children'], $id);
            }
        }
    };

    $apply($tree, null);

    return $this->response->setJSON([
        'ok'    => 1,
        'idMap' => $idMap,          // client updates temp ids → real ids
        'csrf'  => csrf_hash(),
    ]);
}


}
