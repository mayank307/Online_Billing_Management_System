<div id="sidebar-left" class="sidebar cf">
	<?php do_action('frontier_before_sidebar_left'); ?>
	<div id="widgets-wrap-sidebar-left">

		<?php if ( is_active_sidebar('widgets_sidebar_left') ) : ?>
			<?php dynamic_sidebar('widgets_sidebar_left'); ?>
		<?php else : ?>
			<?php
				the_widget('WP_Widget_Archives', 'dropdown=1', array(
					'before_widget'	=> '<div class="widget-sidebar frontier-widget widget_archive">',
					'after_widget' 	=> '</div>',
					'before_title' 	=> '<h4 class="widget-title" >',
					'after_title' 	=> '</h4>'
					) );
				the_widget('WP_Widget_Categories', 'dropdown=1', array(
					'before_widget'	=> '<div class="widget-sidebar frontier-widget widget_categories">',
					'after_widget' 	=> '</div>',
					'before_title' 	=> '<h4 class="widget-title" >',
					'after_title' 	=> '</h4>'
					) );
				the_widget('WP_Widget_Pages', 1, array(
					'before_widget'	=> '<div class="widget-sidebar frontier-widget widget_pages">',
					'after_widget' 	=> '</div>',
					'before_title' 	=> '<h4 class="widget-title" >',
					'after_title' 	=> '</h4>'
					) );
			?>
		<?php endif; ?>

	</div>
	<?php do_action('frontier_after_sidebar_left'); ?>
</div>