<?php

use App\Models\MenuItemModel;

if (!function_exists('render_menu')) {
    function render_menu(
        string $slug,
        string $rootUlClass = 'navbar-nav ms-auto mb-2 mb-md-0 align-items-center flex-wrap-reverse justify-content-end',
        bool   $forceRefresh = false,
        bool   $wrapRoot = true   // <— NEW
    ): string {
        $cacheKey = "menu.$slug.html." . ($wrapRoot ? 'wrap' : 'nowrap');
        if ($forceRefresh) cache()->delete($cacheKey);
        if ($html = cache($cacheKey)) return $html;

        $tree = model(MenuItemModel::class)->getTreeBySlug($slug);

        $build = function(array $nodes, int $level = 0, bool $wrapRoot = true) use (&$build, $rootUlClass): string {
            if (!$nodes) return '';

            $isRoot = ($level === 0);
            $ulClass = $isRoot ? $rootUlClass : 'dropdown-menu';
            $out = $isRoot
                ? ($wrapRoot ? '<ul class="'.esc($ulClass).'">' : '')   // root: maybe skip the UL
                : '<ul class="dropdown-menu">';

            foreach ($nodes as $n) {
                if (empty($n['visible'])) continue;

                $hasChildren = !empty($n['children']);
                $url    = ($n['url'] == '#') ? base_url().'/#': ($n['url'] ? base_url($n['url']) : ($n['route'] ? route_to($n['route']) : base_url() ));
                $target = $n['target'] ?? '_self';
                $extra  = trim($n['css_class'] ?? '');

                $isActive = false;
                if ($url && $url !== '#') {
                    $current = str_replace('/index.php','',rtrim((string)current_url(), '/'));
                    $isActive = $current === rtrim((string)$url, '/');
                }

                if ($isRoot) {
                    if ($hasChildren) {
                        // ONE li that wraps toggle + dropdown menu
                        $out .= '<li class="nav-item dropdown '.esc($extra).'">';
						if (!empty($n['url']) && $n['url'] !== '#') {
							// HAS URL: text navigates, caret toggles (split)
							$out .= '<a class="nav-link'.($isActive?' active':'').'"'
								  . ' href="'.esc($url).'" target="'.esc($target).'"'
								  . ($isActive ? ' aria-current="page"' : '')
								  . '>'.esc($n['title']).'</a>';

							// Split toggle (no navigation)
							$out .= '<a class="dropdown-toggle dropdown-toggle-split caret-toggle"'
								  . ' href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">'
								  . '<span class="visually-hidden">Toggle dropdown</span></a>';
						} else {
							// NO URL: single toggle link (acts like a button)
							$out .= '<a class="nav-link dropdown-toggle'.($isActive?' active':'').'"'
								  . ' href="#" role="button" data-bs-toggle="dropdown"'
								  . ' data-bs-auto-close="outside" aria-expanded="false">'
								  . esc($n['title']).'</a>';
						}
                        $out .= $build($n['children'], 1, true);
                        $out .= '</li>';
                    } else {
                        $out .= '<li class="nav-item '.esc($extra).'">'
                              .   '<a class="nav-link'.($isActive?' active':'').'" href="'.esc($url).'" target="'.esc($target).'"'
                              .   ($isActive ? ' aria-current="page"' : '')
                              .   '>'.esc($n['title']).'</a></li>';
                    }
                } else {
                    // inside dropdown
                    if ($hasChildren) {
                        $out .= '<li class="dropdown-submenu '.esc($extra).'">'
                              .   '<a class="dropdown-item dropdown-toggle'.($isActive?' active':'').'" href="'.esc($url).'" target="'.esc($target).'">'
                              .   esc($n['title']).'</a>'
                              .   $build($n['children'], $level + 1, true)
                              . '</li>';
                    } else {
                        $out .= '<li><a class="dropdown-item'.($isActive?' active':'').'" href="'.esc($url).'" target="'.esc($target).'">'
                              .   esc($n['title']).'</a></li>';
                    }
                }
            }

            // close only if we opened
            if ($isRoot) {
                return $out . ($wrapRoot ? '</ul>' : '');
            }
            return $out . '</ul>';
        };

        $html = $build($tree, 0, $wrapRoot);
        cache()->save($cacheKey, $html, 300);
        return $html;
    }
}

function getMenu($menu_category_id, $role)
{
    $db       = \Config\Database::connect();
    $menu     =  $db->table('user_menu')
        ->orderBy('user_menu.position_order', 'ASC')
        ->join('user_access', 'user_menu.id = user_access.menu_id')
        ->where(['menu_category' => $menu_category_id, 'user_access.role_id' => $role])
        ->get()->getResultArray();
    return $menu;
}


function getSubMenu($menu_id, $role)
{
    $db       = \Config\Database::connect();
    $submenu  = $db->table('user_submenu')
        ->orderBy('user_submenu.position_order', 'ASC')
        ->join('user_access', 'user_submenu.id = user_access.submenu_id')
        ->where(['user_submenu.menu' => $menu_id, 'user_access.role_id' => $role])
        ->get()->getResultArray();
    return $submenu;
}
