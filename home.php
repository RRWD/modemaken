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

			<h2 class="screen-reader-text">Snel naar</h2>

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

			$home = esc_url( home_url( '/' ) );

			?>
			<h3 class="first">Naailes en modevakscholen in jouw woonplaats</h3>
			<form action="<?php echo $home; ?>" class="mode-form first"  method="get">
				<input type="hidden" name="post_type" value="mvs_bedrijf">
				<input type="hidden" name="cat" value="naailes">
 				<label class="screen-reader-text" for="mode-search-place">Zoek op wooonplaats</label>
			 	<?php echo $select; ?>
			 	<input type="submit" name="submit" value="zoek" class="mode-submit" />
			</form>

			<h3 class="first">Mode-opleidingen en speciale naailes</h3>
			<ul>
				<li><a href="<?php echo $home; ?>/opleiding/mbo-opleiding/">ROC en MBO-opleidingen</a>,</li>
				<li><a href="<?php echo $home; ?>/opleiding/hbo-opleiding/">HBO-opleidingen</a>,</li>
				<li><a href="<?php echo $home; ?>/online-naailes/">Online naailes</a>,</li>
				<li><a href="<?php echo $home; ?>/thuis-les/">Naailes bij je thuis</a>,</li>
				<li><a href="<?php echo $home; ?>?post_type=mvs_bedrijf&amp;s=Tienernaailes">Tienernaailes</a>,</li>
				<li><a href="<?php echo $home; ?>?post_type=mvs_bedrijf&amp;s=Marokkaans">Marokkaanse naailes</a></li>
			</ul>

			<h3 class="first">Winkels en Webwinkels</h3>
			<ul>
				<li><a href="<?php echo $home; ?>/?post_type=mvs_bedrijf&amp;s=naaipatronen">Naaipatronen</a>,</li>
				<li><a href="<?php echo $home; ?>/?post_type=mvs_bedrijf&amp;s=naaimachines">Naaimachines</a>,</li>
				<li><a href="<?php echo $home; ?>/?post_type=mvs_bedrijf&amp;s=stoffen">Stoffen</a>,</li>
				<li><a href="<?php echo $home; ?>/?post_type=mvs_bedrijf&amp;s=lingerie+stoffen">Lingerie stoffen</a>,</li>
				<li><a href="<?php echo $home; ?>/?post_type=mvs_bedrijf&amp;s=Fournituren">Fournituren</a>,</li>
				<li><a href="<?php echo $home; ?>/?post_type=mvs_bedrijf&amp;s=wol">Wol en garens</a></li>
			</ul>

			</div>

			<div class="one-half home-top-add">
				<?php mode_get_main_ad_home(); ?>
			</div>

		</div>

	</div>

	<div class="odd">
		<div class="wrap">

		<div class="first mode-center">

			<h2 class="first">Nieuw op Modemaken.nl</h2>
			<ul class="mode-uitgelicht">

			<?php

			$args = array( 'numberposts' => 5, 'post_type' => 'mvs_bedrijf', 'post_status' => publish, 'orderby' => 'post_date',  'order' => 'DESC' );

			$myposts = get_posts( $args );

			foreach( $myposts as $post ) {

	    		$post_id = $post->ID;

				?><li><a href="<?php echo get_permalink( $post_id ); ?>"><?php echo get_the_title( $post_id ) ?></a></li><?php
	    	}

	    	?>

			</ul>

		</div>

		<div class="one-half">

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


	<div class="odd">
		<div class="wrap">
			<div class="first home-content">
			<h2>Alle adressen voor zelfmaakmode in</h2>

			<?php mode_list_cities_summary(); ?>

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

