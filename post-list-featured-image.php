<?php
/*
Plugin Name: Post List Featured Image
Plugin URI: http://jaggededgemedia.com/plugins/post-list-featured-image/
Description: Adds a featured image column in admin Posts/Pages list.
Version: 0.3.6
Author: Jagged Edge Media
Author URI: http://jaggededgemedia.com
License: GPLv2 or later
*/
/**
 * Main plugin file
 *
 * @package Post_List_Featured_Image
 * @since   0.1.0
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

if ( !defined( 'ABSPATH' ) || preg_match(
        '#' . basename( __FILE__ ) . '#',
        $_SERVER['PHP_SELF']
    )
) {
    die( "You are not allowed to call this page directly." );
}

define( 'PLFI_DOMAIN', dirname( plugin_basename( __FILE__ ) ) );

class PostListFeaturedImage {

    const default_thumb_size = 100;

    protected static $instance = null;

    protected $column_slug = 'featured_image';

    protected $thumb_slug = 'admin-thumbs';

    protected $supported_post_types;

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
        $this->plugin_slug        = plugin_basename( __FILE__ );
        $this->plugin_file_path   = __FILE__;
        $this->plugin_options_key = 'plfi_plugin_settings';
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

    public function get_options_key() {
        return $this->plugin_options_key;
    }

    /**
     * Initialize plugin
     */
    public function init() {
        load_plugin_textdomain( PLFI_DOMAIN, false, PLFI_DOMAIN . '/lang/' );

        if ( function_exists( 'add_theme_support' ) ) {
            $options                    = get_option( $this->plugin_options_key );
            $this->supported_post_types = apply_filters( 'plfi_supported_post_types', array( 'post', 'page' ) );
            if ( $options['thumb_size'] ) {
                add_image_size( $this->thumb_slug, $options['thumb_size'], $options['thumb_size'] );
            } else {
                add_image_size( $this->thumb_slug, self::default_thumb_size, self::default_thumb_size );
            }

            add_action( 'admin_menu', array( &$this, 'add_settings_page' ) );
            add_action( 'admin_init', array( &$this, 'register_plugin_settings' ) );
            add_action( 'admin_enqueue_scripts', array( &$this, 'settings_page_scripts' ) );
            add_action( 'plfi_settings_tab_content', array( &$this, 'settings_tab_content' ) );

            add_filter( "plugin_action_links_" . $this->plugin_slug, array( &$this, 'add_settings_link' ) );

            if ( !empty( $this->supported_post_types ) ) {
                foreach ( $this->supported_post_types as $post_type ) {
                    add_action(
                        "manage_{$post_type}_posts_custom_column",
                        array( &$this, 'posts_custom_columns' ),
                        5,
                        2
                    );

                    add_filter( "manage_{$post_type}_posts_columns", array( &$this, 'posts_columns' ), 5, 2 );
                    add_filter( "manage_edit-{$post_type}_sortable_columns", array( &$this, 'post_sortable_columns' ) );
                    add_filter( "pre_get_posts", array( &$this, 'orderby_featured_image_title' ) );
                    add_filter( "pre_get_posts", array( &$this, 'filter_list_table_by_featured_image' ) );
                    add_action(
                        "restrict_manage_posts",
                        array( &$this, 'filter_list_table_by_featured_image_dropdown' )
                    );
                }
            }
        }
    }

    /**
     * Add "Featured Image" label column.
     *
     * @param $defaults array Default column names.
     *
     * @return array An array of column names.
     */
    public function posts_columns( $defaults ) {
        $defaults[$this->column_slug] = __( 'Featured Image' );

        return $defaults;
    }

    /**
     * Add Featured Image column to sortable columns.
     *
     * @param array $columns All sortable columns.
     *
     * @return array The modified array of sortable columns.
     */
    public function post_sortable_columns( $columns = array() ) {
        $columns[$this->column_slug] = $this->column_slug;

        return $columns;
    }

    /**
     * Display post/page featured image.
     *
     * @param $column_name string Current column in the loop.
     * @param $id          int Current post id in the loop.
     */
    public function posts_custom_columns( $column_name, $id ) {
        if ( $column_name === $this->column_slug ) {
            $attr = array(
                'data-imgid' => get_post_thumbnail_id( $id )
            );
            the_post_thumbnail( $this->thumb_slug, $attr );
        }
    }

    /**
     * Order posts by featured image id
     *
     * @param $query
     */
    public function orderby_featured_image_title( $query ) {
        if ( !is_admin() ) {
            return;
        }

        $order_by = $query->get( 'orderby' );

        if ( $order_by === $this->column_slug ) {
            $query->set( 'meta_key', '_thumbnail_id' );
            $query->set( 'orderby', 'meta_value_num' );
        }
    }

    public function filter_list_table_by_featured_image_dropdown() {
        global $wp_query, $typenow;

        if ( in_array( $typenow, $this->supported_post_types ) ) {
            $post_type = get_post_type_object( $typenow );
            ?>
            <select class="postform" id="plfi_filter" name="plfi_filter" style="max-width: 320px;width: auto;">
                <option value="default"><?php printf(
                        __( 'Show All %s with|without Featured Images', PLFI_DOMAIN ),
                        $post_type->label
                    ); ?></option>
                <option value="all"><?php printf(
                        __( 'Show All %s with Featured Image', PLFI_DOMAIN ),
                        $post_type->label
                    ); ?></option>
                <option value="none"><?php printf(
                        __( 'Show All %s without Featured Image', PLFI_DOMAIN ),
                        $post_type->label
                    ); ?></option>
            </select>
        <?php
        }
    }

    public function filter_list_table_by_featured_image( $query ) {
        global $pagenow;

        if ( !is_admin() ) {
            return;
        }

        $qv = & $query->query_vars;

        if ( $pagenow == 'edit.php' && !empty( $qv['post_type'] ) &&
             in_array( $qv['post_type'], $this->supported_post_types )
        ) {
            if ( empty( $_GET['plfi_filter'] ) ) {
                return;
            }

            if ( $_GET['plfi_filter'] == 'all' ) {
                $query->set( 'meta_key', '_thumbnail_id' );
            } else if ( $_GET['plfi_filter'] == 'none' ) {
                $query->set(
                      'meta_query',
                      array(
                          array(
                              'key'     => '_thumbnail_id',
                              'value'   => 'not exists',
                              'compare' => 'NOT EXISTS'
                          )
                      )
                );
            }
        }
    }

    /**
     * Add "Settings" action link.
     *
     * @param $links array Default action links.
     *
     * @return mixed array Modified actions links.
     */
    public function add_settings_link( $links ) {
        $plugin_settings_link = '<a href="upload.php?page=plfi-settings">' . __( 'Settings' ) . '</a>';
        array_unshift( $links, $plugin_settings_link );

        return $links;
    }

    /**
     * Add "Featured Image Settings" submenu to Settings.
     */
    public function add_settings_page() {
        $plugin_data       = $this->get_plugin_data();
        $this->hook_suffix = add_media_page(
            $plugin_data['Name'],
            __( 'Featured Image Settings', PLFI_DOMAIN ),
            'manage_options',
            'plfi-settings',
            array( &$this, 'render_settings_page' )
        );

        add_action( 'admin_footer-' . $this->hook_suffix, array( &$this, 'settings_page_js' ) );
    }

    /**
     * Enqueue admin stylesheet
     *
     * @param $hook_suffix
     */
    public function settings_page_scripts( $hook_suffix ) {
        if ( $hook_suffix == $this->hook_suffix ) {
            wp_enqueue_style( 'plfi-settings-style', plugins_url( 'includes/admin/css/styles.css', __FILE__ ) );
            wp_enqueue_style(
                'plfi-jqueryui-theme',
                plugins_url( 'includes/admin/css/plfi-jqueryui-theme.css', __FILE__ )
            );
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-tabs' );
        }
    }

    public function settings_page_js() {
        ?>
        <script type="text/javascript">
            jQuery( function () {
                jQuery( "#plfi-settings-tabs" ).tabs();
            } );
        </script>
    <?php
    }

    /**
     * Render plugin settings page HTML.
     */
    public function render_settings_page() {
        $plugin_data = $this->get_plugin_data();

        $tabs = array(
            array(
                'id'    => 'plfi-overview',
                'label' => __( 'Overview', PLFI_DOMAIN )
            ),
            array(
                'id'    => 'plfi-settings',
                'label' => __( 'Main Settings', PLFI_DOMAIN )
            ),
            array(
                'id'    => 'plfi-pro-option',
                'label' => __( 'PLFI Pro Addon', PLFI_DOMAIN )
            ),
            array(
                'id'    => 'plfi-help',
                'label' => __( 'Help & Support', PLFI_DOMAIN )
            )
        );

        $tabs = apply_filters( 'plfi_settings_page_tabs', $tabs );

        require_once( 'includes/admin/plugin-settings-page.php' );
    }

    public function settings_tab_content( $tab ) {
        $readme       = null;
        $readmeParser = null;
        if ( $tab['id'] === 'plfi-overview' || $tab['id'] === 'plfi-pro-option' ) {
            if ( !class_exists( 'CustomAutomatticReadme' ) ) {
                include plugin_dir_path( __FILE__ ) . 'includes/admin/parse-readme.php';
            }

            $request = file_get_contents( plugin_dir_path( __FILE__ ) . 'readme.txt' );
            if ( !empty( $request ) && !is_wp_error( $request ) ) {
                $readmeParser = new CustomAutomatticReadme;

                $readme = $readmeParser->parse_readme_contents( $request );
            }
        }

        switch ( $tab['id'] ) {
            case 'plfi-overview':
                ?>
                <div id="plfi-overview">
                    <?php include plugin_dir_path( __FILE__ ) . 'includes/admin/overview-tab.php'; ?>
                </div>
                <?php
                break;
            case 'plfi-settings':
                ?>
                <div id="plfi-settings" class="settings-box">
                    <form id="plfi-settings-form" action="options.php" method="post">
                        <?php settings_fields( 'plfi_plugin_settings' ); ?>
                        <?php do_settings_sections( 'plfi-plugin-settings-section' ); ?>
                        <?php submit_button(); ?>
                    </form>
                    <div style="clear:both;"></div>
                </div>
                <?php
                break;
            case 'plfi-pro-option':
                ?>
                <div id="plfi-pro-option" class="pro-options">
                    <?php include plugin_dir_path( __FILE__ ) . 'includes/admin/addon-tab.php'; ?>
                </div>
                <?php
                break;
            case 'plfi-help':
                ?>
                <div id="plfi-help">
                    <?php include plugin_dir_path( __FILE__ ) . 'includes/admin/help-tab.php'; ?>
                </div>
                <?php
                break;
            default:
                do_action( 'plfi_settings_tab_content_html', $tab );
        }
    }

    /**
     * Register plugin settings
     */
    public function register_plugin_settings() {
        register_setting(
            'plfi_plugin_settings',
            'plfi_plugin_settings',
            array( &$this, 'plfi_plugin_settings_validate' )
        );
        /* THUMBNAIL SIZE OPTIONS */
        add_settings_section(
            'featured_image_thumb_size',
            __( 'Featured Image Thumbnail Size', PLFI_DOMAIN ),
            '__return_false',
            'plfi-plugin-settings-section'
        );
        add_settings_field(
            'thumb_size',
            __( 'Thumbnail Size', PLFI_DOMAIN ),
            array( &$this, 'plfi_plugin_settings_fields' ),
            'plfi-plugin-settings-section',
            'featured_image_thumb_size',
            array( 'field' => 'thumb_size' )
        );
        do_action( 'plfi_settings_field' );
    }

    /**
     * Settings fields callback
     *
     * @param $args array
     */
    public function plfi_plugin_settings_fields( $args ) {
        $args    = (object) $args;
        $options = get_option( $this->plugin_options_key );
        switch ( $args->field ) {
            case 'thumb_size':
                $sizes = array( 150, 100, 50 );
                foreach ( $sizes as $size ) {
                    if ( $options['thumb_size'] && $options['thumb_size'] == $size ) {
                        $checked = ' checked="checked"';
                    } else if ( !$options['thumb_size'] && $size == self::default_thumb_size ) {
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

    /**
     * @param $input array Posted values
     *
     * @return mixed Sanitized posted values
     */
    public function plfi_plugin_settings_validate( $input ) {
        if ( empty( $input['thumb_size'] ) ) {
            $input['thumb_size'] = 100;
        }

        $input = apply_filters( 'plfi_settings_validate', $input );

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
    private function is_plugin_active( $plugin ) {
        return in_array(
                   $plugin,
                   (array) get_option( 'active_plugins', array() )
               ) || $this->is_plugin_active_for_network( $plugin );
    }

    /**
     * Similar to WP's is_plugin_active_for_network function.
     * Check whether the plugin is active for the entire network.
     *
     * @param string $plugin Base plugin path from plugins directory.
     *
     * @return boolean True, if active for the network, otherwise false.
     */
    private function is_plugin_active_for_network( $plugin ) {
        if ( !is_multisite() ) {
            return false;
        }
        $plugins = get_site_option( 'active_sitewide_plugins' );
        if ( isset( $plugins[$plugin] ) ) {
            return true;
        }

        return false;
    }

    /**
     * Retrieve plugin data from plugin's header.
     *
     * @param string $file
     *
     * @return array The plugin's metadata.
     */
    private function get_plugin_data( $file = __FILE__ ) {
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

        return get_file_data( $file, $default_headers, 'plugin' );
    }
}

add_action( 'plugins_loaded', array( PostListFeaturedImage::get_instance(), 'init' ) );
