<?php

/**
 * Main Template File
 * 
 * This is the fallback template file displayed when no more specific template is found.
 * It serves as the default template for all post types and archives.
 * 
 * @package Xtremez
 * @since 1.0.0
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<main id="main-content" class="site-main">
  <div class="container">

    <?php
    if (have_posts()) :
    ?>
      <div class="posts-list">
        <?php
        while (have_posts()) :
          the_post();
        ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>

            <?php if (has_post_thumbnail()) : ?>
              <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium'); ?>
                </a>
              </div>
            <?php endif; ?>

            <div class="post-content">
              <h2 class="post-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>

              <div class="post-meta">
                <span class="post-date"><?php echo esc_html(get_the_date()); ?></span>
                <span class="post-author"><?php the_author(); ?></span>
              </div>

              <div class="post-excerpt">
                <?php
                if (has_excerpt()) {
                  the_excerpt();
                } else {
                  echo wp_trim_words(get_the_content(), 30);
                }
                ?>
              </div>

              <a href="<?php the_permalink(); ?>" class="read-more">
                <?php esc_html_e('Read More', 'xtremez'); ?>
              </a>
            </div>
          </article>
        <?php
        endwhile;
        ?>
      </div>

      <?php
      // Pagination
      the_posts_pagination([
        'prev_text' => esc_html__('Previous', 'xtremez'),
        'next_text' => esc_html__('Next', 'xtremez'),
      ]);
      ?>
    <?php
    else :
    ?>
      <div class="no-posts">
        <h2><?php esc_html_e('Nothing Found', 'xtremez'); ?></h2>
        <p><?php esc_html_e('Sorry, no posts found.', 'xtremez'); ?></p>
      </div>
    <?php
    endif;
    ?>

  </div>
</main>

<?php get_footer();
