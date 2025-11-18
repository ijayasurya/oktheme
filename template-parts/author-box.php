<div class="card  bg-base-100 border bordernew p-5 mt-8">
    <div class="flex flex-col md:flex-row md:items-center gap-4">

        <!-- Avatar -->
        <img
            class="w-20 h-20 rounded-full mx-auto md:mx-0"
            src="<?php echo get_avatar_url(get_the_author_meta('ID'), ['size' => 200]); ?>"
            alt="<?php echo esc_attr(get_the_author()); ?>"
        />

        <!-- Info -->
        <div class="text-center md:text-left">
            <a
                href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                class="font-semibold text-lg text-base-content hover:text-primary transition"
            >
                <?php echo get_the_author(); ?>
            </a>

            <?php if ( get_the_author_meta('description') ) : ?>
                <p class="text-sm text-base-content/70 mt-1">
                    <?php echo wp_kses_post(get_the_author_meta('description')); ?>
                </p>
            <?php else : ?>
                <p class="text-sm text-base-content/70 mt-1">Blogger & Full Stack Developer</p>
            <?php endif; ?>
        </div>

    </div>
</div>
<?php
// Get categories of current post
$categories = wp_get_post_categories(get_the_ID());

$args = [
    'category__in'   => $categories,
    'post__not_in'   => [get_the_ID()],
    'posts_per_page' => 3,
];

$related_query = new WP_Query($args);

if ($related_query->have_posts()) :
?>
<div class="mt-10">
<!-- OUTPUT -->
<div class="flex items-center mb-4">
  <h2 class="text-xl font-bold">
   Related Posts
  </h2>
  <div class="flex-1 ml-3 h-px line"></div>
</div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="card bg-base-100 transition border bordernew">
                <?php if (has_post_thumbnail()) : ?>
                    <figure>
                        <?php the_post_thumbnail('medium', ['class' => 'w-full h-40 object-cover']); ?>
                    </figure>
                <?php else : ?>
                    <figure>
                        <img src="<?php echo get_template_directory_uri(); ?>/img/default.png"
                             class="w-full h-40 object-cover"
                             alt="<?php the_title_attribute(); ?>">
                    </figure>
                <?php endif; ?>

                <div class="card-body p-4">
                    <h3 class="card-title text-base line-clamp-2">
                        <?php the_title(); ?>
                    </h3>
                </div>
            </a>
        <?php endwhile; ?>
    </div>
</div>

<?php
endif;
wp_reset_postdata();
?>
