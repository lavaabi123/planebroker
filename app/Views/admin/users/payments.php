
				<?php if (count($payments) == 0) : ?>
					<p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
				<?php else: ?>
			<div class="table-responsive proMsg">

				<table class="table table-bordered table-striped">
					<thead>
						<tr role="row">
							<th><?php echo trans('S.no'); ?></th>
							<th><?php echo trans('Plan'); ?></th>
							<th><?php echo trans('Amount'); ?></th>
							<th><?php echo trans('Date / Time'); ?></th>
							<th><?php echo trans('Status'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($payments as $p => $payment) : ?>
							<tr>
								<td><?php echo ($p+1); ?> </td>
								<td><?php echo ($payment->amount/100 == 29.99) ? 'Premium' : 'Standard'; ?></td>
								<td><?php echo '$'.$payment->amount/100; ?></td>
								<td><?php echo date("m/d/Y",$payment->charges->data[0]->created); ?></td>
								<td><?php echo ucfirst($payment->status); ?></td>     
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php endif; ?>