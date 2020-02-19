<?php

/***
 * WordPress Defaults Seetings
 */

//Add thumbnail, automatic feed links and title tag support
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'custom-logo' );


// Add uk-logo class to Custom Logo in Appearance Panel
add_filter( 'get_custom_logo', 'change_logo_class' );

function change_logo_class( $html ) {
    $html = str_replace( 'custom-logo-link', 'uk-logo', $html );
    return $html;
}


// Create Main Menu by default
if ( function_exists( 'register_nav_menus' ) ) {
  	register_nav_menus(
  		array(
  		  'main_menu' => 'Main Menu'
  		)
  	);
}

// Change excerpt string
function custom_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );


/***
 * Hide Default Posts & Comments
 */

function remove_menus() {
	remove_menu_page( 'edit.php' ); //Posts
	remove_menu_page( 'edit-comments.php' ); //Posts
}
add_action( 'admin_menu', 'remove_menus' );



/***
 * Admin Stylesheet
 */

function admin_style() {
	wp_enqueue_style('admin-styles', get_template_directory_uri().'/assets/css/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

/***
 * Navbar_Menu_Walker Setup
 */

add_action( 'after_setup_theme', 'navbar_setup' );

if ( ! function_exists( 'navbar_setup' ) ):

	function navbar_setup(){

		add_action( 'init', 'register_menu' );

		function register_menu(){
			register_nav_menu( 'top-bar', 'Bootstrap Top Menu' ); 
		}

		class Navbar_Menu_Walker extends Walker_Nav_Menu {


			function start_lvl( &$output, $depth = 0, $args = array() ) {

        $indent = str_repeat( "\t", $depth );
        // Render prior to dropdown list
				$output	   .= "\n$indent<div class='uk-navbar-dropdown' uk-dropdown='animation: uk-animation-slide-top-small'><ul class=\"uk-nav uk-navbar-dropdown-nav\">\n";

			}

			function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

				if (!is_object($args)) {
					return; // menu has not been configured
				}

				$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

				$li_attributes = '';
				$class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        // Classes for link within an li with children
				$classes[] = ($args->has_children) ? 'dropdown-submenu' : '';
				$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
				$classes[] = 'menu-item-' . $item->ID;

				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
				$class_names = ' class="' . esc_attr( $class_names ) . '"';

				$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
				$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

				$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '  tabindex="-1">';

				$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
				$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
				$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
				$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        // Classes for li element containing a link with children
        $attributes .= ($args->has_children) 	    ? ' class="uk-nav uk-navbar-dropdown-nav"'  : '';

				$item_output = $args->before;
				$item_output .= '<a'. $attributes .'>';
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				$item_output .= ($args->has_children) ? '</a>' : '</a>';
				$item_output .= $args->after;

				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}

			function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

				if ( !$element )
					return;

				$id_field = $this->db_fields['id'];

				//display this element
				if ( is_array( $args[0] ) )
					$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
				else if ( is_object( $args[0] ) )
					$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
				$cb_args = array_merge( array(&$output, $element, $depth), $args);
				call_user_func_array(array(&$this, 'start_el'), $cb_args);

				$id = $element->$id_field;

				// descend only when the depth is right and there are childrens for this element
				if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

					foreach( $children_elements[ $id ] as $child ){

						if ( !isset($newlevel) ) {
							$newlevel = true;
							//start the child delimiter
							$cb_args = array_merge( array(&$output, $depth), $args);
							call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
						}
						$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
					}
						unset( $children_elements[ $id ] );
				}

				if ( isset($newlevel) && $newlevel ){
					//end the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
				}

				//end this element
				$cb_args = array_merge( array(&$output, $element, $depth), $args);
				call_user_func_array(array(&$this, 'end_el'), $cb_args);
			}
		}
 	}
endif;


/*------------------------------------*\
	Load Scripts and Stylesheets
\*------------------------------------*/


