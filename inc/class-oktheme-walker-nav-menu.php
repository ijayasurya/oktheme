<?php
/**
 * Custom Navigation Walker (Tailwind + DaisyUI)
 *
 * @package OKTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

class OKTheme_Walker_Nav_Menu extends Walker_Nav_Menu {

    /** Start Submenu */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"menu menu-sm dropdown-content mt-2 p-2 shadow bg-base-100 rounded-box w-52 z-[999]\">\n";
    }

    /** End Submenu */
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= str_repeat("\t", $depth) . "</ul>\n";
    }

    /** Start Element */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {

        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        /** Detect Active Item */
        $is_active =
            in_array('current-menu-item', $item->classes)
            || in_array('current-menu-ancestor', $item->classes)
            || in_array('current_page_item', $item->classes);

        /** Base LI classes */
        $li_classes = [
            'relative',
            'group',
            'menu-item-' . $item->ID
        ];

        if ($is_active) {
            $li_classes[] = ''; // DaisyUI active
        }

        $class_names = ' class="' . esc_attr(implode(' ', $li_classes)) . '"';

        /** ID */
        $id_attr = ' id="menu-item-' . esc_attr($item->ID) . '"';

        /** Start LI */
        $output .= $indent . '<li' . $id_attr . $class_names . '>';

        /** Link attributes */
        $attributes  = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        /** Add DaisyUI link classes */
        $link_classes = ' class="transition-all duration-200"';
        
        if ($is_active) {
            $link_classes = ' class="  font-semibold"';
        }

        /** Output link */
        $item_output = '<a' . $attributes . $link_classes . '>';
        $item_output .= apply_filters('the_title', $item->title, $item->ID);
        $item_output .= '</a>';

        $output .= $item_output;
    }

    /** End Element */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}
