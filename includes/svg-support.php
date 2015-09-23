<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 *  Core functions 
 *
 *
 * @file           	svg-support.php
 * @package        	Perkster Bear Bones
 * @url				http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @copyright      	2015 Perkster Solutions
 * @license        	license.txt
 * @version        	Release: 1.0.7
 * @filesource     	wp-content/themes/bear-bones-1.0.7/includes/theme-support.php
 * @link           	http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          	available since Release 1.0
 */

// *************** SVG SUPPORT ********************** //

//http://www.smashingmagazine.com/2014/11/03/styling-and-animating-svgs-with-css/
//https://css-tricks.com/using-svg/
//http://www.sitepoint.com/add-svg-to-web-page/
//https://css-tricks.com/snippets/wordpress/allow-svg-through-wordpress-media-uploader/

//@TODO: Add button for TinyMce - http://code.tutsplus.com/tutorials/wordpress-shortcodes-the-right-way--wp-17165

function bb_svg_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'bb_svg_mime_types');

function bb_svg_get_image( $atts = null ) {
	if( !$atts ) return null;
	prar($atts);
	
}

function bb_svg ( $atts = null ) {
	//prar($atts);
	extract( 
		shortcode_atts( array(
			'src' => null,
			'fallback' => null,
			'class' => 'bb-svg',
			'alt' => null,
			'id' => null,
			'method' => 'image', // other options: inline, object
			'data' => null
			
		),$atts	) 
	);
	$svg = null;
	if( $method == null ) $method = 'image';
	if( filter_var( $src, FILTER_VALIDATE_URL) ) {
		if( $id ) $id = 'id="' . $id . '" ';
		if( $class ) $class = 'class="' . $class . '" ';
		if( $alt ) $alt = 'alt="' . $alt . '" ';
		if( $data ) $data = 'alt="' . $data . '" ';
		if( $method == 'inline' ) {
			$svg = wp_remote_fopen($src); 
		} elseif ( $method == 'image' ) {
			if( filter_var( $fallback, FILTER_VALIDATE_URL) ) {
				$fallback =  'onerror="this.onerror=null; this.src='. $fallback . '"';
			}
			
			$svg = '<img src="' . $src . '" ' . $alt . $id . $class . $fallback . $data . '>';
		} elseif ( $method == 'object' ) {
			if( filter_var( $fallback, FILTER_VALIDATE_URL) ) $fallback = '<img src="' . $fallback . '" ' . $alt . $id . $class . $data . '>';
			if( !$fallback ) $fallback = '<img src="" alt="Your browser does not support SVG">';
			$svg = '<object type="image/svg+xml" data="' . $src . '" ' . $alt . $id . $class . $data . '>' . $fallback . '</object>';
			//prar($svg);
		}
	}
	return $svg;
}

function bb_svg_shortcode( $atts = null, $content = null){
	//prar($atts);
	
	return bb_svg ( $atts );
	
}
add_shortcode('bb-svg', 'bb_svg_shortcode');

?>