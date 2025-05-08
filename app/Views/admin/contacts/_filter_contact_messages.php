<div class="row table-filter-container">
    <div class="col-sm-12">
        <?php $uri = service('uri'); ?>
        <?php $RolesPermissionsModel = model('RolesPermissionsModel'); ?>
        <?php $request = \Config\Services::request(); ?>
        <?php $url = !empty($uri->getSegment(3)) ? $uri->getSegment(2) . '/' . $uri->getSegment(3) : $uri->getSegment(2) ?>
        <?php echo form_open(admin_url() . $url, ['method' => 'GET']); ?>


        <div class="item-table-filter">
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
        <input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">

        <div class="item-table-filter md-top-10">
            <label style="display: block">&nbsp;</label>
            <button type="submit" class="btn btn-primary"><?php echo trans("filter"); ?></button>
             <a class="btn btn-primary" href="<?php echo admin_url() . 'contacts/'; ?>"><?php echo trans('Reset'); ?></a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>