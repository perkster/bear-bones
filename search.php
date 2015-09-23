<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * The Template for displaying searches.
 *
 */

get_header('custom'); ?>
<!-- search.php -->
	<?php bear_bones_main_start(); ?>
			
	<div class="search-results">
		<h1>Search Results for: <span><?php echo get_search_query(); ?></span></h1>
		<div class="search-again">
			<h3>Search again...</h3>
				<?php get_template_part('tpl-search'); ?>
		</div>
		<?php get_template_part('tpl-content-list'); ?>		
	</div>

	<?php bear_bones_main_end(); ?>
<?php get_footer('custom'); ?>