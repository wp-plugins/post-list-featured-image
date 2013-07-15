<?php
/*
Plugin Name: NextGEN Gallery Media Library Addon
Plugin URI: http://jaggededgemedia.com/plugins/nextgen-gallery-media-library-addon/
Description: An addon to NextGEN Gallery plugin.
Version: 0.3.0
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
if ( !defined( 'ABSPATH' ) || preg_match( '#' . basename( __FILE__ ) . '#',
                                          $_SERVER['PHP_SELF']
	)
) {
	die( "You are not allowed to call this page directly." );
}

/**
 * Plugin file constants
 */
define( 'NGGMLA_PLUGIN_SLUG', plugin_basename( __FILE__ ) );
define( 'NGGMLA_PLUGIN_FILE', __FILE__ );
define( 'NGGMLA_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'NGGMLA_DOMAIN', basename( dirname( __FILE__ ) ) );
define( 'NGGMLA_MEDIA_TAGS_QUERYVAR', 'sngg_media_tags' );
define( 'NGG_PLUGIN', 'nextgen-gallery/nggallery.php' );
define( 'NGG_PLUGIN_NAME', 'NextGEN Gallery' );

require_once( 'nggmla-class.php' );

add_action( 'plugins_loaded', array( NextGenGalleryMediaLibraryAddon::get_instance(), 'init' ) );