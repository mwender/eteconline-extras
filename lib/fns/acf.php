<?php

if( function_exists( 'acf_add_options_page') ){
  acf_add_options_page([
    'page_title'  => 'ETEC General Settings',
    'menu_title'  => 'ETEC Settings',
    'menu_slug'   => 'etec-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ]);
}