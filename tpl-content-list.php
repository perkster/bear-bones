<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!-- tpl-content-list -->
<div class="content-list post-list">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(array('post-list__item') ); ?>>
	  <a href="<?php the_permalink(); ?>" rel="bookmark" class="post-list__link"  title="<?php echo get_theme_mod( 'posts__link_title' ); ?>">
	<?php  //bb_display_widget(get_post_meta($post->ID, 'widget-top', true)); ?>
		<?php 
					if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
				?>
					<div class="post-list__image">
						<?php the_post_thumbnail( 'post-thumbnail' ); ?>
					</div>
				<?php 
					} 
				?>
		<header class="entry-header post-list__header">
	<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		elseif ( is_page() ) :
		
		else :
			the_title( '<h2 class="entry-title post-list__title">', '</h2>' );
		endif;
				
		//Check for meta
		//bb_posts_meta();
	?>	
		</header><!-- .entry-header --><div class="entry-content post-list__excerpt">
			<?php bb_excerpt(  ); ?>
	<?php

	?>
		</div><!-- .entry-content -->
		<?php
			$readMoreDiv = get_theme_mod( 'posts__read_more_div' );
			if( $readMoreDiv ) {
				echo'<div class="post-list__read-more">' . $readMoreDiv . '</div>';
			}
		?>
	  </a>
	  <?php //Display edit link
				edit_post_link( __( 'Edit', 'bear-bones' ), '<span class="edit-link">', '</span>' ); ?>
	</article>
			
	<?php endwhile; ?>
            
<?php else : ?>
        <h2>Not Found</h2>
<?php endif; ?><!-- end Content -->
<div class="posts_nav_links">
	<?php posts_nav_link(); ?>
</div>
</div>
<!-- end .tpl-content-list -->