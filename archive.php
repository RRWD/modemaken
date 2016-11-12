<?php
/**
 * Archive template
 * @package WordPress
 * @subpackage Modemaken
 * @since Modemaken 3.0
 */

remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description',15 );
add_action( 'genesis_before_loop', 'mode_do_taxonomy_title_description', 15 );

add_action( 'genesis_after_loop', 'mode_google_tax_map' );

add_action( 'genesis_after_loop', 'mode_search_form' );

genesis();

function mode_do_taxonomy_title_description() {

	global $wp_query;

	$term = is_tax() ? get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : $wp_query->get_queried_object();

	$headline = sprintf( '<h1 %s>%s %s</h1>', genesis_attr( 'archive-title' ), strip_tags( $term->name ), '(' . $wp_query->found_posts . ' resultaten)' );

	if ( $term->meta['intro_text'] )
		$intro_text = apply_filters( 'genesis_term_intro_text_output', $term->meta['intro_text'] );

	if ( $headline || $intro_text )
		printf( '<div %s>%s</div>', genesis_attr( 'taxonomy-archive-description' ), $headline . $intro_text );

}


function mode_google_tax_map() {

	if ( is_tax( 'modemaken_woonplaats' ) ) {

		global $wp_query;

		$args = array(
			'post_type' => 'mvs_bedrijf',
			'tax_query' => array(
					array(
						'taxonomy' => 'modemaken_woonplaats',
						'field'    => 'slug',
						'terms' => $wp_query->query,
						'operator' => IN,
                        'include_children' => 1

					),
				),
			'posts_per_page' => -1,
			);

	} else {

		return;
	}

	$the_query = new WP_Query( $args );
	$marker = "";

	if ( $the_query->have_posts() ) {

		while ( $the_query->have_posts() ) {

			$the_query->the_post();

			$post_id = get_the_ID();
			$title = get_the_title();
			$link = get_permalink( $post_id );

	        if ( get_field( 'google_map', $post_id ) ) {

	            while ( has_sub_field( 'google_map', $post_id ) ) {

	                if ( get_sub_field('adres') ) {

	                    $location = get_sub_field('adres');

						if ( ! empty ( $location ) ) {

							$marker .= '<div class="marker" data-lat="' . $location['lat'] . '" data-lng="' . $location['lng'] . '">';
							$marker .= '<p class="address"><a href="' . $link . '?source=map">' . $title . '</a><br />' . $location['address'] . '</p>';
							$marker .= '</div>' . "\n";

						}

	                }

	            }

	        }
	    }
	}

	wp_reset_postdata();

	if ( ! empty ( $marker ) ) {

		?><div class="acf-map"><?php echo $marker;?></div><?php

	}


}
