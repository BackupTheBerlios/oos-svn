<?php
/**
 * @package WordPress
 * @subpackage MyOOS_Theme
 */


// Remove the links to the extra feeds such as category feeds 
remove_action( 'wp_head', 'feed_links_extra', 3 );

// Remove links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'feed_links', 2 );

// Remove the link  EditURI link
remove_action( 'wp_head', 'rsd_link');

// Remove  Windows Live Writer manifest file
remove_action( 'wp_head', 'wlwmanifest_link');

// Remove Index Link
remove_action( 'wp_head', 'index_rel_link');

// Remove wordpress Generator
remove_action( 'wp_head', 'wp_generator');


// canonical links for comments
function canonical_for_comments() {
	global $cpage, $post;
	if ($cpage > 1) :
		echo "\n";
		echo "<link rel='canonical' href='";
		echo get_permalink( $post->ID );
		echo "' />\n";
	endif;
}
add_action('wp_head', 'canonical_for_comments');