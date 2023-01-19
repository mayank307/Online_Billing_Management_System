<?php
function optionsframework_option_name() {
	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = 'frontier_theme';
	update_option( 'optionsframework', $optionsframework_settings );
}

function optionsframework_options() {
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	$imagepath = get_template_directory_uri() . '/includes/options-framework/images/';
	$logofile = get_template_directory_uri() . '/images/logo.png';
	$sliderimage = get_template_directory_uri() . '/images/default-slide.png';

	$options = array();

/*-------------------------------------
	Display
--------------------------------------*/
	$options[] = array('name' => __('Display', 'frontier'), 'type' => 'heading');

	$options[] = array(
		'name' => __('Favicon', 'frontier'),
		'desc' => __('Choose an icon or image to be used as a favicon. You can either upload a file or enter a url.', 'frontier'),
		'id' => 'favicon',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Top Bar', 'frontier'),
		'desc' => __('Show the Top Bar.', 'frontier'),
		'id' => 'top_bar_enable',
		'type' => 'checkbox',
		'std' => '1');

	$options[] = array(
		'desc' => __('Note: the Top Menu only supports top level menu items. It will not show any sub-menus.', 'frontier'),
		'id' => 'top_bar_elements',
		'type' => 'multicheck',
		'std' => array(
			'title'			=> '1',
			'description'	=> '1',
			'top_menu'		=> '0'),
		'options' => array(			
			'title'			=> __('Site Title', 'frontier'),
			'description'	=> __('Site Description', 'frontier'),
			'top_menu'		=> __('Top Menu', 'frontier'))
		);

	$options[] = array(
		'name' => __('Header', 'frontier'),
		'desc' => __('Show the Header.', 'frontier'),
		'id' => 'header_enable',
		'type' => 'checkbox',
		'std' => '1');
		
	$options[] = array(
		'desc' => __('Set the minimum Header Height that is to be used when no Header Logo is present.', 'frontier'),
		'id' => 'header_height',
		'type' => 'text',
		'std' => '140',
		'class' => 'mini px-after');

	$options[] = array(
		'name' => __('Header Logo', 'frontier'),
		'desc' => __('This option is intended for adding or removing your website\'s logo. To change your header\'s background image, check here: <a href=\"?page=custom-header\">Background Image</a>', 'frontier'),
		'id' => 'header_logo',
		'type' => 'upload',
		'std' => $logofile);

	$options[] = array(
		'name' => __('Main Menu', 'frontier'),
		'desc' => __('Show the Main Menu.', 'frontier'),
		'id' => 'main_menu_enable',
		'type' => 'checkbox',
		'std' => '1');

	$options[] = array(
		'name' => __('Footer Text', 'frontier'),
		'id' => 'bottom_bar_text',
		'type' => 'textarea',
		'std' => get_bloginfo('name') . ' &copy; ' . date('Y'),
		'class' => 'code');

/*-------------------------------------
	Layout
--------------------------------------*/
	$options[] = array('name' => __('Layout', 'frontier'), 'type' => 'heading');

	$options[] = array(
		'name' => __('Main Layout', 'frontier'),
		'desc' => __('Select default content and sidebar layout.', 'frontier'),
		'id' => 'column_layout',
		'type' => 'images',
		'std' => 'col-cs',
		'options' => array(
			'col-cs' => $imagepath . 'col-cs.png',		
			'col-c' => $imagepath . 'col-c.png',
			'col-sc' => $imagepath . 'col-sc.png',
			'col-css' => $imagepath . 'col-css.png',
			'col-scs' => $imagepath . 'col-scs.png',
			'col-ssc' => $imagepath . 'col-ssc.png')
		);

	$options[] = array(
		'name' => __('Container Width', 'frontier'),
		'desc' => __('Use the slider to set the width of the container.', 'frontier'),
		'id' => 'width_container',
		'type' => 'slider_ui_width_container',
		'std' => '960');

	$options[] = array(
		'name' => __('Two Column Widths', 'frontier'),
		'desc' => __('Set the width percentage for the content area and a sidebar. These values apply wherever a two-column layout is being used.', 'frontier'),
		'id' => 'width_two_column',
		'type' => 'slider_ui_width_2col',
		'std' => '65');

	$options[] = array(
		'name' => __('Three Column Widths', 'frontier'),
		'desc' => __('Set the width percentage for the content area and two sidebars. These values apply wherever a three-column layout is being used.', 'frontier'),
		'id' => 'width_three_column',
		'type' => 'slider_ui_width_3col',
		'std' => '25-75');

/*-------------------------------------
	Blog
--------------------------------------*/
	$options[] = array('name' => __('Blog View', 'frontier'), 'type' => 'heading');

	$options[] = array(
		'name' => __('Article Display', 'frontier'),
		'desc' => __('Select whether to show excerpts or full content.', 'frontier'),
		'id' => 'blog_display',
		'type' => 'radio',
		'std' => 'excerpt',
		'options' => array(
			'excerpt'	=> 'Excerpt',
			'full' 		=> 'Full')
		);

	$options[] = array(
		'name' => __('Article Elements', 'frontier'),
		'desc' => __('Select elements to display when posts are displayed on blog view. Note: Thumbnail uses the featured image that is set on each post.', 'frontier'),
		'id' => 'blog_elements',
		'type' => 'multicheck',
		'std' => array(
			'thumbnail'		=> '1',
			'author'		=> '1',
			'published'		=> '1',
			'categories'	=> '1',
			'comment_info'	=> '1',
			'continue_btn'	=> '1',
			'updated'		=> '0',
			'tags'			=> '0'),
		'options' => array(
			'thumbnail'		=> __('Thumbnail (Only on Excerpts)', 'frontier'),
			'author'		=> __('Byline Author', 'frontier'),
			'published'		=> __('Byline Date Published', 'frontier'),
			'categories'	=> __('Byline Categories', 'frontier'),
			'comment_info'	=> __('Byline Comment Info', 'frontier'),
			'continue_btn'	=> __('Read Post Button (Only on Excerpts)', 'frontier'),
			'updated'		=> __('Date Updated', 'frontier'),
			'tags'			=> __('Tags', 'frontier'))
		);

	$options[] = array(
		'name' => __('Thumbnail Size', 'frontier'),
		'desc' => __('Note: If you choose the 200 &times; 120 size you may need to regenerate thumbnails to get the exact image size. Use "Regenerate Thumbnail" plugins.', 'frontier'),
		'id' => 'excerpt_thumbnail',
		'type' => 'radio',
		'std' => '150',
		'options' => array(
			'150'	=> __('150 &times; 150 &ndash; Default', 'frontier'),
			'200' 	=> __('200 &times; 120 &ndash; Horizontal', 'frontier'))
		);

/*-------------------------------------
	Single
--------------------------------------*/
	$options[] = array('name' => __('Single View', 'frontier'), 'type' => 'heading');

	$options[] = array(
		'name' => __('Post Elements', 'frontier'),
		'id' => 'post_elements',
		'type' => 'multicheck',
		'std' => array(
			'author'		=> '1',
			'published'		=> '1',
			'categories'	=> '1',
			'comment_info'	=> '1',
			'updated'		=> '1',
			'tags'			=> '1',
			'author_box'	=> '0',
			'post_nav'		=> '1',
			'comments'		=> '1'),
		'options' => array(
			'author'		=> __('Byline Author', 'frontier'),		
			'published'		=> __('Byline Date Published', 'frontier'),
			'categories'	=> __('Byline Categories', 'frontier'),
			'comment_info'	=> __('Byline Comment Info', 'frontier'),
			'updated'		=> __('Show Date Updated', 'frontier'),
			'tags'			=> __('Show Tags', 'frontier'),
			'author_box'	=> __('Show Author Box', 'frontier'),
			'post_nav'		=> __('Show Post Navigation', 'frontier'),
			'comments'		=> __('Enable Comments', 'frontier'))
		);

	$options[] = array(
		'name' => __('Page Elements', 'frontier'),
		'id' => 'page_elements',
		'type' => 'multicheck',
		'std' => array(
			'author'		=> '0',
			'published'		=> '0',
			'comment_info'	=> '0',
			'updated'		=> '0',
			'author_box'	=> '0',
			'comments'		=> '1'),
		'options' => array(
			'author'		=> __('Byline Author', 'frontier'),
			'published'		=> __('Byline Date Published', 'frontier'),
			'comment_info'	=> __('Byline Comment Info', 'frontier'),
			'updated'		=> __('Show Date Updated', 'frontier'),
			'author_box'	=> __('Show Author Box', 'frontier'),
			'comments'		=> __('Enable Comments', 'frontier'))
		);

/*-------------------------------------
	Widget Areas
--------------------------------------*/
	$options[] = array('name' => __('Widgets', 'frontier'), 'type' => 'heading');

	$options[] = array(
		'name' => __('Widget Areas', 'frontier'),
		'id' => 'widget_areas',
		'type' => 'multicheck',
		'std' => array(
			'body'					=> '0',
			'header'				=> '1',
			'below_menu'			=> '0',
			'before_content'		=> '0',
			'after_content'			=> '0',
			'footer'				=> '1',
			'post_header'			=> '1',
			'post_before_content'	=> '1',
			'post_after_content'	=> '1',
			'post_footer'			=> '1'),
		'options' => array(
			'body'					=> __('Body', 'frontier'),
			'header'				=> __('Header', 'frontier'),
			'below_menu'			=> __('Below Menu', 'frontier'),
			'before_content'		=> __('Before Content', 'frontier'),
			'after_content'			=> __('After Content', 'frontier'),
			'footer'				=> __('Footer', 'frontier'),
			'post_header'			=> __('Post - Header', 'frontier'),
			'post_before_content'	=> __('Post - Before Content', 'frontier'),
			'post_after_content'	=> __('Post - After Content', 'frontier'),
			'post_footer'			=> __('Post - Footer', 'frontier'))
		);

	$options[] = array(
		'name' => __('Footer Widget Columns', 'frontier'),
		'desc' => __('Choose how many footer widgets per row to display. Footer must be enabled on Widget Areas option.', 'frontier'),
		'id' => 'footer_widget_columns',
		'type' => 'radio',
		'std' => '3',
		'options' => array(
			'1'	=> __('1 Column', 'frontier'),
			'2' => __('2 Columns', 'frontier'),
			'3' => __('3 Columns', 'frontier'),
			'4' => __('4 Columns', 'frontier'),
			'5' => __('5 Columns', 'frontier'),
			'6' => __('6 Columns', 'frontier'))
		);

/*-------------------------------------
	Colors
--------------------------------------*/
	$options[] = array('name' => __('Colors', 'frontier'), 'type' => 'heading');

	$options[] = array(
		'name' => __('Custom Colors', 'frontier'),
		'desc' => __('Check box to enable the color options below. Other elements not included here can be changed through the Custom CSS option. Background color for the body area can be set here: <a href=\"?page=custom-background\">Body Background</a>', 'frontier'),
		'id' => 'colors_enable',
		'type' => 'checkbox',
		'std' => '0');

	$options[] = array(
		'name' => __('Primary Color', 'frontier'),
		'desc' => __('This is the main accent color. This sets the colors for widget title background, top borders, genericons, reply buttons and various elements.', 'frontier'),
		'id' => 'color_motif',
		'type' => 'color',
		'std' => '#2A5A8E');

	$options[] = array(
		'name' => __('', 'frontier'),
		'desc' => __('<strong>Top Bar</strong>', 'frontier'),
		'id' => 'color_top_bar',
		'type' => 'color',
		'std' => '#222222');

	$options[] = array(
		'desc' => __('<strong>Header</strong>', 'frontier'),
		'id' => 'color_header',
		'type' => 'color',
		'std' => '#FFFFFF');

	$options[] = array(
		'desc' => __('<strong>Main Menu</strong>', 'frontier'),
		'id' => 'color_menu_main',
		'type' => 'color',
		'std' => '#2A5A8E');

	$options[] = array(
		'desc' => __('<strong>Bottom Bar</strong>', 'frontier'),
		'id' => 'color_bottom_bar',
		'type' => 'color',
		'std' => '#222222');

	$options[] = array(
		'name' => __('', 'frontier'),
		'desc' => __('<strong>Link Color</strong>', 'frontier'),
		'id' => 'color_links',
		'type' => 'color',
		'std' => '#0E4D7A');

	$options[] = array(
		'desc' => __('<strong>Link Hover Color</strong>', 'frontier'),
		'id' => 'color_links_hover',
		'type' => 'color',
		'std' => '#0000EE');

/*-------------------------------------
	Slider
--------------------------------------*/
	$options[] = array('name' => __('Slider', 'frontier'), 'type' => 'heading');

	$options[] = array(
		'name' => __('Enable Slider', 'frontier'),
		'desc' => __('Activate slider. The slider is shown on the Front Page and Posts Page.', 'frontier'),
		'id' => 'slider_enable',
		'type' => 'checkbox',
		'std' => '0');

	if ( $options_categories ) {
		$options[] = array(
			'name' => __('Slider Categories', 'frontier'),
			'desc' => __('Select the categories to show on slider. You can select or deselect items by holding down the CTRL key while clicking. Creating a category specifically for use on the slider may be ideal.', 'frontier'),
			'id' => 'slider_categories',
			'type' => 'multiselect',
			'options' => $options_categories); 
	}

	$options[] = array(
		'name' => __('Post Count', 'frontier'),
		'desc' => __('How many posts should the slider show. Starts with the most recent post.', 'frontier'),
		'id' => 'slider_post_count',
		'type' => 'text',
		'std' => '6',
		'class' => 'mini');

	$options[] = array(
		'name' => __('Slide Duration', 'frontier'),
		'desc' => __('How many milliseconds before switching to the next slide.', 'frontier'),
		'id' => 'slider_pause_time',
		'type' => 'text',
		'std' => '5000',
		'class' => 'mini');
		
	$options[] = array(
		'name' => __('Animation Speed', 'frontier'),
		'desc' => __('How many milliseconds should the slide transition take.', 'frontier'),
		'id' => 'slider_slide_speed',
		'type' => 'text',
		'std' => '500',
		'class' => 'mini');

	$options[] = array(
		'name' => __('Slider Position', 'frontier'),
		'desc' => __('Select where to position the slider. The slider expands to full width when positioned below the menu and is normal size when positioned before the content.', 'frontier'),
		'id' => 'slider_position',
		'type' => 'radio',
		'std' => 'before_content',
		'options' => array(
			'before_main' 	 => __('Below Menu', 'frontier'),
			'before_content' => __('Before Content', 'frontier'))
		);

	$options[] = array(
		'name' => __('Slider Height', 'frontier'),
		'id' => 'slider_height',
		'type' => 'text',
		'std' => '340',
		'class' => 'mini px-after');

	$options[] = array(
		'name' => __('Slider Elements', 'frontier'),
		'id' => 'slider_elements',
		'type' => 'multicheck',
		'std' => array(
			'title'	=> '1',
			'text'	=> '1'),
		'options' => array(			
			'title'	=> __('Show Post Title', 'frontier'),
			'text'	=> __('Show Post Text', 'frontier'))
		);

	$options[] = array(
		'name' => __('Slider Image Style', 'frontier'),
		'id' => 'slider_stretch',
		'type' => 'radio',
		'std' => 'stretch',
		'options' => array(
			'stretch'	=> __('Stretch Image to fit Slider.', 'frontier'),
			'no_stretch'=> __('Don\'t Stretch. Center the Image.', 'frontier'))
		);

	$options[] = array(
		'name' => __('Default Slider Image', 'frontier'),
		'desc' => __('Choose the default image shown on the slider. This image will only be used if a Featured Image is not available on the post.', 'frontier'),
		'id' => 'slider_default_image',
		'type' => 'upload',
		'std' => $sliderimage);

/*-------------------------------------
	CSS
--------------------------------------*/
	$options[] = array('name' => __('Custom CSS', 'frontier'), 'type' => 'heading');
	
	$options[] = array(
		'name' => __('CSS', 'frontier'),
		'id' => 'custom_css',
		'type' => 'textarea',
		'class'	=> 'css');

/*-------------------------------------
	Misc
--------------------------------------*/
	$options[] = array('name' => __('Misc', 'frontier'), 'type' => 'heading');

	$options[] = array(
		'name' => __('Custom &lt;Head&gt; Codes', 'frontier'),
		'id' => 'head_codes',
		'type' => 'textarea',
		'class' => 'code');

	$options[] = array(
		'name' => __('Disable Responsive Layout', 'frontier'),
		'desc' => __('Check if you do not want the layout to resize and adapt to the screen size.', 'frontier'),
		'id' => 'responsive_disable',
		'type' => 'checkbox',
		'std' => '0');

	$options[] = array(
		'name' => __('Disable Editor Style', 'frontier'),
		'desc' => __('Remove any custom styles applied to the post visual editor (e.g. Post Editor Width)', 'frontier'),
		'id' => 'editor_style_disable',
		'type' => 'checkbox',
		'std' => '0');

	$options[] = array(
		'name' => __('Remove Theme URL', 'frontier'),
		'desc' => __('Remove theme credit on bottom bar. Please consider either keeping the link or donating to show support.', 'frontier'),
		'id' => 'theme_link_disable',
		'type' => 'checkbox',
		'std' => '0');

	return $options;
}