function mode_list_cities_summary() {

?>
            <div class="one-third">
                <h3>Drenthe</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/assen/">Assen</a>, </li><li><a href="<?php echo $home; ?>/plaats/emmen/">Emmen</a>, </li><li><a href="<?php echo $home; ?>/plaats/coevorden/">Coevorden</a>, </li><li><a href="<?php echo $home; ?>/plaats/hoogeveen/">Hoogeveen</a>, </li><li><a href="<?php echo $home; ?>/plaats/zuidlaren/">Zuidlaren</a>, </li><li><a href="<?php echo $home; ?>/plaats/gasselternijveenschemond/">Gasselternijveenschemond</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/drenthe/"> meer in Drenthe</a>...</li>
                </ul>
            </div>


            <div class="one-third">
                <h3>Flevoland</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/dronten/">Dronten</a>, </li><li><a href="<?php echo $home; ?>/plaats/almere/">Almere</a>, </li><li><a href="<?php echo $home; ?>/plaats/emmeloord/">Emmeloord</a>, </li><li><a href="<?php echo $home; ?>/plaats/lelystad/">Lelystad</a>, </li><li><a href="<?php echo $home; ?>/plaats/zeewolde/">Zeewolde</a>, </li><li><a href="<?php echo $home; ?>/plaats/marknesse/">Marknesse</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/flevoland/"> meer in Flevoland</a>...</li>
                </ul>
            </div>

            <div class="one-third">
                <h3>Friesland</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/leeuwarden/">Leeuwarden</a>, </li><li><a href="<?php echo $home; ?>/plaats/sneek/">Sneek</a>, </li><li><a href="<?php echo $home; ?>/plaats/buitenpost/">Buitenpost</a>, </li><li><a href="<?php echo $home; ?>/plaats/harlingen/">Harlingen</a>, </li><li><a href="<?php echo $home; ?>/plaats/lemmer/">Lemmer</a>, </li><li><a href="<?php echo $home; ?>/plaats/akkrum/">Akkrum</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/friesland/"> meer in Friesland</a>...</li>
                </ul>
            </div>

            <div class="one-third">
                <h3>Gelderland</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/arnhem/">Arnhem</a>, </li><li><a href="<?php echo $home; ?>/plaats/apeldoorn/">Apeldoorn</a>, </li><li><a href="<?php echo $home; ?>/plaats/nijmegen/">Nijmegen</a>, </li><li><a href="<?php echo $home; ?>/plaats/barneveld/">Barneveld</a>, </li><li><a href="<?php echo $home; ?>/plaats/renkum/">Renkum</a>, </li><li><a href="<?php echo $home; ?>/plaats/zevenaar/">Zevenaar</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/gelderland/"> meer in Gelderland</a>...</li>
                </ul>
            </div>


            <div class="one-third">
                <h3>Groningen</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/groningen/">Groningen</a>, </li><li><a href="<?php echo $home; ?>/plaats/winsum/">Winsum</a>, </li><li><a href="<?php echo $home; ?>/plaats/veendam/">Veendam</a>, </li><li><a href="<?php echo $home; ?>/plaats/delfzijl/">Delfzijl</a>, </li><li><a href="<?php echo $home; ?>/plaats/stadskanaal-provincie-groningen/">Stadskanaal</a>, </li><li><a href="<?php echo $home; ?>/plaats/blijham/">Blijham</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/provincie-groningen/"> meer in Provincie Groningen</a>...</li>
                </ul>
            </div>


            <div class="one-third">
                <h3>Limburg</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/maastricht/">Maastricht</a>, </li><li><a href="<?php echo $home; ?>/plaats/kerkrade/">Kerkrade</a>, </li><li><a href="<?php echo $home; ?>/plaats/roermond/">Roermond</a>, </li><li><a href="<?php echo $home; ?>/plaats/weert/">Weert</a>, </li><li><a href="<?php echo $home; ?>/plaats/venray/">Venray</a>, </li><li><a href="<?php echo $home; ?>/plaats/wittem/">Wittem</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/limburg/"> meer in Limburg</a>...</li>
                </ul>
            </div>


            <div class="one-third">
                <h3>Noord-Brabant</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/tilburg/">Tilburg</a>, </li><li><a href="<?php echo $home; ?>/plaats/breda/">Breda</a>, </li><li><a href="<?php echo $home; ?>/plaats/s-hertogenbosch/">'s-Hertogenbosch</a>, </li><li><a href="<?php echo $home; ?>/plaats/eindhoven/">Eindhoven</a>, </li><li><a href="<?php echo $home; ?>/plaats/helmond/">Helmond</a>, </li><li><a href="<?php echo $home; ?>/plaats/etten-leur/">Etten-Leur</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/noord-brabant/"> meer in Noord-Brabant</a>...</li>
                </ul>
            </div>

            <div class="one-third">
                <h3>Noord-Holland</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/amsterdam/">Amsterdam</a>, </li><li><a href="<?php echo $home; ?>/plaats/haarlem/">Haarlem</a>, </li><li><a href="<?php echo $home; ?>/plaats/alkmaar/">Alkmaar</a>, </li><li><a href="<?php echo $home; ?>/plaats/heiloo/">Heiloo</a>, </li><li><a href="<?php echo $home; ?>/plaats/purmerend/">Purmerend</a>, </li><li><a href="<?php echo $home; ?>/plaats/bussum/">Bussum</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/noord-holland/"> meer in Noord-Holland</a>...</li>
                </ul>
            </div>

            <div class="one-third">
                <h3>Overijssel</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/enschede/">Enschede</a>, </li><li><a href="<?php echo $home; ?>/plaats/hengelo/">Hengelo</a>, </li><li><a href="<?php echo $home; ?>/plaats/zwolle/">Zwolle</a>, </li><li><a href="<?php echo $home; ?>/plaats/wierden/">Wierden</a>, </li><li><a href="<?php echo $home; ?>/plaats/rijssen/">Rijssen</a>, </li><li><a href="<?php echo $home; ?>/plaats/borne/">Borne</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/overijssel/"> meer in Overijssel</a>...</li>
                </ul>
            </div>


            <div class="one-third">
                <h3>Utrecht</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/utrecht/">Utrecht</a>, </li><li><a href="<?php echo $home; ?>/plaats/amersfoort/">Amersfoort</a>, </li><li><a href="<?php echo $home; ?>/plaats/maarssen/">Maarssen</a>, </li><li><a href="<?php echo $home; ?>/plaats/nieuwegein/">Nieuwegein</a>, </li><li><a href="<?php echo $home; ?>/plaats/houten/">Houten</a>, </li><li><a href="<?php echo $home; ?>/plaats/zeist/">Zeist</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/provincie-utrecht/"> meer in Provincie Utrecht</a>...</li>
                </ul>
            </div>

            <div class="one-third">
                <h3>Zeeland</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/kerkwerve/">Kerkwerve</a>, </li><li><a href="<?php echo $home; ?>/plaats/vlissingen/">Vlissingen</a>, </li><li><a href="<?php echo $home; ?>/plaats/axel/">Axel</a>, </li><li><a href="<?php echo $home; ?>/plaats/middelburg/">Middelburg</a>, </li><li><a href="<?php echo $home; ?>/plaats/veere/">Veere</a>, </li><li><a href="<?php echo $home; ?>/plaats/aardenburg/">Aardenburg</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/zeeland/"> meer in Zeeland</a>...</li>
                </ul>
            </div>


            <div class="one-third">
                <h3>Zuid-Holland</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/rotterdam/">Rotterdam</a>, </li><li><a href="<?php echo $home; ?>/plaats/den-haag/">Den Haag</a>, </li><li><a href="<?php echo $home; ?>/plaats/zoetermeer-zuid-holland/">Zoetermeer</a>, </li><li><a href="<?php echo $home; ?>/plaats/gorinchem/">Gorinchem</a>, </li><li><a href="<?php echo $home; ?>/plaats/delft/">Delft</a>, </li><li><a href="<?php echo $home; ?>/plaats/pijnacker/">Pijnacker</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/zuid-holland/"> meer in Zuid-Holland</a>...</li>
                </ul>
            </div>


            <div class="one-third">
                <h3>Duitsland</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/dusseldorf/">Düsseldorf</a>, </li>
                <li><a href="<?php echo $home; ?>/plaats/duitsland/"> meer in Duitsland</a>...</li>
                </ul>
            </div>


            <div class="one-third">
                <h3>Belgi&euml;</h3>
                <ul>
                <li><a href="<?php echo $home; ?>/plaats/mol/">Mol</a>, </li><li><a href="<?php echo $home; ?>/plaats/boutersem/">Boutersem (B)</a>, </li><li><a href="<?php echo $home; ?>/plaats/herentals-provincie-antwerpen-b/">Herentals</a>, </li><li><a href="<?php echo $home; ?>/plaats/oudenaarde/">Oudenaarde</a>, </li><li><a href="<?php echo $home; ?>/plaats/dilsen-stokkem/">Dilsen-Stokkem</a>, </li><li><a href="<?php echo $home; ?>/plaats/turnhout/">Turnhout</a>, </li>                    <li><a href="<?php echo $home; ?>/plaats/belgie/"> meer in Belgi&euml;</a>...</li>
                </ul>
            </div>



    <?php

}

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

				?><li class="one-third"><a href="<?php echo $url ?>" onclick="__gaTracker('send', 'event', 'outbound-article', '<?php echo $url ?>', '');"><?php echo wp_get_attachment_image( $id, 'medium', false, array( 'alt' => $name ) ); ?></a></li><?php

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
			$text = $rand_row['mode_main_ad_tekst'];

			$id = $img_obj['ID'];

			if ( ! empty ( $text ) ) {
				?><p><a href="<?php echo $url; ?>" onclick="__gaTracker('send', 'event', 'outbound-article', '<?php echo $url ?>', '');"><?php echo $text; ?></a></p><?php
			}
			echo wp_get_attachment_image( $id, 'large' );

		}

	}

}
