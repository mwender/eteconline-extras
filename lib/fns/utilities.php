<?php
namespace eteconline\utilities;
use function eteconline\templates\{render_template};

/**
 * Returns an HTML alert message
 *
 * @param      array  $atts {
 *   @type  string  $type         The alert type can info, warning, success, or danger (defaults to `warning`).
 *   @type  string  $title        The title of the alert.
 *   @type  string  $description  The content of the alert.
 *   @type  string  $css_classes  Additional CSS classes to add to the alert parent <div>.
 * }
 *
 * @return     html  The alert.
 */
function get_alert( $atts ){
  $args = shortcode_atts([
   'type'               => 'warning',
   'title'              => 'Alert Title Goes Here',
   'description'        => 'Alert description goes here.',
   'css_classes' => null,
  ], $atts );

  $data = [
    'description' => $args['description'],
    'title'       => $args['title'],
    'type'        => $args['type'],
    'css_classes' => $args['css_classes'],
  ];

  return render_template( 'alert', $data );
}

/**
 * Returns SQL for ordering posts by the last word in a post title.
 *
 * @param      string  $orderby_statement  The orderby statement
 *
 * @return     string  SQL for ordering posts.
 */
function posts_orderby_lastname( $orderby_statement ){
  $orderby_statement = "RIGHT(post_title, LOCATE(' ', REVERSE(post_title)) - 1)";
  return $orderby_statement;
}