add_filter( 'optionsframework_multiselect', 'multiselect_type', 10, 3 );		
add_filter( 'optionsframework_slider_ui_width_container', 'slider_ui_width_container_type', 10, 3 );
add_filter( 'optionsframework_slider_ui_width_2col', 'slider_ui_width_2col_type', 10, 3 );
add_filter( 'optionsframework_slider_ui_width_3col', 'slider_ui_width_3col_type', 10, 3 );

add_filter( 'of_sanitize_multiselect', 'of_sanitize_multiselect', 10, 2 );
add_filter( 'of_sanitize_slider_ui_width_container', 'sanitize_text_field' );
add_filter( 'of_sanitize_slider_ui_width_2col', 'sanitize_text_field' );
add_filter( 'of_sanitize_slider_ui_width_3col', 'sanitize_text_field' );


function multiselect_type( $option_name, $value, $val ) {
	$output = '<select multiple="multiple" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '[]" id="' . esc_attr( $value['id'] ) . '">';
	foreach ($value['options'] as $key => $option) {
		$selected = '';
		$label = $option;
		$option = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($key));
		$id = $option_name . '-' . $value['id'] . '-'. $option;
		$name = $option_name . '[' . $value['id'] . '][' . $option .']';

		if ( isset($val) && is_array($val) ) {
			if( array_key_exists( $key, $val)) {
				if($val[$key]) $selected = ' selected="selected" ';
			}
		}
		$output .= '<option'. $selected .' value="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</option>';
	}
	$output .= '</select>';
	return $output;
}

