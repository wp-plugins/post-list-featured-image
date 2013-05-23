<?php
/*
  Plugin Name: NextGEN Gallery Media Library Addon
  Plugin URI: http://jaggededgemedia.com/plugins/nextgen-gallery-media-library-addon/
  Description: An addon to NextGEN Gallery plugin.
  Version: 0.1.1
  Author: Jagged Edge Media
  Author URI: http://jaggededgemedia.com/
*/
if (!defined('ABSPATH') ||
        preg_match('#' . basename(__FILE__) . '#',
                                  $_SERVER['PHP_SELF']))
        die("You are not allowed to call this page directly.");

require_once('nggml-class.php');

add_action('plugins_loaded', 'nggml_init');
function nggml_init() {
    $GLOBALS['nggml'] = new NextGENMediaLibGallery();
}