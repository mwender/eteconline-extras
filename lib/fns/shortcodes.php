<?php
namespace eteconline\shortcodes;
use function eteconline\utilities\{get_alert};
use function eteconline\templates\{render_template};

/**
 * Show a listing of child pages.
 *
 * @param      array  $atts {
 *   @type  string  $orderby    The column we are ordering by. Defaults to "menu_order".
 *   @type  string  $sort       How we are ordering the results. Defaults to ASC.
 *   @type  string  $parent     The page of the child pages we want to list. Defaults to `null`.
 * }
 *
 * @return     string  HTML for the subpage list.
 */
function subpage_list( $atts ){
  $args = shortcode_atts( [
    'orderby' => 'menu_order',
    'sort'    => 'ASC',
    'parent'  => null,
  ], $atts );

  global $post;
  $query_args = [
    'parent'      => $post->ID,
    'sort_column' => $args['orderby'],
    'sort_order'  => $args['sort'],
  ];

  if( ! is_null( $args['parent'] ) ){
    $args['parent'] = html_entity_decode( $args['parent'] );
    $parent = get_page_by_title( $args['parent'] );
    if( $parent )
      $query_args['parent'] = $parent->ID;
  }

  $pages = get_pages( $query_args );
  foreach( $pages as $page ){
    $data['pages'][] = [
      'permalink' => get_page_link( $page->ID ),
      'title'     => get_the_title( $page->ID ),
    ];
  }

  return render_template( 'subpage-list', $data );
}
add_shortcode( 'subpage_list', __NAMESPACE__ . '\\subpage_list' );
