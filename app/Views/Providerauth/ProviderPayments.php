
			<div class="table-responsive proMsg">

				<table class="table table-bordered table-striped">
					<thead>
						<tr role="row">
							<th><?php echo trans('Plan'); ?></th>
							<th><?php echo trans('Amount'); ?></th>
							<th><?php echo trans('Date / Time'); ?></th>
							<th><?php echo trans('Status'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$pp = 0;
						if(!empty($payments)){
							foreach ($payments as $p => $payment) : ?>
							<?php /* ?><!--<tr>
								<td><?php echo ($pp = $pp+1); ?> </td>
								<td><?php echo ($payment->amount/100 == 29.99) ? 'Premium' : 'Standard'; ?></td>
								<td><?php echo '$'.$payment->amount/100; ?></td>
								<td><?php echo date("m/d/Y",$payment->charges->data[0]->created); ?></td>
								<td><?php echo ucfirst($payment->status); ?></td>     
							</tr>--> <?php */ ?>
							<tr>
								<td><?php echo ($payment->stripe_subscription_amount_paid == 29.99) ? 'Premium' : 'Standard'; ?></td>
								<td><?php echo '$'.$payment->stripe_subscription_amount_paid; ?></td>
								<td><?php echo date("m/d/Y",strtotime($payment->stripe_subscription_start_date)); ?></td>
								<td><?php echo ucfirst($payment->stripe_invoice_status); ?></td>     
							</tr>
						<?php endforeach;
						}
						if(!empty($paypal_payments)){						
							foreach ($paypal_payments as $p => $payment) : ?>
							<tr>
								<td><?php echo ($payment->plan_id == 3) ? 'Premium' : 'Standard'; ?></td>
								<td><?php echo '$'.$payment->transaction_amount; ?></td>
								<td><?php echo date("m/d/Y",strtotime($payment->transaction_initiation_date)); ?></td>
								<td><?php 
								if($payment->transaction_amount > 0){
								echo (strtolower($payment->transaction_status) == 'success' || strtolower($payment->transaction_status) == 'active') ? 'Paid' : '-';
								}else{
									echo '-';
								}?></td>     
							</tr>
							<?php endforeach;
						}?>
					</tbody>
				</table>
				<?php if (count($payments)+count($paypal_payments) == 0) : ?>
					<p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
				<?php endif; ?>
			</div>
			<div class="col-sm-12 float-right">
                                    <?php //echo $paginations ?>
                                </div>
            
<?php echo $this->include('Providerauth/_modal_provider_messages') ?>
