<div class="leftsidemenus d-flex flex-column mb-4">
<?php $uri = current_url(true); ?>
<?php $busine_name = !empty($user_detail->business_name) ? $user_detail->business_name : $user_detail->fullname ; ?>
<!--<div class="row align-items-center">
<div class="col-5 proPic">
<?php 
$products_count_show_subs = check_listing($user_detail->id);
if(!empty($user_detail->avatar)){ 
	$pic['file_name'] = base_url().'/uploads/userimages/'.$user_detail->id.'/'.$user_detail->avatar;
}else{
	$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
} ?>
<img class="img-fluid" src="<?php echo $pic['file_name']; ?>">
</div>
<nav class="navbar navbar-white col-2 d-sm-none justify-content-end pe-2" aria-label="sidemenu navbar">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidemenu" aria-controls="sidemenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>      
  </nav>

</div> -->
<nav class="navbar navbar-expand-lg justify-content-end">
	<button class="navbar-toggler sidemenu" type="button" data-bs-toggle="collapse" data-bs-target="#sidemenu" aria-controls="sidemenu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>	  
		  </nav>
<div class="collapse navbar-collapse d-sm-block" id="sidemenu">
<ul class="navbar-nav mt-3">
<li><a class="<?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'dashboard') ? 'active' :''; ?>" href="<?php echo base_url('dashboard'); ?>"><img src="<?php echo base_url('assets/frontend/images/dashboard.png'); ?>" /> Dashboard</a></li>

<hr>

<li><a class="<?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'my-listing') ? 'active' :''; ?>" href="<?php echo base_url('my-listing'); ?>"><img src="<?php echo base_url('assets/frontend/images/list.png'); ?>" /> My Listings</a></li>
<?php if(!empty($user_detail->user_level)){  ?>
<li><a class="<?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'plan') ? 'active' :''; ?>" href="<?php echo base_url('add-listing'); ?>"><img src="<?php echo base_url('assets/frontend/images/new.png'); ?>" /> Create New Listing</a></li>
<?php }else{ ?>
<li><a class="<?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'plan') ? 'active' :''; ?>" href="<?php echo base_url('plan'); ?>"><img src="<?php echo base_url('assets/frontend/images/new.png'); ?>" /> Create New Listing</a></li>
<?php } ?>
<li><a class="<?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'messages') ? 'active' :''; ?>" href="<?php echo base_url('messages'); ?>"><img src="<?php echo base_url('assets/frontend/images/imsg.png'); ?>" /> Messages</a></li>
<?php //if($products_count_show_subs > 0){ ?>
<li><a class=" <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'subscriptions') ? 'active' :''; ?>" href="<?php echo base_url('subscriptions'); ?>"><img src="<?php echo base_url('assets/frontend/images/billing.png'); ?>" /> Subscriptions</a></li>
<?php //} ?>
<li><a class=" <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'billing') ? 'active' :''; ?>" href="<?php echo base_url('billing'); ?>"><img src="<?php echo base_url('assets/frontend/images/cost.png'); ?>" /> Billing</a></li>

<li><a class=" <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'favorites') ? 'active' :''; ?>" href="<?php echo base_url('favorites'); ?>"><img src="<?php echo base_url('assets/frontend/images/favor.png'); ?>" /> Favorites</a></li>

<li><a class=" <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'analytics') ? 'active' :''; ?>" href="<?php echo base_url('analytics'); ?>"><img src="<?php echo base_url('assets/frontend/images/analytics.png'); ?>" /> Analytics</a></li>

<li><a class=" <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'help') ? 'active' :''; ?>" href="<?php echo base_url('help'); ?>"><img src="<?php echo base_url('assets/frontend/images/support.png'); ?>" /> Help/Support</a></li>

<hr>

<li><a class="<?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'account-settings') ? 'active' :''; ?>" href="<?php echo base_url('account-settings'); ?>"><img src="<?php echo base_url('assets/frontend/images/iuser.png'); ?>" /> Profile Settings</a></li>


<?php //if($user_detail->stripe_subscription_customer_id != ''){ ?>
<!--<li><a class=" <?php echo ($uri->getTotalSegments() >= env('urlsegment') && $uri->getSegment(env('urlsegment')) == 'payment_history') ? 'active' :''; ?>" href="<?php echo base_url('providerauth/payment_history'); ?>"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><rect x="32" y="80" width="448" height="256" rx="16" ry="16" transform="rotate(180 256 208)" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M64 384h384M96 432h320"/><circle cx="256" cy="208" r="80" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path d="M480 160a80 80 0 01-80-80M32 160a80 80 0 0080-80M480 256a80 80 0 00-80 80M32 256a80 80 0 0180 80" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg> Payment History</a></li>
<?php //} ?>

<!--<li><a class="<?php echo ($uri->getTotalSegments() >= env('urlsegment') && $uri->getSegment(env('urlsegment')) == 'edit-profile') ? 'active' :''; ?>" href="<?php echo base_url('providerauth/edit-profile'); ?>"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 224v184a40 40 0 01-40 40H104a40 40 0 01-40-40V168a40 40 0 0140-40h167.48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path d="M459.94 53.25a16.06 16.06 0 00-23.22-.56L424.35 65a8 8 0 000 11.31l11.34 11.32a8 8 0 0011.34 0l12.06-12c6.1-6.09 6.67-16.01.85-22.38zM399.34 90L218.82 270.2a9 9 0 00-2.31 3.93L208.16 299a3.91 3.91 0 004.86 4.86l24.85-8.35a9 9 0 003.93-2.31L422 112.66a9 9 0 000-12.66l-9.95-10a9 9 0 00-12.71 0z"/></svg> Edit My Profile</a></li>-->

