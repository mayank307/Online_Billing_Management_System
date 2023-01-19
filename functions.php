<?php
/**
 * Frontier Theme Setup & Functions.
 * @package Frontier
 *
 */
$frontier_version = "1.2.3";

/*-------------------------------------
	Setup Theme Options
--------------------------------------*/
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/includes/options-framework/' );
	require_once dirname( __FILE__ ) . '/includes/options-framework/options-framework.php';
}

function frontier_option( $name, $default = false ) {
	$config = get_option( 'optionsframework' );

	if ( ! isset( $config['id'] ) ) return $default;
	$options = get_option( $config['id'] );
	if ( isset( $options[$name] ) ) return $options[$name];
	
	return $default;
}

/*-------------------------------------
	Register Styles & Scripts
--------------------------------------*/
function frontier_enqueue_styles() {
	global $frontier_version;

	wp_enqueue_style( 'frontier-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Arimo:400,700', array(), false );
	wp_enqueue_style( 'frontier-icon', get_template_directory_uri() . '/includes/genericons/genericons.css', array(), $frontier_version );
	wp_enqueue_style( 'frontier-main', get_stylesheet_uri(), array(), $frontier_version );
	if ( frontier_option('responsive_disable', 0) != 1 ) {
		wp_enqueue_style( 'frontier-responsive', get_template_directory_uri() . '/responsive.css', array(), $frontier_version );
		wp_enqueue_script( 'frontier-nav', get_template_directory_uri() . '/includes/nav-toggle.js', array( 'jquery' ), $frontier_version, true );
	}
	if ( frontier_option('slider_enable') == 1 )
		wp_enqueue_script( 'basic-slider', get_template_directory_uri() . '/includes/slider/bjqs-1.3.min.js', array( 'jquery' ), $frontier_version, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'frontier_enqueue_styles' );


/*-------------------------------------
	Frontier Theme Setup
--------------------------------------*/
function frontier_theme_setup() {
	global	$content_width, $frontier_container, $frontier_header, $frontier_content;

	// Get needed values for layout
	frontier_get_layout_values();

	load_theme_textdomain( 'frontier', get_template_directory() . '/languages' );

	register_nav_menu( 'frontier-menu-top', __( 'Top Bar', 'frontier' ) );

	register_nav_menu( 'frontier-menu-primary', __( 'Primary', 'frontier' ) );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'custom-background', array(
		'default-color' => '505050',
		'default-image' => get_template_directory_uri() . '/images/honeycomb.png',
	) );

	add_theme_support( 'custom-header', array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => $frontier_container,
		'height'                 => $frontier_header,	
		'flex-height'            => true,
		'flex-width'             => true,
		'header-text'            => false,
		'uploads'                => true,
	) );

	add_theme_support( 'post-thumbnails' );

	add_image_size( 'thumb-200x120', 200, 120, true );

	add_theme_support( 'html5', array( 'search-form', 'comment-form' ) );

	add_filter( 'widget_text', 'do_shortcode' );

	add_action( 'wp_head', 'frontier_head_extra', 1 );

	// Print CSS for layout
	add_action( 'wp_head', 'frontier_print_layout' );
	add_action( 'wp_head', 'frontier_print_layout_page' );

	// Print CSS for header image
	if ( !( get_header_image() == '' ) ) add_action( 'wp_head', 'frontier_header_image' );

	// Print CSS for colors
	if ( frontier_option('colors_enable') == 1 ) add_action( 'wp_head', 'frontier_custom_colors' );

	// Print Custom CSS if available
	if ( frontier_option('custom_css') ) add_action( 'wp_head', 'frontier_print_custom_css', 990 );

	if ( frontier_option('favicon') ) add_action( 'wp_head', 'frontier_favicon', 8 );
	if ( frontier_option('head_codes') ) add_action( 'wp_head', 'frontier_head_codes' );
	if ( frontier_option('editor_style_disable') != 1 ) frontier_editor_style();

	if ( frontier_option('slider_enable') == 1 ) {
		frontier_show_slider();
		add_action( 'wp_footer', 'frontier_slider_script', 20 );
		if ( frontier_option('slider_stretch') == 'stretch' ) add_action( 'wp_head', 'frontier_slider_stretch' );
	}
}
add_action( 'after_setup_theme', 'frontier_theme_setup' );


