<?php 
/*
Plugin Name: LH Prefetch and Render
Plugin URI: https://lhero.org/plugins/lh-prefetch-and-render/
Description: Adds prefetch meta to head
Author: Peter Shaw
Version: 1.01
Author URI: https://shawfactor.com
*/


class LH_prefetch_and_render_plugin {

var $filename;
var $options;
var $opt_name = 'lh_prefetch_and_render-options';
var $menu_name = 'lh_prefetch_and_render-menu';


public function register_menu() {
  register_nav_menu($this->menu_name,__( 'Prefetch and render list' ));
}


public function wp_resource_hints( $hints, $relation_type ) {


 
if ( is_front_page() &&  ( $locations = get_nav_menu_locations() ) && isset( $locations[ $this->menu_name ] ) ) {

    $menu = wp_get_nav_menu_object( $locations[ $this->menu_name ] );
 
    $menu_items = wp_get_nav_menu_items($menu->term_id);

    if ( 'prefetch' === $relation_type ) {
foreach ( (array) $menu_items as $key => $menu_item ) {
        $hints[] = $menu_item->url;
}
    } 

if ( 'prerender' === $relation_type ) {
foreach ( (array) $menu_items as $key => $menu_item ) {
        $hints[] = $menu_item->url;
}
    }
 
}
    return $hints;
}


public function __construct() {

$this->filename = plugin_basename( __FILE__ );
$this->options = get_option($this->opt_name);

add_filter( 'wp_resource_hints', array($this,'wp_resource_hints'), 10, 2 );


add_action( 'init', array($this,"register_menu"));

}


}


$lh_prefetch_and_render_instance = new LH_prefetch_and_render_plugin();


?>