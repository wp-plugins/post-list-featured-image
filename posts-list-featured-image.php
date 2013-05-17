<?php
/*
Plugin Name: Posts List Featured Image
Plugin URI: http://jaggededgemedia.com
Description: Adds a featured image column in admin Posts/Pages list.
Version: 0.1.0
Author: Jagged Edge Media
Author URI: http://jaggededgemedia.com
*/
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
	exit('This page cannot be called directly.');
}

class PostsListFeaturedImage {

	public function PostsListFeaturedImage() {
		$this->__construct();
	}

	public function __construct() {
		if (function_exists('add_theme_support')) {
			add_image_size('admin-thumbs', 100, 100);
			add_filter('manage_posts_columns', array(&$this, 'posts_columns'), 5);
			add_filter('manage_pages_columns', array(&$this, 'posts_columns'), 5);
			add_action('manage_posts_custom_column', array(&$this, 'posts_custom_columns'), 5, 2);
			add_action('manage_pages_custom_column', array(&$this, 'posts_custom_columns'), 5, 2);
		}
	}

	public function posts_columns($defaults) {
		$defaults['featured_image'] = __('Featured Image');

		return $defaults;
	}

	public function posts_custom_columns($column_name, $id) {
		if ($column_name === 'featured_image') {
			echo the_post_thumbnail('admin-thumbs');
		}
	}

}

global $plfi;
$plfi = new PostsListFeaturedImage();