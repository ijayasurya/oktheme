<?php
/**
 * The sidebar template
 *
 * @package OKTheme
 */

if (!defined('ABSPATH')) {
	exit;
}


?>

<aside id="secondary" class="space-y-4">


<?php if ( get_theme_mod('oktheme_trending_enable', false) ) : ?>

<?php 
  $trending_count = get_theme_mod('oktheme_trending_count', 5);

  $trending = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => $trending_count,
    'meta_key'       => 'views',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
    'post_status'    => 'publish',
  ]);
?>

<div class="lg:block sticky top-5 rounded bg-base-200 p-4">

  <div class="flex items-center mb-4">
    <h2 class="text-xl font-bold">Trending</h2>
    <div class="flex-1 ml-3 h-px  line"></div>
  </div>

  <div class="space-y-3">
  <?php if ( $trending->have_posts() ) : ?>
      <?php while ( $trending->have_posts() ) : $trending->the_post(); ?>
          <div>
            <h3 class="font-semibold hover:underline cursor-pointer">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>

            <p class="text-sm mt-1">
              <?php echo get_the_date('F j, Y'); ?>
            </p>
          </div>
      <?php endwhile; wp_reset_postdata(); ?>
  <?php endif; ?>
  </div>

</div>

<?php endif; ?>



  
<div class="sticky top-5 space-y-4">
		<?php dynamic_sidebar('sidebar-1'); ?>
	</div>
</aside><!-- #secondary -->