function wpdocs_theme_name_scripts() {
	// Fonts
	wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed&display=swap' ); // Roboto & Roboto Condensed

	// Stylesheets
	wp_enqueue_style( 'reset', get_template_directory_uri() . '/assets/css/reset.css' ); // Reset Stylesheet
	wp_enqueue_style( 'uikit.min', get_template_directory_uri() . '/assets/css/uikit/uikit.min.css' ); // UI Kit Framework
	wp_enqueue_style( 'font-awesome.min', get_template_directory_uri() . '/assets/css/font-awesome.min.css' ); // Font Awesome Icons
	wp_enqueue_style( 'style', get_stylesheet_uri() ); // Custom Styles
	
	// Scripts
    wp_enqueue_script( 'jquery.min', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), '1.0.0', true ); // jQuery
    wp_enqueue_script( 'uikit.min', get_template_directory_uri() . '/assets/js/uikit/uikit.min.js', array(), '1.0.0', true ); // UI Kit Framework
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/assets/js/custom.js', array(), '1.0.0', true ); // Custom Scripts
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );


/*------------------------------------*\
	Custom Widgets
\*------------------------------------*/


/**
 * Widgets
 */

// Custom Widgets Function
function create_sidebar($name, $id, $description = ""){
	if ( function_exists('register_sidebar') ){
		add_action('widgets_init', function() use ($name, $id, $description) {
			register_sidebar(array(
				'id' => $id,
				'name' => $name,
				'description' => $description,
				'before_widget' => '<div id="widget-' . $id . '" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4>',
				'after_title' => '</h4>',
			));
		}, 0);
	}
}

// Widget
create_sidebar("Affiliations", "affiliations", "");
create_sidebar("Footer", "footer", "");



/*------------------------------------*\
	Custom Posts
\*------------------------------------*/

// Custom Post Type Function
function create_post_type($plural, $singular, $slug = "", $dashicon = "menu", $in_rest = false, $featured_text = "Featured Image"){

	// Create new post type using add_action with the arguements passed
	add_action( 'init', function() use ($plural, $singular, $slug, $dashicon, $taxonomy, $in_rest, $featured_text){
		$new_post = array(
			'name' => _x($plural, "post type general name"),
			'singular_name' => _x($singular, "post type singular name"),
			'menu_name' => $plural,
			'add_new' => _x("Add New", $singular),
			'add_new_item' => __("Add New " . $singular),
			'edit_item' => __("Edit " . $singular),
			'new_item' => __("New " . $singular),
			'view_item' => __("View "),
			'search_items' => __("Search " . $plural),
			'not_found' =>  __("No " . $plural . " Found"),
			'not_found_in_trash' => __("No " . $plural . " Found in Trash"),
			'parent_item_colon' => '',
			'featured_image'    => __( $featured_text, 'textdomain'),
			'set_featured_image' => __( "Set " . $featured_text, 'textdomain'),
			'remove_featured_image' => __( "Remove " . $featured_text, 'textdomain'),
			'use_featured_image' => __( "Use as " . $featured_text, 'textdomain')
		);
		
		// Register post type
		register_post_type($plural , array(
			'labels' => $new_post,
			'public' => true,
			'has_archive' => false,
			'rewrite' => array(
					'slug' => $slug,
					'with_front' => false
				),
			'show_in_rest' => $in_rest,
			'supports' => array('title', 'editor', 'thumbnail','excerpt'),
			'exclude_from_search' => 'true',
			'menu_icon' => 'dashicons-' . $dashicon,
			'taxonomies'  => array( 'category', 'product-type' ), // Add categories
			'hierarchical' => false
		) );
	}, 0 );
}

// Custom Post Types
// create_post_type("Plural", "Singular", "Optional Slug", "Dashicon", "In Rest");
create_post_type("Products", "Product", "products", "cart", true);




// Create project taxonomy
add_action( 'init', 'product_taxonomy', 0 );
 
