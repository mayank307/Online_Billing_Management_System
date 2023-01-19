<div id="sidebar-right" class="sidebar cf">
	<?php do_action('frontier_before_sidebar_right'); ?>
	<div id="widgets-wrap-sidebar-right">

		<?php if ( is_active_sidebar('widgets_sidebar_right') ) : ?>
			<?php dynamic_sidebar('widgets_sidebar_right'); ?>
		<?php else : ?>
			<?php
				the_widget('WP_Widget_Search', 'title=The Search Box', array(
					'before_widget'	=> '<div class="widget-sidebar frontier-widget widget_search">',
					'after_widget' 	=> '</div>',
					'before_title' 	=> '<h4 class="widget-title" >',
					'after_title' 	=> '</h4>'
					) );
				the_widget('WP_Widget_Recent_Posts', 1, array(
					'before_widget'	=> '<div class="widget-sidebar frontier-widget widget_recent_entries">',
					'after_widget' 	=> '</div>',
					'before_title' 	=> '<h4 class="widget-title" >',
					'after_title' 	=> '</h4>'
					) );
				the_widget('WP_Widget_Recent_Comments', 1, array(
					'before_widget'	=> '<div class="widget-sidebar frontier-widget widget_recent_comments">',
					'after_widget' 	=> '</div>',
					'before_title' 	=> '<h4 class="widget-title" >',
					'after_title' 	=> '</h4>'
					) );
				the_widget('WP_Widget_Meta', 1, array(
					'before_widget'	=> '<div class="widget-sidebar frontier-widget widget_meta">',
					'after_widget' 	=> '</div>',
					'before_title' 	=> '<h4 class="widget-title" >',
					'after_title' 	=> '</h4>'
					) );
			?>
		<?php endif; ?>

	</div>
	<?php do_action('frontier_after_sidebar_right'); ?>
</div>