function of_sanitize_multiselect( $input, $option ) {
	$output = '';
	if ( is_array( $input ) ) {
		foreach( $option['options'] as $key => $value ) {
			$output[$key] = '0';
			foreach( $input as $selected_val ) {
				if($key == $selected_val) $output[$key] = '1';
			}
		}
	}
	return $output;
}

function slider_ui_width_container_type( $option_name, $value, $val ) {
	$output = '<input style="display: none;" id="' . esc_attr( $value['id'] ) . '" class="slider-ui-text" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
	$output .= '<p><label class="slider-ui-label">Container</label><input id="width_container_text" class="slider-ui-text" type="text" disabled="disabled" /></p>';
	$output .= '<div id="width_container_slider"></div>';
    return $output;
}

function slider_ui_width_2col_type( $option_name, $value, $val ) {
	$output = '<input style="display: none;" id="' . esc_attr( $value['id'] ) . '" class="slider-ui-text" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
	$output .= '<p><label class="slider-ui-label">Content</label><input id="width_two_column_text" class="slider-ui-text" type="text" disabled="disabled" /></p>';
	$output .= '<p><label class="slider-ui-label">Sidebar</label><input id="width_two_column_sidebar_text" class="slider-ui-text" type="text" disabled="disabled" /></p>';
	$output .= '<div id="width_two_column_slider"></div>';	
    return $output;
}

