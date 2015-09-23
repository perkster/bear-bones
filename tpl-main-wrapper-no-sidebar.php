<div id="blk-content" class="block--content">
	<div class="content-wrapper">
		<div class="content-inner">
			<div class="block--main-content">
			<div class="main-content-wrapper--full-width main-content-wrapper-<?php echo get_post_type( ); ?>"><div id="main" tabindex="0"></div>
			<main role="main" id="main" class="main-content--full-width main-content--<?php echo get_post_type( ); ?>">	
				<?php bb_yoast_breadcrumb(); ?>
				<?php bb_display_widget( 'page-widget-top' ); ?>
				<?php if( isset( $post ) ) bb_display_widget( get_post_meta( $post->ID, 'widget-top', true ) ); ?>