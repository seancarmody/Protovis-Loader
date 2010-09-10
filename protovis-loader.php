<?php
/**
 * @package Protovis_Loader
 * @version 0.1
 */
/*
Plugin Name: Protovis Loader
Plugin URI: http://wordpress.org/extend/plugins/protovis-loader/
Description: Creates a shortcode to faciliate the use of Protovis scripts.
Author: Sean Carmody
Version: 0.1
Author URI: http://profiles.wordpress.org/users/seancarmody/
License: GPL2
*/

/*
Copyright 2010 Sean Carmody  (email : sean@stubbornmule.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
Conditionally load the Protovis library
Technique taken from beer planet:
http://beerpla.net
http://bit.ly/8Tuh1O
*/

// TO-DO: use a variable for the shortcode
add_filter( 'the_posts', 'conditionally_add_pv' ); // the_posts gets triggered before wp_head
function conditionally_add_pv( $posts ){
	if ( empty( $posts ) ) return $posts;
 
	$shortcode_found = false; // this flag is triggered if the library need to be enqueued
	foreach ( $posts as $post ) {
		if ( stripos( $post->post_content, 'pvis' ) ) { // look for the string 'pvis'
			$shortcode_found = true;
			break;
		}
	}
 
	if ( $shortcode_found ) {
		// place-holder to enqueue CSS as well
		//wp_enqueue_style( 'my-style', '/style.css' );
		wp_enqueue_script( 'protovis', WP_PLUGIN_URL.'/protovis-loader/js/protovis-r3.2.js' );
	}
 
	return $posts;
}

function sProtovisLoad( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'src' => '',
		'img' => '',
		'alt' => '',
	), $atts ) );
	
	// Check for browsers which does not support SVG
	$using_ie = ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== FALSE);
	$using_android = ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Android' ) !== FALSE );
	
	if ( !$alt )
		$alt = 'Scripts disabled, cannot display chart!';

	if ( $img )
		$no_script = "<img src='$img' alt='$alt'>";
	else
		$no_script = $alt;
	
	if ( $using_ie || $using_android )
		$script = '';
	else {
		$no_script = "<noscript>$no_script</noscript>";
		$script = file_get_contents($src);
		$script = '<script type="text/javascript+protovis">'."\n".$script.'</script>';
	}
	
	if ( $content )
		$caption = '<p align="center"><strong>'.do_shortcode($content).'</strong></p>';
	else
		$caption = '';

	return $script.$no_script.$caption;
}
add_shortcode( 'pvis', 'sProtovisLoad' );

?>
