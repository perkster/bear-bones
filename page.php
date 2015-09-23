<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * The Template for displaying all pages.
 *
 */
get_header('custom'); ?>
<!-- page.php -->
<?php if( get_theme_mod( 'pages__display_featured' ) == 'before_content' ) echo bb_get_featured_image( );?>
	<?php bear_bones_main_start(); ?>
	<?php get_template_part ( 'tpl', 'content' ); ?>
	<?php bear_bones_main_end(); ?>
<?php get_footer('custom'); ?>