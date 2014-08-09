<?php
/*
Plugin Name: Post List Featured Image
Plugin URI: http://jaggededgemedia.com/blog/post-list-featured-image/
Description: Adds a featured image column in admin Posts/Pages list.
Version: 0.5.1
Author: Jagged Edge Media
Author URI: http://jaggededgemedia.com/
License: GPL v2 or later
*/
/*
This file is part of Post List Featured Image.

Post List Featured Image is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Post List Featured Image is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/gpl-3.0.html>.
*/

if ( !defined( 'ABSPATH' ) || preg_match(
		'#' . basename( __FILE__ ) . '#',
		$_SERVER['PHP_SELF']
	)
) {
	die( "You are not allowed to call this page directly." );
}

define( 'PLFI_PLUGIN_SLUG', plugin_basename( __FILE__ ) );
define( 'PLFI_PLUGIN_FILE', __FILE__ );
define( 'PLFI_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLFI_DOMAIN', dirname( PLFI_PLUGIN_SLUG ) );

require_once( 'autoload.php' );
