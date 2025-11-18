<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package OKTheme
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header(null, ['is_full_page' => true]);
?>

<section class="min-h-screen flex flex-col items-center justify-center text-center p-6">
  <h1 class="text-7xl font-bold">404</h1>
  <p class="text-xl mt-2">Page not found</p>

  <p class=" mt-4 max-w-md">
    The page you're looking for doesn't exist or may have been moved.
  </p>

  <div class="mt-6 flex gap-3">
    <a href="/" class="btn btn-primary">Go Home</a>
  </div>
</section>



