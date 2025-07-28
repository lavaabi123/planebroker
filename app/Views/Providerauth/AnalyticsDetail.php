<?= $this->section('content') ?>
    <div class="bg-grey d-flex flex-column flex-lg-row">
	<?= $this->extend('layouts/main') ?>
        <?php echo $this->include('Common/_messages') ?>
		<?php $uri = current_url(true); ?>
		 
		 
		
		<div class="leftsidecontent" id="stickySection">
		<?php echo $this->include('Common/_sidemenu') ?>
		</div>
		<div class="rightsidecontent w-100 px-3">
			<div class="container-fluid">
			<div class="titleSec">
				<h3 class="title-lg fw-bolder my-4">Analytics for <?php echo $results[0]['name']; ?></h3>
			</div>
			<div class="dbContent">
				<div class="container">
				<div class="filter_Sec">
				<div class="row table-filter-container fb-filter">
					<div class="col-sm-12 form-input">
						<?php //$uri = service('uri'); ?>
						<?php $RolesPermissionsModel = model('RolesPermissionsModel'); ?>
						<?php $request = \Config\Services::request(); ?>
						<?php //$url = !empty($uri->getSegment(3)) ? $uri->getSegment(2) . '/' . $uri->getSegment(3) : $uri->getSegment(2) ?>
						<?php echo form_open(base_url(). '/analytics?id='.$_GET['id'], ['method' => 'GET']); ?>  
						
						<input type="hidden" name="name" value="<?php echo !empty($request->getVar('name'))?$request->getVar('name'):''; ?>">
						
						<input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">    
						<div class="bg-grey form-section d-flex align-items-center justify-content-between gap-2 rounded-pill p-3 mb-4">
						<div class="me-sm-2">Results for : <span id="dataforperiod"></span></div>
						<div class="form-group me-sm-2">
							<input type="hidden" name="start" id="created_at_start" value="<?php echo $request->getVar('start'); ?>">
							<input type="hidden" name="end" id="created_at_end" value="<?php echo $request->getVar('end'); ?>">
							<input type="hidden" name="user_id_admin" id="user_id_admin" value="<?php echo !empty($id) ? $id : ""; ?>">
							<input type="hidden" name="id" id="product_id" value="<?php echo !empty($_GET['id']) ? $_GET['id'] : ""; ?>">
							<div id="reportrange" class="form-control mb-0">
								<i class="fa fa-calendar fs-5"></i>&nbsp;
								<span class="fs-6 TwCenMT">Start Date - End Date</span> <i class="fa fa-caret-down fs-4 pull-right"></i>
							</div>

							<script type="text/javascript">
							$(function() {

								//var start = moment().subtract(29, 'days');
								//var end = moment();

								var start = '';
								var end   = '';
								<?php if($request->getVar('start') !== null && $request->getVar('end') !== null
										&& $request->getVar('start') != '' && $request->getVar('end') != '') { ?>
											start = moment('<?php echo $request->getVar('start'); ?>');
											end = moment('<?php echo $request->getVar('end'); ?>');
								<?php } ?>

								function cb(start, end) {
									$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
									$('#created_at_start').val(start.format('YYYY-MM-DD'));
									$('#created_at_end').val(end.format('YYYY-MM-DD'));
								}

								//console.log(start);
								//console.log(end);
								if(start != '' && end != ''){
									cb(start, end);
								}    

								var start = moment().subtract(29, 'days');
								var end = moment();

								$('#reportrange').daterangepicker({
									startDate: start,
									endDate: end,
									ranges: {
									   'Today': [moment(), moment()],
									   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
									   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
									   'This Month': [moment().startOf('month'), moment().endOf('month')],
									   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
									}
								}, cb);                                           
							});
							</script>
						</div>
						<div class="col form-group d-flex gap-2 flex-wrap flex-sm-nowrap">
							<button type="submit" class="btn w-100 btn-primary"><?php echo trans("filter"); ?></button>
							 <a class="btn w-100 btn-primary" href="<?php echo base_url() . '/dashboard/'; ?>"><?php echo trans('Reset'); ?></a>
						</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
				</div>
