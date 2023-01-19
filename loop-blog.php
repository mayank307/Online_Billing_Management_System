<?php
$blog_defaults = array(
	'thumbnail'		=> '1',
	'author'		=> '1',
	'published'		=> '1',
	'categories'	=> '1',
	'comment_info'	=> '1',
	'continue_btn'	=> '1',
	'updated'		=> '0',
	'tags'			=> '0',
);

$blog_elements = frontier_option('blog_elements', array());
$blog_elements = wp_parse_args($blog_elements, $blog_defaults);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-view'); ?>>
<?php do_action('frontier_before_blog_article'); ?>

<header class="entry-header cf">
	<?php do_action('frontier_before_blog_post_header'); ?>
	<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<?php do_action('frontier_after_blog_post_header'); ?>
</header>

<div class="entry-byline cf">
	<?php do_action('frontier_before_blog_post_byline'); ?>

	<?php if ( $blog_elements['author'] == 1 ) : ?>
		<div class="entry-author author vcard">
			<?php $frontier_post_author_url = get_the_author_meta('user_url') != '' ? get_the_author_meta('user_url') : get_author_posts_url( get_the_author_meta('ID') ); ?>
			<i class="genericon genericon-user"></i><a class="url fn" href="<?php echo esc_url( $frontier_post_author_url ); ?>"><?php the_author(); ?></a>
		</div>
	<?php endif; ?>

	<?php if ( $blog_elements['published'] == 1 ) : ?>
		<div class="entry-date">
			<i class="genericon genericon-day"></i><a class="updated" href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a>
		</div>
	<?php endif; ?>

	<?php if ( get_post_type() == 'post' && $blog_elements['categories'] == 1 ) : ?>
		<div class="entry-categories">
			<i class="genericon genericon-category"></i><?php the_category(', '); ?>
		</div>
	<?php endif; ?>

	<?php if ( $blog_elements['comment_info'] == 1 ) : ?>
		<div class="entry-comment-info">
			<i class="genericon genericon-comment"></i><a href="<?php the_permalink(); ?>#comment-area"><?php comments_number( __('Comments', 'frontier'), __('1 Comment', 'frontier'), __('% Comments', 'frontier') ); ?></a>
		</div>
	<?php endif; ?>

	<?php edit_post_link( __('Edit', 'frontier'), '<i class="genericon genericon-edit"></i>' ); ?>

	<?php do_action('frontier_after_blog_post_byline'); ?>
</div>

<div class="entry-content cf">
	<?php do_action('frontier_before_blog_post_content'); ?>

	<?php if ( frontier_option('blog_display', 'excerpt') == 'excerpt' ) : ?>

		<?php if ( $blog_elements['thumbnail'] == 1 ) : ?>
			<?php if ( apply_filters( 'frontier_has_post_thumbnail', has_post_thumbnail() ) ) : ?>
				<div class="entry-thumbnail">
					<a class="post-thumbnail" href="<?php the_permalink(); ?>">
						<?php
							if ( frontier_option('excerpt_thumbnail', '150') == '150' )
								$frontier_excerpt_thumbnail = get_the_post_thumbnail( get_the_ID(), 'thumbnail' );
							else
								$frontier_excerpt_thumbnail = get_the_post_thumbnail( get_the_ID(), 'thumb-200x120' );

							echo apply_filters( 'frontier_excerpt_thumbnail' , $frontier_excerpt_thumbnail );
						?>
					</a>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<div class="entry-excerpt"><?php the_excerpt(); ?></div>

	<?php else : ?>

		<?php the_content(); ?>

	<?php endif; ?>

	<?php wp_link_pages( array(
		'before'           => '<div class="page-nav">' . __('<span>Pages</span>', 'frontier'),
		'after'            => '</div>',
		'link_before'      => '<span>',
		'link_after'       => '</span>',
		'next_or_number'   => 'number',
		'nextpagelink'     => __('Next page', 'frontier'),
		'previouspagelink' => __('Previous page', 'frontier'),
		'pagelink'         => '%',
		'echo'             => 1 ) );
	?>

	<?php do_action('frontier_after_blog_post_content'); ?>
</div>

<footer class="entry-footer cf">
	<?php do_action('frontier_before_blog_post_footer'); ?>

	<?php if ( frontier_option('blog_display', 'excerpt') == 'excerpt' ) : ?>

		<?php if ( $blog_elements['continue_btn'] == 1 ) : ?>
			<a href="<?php the_permalink(); ?>" class="continue-reading">
				<?php $frontier_continue_reading_text = ( get_post_type() == 'page' ) ? __('Read Page', 'frontier') : __('Read Post', 'frontier'); ?>
				<?php echo apply_filters( 'frontier_continue_reading_text', $frontier_continue_reading_text ); ?>
			</a>
		<?php endif; ?>

	<?php endif; ?>

	<?php if ( $blog_elements['updated'] == 1 ) : ?>
		<div class="entry-updated updated">
			<?php printf( __( 'Updated: %1$s &mdash; %2$s', 'frontier' ), get_the_modified_date(), get_the_modified_time() ); ?>
		</div>
	<?php endif; ?>

	<?php if ( get_post_type() == 'post' && $blog_elements['tags'] == 1 ) : ?>
		<div class="entry-tags"><?php the_tags(); ?></div>
	<?php endif; ?>

	<?php do_action('frontier_after_blog_post_footer'); ?>
</footer>

<?php do_action('frontier_after_blog_article'); ?>
</article>