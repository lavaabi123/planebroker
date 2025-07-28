<?= $this->section('content') ?>
<div class="container py-3 mt-3">
<div class="row w-100 m-auto align-items-center justify-content-between">
<div class="col-4"><a class="navbar-brand col-sm-3 me-0" href="<?= base_url('/') ?>"><img class="img-fluid" title="CodeIgniter Logo" alt="Visit CodeIgniter.com official website!" src="<?= base_url('assets/img/logo.png') ?>"></a></div>
<div class="col-8" style="text-align:right"><a class="float-right font-weight-bold text-dark text-decoration-underline fs-7" href="<?php echo base_url('login'); ?>">Log In</a></div>
</div></div>
<div id="xcd" class="col-12 " >
	<div id="note" class="note">
	<div class="">
	<div class=""><img title="CodeIgniter Logo" alt="Visit CodeIgniter.com official website!" width="100%" src="<?= base_url('/') ?>/assets/img/weekly_report.jpg"></div>
	</div>
	<!--<div class="col-12 p-2">
	<h3 class="text-center fs-4"><?php echo !empty($from_cron) ? 'Hello' : 'Welcome'; ?>, <?php echo $user_detail->first_name; ?>!</h3>
	<h6 class="text-center fs-4 mt-4">Your Weekly Performance Snapshot (January 21, 2024 - January 28, 2024)</h6>
	</div>-->
	</div>
</div>
<style>
#gdpr-cookie-message{
	display:none !important;
}
.page-break {
            page-break-before: always; /* This will force a page break before the element */
        }
