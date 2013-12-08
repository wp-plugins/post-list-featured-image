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
    (function ( d, s, id ) {
        var js, fjs = d.getElementsByTagName( s )[0];
        if ( d.getElementById( id ) ) {
            return;
        }
        js = d.createElement( s );
        js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=404710116249124";
        fjs.parentNode.insertBefore( js, fjs );
    }( document, 'script', 'facebook-jssdk' ));
</script>
<div class="wrap">
    <div class="settings-content">
        <?php screen_icon( 'upload' ); ?>
        <h2><?php echo $plugin_data['Name']; ?> Settings</h2>
        <?php
        if (!current_user_can( 'manage_options' )) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', PLFI_DOMAIN ) );
        } else {
        settings_errors();
        ?>
    </div>
    <div style="clear:both;"></div>
    <div class="settings-content">
        <div id="plfi-settings-tabs">
            <ul>
                <li><a href="#plfi-overview"><?php _e( 'Overview' ); ?></a></li>
                <li><a href="#plfi-settings">PLFI <?php _e( 'Settings' ); ?></a></li>
                <li><a href="#plfi-pro-option">PLFI Pro Addon</a></li>
                <li><a href="#plfi-help"><?php _e( 'Help & Support', PLFI_DOMAIN ); ?></a></li>
            </ul>
            <div id="plfi-overview">
                <?php include 'overview-tab.php'; ?>
            </div>
            <div id="plfi-settings" class="settings-box">
                <form id="plfi-settings-form" action="options.php" method="post">
                    <?php settings_fields( 'plfi_plugin_settings' ); ?>
                    <?php do_settings_sections( 'plfi-plugin-settings-section' ); ?>
                    <?php submit_button(); ?>
                </form>
                <div style="clear:both;"></div>
            </div>
            <div id="plfi-pro-option" class="pro-options">
                <?php include 'addon-tab.php'; ?>
            </div>
            <div id="plfi-help">
                <?php include 'help-tab.php'; ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="settings-sidebar">
        <?php include 'plfi-setings-sidebar.php'; ?>
    </div>
</div>