/*-------------------------------------
	Set Default Title
--------------------------------------*/
function frontier_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	$title .= get_bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'frontier' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'frontier_wp_title', 10, 2 );


/*----------------------------------------
	Custom Entries to the Admin Bar
-----------------------------------------*/
function frontier_admin_bar_menu() {
	global $wp_admin_bar;

	if ( current_user_can( 'edit_theme_options' ) ) {
		$wp_admin_bar->add_menu( array(
			'parent' => false,
			'id' => 'frontier_admin_bar', 
			'title' => __('Frontier Options', 'frontier'), 
			'href' => admin_url('themes.php?page=frontier-options') ) );

		$wp_admin_bar->add_menu( array(
			'parent' => 'appearance',
			'id' => 'theme_editor_admin_bar', 	
			'title' => __('Editor', 'frontier'), 
			'href' => admin_url('theme-editor.php') ) );

		$wp_admin_bar->add_menu( array(
			'parent' => 'appearance',
			'id' => 'plugins_admin_bar', 	
			'title' => __('Plugins', 'frontier'), 
			'href' => admin_url('plugins.php') ) );
	}
}
add_action( 'admin_bar_menu', 'frontier_admin_bar_menu', 88 );


/*----------------------------------------
	Register Sidebars
-----------------------------------------*/
function frontier_register_sidebars() {
	register_sidebar( array(
		'name' 			=> __('Sidebar &ndash; Left', 'frontier'),
		'id' 			=> 'widgets_sidebar_left',
		'description'	=> __('For layouts and templates with a left sidebar.', 'frontier'),
		'before_widget' => '<div id="%1$s" class="widget-sidebar frontier-widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="widget-title">',
		'after_title' 	=> '</h4>') );

	register_sidebar( array(
		'name' 			=> __('Sidebar &ndash; Right', 'frontier'),
		'id' 			=> 'widgets_sidebar_right',
		'description'	=> __('For layouts and templates with a right sidebar.', 'frontier'),
		'before_widget' => '<div id="%1$s" class="widget-sidebar frontier-widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="widget-title">',
		'after_title' 	=> '</h4>') );

	frontier_register_sidebars_extra();
}
add_action( 'widgets_init', 'frontier_register_sidebars' );


function frontier_register_sidebars_extra() {
	$widget_areas = frontier_option('widget_areas');

	if ( $widget_areas['body'] == 1 ) {
		register_sidebar( array(
			'name' 			=> __('Body', 'frontier'),
			'id' 			=> 'widgets_body',
			'description'	=> __('Widgets outside of the container. If used, you\'ll have to position the widgets with css.', 'frontier'),
			'before_widget' => '<div id="%1$s" class="widget-body frontier-widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h4 class="widget-title">',
			'after_title' 	=> '</h4>') );
	}

	if ( !isset($widget_areas['header']) || $widget_areas['header'] == 1 ) {
		register_sidebar( array(
			'name' 			=> __('Header', 'frontier'),
			'id' 			=> 'widgets_header',
			'description'	=> __('Widgets to appear on the header. Ideal for horizontal ads or banners.', 'frontier'),
			'before_widget' => '<div id="%1$s" class="widget-header frontier-widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h4 class="widget-title">',
			'after_title' 	=> '</h4>') );
	}

	if ( $widget_areas['below_menu'] == 1 ) {
		register_sidebar( array(
			'name' 			=> __('Below Menu', 'frontier'),
			'id' 			=> 'widgets_below_menu',
			'description'	=> __('Full-width widgets that appear under the main menu. Ideal for horizontal ads or banners.', 'frontier'),
			'before_widget' => '<div id="%1$s" class="widget-below-menu frontier-widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h4 class="widget-title">',
			'after_title' 	=> '</h4>') );
	}

	if ( $widget_areas['before_content'] == 1 ) {
		register_sidebar(array(
			'name' 			=> __('Before Content', 'frontier'),
			'id' 			=> 'widgets_before_content',
			'before_widget' => '<div id="%1$s" class="widget-before-content frontier-widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h4 class="widget-title">',
			'after_title' 	=> '</h4>') );
	}

	if ( $widget_areas['after_content'] == 1 ) {
		register_sidebar( array(
			'name' 			=> __('After Content', 'frontier'),
			'id' 			=> 'widgets_after_content',
			'before_widget' => '<div id="%1$s" class="widget-after-content frontier-widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h4 class="widget-title">',
			'after_title' 	=> '</h4>') );
	}

	if ( !isset($widget_areas['footer']) || $widget_areas['footer'] == 1 ) {
		register_sidebar( array(
			'name' 			=> __('Footer', 'frontier'),
			'id' 			=> 'widgets_footer',
			'description'	=> __('You can set the number of widgets per row on the options page. 1, 2, 3, 4, 5 or 6 columns.', 'frontier'),
			'before_widget' => '<div id="%1$s" class="widget-footer frontier-widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h4 class="widget-title">',
			'after_title' 	=> '</h4>') );
	}

	if ( !isset($widget_areas['post_header']) || $widget_areas['post_header'] == 1 ) {
		register_sidebar( array(
			'name' 			=> __('Post &ndash; Header', 'frontier'),
			'id' 			=> 'widgets_before_post',
			'before_widget' => '<div id="%1$s" class="widget-before-post frontier-widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h4 class="widget-title">',
			'after_title' 	=> '</h4>') );
	}

	if ( !isset($widget_areas['post_before_content']) || $widget_areas['post_before_content'] == 1 ) {
		register_sidebar( array(
			'name' 			=> __('Post &ndash; Before Content', 'frontier'),
			'id' 			=> 'widgets_before_post_content',
			'before_widget' => '<div id="%1$s" class="widget-before-post-content frontier-widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h4 class="widget-title">',
			'after_title' 	=> '</h4>') );
	}

	if ( !isset($widget_areas['post_after_content']) || $widget_areas['post_after_content'] == 1 ) {
		register_sidebar( array(
			'name' 			=> __('Post &ndash; After Content', 'frontier'),
			'id' 			=> 'widgets_after_post_content',
			'before_widget' => '<div id="%1$s" class="widget-after-post-content frontier-widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h4 class="widget-title">',
			'after_title' 	=> '</h4>') );
	}

	if ( !isset($widget_areas['post_footer']) || $widget_areas['post_footer'] == 1 ) {
		register_sidebar( array(
			'name' 			=> __('Post &ndash; Footer', 'frontier'),
			'id' 			=> 'widgets_after_post',
			'before_widget' => '<div id="%1$s" class="widget-after-post frontier-widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h4 class="widget-title">',
			'after_title' 	=> '</h4>') );
	}
}

function frontier_head_extra() { 
?>
<meta name="viewport" content="initial-scale=1.0" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php 
}