//create a project taxonomy name it "type" for your posts
function product_taxonomy() {
 
  $labels = array(
    'name' => _x( 'Product Type', 'taxonomy general name' ),
    'singular_name' => _x( 'Product Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Types' ),
    'all_items' => __( 'All Types' ),
    'parent_item' => __( 'Parent Type' ),
    'parent_item_colon' => __( 'Parent Type:' ),
    'edit_item' => __( 'Edit Type' ), 
    'update_item' => __( 'Update Type' ),
    'add_new_item' => __( 'Add New Type' ),
    'new_item_name' => __( 'New Type Name' ),
    'menu_name' => __( 'Product Types' ),
  ); 	
 
  register_taxonomy('product-type',array('products'), array(
    'hierarchical' => true,
    'labels' => $labels,
	'show_ui' => true,
	'show_in_rest' => true,
	'publicly_queryable'  => false,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'products-category' ),
  ));
}

// Rename Category Taxonomy

function change_cat_tax() {
    global $wp_taxonomies;
    $labels = &$wp_taxonomies['category']->labels;
    $labels->name = 'Brands';
    $labels->singular_name = 'Brand';
    $labels->add_new = 'Add Brand';
    $labels->add_new_item = 'Add Brand';
    $labels->edit_item = 'Edit Brand';
    $labels->new_item = 'Brand';
    $labels->view_item = 'View Brand';
    $labels->search_items = 'Search Brand';
    $labels->not_found = 'No Brands found';
    $labels->not_found_in_trash = 'No Brands found in Trash';
    $labels->all_items = 'All Brands';
    $labels->menu_name = 'Brand';
    $labels->name_admin_bar = 'Brand';
}
add_action( 'init', 'change_cat_tax' );




/*------------------------------------*\
	Custom Settings
\*------------------------------------*/


// Media Uploader
add_action('admin_footer', function() { ?>

    <script>
		jQuery(document).ready(function($){
		var custom_uploader;
		$('#upload_image_button').click(function(e) {
			const target = "#" + this.getAttribute("data-target"); // Select image preview element
			e.preventDefault();
			//If the uploader object has already been created, reopen the dialog
			if (custom_uploader) {
				custom_uploader.open();
				return;
			}
			//Extend the wp.media object
			custom_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				},
				multiple: false
			});
			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader.on('select', function() {
				attachment = custom_uploader.state().get('selection').first().toJSON();
				$('#upload_image').val(attachment.url); // Update input
				$(target).attr("src",attachment.url); // Update preview section
			});
			//Open the uploader dialog
			custom_uploader.open();
			});
		});
    </script>
<?php
});

add_action('admin_enqueue_scripts', function(){
	wp_enqueue_media();
});



/**
 * Register "Contact Section" settings
 */

function display_phone() { ?>
	<input type="text" name="phone" id="phone" value="<?php echo get_option('phone'); ?>" style="min-width: 378px" />
<?php }

function display_fax() { ?>
	<input type="text" name="fax" id="fax" value="<?php echo get_option('fax'); ?>" style="min-width: 378px" />
<?php }

function display_google_maps() { ?>
	<input type="text" name="google_maps" id="google_maps" value="<?php echo get_option('google_maps'); ?>" style="min-width: 378px" />
<?php }


function display_address() {
	$settings = array(
		'tinymce' => false,
		'media_buttons' => false,
		'editor_height' => '200px'
	);

	echo "<div style='width:378px;'>";
	echo wp_editor( get_option( 'address' ), 'address', $settings );
	echo "</div>";
}

function display_contact_section() {
	$settings = array(
		'editor_height' => '200px'
	);d

	echo "<div style='width:378px;'>";
	echo wp_editor( get_option( 'contact_section' ), 'contact_section', $settings );
	echo "</div>";
}

function display_image() { // Media Selector Fields & Input ?>
	<!-- Preview -->
	<div style="display:table; margin-bottom: 10px;">
		<div style="display: table-cell; vertical-align: middle; width: 90px; height: 90px; border: 1px solid #7e8993; text-align: center; padding: 5px; border-radius: 3px;">
			<img src="<?php echo get_option('contact_image'); ?>" id="upload_image_preview" style="max-width:100%; max-height:100%">
		</div>
	</div>
	
	<!-- Hidden Input -->
	<input id="upload_image" type="hidden" name="contact_image" value=<?php echo get_option('contact_image'); ?> /> 
	
	<!-- Media Button. data-target attribute links to preview section id -->
	<input id="upload_image_button" class="button" type="button" data-target="upload_image_preview" value="Select Image" />
<?php }

