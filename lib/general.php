<?php

remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

unregister_sidebar( 'header-right' );

add_filter( 'query_vars', 'mode_add_query_vars_filter' );
function mode_add_query_vars_filter( $vars ) {

  $vars[] = "all";
  return $vars;

}

/**
 *  Grafity Forms
 */
add_filter( 'gform_tabindex', '__return_false' );
add_filter( "gform_confirmation_anchor", create_function( "","return 20;" ) );


add_filter( 'the_title', 'mode_add_woonplaats', 10, 2 );
function mode_add_woonplaats( $title ) {

    if ( is_singular() || ! in_the_loop() ) {
         return $title;
    }

    global $post;

    $place = "";

    if ( "mvs_bedrijf" == $post->post_type ) {

        if ( get_field( 'acf_mm_bedrijf_address', $post->ID ) ) {

            while ( has_sub_field( 'acf_mm_bedrijf_address', $post->ID ) ) {

                if ( get_sub_field('straat') ) {
                    $term = get_term_by( 'id', get_sub_field('woonplaats'), 'modemaken_woonplaats' );

                    if ( stripos( $title, $term->name ) === false ) {
                        $place .= $term->name . ", ";
                    }
                }

            }

            $place = rtrim( $place, ', ' );

            if ( ! empty (  $place ) ) {
                $title .= ' in ' . $place;
            }

        }
    }

    return $title;

}


add_action( 'genesis_header', 'mode_do_header' );
function mode_do_header( $title, $id = null ) {

        ?>
            <ul class="alignright">

            <?php if ( !is_home() && !is_front_page() ) { ?>
            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">zoeken</a></li>
            <?php } ?>

            <li><a href="<?php echo get_permalink( 2554 ); ?>">bedrijf of school aanmelden</a></li>
            </ul>
        <?php

}

function mode_search_form() {

    $form_id = esc_attr( uniqid( 'searchform-' ) );

    ?>
        <form class="search-form" method="get" action="<?php echo home_url(); ?>" role="search">
            <label for="<?php echo $form_id; ?>" class="screen-reader-text" >Zoek een (web)winkel, naailes of modeopleiding</label>
            <input type="hidden" name="post_type" value="mvs_bedrijf">
            <input type="search" name="s" id="<?php echo $form_id; ?>" placeholder="Zoek een (web)winkel, naailes of modeopleiding op naam, plaats of trefwoord" autocomplete="off" value="<?php echo get_search_query(); ?>"><button type="submit">Zoek!</button>
        </form>
    <?php

}

//* Customize the entire footer
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'mode_custom_footer' );
function mode_custom_footer() {
    echo '<p>&copy; ' . date("Y") . ' Modemaken.nl</p>';
}

// login page
add_filter( 'login_headerurl', 'mode_login_logo_url' );
function mode_login_logo_url() {
    return home_url();
}

add_filter( 'login_message', 'mode_login_message' );
function mode_login_message() {
    return '<p class="oogv-login-intro">Beheer uw pagina op Modemaken.nl</p><p class="oogv-login-intro">Heeft u nog geen account op Modemaken.nl?<br /><a href="http://modemaken.nl/wp/aanmelden-wijzigen/">Meld uw bedrijf aan</a> voor een gratis pagina.</p>';
}

add_action( 'login_enqueue_scripts', 'mode_login_css' );
function mode_login_css() {

    wp_enqueue_style( 'login-css', get_stylesheet_directory_uri() . '/css/modemaken-custom-login-css.css', false );

}

add_action( 'wp_enqueue_scripts', 'mode_scripts' );
function mode_scripts() {

    wp_enqueue_script( 'googleapis', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' );
    wp_enqueue_script(
        'render_map',
        get_stylesheet_directory_uri() . '/js/render_map.js',
        array( 'jquery' )
    );

    wp_register_script(
        'mode-more',
        get_stylesheet_directory_uri() . '/js/mode.js',
        array( 'jquery' ), '1.0', true
        );
    wp_enqueue_script( 'mode-more' );

}

add_filter( 'get_the_archive_title', 'mode_archive_title', 10, 1 );
/**
 * Echo the title with the cat term.
 *
 * @since 2.0.0
 */
function mode_archive_title( $title ) {

    global $term;

    $title = $term->name . '(' . $term->count . ')';

    return $title;
}

/**
 * Echo thumbnail if post contains ad.
 *
 * @since 2.0.0
 */

add_action( 'genesis_entry_content', 'mode_do_post_image', 8 );
function mode_do_post_image() {

    if ( is_singular() ) {
        return;
    }

    global $post;

    if (  get_field( 'ad_start_date', $post->ID ) ) {

        $today = date( 'Ymd' );

        if ( ( get_field( 'ad_start_date', $post->ID ) <= $today ) && ( get_field( 'ad_end_date', $post->ID ) >= $today ) ) {

            $img = genesis_get_image( array(
                'format'  => 'html',
                'size'    => genesis_get_option( 'image_size' ),
                'context' => 'archive',
                'attr'    => genesis_parse_attr( 'entry-image', array ( 'alt' => get_the_title() ) ),
            ) );

            if ( ! empty( $img ) ) {
                printf( '<a href="%s" aria-hidden="true">%s</a>', get_permalink(), $img );
            }
        }

    }
}



//add_action( 'genesis_before_footer', 'mode_bol_ads', 5 );
add_action( 'genesis_entry_content', 'mode_bol_ads', 20 );
function mode_bol_ads() {

    if ( ! is_singular() ) {
        return;
    }

    $rows = get_field( 'mode_bol_ad', 'option' ); // get all the rows

    $max = count( $rows );
    $numbers = range( 0, $max - 1 );
    shuffle($numbers);

    ?>
    <section class="lees-tip">
        <div class="wrap">
            <h2 class=""screen-reader-text">Leestips</h2>
            <?php

            mode_display_ad( $rows[ $numbers[0] ], ' first' );
            mode_display_ad( $rows[ $numbers[1] ] );
            mode_display_ad( $rows[ $numbers[2] ] );

            ?>
        </div>
    </section>
    <?php

}


/**
 * Display Bol advertisement.
 *
 * @param $rand_row
 * @param string $first
 */
function  mode_display_ad( $rand_row, $first = '' ) {

    $url = $rand_row['mode_bol_url'];
    $img_obj = $rand_row['mode_bol_img'];
    $id = $img_obj['ID'];

    $onclick = "__gaTracker('send', 'event', 'outbound-article', '" . $url . "', '');"

    ?>
    <div class="one-third<?php echo esc_attr( $first ); ?>">
    <a href="<?php echo esc_url( $url ) ; ?>" onclick="<?php echo $onclick; ?>"><?php echo wp_get_attachment_image( $id, 'medium' ); ?></a>
    </div>
    <?php

}

function mode_disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'mode_disable_emojicons_tinymce' );
}
// add_action( 'init', 'mode_disable_wp_emojicons' );
