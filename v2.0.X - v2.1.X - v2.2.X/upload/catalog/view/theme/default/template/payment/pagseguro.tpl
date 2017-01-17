<script type="text/javascript" src="<?php echo $script; ?>"></script>

<style>
	#pagseguro span {
		position: relative;
	}
</style>

<div id="pagseguro">
	<div class="buttons">
		<div class="pull-right">
			<input type="submit" value="<?php echo $button; ?>" class="btn btn-primary" data-order="" onclick="startPagSeguro()" />
			<span style="display:none;"><?php echo $loading; ?></span>
		</div>
	</div>
</div>

<script type="text/javascript"><!--
	$.ajax({
		url: '<?php echo $post; ?>',
		type: 'post',
		cache: false,
		dataType: 'json',
		success: function(json) {
			$('#pagseguro input').attr('data-order', json.code);
			
			<?php if($auto_start) { ?>
				setTimeout(function() {
					startPagSeguro();
				}, (<?php echo $delay; ?>*1000));
			<?php } ?>
		}
	});

	function startPagSeguro() {
		$('#pagseguro input').hide();
		$('#pagseguro span').show();
		
		PagSeguroLightbox({
			code: $('#pagseguro input').attr('data-order')
		}, {
			success : function(transactionCode) {
				location.href = '<?php echo $redirect; ?>'
			},
			abort : function() {
				$('#pagseguro span').hide();
				$('#pagseguro input').show();
				location.href = '<?php echo $cancel; ?>'
			}
		});
	}
//--></script>