function slider_ui_width_3col_type( $option_name, $value, $val ) {
	$output = '<input style="display: none;" id="' . esc_attr( $value['id'] ) . '" class="slider-ui-text" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '">';
	$output .= '<p><label class="slider-ui-label">Content</label><input id="width_three_column_text" class="slider-ui-text" type="text" disabled="disabled" /></p>';
	$output .= '<p><label class="slider-ui-label">Sidebar 1</label><input id="width_three_column_sidebar1_text" class="slider-ui-text" type="text" disabled="disabled" /></p>';
	$output .= '<p><label class="slider-ui-label">Sidebar 2</label><input id="width_three_column_sidebar2_text" class="slider-ui-text" type="text" disabled="disabled" /></p>';
	$output .= '<div id="width_three_column_slider"></div>';
    return $output;
}


function frontier_slider_ui_js() {
?>
<script>
jQuery(function($) {
	$( "#width_container_slider" ).slider({
		range: "min",
		value: <?php echo frontier_option('width_container', '960'); ?>,
		min: 500,
		max: 1400,
		slide: function( event, ui ) {
			$( "#width_container" ).val( ui.value );
			$( "#width_container_text" ).val( ui.value + "px");
		}
	});
	$( "#width_container_text" ).val( $( "#width_container_slider" ).slider( "value" ) + "px" );
});

jQuery(function($) {
	$( "#width_two_column_slider" ).slider({
		range: "min",
		value: <?php echo frontier_option('width_two_column', '65'); ?>,
		min: 1,
		max: 100,
		slide: function( event, ui ) {
			$( "#width_two_column" ).val( ui.value );
			$( "#width_two_column_text" ).val( ui.value + "%" );
			$( "#width_two_column_sidebar_text" ).val( 100 - ui.value + "%" );
		}
	});
	$( "#width_two_column_text" ).val( $( "#width_two_column_slider" ).slider( "value" ) + "%" );
	$( "#width_two_column_sidebar_text" ).val( 100 - $( "#width_two_column_slider" ).slider( "value" ) + "%" );
});

jQuery(function($) {
	<?php $width_value = explode( '-', frontier_option('width_three_column', '25-75') ); ?>
	$( "#width_three_column_slider" ).slider({
		range: true,
		min: 1,
		max: 100,
		values: [ <?php echo $width_value[0]; ?>, <?php echo $width_value[1]; ?> ],
		slide: function( event, ui ) {
			$( "#width_three_column" ).val( "" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
			$( "#width_three_column_text" ).val( ui.values[ 1 ] - ui.values[ 0 ] + "%" );
			$( "#width_three_column_sidebar1_text" ).val( ui.values[ 0 ] + "%" );
			$( "#width_three_column_sidebar2_text" ).val( 100 - ui.values[ 1 ] + "%" );
		}
	});
	$( "#width_three_column_text" ).val( $( "#width_three_column_slider" ).slider( "values", 1 ) - $( "#width_three_column_slider" ).slider( "values", 0 ) + "%" );
	$( "#width_three_column_sidebar1_text" ).val( $( "#width_three_column_slider" ).slider( "values", 0 ) + "%" );
	$( "#width_three_column_sidebar2_text" ).val( 100 - $( "#width_three_column_slider" ).slider( "values", 1 ) + "%" );
});
</script>
<?php
}
add_action( 'optionsframework_custom_scripts', 'frontier_slider_ui_js' );


function customize_sanitization() {
	remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
	add_filter( 'of_sanitize_textarea', 'of_sanitize_textarea_custom' );
}
add_action( 'admin_init', 'customize_sanitization', 100 );


function of_sanitize_textarea_custom( $input ) {	
    global $allowedposttags;
	$custom_allowedtags["script"] = array("type" => array());
	$custom_allowedtags["meta"] = array("property" => array(), "name" => array(), "content" => array());
	$custom_allowedtags["link"] = array("id" => array(), "media" => array(), "type" => array(), "href" => array(), "rel" => array(), "property" => array(), "content" => array());

	$custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);

	$output = wp_kses( $input, $custom_allowedtags );
	$output = htmlspecialchars_decode( $output );
    return $output;
}


