<?php

add_action( 'genesis_before_loop', 'mode_do_search_title' );
add_action( 'genesis_after_loop', 'mode_search_form' );

genesis();

/**
 * Echo the title with the search term.
 *
 * @since 2.0.0
 */
function mode_do_search_title() {

    global $wp_query;

	$title = sprintf( '<div class="archive-description"><h1 class="archive-title">%s %s %s</h1></div>', apply_filters( 'genesis_search_title_text', __( 'Search Results for:', 'genesis' ) ), get_search_query(), '(' . $wp_query->found_posts . ' resultaten)' );

	echo apply_filters( 'genesis_search_title_output', $title );

}
