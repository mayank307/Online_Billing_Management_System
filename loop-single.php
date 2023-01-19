<?php
$post_defaults = array(
	'author'		=> '1',
	'published'		=> '1',
	'categories'	=> '1',
	'comment_info'	=> '1',
	'updated'		=> '1',
	'tags'			=> '1',
	'author_box'	=> '0',
	'post_nav'		=> '1',
	'comments'		=> '1',
);
$post_elements = frontier_option('post_elements', array());
$post_elements = wp_parse_args($post_elements, $post_defaults);

$page_defaults = array(
	'author'		=> '0',
	'published'		=> '0',
	'comment_info'	=> '0',
	'updated'		=> '0',
	'author_box'	=> '0',
	'comments'		=> '1',
);
$page_elements = frontier_option('page_elements', array());
$page_elements = wp_parse_args($page_elements, $page_defaults);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-view'); ?>>
<?php do_action('frontier_before_single_article'); ?>

<?php if ( is_active_sidebar('widgets_before_post') ) : ?><div id="widgets-wrap-before-post" class="cf"><?php dynamic_sidebar('widgets_before_post'); ?></div><?php endif; ?>

<header class="entry-header cf">
	<?php do_action('frontier_before_single_post_header'); ?>
	<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	<?php do_action('frontier_after_single_post_header'); ?>
</header>

<div class="entry-byline cf">
	<?php do_action('frontier_before_single_post_byline'); ?>

	<?php if ( ( is_singular(array('post','attachment')) && $post_elements['author'] == 1 ) || ( is_page() && $page_elements['author'] == 1 ) ) : ?>
		<div class="entry-author author vcard">
			<?php $frontier_post_author_url = get_the_author_meta('user_url') != '' ? get_the_author_meta('user_url') : get_author_posts_url( get_the_author_meta('ID') ); ?>
			<i class="genericon genericon-user"></i><a class="url fn" href="<?php echo esc_url( $frontier_post_author_url ); ?>"><?php the_author(); ?></a>
		</div>
	<?php endif; ?>

	<?php if ( ( is_singular(array('post','attachment')) && $post_elements['published'] == 1 ) || ( is_page() && $page_elements['published'] == 1 ) ) : ?>
		<div class="entry-date">
			<i class="genericon genericon-day"></i><a class="updated" href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a>
		</div>
	<?php endif; ?>

	<?php if ( is_singular('post') && $post_elements['categories'] == 1 ) : ?>
		<div class="entry-categories">
			<i class="genericon genericon-category"></i><?php the_category(', '); ?>
		</div>
	<?php endif; ?>

	<?php if ( ( ( is_singular(array('post','attachment')) && $post_elements['comment_info'] == 1 ) || ( is_page() && $page_elements['comment_info'] == 1 ) ) && ( comments_open() || ( !comments_open() && get_comments_number() != 0 ) ) ) : ?>
		<div class="entry-comment-info">
			<i class="genericon genericon-comment"></i><a href="#comment-area"><?php comments_number( __('Comments', 'frontier'), __('1 Comment', 'frontier'), __('% Comments', 'frontier') ); ?></a>
		</div>
	<?php endif; ?>

	<?php edit_post_link( __('Edit', 'frontier'), '<i class="genericon genericon-edit"></i>' ); ?>

	<?php do_action('frontier_after_single_post_byline'); ?>
</div>

<div class="entry-content cf">
	<?php do_action('frontier_before_single_post_content'); ?>

	<?php if ( is_active_sidebar('widgets_before_post_content') ) : ?><div id="widgets-wrap-before-post-content" class="cf"><?php dynamic_sidebar('widgets_before_post_content'); ?></div><?php endif; ?>

	<?php the_content(); ?>

	<?php if ( is_active_sidebar('widgets_after_post_content') ) : ?><div id="widgets-wrap-after-post-content" class="cf"><?php dynamic_sidebar('widgets_after_post_content'); ?></div><?php endif; ?>

	<?php if ( is_attachment() && wp_attachment_is_image() ) : ?>
		<div class="attachment-nav cf">
			<?php $nav_image_size = apply_filters( 'frontier_prev_next_image_size', 0 ); ?>
			<div class="link-prev"><?php previous_image_link( $nav_image_size, __('&#8592; Previous Image', 'frontier') ); ?></div>
			<div class="link-next"><?php next_image_link( $nav_image_size, __('Next Image &#8594;', 'frontier') ); ?></div>
		</div>
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

	<?php do_action('frontier_after_single_post_content'); ?>
</div>

<footer class="entry-footer cf">
	<?php do_action('frontier_before_single_post_footer'); ?>

	<?php if ( ( is_singular('post') && $post_elements['updated'] == 1 ) || ( is_page() && $page_elements['updated'] == 1 ) ) : ?>
		<div class="entry-updated updated">
			<?php printf( __( 'Updated: %1$s &mdash; %2$s', 'frontier' ), get_the_modified_date(), get_the_modified_time() ); ?>
		</div>
	<?php endif; ?>

	<?php if ( is_singular('post') && $post_elements['tags'] == 1 ) : ?>
		<div class="entry-tags"><?php the_tags(); ?></div>
	<?php endif; ?>

	<?php do_action('frontier_after_single_post_footer'); ?>
</footer>

<?php if ( is_active_sidebar('widgets_after_post') ) : ?><div id="widgets-wrap-after-post" class="cf"><?php dynamic_sidebar('widgets_after_post'); ?></div><?php endif; ?>

<?php do_action('frontier_after_single_article'); ?>
</article>

<?php if ( ( is_singular('post') && $post_elements['author_box'] == 1 ) || ( is_page() && $page_elements['author_box'] == 1 ) ) : ?>
	<div class="author-info">
		<?php
			$frontier_author_info = '<h4 class="title">' . __('The Author', 'frontier') . '</h4>';
			$frontier_author_info .= '<div class="author-avatar">' . get_avatar( get_the_author_meta('ID'), 64 ) . '</div>';
			$frontier_author_info .= '<div class="author-description"><h4>' . get_the_author_link() . '</h4>' . get_the_author_meta('description') . '</div>';
			echo apply_filters( 'frontier_author_info', $frontier_author_info );
		?>
	</div>
<?php endif; ?>

<?php if ( is_singular('post') && $post_elements['post_nav'] == 1 ) : ?>
	<div class="post-nav cf">
		<?php
			$prev_post = get_previous_post();
			$next_post = get_next_post();
			$post_nav_single = '';

			if ( !empty($prev_post) )
				$post_nav_single .= '<div class="link-prev"><a href="' . get_permalink( $prev_post->ID ) . '" title="' . esc_attr( $prev_post->post_title ) . '">' . __('&#8592; Previous Post', 'frontier') . '</a></div>';

			if ( !empty($next_post) )
				$post_nav_single .= '<div class="link-next"><a href="' . get_permalink( $next_post->ID ) . '" title="' . esc_attr( $next_post->post_title ) . '">' . __('Next Post &#8594;', 'frontier') . '</a></div>';
			
			echo apply_filters( 'frontier_post_nav_single', $post_nav_single );
		?>
	</div>
<?php endif; ?>

<?php if ( ( !is_page() && $post_elements['comments'] == 1 ) || ( is_page() && $page_elements['comments'] == 1 ) ) : ?>
	<?php do_action('frontier_before_comments'); ?>
		<div id="comment-area"><?php comments_template(); ?></div>
	<?php do_action('frontier_after_comments'); ?>
<?php endif; ?>