/*-------------------------------------
	Get Layout Values - Theme Setup
--------------------------------------*/
function frontier_get_layout_values() {
	global	$content_width, $frontier_container, $frontier_header, $frontier_content, $frontier_side_left, $frontier_side_right, $footer_widget_css,
			$frontier_2col_content, $frontier_2col_sidebar, $frontier_3col_content, $frontier_3col_sidebar1, $frontier_3col_sidebar2;

	$frontier_container = frontier_option('width_container', 960);

	$frontier_header = frontier_option('header_height', 140);

	$frontier_2col_content = frontier_option('width_two_column', 65);
	$frontier_2col_sidebar = 100 - frontier_option('width_two_column', 65);
	
	$frontier_3col_value = explode( '-', frontier_option('width_three_column', '25-75') );
	$frontier_3col_content = $frontier_3col_value[1] - $frontier_3col_value[0];
	$frontier_3col_sidebar1 = $frontier_3col_value[0];
	$frontier_3col_sidebar2 = 100 - $frontier_3col_value[1];

	switch ( frontier_option('column_layout', 'col-cs') ) {
		case 'col-c'  :
			$frontier_content = 100;
			$content_width = $frontier_container - 42;
			break;

		case 'col-sc' :
		case 'col-cs' :
			$frontier_content = $frontier_2col_content;
			$frontier_side_left = $frontier_2col_sidebar;
			$frontier_side_right = $frontier_2col_sidebar;
			$content_width = intval( $frontier_container * ( $frontier_content / 100 ) ) - 38;
			break;

		case 'col-ssc' :
		case 'col-css' :
		case 'col-scs' :
			$frontier_content = $frontier_3col_content;
			$frontier_side_left = $frontier_3col_sidebar1;
			$frontier_side_right = $frontier_3col_sidebar2;
			$content_width = intval( $frontier_container * ( $frontier_content / 100 ) ) - 38;
			break;
	}
}

/*-------------------------------------
	Layout CSS - Theme Setup
--------------------------------------*/
function frontier_print_layout() {
	global	$frontier_version, $frontier_container,
			$frontier_content, $frontier_side_left, $frontier_side_right;

	$header_min = ( frontier_option('header_logo') ) ? 0 : frontier_option('header_height', 140);
echo '
<meta property="Frontier Theme" content="' . $frontier_version . '" />
<style type="text/css" media="screen">
	#container 	{width: ' . $frontier_container . 'px;}
	#header 	{min-height: ' . $header_min . 'px;}
	#content 	{width: ' . $frontier_content . '%;}
	#sidebar-left 	{width: ' . $frontier_side_left . '%;}
	#sidebar-right 	{width: ' . $frontier_side_right . '%;}
</style>' . "\n";
}

/*-------------------------------------
	Layout CSS for Pages - Theme Setup
--------------------------------------*/
function frontier_print_layout_page() {
	global	$frontier_2col_content, $frontier_2col_sidebar,
			$frontier_3col_content, $frontier_3col_sidebar1, $frontier_3col_sidebar2;
echo '
<style type="text/css" media="screen">
	.page-template-page-cs-php #content, .page-template-page-sc-php #content {width: ' . $frontier_2col_content . '%;}
	.page-template-page-cs-php #sidebar-left, .page-template-page-sc-php #sidebar-left,
	.page-template-page-cs-php #sidebar-right, .page-template-page-sc-php #sidebar-right {width: ' . $frontier_2col_sidebar . '%;}
	.page-template-page-scs-php #content {width: ' . $frontier_3col_content . '%;}
	.page-template-page-scs-php #sidebar-left {width: ' . $frontier_3col_sidebar1 . '%;}
	.page-template-page-scs-php #sidebar-right {width: ' . $frontier_3col_sidebar2 . '%;}
</style>' . "\n\n";
}

/*-------------------------------------
	Header BG CSS - Theme Setup
--------------------------------------*/
function frontier_header_image() {
	global $frontier_container, $frontier_header;
echo
'<style type="text/css" media="screen">
	#header {
		background-image: url(\'' . get_header_image() . '\');
		background-size: ' . $frontier_container . 'px ' . $frontier_header . 'px;
	}
</style>' . "\n\n";
}

