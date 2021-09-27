<?php

namespace eteconline\wplogin;

/**
 * Renders an Elementor template on wp-login.php just above the login form.
 *
 * @param      string  $message  The message
 *
 * @return     string  The filtered message.
 */
function filter_login_message( $message ){
  $template = get_field( 'wplogin_message', 'option' );
  if( $template ){
    $message = '<div class="login-heading"><h2>Sign In</h2></div>';
    $message.= do_shortcode( '[elementor-template id="' . $template->ID . '"]' );
  }
  return $message;
}
add_filter( 'login_message', __NAMESPACE__ . '\\filter_login_message', 10 );
