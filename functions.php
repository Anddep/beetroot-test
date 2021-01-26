<?php
define('THEME_VERSION', '1.21.97567');

if (!is_admin())
{

    function hotel_styles()
    {
        wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/dist/style.css', array() , THEME_VERSION);
        wp_enqueue_style('main', get_template_directory_uri() . '/style.css', array(
            'custom-style'
        ) , THEME_VERSION);
    }
    add_action('wp_enqueue_scripts', 'hotel_styles');

    function wp_hotel_scripts()
    {
        wp_enqueue_script('font-awesome', 'https://use.fontawesome.com/d3fd47599b.js', array() , true);
        wp_enqueue_script('main-scripts', get_template_directory_uri() . '/assets/dist/main.bundle.js', array(
            'jquery'
        ) , THEME_VERSION, true);
    }
    add_action('wp_enqueue_scripts', 'wp_hotel_scripts');
}

if (!function_exists('hotel_head_meta_tags'))
{
    function hotel_head_meta_tags()
    {
        echo '<meta name="keywords" content="' . get_bloginfo('keywords') . '"/>' . PHP_EOL;
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2, user-scalable=yes" />' . PHP_EOL;
        echo '<meta name="apple-mobile-web-app-capable" content="yes" />' . PHP_EOL;
        echo '<meta http-equiv="X-UA-Compatible" content="IE=edge" />' . PHP_EOL;

    }
    add_action('wp_head', 'hotel_head_meta_tags', 1);
}

//remove attr
function register_html_support()
{
    add_theme_support('html5', array(
        'script',
        'style'
    ));
}

//add custom post type
add_action('init', 'create_property');
function create_property()
{
    register_post_type('property', array(
        'labels' => array(
            'name' => __('Property', 'Hotel') ,
            'singular_name' => __('Property', 'Hotel') ,
        ) ,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-store',
        'show_in_rest' => true,
        'show_in_nav_menus' => 'true',
        'rewrite' => array(
            'slug' => 'property'
        ) ,
        'supports' => array(
            'title',
            'editor',
            'author',
            'custom-fields',
            'revisions',
            'thumbnail'
        ) ,
    ));
}
add_theme_support('post-thumbnails');
//custom tax
add_action('init', 'create_property_city');
function create_property_city()
{

    register_taxonomy('city', array(
        'property'
    ) , array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('City', 'taxonomy general name') ,
            'singular_name' => _x('City', 'taxonomy singular name') ,
            'search_items' => __('Search City') ,
            'all_items' => __('All Cities') ,
            'parent_item' => __('Parent Cities') ,
            'parent_item_colon' => __('Parent Cities:') ,
            'edit_item' => __('Edit City') ,
            'update_item' => __('Update City') ,
            'add_new_item' => __('Add New City') ,
            'new_item_name' => __('New City Name') ,
            'menu_name' => __('City') ,
        ) ,
        'show_in_rest' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'city'
        ) ,
    ));
}

add_action('init', 'create_property_amenities');
function create_property_amenities()
{

    register_taxonomy('amenities', array(
        'property'
    ) , array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('Amenities', 'taxonomy general name') ,
            'singular_name' => _x('Amenities', 'taxonomy singular name') ,
            'search_items' => __('Search Amenities') ,
            'all_items' => __('All Amenities') ,
            'parent_item' => __('Parent Amenities') ,
            'parent_item_colon' => __('Parent Amenities:') ,
            'edit_item' => __('Edit Amenitie') ,
            'update_item' => __('Update Amenitie') ,
            'add_new_item' => __('Add New Amenities') ,
            'new_item_name' => __('New Amenitie Name') ,
            'menu_name' => __('Amenities') ,
        ) ,
        'show_in_rest' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'amenities'
        ) ,
    ));
}

add_action('init', 'create_property_extras');
function create_property_extras()
{

    register_taxonomy('extras', array(
        'property'
    ) , array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('Extras', 'taxonomy general name') ,
            'singular_name' => _x('Extras', 'taxonomy singular name') ,
            'search_items' => __('Search Extras') ,
            'all_items' => __('All Extras') ,
            'parent_item' => __('Parent Extras') ,
            'parent_item_colon' => __('Parent Extras:') ,
            'edit_item' => __('Edit Extras') ,
            'update_item' => __('Update Extras') ,
            'add_new_item' => __('Add New Extras') ,
            'new_item_name' => __('New Extras Name') ,
            'menu_name' => __('Extras') ,
        ) ,
        'show_in_rest' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'extras'
        ) ,
    ));
}