/*-------------------------------------
	Custom Colors CSS - Theme Setup
--------------------------------------*/
function frontier_custom_colors() {
	$colormotif = frontier_option('color_motif');
	$colortopbar = frontier_option('color_top_bar');
	$colorheader = frontier_option('color_header');
	$colormenu = frontier_option('color_menu_main');
	$colorbottombar = frontier_option('color_bottom_bar');
	$colorlinks = frontier_option('color_links');
	$colorlinkshover = frontier_option('color_links_hover');

echo
'<style type="text/css" media="screen">
	#header {background-color:' . $colorheader . ';}
	#nav-main {background-color:' . $colormenu . ';}
	#nav-main .nav-main {border-left: 1px solid ' . frontier_alter_color( $colormenu, -40 ) . '; border-right: 1px solid ' . frontier_alter_color( $colormenu, 30 ) . ';}
	#nav-main .nav-main > li, #nav-main .nav-main > ul > .page_item {border-left: 1px solid ' . frontier_alter_color( $colormenu, 30 ) . '; border-right: 1px solid ' . frontier_alter_color( $colormenu, -40 ) . ';}
	#top-bar {background-color:' . $colortopbar . ';}
	#bottom-bar {background-color:' . $colorbottombar . ';}
	.blog-view, .comment-author-admin > .comment-body, .bypostauthor > .comment-body {border-top: 6px solid ' . $colormotif . ';}
	.page-nav > *, .comment-nav > *, .author-info .title, .comment-reply-link, .widget-title,
	.widget_search .search-submit, .widget_calendar caption {background-color:' . $colormotif . ';}
	.genericon {color:' . $colormotif . ';}
	a {color:' . $colorlinks . ';}
	a:hover {color:' . $colorlinkshover . ';}
</style>' . "\n\n";
}

function frontier_alter_color( $hex, $steps ) {
    $steps = max(-255, min(255, $steps));

    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}

/*-------------------------------------
	Custom CSS - Theme Setup
--------------------------------------*/
function frontier_print_custom_css() {
	echo "\n" . '<!-- Custom CSS -->' . "\n" . '<style type="text/css" media="screen">' . "\n";
	echo frontier_option('custom_css');
	echo "\n" . '</style>' . "\n" . '<!-- Custom CSS End -->' . "\n\n";
}

/*-------------------------------------
	Favicon - Theme Setup
--------------------------------------*/
function frontier_favicon() {
	echo '<link rel="icon" href="' . esc_url( frontier_option('favicon') ) . '" type="image/x-icon" />' . "\n";
}

/*-------------------------------------
	Custom Codes - Theme Setup
--------------------------------------*/
function frontier_head_codes() {
	echo '<!-- Custom Head Codes -->' . "\n";
	echo frontier_option('head_codes');
	echo "\n" . '<!-- Custom Head Codes End -->' . "\n\n";
}

/*----------------------------------------
	Post Editor Style - Theme Setup
-----------------------------------------*/
function frontier_editor_style() {
	add_editor_style();
	add_action( 'before_wp_tiny_mce', 'frontier_tinymce_width' );
}

function frontier_tinymce_width() {
	global $content_width, $frontier_container, $frontier_2col_content, $frontier_3col_content;

	$tinymce_width = $content_width;

	switch ( get_page_template_slug() ) {
		case 'page-c.php'		:
		case 'page-blank.php'	:
			$tinymce_width = $frontier_container - 42;
			break;

		case 'page-sc.php'	:
		case 'page-cs.php'	:
			$tinymce_width = intval( $frontier_container * ( $frontier_2col_content / 100 ) ) - 38;
			break;

		case 'page-scs.php'	:
			$tinymce_width = intval( $frontier_container * ( $frontier_3col_content / 100 ) ) - 38;
			break;
	}

?>
<script type="text/javascript">
jQuery( document ).ready( function() {
	var editor_width = '.mceContentBody {width: <?php echo $tinymce_width; ?>px;}';
	var checkInterval = setInterval(
		function() {
			if ( 'undefined' !== typeof( tinyMCE ) ) {
				if ( tinyMCE.activeEditor && ! tinyMCE.activeEditor.isHidden() ) {
					jQuery( '#content_ifr' ).contents().find( 'head' ).append( '<style>' + editor_width + '</style>' );
					clearInterval( checkInterval );
				}
			}
	}, 500 );
} );
</script>
<?php
}

