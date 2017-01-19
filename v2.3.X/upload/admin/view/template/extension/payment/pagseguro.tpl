<style>
	.panel-uol {
		margin: 20px;
	}

	#pagseguro-register {
		margin: 35px 35px 0 35px;
	}

	#pagseguro-register img {
    	margin-right: 10px;
	}

	#pagseguro-register p {
		margin-top: 8.5px;
		display: inline-block;
	}

	#pagseguro-support {
		margin: 30px 35px -35px 35px;
	}
</style>

<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-pagseguro" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>

			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li>
						<a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<div class="container-fluid">
    	<?php if ($error_warning) { ?>
			<div class="alert alert-danger">
				<i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>

    	<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>

			<div id="pagseguro-register">
				<img src="view/image/payment/pagseguro.png">
				<p><?php echo $text_register; ?></p>
			</div>

			<div id="pagseguro-support">
				<p><?php echo $text_support; ?></p>
			</div>

			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-pagseguro" class="form-horizontal">
					<!-- tokens -->
					<div class="panel panel-default panel-uol">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit_tokens; ?></h3>
						</div>

						<div class="panel-body">
							<!-- token -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-token"><span data-toggle="tooltip" title="<?php echo $help_token; ?>"><?php echo $entry_token; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="pagseguro_token" value="<?php echo $pagseguro_token; ?>" placeholder="<?php echo $entry_token; ?>" id="input-token" class="form-control" />
									<?php if ($error_token) { ?>
										<div class="text-danger">
											<?php echo $error_token; ?>
										</div>
									<?php } ?>
								</div>
							</div>

							<!-- e-mail -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-email"><span data-toggle="tooltip" title="<?php echo $help_email; ?>"><?php echo $entry_email; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="pagseguro_email" value="<?php echo $pagseguro_email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
									<?php if ($error_email) { ?>
										<div class="text-danger">
											<?php echo $error_email; ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>

					<!-- notifications -->
					<div class="panel panel-default panel-uol">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit_notifications; ?></h3>
						</div>

						<div class="panel-body">
							<!-- notification url -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-notification-url"><span data-toggle="tooltip" title="<?php echo $help_notification_url; ?>"><?php echo $entry_notification_url; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="pagseguro_notification_url" value="<?php echo $notification_url; ?>" placeholder="<?php echo $entry_notification_url; ?>" id="input-notification-url" class="form-control" readonly="readonly" />
									<?php if ($error_notification_url) { ?>
										<div class="text-danger">
											<?php echo $error_notification_url; ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>

					<!-- redirect -->
					<div class="panel panel-default panel-uol">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit_redirects; ?></h3>
						</div>

						<div class="panel-body">
							<!-- redirect url -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-redirect-url"><span data-toggle="tooltip" title="<?php echo $help_redirect_url; ?>"><?php echo $entry_redirect_url; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="pagseguro_redirect_url" value="<?php echo $redirect_url; ?>" placeholder="<?php echo $entry_redirect_url; ?>" id="input-redirect-url" class="form-control" readonly="readonly" />
									<?php if ($error_redirect_url) { ?>
										<div class="text-danger">
											<?php echo $error_redirect_url; ?>
										</div>
									<?php } ?>
								</div>
							</div>

							<!-- cancel url -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-cancel-url"><span data-toggle="tooltip" title="<?php echo $help_cancel_url; ?>"><?php echo $entry_cancel_url; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="pagseguro_cancel_url" value="<?php echo $cancel_url; ?>" placeholder="<?php echo $entry_cancel_url; ?>" id="input-cancel-url" class="form-control" readonly="readonly" />
									<?php if ($error_cancel_url) { ?>
										<div class="text-danger">
											<?php echo $error_cancel_url; ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>

					<!-- freight -->
					<div class="panel panel-default panel-uol">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit_freight; ?></h3>
						</div>

						<div class="panel-body">
							<!-- freight -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-freight"><span data-toggle="tooltip" title="<?php echo $help_freight; ?>"><?php echo $entry_freight; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_freight" id="input-freight" class="form-control">
										<?php foreach ($util_freight as $key => $value) : ?>
											<?php if ($key == $pagseguro_freight) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<!-- fields -->
					<div class="panel panel-default panel-uol">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit_fields; ?></h3>
						</div>

						<div class="panel-body">
							<!-- document -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-document"><span data-toggle="tooltip" title="<?php echo $help_document; ?>"><?php echo $entry_document; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_document" id="input-document" class="form-control">
										<?php foreach ($util_fields as $key => $value) : ?>
											<?php if ($key == $pagseguro_document) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- cellphone -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-cellphone"><span data-toggle="tooltip" title="<?php echo $help_cellphone; ?>"><?php echo $entry_cellphone; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_cellphone" id="input-cellphone" class="form-control">
										<?php foreach ($util_fields as $key => $value) : ?>
											<?php if ($key == $pagseguro_cellphone) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- address -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-address"><span data-toggle="tooltip" title="<?php echo $help_address; ?>"><?php echo $entry_address; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_address" id="input-address" class="form-control">
										<?php foreach ($util_fields as $key => $value) : ?>
											<?php if ($key == $pagseguro_address) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- number -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-number"><span data-toggle="tooltip" title="<?php echo $help_number; ?>"><?php echo $entry_number; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_number" id="input-number" class="form-control">
										<?php foreach ($util_fields as $key => $value) : ?>
											<?php if ($key == $pagseguro_number) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- complement -->
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-complement"><span data-toggle="tooltip" title="<?php echo $help_complement; ?>"><?php echo $entry_complement; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_complement" id="input-complement" class="form-control">
										<option value=""></option>
										<?php foreach ($util_fields as $key => $value) : ?>
											<?php if ($key == $pagseguro_complement) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- neighborhood -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-neighborhood"><span data-toggle="tooltip" title="<?php echo $help_neighborhood; ?>"><?php echo $entry_neighborhood; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_neighborhood" id="input-neighborhood" class="form-control">
										<?php foreach ($util_fields as $key => $value) : ?>
											<?php if ($key == $pagseguro_neighborhood) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<!-- order status -->
					<div class="panel panel-default panel-uol">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit_order_status; ?></h3>
						</div>

						<div class="panel-body">
							<!-- status: waiting payment -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-order-waiting-payment"><span data-toggle="tooltip" title="<?php echo $help_order_waiting_payment; ?>"><?php echo $entry_order_waiting_payment; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_order_waiting_payment" id="input-order-waiting-payment" class="form-control">
										<?php foreach ($util_status as $key => $value) : ?>
											<?php if ($key == $pagseguro_order_waiting_payment) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- status: payment in analisys -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-order-payment-analisys"><span data-toggle="tooltip" title="<?php echo $help_order_payment_analisys; ?>"><?php echo $entry_order_payment_analisys; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_order_payment_analisys" id="input-order-payment-analisys" class="form-control">
										<?php foreach ($util_status as $key => $value) : ?>
											<?php if ($key == $pagseguro_order_payment_analisys) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- status: approved payment -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-order-approved-payment"><span data-toggle="tooltip" title="<?php echo $help_order_approved_payment; ?>"><?php echo $entry_order_approved_payment; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_order_approved_payment" id="input-order-approved-payment" class="form-control">
										<?php foreach ($util_status as $key => $value) : ?>
											<?php if ($key == $pagseguro_order_approved_payment) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- status: payment in dispute -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-order-payment-dispute"><span data-toggle="tooltip" title="<?php echo $help_order_payment_dispute; ?>"><?php echo $entry_order_payment_dispute; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_order_payment_dispute" id="input-order-payment-dispute" class="form-control">
										<?php foreach ($util_status as $key => $value) : ?>
											<?php if ($key == $pagseguro_order_payment_dispute) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- status: reversed payment -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-order-reversed-payment"><span data-toggle="tooltip" title="<?php echo $help_order_reversed_payment; ?>"><?php echo $entry_order_reversed_payment; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_order_reversed_payment" id="input-order-reversed-payment" class="form-control">
										<?php foreach ($util_status as $key => $value) : ?>
											<?php if ($key == $pagseguro_order_reversed_payment) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- status: chargeback payment -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-order-chargeback-payment"><span data-toggle="tooltip" title="<?php echo $help_order_chargeback_payment; ?>"><?php echo $entry_order_chargeback_payment; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_order_chargeback_payment" id="input-order-chargeback-payment" class="form-control">
										<?php foreach ($util_status as $key => $value) : ?>
											<?php if ($key == $pagseguro_order_chargeback_payment) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- status: canceled payment -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-order-canceled-payment"><span data-toggle="tooltip" title="<?php echo $help_order_canceled_payment; ?>"><?php echo $entry_order_canceled_payment; ?></span></label>
								<div class="col-sm-10">
									<select name="pagseguro_order_canceled_payment" id="input-order-canceled-payment" class="form-control">
										<?php foreach ($util_status as $key => $value) : ?>
											<?php if ($key == $pagseguro_order_canceled_payment) : ?>
												<option value="<?php echo $key; ?>" selected="selected" ><?php echo $value; ?></option>
											<?php  else : ?>
												<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<!-- settings -->
					<div class="panel panel-default panel-uol">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit_settings; ?></h3>
						</div>

						<div class="panel-body">
							<!-- min value for enable -->
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-min-value-enable"><span data-toggle="tooltip" title="<?php echo $help_min_value_enable; ?>"><?php echo $entry_min_value_enable; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="pagseguro_min_value_enable" value="<?php echo $pagseguro_min_value_enable; ?>" placeholder="<?php echo $entry_min_value_enable; ?>" id="input-min-value-enable" class="form-control" />
								</div>
							</div>

							<!-- status -->
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
									<select name="pagseguro_status" id="input-status" class="form-control">
										<?php if ($pagseguro_status) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<!-- sort order -->
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
								<div class="col-sm-10">
									<input type="text" name="pagseguro_sort_order" value="<?php echo $pagseguro_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>
