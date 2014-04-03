<?php
/*
* Basic HTML for Overview Tab
*/
if ( !defined( 'ABSPATH' ) || preg_match(
        '#' . basename( __FILE__ ) . '#',
        $_SERVER['PHP_SELF']
    )
) {
    die( "You are not allowed to call this page directly." );
}
?>
<div class="instr-use">
    <div class="instr-inner">
        <div id="pro-notice"><?php _e( "SEE WHAT'S NEW IN THE PRO VERSION!", PLFI_DOMAIN ); ?></div>
        <?php
        if ( !empty( $readme ) ) {
            printf(
                __( '<h3>Instructions and Usage:</h3>%s', PLFI_DOMAIN ),
                $readme['sections']['instructions_and_usage']
            );
            printf( __( '<h3>Changelog:</h3>%s', PLFI_DOMAIN ), $readme['sections']['changelog'] );
        }

        do_action( 'plfi_usage_instructions', $readmeParser, $readme );
        ?>
    </div>
    <div class="settings-sidebar">
        <?php include 'plfi-setings-sidebar.php'; ?>
    </div>
</div>
<?php include 'plfi-set-footer.php'; ?>
