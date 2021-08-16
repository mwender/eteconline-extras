<?php

namespace eteconline\enqueues;

/**
 * Enqueues frontend scripts.
 */
function enqueue_scripts(){
  // Our custom styles
  $css_filename = ETEC_PLUGIN_PATH . 'lib/' . ETEC_CSS_DIR . '/main.css';
  if( file_exists( $css_filename ) )
    wp_enqueue_style( 'eteconline', ETEC_PLUGIN_URL . 'lib/' . ETEC_CSS_DIR . '/main.css', null, filemtime( $css_filename ) );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );
