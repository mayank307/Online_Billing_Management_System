<?php // Template Name: 2 Sidebars ?>

<?php get_header(); ?>

<div id="content" class="cf">
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

<?php get_sidebar('left'); ?>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>