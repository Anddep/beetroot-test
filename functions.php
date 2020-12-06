<?php
define('THEME_VERSION', '1.21.97567');

if (!is_admin()) {

    function hotel_styles()
    {
        wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/dist/style.css', array(), THEME_VERSION);
        wp_enqueue_style('main', get_template_directory_uri() . '/style.css', array('custom-style'), THEME_VERSION);
    }
    add_action('wp_enqueue_scripts', 'hotel_styles');

    function wp_hotel_scripts()
    {
       wp_enqueue_script('font-awesome', 'https://use.fontawesome.com/d3fd47599b.js', array(),  true);
       wp_enqueue_script('main-scripts', get_template_directory_uri() . '/assets/dist/main.bundle.js', array('jquery'), THEME_VERSION, true);
    }
    add_action('wp_enqueue_scripts', 'wp_hotel_scripts');
}

if (!function_exists('hotel_head_meta_tags')) {
    function hotel_head_meta_tags()
    {
        echo '<meta name="keywords" content="'. get_bloginfo('keywords') .'"/>'.PHP_EOL;
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2, user-scalable=yes" />'.PHP_EOL;
		echo '<meta name="apple-mobile-web-app-capable" content="yes" />'.PHP_EOL;
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge" />'.PHP_EOL;

	}
    add_action('wp_head', 'hotel_head_meta_tags', 1);
}


//remove attr
function register_html_support() {
    add_theme_support( 'html5', array( 'script', 'style' ) );
}

//add custom post type
add_action('init', 'create_property');
function create_property()
{
    register_post_type('property',
        array(
            'labels' => array(
                'name' => __('Property', 'Hotel'),
                'singular_name' => __('Property', 'Hotel'),
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-store',
            'show_in_rest' => true,
            'show_in_nav_menus' => 'true',
            'rewrite' => array('slug' => 'property'),
            'supports' => array('title', 'editor','author', 'custom-fields', 'revisions', 'thumbnail'),
        )
    );
}

function add_author_support_to_posts() {
   add_post_type_support( 'property', 'author' );
}
add_action( 'init', 'add_author_support_to_posts' );

//custom tax
add_action( 'init', 'create_property_city' );
function create_property_city(){

	register_taxonomy('city', array('property'), array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'              => _x( 'City', 'taxonomy general name' ),
			'singular_name'     => _x( 'City', 'taxonomy singular name' ),
			'search_items'      => __( 'Search City' ),
			'all_items'         => __( 'All Cities' ),
			'parent_item'       => __( 'Parent Cities' ),
			'parent_item_colon' => __( 'Parent Cities:' ),
			'edit_item'         => __( 'Edit City' ),
			'update_item'       => __( 'Update City' ),
			'add_new_item'      => __( 'Add New City' ),
			'new_item_name'     => __( 'New City Name' ),
			'menu_name'         => __( 'City' ),
		),
		'show_in_rest' => true,
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'city' ),
	));
}

add_action( 'init', 'create_property_amenities' );
function create_property_amenities(){

	register_taxonomy('amenities', array('property'), array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'              => _x( 'Amenities', 'taxonomy general name' ),
			'singular_name'     => _x( 'Amenities', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Amenities' ),
			'all_items'         => __( 'All Amenities' ),
			'parent_item'       => __( 'Parent Amenities' ),
			'parent_item_colon' => __( 'Parent Amenities:' ),
			'edit_item'         => __( 'Edit Amenitie' ),
			'update_item'       => __( 'Update Amenitie' ),
			'add_new_item'      => __( 'Add New Amenities' ),
			'new_item_name'     => __( 'New Amenitie Name' ),
			'menu_name'         => __( 'Amenities' ),
		),
		'show_in_rest' => true,
		'show_in_rest' => true,
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'amenities' ),
	));
}

add_action( 'init', 'create_property_extras' );
function create_property_extras(){

	register_taxonomy('extras', array('property'), array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'              => _x( 'Extras', 'taxonomy general name' ),
			'singular_name'     => _x( 'Extras', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Extras' ),
			'all_items'         => __( 'All Extras' ),
			'parent_item'       => __( 'Parent Extras' ),
			'parent_item_colon' => __( 'Parent Extras:' ),
			'edit_item'         => __( 'Edit Extras' ),
			'update_item'       => __( 'Update Extras' ),
			'add_new_item'      => __( 'Add New Extras' ),
			'new_item_name'     => __( 'New Extras Name' ),
			'menu_name'         => __( 'Extras' ),
		),
		'show_in_rest' => true,
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'extras' ),
	));
}

add_action( 'init', 'create_property_accessibility' );
function create_property_accessibility(){

	register_taxonomy('accessibility', array('property'), array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'              => _x( 'Accessibility', 'taxonomy general name' ),
			'singular_name'     => _x( 'Accessibility', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Accessibility' ),
			'all_items'         => __( 'All Accessibility' ),
			'parent_item'       => __( 'Parent Accessibility' ),
			'parent_item_colon' => __( 'Parent Accessibility:' ),
			'edit_item'         => __( 'Edit Accessibility' ),
			'update_item'       => __( 'Update Accessibility' ),
			'add_new_item'      => __( 'Add New Accessibility' ),
			'new_item_name'     => __( 'New Accessibility Name' ),
			'menu_name'         => __( 'Accessibility' ),
		),
		'show_in_rest' => true,
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'accessibility' ),
	));
}


add_action( 'init', 'create_property_bedroom_features' );
function create_property_bedroom_features(){

	register_taxonomy('bedroom-features', array('property'), array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'              => _x( 'Bedroom Features', 'taxonomy general name' ),
			'singular_name'     => _x( 'Bedroom Features', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Bedroom Features' ),
			'all_items'         => __( 'All Bedroom Features' ),
			'parent_item'       => __( 'Parent Bedroom Feature' ),
			'parent_item_colon' => __( 'Parent Bedroom Feature:' ),
			'edit_item'         => __( 'Edit Bedroom Feature' ),
			'update_item'       => __( 'Update Bedroom Feature' ),
			'add_new_item'      => __( 'Add New Bedroom Feature' ),
			'new_item_name'     => __( 'New Bedroom Feature Name' ),
			'menu_name'         => __( 'Bedroom Features' ),
		),
		'show_in_rest' => true,
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'bedroom-features' ),
	));
}

add_action( 'init', 'create_property_property_type' );
function create_property_property_type(){

	register_taxonomy('property-type', array('property'), array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'              => _x( 'Property Type', 'taxonomy general name' ),
			'singular_name'     => _x( 'Property Type', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Property Type' ),
			'all_items'         => __( 'All Property Type' ),
			'parent_item'       => __( 'Parent Property Type' ),
			'parent_item_colon' => __( 'Parent Property Type:' ),
			'edit_item'         => __( 'Edit Property Type' ),
			'update_item'       => __( 'Update Property Type' ),
			'add_new_item'      => __( 'Add New Property Type' ),
			'new_item_name'     => __( 'New Property Type Name' ),
			'menu_name'         => __( 'Property Type' ),
		),
		'show_in_rest' => true,
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'property-type' ),
	));
}

?>
