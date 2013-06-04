<?php
/**
 * Main plugin file
 *
 * @package Post_List_Featured_Image
 * @since   0.1.0
 */
/*
Plugin Name: Post List Featured Image
Plugin URI: http://jaggededgemedia.com/plugins/post-list-featured-image/
Description: Adds a featured image column in admin Posts/Pages list.
Version: 0.2.0
Author: Jagged Edge Media
Author URI: http://jaggededgemedia.com
License: GPLv2 or later
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
along with Foobar.  If not, see <http://www.gnu.org/licenses/gpl-3.0.html>.
*/

if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
	exit('This page cannot be called directly.');
}

class PostListFeaturedImage {

	const default_thumb_size = 100;

	protected static $instance = null;

	protected $column_slug = 'featured_image';

	protected $thumb_slug = 'admin-thumbs';

	protected $hook_suffix;

	protected $plugin_file_path;
	
	protected $plugin_slug;
	
	protected $plugin_options_key;

	/**
	 * PHP4 constructor
	 */
	public function PostsListFeaturedImage() {
		$this->__construct();
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->plugin_slug = plugin_basename(__FILE__);
		$this->plugin_file_path = __FILE__;
	}

	public static function get_instance() {
		null === self::$instance && self::$instance = new self;

		return self::$instance;
	}

	public function get_column_slug() {
		return $this->column_slug;
	}

	public function get_thumb_slug() {
		return $this->thumb_slug;
	}

	public function get_plugin_file_path() {
		return $this->plugin_file_path;
	}

	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	public function get_hook_suffix() {
		return $this->hook_suffix;
	}

	public function get_options_key(){
		return $this->plugin_options_key;
	}

	public function init() {
		if (function_exists('add_theme_support')) {
			$this->plugin_options_key = 'plfi_plugin_settings';
			$options = get_option($this->plugin_options_key);
			if ($options['thumb_size']) {
				add_image_size($this->thumb_slug, $options['thumb_size'], $options['thumb_size']);
			} else {
				add_image_size($this->thumb_slug, self::default_thumb_size, self::default_thumb_size);
			}
			add_filter("plugin_action_links_" . $this->plugin_slug, array(&$this, 'add_settings_link'));
			add_action('admin_menu', array(&$this, 'add_settings_page'));
			add_action('admin_init', array(&$this, 'register_plugin_settings'));
			add_filter('manage_posts_columns', array(&$this, 'posts_columns'), 5);
			add_filter('manage_pages_columns', array(&$this, 'posts_columns'), 5);
			add_action('manage_posts_custom_column', array(&$this, 'posts_custom_columns'), 5, 2);
			add_action('manage_pages_custom_column', array(&$this, 'posts_custom_columns'), 5, 2);
		}
	}

	/**
	 * Add "Featured Image" label column.
	 *
	 * @param $defaults array Default column names.
	 *
	 * @return array An array of column names.
	 */
	public function posts_columns($defaults) {
		$defaults[$this->column_slug] = __('Featured Image');

		return $defaults;
	}

	/**
	 * Display post/page featured image.
	 *
	 * @param $column_name string Current column in the loop.
	 * @param $id          Current post id in the loop.
	 */
	public function posts_custom_columns($column_name, $id) {
		if ($column_name === $this->column_slug) {
			$attr = array(
				'data-imgid' => get_post_thumbnail_id($id)
			);
			the_post_thumbnail($this->thumb_slug, $attr);
		}
	}

	/**
	 * Add "Settings" action link.
	 *
	 * @param $links array Default action links.
	 *
	 * @return mixed array Modified actions links.
	 */
	public function add_settings_link($links) {
		$plugin_settings_link = '<a href="upload.php?page=plfi-settings">Settings</a>';
		array_unshift($links, $plugin_settings_link);

		return $links;
	}

	/**
	 * Add "Featured Image Settings" submenu to Settings.
	 */
	public function add_settings_page() {
		$plugin_data       = $this->get_plugin_data();
		$this->hook_suffix = add_media_page($plugin_data['Name'],
		                                    'Featured Image Settings',
		                                    'manage_options',
		                                    'plfi-settings',
		                                    array(&$this, 'render_settings_page'));
		add_action('admin_enqueue_scripts', array(self::get_instance(), 'settings_page_css'));
	}

