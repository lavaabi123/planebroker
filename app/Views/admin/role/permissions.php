<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?> - <?php echo $role->role_name ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>role-management"><?php echo trans('roles_permissions') ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif  ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover my-0">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th>View and Edit</th>
                                            <th>View Only</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($MenuCategories as $menuCategory) : 
										if ($menuCategory['id'] > 1) :
										?>
                                            
                                            <?php foreach ($Menus as $menu) : if ($menu['menu_category'] == $menuCategory['id']) : 
											$c_m = check_menu_access($role->id, $menu['id']);
											?>
                                                    <tr>
                                                        <td><?= $menu['title']; ?></td>
                                                        <td class="d-none d-md-table-cell">
														<div class="form-check">
                                                                <input <?php echo (user()->role ==1 || (!empty($menu_permission) && $menu_permission['is_edit'] == 1)) ? '':'disabled' ; ?> class="form-check-input menu_permission editcheck" type="checkbox" <?= (!empty($c_m) && $c_m->is_edit == 1)?'checked':'' ?> data-role="<?= $role->id ?>" data-menu="<?= $menu['id'] ?>">
                                                                
                                                            </div>
														</td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input <?php echo (user()->role ==1 || (!empty($menu_permission) && $menu_permission['is_edit'] == 1)) ? '':'disabled' ; ?> class="form-check-input menu_permission viewcheck" type="checkbox" <?= (!empty($c_m) && $c_m->is_view == 1)?'checked':'' ?> data-role="<?= $role->id ?>" data-menu="<?= $menu['id'] ?>">
                                                                
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php foreach ($Submenus as $subMenu) :  if ($menu['id'] == $subMenu['menu']) : 
													$cs_m = check_submenu_access($role->id, $subMenu['id']);
													?>
                                                            <tr>
                                                                <td>
                                                                    <p class="ml-4"> <?= $subMenu['title']; ?></p>
                                                                </td>
                                                                <td class="d-none d-md-table-cell">
                                                                    <div class="form-check">
																	<input <?php echo (user()->role ==1 || (!empty($menu_permission) && $menu_permission['is_edit'] == 1)) ? '':'disabled' ; ?> class="form-check-input submenu_permission editcheck" type="checkbox" <?= (!empty($cs_m) && $cs_m->is_edit == 1)?'checked':'' ?> data-role="<?= $role->id ?>" data-submenu="<?= $subMenu['id'] ?>">
																	
																</div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input <?php echo (user()->role ==1 || (!empty($menu_permission) && $menu_permission['is_edit'] == 1)) ? '':'disabled' ; ?> class="form-check-input submenu_permission viewcheck" type="checkbox" <?= (!empty($cs_m) && $cs_m->is_view == 1)?'checked':'' ?> data-role="<?= $role->id ?>" data-submenu="<?= $subMenu['id'] ?>" >
                                                                        
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                    <?php endif;
                                                    endforeach; ?>
                                            <?php endif;
                                            endforeach;
											endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>

</script>
<style>
.form-check-input{
	border: var(--bs-border-width) solid #1e446b;
}
</style>
<?php echo $this->endSection() ?>