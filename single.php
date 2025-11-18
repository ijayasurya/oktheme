<?php
/**
 * Template for displaying single posts
 *
 * @package OKTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<?php while (have_posts()) : the_post(); ?>
<?php oktheme_breadcrumbs(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-card mb-12'); ?>>

    <!-- HEADER -->
    <header class="fb-article-headblock space-y-3 mx-auto py-6">

        <!-- TITLE -->
        <h1 class="fb-article-mainheading text-2xl sm:text-3xl md:text-3xl font-extrabold leading-tight">
            <?php the_title(); ?>
        </h1>

        <!-- SYNOPSIS / EXCERPT -->
        <?php if (has_excerpt()) : ?>
            <div class="synopsis py-1">
                <p><?php the_excerpt(); ?></p>
            </div>
        <?php endif; ?>

        

        <!-- Hidden author (legacy) -->
        <div class="io-author hidden">
            -<?php the_author(); ?>
        </div>

        <div class="flex justify-between place-content-center items-center">

        
        <!-- AUTHOR + UPDATED TIME BLOCK -->
        <div class="fb-article-publish flex   flex-col  gap-2">

            <!-- AUTHOR -->
            <div class=" author-profile written-by sm:text-base">
                By 
                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                   class="ml-1 font-semibold hover:underline"
                   target="_blank">
                    <strong><?php the_author(); ?></strong>
                </a>
            </div>

           <!-- UPDATED OR PUBLISHED TIME -->
<div>
    <?php
    $modified_time  = get_the_modified_time('U');
    $published_time = get_the_time('U');

    // Get timezone abbreviation (IST, EST, etc.)
    $timezone_abbr_modified  = date_i18n('T', $modified_time);
    $timezone_abbr_published = date_i18n('T', $published_time);

    if ($modified_time !== $published_time) :
    ?>
        <time datetime="<?php echo esc_attr(get_the_modified_time('c')); ?>">
            Updated: <strong><?php echo esc_html(get_the_modified_time('l, F j, Y, H:i')); ?>
            <?php echo esc_html($timezone_abbr_modified); ?></strong>
        </time>
    <?php else : ?>
        <time datetime="<?php echo esc_attr(get_the_time('c')); ?>">
            Published: <strong><?php echo esc_html(get_the_time('l, F j, Y, H:i')); ?>
            <?php echo esc_html($timezone_abbr_published); ?></strong>
        </time>
    <?php endif; ?>
</div>



        </div>
        
        </div>
    </header>

<?php if (has_post_thumbnail()) : ?>
    <?php 
        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $caption = wp_get_attachment_caption(get_post_thumbnail_id());
    ?>

    <?php if ($img_url) : ?>
        <figure class="featured-image md:p-10">
            <img loading="lazy" src="<?php echo esc_url($img_url); ?>" 
                 alt="<?php echo esc_attr(get_the_title()); ?>"
                 class="w-full h-auto rounded-xl object-cover" />

            <?php if ($caption) : ?>
                <figcaption class="text-xs text-gray-500 mt-2 italic">
                    <?php echo esc_html($caption); ?>
                </figcaption>
            <?php endif; ?>
        </figure>
    <?php endif; ?>

<?php endif; ?>

<?php oktheme_display_ad('before_post'); ?>


    <!-- CONTENT -->
    <div class="entry-content prose prose-lg max-w-none 
        prose-headings:text-base-content
        prose-p:text-base-content 
        prose-a:link
        prose-a:link-info
		prose-a:text-secondary
		dark:prose-a:text-info
        prose-hr:mb-5
        prose-hr:mt-0
        prose-strong:text-base-content 
        prose-code:text-base-content 
        prose-pre:bg-base-200 
        prose-blockquote:border-primary">

        <?php
        the_content(
            sprintf(
                wp_kses(
                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'oktheme'),
                    ['span' => ['class' => []]]
                ),
                wp_kses_post(get_the_title())
            )
        );

        wp_link_pages([
            'before' => '<div class="page-links mt-8 flex gap-2 flex-wrap">' . esc_html__('Pages:', 'oktheme'),
            'after'  => '</div>',
        ]);
        ?>
    </div>

    <!-- FOOTER -->
    <footer class="entry-footer space-y-4 border-base-300">
        <?php get_template_part( 'template-parts/author-box' ); ?>

    </footer>

</article>



<?php endwhile; ?>

<?php get_footer(); ?>
