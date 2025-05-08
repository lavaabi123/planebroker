  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?php echo admin_url(); ?>" class="brand-link">
          <img src="<?php echo base_url(); ?>/assets/img/logo.png" alt="Plane Broker Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light"><?php echo get_general_settings()->application_name ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->


          <!-- SidebarSearch Form -->
          <?php /*<div class="form-inline mt-3">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div> */ ?>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <?php foreach ($MenuCategory as $mCategory) : ?>
                      <li class="nav-header"> <?php echo $mCategory['menu_category']; ?></li>
                      <?php
                        $Menu = getMenu($mCategory['menuCategoryID'], user()->role);
						//echo "<pre>";print_r($Menu);
                        foreach ($Menu as $menu) :
                            if ($menu['parent'] == 0) :
                              //&& $menu['title'] != 'locations' && $menu['title'] != 'locations_base'
                              if($menu['title'] != 'general_settings' && $menu['title'] != 'menu_management' && $menu['title'] != 'roles_permissions' && $menu['title'] != 'language_settings'):

                                $parentMenuUrl = $menu['url'];

                                 if($segment == 'skills'):
                                  $segment = 'categories';    
                                 elseif($parentMenuUrl == 'locations/county'):
                                  $parentMenuUrl = 'locations';                                  
                                 endif;

                        ?>
                              <li class="nav-item">
                                  <a href="<?php echo admin_url() . $menu['url'] ?>" class="nav-link <?php echo ($segment == $parentMenuUrl) ? 'active' : ''; ?>">
                                      <i class="nav-icon <?php echo $menu['icon']; ?>"></i>
                                      <p><?php echo trans($menu['title']); ?></p>
                                  </a>
                              </li>
                          <?php
                               endif;
                            else :
                                $SubMenu =  getSubMenu($menu['menu_id'], user()->role);

                                 $parentMenuUrl = $menu['url'];
                                 if($segment == 'emails'):
                                  $segment = 'emailtemplates';                                  
                                 endif;

                                 if($menu['title'] == 'emailtemplates'):
                                  $menu['title'] = 'emails';
                                 endif;
                            ?>
                              <li class="nav-item <?php echo ($segment == $parentMenuUrl) ? 'menu-open' : ''; ?>">
                                  <a href="#" class="nav-link <?php echo ($segment == $parentMenuUrl) ? 'active' : ''; ?>">
                                      <i class="nav-icon <?php echo $menu['icon']; ?>"></i>
                                      <p>
                                          <?php echo trans($menu['title']); ?>
                                          <i class="right fas fa-angle-left"></i>
                                      </p>
                                  </a>

                                  <ul class="nav nav-treeview">
                                      <!-- on submenu  -->
                                      <?php foreach ($SubMenu as $subMenu) : 
                                            if($subMenu['title'] != 'administrators'):
                                              if($subMenu['url'] == 'send-email'):
                                                $menu['url'] = 'emails';
                                              endif;

                                              //'list-emailtemplates'
                                              $subActiveCls = '';
                                              if($subsegment == $subMenu['url'] 
                                                  || ($subMenu['url'] == 'list-emailtemplates' && $subsegment == 'edit-emailtemplate')
                                                  || ($subMenu['url'] == 'list-providers' && $subsegment == 'edit-provider')){
                                                $subActiveCls = 'sub-active';
                                              }
                                        ?>
                                          <li class="nav-item">
                                              <a href="<?php echo admin_url() . $menu['url'] . '/' . $subMenu['url']; ?>" class="nav-link <?php echo $subActiveCls; ?>">
                                                  <i class="far fa-circle nav-icon"></i>
                                                  <p><?php echo trans($subMenu['title']); ?></p>

                                              </a>
                                          </li>

                                      <?php 
                                          endif;
                                          endforeach; ?>

                                  </ul>
                              </li>


                      <?php
                            endif;
                        endforeach;
                        ?>
                  <?php endforeach; ?>

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>