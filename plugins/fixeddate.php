<?php
/**
 * Plugin: Fixed Date Hack
 * Description: If custom field "datehack" = true, show today's date at 12:00 AM as the modified date.
 */

if (!defined('ABSPATH')) exit;

function oktheme_fixeddate_override($modified, $format, $post) {

    // Ensure we have a post object
    if (!is_a($post, 'WP_Post')) {
        return $modified;
    }

    // Check custom field
    $datehack = get_post_meta($post->ID, 'datehack', true);

    if ($datehack === 'true' || $datehack === true) {

        // Force date to today's date at 12:00 AM
        $forced_time = strtotime('today midnight');

        // Return formatted time based on requested format
        return date_i18n($format, $forced_time);
    }

    return $modified;
}
add_filter('get_the_modified_time', 'oktheme_fixeddate_override', 10, 3);
add_filter('get_the_modified_date', 'oktheme_fixeddate_override', 10, 3);
