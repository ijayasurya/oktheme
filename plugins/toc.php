<?php
/**
 * Accordion Table of Contents using DaisyUI Collapse
 */

if (!defined('ABSPATH')) exit;

function oktheme_generate_toc_accordion($content) {

    if (!is_singular('post')) {
        return $content;
    }

    // Find H2 + H3 from post content
    preg_match_all('/<h([2-3])[^>]*>(.*?)<\/h[2-3]>/', $content, $matches, PREG_SET_ORDER);

    if (empty($matches)) {
        return $content;
    }

    $toc  = '<div class="collapse not-prose collapse-arrow mt-4 border bordernew mb-6">';
    $toc .= '<input type="checkbox" />';
    $toc .= '<div class="collapse-title font-semibold text-lg">Table of Contents</div>';
    $toc .= '<div class="collapse-content">';

    $toc .= '<ul class="menu p-0 w-full">';

    $used_ids = [];

    foreach ($matches as $heading) {

        $level = (int) $heading[1];
        $raw_text = strip_tags($heading[2]);

        // Convert to custom slug with underscores
        $slug = preg_replace('/[^A-Za-z0-9]+/', '_', $raw_text);
        $slug = trim($slug, '_');

        // Ensure unique IDs
        $unique_slug = $slug;
        $i = 2;
        while (in_array($unique_slug, $used_ids)) {
            $unique_slug = $slug . '_' . $i;
            $i++;
        }
        $used_ids[] = $unique_slug;

        // Add ID to heading
        $content = preg_replace(
            '/'.preg_quote($heading[0], '/').'/',
            '<h'.$level.' id="'.$unique_slug.'" class="scroll-mt-24">'.$heading[2].'</h'.$level.'>',
            $content,
            1
        );

        // Menu indentation for H3
        $toc .= '<li class="'.($level === 3 ? 'ml-4' : '').'">';
        $toc .= '<a href="#'.$unique_slug.'" class="text-sm">'.$raw_text.'</a>';
        $toc .= '</li>';
    }

    $toc .= '</ul>'; 
    $toc .= '</div>'; 
    $toc .= '</div>'; 

    return $toc . $content;
}

add_filter('the_content', 'oktheme_generate_toc_accordion', 20);
