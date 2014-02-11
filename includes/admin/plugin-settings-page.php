<?php
/**
 * Plugin settings HTML page
 *
 * @package    Posts_List_Featured_Image
 * @subpackage Posts_List_Featured_Image_Settings
 * @since      0.2.0
 */
if ( !defined( 'ABSPATH' ) || preg_match(
        '#' . basename( __FILE__ ) . '#',
        $_SERVER['PHP_SELF']
    )
) {
    die( "You are not allowed to call this page directly." );
}
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
                <?php foreach ( $tabs as $tab ) { ?>
                    <li><a href="#<?php echo $tab['id']; ?>"><?php echo $tab['label']; ?></a></li>
                <?php } ?>
            </ul>
            <?php foreach ( $tabs as $tab ) { ?>
                <div id="<?php echo $tab['id']; ?>">
                    <?php do_action( 'plfi_settings_tab_content', $tab ); ?>
                </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</div>