function display_single_product_info() {
	$settings = array(
		'editor_height' => '200px'
	); // Hide all the editor buttons

	echo "<div style='width:378px;'>";
	echo wp_editor( get_option( 'single_product' ), 'single_product', $settings );
	echo "</div>";
}

// Create display using inputs then registering them.
function display_theme_panel_fields()
{
	// Combine ID with Group ID. Second arg is a heading for the settings.
	add_settings_section("contact_info", "", null, "contact_info");
	
	// Create display with inputs
	add_settings_field("address", "Address", "display_address", "contact_info", "contact_info");
	add_settings_field("google_maps", "Google Maps URL", "display_google_maps", "contact_info", "contact_info");
	add_settings_field("phone", "Phone Number", "display_phone", "contact_info", "contact_info");
	add_settings_field("fax", "Fax Number", "display_fax", "contact_info", "contact_info");



	add_settings_section("contact_info", "", null, "contact_info");
	add_settings_section("contact_section", "", null, "contact_section");
	add_settings_section("single_product", "", null, "single_product");
	add_settings_field("contact_image", "Image", "display_image", "contact_section", "contact_section");
	add_settings_field("contact_section", "Contact Section", "display_contact_section", "contact_section", "contact_section");
	add_settings_field("single_product", "Single Product", "display_single_product_info", "single_product", "single_product");

	// Register inputs
	register_setting("contact_section", "contact_image");
	register_setting("contact_section", "contact_section");
	register_setting("single_product", "single_product");
	register_setting("contact_info", "address");
	register_setting("contact_info", "google_maps");
	register_setting("contact_info", "phone");
	register_setting("contact_info", "fax");
}

// Add action
add_action("admin_init", "display_theme_panel_fields");



