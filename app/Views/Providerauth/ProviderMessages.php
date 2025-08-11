<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="bg-grey d-flex flex-column flex-lg-row">
        <?php echo $this->include('Common/_messages') ?>
		<div class="leftsidecontent" id="stickySection">
			<?php echo $this->include('Common/_sidemenu') ?>
		</div>
		<div class="rightsidecontent w-100 px-3 mb-5">
			<div class="container-fluid">
				<div class="titleSec">
					<h3 class="title-lg fw-bolder my-4"><?php echo $title; ?></h3>
				</div>
				<div class="dbContent">
					<div class="container">
					<div class="table-responsive proMsg dbMsg">

						<table class="table msgtable table-bordered table-striped mb-0">
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
										<td> <a href="javascript:void(0)" class="me-2 fs-7" onclick="get_provider_messages('<?php echo html_escape($provider_message['id']); ?>');"><i class="far fa-eye me-1"></i><?php echo trans('View'); ?></a>
										<a href="javascript:void(0)" class="fs-7" onclick="delete_provider_messages('<?php echo html_escape($provider_message['id']); ?>');"><i class="far fa-trash-o me-1"></i><?php echo trans('Delete'); ?></a>
										</td>      
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="col-sm-12 float-right mt-5">
						<?php echo (count($provider_messages) > 10) ? $paginations : ''; ?>
					</div>
				</div>
				</div>
            </div>                    
		</div>
	</div>
<?php echo $this->include('Providerauth/_modal_provider_messages') ?>
<?= $this->endSection() ?>
