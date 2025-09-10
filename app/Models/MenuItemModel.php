<?php
namespace App\Models;

use CodeIgniter\Model;

class MenuItemModel extends Model
{
    protected $table         = 'menu_items';
    protected $allowedFields = [
        'menu_id','parent_id','type','title','url','route','entity_id',
        'target','rel','css_class','visible','sort_order','meta'
    ];
    protected $useTimestamps = true;

    public function getTreeBySlug(string $slug): array
    {
        $menu = model(MenuModel::class)->where('slug',$slug)->first();
        if (!$menu) return [];

        $rows = $this->where('menu_id',$menu['id'])
                     ->orderBy('parent_id','ASC')
                     ->orderBy('sort_order','ASC')
                     ->findAll();

        $byParent = [];
        foreach ($rows as $r) $byParent[$r['parent_id'] ?? 0][] = $r;

        $build = function($parentId) use (&$build,$byParent) {
            $branch = [];
            foreach ($byParent[$parentId] ?? [] as $node) {
                $node['children'] = $build($node['id']);
                $branch[] = $node;
            }
            return $branch;
        };
        return $build(0);
    }
}
