<?php do_action('frontier_before_slider'); ?>

<div id="basic-slider">
	<?php
		$slider_cat_array = frontier_option('slider_categories');
		$slider_post_count = frontier_option('slider_post_count', 6);

		if ( frontier_option('slider_categories') ) {
			foreach ($slider_cat_array as $id => $value) {
				if ( 1 == $value ) $slider_cat[] = $id;
			}
		}
		else {
			$slider_cat = false;
		}

		$frontier_slider_query = array(
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' 		=> $slider_post_count,
			'orderby' 				=> 'menu_order date',
			'order' 				=> 'DESC',
			'category__in' 			=> $slider_cat,
		);

		$slider_loop = new WP_Query( apply_filters( 'frontier_slider_query', $frontier_slider_query ) );
	?>

	<ul class="bjqs">
		<?php while ( $slider_loop->have_posts() ) : $slider_loop->the_post(); ?>

			<?php
				if ( has_post_thumbnail() ) {
					$image_attr = wp_get_attachment_image_src( get_post_thumbnail_id(), apply_filters( 'frontier_slider_image_size', 'large' ) );
					$image_src = $image_attr[0];
				}
				else {
					if ( '' == frontier_option('slider_default_image') )
						$image_src = get_template_directory_uri() . '/images/default-slide.png';
					else
						$image_src = frontier_option('slider_default_image', get_template_directory_uri() . '/images/default-slide.png');
				}

				$slider_elements = frontier_option('slider_elements');
			?>

			<li>
				<a href="<?php the_permalink(); ?>">

					<img class="slider-element" src="<?php echo $image_src; ?>" alt="" />

					<?php if ( 1 == $slider_elements['title'] ) : ?>
						<h4 class="slider-element"><?php the_title(); ?></h4>
					<?php endif; ?>

					<?php if ( 1 == $slider_elements['text'] ) : ?>
						<p class="slider-element"><?php echo wp_trim_words( get_the_excerpt(), 40, null ); ?></p>
					<?php endif; ?>

				</a>
			</li>

		<?php endwhile; ?>

		<?php wp_reset_postdata(); ?>
	</ul>
</div>

<?php do_action('frontier_after_slider'); ?>