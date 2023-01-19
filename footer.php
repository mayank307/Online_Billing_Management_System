<?php do_action('frontier_after_main'); ?>
</div>

<?php if ( is_active_sidebar('widgets_footer') ) : ?>
	<div id="footer" class="cf">
		<div id="widgets-wrap-footer" class="widget-column-<?php echo frontier_option('footer_widget_columns', '3'); ?> cf">
			<?php dynamic_sidebar('widgets_footer'); ?>
		</div>
	</div>
<?php endif; ?>

<div id="bottom-bar" class="cf">
	<?php do_action('frontier_before_bottom_bar'); ?>

	<?php if ( frontier_option('bottom_bar_text', get_bloginfo('name') . ' &copy; ' . date('Y')) ) : ?>
		<span id="bottom-bar-text"><?php echo frontier_option('bottom_bar_text', get_bloginfo('name') . ' &copy; ' . date('Y')); ?></span>
	<?php endif; ?>

	<?php if ( frontier_option('theme_link_disable', 0) == 0 ) : ?>
		<?php $frontier_theme_link = '<a href="' . esc_url( 'http://www.enggroom.com' ) . '">www.enggroom.com</a>'; ?>
		<span id="theme-link"><?php echo apply_filters( 'frontier_theme_link', $frontier_theme_link ); ?></span>
	<?php endif; ?>

	<?php do_action('frontier_after_bottom_bar'); ?>
</div>

<?php do_action('frontier_after_container'); ?>
</div>

<?php do_action('frontier_after_body'); ?>

<?php wp_footer(); ?>
</body>
</html>