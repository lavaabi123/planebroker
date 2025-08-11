<?= $this->section('content') ?>
    <div class="bg-grey d-flex flex-column flex-lg-row">
	<?= $this->extend('layouts/main') ?>
        <?php echo $this->include('Common/_messages') ?>
		<?php $uri = current_url(true); ?>
		 
		 
		
		<div class="leftsidecontent" id="stickySection">
		<?php echo $this->include('Common/_sidemenu') ?>
		</div>
		<div class="rightsidecontent w-100 px-3">
			<div class="container-fluid pb-5">
			<div class="d-flex align-items-center justify-content-between my-4">
				<div class="titleSec">
					<h3 class="title-lg fw-bolder">Dashboard</h3>
				</div>
				<a class="text-primary fw-medium d-flex align-items-center gap-2" href="<?php echo base_url('help'); ?>"><img src="<?php echo base_url('assets/frontend/images/ohelp.png'); ?>" /> Help/Support</a>
			</div>
			<div class="row">
				<div class="col-md-6 mb-4">
					<div class="dbContent h-100 py-0 py-xl-4 d-flex flex-column justify-content-center">
						<div class="d-flex row row-cols-4 new_list py-3 row-gap-3">
							<div class="col-6 col-xl-3 text-center px-xl-1">
								<a href="<?php echo base_url('my-listing'); ?>">
									<div class="list-item">
										<img src="<?php echo base_url('assets/frontend/images/list.png'); ?>" />									
										<h5 class="mb-0 mt-2 title-sm fw-bolder">My Listings</h5>
									</div>
								</a>
							</div>
							<div class="col-6 col-xl-3 text-center px-xl-1">
								<a href="<?php echo !empty($user_detail->user_level) ? base_url('add-listing') : base_url('plan'); ?>">
									<div class="list-item">
										<img src="<?php echo base_url('assets/frontend/images/new.png'); ?>" />								
										<h5 class="mb-0 mt-2 title-sm fw-bolder">Create <br>New Listing</h5>
									</div>
								</a>
							</div>
							<div class="col-6 col-xl-3 text-center px-xl-1">
								<a href="<?php echo base_url('messages'); ?>">
									<div class="list-item">
										<img src="<?php echo base_url('assets/frontend/images/imsg.png'); ?>" />	
										<h5 class="mb-0 mt-2 title-sm fw-bolder">Messages</h5>
									</div>
								</a>
							</div>
							<div class="col-6 col-xl-3 text-center px-xl-1">
								<a href="<?php echo base_url('analytics'); ?>">
									<div class="list-item">
										<img src="<?php echo base_url('assets/frontend/images/analytics.png'); ?>" />
										<h5 class="mb-0 mt-2 title-sm fw-bolder">Analytics</h5>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 mb-4">
					<div class="dbContent h-100 py-3 d-flex flex-column justify-content-center">
					<?php if(!empty($provider_message)){ ?>
						<div class="row fs-6 fw-medium lmsg">
							<div class="col-md-4 px-md-0 text-center align-self-center">
								<img src="<?php echo base_url('assets/frontend/images/rimsg.png'); ?>" />
								<h6 class="fw-bolder mt-1">Latest Message</h6>
								<p class="date_time"><?php echo formatted_date($provider_message['created_at'],'m/d/Y h:i a'); ?></p>
							</div>
							<div class="col-md-8 ps-md-4">
								<p class="mb-0"><?php echo $provider_message['from_name']; ?><br/>
								<?php echo $provider_message['from_email']; ?><br/>
								<?php echo $provider_message['from_phone']; ?></p>
								<hr>
								<p class="mb-0"><?php $maxLength = 65;
								$message = $provider_message['from_message'];
								$shortMessage = strlen($message) > $maxLength ? substr($message, 0, $maxLength) . '...' : $message;
								echo $shortMessage; ?></p>
								<hr>
								<a href="<?php echo base_url('messages'); ?>">View Message</a>
							</div>
						</div>
					<?php }else{ ?>
						<div class="col-md-12 px-md-0 text-center align-self-center">
							<img src="<?php echo base_url('assets/frontend/images/rimsg.png'); ?>" />
							<h6 class="fw-bolder mt-1">No Recent Messages found.</h6>
						</div>
					<?php } ?>
					<?php if(!empty($inactive_subs_count)){ ?>
						<div class="col-md-12 px-md-0 text-center align-self-center">
							<a href="<?php echo base_url('subscriptions'); ?>"><h6 class="mt-1 red">You have <?= $inactive_subs_count; ?> inactive subscriptions!</h6></a>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
			
			<div class="dbContent">
				<div class="container-fluid px-0">
				<div class="filter_Sec">
				<div class="row table-filter-container fb-filter">
					<div class="col-sm-12 form-input">
						<?php //$uri = service('uri'); ?>
						<?php $RolesPermissionsModel = model('RolesPermissionsModel'); ?>
						<?php $request = \Config\Services::request(); ?>
						<?php //$url = !empty($uri->getSegment(3)) ? $uri->getSegment(2) . '/' . $uri->getSegment(3) : $uri->getSegment(2) ?>
						<?php echo ($uri->getTotalSegments() >= env('urlsegment') && !empty($uri->getSegment(env('urlsegment'))) && $uri->getSegment(env('urlsegment')) == 'groomer_dashboard') ? form_open(base_url(). '/providerauth/groomer_dashboard?name='.$_GET['name'], ['method' => 'GET']) : form_open(base_url(). '/dashboard/', ['method' => 'GET']); ?>  
						
						<input type="hidden" name="name" value="<?php echo !empty($request->getVar('name'))?$request->getVar('name'):''; ?>">
						
						<input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">    
						<div class="bg-grey form-section d-flex flex-wrap flex-xl-nowrap align-items-center justify-content-center justify-content-xl-between gap-2 rounded-5 p-3 mb-4 text-center text-xl-start">
						<div class="w-100 fs-6">Results for : <span id="dataforperiod"></span></div>
						<div class="form-group col-sm-7 col-xl-4">
							<input type="hidden" name="start" id="created_at_start" value="<?php echo $request->getVar('start'); ?>">
							<input type="hidden" name="end" id="created_at_end" value="<?php echo $request->getVar('end'); ?>">
							<input type="hidden" name="user_id_admin" id="user_id_admin" value="<?php echo !empty($id) ? $id : ""; ?>">
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
						<div class="col col-md-4 form-group d-flex gap-2 flex-wrap flex-sm-nowrap">
							<button type="submit" class="btn w-100 btn-primary"><?php echo trans("filter"); ?></button>
							 <a class="btn w-100 btn-primary" href="<?php echo base_url() . '/dashboard/'; ?>"><?php echo trans('Reset'); ?></a>
						</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
				</div>
				<div class="row sm-box">
                <!-- ./col -->
				<div class="col-lg-3 col-6 p-2">
					<div class="card border h-100 orange-box">
                    <!-- small box -->
                    <div class="card-body">				
						<div class="d-flex justify-content-between align-items-center">
							<h2 class="fw-bolder"><?php echo $view_count; ?></h2>
							<img src="<?php echo base_url('assets/frontend/images/ceye.png'); ?>" width="35px" />
						</div>
						<h6 class="ls-1">Total Views</h6>
						
                    </div>
					<a href="<?php echo base_url() . '/analytics/'; ?>"><div class="card-footer">More info <img src="<?php echo base_url('assets/frontend/images/minfo.png'); ?>" /></div></a>
					</div>
                </div>
				<div class="col-lg-3 col-6 p-2">
					<div class="card border h-100 green-box">
                    <!-- small box -->
                    <div class="card-body">						
						<div class="d-flex justify-content-between align-items-center">
							<h2 class="fw-bolder"><?php echo $form_count; ?></h2>
							<img src="<?php echo base_url('assets/frontend/images/gmsg.png'); ?>" width="35px" />
						</div>
						<h6 class="ls-1">Form Submissions</h6>
                    </div>
					<a href="<?php echo base_url() . '/analytics/'; ?>"><div class="card-footer">More info <img src="<?php echo base_url('assets/frontend/images/minfo.png'); ?>" /></div></a>
                    </div>
                </div>
				<div class="col-lg-3 col-6 p-2">
					<div class="card border h-100 blue-box">
                    <!-- small box -->
                    <div class="card-body">						
						<div class="d-flex justify-content-between align-items-center">
							<h2 class="fw-bolder"><?php echo $call_count; ?></h2>
							<img src="<?php echo base_url('assets/frontend/images/call.png'); ?>" width="35px" />
						</div>
						<h6 class="ls-1">People Called</h6>
                    </div>
					<a href="<?php echo base_url() . '/analytics/'; ?>"><div class="card-footer">More info <img src="<?php echo base_url('assets/frontend/images/minfo.png'); ?>" /></div></a>
					</div>
                </div>
				<div class="col-lg-3 col-6 p-2">
					<div class="card border h-100 red-box">
                    <!-- small box -->
                    <div class="card-body">						
						<div class="d-flex justify-content-between align-items-center">
							<h2 class="fw-bolder"><?php echo $favorites_count; ?></h2>
							<img src="<?php echo base_url('assets/frontend/images/rheart.png'); ?>" width="35px" />
						</div>
						
						<h6 class="ls-1">Saved to Favorites</h6>
                    </div>
					<a href="<?php echo base_url() . '/analytics/'; ?>"><div class="card-footer">More info <img src="<?php echo base_url('assets/frontend/images/minfo.png'); ?>" /></div></a>
					</div>
                </div>
				
				</div>	 
				<div class="row mt-5 d-none">
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
							
				<div class="row mt-5 d-none">
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
							
				<div class="row mt-5 d-none">
					<h5>Potential Customers</h5>
					<div id="map" class="p-3 mt-2 m-auto" style="height:400px;width:97%;border-radius:10px">
					</div>
				</div>
			
			<div class="row d-none">
				<div class="col-xl-6 mt-3">
					<div class="d-flex">
						<p class="d-flex flex-column">
							<strong>Top 20 Recent Searches of your profile</strong>
						</p>
					</div>
					<div class="table-responsive">
					<?php if(!empty($recent_payments)){ ?>
					<table class="table text-nowrap table-hover">
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
					<table class="table text-nowrap table-hover">
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