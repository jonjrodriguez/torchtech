<?php

/** Change layout of home page */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

add_action('genesis_sidebar', 'torchtech_remove_tagline');
function torchtech_remove_tagline() {
	unregister_sidebar('footer-2');
}

add_action( 'genesis_after_header', 'torchtech_after_header');
function torchtech_after_header() {
		if ( is_active_sidebar( 'slider' ) ) {
			
			genesis_widget_area( 'slider', array( 
		
			'before'	=> 	'<div id="slider"><div class="wrap">', 
			'after'	=>	'</div></div><!-- end #slider -->' 
		
		) );
	}
}

remove_action( 'genesis_post_title', 'genesis_do_post_title' );

add_action( 'genesis_before_post_content', 'torchtech_before_post_content');
function torchtech_before_post_content() {
		if ( is_active_sidebar( 'intro' ) ) {

			genesis_widget_area( 'intro', array( 
			
				'before'	=> 	'<div id="intro">', 
				'after'	=>	'</div><!-- end .intro -->' 
			
			) );
	}
}

genesis();