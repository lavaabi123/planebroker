<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- reCAPTCHA JS-->
<script src="https://www.google.com/recaptcha/api.js?render=<?= getenv('GOOGLE_RECAPTCHAV3_SITEKEY') ?>"></script>

<!-- Include script -->
<script type="text/javascript">

function onSubmit(e) {
	e.preventDefault();
	grecaptcha.ready(function() {
		 grecaptcha.execute("<?= getenv('GOOGLE_RECAPTCHAV3_SITEKEY') ?>", {action: 'submit'}).then(function(token) {
			  // Store recaptcha response
			  $("#recaptcha_response").val(token);
			  // Submit form
			  document.getElementById("messageProviderForm").submit();

		 });
	});
}

</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css">
<script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script>
<?php
if(!empty($user_detail->avatar)){
	$img = base_url()."/uploads/userimages/".$userId."/".$user_detail->avatar;
	$user_photos = array_merge(array(array('file_name'=>$user_detail->avatar,'image_tag'=>'')),$user_photos);
}
?>
    <div class="viewProfile pt-4 pt-sm-5">
        <?php echo $this->include('Common/_messages') ?>
		<div class="container pb-5">
			<div class="d-flex justify-content-between mb-5 gallerySearch">
				<h6 class="text-black"><?php echo $title; ?></h6>
				<div class="d-flex">
				<?php if (session()->get('vr_sess_logged_in') == TRUE && session()->get('vr_sess_user_id') == $userId) { ?>
					<a href="<?php echo base_url('providerauth/photos'); ?>" class="btn me-3"><i class="fas fa-camera"></i> Add Photo</a>
				<?php } ?>
					<input type="search" class="form-control w-auto" id="filter" placeholder="Search Photos" />
				</div>
			</div>	
			<div class="d-grid gridGallery">
				<?php if(!empty($user_photos)){
					foreach($user_photos as $p => $photo){ ?>
				<div class="col size" data-size="<?php echo $photo['image_tag']; ?>">
				<a class="proPic example-image-link" href="<?php echo base_url()."/uploads/userimages/".$userId."/".$photo['file_name']; ?>" data-lightbox="example-1"><img
				  src="<?php echo base_url()."/uploads/userimages/".$userId."/".$photo['file_name']; ?>"
				  alt="landscape" width="100%"
				/></a>
				</div>
				<?php } } ?>		
			</div>
		</div>
		
	</div>
<div class="loader"></div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script>
function save_report(){
	var report_type = $('input[name="report"]:checked').val();
	var user_id = '<?php echo $userId; ?>';
	$.ajax({
		url: '<?php echo base_url(); ?>/providerauth/save_report',
		type: 'POST',
		data: {report_type:report_type,user_id:user_id},
		success: function(res) {
			$('#myModal').modal('hide');
			Swal.fire({
				text: "Reported Profile!",
				icon: "success",
				confirmButtonColor: "#34c38f",
				confirmButtonText: "<?php echo trans("ok"); ?>",
			})
			
		}
	});
}
$(document).ready(function(){
	$("#filter").on("search", function(evt){
		if($(this).val().length > 0){
			// the search is being executed
			console.log('asd');
		}else{
			// user clicked reset
			console.log('sds');$('.size').show();
		}
	});

	$("#filter").keyup(function(){
		var selectSize = $(this).val();
		if($(this).val() == ''){
			$('.size').show();
		}else{
			filter(selectSize);
		}
	});
	function filter(e) {
		var regex = new RegExp('\\b\\w*' + e + '\\w*\\b');
				$('.size').hide().filter(function () {
			return regex.test($(this).data('size'))
		}).show();
	}
	$('.open-report-modal').on('click', function(e){
			e.preventDefault();
			$('#myModal').modal('show');
		});
	var simg = '<?php echo base_url().'/assets/img/favicon.png'; ?>';
    $('[data-toggle="popover"]').popover({
        placement : 'right',
		trigger : 'hover',
        html : true,
        content : '<div class="tooltip-inner text-start"><p class="dblue mb-2 d-flex align-items-center gap-1 fw-bold fs-8"><img width="24" src="'+simg+'"> A little extra about your broker!</p><p class="mb-0">These are 2 mandatory questions for your broker to answer when creating a profile.</p><p>This givens you a little more insight into who you choose to broker your plane!</p></div>'
    });
});
</script>
<style>
	.bs-example{
    	margin: 200px 150px 0;
    }
	.bs-example button{
		margin: 10px;
    }
	.a2a_full_footer{
		display:none;
	}
</style>


<script>
function phprun(target) { // <-----( INJECT THE EVENT TARGET)

    // get the video element from the target
    let videoEl = target.parentNode.parentNode.childNodes[0];

    // retrieve the data you want (eg. the video url and title)
    let videoUrl = 'http';
    let videoTitle = 'tit';

    // inject it into the desired containers
    h1.innerHTML = 'Share:' + videoTitle;
    h2.innerHTML = videoUrl;

    // do more stuff...
    if (copy.style.display === "none") {
        copy.style.display = "block";
    } else {
        copy.style.display = "none";
    }

}

    var sync1 = jQuery("#sync1");
    var sync2 = jQuery("#sync2");
    var slidesPerPage = 5; //globaly define number of elements per page
    var syncedSecondary = true;

    sync1.owlCarousel({
		items: 1,
		slideSpeed: 3000,
		nav: false,
		margin:10,
		animateIn: "fadeIn",
		autoplayHoverPause: true,
		autoplaySpeed: 1400, //過場速度
		dots: false,
		loop: false,
		responsiveClass: true,
		responsive: {
			0: {
			item: 1
			},
			600: {
			items: 1
			},
			1000:{
			items:1
			}
		},
		responsiveRefreshRate: 200,
		navText: [
		'<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>',
		'<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'
		]
	}).on("changed.owl.carousel", syncPosition);

    sync2.owlCarousel({
      loop:false,
		margin:10,
		nav:true,
		responsive:{
			0:{
				items:3
			},
			600:{
				items:4
			},
			1000:{
				items:5
			}
		}
    });

    function syncPosition(el) {
      //if you set loop to false, you have to restore this next line
      //var current = el.item.index;

      //if you disable loop you have to comment this block
      var count = el.item.count - 1;
      var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

      if (current < 0) {
        current = count;
      }
      if (current > count) {
        current = 0;
      }

      //end block

      sync2
        .find(".owl-item")
        .removeClass("current")
        .eq(current)
        .addClass("current");
      var onscreen = sync2.find(".owl-item.active").length - 1;
      var start = sync2
      .find(".owl-item.active")
      .first()
      .index();
      var end = sync2
      .find(".owl-item.active")
      .last()
      .index();

      if (current > end) {
        sync2.data("owl.carousel").to(current, 100, true);
      }
      if (current < start) {
        sync2.data("owl.carousel").to(current - onscreen, 100, true);
      }
    }

    function syncPosition2(el) {
      if (syncedSecondary) {
        var number = el.item.index;
        sync1.data("owl.carousel").to(number, 100, true);
      }
    }

    sync2.on("click", ".owl-item", function(e) {
      e.preventDefault();
      var number = jQuery(this).index();
      sync1.data("owl.carousel").to(number, 300, true);
    });
$('.owl-carousel').owlCarousel({
    loop:false,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
</script>
<?= $this->endSection() ?>