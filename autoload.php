<?php
if ( !defined( 'ABSPATH' ) || preg_match(
		'#' . basename( __FILE__ ) . '#',
		$_SERVER['PHP_SELF']
	)
) {
	die( "You are not allowed to call this page directly." );
}

class Post_List_Featured_Image_Loader {

	public static function init() {
		spl_autoload_register( array( 'Post_List_Featured_Image_Loader', 'autoload' ) );

		add_action( 'init', array( 'Post_List_Featured_Image_Loader', 'load_plugin_textdomain' ) );

		if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
			add_action( 'admin_notices', array( 'Post_List_Featured_Image_Loader', 'required_php_version' ) );

			return;
		}

		/*register_activation_hook( __FILE__, array( Admin::instance(), 'activation_actions' ) );
		register_deactivation_hook( __FILE__, array( Admin::instance(), 'deactivation_actions' ) );*/

		add_action( 'plugins_loaded', array( \PostListFeaturedImage\Controller\Admin::instance(), 'init' ) );
		add_action( 'plugins_loaded', array( \PostListFeaturedImage\Controller\Front::instance(), 'init' ) );
	}

	public static function load_plugin_textdomain() {
		load_plugin_textdomain( PLFI_DOMAIN, false, PLFI_DOMAIN . '/languages' );
	}

	public static function autoload( $class ) {
		if ( 'PostListFeaturedImage' !== mb_substr( $class, 0, 21 ) ) {
			return;
		}

		$file = PLFI_PLUGIN_DIR_PATH . str_replace( '\\', '/', $class ) . '.php';
		if ( file_exists( $file ) ) {
			require_once( $file );
		} else {
			$error = new WP_Error( 'class_not_found', 'Class ' . $class . ' not found!<br>' . $file );
			echo $error->get_error_message( 'class_not_found' );
		}
	}

	public static function required_php_version() {
		?>
		<div class='error' id='message'>
			<p><?php _e( 'Post List Featured Image plugin requires at least PHP 5.3.0 to work properly.', PLFI_DOMAIN ) ?></p>
		</div>
	<?php
	}
}

Post_List_Featured_Image_Loader::init();