<div class="row sm-box mb-5">
                <!-- ./col -->
				<div class="col-lg-4 col-6 p-2">
					<div class="card border border-2 rounded-5 h-100 orange-box">
						<!-- small box -->
						<div class="card-body">				
							<div class="d-flex justify-content-between align-items-center">
								<h2 class="fw-bolder"><?php echo $view_count; ?></h2>
								<img src="<?php echo base_url('assets/frontend/images/eye.png'); ?>" width="35px" />
							</div>
							<h6 class="ls-1">Total Views</h6>
							
						</div>
                    </div>
                </div>
				<div class="col-lg-4 col-6 p-2">
					<div class="card border border-2 rounded-5 h-100 blue-box">
						<!-- small box -->
						<div class="card-body">				
							<div class="d-flex justify-content-between align-items-center">
								<h2 class="fw-bolder"><?php echo $call_count; ?></h2>
								<img src="<?php echo base_url('assets/frontend/images/call.png'); ?>" width="35px" />
							</div>
							<h6 class="ls-1">Contact Button Clicks</h6>
							
						</div>
					</div>
                </div>
				<div class="col-lg-4 col-6 p-2">
					<div class="card border border-2 rounded-5 h-100 green-box">
						<!-- small box -->
						<div class="card-body">				
							<div class="d-flex justify-content-between align-items-center">
								<h2 class="fw-bolder"><?php echo $form_count; ?></h2>
								<img src="<?php echo base_url('assets/frontend/images/gmsg.png'); ?>" width="35px" />
							</div>
							<h6 class="ls-1">Form Submissions</h6>
							
						</div>
					</div>
                </div>
				
				<div class="col-lg-4 col-6 p-2">
					<div class="card border border-2 rounded-5 h-100 red-box">
						<!-- small box -->
						<div class="card-body">				
							<div class="d-flex justify-content-between align-items-center">
								<h2 class="fw-bolder"><?php echo $favorites_count; ?></h2>
								<img src="<?php echo base_url('assets/frontend/images/rheart.png'); ?>" width="35px" />
							</div>
							<h6 class="ls-1">Saved to Favorites</h6>
							
						</div>
                    </div>
                </div>
				
				<div class="col-lg-4 col-6 p-2">
					<div class="card border border-2 rounded-5 h-100 purple-box">
						<!-- small box -->
						<div class="card-body">				
							<div class="d-flex justify-content-between align-items-center">
								<h2 class="fw-bolder"><?php echo $reveal_count; ?></h2>
								<img src="<?php echo base_url('assets/frontend/images/unlock.png'); ?>" width="35px" />
							</div>
							<h6 class="ls-1">Phone Number Reveals / Clicks</h6>
							
						</div>
					</div>
                </div>
				
				<div class="col-lg-4 col-6 p-2">
					<div class="card border border-2 rounded-5 h-100 gold-box">
						<!-- small box -->
						<div class="card-body">				
							<div class="d-flex justify-content-between align-items-center">
								<h2 class="fw-bolder"><?php echo $share_count; ?></h2>
								<img src="<?php echo base_url('assets/frontend/images/ishare.png'); ?>" width="35px" />
							</div>
							<h6 class="ls-1">Share Count</h6>
							
						</div>
					</div>
                </div>
				</div>				
	
								<div class="row row-cols-1 row-cols-sm-2">
								  <div>
                                        <p class="d-flex flex-column">
                                            <h6 class="text-center">Profile Viewed</h6>
                                        </p>
									<canvas id="visitors-chart" style="height:300px;"></canvas>
								  </div>
								  <div>
                                        <p class="d-flex flex-column">
                                            <h6 class="text-center">Favorites</h6>
                                        </p>
									<canvas id="appears-chart" style="height:300px;"></canvas>
								  </div>
								  <div>
                                        <p class="d-flex flex-column">
                                            <h6 class="text-center">Form Submissions</h6>
                                        </p>
									<canvas id="form-chart" style="height:300px;"></canvas>
								  </div>
								  <div>
                                        <p class="d-flex flex-column">
                                            <h6 class="text-center">People Called</h6>
                                        </p>
									<canvas id="called-chart" style="height:300px;"></canvas>
								  </div>
								</div>
	
			
				</div>
				</div>
				</div>
		</div>
	</div>
<style>
.table-bordered tr, .table-bordered td, .table-bordered th{
  border: 1px solid #dee2e6;
}#visitors-chart,
#appears-chart {
  height: 300px !important;
  width: 100% !important;
}

</style>
<?= $this->endSection() ?>