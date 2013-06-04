<?php
/**
 * Plugin settings HTML page
 *
 * @package    Posts_List_Featured_Image
 * @subpackage Posts_List_Featured_Image_Settings
 * @since      0.2.0
 */
?>
<div id="fb-root"></div>
<script>
	(function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s);
		js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=404710116249124";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<div class="wrap">
	<div class="settings-content">
		<?php screen_icon('upload'); ?>
		<h2><?php echo $plugin_data['Name']; ?> Settings</h2>
		<?php
		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		} else {
			settings_errors();
			?>
			<div class="settings-box">
				<form id="imgsizes" action="options.php" method="post">
					<?php settings_fields('plfi_plugin_settings'); ?>
					<?php do_settings_sections('plfi-plugin-settings-section'); ?>
					<?php submit_button(); ?>
				</form>
			</div>
			<div style="clear:both;"></div>
		<?php } ?>    <!-- <hr class="hrdivide"> -->
		<div class="pro-options">
			<h1><?php echo $plugin_data['Name']; ?> PRO!</h1>

			<div class="instr-vid">
				<iframe width="560" height="315" src="http://www.youtube.com/embed/Li-rtW0drq4" frameborder="0" allowfullscreen></iframe>
			</div>
			<div style="clear:both;"></div>
			<div id="link-btns">
				<a href="http://gator.johnnyakzam.com/cart.php" target="_blank">
					<img class="aligncenter size-full wp-image-212" alt="Post List Featured Image Pro"
					     src="http://jaggededgemedia.com/wp-content/uploads/2013/05/go-pro.png" width="300"
					     height="100" />
				</a>
				<h2>Only $10</h2>
			</div>
		</div>
	</div>
	<div class="settings-sidebar">
		<ul style="list-style-type:none;">
			<li><a href="http://jaggededgemedia.com/plugins/" target="_blank">
					<img class="aligncenter  wp-image-121"
					     title="Jagged Edge Media - Plugins"
					     alt="Jagged Edge Media - Plugins"
					     src="http://jaggededgemedia.com/wp-content/uploads/2013/05/cropped-logo-icon-lg-300x60.png"
					     width="292" height="59" /></a></li>
			<li>
				<div class="fb-like" data-href="https://www.facebook.com/JaggedEdgeMedia" data-send="true"
				     data-layout="button_count" data-width="450" data-show-faces="false" data-font="tahoma"></div>
			</li>
			<li><a href="http://wordpress.org/support/plugin/post-list-featured-image" target="_blank"><img
						class="aligncenter size-full wp-image-213" alt="Premium Support"
						src="http://jaggededgemedia.com/wp-content/uploads/2013/05/support-btn.png" width="273"
						height="100" /></a></li>
			<li>
				<div class="fb-like-box" data-href="http://www.facebook.com/jaggededgemedia" data-width="292"
				     data-height="520" data-show-faces="true" data-stream="true" data-show-border="false"
				     data-header="true"></div>
			</li>
			<li><p id="pro-sup"><a href="http://gator.johnnyakzam.com/supporttickets.php" target="_blank">For Pro Support Only</a></p></li>
		</ul>
	</div>
</div>