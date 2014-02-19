<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'TorchTech Theme' );

/** Add structural wraps */
add_theme_support( 'genesis-structural-wraps', array(
	'header', 
	'inner', 
	'footer-widgets', 
	'footer' 
) );

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Register widget areas */
$sidebars = array(
	'slider'	=> 'Slider',
	'intro'		=> 'Intro',
	'featured'	=> 'Featured'
);

foreach( $sidebars as $id => $title ) {
	genesis_register_sidebar( array(
		'id'	=> $id,
		'name'	=> $title
	) );
}

/** Change breadcrumb text */
add_filter('genesis_breadcrumb_args', 'torchtech_breadcrumb_args');
function torchtech_breadcrumb_args($args) {
    $args['labels']['prefix'] = '';
    return $args;
}

/** Change copyright text */
add_filter('genesis_footer_creds_text', 'torchtech_footer_creds_text');
function torchtech_footer_creds_text($creds) {
 $creds = '[footer_copyright] New York University';
 return  $creds;
}

/** Add event navigation on event subpages */
add_action('genesis_before_sidebar_widget_area','torchtech_add_event_nav');
function torchtech_add_event_nav() {
	global $post;
	$post_parents = get_post_ancestors($post->ID);
	foreach($post_parents as $parent_id) {
		if($parent_id == 92) {
			echo "<ul id='event_nav'>";
			if (count($post_parents) == 2) {
  				wp_list_pages("depth=1&title_li=&child_of=".$post->post_parent);
			} elseif (count($post_parents) > 2) {
				wp_list_pages("depth=1&title_li=&child_of=".$post_parents[1]);
			} else {
  				wp_list_pages("depth=1&title_li=&child_of=".$post->ID);
			}

	  		echo "</ul>";
			break;
		}
	}
}

/** Remove setting options for non-admins */
if(!current_user_can( 'administrator')) {
	/** Remove Genesis Layout Settings */
	remove_theme_support( 'genesis-inpost-layouts' );

	/** Remove Genesis in-post SEO Settings */
	remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );

	/** Remove Twitter Tracker settings */
	add_filter('tt_post_types_with_override',array( 'page', 'post' ));

	/** Remove HTTPS and Fetured Image Metaboxes */
	add_action( 'do_meta_boxes', 'remove_meta_boxes' );
	function remove_meta_boxes() {
		remove_meta_box( 'postimagediv', 'page', 'side' );
		remove_meta_box( 'wordpress-https', 'page', 'side' );
	}
}
