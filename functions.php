<?php

const CSS_VERSION = 1.65;

/** Other */
include_once('ranking-kurierow.php');
include_once('carrier-maps.php');
include_once('review-form.php');

/** Products */
include_once('Products/ProductFactory.php');
include_once('Products/Connector.php');
include_once('Products/Product.php');
include_once('Products/Exception/CollectionNotFoundException.php');
include_once('Products/Generator/ProductsGenerator.php');
include_once('Products/Generator/ProductsGeneratorFactory.php');
include_once('Products/Generator/ProductsGeneratorRepository.php');
include_once('Products/Generator/SitemapGenerator.php');
include_once('Products/Generator/CatalogGenerator.php');
include_once('Products/Enum/FieldsEnum.php');

/** Virtual Page */
include_once('VirtualPage/VirtualPage.php');

/** Custom Functions */
include_once('CustomFunctions/DisplayService.php');
include_once('CustomFunctions/WebpConverter.php');
include_once('CustomFunctions/SitemapGenerator.php');

/** Custom Post Types */
include_once('CustomPostTypes/Oceny.php');

/** Custom Taxonomies */
include_once('CustomTaxonomies/Oceny/Couriers.php');

/** Custom Fields */
include_once('CustomFields/Oceny.php');

/** Scripts */
include_once('Scripts/FaqSchemaForParcels.php');

/** Endpoints */
include_once('Endpoints/latest-posts.php');

remove_filter('template_redirect','redirect_canonical');
add_filter('xmlrpc_enabled', '__return_false');

remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

add_filter('bcn_breadcrumb_url', 'my_breadcrumb_url_changer', 3, 10);
function my_breadcrumb_url_changer($url, $type, $id) {
    if (in_array('category', $type)) {
        $url = str_replace("kategoria/", "", $url);
    }

    return $url;
}

/**
 * @return string
 */
function get_logo_url_by_language()
{
    $path = get_template_directory_uri();
    $currentLanguage = get_locale();

    $logoUrl = $path."/img/logo_pl.png";
    if ($currentLanguage !== 'pl') {
        $logoUrl = $path."/img/logo_pl.png";
    }

    return $logoUrl;
}

register_nav_menus([
	'primary' => __('Primary Menu', 'globkurier'),
	'primary-v2' => __('Menu główne v2.0', 'globkurier'),
	'upper-v2' => __('Menu główne górne v2.0', 'globkurier'),
    'footer_main_menu' => __('Footer Main Menu', 'globkurier'),
	'footer_bottom_menu' => __('Footer Bottom Menu', 'globkurier'),
]);

function breadcrumbs_widget() {
    register_sidebar([
        'name' => 'Breadcrumbs',
        'id' => 'breadcrumbs_widget',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
    ]);
}
add_action('widgets_init', 'breadcrumbs_widget');

function language_switcher_widget() {
    register_sidebar([
        'name' => 'Language Switcher',
        'id' => 'language_switcher_widget',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
    ]);
}
add_action('widgets_init', 'language_switcher_widget');

function WidgetA() {
	register_sidebar([
		'name'          => 'Stopka 1',
		'id'            => 'home_right_1',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="line-menu__heading accordion__heading">',
		'after_title'   => '</h2>',
	]);
}
add_action('widgets_init', 'WidgetA');

function WidgetB() {
	register_sidebar([
		'name'          => 'Stopka 2',
		'id'            => 'home_right_2',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="line-menu__heading accordion__heading">',
		'after_title'   => '</h2>',
	]);
}
add_action('widgets_init', 'WidgetB');

function WidgetC() {
	register_sidebar([
		'name'          => 'Stopka 3',
		'id'            => 'home_right_3',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="line-menu__heading accordion__heading">',
		'after_title'   => '</h2>',
	]);
}
add_action('widgets_init', 'WidgetC');

function WidgetD() {
	register_sidebar([
		'name'          => 'Stopka 4',
		'id'            => 'home_right_4',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="line-menu__heading accordion__heading">',
		'after_title'   => '</h2>',
	]);
}
add_action('widgets_init', 'WidgetD');

function GlobKurier_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	register_nav_menus([
	 	'naskroty' => __('Poznaj GLobKurier Na Skroty', 'globkurier'),
		'naskroty_blog' => __('Na Skroty przy BLOG', 'globkurier'),
		'naskroty_strona' => __('Na Skroty przy Strona', 'globkurier'),
		'primary'  => __('Menu Główne bez PoznajGK', 'globkurier'),
		'footermenu' => __('Stopka', 'globkurier'),
	]);

}	
add_action('after_setup_theme', 'GlobKurier_setup');

function wpb_set_post_views($postID) {
	$count_key = 'wpb_post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if ($count == '') {
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	} else {
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}

function wpb_track_post_views ($post_id) {
	if (!is_single()) return;
	if (empty($post_id)) {
		global $post;
		$post_id = $post->ID;    
	}

	wpb_set_post_views($post_id);
}
add_action('wp_head', 'wpb_track_post_views');

if (function_exists('acf_add_options_page')) {
	acf_add_options_page([
		'page_title' 	=> 'Ustawienia motywu',
		'menu_title'	=> 'Ust. motywu',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	]);
}

function title_filter($where, $wp_query) {
	global $wpdb;

	if ($search_term = $wp_query->get('search_prod_title')) {
		$search_term = $wpdb->esc_like($search_term);
		$search_term = ' \'%' . $search_term . '%\'';
		$where .= ' AND ' . $wpdb->posts . '.post_title LIKE '.$search_term;
	}

	return $where;
}

