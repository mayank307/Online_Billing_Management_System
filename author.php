<?php get_header(); ?>

<div id="content" class="cf">

	<div id="author-<?php the_author_meta( 'ID' ); ?>">

		<div class="author-info-box">
			<div class="author-info">
				<div class="author-avatar">
					<?php echo get_avatar( get_the_author_meta('ID'), 96 ); ?>
					<div class="author-post-count"><?php _e('Posts:', 'frontier'); ?>&nbsp;<?php the_author_posts(); ?></div>
				</div>
				<div class="author-description">
					<h4><?php the_author_meta('display_name'); ?></h4>
					<a href="<?php esc_url( the_author_meta('user_url') ); ?>"><?php the_author_meta('user_url'); ?></a>
					<div><?php echo get_the_author_meta('description'); ?></div>
				</div>
			</div>
		</div>

		<div class="author-latest-posts">
			<h4 class="author-latest-posts-title"><?php _e('Latest Posts by the Author', 'frontier'); ?></h4>
			<?php
				$postsQuery = new WP_Query( array(
					'posts_per_page' 	=> 20,
					'author' 			=> get_the_author_meta( 'ID' ),
					'orderby'			=> 'date',
					'suppress_filters'	=> 0 )
				);

				if ( $postsQuery->have_posts() ) :
			?>

			<ol class="author-latest-posts-list">
				<?php while ( $postsQuery->have_posts() ) : $postsQuery->the_post(); ?>
					<li><a href="<?php the_permalink(); ?>"><?php echo get_the_title() != '' ? get_the_title() : __('Untitled', 'frontier'); ?></a></li>
				<?php endwhile; ?>
			</ol>

			<?php endif; wp_reset_postdata(); ?>
		</div>

	</div>

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