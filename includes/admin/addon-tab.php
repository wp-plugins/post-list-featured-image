<?php
/*
* Basic HTML for Pro Addon Tab
*/
?>

<h1><?php echo $plugin_data['Name']; ?> PRO!</h1>

<div class="instr-vid">
    <iframe width="853" height="480" src="//www.youtube.com/embed/7U9qeSbL_ys" frameborder="0" allowfullscreen></iframe>
</div>
<div style="clear:both;"></div>
<div id="link-btns">
    <a href="http://jaggededgemedia.com/pro-plugins-shop/" target="_blank">
        <img id="sup-img" alt="Post List Featured Image Pro"
             src="http://jaggededgemedia.com/wp-content/uploads/2013/05/go-pro.png" width="300" height="100"/>
    </a>
</div>
<div class="pro-features">
    <?php
    if ( !empty( $readme ) ) {
        printf(
            __( '<h2>Pro Addon Features:</h2>%s', PLFI_DOMAIN ),
            $readme['sections']['pro_features']
        );
    }
    ?>
</div>
<?php include 'plfi-set-footer.php'; ?>
