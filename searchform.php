<?php
/**
 * Template for displaying search form
 *
 * @package OKTheme
 */

if (!defined('ABSPATH')) {
	exit;
}
?>

<form role="search" method="get" class="search-form flex items-center gap-2" action="<?php echo esc_url(home_url('/')); ?>">
	<label class="sr-only">
		<span class="screen-reader-text"><?php esc_html_e('Search for:', 'oktheme'); ?></span>
	</label>
	<div class="form-control">
		<div class="input-group">
			<input 
				type="search" 
				class="input input-bordered w-full max-w-xs focus:outline-none focus:ring-2 focus:ring-primary" 
				placeholder="<?php esc_attr_e('Search &hellip;', 'oktheme'); ?>" 
				value="<?php echo get_search_query(); ?>" 
				name="s" 
			/>
			<button type="submit" class="btn btn-primary btn-square">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
				</svg>
				<span class="screen-reader-text"><?php esc_html_e('Search', 'oktheme'); ?></span>
			</button>
		</div>
	</div>
</form>