<?php //if($user_detail->plan_id == 1){ ?>
<!--<li><a class="" href="<?php echo base_url('plan'); ?>"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" data-name="Layer 1" viewBox="0 0 512 512" id="credit-card"><path d="M222.06,305h-65a7.5,7.5,0,0,0,0,15h65a7.5,7.5,0,0,0,0-15Zm-10,52H55.51a7.5,7.5,0,1,0,0,15H212.08a7.5,7.5,0,1,0,0-15Zm-91.23-52h-65a7.5,7.5,0,0,0,0,15h65a7.5,7.5,0,1,0,0-15ZM65.5,257h50A17.52,17.52,0,0,0,133,239.5v-31A17.52,17.52,0,0,0,115.5,191h-50A17.52,17.52,0,0,0,48,208.5v31A17.52,17.52,0,0,0,65.5,257ZM63,208.5a2.5,2.5,0,0,1,2.5-2.5h50a2.5,2.5,0,0,1,2.5,2.5v31a2.5,2.5,0,0,1-2.5,2.5h-50a2.5,2.5,0,0,1-2.5-2.5ZM141.5,387H55.85a7.5,7.5,0,0,0,0,15H141.5a7.5,7.5,0,0,0,0-15Zm181.78-82h-65a7.5,7.5,0,0,0,0,15h65a7.5,7.5,0,0,0,0-15ZM414.5,191h-111A17.52,17.52,0,0,0,286,208.5v12A17.52,17.52,0,0,0,303.5,238h111A17.52,17.52,0,0,0,432,220.5v-12A17.52,17.52,0,0,0,414.5,191Zm2.5,29.5a2.5,2.5,0,0,1-2.5,2.5h-111a2.5,2.5,0,0,1-2.5-2.5v-12a2.5,2.5,0,0,1,2.5-2.5h111a2.5,2.5,0,0,1,2.5,2.5ZM474.5,50H69.5A37.54,37.54,0,0,0,32,87.5v58.91A37.55,37.55,0,0,0,0,183.5v226A37.54,37.54,0,0,0,37.5,447h405A37.54,37.54,0,0,0,480,409.5V350.59a37.55,37.55,0,0,0,32-37.09V87.5A37.54,37.54,0,0,0,474.5,50ZM465,409.5A22.52,22.52,0,0,1,442.5,432H37.5A22.52,22.52,0,0,1,15,409.5v-226A22.52,22.52,0,0,1,37.5,161h405A22.52,22.52,0,0,1,465,183.5Zm32-96a22.54,22.54,0,0,1-17,21.82V183.5c0-.84,0-1.67-.09-2.5H497ZM497,166H475.65a37.53,37.53,0,0,0-33.15-20H47V117H497Zm0-64H47V87.5A22.52,22.52,0,0,1,69.5,65h405A22.52,22.52,0,0,1,497,87.5ZM424.5,305h-65a7.5,7.5,0,0,0,0,15h65a7.5,7.5,0,0,0,0-15ZM402,351a29.94,29.94,0,0,0-15,4A30,30,0,1,0,387,407a30,30,0,1,0,15-56Zm-30,45a15,15,0,1,1,15-15A15,15,0,0,1,372,396Zm30,0a14.67,14.67,0,0,1-3.75-.49,29.95,29.95,0,0,0,0-29A14.67,14.67,0,0,1,402,366a15,15,0,0,1,0,30Z"></path></svg> My Plan</a></li>-->
<?php //} ?>
<?php /*if($user_detail->plan_id > 1){ ?>
<a class="btn yellowbtn fw-bold mt-4" href="<?php echo base_url('plan'); ?>">CHANGE MY PLAN</a>
<?php }*/ ?>
<!--<li><a class="" href="<?php echo base_url('providerauth/update-card'); ?>"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><rect x="48" y="96" width="416" height="320" rx="56" ry="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="60" d="M48 192h416M128 300h48v20h-48z"/></svg> Payment Methods</a></li>-->
<!--<hr>
<li><a class="" href="<?php echo base_url('provider/'.cleanURL(strtolower(str_replace(' ','-',$busine_name))).'/'.base64_encode($user_detail->id)); ?>"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M258.9 48C141.92 46.42 46.42 141.92 48 258.9c1.56 112.19 92.91 203.54 205.1 205.1 117 1.6 212.48-93.9 210.88-210.88C462.44 140.91 371.09 49.56 258.9 48zm126.42 327.25a4 4 0 01-6.14-.32 124.27 124.27 0 00-32.35-29.59C321.37 329 289.11 320 256 320s-65.37 9-90.83 25.34a124.24 124.24 0 00-32.35 29.58 4 4 0 01-6.14.32A175.32 175.32 0 0180 259c-1.63-97.31 78.22-178.76 175.57-179S432 158.81 432 256a175.32 175.32 0 01-46.68 119.25z"/><path d="M256 144c-19.72 0-37.55 7.39-50.22 20.82s-19 32-17.57 51.93C191.11 256 221.52 288 256 288s64.83-32 67.79-71.24c1.48-19.74-4.8-38.14-17.68-51.82C293.39 151.44 275.59 144 256 144z"/></svg> View My Profile</a></li>-->
</ul>
</div>
</div>
 <script>
    window.addEventListener('DOMContentLoaded', () => {
      const header = document.getElementById('header');
      const stickySection = document.getElementById('stickySection');
      const headerHeight = header.offsetHeight;

      // Set the top value dynamically
      //stickySection.style.top = `${headerHeight}px`;
	  // Set CSS variable on body or root
      stickySection.style.setProperty('--sticky-top', `${headerHeight}px`);
    });
  </script>