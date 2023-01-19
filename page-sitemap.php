<?php // Template Name: Sitemap ?>

<?php get_header(); ?>

<div id="content" class="cf">
	<?php do_action('frontier_before_content'); ?>

	<article class="sitemap-template single-view">

		<div class="entry-content cf">
			<?php the_post(); the_content(); ?>

			<h3><?php _e('Pages', 'frontier'); ?></h3>
			<ul><?php wp_list_pages('title_li='); ?></ul>

			<h3><?php _e('Categories', 'frontier'); ?></h3>
			<ul><?php wp_list_categories('title_li='); ?></ul>

			<h3><?php _e('Recent Posts', 'frontier'); ?></h3>
			<ul><?php
					$archive_query = new WP_Query('showposts=30&cat=-8');
					while ( $archive_query->have_posts() ) : $archive_query->the_post();
				?>
					<li><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile; ?>
			</ul>
		</div>

	</article>

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