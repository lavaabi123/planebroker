<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

	<div class="bg-grey d-flex flex-column flex-lg-row">
        <?php echo $this->include('Common/_messages') ?>
		<div class="leftsidecontent" id="stickySection">
			<?php echo $this->include('Common/_sidemenu') ?>
		</div>
		<div class="rightsidecontent w-100 px-3 mb-5">
			<div class="container">
				<div class="titleSec">
					<h3 class="title-lg fw-bolder my-4"><?php echo $title; ?></h3>
				</div>
				<div class="dbContent">
				<?php if(!empty($supports)){ ?>
					<div class="accordion" id="faqAccordion">
						<?php foreach($supports as $support){ ?>
						<div class="accordion-item">
						  <h2 class="accordion-header" id="heading<?php echo $support->id; ?>">
							<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $support->id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $support->id; ?>">
							  <?php echo $support->name; ?>
							</button>
						  </h2>
						  <div id="collapse<?php echo $support->id; ?>" class="accordion-collapse collapse show" aria-labelledby="heading<?php echo $support->id; ?>" data-bs-parent="#faqAccordion">
							<div class="accordion-body">
							  <?php echo $support->content; ?>
							</div>
						  </div>
						</div>
						<?php } ?>
					  </div>
				<?php }else{ ?>
						No Results
				<?php } ?>
				</div>
            </div>                    
		</div>
	</div>

    
<?= $this->endSection() ?>