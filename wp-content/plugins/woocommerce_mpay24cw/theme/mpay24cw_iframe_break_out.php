<?php
add_filter( 'run_wptexturize', '__return_false' );
?>
<div class="woocommerce mpay24cw">
	<?php echo __('Redirecting... Please Wait ', 'woocommerce_mpay24cw'); ?>
	<script type="text/javascript"> 
		top.location.href = '<?php echo $url; ?>';
	</script>
	

	<noscript>
		<a class="button btn btn-success mpay24cw-continue-button" href="<?php echo $url; ?>" target="_top"><?php echo __('If you are not redirected shortly, click here.', 'woocommerce_mpay24cw'); ?></a>
	</noscript>
</div>