add_action('init', 'create_property_accessibility');
function create_property_accessibility()
{

    register_taxonomy('accessibility', array(
        'property'
    ) , array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('Accessibility', 'taxonomy general name') ,
            'singular_name' => _x('Accessibility', 'taxonomy singular name') ,
            'search_items' => __('Search Accessibility') ,
            'all_items' => __('All Accessibility') ,
            'parent_item' => __('Parent Accessibility') ,
            'parent_item_colon' => __('Parent Accessibility:') ,
            'edit_item' => __('Edit Accessibility') ,
            'update_item' => __('Update Accessibility') ,
            'add_new_item' => __('Add New Accessibility') ,
            'new_item_name' => __('New Accessibility Name') ,
            'menu_name' => __('Accessibility') ,
        ) ,
        'show_in_rest' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'accessibility'
        ) ,
    ));
}

add_action('init', 'create_property_bedroom_features');
function create_property_bedroom_features()
{

    register_taxonomy('bedroom-features', array(
        'property'
    ) , array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('Bedroom Features', 'taxonomy general name') ,
            'singular_name' => _x('Bedroom Features', 'taxonomy singular name') ,
            'search_items' => __('Search Bedroom Features') ,
            'all_items' => __('All Bedroom Features') ,
            'parent_item' => __('Parent Bedroom Feature') ,
            'parent_item_colon' => __('Parent Bedroom Feature:') ,
            'edit_item' => __('Edit Bedroom Feature') ,
            'update_item' => __('Update Bedroom Feature') ,
            'add_new_item' => __('Add New Bedroom Feature') ,
            'new_item_name' => __('New Bedroom Feature Name') ,
            'menu_name' => __('Bedroom Features') ,
        ) ,
        'show_in_rest' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'bedroom-features'
        ) ,
    ));
}

add_action('init', 'create_property_property_type');
function create_property_property_type()
{

    register_taxonomy('property-type', array(
        'property'
    ) , array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('Property Type', 'taxonomy general name') ,
            'singular_name' => _x('Property Type', 'taxonomy singular name') ,
            'search_items' => __('Search Property Type') ,
            'all_items' => __('All Property Type') ,
            'parent_item' => __('Parent Property Type') ,
            'parent_item_colon' => __('Parent Property Type:') ,
            'edit_item' => __('Edit Property Type') ,
            'update_item' => __('Update Property Type') ,
            'add_new_item' => __('Add New Property Type') ,
            'new_item_name' => __('New Property Type Name') ,
            'menu_name' => __('Property Type') ,
        ) ,
        'show_in_rest' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'property-type'
        ) ,
    ));
}

//api search form
add_action('rest_api_init', function ()
{
    register_rest_route( 'api/v1', 'property', [
            'methods' => 'GET',
            'callback' => 'property_form',
            'permission_callback' => '__return_true'
        ]);

});