add_filter('redirect_canonical', function($redirect_url) {
	if (is_paged()) {
		return false;
	}

	return $redirect_url;
}, 10, 1);


/* Dodanie Bloga do okruszków na podstronie kategorii i postu*/
function add_magazin_link_to_breadcrumbs( $breadcrumb_obj ) {
	$language = explode('?lang=', $_SERVER['REQUEST_URI']); 
	if ($postCat = get_the_category()) {
		$postCategories = [];
		foreach($postCat as $cat) {
			array_push($postCategories, $cat->slug);
		}

		$urlCategory = explode('/', $_SERVER['REQUEST_URI'])[1]; 
		if (in_array($urlCategory, $postCategories)) {
			$magazine_item = new bcn_breadcrumb();
			$magazine_item->set_title('Blog Globkurier');
			$url = isset($language[1]) ? '/blog?lang=' . $language[1] : '/blog';
			$magazine_item->set_url(site_url().$url);
			$magazine_item->set_linked(true);
			array_splice($breadcrumb_obj->breadcrumbs, 2, 0, [$magazine_item]);
		}
		if (false !== strpos($_SERVER['REQUEST_URI'], '/blog/')) {
			$magazine_item = new bcn_breadcrumb();
			$magazine_item->set_title('Blog Globkurier');
			$url = isset($language[1]) ? '/blog?lang=' . $language[1] : '/blog';
			$magazine_item->set_url(site_url().$url);
			$magazine_item->set_linked(true);
			array_splice($breadcrumb_obj->breadcrumbs, 1, 0, [$magazine_item]);
		}
	}

	if (isset($language[1])) {
		$magazine_item = new bcn_breadcrumb();
		$url = null;
		switch ($language[1]) {
			case 'en':
				$url = 'https://globkurier.com';
				break;
			case 'es':
				$url = 'https://globkurier.es';
				break;
			default:
				$url = 'https://globkurier.pl';
		}
		$magazine_item->set_url($url);
		$magazine_item->set_title('Globkurier');
		$magazine_item->set_linked(true);
		array_splice($breadcrumb_obj->breadcrumbs, count($breadcrumb_obj->breadcrumbs) - 1, 1, [$magazine_item]);
	}
}
add_action('bcn_after_fill', 'add_magazin_link_to_breadcrumbs');

/* Przekierowanie z adresu /blog na kategorię */
function redirect_blog_to_category() {
	$url = $_SERVER['REQUEST_URI'];
	$splitUrl = explode('/', $url);
	
	if (!(sizeof($splitUrl) > 2 && $splitUrl[1] == 'blog')) {
		return;
	}

	$args = [
		'name'        => $splitUrl[2],
		'post_type'   => 'post',
		'post_status' => 'publish',
		'numberposts' => 1
	];

	$my_posts = get_posts($args);
	if ($my_posts && $splitUrl[2]) {
		global $wp_query;
		$wp_query->set_404();
		status_header(404);
		get_template_part(404);

		exit();
	}
}
add_action('init','redirect_blog_to_category');

/* Dodanie Ranking kurierów do okruszków na podstronie opinii*/
function add_rank_link_to_breadcrumbs($breadcrumb_obj) {
	if (false !== strpos($_SERVER['REQUEST_URI'], '/opinie-')) {
		$magazine_item = new bcn_breadcrumb();
		$magazine_item->set_title('Ranking kurierów');
		$magazine_item->set_url(site_url().'/ranking-kurierow');
		$magazine_item->set_linked(true);
		array_splice( $breadcrumb_obj->breadcrumbs, 1, 0, [$magazine_item]);
	}
}
add_action('bcn_after_fill', 'add_rank_link_to_breadcrumbs');

add_filter('elementor_pro/custom_fonts/font_display', function($current_value, $font_family, $data) {
	return 'swap';
}, 10, 3);

/* Przekierowanie wpisów na swoje kategorie */
function check_category_and_redirect() {
	$url = $_SERVER['REQUEST_URI'];
	$splitUrl = explode('/', $url);

	if (sizeof($splitUrl) <= 2 ) {
		return;
	}

	if ($splitUrl[1] == 'wp-admin') {
		return;
	}

	if (!$splitUrl[2]) {
		return;
	}

	$args = [
		'name'        => end($splitUrl),
		'post_type'   => 'post',
		'post_status' => 'publish',
		'numberposts' => 1,
	];
	
	if (!$post = get_posts($args)) {
		return;
	}

	$postCategories = get_the_category($post[0]->ID);
	$postCategoriesSlugs = [];
	foreach ($postCategories as $category) {
		$postCategoriesSlugs[$category->slug] = $category->slug;
	}

	if (!in_array($splitUrl[1], $postCategoriesSlugs)) {
		global $wp_query;
		$wp_query->set_404();
		status_header(404);
		get_template_part(404);
		exit();
	}
}
add_action('init','check_category_and_redirect');

add_filter("wpdiscuz_comment_author", function ($authorName, $comment) {
	if ($comment->user_id) {
		$authorName = "GlobKurier.pl";
	}

	return $authorName;
}, 10, 2);

new VirtualPage('Produkty', 'produkty', 'Products/template/main.php', 'noindex');
(new ProductsGeneratorFactory())->build();
new SitemapGenerator();
new CatalogGenerator();

function get_current_url()
{
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "۸۰") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

add_filter('bloginfo_url', function($output, $property){
    return ($property == 'pingback_url') ? null : $output;
}, 11, 2);

add_filter('wp_headers', function($headers, $wp_query){
    if(isset($headers['X-Pingback'])){
        unset($headers['X-Pingback']);
    }
    return $headers;
}, 11, 2);

add_action('rest_api_init', function() {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
}, 15);
