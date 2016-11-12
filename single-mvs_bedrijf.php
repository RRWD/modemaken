<?php

add_action( 'genesis_entry_content', 'mode_single_mvs_bedrijf', 5 );
add_action( 'genesis_entry_content', 'mode_single_mvs_bedrijf_map' );
add_action( 'genesis_entry_content', 'mode_single_cats', 21 );

genesis();


function mode_single_mvs_bedrijf() {

	global $post;

	echo '<h2>Contactgegevens</h2><ul>';

	if ( get_field( 'acf_mm_bedrijf_address' ) ) {



 		while ( has_sub_field( 'acf_mm_bedrijf_address' ) ) {

 			if ( get_sub_field('straat') ) {
 				$variable = '<li>Adres: ' . get_sub_field('straat') . ", ";
	 			$variable .= get_sub_field('postcode') . " ";
	 			$term = get_term_by( 'id', get_sub_field('woonplaats'), 'modemaken_woonplaats' );
	 			$variable .= $term->name . ", ";
	 			$variable .= ucfirst( get_sub_field('land') ) . "</li>";
	 			echo $variable;

	 			if ( get_sub_field( 'telefoon' ) ) {
					echo '<li>Telefoon: ' . get_sub_field( 'telefoon' ) . "</li>";
				}

 			}
 		}

	}


	if ( get_field( 'e-mail' ) ) {
		echo '<li>E-mail: <a href="mailto:' . get_field( 'e-mail' ) . '">' . get_field( 'e-mail' ) . "</a></li>";
	}

	if ( get_field( 'website' ) ) {

		$website_url = get_field( 'website' );
		$website_name = str_ireplace('www.', '', parse_url($website_url, PHP_URL_HOST));

		$onclick = "__gaTracker('send', 'event', 'outbound-article', '" . $website_url . "', '" . $post->post_name . "');";
		echo '<li>Website: <a href="' . $website_url . '" onclick="' . $onclick . '" >' . $website_name . "</a></li>";

	}



	if ( get_field( 'sociale_media' ) ) {

    	while ( have_rows( 'sociale_media' ) ) : the_row();

    		$onclick = "__gaTracker('send', 'event', 'outbound-article', '" . get_sub_field( 'website_sociale_media' )  . "', '" . get_sub_field( 'naam_sociale_media' ) . "-" . $post->post_name . "');";
        	echo '<li><a href="' . get_sub_field( 'website_sociale_media' ) . '" onclick="' . $onclick . '">' . get_sub_field( 'naam_sociale_media' ) . "</a></li>";

    	endwhile;


    }

    echo "</ul>";

    if ( ! empty ( $post->post_content ) ) {
    	echo '<h2>Omschrijving</h2>';
    }

	// Get thumbnail
	if ( has_post_thumbnail( $post->ID ) ) {
    	echo get_the_post_thumbnail ( $post->ID, 'medium', array( 'class' => 'alignright' ) );
	}

	// content will be added after this



}

function mode_single_mvs_bedrijf_map() {
	global $post;

	if( have_rows('google_map', $post->ID ) ): ?>
		<div class="acf-map">
			<?php while ( have_rows('google_map', $post->ID ) ) : the_row();

				$location = get_sub_field('adres', $post->ID);

				?>
				<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
					<p class="address"><?php echo $location['address']; ?></p>
				</div>
		<?php endwhile; ?>
		</div>
	<?php endif;

}

add_filter('pre_get_posts', 'posts_for_current_author');
function posts_for_current_author($query) {
	global $pagenow;

	if( 'edit.php' != $pagenow || !$query->is_admin )
	    return $query;

	if( !current_user_can( 'edit_others_posts' ) ) {
		global $user_ID;
		$query->set('author', $user_ID );
	}
	return $query;
}

add_action( 'genesis_entry_content', 'mode_single_cats', 21 );
function mode_single_cats() {
	global $post;

    ?>
	<h2>Meer bij:</h2>
	<ul class="mode-more">
	<?php

	$categories = get_the_category();
	if ( ! empty( $categories ) ) {
		foreach ( $categories as $category ) {
			if ( $category->term_id != 684 && $category->term_id != 685 ) {
				echo '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
			}
		}
	}
	$taxonomies = get_the_terms( $post->ID ,'modemaken_woonplaats' );
	if ( ! empty( $taxonomies ) ) {
		foreach ( $taxonomies as $taxonomy ) {
			echo '<li><a href="' . esc_url( get_category_link( $taxonomy->term_id ) ) . '">' . esc_html( $taxonomy->name ) . '</a></li>';
		}
	}

	?>
	</ul>
	<?php

}