function property_form($request)
{
    $where = $request['where'] ? $request['where'] : '';
    $paged = $request['page'] ? $request['page'] : 1;
    $post_per_page = $request['posts_per_page'] ? intval($request['posts_per_page']) : 2;

    $args = [
    'posts_per_page' => $post_per_page,
    'paged' => $paged,
    'post_type' => 'property',
    's' => $where,
    'order'   => 'DESC',
    'meta_query' => array(
        'relation' => 'AND',
    ) ,

    ];

    if ($request['order'])
    {
        $order = $request['order'];
        if ($order == 'recent'){
            $args['orderby'] = 'date';
        } elseif ($order == 'price'){
        	$args['orderby'] = 'meta_value_num';
        	$args['meta_key'] = 'price';
        } elseif ($order == 'flat'){
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'rooms';
        }
    }



    if ($request['in'])
    {
        $check_in = $request['in'];

        $args['meta_query'][] = array(

            array(
                'key' => 'start_available',
                'value' => $check_in,
                'compare' => '<=',
                'type' => 'DATE'
            ) ,

        );
    }

    if ($request['out'])
    {
        $check_out = $request['out'];

        $args['meta_query'][] = array(

            array(
                'key' => 'end_available',
                'value' => $check_out,
                'compare' => '>=',
                'type' => 'DATE'
            ) ,

        );
    }

    if ($request['guest'])
    {
        $guest = $request['guest'];

        $args['meta_query'][] = array(

            array(
                'key' => 'max_capability',
                'value' => $guest,
                'compare' => '>=',
            ) ,

        );
    }

    if ($request['amenities'])
    {
        $amenities = $request['amenities'];
        $amenities = explode(',', $amenities);

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'amenities',
                'field' => 'slug',
                'terms' => $amenities,
                'operator' => 'AND'
            )
        );
    }

    if ($request['extras'])
    {
        $extras = $request['extras'];
        $extras = explode(',', $extras);

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'extras',
                'field' => 'slug',
                'terms' => $extras,
                'operator' => 'AND'
            )
        );
    }

    if ($request['accessibility'])
    {
        $accessibility = $request['accessibility'];
        $accessibility = explode(',', $accessibility);

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'accessibility',
                'field' => 'slug',
                'terms' => $accessibility,
                'operator' => 'AND'
            )
        );
    }

    if ($request['bedroom'])
    {
        $bedroom = $request['bedroom'];
        $bedroom = explode(',', $bedroom);

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'bedroom-features',
                'field' => 'slug',
                'terms' => $bedroom,
                'operator' => 'AND'
            )
        );
    }

    if ($request['type'])
    {
        $property_type = $request['type'];
        $property_type = explode(',', $property_type);

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'property-type',
                'field' => 'slug',
                'terms' => $property_type,
                'operator' => 'AND'
            )
        );
    }

    $posts = new WP_Query($args);

    if ($posts->have_posts())
    {
        while ($posts->have_posts())
        {
            $posts->the_post();

            $property_data['items'][] = array(

                'id' => get_the_ID() ,
                'title' => get_the_title() ,
                'description' => get_field("description", get_the_ID()) ,
                'link' => get_the_permalink(get_the_ID()) ,
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID() , 'full') ,
                'price' => get_field("price", get_the_ID()) ,
                'location' => array(
                    'link' => get_field('location_link', get_the_ID()) ,
                    'name' => get_field("location_name", get_the_ID()) ,
                ) ,
                'rooms' => array(
                    'all' => get_field("rooms", get_the_ID()) ,
                    'bedrooms' => get_field("вedrooms", get_the_ID()) ,
                    'bathrooms' => get_field("bathrooms", get_the_ID()) ,
                    'square' => get_field("square", get_the_ID()) ,
                ) ,
                'author' => array(
                    'id' => get_the_author_meta('ID') ,
                    'name' => get_the_author_meta('user_firstname', get_the_author_meta('ID')) . ' ' . get_the_author_meta('user_lastname', get_the_author_meta('ID')) ,
                    'image' => get_field('profile_avatar', 'user_' . get_the_author_meta('ID', get_the_author_meta('ID'))) ,
                ) ,
                'date' => get_the_time('M d, Y', get_the_ID())
            );
        }
    }
    $property_data['total'] = $posts->found_posts;
    $property_data['postOnPage'] = $post_per_page;

    if (empty($property_data))
    {
        return false;
    }

    return $property_data;
}
//http://localhost:8888/beet-test/wp-json/api/v1/property?in=2020-12-23&out=2020-12-25&guest=2
#single page

//add js code on page
function js_vars()
{ ?>
    <script type="text/javascript">
        let ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
        let siteUrl = '<?=get_site_url(); ?>';
    </script><?php
}
add_action('wp_head', 'js_vars');

add_action('wp_ajax_send_form', 'sendForm');
add_action('wp_ajax_nopriv_send_form', 'sendForm');

function sendForm()
{

    //     if ( empty( $_POST["check-in"] ) ) {
    //         echo "Insert your name please";
    //         wp_die();
    //     }


    // This is the email where you want to send the comments.
    $to = 'a.deputovich@gmail.com';

    // Your message subject.
    $subject = 'Now message from a client!';

    $body = 'From: ' . $_POST['check-in'] . '\n';
    $body .= 'Email: ' . $_POST['name'] . '\n';
    $body .= 'Message: ' . $_POST['comment'] . '\n';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8'
    );

    wp_mail($to, $subject, $body, $headers);

    wp_die();
}



?>
