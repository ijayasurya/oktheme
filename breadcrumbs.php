<?php
// breadcrumbs.php

function oktheme_breadcrumbs() {

    // Do not show on homepage
    if (is_front_page()) return;

    echo '<div class="breadcrumbs w-fit bg-base-200 px-3 py-1 rounded text-sm"><ul>';

    // Home Link
    echo '<li><a class=" no-underline" href="' . home_url() . '">Home</a></li>';

    // Category or Custom Taxonomy
    if (is_single()) {
        $category = get_the_category();
        if (!empty($category)) {
            $cat_link = get_category_link($category[0]->term_id);
            echo '<li><a class="link  no-underline" href="' . esc_url($cat_link) . '">' . esc_html($category[0]->name) . '</a></li>';
        }
        // Current Post Title
        echo '<li>' . get_the_title() . '</li>';
    }

    // Pages
    if (is_page()) {
        global $post;
        if ($post->post_parent) {
            $parent_id   = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page          = get_page($parent_id);
                $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                $parent_id     = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) echo $crumb;
        }
        echo '<li>' . get_the_title() . '</li>';
    }

    echo '</ul></div>';
}
?>
