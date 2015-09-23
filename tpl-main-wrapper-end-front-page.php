<?php if( isset( $post ) ) bb_display_widget( get_post_meta( $post->ID, 'widget-bottom', true ), array('wrapper' => true) ); ?>
			</main>
		</div>
	</div><!-- end home -->
<?php if ( is_active_sidebar( 'home-widget-bottom' ) ) : ?>
	<div class="home-widget-bottom-wrapper">	
		<div class="home-widget-bottom-inner inner">
	<?php bb_display_widget( 'home-widget-bottom' ); ?>
		</div>
	</div>
<?php endif; ?>
</div><!-- end block--content -->