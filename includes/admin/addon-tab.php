<?php
/*
* Basic HTML for Pro Addon Tab
*/
?>

    <h1><?php echo $plugin_data['Name']; ?> PRO!</h1>

    <div class="instr-vid">
        <iframe width="560" height="315" src="//www.youtube.com/embed/7RaZmPWODfY" frameborder="0"
                allowfullscreen></iframe>
    </div>
    <div style="clear:both;"></div>
    <div id="link-btns">
        <a href="http://jaggededgemedia.com/pro-plugins-shop/" target="_blank">
            <img id="sup-img" alt="Post List Featured Image Pro"
                 src="http://jaggededgemedia.com/wp-content/uploads/2013/05/go-pro.png" width="300" height="100"/>
        </a>
    </div>
    <div class="pro-features">
        <h2>Pro Addon <?php _e( 'Features', PLFI_DOMAIN ); ?></h2>
        <ul>
            <li><?php _e( 'QUICK EDIT on Post/Page List pages', PLFI_DOMAIN ); ?></li>
            <li><b><em><?php _e( 'NEW!', PLFI_DOMAIN ); ?></em></b> <?php _e(
                    'Support for Custom Post Types',
                    PLFI_DOMAIN
                ); ?></li>
            <li><b><em><?php _e( 'NEW!', PLFI_DOMAIN ); ?></em></b> <?php _e(
                    'Image filtering through the Quick Edit Media Library function',
                    PLFI_DOMAIN
                ); ?></li>
        </ul>
    </div>
<?php include 'plfi-set-footer.php'; ?>
