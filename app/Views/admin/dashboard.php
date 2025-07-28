<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
Dashboard content
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<style>
    #chartdiv {
        width: 100%;
        height: 400px;
    }
	.small-box .icon>i.fa, .small-box .icon>i.fab, .small-box .icon>i.fad, .small-box .icon>i.fal, .small-box .icon>i.far, .small-box .icon>i.fas, .small-box .icon>i.ion {		
		background: #ef5d15;
		border-radius: 50%;
		color: #fff;
		font-size: 17px;
		padding: 7px;
		width: 35px;
		text-align: center;
		height: auto;
	}
	.small-box>.small-box-footer {
		background: #ff6c00;
		padding: 5px;
		color: #fff !important;
	}
.avatar.avatar-md {
    width: 2.5rem;
    height: 2.5rem;
    line-height: 2.5rem;
    font-size: 1rem;
    right: 15px;
	display: block;
    position: absolute;
    top: 15px;
	border-radius: 50%;
    text-align: center;color: #fff;
}
.card.custom-card .card-header .card-title {
    position: relative;
    margin-block-end: 0;
    font-size: 0.9375rem;
    font-weight: 700;
    text-transform: capitalize;
}
.card.custom-card .card-header .card-title:before {
    content: "";
    position: absolute;
    height: 1rem;
    width: 0.2rem;
    inset-block-start: 0.15rem;
    inset-inline-start: -0.65rem;
    background: linear-gradient(to bottom, rgb(132,90,223) 50%, rgba(35,183,229, 0.5) 50%);
    border-radius: 0.5rem;
}
.table-bordered thead td, .table-bordered thead th {
    font-size: 13px;
}
.table-bordered td, .table-bordered th {
    font-size: 13px;
}
.small-box.bg-white {
    border: 2px solid;
    border-radius: 30px;
    overflow: hidden;
}
.small-box h3 {
    font-weight: 900;
}
.small-box.bg-white:hover {
    box-shadow: 2px 2px 8px #00000044;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">                    
                    <div>
                        <h1 class="m-0" style="float: left;">Dashboard</h1>
						<div class="card-tools d-flex align-items-center" style="float: right;">
							<p style="margin-bottom:0" id="dataforperiod">&nbsp;</p>
							<button type="button" class="btn btn-primary btn-sm daterange ml-2" data-input-url="<?php echo base_url() ?>/common/getUsersRegister" title="Date range">
								<i class="far fa-calendar-alt"></i>
							</button>
							<button type="button" class="btn btn-primary btn-sm ml-2" data-card-widget="collapse" title="Collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
                    </div>
                </div><!-- /.col -->
                <?php /* <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif  ?>

                    </ol>
                </div>  <?php */ ?><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
          <div class="row">
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white" style="border-color:#eca241;">
                        <div class="icon">
                            <span class="avatar avatar-md avatar-rounded" style="background:#eca241">
									<i class="fa fa-users fs-16"></i>
							</span> 
                        </div>
                        <div class="inner">
                            <h3 id="total_registrations" style="color:#eca241;">&nbsp;</h3>

                            <p>User Registrations</p>
                        </div>
                        <a href="<?php echo admin_url().'users'; ?>" class="small-box-footer" style="background:#eca241;">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white" style="border-color:#43ac3e;">
                        <div class="icon">
							<span class="avatar avatar-md avatar-rounded" style="background:#43ac3e">
									<i class="fa fa-shopping-bag fs-16"></i>
							</span>                            
                        </div>
                        <div class="inner">
                            <h3 id="totalAmountPaid" style="color:#43ac3e;">&nbsp;</h3>
                            <p>Sales</p>
                        </div>
                        <a href="<?php echo admin_url().'listings/sales'; ?>" class="small-box-footer" style="background:#43ac3e">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
				<div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white" style="border-color:#2379d0;">
                        <div class="icon">
                            <span class="avatar avatar-md avatar-rounded" style="background:#2379d0">
									<i class="fa fa-user-plus fs-16"></i>
							</span>   
                        </div>
                        <div class="inner">
                            <h3 id="totalStandard" style="color:#2379d0;">&nbsp;</h3>

                            <p>Standard Users</p>
                        </div>
                        <a href="<?php echo admin_url().'users?user_level=0'; ?>" class="small-box-footer" style="background:#2379d0">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white" style="border-color:#e66c00;">
                        <div class="icon">
                            <span class="avatar avatar-md avatar-rounded" style="background:#e66c00">
									<i class="fa fa-user-shield fs-16"></i>
							</span> 
                        </div>
                        <div class="inner">
                            <h3 id="totalPremium" style="color:#e66c00;">&nbsp;</h3>

                            <p>Captain's Club Members</p>
                        </div>
                        <a href="<?php echo admin_url().'users?user_level=1'; ?>" class="small-box-footer" style="background:#e66c00">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Users Registered</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <span id="ga-visitors" class="text-bold text-lg"></span>
                                            <span>Users Overtime</span>
                                        </p>

                                    </div>

                                    <div class="position-relative">
                                        <canvas id="visitors-chart" height="300"></canvas>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-center">
                                        <strong>Broker Plan</strong>
                                    </p>
                                    <div class="chart">
                                        <canvas id="donutChart" height="300"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="loading-data" class="overlay ">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<hr>
			<div class="row">
				<div class="col-xl-4 mt-3">
					<div class="card custom-card" style="padding: 1rem 1.25rem">
						<div class="card-header  justify-content-between">
							<div class="card-title">
								Top Broker Locations
							</div>
						</div>
						<div class="card-body" style="font-size: 14px;">
							<ul class="list-unstyled crm-top-deals mb-0">
							<?php if(!empty($top_locations)){
								foreach($top_locations as $top_location){	?>
								<li class="mt-3">
									<div class="d-flex align-items-top flex-wrap">
										<div class="flex-fill">
											<p class="fw-semibold mb-0" style="font-weight: 600!important;"><?php echo $top_location->city.', '.$top_location->state_code; ?></p>
										</div>
										<div class="fw-semibold fs-15"><?php echo $top_location->user_count.' Brokers'; ?></div>
									</div>
								</li>
							<?php } } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-xl-8 mt-3">
					<div class="card custom-card" style="padding: 1rem 1.25rem">
						<div class="card-header  justify-content-between">
							<div class="card-title">
								Recent Subscription Payments
							</div>
						</div>
						<div class="card-body px-0">
							<div class="table-responsive">
							<table class="table text-nowrap table-hover border table-bordered">
								<thead>
									<tr>
										<th scope="col">Provider</th>
										<th><?php echo trans('Subscription Start Date'); ?></th>
										<th><?php echo trans('Subscription End Date'); ?></th>
										<th scope="col">Amount Paid</th>
										<th scope="col">Paid On</th>
									</tr>
								</thead>
								<tbody>
								<?php if(!empty($recent_payments)){
								foreach($recent_payments as $recent_payment){ if(!empty($recent_payment->provider)){	?>
								<tr>
									<td><?php echo $recent_payment->provider; ?></td>
									<td><?php echo ($recent_payment->stripe_subscription_start_date != NULL) ? formatted_date($recent_payment->stripe_subscription_start_date,'m/d/Y') : '-'; ?></td>
									<td><?php echo ($recent_payment->stripe_subscription_end_date != NULL) ? formatted_date($recent_payment->stripe_subscription_end_date,'m/d/Y') : '-'; ?></td>
									<td><?php echo '$ '.$recent_payment->stripe_subscription_amount_paid; ?></td>
									<td><?php echo formatted_date($recent_payment->created_at,'m/d/Y'); ?></td>
								</tr>
								<?php } } } ?>
								</tbody>
							</table>	
							</div>
						</div>
					</div>
				</diV>
			</div>


            <!-- /.row -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



<!-- /.content-wrapper -->
<?php echo $this->endSection() ?>