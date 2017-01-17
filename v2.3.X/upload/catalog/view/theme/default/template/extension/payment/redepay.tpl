<style>
	#sair-container .modal {
		display: block!important;
	}

	#redepay span {
		position: relative;
	}

	#redepay img {
		display: none;
	}
</style>

<div id="redepay">
	<div class="buttons">
		<div class="pull-right">
			<script src="<?php echo $script; ?>" data-publishable-key="<?php echo $public_key; ?>" data-image="cen1_hor_op3_pc_225x45" data-order-id="" id="redepay-script"></script>
			<span><?php echo $loading; ?></span>
		</div>
	</div>
</div>

<script type="text/javascript"><!--
	$('#redepay img').hide();
	$.ajax({
		url: '<?php echo $post; ?>',
		type: 'post',
		dataType: 'json',
		success: function(json) {
			$('#redepay script').attr('data-order-id', json.id);
			$('#redepay span').hide();
			$('#redepay img').show();

			<?php if($auto_start) { ?>
				setTimeout(function() {
					RedePay.start();
				}, (<?php echo $delay; ?>*1000));
			<?php } ?>
		}
	});
//--></script>
