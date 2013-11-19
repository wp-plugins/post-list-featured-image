<?php
/*
* Basic HTML for Pro Addon Tab
*/
?>
<div class="help-issues">
    <h1><?php _e( 'Experiencing Issues?', PLFI_DOMAIN ); ?></h1>

    <h2><?php _e( 'JEM Help and Support', PLFI_DOMAIN ); ?></h2>

    <p><?php printf(
            __(
                'If you are experiencing issues with the Free version of the Plugin, that can be downloaded ' .
                'through the %s, please use the WP %s by clicking on the Support Button below.',
                PLFI_DOMAIN
            ),
            '<a href="http://wordpress.org/plugins/post-list-featured-image/" target="_blank">WordPress Plugin Directory</a>',
            '<a href="http://wordpress.org/support/plugin/post-list-featured-image" target="_blank">Plugin Forum</a>'
        ); ?>
    </p>

    <p>
        <?php
        printf(
            __(
                '<b>*</b><em>Please <b>NOTE:</b> The WordPress Plugin Support forum for Post List Featured Image ' .
                'is <b>ONLY</b> for the <b>FREE</b> version.</em> ' .
                '<a href="http://wordpress.org/support/plugin/post-list-featured-image" target="_blank">
        <img class="aligncenter" id="sup-img" alt="Basic Support" ' .
                'src="http://jaggededgemedia.com/wp-content/uploads/2013/05/support-btn.png" ' .
                'width="273" height="100"/></a>'
            )
        );
        ?>
    </p>

    <div style="clear :both;"></div>
    <h1><?php _e( 'Pro Support Only', PLFI_DOMAIN ); ?></h1>

    <p><?php _e( 'The following link is <b>ONLY</b> for Pro Support. Use this if:', PLFI_DOMAIN ); ?></p>
    <ul>
        <li><p><?php _e(
                    'You have purchased any <b><a href="http://jaggededgemedia.com/pro-plugins-shop/" target="_blank">Pro Addons</a></b> from us,',
                    PLFI_DOMAIN
                ); ?></p></li>
        <li><p><?php _e( '<b>AND</b> you have any issues with the Pro Version', PLFI_DOMAIN ); ?></p></li>
        <li><p><?php _e(
                    '<b>OR</b> you have any issues with the Pro <b>AND/OR</b> the FREE Version',
                    PLFI_DOMAIN
                ); ?></p></li>
        <li><p><?php _e(
                    'We will answer any support issues for our Pro users, through the following link',
                    PLFI_DOMAIN
                ); ?></p></li>
    </ul>
    <p id="pro-sup">
        <a href="http://gator.johnnyakzam.com/supporttickets.php" target="_blank">
            <?php _e( 'For Pro Support ONLY', PLFI_DOMAIN ); ?>
        </a>
    </p>
</div>
<?php include 'plfi-set-footer.php'; ?>
