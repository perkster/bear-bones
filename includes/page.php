<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 *  Core functions 
 *
 *
 * @file           	page.php
 * @package        	Perkster Bear Bones 1.0.1
 * @url				http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @license        	license.txt
 * @copyright      	2013-2015 Perkster Solutions
 * @version        	Release: 1.0.1
 * @filesource     	wp-content/themes/perkster-bear-bones/includes/page.php
 * @link           	http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          	available since Release 1.0
 */

//https://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/
function bb_get_attachment_id_from_url( $attachment_url = '', $size = null ) {
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
	
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir(); 
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
		
		//$attachment_url = strstr( $attachment_url, '-', true );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
	//prar("Size: $size");
	if ($size ) {
		$image = wp_get_attachment_image( $attachment_id, $size );
		//prar($image);
		return $image;
	
	} else {
		return $attachment_id;
	}
}

function bb_get_featured_image ( $atts = null ) {
	
	if( isset( $atts['id'] ) ) {
		$id = $atts['id'];
	} else {
		global $post;
		$id = $post->ID;
	}
	$dnu_image = get_post_meta( $id, 'do-not-use-featured-image', true ); 
	$alt_image = get_post_meta( $id, 'alt-featured-image', true ); //prar($alt_image);
	$use_default = get_post_meta( $id, 'use-default-featured-image', true ); 
	
	$post_image = null;
	$imageSize = 'thumbnail';
	$defaultImage = null;
	
	if( is_page() ) {
		$size = 'page-featured-image'; //get_theme_mod( 'page__featured' );
		$divClass = get_theme_mod( 'pages__featured_class' );
		//check for default photo & caption for pages
		$defaultImage = get_theme_mod( 'pages__default_featured_image' ); //prar($defaultImage);
		$defaultCaption = get_theme_mod( 'pages__default_featured_image_caption' ); //prar("defaultCaption: $defaultCaption");
		$featuredImageCaption = get_post_meta( $id, 'featured-image-caption', true ); 
		$featuredImageCaption = (  $featuredImageCaption ) ? $featuredImageCaption : $defaultCaption; //prar("featuredImageCaption: $featuredImageCaption");
		if ( $featuredImageCaption ) {
			$featuredImageCaption = '<p class="' . $divClass . '-caption">'. $featuredImageCaption . '</p>';
		}
		
	} elseif ( is_single() ) {
		$size = 'post-featured-image'; //get_theme_mod( 'post__featured' );
		$divClass = get_theme_mod( 'posts__featured_class' );
		$featuredImageCaption = null;
	}
	$size = isset( $atts['size'] ) ? $atts['size'] : $size; //prar("Size: $size");
	$image_url = isset( $atts['image_url'] ) ? $atts['image_url'] : null;
	
	
	$featured_image = null;
	
	if ( $image_url ) {
		$featured_image = bb_get_attachment_id_from_url( $image_url, $size ); 
	} elseif ( $alt_image ) {
		$featured_image = bb_get_attachment_id_from_url( $alt_image, $size ); 
	} elseif ( $use_default ) {
		$featured_image = bb_get_attachment_id_from_url( $defaultImage, $size ); 
	} elseif ( !$dnu_image && has_post_thumbnail($id) && ( is_single() || is_page() ) ) { // check if the post has a Post Thumbnail assigned to it.	
		$featured_image = get_the_post_thumbnail( $id, $size ); 
	} elseif ( !$dnu_image && $defaultImage ) {
		$featured_image = bb_get_attachment_id_from_url( $defaultImage, $size ); 
	}
	
	$div_html = null;
	
	if ($featured_image) {
		$divClass = isset( $atts['div_class'] ) ? $atts['div_class'] : $divClass;
		$div_html = '<div class="' . $divClass . '-wrapper"><div class="' . $divClass . '">' . $featured_image . $featuredImageCaption . '</div></div>';
	}	
	return $div_html;
	
}
?>