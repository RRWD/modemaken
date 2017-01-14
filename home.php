<?php
/**
 *
 */

/**
 * Template Name: Home
 * This file handles the home page
 *
 * This file belongs to the custome theme: Oogvereniging
 *
 * @category Genesis
 * @package  Templates
 * @author   Rian Rietveld
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://rianrietveld.com
 */



remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'modemaken_main_cat_list' );

genesis();


function modemaken_main_search() {
// search widget inside post_type mvs_bedrijf
	?>
	<form class="search-form first" method="get" action="<?php echo home_url(); ?>" role="search">
		<label for="main-search-mvs-bedrijf">Zoek een (web)winkel, naailes of modeopleiding</label>
		<input type="hidden" name="post_type" value="mvs_bedrijf">
		<input type="search" name="s" id="main-search-mvs-bedrijf" autocomplete="off" value="" placeholder="bijvoorbeeld: naailes Amsterdam"><button type="submit">Zoek</button>
	</form>
	<?php
}

function modemaken_main_cat_list() {

	?>
	<div class="odd">

		<div class="wrap">

			<?php modemaken_main_search(); ?>

		</div>

	</div>

	<div class="even">

		<div class="wrap">

			<div class="one-half first">

				<h2 class="screen-reader-text">Zoek naailes op woonplaats</h2>

				<?php $args = array(
					'show_option_none'   => 'Naailes en modevakscholen in ...',
					'option_none_value'  => '-1',
					'orderby'            => 'NAME',
					'order'              => 'ASC',
					'show_count'         => 1,
					'hide_empty'         => 1,
					'child_of'           => 0,
					'echo'               => 0,
					'selected'           => 0,
					'hierarchical'       => 0,
					'name'               => 'modemaken_woonplaats',
					'class'              => 'first mode-select-place',
					'id'                 => 'mode-search-place',
					'taxonomy'           => 'modemaken_woonplaats',
					'value_field'	     => 'slug',
				);

				$select = wp_dropdown_categories( $args );

				?>
				<h3 class="first">Naailes en modevakscholen in jouw woonplaats</h3>
				<form action="<?php esc_url( home_url() ) ?>" class="mode-form first"  method="get">
					<input type="hidden" name="post_type" value="mvs_bedrijf">
					<input type="hidden" name="cat" value="naailes">
	                <label class="screen-reader-text" for="mode-search-place">Zoek op wooonplaats</label>
				    <?php echo $select; ?>
				    <input type="submit" name="submit" value="zoek" class="mode-submit" />
				</form>

				<h2 class="first">Nieuw op Modemaken.nl</h2>
				<ul class="mode-uitgelicht">

					<?php

					$args = array( 'numberposts' => 5, 'post_type' => 'mvs_bedrijf', 'post_status' => 'publish', 'orderby' => 'post_date',  'order' => 'DESC' );

					$myposts = get_posts( $args );

					foreach( $myposts as $post ) {

						$post_id = $post->ID;

						?><li><a href="<?php echo get_permalink( $post_id ); ?>"><?php echo get_the_title( $post_id ) ?></a></li><?php
					}

					?>

				</ul>

			</div>

			<div class="one-half home-top-add">
				<?php mode_get_main_ad_home(); ?>
			</div>

		</div>

	</div>

	<div class="odd">
		<div class="wrap">

		<div class="first one-half">

			<?php $home = esc_url( home_url( '/' ) ); ?>

			<h3 class="first">Mode-opleidingen en speciale naailes</h3>
			<ul>
				<li><a href="<?php echo $home; ?>opleiding/mbo-opleiding/">ROC en MBO-opleidingen</a>,</li>
				<li><a href="<?php echo $home; ?>opleiding/hbo-opleiding/">HBO-opleidingen</a>,</li>
				<li><a href="<?php echo $home; ?>online-naailes/">Online naailes</a>,</li>
				<li><a href="<?php echo $home; ?>thuis-les/">Naailes bij je thuis</a>,</li>
				<li><a href="<?php echo $home; ?>?post_type=mvs_bedrijf&amp;s=Tienernaailes">Tienernaailes</a>,</li>
				<li><a href="<?php echo $home; ?>?post_type=mvs_bedrijf&amp;s=Marokkaans">Marokkaanse naailes</a></li>
			</ul>

		</div>

		<div class="one-half">

			<h3 class="first">Winkels en Webwinkels</h3>
			<ul>
				<li><a href="<?php echo $home; ?>?post_type=mvs_bedrijf&amp;s=naaipatronen">Naaipatronen</a>,</li>
				<li><a href="<?php echo $home; ?>?post_type=mvs_bedrijf&amp;s=naaimachines">Naaimachines</a>,</li>
				<li><a href="<?php echo $home; ?>?post_type=mvs_bedrijf&amp;s=stoffen">Stoffen</a>,</li>
				<li><a href="<?php echo $home; ?>?post_type=mvs_bedrijf&amp;s=lingerie+stoffen">Lingerie stoffen</a>,</li>
				<li><a href="<?php echo $home; ?>?post_type=mvs_bedrijf&amp;s=Fournituren">Fournituren</a>,</li>
				<li><a href="<?php echo $home; ?>?post_type=mvs_bedrijf&amp;s=wol">Wol en garens</a></li>
			</ul>

		</div>

		</div>
	</div>

	<div class="even">
		<div class="wrap">
			<div class="first home-content">

			<?php mode_bol_ads(); ?>

			</div>
		</div>
	</div>

	<div class="even">
		<div class="wrap">
			<div class="first home-content">

			<?php the_content(); ?>

			</div>
		</div>
	</div>

	<?php
}

/**
 *
 */
function mode_uitgelicht() {

?>

		<h2 class="first">Uitgelicht</h2>
		<ul class="mode-uitgelicht">

		<?php

		if ( have_rows( 'ads_bedrijven_home', 'option' ) ) {

			while ( have_rows( 'ads_bedrijven_home', 'option' ) ) : the_row();

				$url = get_sub_field('ad_link');
				$img_obj = get_sub_field('ad_img');
				$name = get_sub_field('adverteerder');

				$id = $img_obj['ID'];

				?><li class="one-third"><a href="<?php echo esc_url( $url ) ?>" onclick="__gaTracker('send', 'event', 'outbound-article', '<?php echo esc_url( $url ) ?>', '');"><?php echo wp_get_attachment_image( $id, 'medium', false, array( 'alt' => esc_attr( $name ) ) ); ?></a></li><?php

			endwhile;

		}
		?>
		</ul>


<?php

}

function mode_get_main_ad_home() {

	if ( have_rows( 'ads_main_home', 'option' ) ) {

		$rows = get_field( 'ads_main_home', 'option' );
		$rand_row = $rows[ array_rand( $rows ) ]; // get a random row

		if ( $rand_row['mode_main_ad_img'] ) {

			$url = $rand_row['mode_main_ad_link'];
			$img_obj = $rand_row['mode_main_ad_img'];
			$id = $img_obj['ID'];

            ?><p><a href="<?php echo $url; ?>" onclick="__gaTracker('send', 'event', 'outbound-article', '<?php echo $url ?>', '');"><?php echo wp_get_attachment_image( $id, 'large' ); ?></a></p><?php

		}

	}

}
