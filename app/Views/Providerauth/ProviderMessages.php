<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="plan bg-gray pt-2 pb-4 pb-xl-5">
        <?php echo $this->include('Common/_messages') ?>
		<div class="titleSec text-center mb-3 mb-xl-4">
			<h3 class="title-lg dblue mb-0 mb-sm-5"><?php echo $title; ?></h3>
		</div>
		<div class="container">
			<div class="row">
			<div class="leftsidecontent col col-sm-4 col-lg-3">
			<?php echo $this->include('Common/_sidemenu') ?>
			</div>
			
                                <div class="col col-sm-8 col-lg-9">
			<div class="filter_Sec">
				<?php echo $this->include('Providerauth/_filter_provider_messages') ?>
			</div>
			<div class="table-responsive proMsg">

				<table class="table table-bordered table-striped">
					<thead>
						<tr role="row">
							<th><?php echo trans('Name'); ?></th>
							<th><?php echo trans('Email'); ?></th>
							<th><?php echo trans('Phone'); ?></th>
							<th><?php echo trans('Date / Time'); ?></th>
							<th class="max-width-120"><?php echo trans('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($provider_messages as $provider_message) : ?>
							<tr id="pm<?php echo html_escape($provider_message['id']); ?>">
								<td><?php echo $provider_message['from_name']; ?> </td>
								<td><?php echo $provider_message['from_email']; ?></td>
								<td><?php echo $provider_message['from_phone']; ?></td>
								<td><?php echo formatted_date($provider_message['created_at'],'m/d/Y h:i a'); ?></td>
								<td> <a href="javascript:void(0)" class="me-2 fs-7" onclick="get_provider_messages('<?php echo html_escape($provider_message['id']); ?>');"><i class="fas fa-eye me-1"></i><?php echo trans('View'); ?></a>
								<a href="javascript:void(0)" class="fs-7" onclick="delete_provider_messages('<?php echo html_escape($provider_message['id']); ?>');"><i class="fas fa-trash me-1"></i><?php echo trans('Delete'); ?></a>
								</td>      
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php if (empty($provider_messages)) : ?>
					<p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
				<?php endif; ?>
			</div>
			<div class="col-sm-12 float-right">
                                    <?php echo $paginations ?>
                                </div>
                                </div>
                                
		</div></div>
	</div>
<?php echo $this->include('Providerauth/_modal_provider_messages') ?>
<?= $this->endSection() ?>
