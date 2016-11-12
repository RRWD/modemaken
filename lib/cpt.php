<?php

add_action( 'init', 'modemaken_post_types' );

function modemaken_post_types() {

    $labels = array(
        'name' => _x( 'Bedrijven', 'modemaken' ),
        'singular_name' => _x( 'Bedrijf', 'modemaken' ),
        'add_new' => _x( 'Voeg toe', 'modemaken' ),
        'add_new_item' => _x( 'Voeg nieuw bedrijf toe', 'modemaken' ),
        'edit_item' => _x( 'Bewerk bedrijf', 'modemaken' ),
        'new_item' => _x( 'Nieuw bedrijf', 'modemaken' ),
        'view_item' => _x( 'Bekijk bedrijf', 'modemaken' ),
        'search_items' => _x( 'Zoek bedrijven', 'modemaken' ),
        'not_found' => _x( 'Geen bedrijven gevonden', 'modemaken' ),
        'not_found_in_trash' => _x( 'Geen bedrijven in de prullenbak gevonden', 'modemaken' ),
        'parent_item_colon' => _x( 'Parent bedrijf:', 'modemaken' ),
        'menu_name' => _x( 'Bedrijven', 'modemaken' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => _x( 'Bedrijven', 'modemaken' ),
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 21,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array('slug' => 'bedrijf'),
        'capability_type' => 'post'
    );

    register_post_type( 'mvs_bedrijf', $args );
}

add_action( 'init', 'modemaken_taxonomy' );
function modemaken_taxonomy() {

    register_taxonomy(
        'modemaken_woonplaats',
        array( 'mvs_bedrijf' ),
        array(
            'hierarchical' => true,
            'label' => 'Provincie en plaats',
            'query_var' => true,
            'show_ui'  => true,
            'show_in_quick_edit' => true,
            'show_in_menu' => true,
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'plaats' )
        )
    );

}

add_action( 'pre_get_posts', 'mode_get_posts' );
function mode_get_posts( $query ) {

    // get results from all post types
    if ( ( is_category() || is_tax() || is_tag() ) && empty( $query->query_vars['suppress_filters'] ) && !is_admin() && $query->is_main_query() ) {

        $post_types = get_post_types();

        if ( ! is_array( $post_types ) && ! empty( $post_types ) )  {
            $post_types = explode( ',', $post_types );
        }

        if ( empty( $post_types ) ) {
            $post_types[] = 'post';
        }

        $post_types[] = 'mvs_bedrijf';

        $post_types = array_map( 'trim', $post_types );
        $post_types = array_filter( $post_types );

        $query->set('post_type', $post_types);

    }

    //$online_cats = array ( 'webwinkels', 'online-naailes' );
    //if ( is_category() && $query->is_main_query() && in_array( $query->query_vars['category_name'], $online_cats ) ) {

    //    $query->set( 'posts_per_page', -1 );

    //}


    if ( ( ( is_category() || is_tax() ) && empty( $query->query_vars['suppress_filters'] ) && $query->is_main_query() ) ) {

        $query->set( 'orderby', 'menu_order date' );

    }

    return $query;
}

// add_filter('relevanssi_match', 'mode_field_weights' );
function mode_field_weights( $match ) {

    $ad = false;

    if ( get_field( 'ad_active', $match->doc ) && ( get_field( 'ad_cat', $match->doc ) || get_field( 'ad_place', $match->doc ) ) ) {

        $today = date( 'Ymd' );

        if ( ( get_field( 'ad_start_date', $match->doc ) <= $today ) && ( get_field( 'ad_end_date', $match->doc ) >= $today ) ) {

            $search_words = get_field( 'ad_search_word', $match->doc );

            if ( strtolower( $match->term ) == strtolower( $search_words ) ) {

                $ad = true;

            }

       }

    }

    if ( $ad ) {

        $match->weight = $match->weight * 10;

    }

    return $match;
}

