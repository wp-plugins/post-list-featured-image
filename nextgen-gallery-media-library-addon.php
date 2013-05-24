<?php
/*
Plugin Name: NextGEN Gallery Media Library Addon
Plugin URI: http://jaggededgemedia.com/plugins/nextgen-gallery-media-library-addon/
Description: An addon to NextGEN Gallery plugin.
Version: 0.2.1
Author: Jagged Edge Media
Author URI: http://jaggededgemedia.com/
 */
/*
This file is part of NextGEN Gallery Media Library Addon.
NextGEN Gallery Media Library Addon is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
NextGEN Gallery Media Library Addon is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
if (!defined('ABSPATH') ||
        preg_match('#' . basename(__FILE__) . '#',
                                  $_SERVER['PHP_SELF']))
        die("You are not allowed to call this page directly.");

require_once('nggmla-class.php');

add_action('plugins_loaded', 'sngg_init');
function sngg_init() {
    $GLOBALS['nggmla'] = new NextGenGalleryMediaLibraryAddon();
}