<?php
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}
?>
<div class="wrap">
    <div class="icon32" id="icon-nextgen-gallery"></div>
    <h2>NextGEN Gallery Media Library Addon</h2>
</div>