<?php
/**
 * The template for displaying comments
 *
 * @package OKTheme
 */

if (!defined('ABSPATH')) {
	exit;
}

if (post_password_required()) {
	return;
}
?>

<div id="comments" class="comments-area mt-8">
	<?php if (have_comments()) : ?>
		<h2 class="comments-title text-2xl font-bold mb-6">
			<?php
			$comment_count = get_comments_number();
			if ('1' === $comment_count) {
				printf(
					esc_html__('One thought on &ldquo;%1$s&rdquo;', 'oktheme'),
					'<span>' . wp_kses_post(get_the_title()) . '</span>'
				);
			} else {
				printf(
					esc_html(_n('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'oktheme')),
					number_format_i18n($comment_count),
					'<span>' . wp_kses_post(get_the_title()) . '</span>'
				);
			}
			?>
		</h2>

		<ol class="comment-list list-none space-y-6">
			<?php
			wp_list_comments(array(
				'style' => 'ol',
				'short_ping' => true,
				'callback' => 'oktheme_comment',
			));
			?>
		</ol>

		<?php
		the_comments_navigation();

		if (!comments_open()) :
			?>
			<p class="no-comments mt-6 text-gray-600"><?php esc_html_e('Comments are closed.', 'oktheme'); ?></p>
			<?php
		endif;

	endif;

	comment_form();
	?>
</div>

<?php
/**
 * Custom comment callback
 */
function oktheme_comment($comment, $args, $depth) {
	if ('div' === $args['style']) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment-body card bg-base-200 shadow p-4">
			<div class="comment-meta flex items-center mb-3">
				<div class="comment-author vcard">
					<?php
					if ($args['avatar_size'] != 0) {
						echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'rounded-full mr-3'));
					}
					?>
					<cite class="fn font-semibold"><?php comment_author_link(); ?></cite>
				</div>
				<div class="comment-metadata ml-auto text-sm text-gray-600">
					<a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
						<time datetime="<?php comment_time('c'); ?>">
							<?php
							printf(
								esc_html__('%1$s at %2$s', 'oktheme'),
								get_comment_date(),
								get_comment_time()
							);
							?>
						</time>
					</a>
					<?php edit_comment_link(esc_html__('(Edit)', 'oktheme'), '  ', ''); ?>
				</div>
			</div>

			<?php if ($comment->comment_approved == '0') : ?>
				<em class="comment-awaiting-moderation text-sm text-yellow-600"><?php esc_html_e('Your comment is awaiting moderation.', 'oktheme'); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-content text-gray-700">
				<?php comment_text(); ?>
			</div>

			<div class="reply mt-3">
				<?php
				comment_reply_link(array_merge($args, array(
					'add_below' => $add_below,
					'depth' => $depth,
					'max_depth' => $args['max_depth'],
					'class' => 'text-sm link link-primary',
				)));
				?>
			</div>
		</div>
	<?php
}

