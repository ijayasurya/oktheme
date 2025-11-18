<?php
/**
 * The main template file
 *
 * @package OKTheme
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>


<?php get_template_part('template-parts/feed-loop'); ?>

<?php
get_footer();

