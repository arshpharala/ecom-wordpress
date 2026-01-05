<?php

/**
 * Page Template
 * 
 * Displays single pages with full-width layout.
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
      while (have_posts()) :
        the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>

          <?php if (has_post_thumbnail()) : ?>
            <div class="page-thumbnail">
              <?php the_post_thumbnail('full'); ?>
            </div>
          <?php endif; ?>

          <div class="page-content">
            <h1 class="page-title"><?php the_title(); ?></h1>

            <div class="page-body">
              <?php
              the_content();

              wp_link_pages([
                'before'      => '<div class="page-links">',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
              ]);
              ?>
            </div>
          </div>

          <?php
          // Comments section
          if (comments_open() || get_comments_number()) :
            comments_template();
          endif;
          ?>
        </article>
    <?php
      endwhile;
    endif;
    ?>
  </div>
</main>

<?php get_footer();
