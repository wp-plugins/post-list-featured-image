<?php
/*
* Basic HTML for Overview Tab
*/
?>

<div class="instr-use">
    <h1><?php _e( 'Instructions and Usage', PLFI_DOMAIN ); ?></h1>

    <h3><?php _e( 'Basic Settings', PLFI_DOMAIN ); ?></h3>
    <ul>
        <li><h3><?php _e( 'Thumbnail Size', PLFI_DOMAIN ); ?></h3>

            <p><?php _e( 'Choose between 50px, 100px and 150px', PLFI_DOMAIN ); ?></p></li>
        <li><h3><?php _e( 'Sorting by Featured Image', PLFI_DOMAIN ); ?></h3>

            <p><?php _e(
                    'On the Post/Page list pages of the Admin area, click on the Featured Image column heading to sort by Featured Image ID.',
                    PLFI_DOMAIN
                ); ?></p></li>
        <li><h3><?php _e( 'Filtering by Featured Image', PLFI_DOMAIN ); ?></h3>

            <p><?php _e(
                    'On the Post/Page list pages of the Admin area, Choose to Filter the posts by "Show All Posts with Featured Image" or "Show All Posts without Featured Image"',
                    PLFI_DOMAIN
                ); ?></p>

            <p><?php _e(
                    'This is especially helpful for assigning new featured image to posts that do not have them. Or this helps with large sites, with many posts, and editing the post featured images for those posts using the "Quick Edit" feature, available with the <b>Pro Addon</b>',
                    PLFI_DOMAIN
                ); ?></p></li>
    </ul>
    <p><b>*</b><em><?php _e(
            'Please remember, if you do not see the Featured Image column in your Post/Page Lists to click on "Screen Options" in the upper right corner, and tick the box for</em> Featured Image.',
            PLFI_DOMAIN
        ); ?></p>
</div>
<?php include 'plfi-set-footer.php'; ?>
