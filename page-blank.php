<?php // Template Name: Blank ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="post-<?php the_ID(); ?>">

		<?php
			the_post();
			the_content();
		?>

	</div>

	<?php wp_footer(); ?>
</body>
</html>