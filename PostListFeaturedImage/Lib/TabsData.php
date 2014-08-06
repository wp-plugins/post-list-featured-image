<?php
namespace PostListFeaturedImage\Lib;

use PostListFeaturedImage\Controller\View;

if ( !defined( 'ABSPATH' ) || preg_match(
		'#' . basename( __FILE__ ) . '#',
		$_SERVER['PHP_SELF']
	)
) {
	die( "You are not allowed to call this page directly." );
}

class TabsData {

	public static function admin_page() {
		$tabs = array(
			array(
				'id'       => 'plugin-overview',
				'template' => View::instance()->make(
				                  array( 'PostListFeaturedImage/overview-tab.php', 'overview-tab.php' ),
				                  array(),
				                  false
					),
				'href'     => '#plugin-overview',
				'title'    => __( 'Overview', PLFI_DOMAIN )
			),
			array(
				'id'       => 'plugin-settings',
				'template' => View::instance()->make(
				                  array( 'PostListFeaturedImage/settings-tab.php', 'settings-tab.php' ),
				                  array(),
				                  false
					),
				'href'     => '#plugin-settings',
				'title'    => __( 'Settings', PLFI_DOMAIN )
			),
			array(
				'id'       => 'plugin-tools',
				'template' => View::instance()->make(
				                  array( 'PostListFeaturedImage/tools-tab.php', 'tools-tab.php' ),
				                  array(),
				                  false
					),
				'href'     => '#plugin-tools',
				'title'    => __( 'Tools', PLFI_DOMAIN )
			),
			array(
				'id'       => 'plugin-help',
				'template' => View::instance()->make(
				                  array( 'PostListFeaturedImage/help-tab.php', 'help-tab.php' ),
				                  array(),
				                  false
					),
				'href'     => '#plugin-help',
				'title'    => __( 'Help', PLFI_DOMAIN )
			),
		);

		return apply_filters( 'plfi_admin_page_tabs', $tabs );
	}

	public static function ms_admin_page() {
		$tabs = array(
			array()
		);

		return apply_filters( 'plfi_ms_admin_page_tabs', $tabs );
	}

	public static function help_content() {
		$help = array(
			array(
				'header'  => __( 'Change "Featured Image Thumbnail Size"', PLFI_DOMAIN ),
				'content' => __(
					'Under <code>Settings</code> tab, select the desired thumbnail size and click ' .
					'<code>Save Changes</code> button.',
					PLFI_DOMAIN
				)
			),
			array(
				'header'  => __( 'Shortcodes', PLFI_DOMAIN ),
				'content' => self::shortcodes_help_html()
			),
			array(
				'header'  => __( 'Support', PLFI_DOMAIN ),
				'content' => sprintf(
					__(
						'Need support for the %s plugin? Visit the support site at <a class="link" href="http://wordpress.org/support/plugin/post-list-featured-image" target="_blank">Wordpress.org</a>.',
						PLFI_DOMAIN
					),
					Helper::get_plugin_data( PLFI_PLUGIN_FILE )->Name
				)
			),
			array(
				'header'  => __( 'Tutorial', PLFI_DOMAIN ),
				'content' => ''
			)
		);

		return apply_filters( 'plfi_admin_page_help_content', $help );
	}

	public static function shortcodes_help_data() {
		$featured_img_params = array(
			'post_id' => __( 'The ID of the post that has the featured image that you want to get.', PLFI_DOMAIN ),
			'size'    => __(
				'The size of the featured image you want returned. <em>Defaults to "thumbnail".</em>',
				PLFI_DOMAIN
			),
			'alt'     => __(
				'"alt" text of the image. <em>Defaults to the "alt" data entered for the image in media library.</em>',
				PLFI_DOMAIN
			),
			'attr'    => __(
				'Any additional attribute(s) you want to put in the returned &lt;img&gt; tag. You can pass a URL-query style value as in "foo=bar&var=foobar".',
				PLFI_DOMAIN
			)
		);

		$featured_img_params_list = '';
		foreach ( $featured_img_params as $param => $param_desc ) {
			$featured_img_params_list .= sprintf(
				'<div class="row"><div class="column-3-desk"><strong>%s</strong></div><div class="column-9-desk">%s</div></div>',
				$param,
				$param_desc
			);
		}

		$help = array(
			array(
				'shortcode' => '[featured_img]',
				'desc'      => sprintf(
					'<p>%s</p><p><em>%s</em></p>%s',
					__( 'Add featured image via shortcode.', PLFI_DOMAIN ),
					__( 'Parameters:', PLFI_DOMAIN ),
					$featured_img_params_list
				)
			)
		);

		return apply_filters( 'plfi_admin_page_help_data', $help );
	}

	public static function shortcodes_help_html() {
		$help_data = self::shortcodes_help_data();
		$html      = '<div class="row shortcodes-help-row">';
		if ( !empty( $help_data ) ) {
			ob_start();
			foreach ( (array) $help_data as $h ) {
				?>
				<div class="column-3-desk shortcode-col">
					<div class="row">
						<div class="column-12-desk"><code><?php echo $h['shortcode']; ?></code></div>
					</div>
				</div>
				<div class="column-9-desk shortcode-desc-col">
					<?php echo $h['desc']; ?>
				</div>
			<?php
			}
			$html .= ob_get_clean();
		}
		$html .= '</div>';

		return apply_filters( 'plfi_admin_page_shortcode_help_html', $html );
	}
}
