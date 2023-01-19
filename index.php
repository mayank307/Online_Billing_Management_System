<?php get_header(); ?>

<div id="content" class="cf">
<?php do_action('frontier_before_content'); ?>

	<?php if ( is_active_sidebar('widgets_before_content') ) : ?>
		<div id="widgets-wrap-before-content" class="cf"><?php dynamic_sidebar('widgets_before_content'); ?></div>
	<?php endif; ?>

	<?php if ( is_category() || is_tag() || is_date() || is_search() ) : ?>
		<div class="archive-info">
		<h3 class="archive-title">
		<?php
			if ( is_search() )
				printf(	__('Search Results for &ndash; &quot;<span>%s</span>&quot;', 'frontier'), get_search_query() );
			elseif ( is_day() )
				printf( __('Date &ndash; <span>%s</span>', 'frontier'), get_the_date() );
			elseif ( is_month() )
				printf( __('Month &ndash; <span>%s</span>', 'frontier'), get_the_date( 'F Y' ) );
			elseif ( is_year() )
				printf( __('Year &ndash; <span>%s</span>', 'frontier'), get_the_date( 'Y' ) );
			elseif ( is_category() || is_tag() )
				echo '<span>' . single_cat_title( '', false ) . '</span>';
		?>
		</h3>

		<?php if ( category_description() != '' ) : ?>
			<div class="archive-description"><?php echo category_description(); ?></div>
		<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php do_action('frontier_before_loop'); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php if ( !is_singular() ) : ?>
			<?php get_template_part( 'loop', 'blog' ); ?>
		<?php else : ?>
			<?php get_template_part( 'loop', 'single' ); ?>
		<?php endif; ?>

	<?php endwhile; else: ?>

		<div class="form-404">
			<?php
				$frontier_nothing_found_content = '<h2>' . __('Nothing Found', 'frontier') . '</h2>';
				$frontier_nothing_found_content .= '<p>' . __('Try a new keyword.', 'frontier') . '</p>';
				$frontier_nothing_found_content .= get_search_form( false );
				echo apply_filters( 'frontier_nothing_found_content', $frontier_nothing_found_content );
			?>
		</div>

	<?php endif; ?>

	<?php do_action('frontier_after_loop'); ?>

	<?php if ( !is_singular() ) : ?>
		<div class="blog-nav cf">
			<?php if ( function_exists('wp_pagenavi') ) : ?>
				<?php wp_pagenavi(); ?>
			<?php else : ?>
				<?php
					$post_nav_blog = '';

					if ( !is_search() ) {
						$post_nav_blog .= '<div class="link-prev">' . get_next_posts_link( __('&#8592; Older Posts', 'frontier') ) . '</div>';
						$post_nav_blog .= '<div class="link-next">' . get_previous_posts_link( __('Newer Posts &#8594;', 'frontier') ) . '</div>';
					}
					else {
						$post_nav_blog .= '<div class="link-next">' . get_next_posts_link( __('Next Page &#8594;', 'frontier') ) . '</div>';
						$post_nav_blog .= '<div class="link-prev">' . get_previous_posts_link( __('&#8592; Previous Page', 'frontier') ) . '</div>';
					}

					echo apply_filters( 'frontier_post_nav_blog', $post_nav_blog );

				?>

			<?php endif; ?>
		</div>
	<?php endif; ?>
<?php if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>
	<?php if ( is_active_sidebar('widgets_after_content') ) : ?>
		<div id="widgets-wrap-after-content" class="cf"><?php dynamic_sidebar('widgets_after_content'); ?></div>
	<?php endif; ?>

<?php do_action('frontier_after_content'); ?>
</div>

<?php
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
?>
<?php get_footer(); ?>