<style>
	<?php
	$ccs_color = get_option('cc_slider_settings');
	
	$caption_color = esc_attr($ccs_color['caption-color']);
	$desc_color = esc_attr($ccs_color['desc-color']);	
	$shadow_color = esc_attr($ccs_color['shadow-color']);
	$caption_hover = esc_attr($ccs_color['caption-hover-color']);

	if($ccs_color['desc-color']!==''){
		?>
		.ccs-caption p{
			color: <?php echo $desc_color ?> !important;
			opacity: 1;
		}
		<?php 
	}

	if($ccs_color['caption-hover-color']!==''){
		?>
		.ccs-caption a:hover{
			color: <?php echo $caption_hover ?> !important;
			opacity: 1;
		}
		<?php 

	}


	if($ccs_color['caption-color']!==''){
		?>
		.ccs-caption a{
			color: <?php echo $caption_color ?> !important;
			opacity: 1;
		}
		<?php 

	}
	if($ccs_color['shadow-color']!==''){
		?>
		.ccs-caption::after {
			background: <?php echo $shadow_color ?> !important;
			opacity: 0.5;
			position: absolute;
			content: '';
			display: block;
			z-index: 99;
			height: 100%;
			width: 100%;
			bottom: 0;
			left: 0;
		}
	<?php
	}
	?>
	.cc-caption-text{
		display: block;
		z-index: 9999;
		position: relative;
	}

</style>