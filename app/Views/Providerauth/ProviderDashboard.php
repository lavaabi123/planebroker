<?= $this->section('content') ?>
    <div class="bg-gray pt-2 pb-4 pb-xl-5">
	<?= $this->extend('layouts/main') ?>
        <?php echo $this->include('Common/_messages') ?>
		<?php $uri = current_url(true); ?>
		 
		 
		<div class="titleSec text-center mb-3 mb-xl-4">
			<h3 class="title-lg text-black mb-0 mb-sm-5">Welcome, <?php echo $user_detail->first_name; ?>!</h3>
		</div>
		<div class="container">
			<div class="row">
				<div class="leftsidecontent col-12 col-sm-4 col-lg-3" style="display:<?php echo ($uri->getTotalSegments() >= env('urlsegment') && !empty($uri->getSegment(env('urlsegment'))) && $uri->getSegment(env('urlsegment')) == 'groomer_dashboard') ? 'none !important' : ''; ?>">
				<?php echo $this->include('Common/_sidemenu') ?>
				</div>
				<div class="col-12 <?php echo ($uri->getTotalSegments() >= env('urlsegment') && !empty($uri->getSegment(env('urlsegment'))) && $uri->getSegment(env('urlsegment')) == 'groomer_dashboard') ? 'col-sm-12 col-lg-12' : 'col-sm-8 col-lg-9'; ?>">
				<div class="filter_Sec">
				<div class="row table-filter-container fb-filter">
					<div class="col-sm-12 form-input">
						<?php //$uri = service('uri'); ?>
						<?php $RolesPermissionsModel = model('RolesPermissionsModel'); ?>
						<?php $request = \Config\Services::request(); ?>
						<?php //$url = !empty($uri->getSegment(3)) ? $uri->getSegment(2) . '/' . $uri->getSegment(3) : $uri->getSegment(2) ?>
						<?php echo ($uri->getTotalSegments() >= env('urlsegment') && !empty($uri->getSegment(env('urlsegment'))) && $uri->getSegment(env('urlsegment')) == 'groomer_dashboard') ? form_open(base_url(). '/providerauth/groomer_dashboard?name='.$_GET['name'], ['method' => 'GET']) : form_open(base_url(). '/providerauth/dashboard/', ['method' => 'GET']); ?>  
						
						<input type="hidden" name="name" value="<?php echo !empty($request->getVar('name'))?$request->getVar('name'):''; ?>">
						
						<input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">    
						<div class="form-section d-flex align-items-center mb-4" style="float:right">
						<div class="me-2">Results for : <span id="dataforperiod"></span></div>
						<div class="form-group me-2">
							<input type="hidden" name="start" id="created_at_start" value="<?php echo $request->getVar('start'); ?>">
							<input type="hidden" name="end" id="created_at_end" value="<?php echo $request->getVar('end'); ?>">
							<input type="hidden" name="user_id_admin" id="user_id_admin" value="<?php echo !empty($id) ? $id : ""; ?>">
							<div id="reportrange" class="form-control mb-0">
								<i class="fa fa-calendar"></i>&nbsp;
								<span>Start Date - End Date</span> <i class="fa fa-caret-down"></i>
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
						<div class="col form-group">
							<button type="submit" class="btn btn-primary"><?php echo trans("filter"); ?></button>
							 <a class="btn btn-primary" href="<?php echo base_url() . '/providerauth/dashboard/'; ?>"><?php echo trans('Reset'); ?></a>
						</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
				</div>
				<div class="row">
                <!-- ./col -->
				<div class="col-lg-4 col-6 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<h6><i class="fa fa-eye me-2"></i>Impressions</h6>
						<p class="mt-4 fs-3 fw-bold"><?php echo $impression_count; ?></p>
                    </div>
					</div>
                </div>
				<div class="col-lg-4 col-6 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<h6><i class="fa fa-window-maximize me-2"></i>Profile Views</h6>
						<p class="mt-4 fs-3 fw-bold"><?php echo $view_count; ?></p>
                    </div>
                    </div>
                </div>
				<div class="col-lg-4 col-6 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<h6><i class="fa fa-phone me-2"></i>People Called</h6>
						<p class="mt-4 fs-3 fw-bold"><?php echo $call_count; ?></p>
                    </div>
					</div>
                </div>
				<div class="col-lg-4 col-6 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<h6><i class="fa fa-check-square me-2"></i>Submitted a Form</h6>
						<p class="mt-4 fs-3 fw-bold"><?php echo $form_count; ?></p>
                    </div>
					</div>
                </div>
				<div class="col-lg-4 col-6 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<h6><i class="fa fa-map-marker me-2"></i>Zipcode Searched</h6>
						<p class="mt-4 fs-3 fw-bold"><?php echo $zipcode_count; ?></p>
						</div>
                    </div>
                </div>
				<div class="col-lg-4 col-6 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<h6><i class="fa fa-arrows me-2"></i>Get Directions Clicked</h6>
						<p class="mt-4 fs-3 fw-bold"><?php echo $direction_count; ?></p>
                    </div>
					</div>
                </div>
				</div>	 <div class="row mt-5">
                                <div class="col-md-8">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <strong>Profile Viewed</strong>
                                        </p>

                                    </div>

                                    <div class="position-relative">
                                        <canvas id="visitors-chart" height="300"></canvas>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-center">
                                        <strong>Top 5 Zipcodes Searched</strong>
                                    </p>
                                    <div class="chart">
                                        <canvas id="donutChart" height="300"></canvas>
                                    </div>
                                </div>
                            </div>	
							
							<div class="row mt-5">
                                <div class="col-md-7">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <strong>Impressions</strong>
                                        </p>

                                    </div>

                                    <div class="position-relative">
                                        <canvas id="appears-chart" height="200"></canvas>

                                    </div>
                                </div>
								<div class="col-xl-5 mt-3">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <strong>Top Customers Locations</strong>
                                        </p>

                                    </div>
									<div class="card custom-card">
										<div class="card-body" style="font-size: 14px;">
											<ul class="list-unstyled crm-top-deals mb-0">
											<?php if(!empty($top_locations)){
												foreach($top_locations as $top_location){ if(!empty($top_location->city)){	?>
												<li class="mt-3">
													<div class="d-flex align-items-top flex-wrap">
														<div class="flex-fill">
															<p class="mb-0"><?php echo $top_location->city.', '.$top_location->state_code.' '.$top_location->zipcode; ?></p>
														</div>
														<div class="fs-15"><?php echo $top_location->user_count.' Customers'; ?></div>
													</div>
												</li>
												<?php } } }else{
												echo 'No Records Found';
											} ?>
											</ul>
										</div>
									</div>
								</div>
                            </div>
							
					<div class="row mt-5">
						<h5>Potential Customers</h5>
						<div id="map" class="p-3 mt-2 m-auto" style="height:400px;width:97%;border-radius:10px">
						</div>
					</div>
			<hr>
			<div class="row">
				<div class="col-xl-6 mt-3">
					<div class="d-flex">
						<p class="d-flex flex-column">
							<strong>Top 20 Recent Searches of your profile</strong>
						</p>
					</div>
					<div class="table-responsive">
					<?php if(!empty($recent_payments)){ ?>
					<table class="table text-nowrap table-hover border table-bordered">
						<thead>
							<tr>
								<th scope="col" style="font-weight: 600!important;">Users Zipcode</th>
								<th scope="col" style="font-weight: 600!important;">Date</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						foreach($recent_payments as $r => $recent_payment){	?>
						<tr>
							<td><?php echo $recent_payment->customer_zipcode; ?></td>
							<td><?php echo formatted_date($recent_payment->created_at,'m/d/Y h:i a'); ?></td>
						</tr>
						<?php } ?>
						</tbody>
					</table>	
					<?php }else{
						echo 'No Records Found';
					} ?>
					</div>
				</div><div class="col-xl-6 mt-3">
					<div class="d-flex">
						<p class="d-flex flex-column">
							<strong>Top 20 Recent Calls</strong>
						</p>
					</div>
					<div class="table-responsive">
					<?php if(!empty($top_calls)){ ?>
					<table class="table text-nowrap table-hover border table-bordered">
						<thead>
							<tr>
								<th scope="col" style="font-weight: 600!important;">Users Zipcode</th>
								<th scope="col" style="font-weight: 600!important;">Date</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						foreach($top_calls as $r => $top_call){	?>
						<tr>
							<td><?php echo !empty($top_call->customer_zipcode) ? $top_call->customer_zipcode : '-'; ?></td>
							<td><?php echo formatted_date($top_call->created_at,'m/d/Y h:i a'); ?></td>
						</tr>
						<?php } ?>
						</tbody>
					</table>	
					<?php }else{
						echo 'No Records Found';
					} ?>
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
}
</style>
<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVOEBebUkCDtSrIMdFekS9T9CcmRECNPo&libraries=visualization&callback=initMap">
</script>
<script>


