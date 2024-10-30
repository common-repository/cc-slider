<?php
/*
* Exit if accessed directly.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="wrap">
	<div class="plugin-header"> <?php _e('CC Slider Options','cc-slider');?></div>
	<div id = "plugin-title"><?php _e('Settings','cc-slider');?></div>
	<div id = "tabs-5">
	
		<div id = "tabs-6">
		<form method="POST" action="options.php" id="form1">
			
				
				
				<?php settings_fields( 'cc_slider_settings' );
				do_settings_sections( __FILE__ );
				$options = get_option( 'cc_slider_settings' );
				$count_posts = wp_count_posts('cc-slider','');?>

				<div class="ccs-row-slider">
					<label for="cc_slider_settings[slides]"><?php _e('Number of Slides:','cc-slider'); ?>
					</label>
					<div class="ccs-option-field">
						<input type="number" pattern="\d{1,15}" min="1" max="4" id="cc_slider_settings[slides]" name="cc_slider_settings[slides]" value="<?php echo esc_attr((isset($options['slides']) && $options['slides'] != '')) ? $options['slides'] : $count_posts->publish; ?>">
						<div class="ccs-option-note">
							<?php _e('Maximum number of slides can be: 4','cc-slider');?><br>
							<?php _e('Number of slides created is: '.$count_posts->publish,'cc-slider');?>
						</div>
					</div>
				</div>
				<div class="ccs-row-slider">
					<label for="cc_slider_settings[slideshow]"><?php _e('Slideshow Speed:','cc-slider');?>
					</label>
					<div class="ccs-option-field">
						<input type="number" pattern="\d{1,15}" min="1" id="cc_slider_settings[slideshow]" name="cc_slider_settings[slideshow]" value="<?php echo esc_attr((isset($options['slideshow']) && $options['slideshow'] != '')) ? $options['slideshow'] : '3'; ?>">
						<div class="ccs-option-note">
						<?php _e('in seconds','cc-slider');?>
						</div>
					</div>
				</div>
					
				<div class="ccs-row-slider">
					<label for="cc_slider_settings[animation]">
							<?php _e('Animation:','cc-slider');?>
					</label>
					<div class="ccs-option-field">
						<select id="cc_slider_settings[animation]" name="cc_slider_settings[animation]">

							<option value="fade"<?php if(!isset($options['animation']) || $options['animation']=='fade'){ echo 'selected'; }?>><?php _e('Fade','cc-slider');?></option>
							<option value="goDown"<?php if(isset($options['animation'] ) && $options['animation']=='goDown'){ echo 'selected';}?>><?php _e('Go Down','cc-slider');?></option>	
							<option value="backSlide"<?php if(isset($options['animation']) && $options['animation']=='backSlide'){ echo 'selected'; }?>><?php _e('Back Slide','cc-slider');?></option>
							<option value="fadeUp"<?php if(isset($options['animation']) && $options['animation']=='fadeUp'){ echo 'selected'; }?>><?php _e('Fade Up','cc-slider');?></option>

						</select>
					</div>
				</div>
				
				<div class="ccs-row-slider">
					<label><?php _e('Pagination Button:','cc-slider');?></label>
					<div class="ccs-option-field">
						<label for="control-yes" class="control-yes">
							<input type="radio" id="control-yes" name="cc_slider_settings[control]" value="true" <?php if(isset($options['control'] ) && $options['control']=='true'){ echo 'checked';}?>><?php _e(' Yes','cc-slider');?>
						</label>
						<label for="control-no" class="control-no">
						<input type="radio" id="control-no" name="cc_slider_settings[control]" value="false" <?php if(!isset($options['control']) || $options['control']=='false'){ echo 'checked'; }?>><?php _e(' No','cc-slider');?>
						</label>
						<div class="ccs-option-note">
							<?php _e(' Buttons below slider','cc-slider');?>
						</div>
					</div>
				</div>
				<div class="ccs-row-slider">
					<label><?php _e('Navigation Arrows:','cc-slider');?></label>
					<div class="ccs-option-field"><label for="direction-yes" class="control-yes">
						<input type="radio" id="direction-yes" name="cc_slider_settings[direction]" value="true" <?php if(isset($options['direction'] ) && $options['direction']=='true'){ echo 'checked';}?>><?php _e(' Yes','cc-slider');?>
					</label>
					<label for="direction-no" class="control-no">
						<input type="radio" id="direction-no" name="cc_slider_settings[direction]" value="false"  <?php if(!isset($options['direction']) || $options['direction']=='false'){ echo 'checked'; }?>><?php _e(' No','cc-slider');?>
					</label>
					<div class="ccs-option-note">
						<?php _e('Next/Prev arrow','cc-slider');?></div>
					</div>
				</div>
				
				<div class="ccs-row-slider">
					<label><?php _e('Stop on Hover:','cc-slider');?></label>
					<div class="ccs-option-field">
						<label for="hover-yes" class="hover-yes">
							<input type="radio" id="hover-yes" name="cc_slider_settings[hover]" value="true" <?php if(isset($options['hover'] ) && $options['hover']=='true'){ echo 'checked';}?>><?php _e(' Yes','cc-slider');?>
						</label>
						<label for="hover-no" class="hover-no"><input type="radio" id="hover-no" name="cc_slider_settings[hover]" value="false" <?php if(!isset($options['hover']) || $options['hover']=='false'){ echo 'checked'; }?>><?php _e(' No','cc-slider');?>
						</label>
						<div class="ccs-option-note">
							<?php _e('Slider stops on mouse-hover','cc-slider');?>
						</div>
					</div>
				</div>
				
				<div class="ccs-row-slider">
					<label for="cc_slider_settings[caption]"><?php _e('Caption/Description:','cc-slider'); ?>
					</label>
					<div class="ccs-option-field">
						<input type='checkbox' name='cc_slider_settings[caption]' id='cc_slider_settings[caption]' value='1' <?php if ( isset($options['caption']) && 1 == $options['caption'] ) echo 'checked="checked"'; ?> />
						<div class="ccs-option-note"><?php _e('Check to Hide Slider Caption and Description','cc-slider');?>
						</div>
					</div>
				</div>

				<div class="ccs-row-slider">
					<label for="cc_slider_settings[caption-color]"><?php _e('Caption Color:','cc-slider'); ?>
					</label>
					<div class="ccs-option-field">
						<input type="text" id="cc_slider_settings[caption-color]" name="cc_slider_settings[caption-color]" value="<?php echo esc_attr((isset($options['caption-color']) && $options['caption-color'] != '')) ? $options['caption-color'] : '#fff'; ?>" class="ccs-color-field"  />
						<div class="ccs-option-note">
							<?php _e('Caption text color in slides','cc-slider');?>
						</div>
					</div>
				</div>

				<div class="ccs-row-slider">
					<label for="cc_slider_settings[caption-hover-color]"><?php _e('Caption-hover Color:','cc-slider'); ?>
					</label>
					<div class="ccs-option-field">
						<input type="text" id="cc_slider_settings[caption-hover-color]" name="cc_slider_settings[caption-hover-color]" value="<?php echo esc_attr((isset($options['caption-hover-color']) && $options['caption-hover-color'] != '')) ? $options['caption-hover-color'] : '#fff'; ?>" class="ccs-color-field"  />
						<div class="ccs-option-note">
							<?php _e('Caption hover color in slides','cc-slider');?>
						</div>
					</div>
				</div>

				<div class="ccs-row-slider">
					<label for="cc_slider_settings[desc-color]"><?php _e('Description Color:','cc-slider'); ?>
					</label>
					<div class="ccs-option-field">
						<input type="text" id="cc_slider_settings[desc-color]" name="cc_slider_settings[desc-color]" value="<?php echo esc_attr((isset($options['desc-color']) && $options['desc-color'] != '')) ? $options['desc-color'] : '#fff'; ?>" class="ccs-color-field"  />
						<div class="ccs-option-note"><?php _e('Description text color in slides','cc-slider');?>
						</div>
					</div>
				</div>

				<div class="ccs-row-slider">
					<label for="cc_slider_settings[shadow-color]"><?php _e('Overlay Color:','cc-slider'); ?>
					</label>
					<div class="ccs-option-field">
						<input type="text" id="cc_slider_settings[shadow-color]" name="cc_slider_settings[shadow-color]" value="<?php echo esc_attr((isset($options['shadow-color']) && $options['shadow-color'] != '')) ? $options['shadow-color'] : '#fff'; ?>" class="ccs-color-field"  />
						<div class="ccs-option-note">
							<?php _e('Caption/Description overlay color in slides','cc-slider');?>
						</div>
					</div>
				</div>	
			<?php submit_button(); ?>
			
		</form>	
		</div>
		<div class="cc-note">
			<h2><?php _e('Usage','cc-slider');?></h2>
			<h4><?php _e('Shortcode','cc-slider');?></h4>
			<p><?php _e('Use this shortcode into any WordPress post or page.','cc-slider');?></p>
			<textarea class="cc-text-code" readonly="readonly">[cc-slider-sc]</textarea>

			<h4><?php _e('Template Include','cc-slider');?></h4>
			<p><?php _e('Use this function to include the slider within your theme.','cc-slider');?></p>
			<textarea class="cc-text-code" readonly="readonly">&lt;?php echo do_shortcode("[cc-slider-sc]"); ?&gt;</textarea>
		</div>
	</div>
</div>
