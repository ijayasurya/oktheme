<?php if ( have_posts() ) : ?>

<?php
// Get current page number
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// Build dynamic title
if ( is_home() || is_front_page() ) {
    $title = 'Recent';
}
elseif ( is_category() ) {
    $title = single_cat_title('', false);
}
elseif ( is_tag() ) {
    $title = 'Tag: ' . single_tag_title('', false);
}
elseif ( is_search() ) {
    $title = 'Search: ' . esc_html( get_search_query() );
}
elseif ( is_author() ) {
    $author = get_queried_object();
    $title = 'Author: ' . esc_html( $author->display_name );
}
elseif ( is_archive() ) {
    $title = get_the_archive_title();
}
else {
    $title = 'Recent';
}

// Add page number if paginated
if ( $paged > 1 ) {
    $title .= ' – Page ' . $paged;
}
?>

<!-- OUTPUT -->
<div class="flex items-center mb-4">
  <h2 class="text-xl font-bold">
    <?php echo ( $title ); ?>
  </h2>
  <div class="flex-1 ml-3 h-px line"></div>
</div>

<div class="">
<?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" 
        class="flex flex-row p-2 border-b gap-3 sm:gap-4  place-items-center items-center bordernew ">

        <!-- Left: Image -->
        <figure class="post-thumbnail  flex-shrink-0 w-24 sm:w-32 md:w-40 lg:w-48 h-24 sm:h-28 md:h-32">
            <a aria-label="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail('medium', [
                        'class' => 'w-full h-full object-cover rounded',
                        'loading' => 'lazy',
                    ]); ?>
                <?php else : ?>
                    <img
                        data-src="placeholder.jpg"
                        src="<?php echo get_template_directory_uri(); ?>/img/default.png"
                        alt="<?php the_title_attribute(); ?>"
                        class="w-full h-full object-cover rounded"
                        loading="lazy"
                        onerror="this.onerror=null; this.src='<?php echo get_template_directory_uri(); ?>/img/default.png';"
                    />
                <?php endif; ?>
            </a>
        </figure>

        <!-- Right: Info -->
        <div class="flex-1 space-y-1 sm:space-y-2 min-w-0">
            <?php
            $categories = get_the_category();
            if ( ! empty( $categories ) ) {
                echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="badge badge-ghost text-xs">';
                echo esc_html( $categories[0]->name );
                echo '</a>';
            }
            ?>
            
            <?php the_title(
                '<h2 class="text-base sm:text-lg font-semibold leading-snug hover:underline cursor-pointer line-clamp-2"><a href="' . esc_url(get_permalink()) . '">',
                '</a></h2>'
            ); ?>

            <p class="text-xs sm:text-sm opacity-70">
               <time class="published" datetime="<?php echo get_the_date( 'c' ); ?>">
    <?php echo get_the_date( 'F j, Y' ); ?>
</time>
            </p>
        </div>
    </article>

<?php endwhile; ?>
</div>

<?php oktheme_pagination(); ?>

<?php else : ?>
    <p>No posts found.</p>
<?php endif; ?>