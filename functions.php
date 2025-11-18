<?php
/**
 * OK Theme Functions
 *
 * @package OKTheme
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Theme Setup
 */
function oktheme_setup() {
	// Add theme support
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	));
	add_theme_support('custom-logo');
	add_theme_support('customize-selective-refresh-widgets');
	add_theme_support('responsive-embeds');
	add_theme_support('align-wide');
	add_theme_support('editor-styles');
	add_theme_support('wp-block-styles');
	
	// Register navigation menus
	register_nav_menus(array(
		'primary' => __('Primary Menu', 'oktheme'),
		'footer' => __('Footer Menu', 'oktheme'),
	));
	
	// Set content width
	$GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'oktheme_setup');

/**
 * Enqueue Scripts and Styles
 */
function oktheme_scripts() {

	    // Main JS (compiled by your build tool)
    wp_enqueue_script(
        'oktheme-js',
        get_template_directory_uri() . '/js/script.js', // or build/script.js
        array(),
        filemtime(get_template_directory() . '/js/script.js'),
        true
    );


	// Enqueue main stylesheet
	wp_enqueue_style('oktheme-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
	wp_enqueue_style('oktheme-tailwind', get_template_directory_uri() . '/assets/tailwind.css', [], filemtime(get_template_directory() . '/assets/tailwind.css'));

	// Enqueue navigation script
	wp_enqueue_script('oktheme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), wp_get_theme()->get('Version'), true);
	
	// Enqueue comment reply script
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'oktheme_scripts');
add_filter('use_widgets_block_editor', '__return_false');

/**
 * Register Widget Areas
 */
function oktheme_widgets_init() {
	register_sidebar(array(
		'name' => __('Sidebar', 'oktheme'),
		'id' => 'sidebar-1',
		'description' => __('Add widgets here to appear in your sidebar.', 'oktheme'),
		'before_widget' => '<section id="%1$s" class="widget %2$s card bg-base-200 p-4">',
		'after_widget' => '</section>',
		'before_title' => '<div class="flex items-center mb-4"><h2 class="text-xl font-bold">',
		'after_title' => '</h2><div class="flex-1 ml-3 h-px line"></div></div>',
	));
	
	register_sidebar(array(
		'name' => __('Footer Widget Area 1', 'oktheme'),
		'id' => 'footer-1',
		'description' => __('Add widgets here to appear in your footer.', 'oktheme'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title text-left font-bold mb-3">',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array(
		'name' => __('Footer Widget Area 2', 'oktheme'),
		'id' => 'footer-2',
		'description' => __('Add widgets here to appear in your footer.', 'oktheme'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title font-bold mb-3">',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array(
		'name' => __('Footer Widget Area 3', 'oktheme'),
		'id' => 'footer-3',
		'description' => __('Add widgets here to appear in your footer.', 'oktheme'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title font-bold mb-3">',
		'after_title' => '</h3>',
	));
}
add_action('widgets_init', 'oktheme_widgets_init');

/**
 * Check if sidebar should be displayed
 * Sidebar shows on: home, archive, post, tag, category
 * Sidebar does NOT show on: pages
 */
function oktheme_should_display_sidebar() {
	// Don't show sidebar on pages
	if (is_page()) {
		return false;
	}
	
	// Show sidebar on home, archive, single post, tag, category
	if (is_home() || is_archive() || is_single() || is_tag() || is_category()) {
		return true;
	}
	
	return false;
}


add_action('init', function() {

    // Disable Gutenberg block styles
    add_action('wp_enqueue_scripts', function() {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
        wp_dequeue_style('classic-theme-styles');
    }, 100);

    // Disable Global Styles inline CSS
    add_filter('wp_get_global_styles', '__return_empty_array');
    add_filter('wp_get_global_stylesheet', '__return_empty_string');

    // Disable emojis (CSS + JS)
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
});

// Count only ONE view per user per post
function oktheme_set_post_views($postID) {
    $count_key = 'views';
    $count = get_post_meta($postID, $count_key, true);

    if ($count == '') {
        $count = 1;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, $count);
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// Track views - one per user using cookie
function oktheme_track_post_views() {
    if (!is_single()) return;

    global $post;
    if (!$post) return;

    $post_id = $post->ID;
    $cookie_name = 'viewed_post_' . $post_id;

    // If cookie NOT set → count view
    if (!isset($_COOKIE[$cookie_name])) {

        // Set cookie for 30 days
        setcookie($cookie_name, '1', time() + (30 * 24 * 60 * 60), "/");

        // Count the view
        oktheme_set_post_views($post_id);
    }
}
add_action('wp_head', 'oktheme_track_post_views');

function oktheme_display_ad($location) {

    if (!get_theme_mod("oktheme_ads_{$location}_enable")) return;

    $code    = get_theme_mod("oktheme_ads_{$location}_code", '');

    if (empty($code)) return;
    echo '<div id="oktheme-ad"><div class="oktheme-ad-content">
	
	

	' . $code . '</div>';
    echo '</div>';
}


/**
 * Custom Navigation Walker for better menu styling
 */
require get_template_directory() . '/inc/class-oktheme-walker-nav-menu.php';

/**
 * Theme Customizer
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom template tags
 */
require get_template_directory() . '/inc/template-tags.php';



require get_template_directory() . '/breadcrumbs.php';


// require_once get_template_directory() . '/plugins/dynamic-date.php';

// require_once get_template_directory() . '/plugins/toc.php';

// require_once get_template_directory() . '/plugins/related-links.php';

require_once get_template_directory() . '/plugins/fixeddate.php';
