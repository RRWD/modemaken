<?php

if ( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Modemaken Instellingen',
        'menu_title'    => 'Advertenties',
        'menu_slug'     => 'mode-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

}


