<?php
/**
 * Custom Template Tags
 *
 * @package OKTheme
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Display post meta information
 */
function oktheme_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	
	if (get_the_time('U') !== get_the_modified_time('U')) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}
	
	$time_string = sprintf(
		$time_string,
		esc_attr(get_the_date(DATE_W3C)),
		esc_html(get_the_date()),
		esc_attr(get_the_modified_date(DATE_W3C)),
		esc_html(get_the_modified_date())
	);
	
	$posted_on = sprintf(
		esc_html_x('Posted on %s', 'post date', 'oktheme'),
		'<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
	);
	
	$byline = sprintf(
		esc_html_x('by %s', 'post author', 'oktheme'),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
	);
	
	echo '<div class="flex flex-wrap items-center gap-3 text-sm text-base-content/70">';
	echo '<span class="posted-on">' . $posted_on . '</span>';
	echo '<span class="separator">•</span>';
	echo '<span class="byline">' . $byline . '</span>';
	echo '</div>';
}

/**
 * Display post categories
 */
function oktheme_post_categories() {
	$categories = get_the_category();
	if (!empty($categories)) {
		echo '<div class="post-categories flex flex-wrap gap-2">';
		foreach ($categories as $category) {
			echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="badge badge-ghost">' . esc_html($category->name) . '</a>';
		}
		echo '</div>';
	}
}

/**
 * Display post tags
 */
function oktheme_post_tags() {
	$tags = get_the_tags();
	if (!empty($tags)) {
		echo '<div class="post-tags flex flex-wrap items-center gap-2">';
		echo '<span class="text-sm font-semibold text-base-content/70">Tags:</span>';
		foreach ($tags as $tag) {
			echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="badge badge-outline badge-sm hover:badge-primary hover:badge-primary transition-all">' . esc_html($tag->name) . '</a>';
		}
		echo '</div>';
	}
}

/**
 * Display pagination
 */
function oktheme_pagination() {
	if (is_singular()) {
		return;
	}
	
	global $wp_query;
	
	if ($wp_query->max_num_pages < 2) {
		return;
	}
	
	$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
	$max = intval($wp_query->max_num_pages);
	
	if ($paged >= 1) {
		$links[] = $paged;
	}
	
	if ($paged >= 3) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}
	
	if (($paged + 2) <= $max) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}
	
	echo '<nav class="pagination mt-12 mb-8 flex justify-center" aria-label="' . esc_attr__('Posts navigation', 'oktheme') . '">';
	echo '<div class="join gap-2">';
	
	// Previous link
	if (get_previous_posts_link()) {
		echo '<div class="pagination-link">';
		previous_posts_link('<button class="join-item btn btn-sm md:btn-md">' . __('Previous', 'oktheme') . '</button>');
		echo '</div>';
	}
	
	// Page numbers
	for ($i = 1; $i <= $max; $i++) {
		if (!in_array($i, $links) && $i != $paged && $i != 1 && $i != $max) {
			if ($i == $paged - 3 || $i == $paged + 3) {
				echo '<button class="join-item btn btn-sm md:btn-md btn-disabled">...</button>';
			}
			continue;
		}
		
		if ($i == $paged) {
			echo '<button class="join-item btn btn-sm md:btn-md btn-active btn-primary">' . $i . '</button>';
		} else {
			echo '<a href="' . esc_url(get_pagenum_link($i)) . '" class="join-item btn btn-sm md:btn-md hover:btn-primary">' . $i . '</a>';
		}
	}
	
	// Next link
	if (get_next_posts_link()) {
		echo '<div class="pagination-link">';
		next_posts_link('<button class="join-item btn btn-sm md:btn-md">' . __('Next', 'oktheme') . '</button>');
		echo '</div>';
	}
	
	echo '</div>';
	echo '</nav>';
}

/**
 * Display excerpt with custom length
 */
function oktheme_excerpt($length = 55) {
	$excerpt = get_the_excerpt();
	if (strlen($excerpt) > $length) {
		$excerpt = substr($excerpt, 0, $length);
		$excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
		$excerpt .= '...';
	}
	return $excerpt;
}

