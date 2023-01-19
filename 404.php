<?php get_header(); ?>

<div id="content" class="cf">
	<?php do_action('frontier_before_content'); ?>

	<div class="form-404">
		<?php
			$frontier_404_content = '<h2>' . __('Nothing Found', 'frontier') . '</h2>';
			$frontier_404_content .= '<p>' . __('Sorry. The Page or File you were looking for was not found.', 'frontier') . '</p>';
			$frontier_404_content .= get_search_form( false );
			echo apply_filters( 'frontier_404_content', $frontier_404_content );
		?>
	</div>

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