<?php

/**
 * Comments Template
 * 
 * Displays comments and comment form for posts that support comments.
 * 
 * @package Xtremez
 * @since 1.0.0
 */

if (!defined('ABSPATH')) exit;

// Don't show comments if password protected and not authenticated
if (post_password_required()) {
  return;
}
?>

<div id="comments" class="comments-area">

  <?php if (have_comments()) : ?>
    <h2 class="comments-title">
      <?php
      $comment_count = get_comments_number();
      if (1 === $comment_count) {
        esc_html_e('1 Comment', 'xtremez');
      } else {
        printf(
          esc_html(_n('%s Comment', '%s Comments', $comment_count, 'xtremez')),
          intval($comment_count)
        );
      }
      ?>
    </h2>

    <ol class="comment-list">
      <?php
      wp_list_comments([
        'style'      => 'ol',
        'short_ping' => true,
      ]);
      ?>
    </ol>

    <?php
    the_comments_pagination([
      'prev_text' => esc_html__('Older Comments', 'xtremez'),
      'next_text' => esc_html__('Newer Comments', 'xtremez'),
    ]);
    ?>
  <?php endif; ?>

  <?php
  if (comments_open()) {
    comment_form([
      'title_reply' => esc_html__('Leave a Reply', 'xtremez'),
      'label_submit' => esc_html__('Post Comment', 'xtremez'),
    ]);
  } elseif (is_single() || is_page()) {
  ?>
    <p class="no-comments"><?php esc_html_e('Comments are closed.', 'xtremez'); ?></p>
  <?php
  }
  ?>
</div>