$(document).ready(function() {
console.log('zxc');
    $('#hiring').change(function() {
        if($(this).is(":checked")) {
			var hiring_status = 1;
			$('.status-circle').show();	
        }else{
			var hiring_status = 0;
			$('.status-circle').hide();	
		}     
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>/providerauth/update_hiring_status',
			data:{csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',hiring_status:hiring_status},   
			dataType: 'HTML',
			beforeSend: function(){
				$('.loader').show();
			},
			success: function (data) {  
				$('.loader').hide();	
				if(data == 'success'){
					Swal.fire({
						text: "Updated Successfully!",
						icon: "success",
						confirmButtonColor: "#34c38f",
						confirmButtonText: "<?php echo trans("ok"); ?>",
					})
				}else{
					Swal.fire({
						text: "Failed!",
						icon: "success",
						confirmButtonColor: "#34c38f",
						confirmButtonText: "<?php echo trans("ok"); ?>",
					})
				}
			}
		});	           
    });
});
var data = <?php echo $zipcodes; ?>;
console.log(data[0][0]);
var lat = (data[0][0]) ? parseFloat(data[0][0]) : '36.1716';
var lng = (data[0][1]) ? parseFloat(data[0][1]) : '-115.1391';
let map, heatmap;

function initMap() {
	map = new google.maps.Map(document.getElementById("map"), {
	zoom: 7,
	center: { lat: lat, lng: lng },
	disableDefaultUI: true,
	});

	var i; var arraino = [];
	for (i = 0; i < data.length; ++i) {
	console.log(data[i]);
	arraino.push(new google.maps.LatLng(
			parseFloat(data[i][0]),
			parseFloat(data[i][1])) );
	}
	console.log(arraino);
	heatmap = new google.maps.visualization.HeatmapLayer({
		data: arraino,
		map: map,
	});
}

window.initMap = initMap;
</script>
<?= $this->endSection() ?>