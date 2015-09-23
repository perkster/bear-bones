<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 *  Admin functions 
 *
 *
 * @file           	admin.php
 * @package        	Bear Bones 1.0.7
 * @url				http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @copyright      	2013 Perkster Solutions
 * @license        	license.txt
 * @version        	Release: 1.0.7
 * @filesource     	wp-content/themes/bear-bones-1.0.7/includes/admin.php
 * @link           	http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          	available since Release 1.0
 */

 /* 
	Login Logo
	- Option to use different logo for login
	- uplaod login logo from theme customizer 
	- save location
 */
 
 /* 
	Display login logo
	- Retrieve logo if uses different logo then main
	- display css information
 *
function bear_bones_login_logo() { 
	/*global $bb_admin_login_logo_url;
	list($width, $height, $type, $attr) = getimagesize($bb_admin_login_logo_url);
?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo $bb_admin_login_logo_url; ?>);
			background-size: <?php echo $width; ?>px <?php echo $height; ?>px;
            padding-bottom: 30px;
			height: <?php echo $height; ?>px;
			width: <?php echo $width; ?>px;
        }
    </style>
<?php *
}
add_action( 'login_enqueue_scripts', 'bear_bones_login_logo' );

function bear_bones_login_url() {
   // return $bb_admin_login_url;
}
add_filter( 'login_headerurl', 'bear_bones_login_url' );

function bear_bones_login_text() {
   // return $bb_admin_login_text;
}
add_filter( 'login_headertitle', 'bear_bones_login_text' );
*/

function prar($array = null, $debug = false, $noAdmin = false) {
	if ( ( is_user_logged_in() && current_user_can( 'manage_options' ) ) || $noAdmin ) {
		echo '<pre>';
		if( $debug ) debug_print_backtrace();
		if( is_object( $array ) ) {
			print_r ($array);
		} elseif( is_array( $array ) ) {
			print_r( $array );	
		} elseif( !is_null( $array ) ) {
			$string = esc_html( $array );
			echo "<p> $string</p>";
		}
		echo '</pre>';
	}
}

//http://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php
function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

function bear_bones_title(  ) {
	if( get_bloginfo ( 'name' ) == 'LOCALHOST' ) {
		$title =  wp_get_theme();
		global $post; 
		if($post) $title .= ' - ' . $post->post_title;
		return $title;
	} 	
}
add_filter( 'wp_title', 'bear_bones_title', 10, 2 );

function bear_bones_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'bear_bones_login_logo_url' );

function bear_bones_login_logo() {
	$logo =  get_theme_mod('login_logo');
	if(!$logo) $logo =  get_theme_mod('site_logo');
	if( $logo ) {		
		//prar($logo, false, true);
		list($width, $height, $type, $attr) = getimagesize( $logo );
		//prar( $attr, false, true );
		$widthHeight = $width . 'px ' . $height . 'px';
		$bgc =  get_theme_mod('login_bgc_color');
		$linkColor = get_theme_mod('login_link_color');
		$linkHoverColor = get_theme_mod('login_link_hover_color');
		$marginLeft = 320 - $width;
	 ?>
		<style type="text/css">
			body.login {
				background-color: <?php echo $bgc; ?>;
			}
			.login #backtoblog a, .login #nav a {
				color: <?php echo $linkColor; ?>;
			}
			.login #backtoblog a:hover, .login #nav a:hover {
				color: <?php echo $linkHoverColor; ?>;
			}
			body.login div#login h1 a {
				background-image: url(<?php echo $logo; ?>);
				padding-bottom: 30px;
				-webkit-background-size: <?php echo $widthHeight; ?>;
				background-size: <?php echo $widthHeight; ?>;
				width: <?php echo $width; ?>px;
				height: <?php echo $height; ?>px;
			}
		</style>
	<?php 
	}
}
add_action( 'login_enqueue_scripts', 'bear_bones_login_logo' );

if( !function_exists( 'bb_parent_children_array' ) ) {
/** 
 * Recursively sort attributes hierarchically.
 * Child attributes will be placed under parent term.
 * @param Array $elements can also be objects
 * @param integer $parentId the ID of the portfolio item
 *	http://stackoverflow.com/questions/13877656/php-hierarchical-array-parents-and-childs
 */
	function bb_sort_parent_children_array( array $elements, $parentId = 0 ) {
		
		 $branch = array();

		foreach ($elements as $element) {
			if( is_object( $element ) ) $element = (array) $element; //prar( $element );
			if ($element['parent'] == $parentId) {
				$children = bb_sort_parent_children_array($elements, $element['term_id']);
				if ($children) {
					$element['children'] = $children;
				}
				$branch[] = $element;
			}
		}
		
		return $branch;
	}
}	

function bb_attribute_list( $id = null, $atts = null, $elementArgs = null ) {
		//prar($id);
		if( !$id ) $id = bb_get_id();
		//prar( $atts );
		$taxonomy = ( isset( $atts['taxonomy'] ) ? $atts['taxonomy'] : 'category' );
		$attributes = get_the_terms( $id,  $taxonomy, array( 'hide_empty' => false ) );
		//prar($attributes);
		if( !empty( $attributes ) && !is_wp_error( $attributes ) ) {
			if(!$elementArgs) 
			$elementArgs = array(
				'orderby'           => 'name', 
				'order'             => 'ASC',
				'hide_empty'        => true, 
				'exclude'           => array(), 
				'exclude_tree'      => array(), 
				'include'           => array(),
				'number'            => '', 
				'fields'            => 'all', 
				'slug'              => '',
				'parent'            => '',
				'hierarchical'      => true, 
				'child_of'          => 0,
				'childless'         => false,
				'get'               => '', 
				'name__like'        => '',
				'description__like' => '',
				'pad_counts'        => false, 
				'offset'            => '', 
				'search'            => '', 
				'cache_domain'      => 'core'
			); 
			$elements =  get_terms( $taxonomy , $elementArgs ); 
			//prar( 'elements:' ); prar( $elements );
			
			$attributeList = bb_sort_parent_children_array( $elements );
			//prar( $attributeList );
			
			$listClass = ( isset( $atts['list-class'] ) ? $atts['list-class'] : 'attribute-list' );
			$itemClass = ( isset( $atts['item-class'] ) ? $atts['item-class'] : 'attribute-list__item' );
			
			$list = '<ul class="' . $listClass . '">';
			foreach( $attributeList as $parent ) {
				//prar($parent);
				$list .= '<li class="' . $itemClass . '">' . $parent['name'];
				if( isset( $parent['children'] ) ) {
					$list .= '<ul class=' . $listClass . '__submenu">';
					foreach( $parent['children'] as $child ) {
						$list .= '<li class=' . $itemClass . '__submenu">' . $child['name'] . '</li>';
					}
					$list .= '</ul>';
				}
				$list .= '</li>';
			}
			$list .= '</ul>';
			echo $list;
		}
	}
?>