function frontier_options_page_sidebar() {
?>
<div class="metabox-holder of-sidebar">
	<div id="donate" class="postbox">
		<h3>Support the Developer</h3>
		<div class="inside">
			<p>If you liked this theme, please consider donating a small amount.</p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="U92LEYCWW973S">
			<input type="hidden" name="lc" value="PH">
			<input type="hidden" name="item_name" value="Frontier Theme">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
	</div>

	<div id="theme-info" class="postbox">
		<h3>About Frontier Theme</h3>
		<div class="inside">
			<div>&#9679;&nbsp;&nbsp;<a href="<?php echo esc_url( 'http://ronangelo.com/frontier/' ); ?>" target="_blank">Frontier Theme Page</a></div>
			<div>&#9679;&nbsp;&nbsp;<a href="<?php echo esc_url( 'http://ronangelo.com/frontier/theme-documentation/' ); ?>" target="_blank">Frontier Documentation</a></div>
			<div>&#9679;&nbsp;&nbsp;<a href="<?php echo esc_url( 'http://ronangelo.com/frontier/theme-changelog/' ); ?>" target="_blank">Frontier Changelog</a></div>
			<p>Have any questions or suggestions? Post them here on the theme's <a href="<?php echo esc_url( 'http://ronangelo.com/theme-forum/' ); ?>" target="_blank">support forum</a> or on <a href="<?php echo esc_url( 'http://wordpress.org/support/theme/frontier/' ); ?>" target="_blank">wordpress.org</a></p>
			<p>Note: Check the theme changelog page linked above before updating to a newer version of the theme.</p>
		</div>
	</div>
</div>
<?php
}
add_action( 'optionsframework_after', 'frontier_options_page_sidebar', 100 );