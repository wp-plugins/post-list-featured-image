<?php
/*
* Settings Sidebar File
*/
?>

<aside id="set-header">
    <div class="set-widget">
        <a href="http://jaggededgemedia.com/plugins/" target="_blank">
            <img class="aligncenter  wp-image-121" id="jem-logo" title="Jagged Edge Media - Plugins" alt="Jagged Edge Media - Plugins"
                 src="http://jaggededgemedia.com/wp-content/uploads/2013/05/cropped-logo-icon-lg-300x60.png" />
        </a>

        <div style="clear:both;"></div>
        <div class="fb-like" data-href="https://www.facebook.com/JaggedEdgeMedia" data-send="true"
             data-layout="button_count" data-width="450" data-show-faces="false" data-font="tahoma"></div>
    </div>
</aside>
<aside>
    <h2 id="side-title"><?php _e( 'Twitter Updates', PLFI_DOMAIN ); ?></h2>

    <div class="set-widget">
        <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/JaggedEdgeMedia"
           data-widget-id="401196566704185346">Tweets by @JaggedEdgeMedia</a>
        <script>!function ( d, s, id ) {
                var js, fjs = d.getElementsByTagName( s )[0], p = /^http:/.test( d.location ) ? 'http' : 'https';
                if ( !d.getElementById( id ) ) {
                    js = d.createElement( s );
                    js.id = id;
                    js.src = p + "://platform.twitter.com/widgets.js";
                    fjs.parentNode.insertBefore( js, fjs );
                }
            }( document, "script", "twitter-wjs" );</script>
    </div>
</aside>
<aside>
    <h2 id="side-title"><?php _e( 'Join Us on Facebook', PLFI_DOMAIN ); ?></h2>

    <div class="set-widget">
        <div class="fb-like-box" data-href="http://www.facebook.com/jaggededgemedia" data-width="98%" data-height="304"
             data-show-faces="true" data-stream="false" data-show-border="false" data-header="false"></div>
    </div>
</aside>
<aside id="lastside">
    <h2 id="side-title"><?php _e( 'JEM News Update', PLFI_DOMAIN ); ?></h2>

    <div class="set-widget">
        <!--<script type="text/javascript" src="http://forms.aweber.com/form/45/1831010845.js"></script>-->
	    <?php
	    /**
	     * @var SimplePie $jem_news_feed
	     * @var SimplePie $item
	     */
	    $jem_news_feed = fetch_feed( 'http://jaggededgemedia.com/feed' );
	    if ( !is_wp_error( $jem_news_feed ) ) {
		    $max_items = $jem_news_feed->get_item_quantity( 5 );
		    $news_items = $jem_news_feed->get_items( 0, $max_items );
		    
		    if ( $max_items > 0 ) {
			    ?>
			    <ul>
				    <?php
				    foreach ( $news_items as $item ) {
					    printf( '<li><a href="%s">%s</a></li>', esc_url( $item->get_permalink() ), esc_html( $item->get_title() ) );
				    }
				    ?>
			    </ul>
		    <?php
		    } else {
			    _e( '<p>No items fetched from feed. You may visit <a href="http://jaggededgemedia.com/">Jagged Edge Media site</a> to check on our latest news.</p>', PLFI_DOMAIN );
		    }
	    } else {
		    _e( '<p>Error fetching feed...</p>', PLFI_DOMAIN );
	    }
	    ?>
    </div>
</aside>
