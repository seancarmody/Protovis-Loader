<?php
/**
 * @package Protovis_Loader
 * @version 0.2.0
 */
/*
Plugin Name: Protovis Loader
Plugin URI: http://www.stubbornmule.net/resources/protovis-loader/
Description: Creates a shortcode to faciliate the use of Protovis scripts.
Author: Sean Carmody
Version: 0.2.0
Author URI: http://www.stubbornmule.net/
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

// The Protovis library and style-sheet are only loaded if the shortcode is used
add_filter( 'the_posts', 'pvl_conditionally_load' );

// TO-DO: use a variable for the shortcode name

function pvl_conditionally_load( $posts ){
	if ( empty( $posts ) ) return $posts;
 
	$shortcode_found = false; 
	foreach ( $posts as $post ) {
		if ( stripos( $post->post_content, 'pvis' ) ) { // look for the string 'pvis'
			$shortcode_found = true;
			break;
		}
	}
 
	if ( $shortcode_found ) {
		// Load css stylesheet and javascript library
		wp_enqueue_style( 'protovis-style', WP_PLUGIN_URL.'/protovis-loader/css/pvl-standard.css' );
		wp_enqueue_script( 'protovis-lib', WP_PLUGIN_URL.'/protovis-loader/js/protovis-r3.2.js' );
	}
 
	return $posts;
}


// Function to slurp in your javascript code
function pvl_load_script( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => '',
		'src' => '',
		'img' => '',
		'alt' => '',
	), $atts ) );
	
	// Check for browsers which does not support SVG
	$non_svg = array( 'MSIE', 'Android', 'BlackBerry' );
	$using_non_svg = FALSE;
	foreach ( $non_svg as $str)
		if (strpos ( $_SERVER['HTTP_USER_AGENT'], $str ) !== FALSE )
			$using_non_svg = TRUE;

	//$using_ie = ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== FALSE);
	//$using_android = ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Android' ) !== FALSE );
	
	if ( !$alt )
		$alt = 'Scripts disabled, cannot display chart!';

	if ( $img )
		$no_script = "<img src='$img' alt='$alt'>";
	else
		$no_script = $alt;
	
	//if ( $using_ie || $using_android )
	if ( $using_non_svg )
		$script = '';
	else {
		$no_script = "<noscript>$no_script</noscript>";
		$script = file_get_contents($src);
		$script = '<script type="text/javascript+protovis">'."\n".$script.'</script>';
	}
	
	if ( $content )
		$caption = '<div class="pvl-caption-text">'.do_shortcode($content).'</div>';
	else
		$caption = '';

	$css = '<div class="pvl-chart aligncenter"><div class="pvl-canvas"';
	if ( $type == 'inline')
		return $script.$noscript;
	else
		return $css.$script.$no_script.'</div>'.$caption.'</div><br />';
}

// Associate shortcode to function
add_shortcode( 'pvis', 'pvl_load_script' );

?>