// Create page structure for menu calling section using ID and Group ID (section & contact-inputs). Then create submit button.
function theme_settings_page(){
		if( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else {
			$active_tab = "contact_info";
		} // end if
        ?>
	    <div class="wrap">
		<h1>Editable Sections</h1>
		<h2 class="nav-tab-wrapper" style="width:566px; border-bottom: 0">
			<a href="?page=contact-information&tab=contact_info" class="nav-tab <?php echo $active_tab == 'contact_info' ? 'nav-tab-active' : ''; ?>" style="margin-left: 0">Contact Info</a>
			<a href="?page=contact-information&tab=contact_section" class="nav-tab <?php echo $active_tab == 'contact_section' ? 'nav-tab-active' : ''; ?>">Contact Section</a>
			<a href="?page=contact-information&tab=single_product" class="nav-tab <?php echo $active_tab == 'single_product' ? 'nav-tab-active' : ''; ?>">Single Product</a>
		</h2>
	    <form method="post" action="options.php">
			<div class="acf-box" style="display: inline-block; padding: 13px; width:540px">
				<?php
				if( $active_tab == 'contact_section' ) { ?>
					<?php settings_fields( 'contact_section' ); ?>
					<p>Copy used on the contact section found above the footer.</p>
					<?php do_settings_sections("contact_section"); ?>
				<?php } else if ( $active_tab == 'single_product') { ?>
					<p>General contact information used throughout the site.</p>
					<?php settings_fields( 'single_product' ); ?>
					<?php do_settings_sections("single_product"); ?>
				<?php } else { ?>
					<p>General contact information used throughout the site.</p>
					<?php settings_fields( 'contact_info' ); ?>
					<?php do_settings_sections("contact_info"); ?>
				<?php } // end if/else // end if/else
				?>


				
			</div> 
			<?php submit_button(); ?>          
	    </form>
		</div>
	<?php
}

// Create settings in WP Control Panel
function add_theme_menu_item() {
	add_menu_page("Editable Sections", "Editable Sections", "manage_options", "contact-information", "theme_settings_page", "dashicons-layout" ,null, 99);
}

// Add action
add_action("admin_menu", "add_theme_menu_item");


/**
 * Register "Social Media" settings
 */


// Create first input (heading)
function display_facebook() { ?>
	<input type="url" name="facebook" id="facebook" value="<?php echo get_option('facebook'); ?>" style="min-width: 378px" />
<?php }

// Create second input (copy)
function display_instagram() { ?>
	<input type="url" name="instagram" id="instagram" value="<?php echo get_option('instagram'); ?>" style="min-width: 378px" />
<?php }

// Create third input (form)
function display_twitter() { ?>
	<input type="url" name="twitter" id="twitter" value="<?php echo get_option('twitter'); ?>" style="min-width: 378px" />
<?php }

function display_linkedin() { ?>
	<input type="url" name="linkedin" id="linkedin" value="<?php echo get_option('linkedin'); ?>" style="min-width: 378px" />
<?php }

function display_youtube() { ?>
	<input type="url" name="youtube" id="youtube" value="<?php echo get_option('youtube'); ?>" style="min-width: 378px" />
<?php }

// Create display using inputs then registering them.
function display_social_fields()
{
	// Combine ID with Gropu ID. Second arg is a heading for the settings.
	add_settings_section("social", "All Settings", null, "social-media");
	
	// Create display with inputs
	add_settings_field("facebook", "Facebook", "display_facebook", "social-media", "social");
	add_settings_field("instagram", "Instagram", "display_instagram", "social-media", "social");
	add_settings_field("twitter", "Twitter", "display_twitter", "social-media", "social");
	add_settings_field("linkedin", "LinkedIn", "display_linkedin", "social-media", "social");
	add_settings_field("youtube", "Youtube", "display_youtube", "social-media", "social");

	// Register inputs
	register_setting("social", "facebook");
	register_setting("social", "instagram");
	register_setting("social", "twitter");
	register_setting("social", "linkedin");
	register_setting("social", "youtube");
}

// Add action
add_action("admin_init", "display_social_fields");

function social_settings_page(){
	?>
	    <div class="wrap">
	    <h1>Social Media Handles</h1>
	    <form method="post" action="options.php">
	        <?php
	            settings_fields("social");
	            do_settings_sections("social-media");      
	            submit_button(); 
	        ?>          
	    </form>
		</div>
	<?php
}

// Create settings in WP Control Panel
function add_social_menu() {
	add_menu_page("Social Media", "Social Media", "manage_options", "social-media", "social_settings_page", "dashicons-share" ,null, 99);
}

// Add action
add_action("admin_menu", "add_social_menu");


add_filter('post_type_link', 'productcategory_permalink_structure', 10, 4);
function productcategory_permalink_structure($post_link, $post, $leavename, $sample) {
    if (false !== strpos($post_link, '%servicecategory%')) {
        $productscategory_type_term = get_the_terms($post->ID, 'service type');
        if (!empty($productscategory_type_term))
            $post_link = str_replace('%servicecategory%', array_pop($productscategory_type_term)->
            slug, $post_link);
        else
            $post_link = str_replace('%servicecategory%', 'uncategorized', $post_link);
    }
    return $post_link;
}


/**
 * Display a custom taxonomy dropdown in admin
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_action('restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy');
function tsm_filter_post_type_by_taxonomy() {
	global $typenow;
	$post_type = 'products'; // change to your post type
	$taxonomy  = 'product-type'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => sprintf( __( 'Show all %s', 'textdomain' ), $info_taxonomy->label ),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		));
	};
}

/**
 * Filter posts by taxonomy in admin
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter('parse_query', 'tsm_convert_id_to_term_in_query');
function tsm_convert_id_to_term_in_query($query) {
	global $pagenow;
	$post_type = 'products'; // change to your post type
	$taxonomy  = 'product-type'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}



// Remove Yoast filter options in Control Panel (not needed)
add_action( 'admin_init', 'bb_remove_yoast_seo_admin_filters', 20 );
function bb_remove_yoast_seo_admin_filters() {
    global $wpseo_meta_columns ;
    if ( $wpseo_meta_columns  ) {
        remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown' ) );
        remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown_readability' ) );
    }
}



/*------------------------------------*\
	AJAX Filter Function
\*------------------------------------*/

add_action('wp_ajax_myfilter', 'misha_filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_myfilter', 'misha_filter_function');
 
function misha_filter_function(){
    $paged = ( $_POST['page'] ) ? $_POST['page'] : 1;
    $limit = ( $_POST['limit'] ) ? $_POST['limit'] : 3;

	$args = array(
		'orderby' => 'date', // we will sort posts by date
		'post_type' => 'products',
        'posts_per_page' => $limit,
		'paged' => $paged,
	);
 
	// for taxonomies / categories
	if( isset( $_POST['categoryfilter'] ) && $_POST['categoryfilter'] != "all" )
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $_POST['categoryfilter']
			)
		);
 
	$query = new WP_Query( $args );
 
	if( $query->have_posts() ) :
		echo '<div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-margin-medium-bottom uk-margin-medium-top"  uk-grid uk-scrollspy="cls: uk-animation-slide-right-small; target: > div; delay: 50; repeat: false">';
		while( $query->have_posts() ): $query->the_post(); ?>
			<div class="opacity0 products-single">
				<a href='<?php echo the_permalink(); ?>' class="products-container-link uk-width-1-1">
					<div>
						<figure class="uk-text-center"><div class="uk-padding-small"><?php the_post_thumbnail("thumb"); ?></div></figure>
						<h3 class="uk-text-bold uk-margin-remove"><?php the_title(); ?></h3>
					</div>
				</a>
			</div>
		<?php endwhile;
		wp_reset_postdata();
	else :
		echo 'No posts found';
	endif;

	echo "</div>";

		echo "<div id='pagination' class='pagination uk-text-center' data-action='" . site_url() .  "/wp-admin/admin-ajax.php'>";

		echo paginate_links( array(
			'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'total'        => $query->max_num_pages,
			'current'      => max( $paged, get_query_var( 'paged' ) ),
			'format'       => '?paged=%#%',
			'show_all'     => false,
			'type'         => 'plain',
			'end_size'     => 2,
			'mid_size'     => 1,
			'prev_next'    => false,
			'add_args'     => false,
			'add_fragment' => '',
		) );
		echo "</div>";
	die();
}