</style>
    <div class="bg-gray pt-2 pb-4 pb-xl-5">
	<?= $this->extend('layouts/main') ?>
        <?php echo $this->include('Common/_messages') ?>
		<?php $uri = current_url(true); ?>
		 
		<input type="hidden" name="start" id="created_at_start" value="<?php echo $startDate; ?>">
		<input type="hidden" name="end" id="created_at_end" value="<?php echo $endDate; ?>">
		<input type="hidden" name="user_id_admin" id="user_id_admin" value="<?php echo !empty($id_load) ? $id_load : ""; ?>">
		<div class="container">
			<h6 class="text-start mt-4" style="font-size: 16px;">Performance Summary</h6>
			<div class="row">
				<div class="col-12 <?php echo ($uri->getTotalSegments() >= env('urlsegment') && !empty($uri->getSegment(env('urlsegment'))) && $uri->getSegment(env('urlsegment')) == 'groomer_dashboard') ? 'col-sm-12 col-lg-12' : 'col-sm-12 col-lg-12'; ?>">
				
				<div class="row">
                <!-- ./col -->
				<div class="col-lg-4 col-4 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<p><strong><i class="fa fa-eye me-2"></i>Impressions</strong></p>
						<p class="my-2 fs-6 fw-bold"><?php echo $impression_count; ?></p>
                    </div>
					</div>
                </div>
				<div class="col-lg-4 col-4 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<p><strong><i class="fa fa-window-maximize me-2"></i>Profile Views</strong></p>
						<p class="my-2 fs-6 fw-bold"><?php echo $view_count; ?></p>
                    </div>
                    </div>
                </div>
				<div class="col-lg-4 col-4 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<p><strong><i class="fa fa-phone me-2"></i>People Called</strong></p>
						<p class="my-2 fs-6 fw-bold"><?php echo $call_count; ?></p>
                    </div>
					</div>
                </div>
				<div class="col-lg-4 col-4 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<p><strong><i class="fa fa-check-square me-2"></i>Submitted a Form</strong></p>
						<p class="my-2 fs-6 fw-bold"><?php echo $form_count; ?></p>
                    </div>
					</div>
                </div>
				<div class="col-lg-4 col-4 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<p><strong><i class="fa fa-map-marker me-2"></i>Zipcode Searched</strong></p>
						<p class="my-2 fs-6 fw-bold"><?php echo $zipcode_count; ?></p>
						</div>
                    </div>
                </div>
				<div class="col-lg-4 col-4 p-2">
					<div class="card">
                    <!-- small box -->
                    <div class="card-body">						
						<p><strong><i class="fa fa-arrows me-2"></i>Get Directions Clicked</strong></p>
						<p class="my-2 fs-6 fw-bold"><?php echo $direction_count; ?></p>
                    </div>
					</div>
                </div>
				</div>	
							
							<div class="row mt-2 pt-2">
                                <div class="col-md-8">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <h6 class="text-start" style="font-size: 16px;">Profile Viewed</h6>
                                        </p>

                                    </div>

                                    <div class="position-relative">
                                        <canvas id="visitors-chart" height="300"></canvas>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                        <h6 class="text-center" style="font-size: 16px;">Top 5 Zipcodes Searched</h6>
                                    <div class="chart">
                                        <canvas id="donutChart" height="300"></canvas>
                                    </div>
                                </div>
                            </div>	
							<div class="page-break"></div>	
							<div class="row mt-2"> 
                                <div class="col-md-12">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <h6 class="text-start" style="font-size: 16px;">Impressions</h6>
                                        </p>

                                    </div>

                                    <div class="position-relative">
                                        <canvas id="appears-chart" height="200"></canvas>

                                    </div>
                                </div></div>	
							<?php if(!empty(json_decode($zipcodes,true)[0])){ ?>
									<div class="row mt-5">
										<h6 class="text-start" style="font-size: 16px;">Potential Customers</h6>
										<div id="map" class="p-3 mt-2 m-auto" style="height:400px;width:97%;border-radius:10px">
										</div>
									</div>
							<div class="page-break"></div>
							<?php } ?>
							<div class="row mt-2">
								<div class="col-xl-5 mt-3">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <h6 class="text-start" style="font-size: 16px;">Top Customers Locations</h6>
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
			<div class="row">
				<div class="col-xl-6 mt-3">
					<div class="d-flex">
						<p class="d-flex flex-column">
							<h6 class="text-start" style="font-size: 16px;">Top 20 Recent Searches of your profile</h6>
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
							<h6 class="text-start" style="font-size: 16px;">Top 20 Recent Calls</h6>
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
			
			<hr>
			<h6 class="text-start text-decoration-underline mt-5" style="font-size: 16px;">Connect with us</h6>
			<div class="col-12 mt-4">
			<?php if (!empty(get_general_settings()->facebook_url) && get_general_settings()->facebook_url != '#') : ?>						
			<a href="<?php echo html_escape(get_general_settings()->facebook_url); ?>" target="_blank">	
				<i class="fa-brands fa-facebook fs-4 me-3 text-dark"></i>	
			</a>					
			<?php endif; ?>					
			<?php if (!empty(get_general_settings()->twitter_url) && get_general_settings()->twitter_url != '#') : ?>						
			<a href="<?php echo html_escape(get_general_settings()->twitter_url); ?>" target="_blank">							
				<img src="<?php echo base_url('assets/img/twitter.png'); ?>" />	
			</a>
			<?php endif; ?>					
			<?php if (!empty(get_general_settings()->pinterest_url) && get_general_settings()->pinterest_url != '#') : ?>						
			<a href="<?php echo html_escape(get_general_settings()->pinterest_url); ?>" target="_blank">
				<img src="<?php echo base_url(); ?>assets/images/social-icons/pinterest.png" alt="" style="width: 28px; height: 28px;" />
			</a>					
			<?php endif; ?>					
			<?php if (!empty(get_general_settings()->instagram_url) && get_general_settings()->instagram_url != '#') : ?>
			<a href="<?php echo html_escape(get_general_settings()->instagram_url); ?>" target="_blank">
				<i class="fa-brands fa-instagram fs-4 me-3 text-dark"></i>	
			</a>					
			<?php endif; ?>					
			<?php if (!empty(get_general_settings()->linkedin_url) && get_general_settings()->linkedin_url != '#') : ?>
			<a href="<?php echo html_escape(get_general_settings()->linkedin_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
				<img src="<?php echo base_url(); ?>assets/images/social-icons/linkedin.png" alt="" style="width: 28px; height: 28px;" />
			</a>
			<?php endif; ?>
			<?php if (!empty(get_general_settings()->vk_url) && get_general_settings()->vk_url != '#') : ?>
			<a href="<?php echo html_escape(get_general_settings()->vk_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
				<img src="<?php echo base_url(); ?>assets/images/social-icons/vk.png" alt="" style="width: 28px; height: 28px;" />
			</a>					
			<?php endif; ?>					
			<?php if (!empty(get_general_settings()->youtube_url) && get_general_settings()->youtube_url != '#') : ?>						
			<a href="<?php echo html_escape(get_general_settings()->youtube_url); ?>" target="_blank">
				<img src="<?php echo base_url('assets/img/youtube.png'); ?>" />					
			</a>						
			<?php endif; ?>	
			<p class="mb-0 mt-4">You have received this email because you have an account at <a href="<?php echo base_url(); ?>">planebroker.com</a></p>
			<p>Did you find this email useful?  <a href="<?php echo base_url('/contact'); ?>">Submit Feedback</a></p>
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