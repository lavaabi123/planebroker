<div class="row table-filter-container align-items-center">
    <div class="col-sm-10">
        <?php $uri = service('uri'); ?>
        <?php $RolesPermissionsModel = model('RolesPermissionsModel'); ?>
        <?php $request = \Config\Services::request(); ?>
        <?php $url = !empty($uri->getSegment(3)) ? $uri->getSegment(2) . '/' . $uri->getSegment(3) : $uri->getSegment(2) ?>
        <?php echo form_open(admin_url() . $url, ['method' => 'GET']); ?>


        <div class="item-table-filter" style="width: 80px; min-width: 80px;">
            <label><?php echo trans("show"); ?></label>
            <select name="show" class="form-control">
                <option value="15" <?php echo ($request->getVar('show') == '15') ? 'selected' : ''; ?>>15</option>
                <option value="30" <?php echo ($request->getVar('show') == '30') ? 'selected' : ''; ?>>30</option>
                <option value="60" <?php echo ($request->getVar('show') == '60') ? 'selected' : ''; ?>>60</option>
                <option value="100" <?php echo ($request->getVar('show') == '100') ? 'selected' : ''; ?>>100</option>
            </select>
        </div>

        <div class="item-table-filter item-table-filter-long">
            <label><?php echo trans("search"); ?></label>
            <input name="search" class="form-control" placeholder="<?php echo trans("search") ?>" type="search" value="<?php echo $request->getVar('search'); ?>">
        </div>
        <div class="item-table-filter">
            <label><?php echo trans("Status"); ?></label>
            <select name="status" class="form-control">
                <option value="" <?php echo ($request->getVar('status') == '') ? 'selected' : ''; ?>>All</option>
                <option value="1" <?php echo ($request->getVar('status') == '1') ? 'selected' : ''; ?>>Active</option>
                <option value="2" <?php echo ($request->getVar('status') == '2') ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>
        <input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">

        <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
            <label style="display: block">&nbsp;</label>
            <button type="submit" class="btn btn-primary"><?php echo trans("filter"); ?></button>
        </div>
        <?php echo form_close(); ?>
		
    </div>
	<div class="col-sm-2 float-right">
		<a href="<?php echo admin_url() . 'blog/add-blog/'; ?>"><button type="button" class="btn btn-primary">Add Blog</button></a>
	</div>
</div>