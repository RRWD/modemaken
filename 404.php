<?php
/**
 * Genesis Framework.
 *
 *
 * @package Genesis\Templates
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

//* Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'genesis_404' );
/**
 * This function outputs a 404 "Not Found" error message
 *
 * @since 1.6
 */
function genesis_404() {

	echo '<article class="entry">' ;

		echo '<h1 class="entry-title">Oeps, aan deze pagina zit een steekje los!</h1>';
		echo '<div class="entry-content">';

				echo '<p>Geen paniek! Probeer het eens op onze <a href="http://modemaken.nl">voorpagina</a>, of met zoeken op trefwoord hieronder.</p>';

				get_search_form();

			echo '</div>';

		echo '</article>';

}

genesis();
