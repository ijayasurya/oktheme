<?php
/**
 * OKTheme – Auto Related “Also Read” Links (SAFE VERSION)
 * File: theme/oktheme/plugins/related-links.php
 */

if (!defined('ABSPATH')) exit;


/**
 * CUSTOMIZER SECTION
 */
function oktheme_related_links_customizer($wp_customize) {

    $wp_customize->add_section('oktheme_related_links_section', [
        'title'    => __('Related Links (Auto)', 'oktheme'),
        'priority' => 42,
    ]);

    // Enable / Disable
    $wp_customize->add_setting('oktheme_related_links_enable', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);

    $wp_customize->add_control('oktheme_related_links_enable', [
        'label'   => __('Enable Related Auto Links', 'oktheme'),
        'section' => 'oktheme_related_links_section',
        'type'    => 'checkbox',
    ]);

    // Number of related posts
    $wp_customize->add_setting('oktheme_related_links_limit', [
        'default'           => 5,
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('oktheme_related_links_limit', [
        'label'       => __('Number of Related Posts', 'oktheme'),
        'section'     => 'oktheme_related_links_section',
        'type'        => 'number',
        'input_attrs' => ['min' => 1, 'max' => 20]
    ]);

    // Insert every X paragraphs
    $wp_customize->add_setting('oktheme_related_links_insert_every', [
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('oktheme_related_links_insert_every', [
        'label'       => __('Insert "Also Read" After Every X Paragraphs', 'oktheme'),
        'section'     => 'oktheme_related_links_section',
        'type'        => 'number',
        'input_attrs' => ['min' => 1, 'max' => 10]
    ]);
}
add_action('customize_register', 'oktheme_related_links_customizer');



/**
 * Get Related Posts
 */
function oktheme_get_related_posts($post_id, $limit = 5) {
    $related = [];

    // by categories
    $categories = wp_get_post_categories($post_id);
    if (!empty($categories)) {
        $related = get_posts([
            'category__in'   => $categories,
            'post__not_in'   => [$post_id],
            'posts_per_page' => $limit,
            'orderby'        => 'rand',
        ]);
    }

    // fallback tags
    if (empty($related)) {
        $tags = wp_get_post_tags($post_id, ['fields' => 'ids']);
        if (!empty($tags)) {
            $related = get_posts([
                'tag__in'        => $tags,
                'post__not_in'   => [$post_id],
                'posts_per_page' => $limit,
                'orderby'        => 'rand',
            ]);
        }
    }

    // final fallback
    if (empty($related)) {
        $related = get_posts([
            'post__not_in'   => [$post_id],
            'posts_per_page' => $limit,
            'orderby'        => 'rand',
        ]);
    }

    return $related;
}



/**
 * INSERT ALSO READ USING PARAGRAPH-SAFE LOGIC
 */
function oktheme_insert_also_read_links($content) {
    if (!is_singular('post')) return $content;

    // Enabled?
    $enabled = get_theme_mod('oktheme_related_links_enable', true);
    if (!$enabled) return $content;

    global $post;

    // Settings
    $limit        = get_theme_mod('oktheme_related_links_limit', 5);
    $insert_every = get_theme_mod('oktheme_related_links_insert_every', 3);

    // Get related posts
    $related = oktheme_get_related_posts($post->ID, $limit);
    if (empty($related)) return $content;

    // Split by paragraphs without breaking the content
    $paragraphs = preg_split('/<\/p>/i', $content);
    $output = '';
    $index = 0;
    $related_index = 0;

    foreach ($paragraphs as $p) {

        if (trim($p)) {
            // Always keep paragraph
            $output .= $p . '</p>';
            $index++;

            // Insert after X paragraphs
            if ($index % $insert_every === 0 && isset($related[$related_index])) {

                $title = esc_html($related[$related_index]->post_title);
                $url   = esc_url(get_permalink($related[$related_index]->ID));

                // Styled block — Tailwind + DaisyUI
                $output .= '
                    <p>
                        <span class="font-semibold">Also Read:</span>
                        <a href="'.$url.'" class="ml-1 text-primary hover:underline">
                            '.$title.'
                        </a>
                    </p>';

                $related_index++;

                // ⭐ IMPORTANT FIX:
                // DO NOT break, continue showing rest of content
            }
        }
    }

    return $output;
}
add_filter('the_content', 'oktheme_insert_also_read_links');
