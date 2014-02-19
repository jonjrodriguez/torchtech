<?php 
/* 
Template Name: Session Template
*/ 

remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'tt_custom_content');

function tt_custom_content() {
	$login = wp_login_url( get_permalink() );
	if(!is_user_logged_in()) {
		echo "<p><a class='simplemodal-login' href='$login'>Please login using your NetID and password</a> to create new session notes, or to modify existing content.</p><br />";
	}

	global $post;
	$children = get_pages('child_of='.$post->ID); ?>
	<table>
		<thead>
			<tr class="odd">
				<th>Session Name</th>
				<th>Author</th>
			</tr>
		</thead>
		<tbody>
	<?php
  	foreach ($children as $child) { ?>
 		<tr>
			<td><a href="<?php echo get_page_link( $child->ID ); ?>"><?php echo $child->post_title; ?></a></td>
			<td><?php the_author_meta( 'display_name', $child->post_author) ?></td>
		</tr>
	<?php
	}

	echo '</tbody></table>';
}

genesis();

?> 