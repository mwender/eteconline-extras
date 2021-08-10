<?php

namespace eteconline\enqueues;

function enqueue_scripts(){
  // Our custom styles
  $css_filename = ETEC_PLUGIN_PATH . 'lib/' . ETEC_CSS_DIR . '/main.css';
  if( file_exists( $css_filename ) )
    wp_enqueue_style( 'eteconline', ETEC_PLUGIN_URL . 'lib/' . ETEC_CSS_DIR . '/main.css', ['hello-elementor','elementor-frontend'], filemtime( $css_filename ) );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );

/**
 * Custom styles for the WP Admin
 */
function custom_admin_styles(){
  wp_enqueue_style( 'myndyou-admin-styles', ETEC_PLUGIN_URL . 'lib/dist/admin.css', null, filemtime( ETEC_PLUGIN_PATH . 'lib/dist/admin.css' ) );
}
add_action( 'admin_head', __NAMESPACE__ . '\\custom_admin_styles' );