/*-------------------------------------
	Slider Template - Theme Setup
--------------------------------------*/
function frontier_show_slider() {
	if ( frontier_option('slider_position') == 'before_main' ) {
		add_action('frontier_before_main', 'frontier_slider_on_main'); }
	else {
		add_action('frontier_before_content', 'frontier_slider_on_content');
	}
}

function frontier_slider_on_main() {
	if ( is_home() || is_front_page() ) {
		echo '<div id="slider" class="slider-main">';
		get_template_part('slider');
		echo '</div>';
	}
}

function frontier_slider_on_content() {
	if ( is_home() || is_front_page() ) {
		echo '<div id="slider" class="slider-content">';
		get_template_part('slider');
		echo '</div>';
	}
}

/*-------------------------------------
	Slider Script - Theme Setup
--------------------------------------*/
function frontier_slider_script() {
	global $frontier_container, $frontier_content;
	$slider_width = frontier_option('slider_position') == 'before_main' ? $frontier_container : $frontier_container * ( $frontier_content / 100 );
?>
<script type="text/javascript">
jQuery( document ).ready( function($) {
	$( '#basic-slider' ).bjqs( {
		animtype : 'fade',
		width : <?php echo $slider_width; ?>,
		height : <?php echo frontier_option('slider_height'); ?>,
		animduration : <?php echo frontier_option('slider_slide_speed'); ?>,
		animspeed : <?php echo frontier_option('slider_pause_time'); ?>,
		automatic : true,
		showcontrols : true,
		nexttext : '<span class="slider-next"></span>',
		prevtext : '<span class="slider-prev"></span>',
		showmarkers : false,
		usecaptions : true,
		responsive : true
	} );
} );
</script>
<?php
}

/*-------------------------------------
	Slider Stretch - Theme Setup
--------------------------------------*/
function frontier_slider_stretch() {
	echo '<style type="text/css">.bjqs-slide a, .bjqs-slide img {height: 100%; width: 100%;}</style>' . "\n\n";
}

/*-------------------------------------
	Attachment Page Image
--------------------------------------*/
function frontier_prepend_attachment( $content ) {
	$attachment_image = '<div class="attachment">';
	$attachment_image .= wp_get_attachment_link( 0, apply_filters( 'frontier_attachment_image_size', 'full' ), false );
	$attachment_image .= '<p class="wp-caption-text">' . get_post()->post_excerpt . '</p>';
	$attachment_image .= '</div>';

	if ( wp_attachment_is_image() )
		return $attachment_image;
	else
		return $content;
}
add_filter( 'prepend_attachment', 'frontier_prepend_attachment' );


/*-------------------------------------
	Callback: Comment Markup
--------------------------------------*/
function frontier_comments( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">

<?php if ( get_comment_type() == 'comment' || !$args['short_ping'] ) : ?>

	<div class="comment-meta">
		<div class="comment-author">
			<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'], '', get_comment_author() ); ?>
			<div class="link"><?php echo get_comment_author_link(); ?></div>
		</div>

		<div class="comment-metadata">
			<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
				<time datetime="<?php comment_time( 'c' ); ?>">
					<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'frontier' ), get_comment_date(), get_comment_time() ); ?>
				</time>
			</a>
			<?php edit_comment_link( __( 'Edit', 'frontier' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php if ( '0' == $comment->comment_approved ) : ?>
		<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'frontier' ); ?></p>
	<?php endif; ?>
	</div>

	<div class="comment-content"><?php comment_text(); ?></div>

	<div class="reply"><?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>

<?php else : ?>

	<?php _e( 'Pingback:', 'frontier' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'frontier' ), '<span class="edit-link">', '</span>' ); ?>

<?php endif; ?>

</div>
<?php
}