// Allow shortcodes in CF7 (for dynamic content)
add_filter( 'wpcf7_form_elements', 'mycustom_wpcf7_form_elements' );
	function mycustom_wpcf7_form_elements( $form ) {
	$form = do_shortcode( $form );

	return $form;
}



/**
 * crunchify - add thumbnail image row in custom post type page
 */

add_image_size( 'crunchify-admin-post-featured-image', 120, 120, false );
 
// Add the posts and pages columns filter. They can both use the same function.
add_filter('manage_posts_columns', 'crunchify_add_post_admin_thumbnail_column', 2);
add_filter('manage_pages_columns', 'crunchify_add_post_admin_thumbnail_column', 2);
 
// Add the column
function crunchify_add_post_admin_thumbnail_column($crunchify_columns){
	$crunchify_columns['crunchify_thumb'] = __('Featured Image');
	return $crunchify_columns;
}
 
// Let's manage Post and Page Admin Panel Columns
add_action('manage_posts_custom_column', 'crunchify_show_post_thumbnail_column', 5, 2);
add_action('manage_pages_custom_column', 'crunchify_show_post_thumbnail_column', 5, 2);
 
// Here we are grabbing featured-thumbnail size post thumbnail and displaying it
function crunchify_show_post_thumbnail_column($crunchify_columns, $crunchify_id){
	switch($crunchify_columns){
		case 'crunchify_thumb':
		if( function_exists('the_post_thumbnail') )
			echo the_post_thumbnail( 'crunchify-admin-post-featured-image' );
		else
			echo 'hmm... your theme doesn\'t support featured image...';
		break;
	}
}


?>