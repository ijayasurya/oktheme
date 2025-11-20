<?php
/**
 * The header template
 *
 * @package OKTheme
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="lofi" class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>

<body <?php body_class('antialiased'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="">


<header class="border-b bordernew   z-50 bg-base-100">

<!-- Proper Drawer (Mobile Only) -->
<div class="drawer">
  <input id="mobile-drawer" aria-label="mobile-drawer" aria-labelledby="mobile-drawer" type="checkbox" class="drawer-toggle" />

  <!-- NAVBAR CONTENT -->
  <div class="drawer-content flex flex-col">
    <div class="navbar max-w-6xl mx-auto">

      <!-- LEFT: HAMBURGER + LOGO -->
      <div class="navbar-start flex items-center gap-2">

        <!-- Hamburger ONLY Mobile -->
        <label for="mobile-drawer"  class="btn btn-ghost lg:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
               fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </label>

        <!-- Logo -->
        <?php
        $logo_id = get_theme_mod('custom_logo');

        if ($logo_id) {
            $logo_url = wp_get_attachment_image_url($logo_id, 'full');
            ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn dark:invert btn-ghost">
              <img width="100%" height="100px" src="<?php echo esc_url($logo_url); ?>"
                   alt="<?php bloginfo('name'); ?>"
                   class="h-8 w-auto" />
            </a>
            <?php
        } else { ?>
            <a href="<?php echo esc_url(home_url('/')); ?>"
               class="btn btn-ghost text-xl font-bold">
                <?php bloginfo('name'); ?>
            </a>
        <?php } ?>
      </div>
  <div class="navbar-center hidden lg:flex">
     <ul class="menu menu-horizontal px-1">
          <?php
          wp_nav_menu([
            'theme_location' => 'primary',
            'container' => false,
            'items_wrap' => '%3$s',
            'walker' => new OKTheme_Walker_Nav_Menu(),
            'fallback_cb' => false,
          ]);
          ?>
        </ul>
  </div>
      <!-- RIGHT: Desktop Navigation -->
      <div class="navbar-end gap-2 ">
         <form role="search" method="get" class="hidden lg:flex search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="input">
        <input 
            type="search" 
            class="search-field"
            placeholder="Search" 
            value="<?php echo get_search_query(); ?>" 
            name="s"
            required
        />
    </label>
</form>

       <!-- <button class="btn btn-square btn-ghost" aria-label="Theme Changer" data-toggle-theme="dark,light" data-act-class="ACTIVECLASS">
        
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=""><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path><path d="M12 3l0 18"></path><path d="M12 9l4.65 -4.65"></path><path d="M12 14.3l7.37 -7.37"></path><path d="M12 19.6l8.85 -8.85"></path></svg>

      </button> -->
     
      </div>
      


    </div>
  </div>

  <!-- DRAWER SIDEBAR (Mobile Only) -->
  <div class="drawer-side z-50 lg:hidden">
    <label for="mobile-drawer" aria-label="close sidebar"  class="drawer-overlay"></label>

    <aside class="menu p-4 w-80 min-h-full bg-base-100 border-r border-base-300">

      <!-- Drawer Header -->
      <div class="flex items-center justify-between mb-4">
        <span class="text-lg font-semibold">Menu</span>
        <label for="mobile-drawer" class="btn btn-sm btn-ghost">✕</label>
      </div>

      <!-- Search -->
      <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="mb-4">
        <label class="input input-bordered flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input name="s" type="text" placeholder="Search…" class="grow" />
        </label>
      </form>

      <!-- Mobile Menu -->
      <ul class="menu  w-full">
        <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'container' => false,
          'items_wrap' => '%3$s',
          'walker' => new OKTheme_Walker_Nav_Menu(),
          'fallback_cb' => false,
        ]);
        ?>
      </ul>
    </aside>
  </div>

</div>
</header>

<?php oktheme_display_ad('before_header'); ?>


	<div id="content" class="">
<?php
$is_full_page = $args['is_full_page'] ?? false;
?>

<?php if ($is_full_page): ?>
    <div class="container-box">
        <div class="w-full">
<?php else: ?>
    <div class="container-box grid w-full min-h-screen grid-cols-1 gap-10 p-4 lg:grid-cols-3">
        <div class="w-full lg:col-span-2">
<?php endif; ?>
