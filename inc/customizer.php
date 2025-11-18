<?php
/**
 * Theme Customizer
 *
 * @package OKTheme
 */

if (!defined('ABSPATH')) {
	exit;
}

function oktheme_sanitize_ad_code( $input ) {
    return $input; // allow everything including script
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function oktheme_customize_register($wp_customize) {
/* ---------------------------------------------
 * TRENDING SECTION
 * --------------------------------------------- */
$wp_customize->add_section('oktheme_trending', array(
    'title'    => __('Trending Posts', 'oktheme'),
    'priority' => 45,
));

$wp_customize->add_setting('oktheme_trending_enable', array(
    'default'           => false,
    'sanitize_callback' => 'wp_validate_boolean',
));

$wp_customize->add_control('oktheme_trending_enable', array(
    'label'   => __('Enable Trending Section', 'oktheme'),
    'section' => 'oktheme_trending',
    'type'    => 'checkbox',
));

// Number of posts
$wp_customize->add_setting('oktheme_trending_count', array(
    'default'           => 5,
    'sanitize_callback' => 'absint',
));

$wp_customize->add_control('oktheme_trending_count', array(
    'label'       => __('Number of Trending Posts', 'oktheme'),
    'section'     => 'oktheme_trending',
    'type'        => 'number',
    'input_attrs' => array('min' => 1, 'max' => 20),
));
/* ---------------------------------------------
 * ADVERTISEMENTS SECTION (SCRIPT TAG SAFE)
 * --------------------------------------------- */
$wp_customize->add_section('oktheme_ads', array(
    'title'    => __('Advertisements', 'oktheme'),
    'priority' => 70,
));

$ad_locations = array(
    'before_header' => __('Before Header', 'oktheme'),
    'before_post'   => __('Before Post Content', 'oktheme'),
    'after_post'    => __('After Post Content', 'oktheme'),
);

foreach ($ad_locations as $key => $label) {

    // Enable switch
    $wp_customize->add_setting("oktheme_ads_{$key}_enable", array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control("oktheme_ads_{$key}_enable", array(
        'label'   => sprintf(__('Enable %s Ad', 'oktheme'), $label),
        'section' => 'oktheme_ads',
        'type'    => 'checkbox',
    ));

    // Ad Code (HTML + SCRIPT allowed)
    $wp_customize->add_setting("oktheme_ads_{$key}_code", array(
        'default'           => '',
        'sanitize_callback' => 'oktheme_sanitize_ad_code', // FIXED
    ));

    $wp_customize->add_control("oktheme_ads_{$key}_code", array(
        'label'   => sprintf(__('%s Ad Code (HTML/JS)', 'oktheme'), $label),
        'section' => 'oktheme_ads',
        'type'    => 'textarea',
    ));

}

	
	// Typography Section
	$wp_customize->add_section('oktheme_typography', array(
		'title' => __('Typography', 'oktheme'),
		'priority' => 35,
	));
	
	// Body Font Size
	$wp_customize->add_setting('oktheme_body_font_size', array(
		'default' => '16',
		'sanitize_callback' => 'absint',
		'transport' => 'refresh',
	));
	
	$wp_customize->add_control('oktheme_body_font_size', array(
		'label' => __('Body Font Size (px)', 'oktheme'),
		'section' => 'oktheme_typography',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 12,
			'max' => 24,
			'step' => 1,
		),
	));
	
	// Layout Section
	$wp_customize->add_section('oktheme_layout', array(
		'title' => __('Layout', 'oktheme'),
		'priority' => 40,
	));
	
	// Container Width
	$wp_customize->add_setting('oktheme_container_width', array(
		'default' => '1280',
		'sanitize_callback' => 'absint',
		'transport' => 'refresh',
	));
	
	$wp_customize->add_control('oktheme_container_width', array(
		'label' => __('Container Max Width (px)', 'oktheme'),
		'section' => 'oktheme_layout',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 960,
			'max' => 1920,
			'step' => 10,
		),
	));
	
	// Footer Section
	$wp_customize->add_section('oktheme_footer', array(
		'title' => __('Footer', 'oktheme'),
		'priority' => 50,
	));
	
	// Footer Text
	$wp_customize->add_setting('oktheme_footer_text', array(
		'default' => sprintf(
			esc_html__('&copy; %1$s %2$s. All rights reserved.', 'oktheme'),
			date('Y'),
			get_bloginfo('name')
		),
		'sanitize_callback' => 'wp_kses_post',
		'transport' => 'refresh',
	));
	
	$wp_customize->add_control('oktheme_footer_text', array(
		'label' => __('Footer Text', 'oktheme'),
		'section' => 'oktheme_footer',
		'type' => 'textarea',
	));
	
	// Social Media Section
	$wp_customize->add_section('oktheme_social', array(
		'title' => __('Social Media', 'oktheme'),
		'priority' => 60,
	));
	
	$social_networks = array(
		'facebook' => __('Facebook', 'oktheme'),
		'twitter' => __('Twitter', 'oktheme'),
		'instagram' => __('Instagram', 'oktheme'),
		'linkedin' => __('LinkedIn', 'oktheme'),
		'youtube' => __('YouTube', 'oktheme'),
	);
	
	foreach ($social_networks as $network => $label) {
		$wp_customize->add_setting('oktheme_social_' . $network, array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport' => 'refresh',
		));
		
		$wp_customize->add_control('oktheme_social_' . $network, array(
			'label' => $label . ' ' . __('URL', 'oktheme'),
			'section' => 'oktheme_social',
			'type' => 'url',
		));
	}
}
add_action('customize_register', 'oktheme_customize_register');

/**
 * Output custom CSS based on customizer settings
 */
function oktheme_customizer_css() {
	$body_font_size = get_theme_mod('oktheme_body_font_size', '16');
	$container_width = get_theme_mod('oktheme_container_width', '1280');
	
	?>
	<style type="text/css">
		:root {
			--oktheme-body-font-size: <?php echo esc_attr($body_font_size); ?>px;
			--oktheme-container-width: <?php echo esc_attr($container_width); ?>px;
		}
		
		body {
			font-size: var(--oktheme-body-font-size);
		}
		
		.container-custom {
			max-width: var(--oktheme-container-width);
		}
	</style>
	<?php
}
add_action('wp_head', 'oktheme_customizer_css');