	public function settings_page_css($hook_suffix) {
		if ($hook_suffix == $this->hook_suffix) {
			wp_enqueue_style('plfi-settings-style', plugins_url('includes/admin/css/styles.css', __FILE__));
		}
	}

	/**
	 * Render plugin settings page HTML.
	 */
	public function render_settings_page() {
		$plugin_data = $this->get_plugin_data();
		require_once('includes/admin/plugin-settings-page.php');
	}

	public function register_plugin_settings() {
		register_setting('plfi_plugin_settings',
		                 'plfi_plugin_settings',
		                 array(&$this, 'plfi_plugin_settings_validate'));
		/* THUMBNAIL SIZE OPTIONS */
		add_settings_section('featured_image_thumb_size',
		                     'Featured Image Thumbnail Size',
		                     '__return_false',
		                     'plfi-plugin-settings-section');
		add_settings_field('thumb_size',
		                   'Thumbnail Size',
		                   array(&$this, 'plfi_plugin_settings_fields'),
		                   'plfi-plugin-settings-section',
		                   'featured_image_thumb_size',
		                   array('field' => 'thumb_size')
		);
		do_action('plfi_settings_field');
	}

	public function plfi_plugin_settings_fields($args) {
		$args    = (object)$args;
		$options = get_option($this->plugin_options_key);
		switch ($args->field) {
			case 'thumb_size':
				$sizes = array(150, 100, 50);
				foreach ($sizes as $size) {
					if ($options['thumb_size'] && $options['thumb_size'] == $size) {
						$checked = ' checked="checked"';
					} else if (!$options['thumb_size'] && $size == self::default_thumb_size) {
						$checked = ' checked="checked"';
					} else {
						$checked = '';
					}
					?>
					<input type="radio" name="plfi_plugin_settings[thumb_size]"
					       value="<?php echo $size; ?>"<?php echo $checked; ?>>
					<?php
					echo $size . ' x ' . $size . 'px<br>';
				}
				break;
			default:
				echo "Unknown field: $args->field";
		}
	}

	public function plfi_plugin_settings_validate($input) {
		if (empty($input['thumb_size'])) {
			$input['thumb_size'] = 100;
		}

		return $input;
	}

	/*-----------------------------------------------------------
	 |                      PRIVATE ACCESS
	 -----------------------------------------------------------*/

	/**
	 * Similar to WP's is_plugin_active function.
	 * Check whether the plugin is active by checking the active_plugins list.
	 *
	 * @param string $plugin Base plugin path from plugins directory.
	 *
	 * @return bool True, if in the active plugins list. False, not in the list.
	 */
	private function is_plugin_active($plugin) {
		return in_array($plugin,
		                (array)get_option('active_plugins', array())) || $this->is_plugin_active_for_network($plugin);
	}

	/**
	 * Similar to WP's is_plugin_active_for_network function.
	 * Check whether the plugin is active for the entire network.
	 *
	 * @param string $plugin Base plugin path from plugins directory.
	 *
	 * @return boolean True, if active for the network, otherwise false.
	 */
	private function is_plugin_active_for_network($plugin) {
		if (!is_multisite()) {
			return false;
		}
		$plugins = get_site_option('active_sitewide_plugins');
		if (isset($plugins[$plugin])) {
			return true;
		}

		return false;
	}

	/**
	 * Retrieve plugin data from plugin's header.
	 *
	 * @return array The plugin's metadata.
	 */
	private function get_plugin_data($file = __FILE__) {
		$default_headers = array(
			'Name'        => 'Plugin Name',
			'PluginURI'   => 'Plugin URI',
			'Version'     => 'Version',
			'Description' => 'Description',
			'Author'      => 'Author',
			'AuthorURI'   => 'Author URI',
			'TextDomain'  => 'Text Domain',
			'DomainPath'  => 'Domain Path',
			'Network'     => 'Network',
			// Site Wide Only is deprecated in favor of Network.
			'_sitewide'   => 'Site Wide Only',
		);

		return get_file_data($file, $default_headers, 'plugin');
	}
}

add_action('plugins_loaded', array(PostListFeaturedImage::get_instance(), 'init'), 7);
