<?php get_header(); ?>

<?php if ( get_post_type() == 'topic' || get_post_type() == 'reply' ) : ?>
	<div id="content" class="cf">
<?php else : ?>
	<div id="content" class="no-sidebars cf">
<?php endif; ?>

	<?php do_action('frontier_before_content'); ?>

	<?php if ( is_active_sidebar('widgets_before_content') ) : ?>
		<div id="widgets-wrap-before-content" class="cf"><?php dynamic_sidebar('widgets_before_content'); ?></div>
	<?php endif; ?>

    <?php
		the_post();
		get_template_part( 'loop', 'single' );
	?>

	<?php if ( is_active_sidebar('widgets_after_content') ) : ?>
		<div id="widgets-wrap-after-content" class="cf"><?php dynamic_sidebar('widgets_after_content'); ?></div>
	<?php endif; ?>

	<?php do_action('frontier_after_content'); ?>
	</div>

<?php 
	if ( get_post_type() == 'topic' || get_post_type() == 'reply' ) {
		switch ( frontier_option('column_layout', 'col-cs') ) {
			case 'col-sc' :
				get_sidebar('left');
				break;

			case 'col-cs' :
				get_sidebar('right');
				break;
			
			case 'col-ssc' :
			case 'col-scs' :
			case 'col-css' :
				get_sidebar('left');
				get_sidebar('right');	
				break;
		}
	}
?>

<?php get_footer(); ?>