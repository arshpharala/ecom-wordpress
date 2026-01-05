<?php

/**
 * Single Service Template
 * 
 * Displays individual service posts with custom styling.
 * 
 * @package Xtremez
 * @since 1.0.0
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<main id="main-content" class="site-main">

  <?php
  if (have_posts()) :
    while (have_posts()) :
      the_post();
  ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('service-single'); ?>>

        <!-- Service Hero Section -->
        <?php if (has_post_thumbnail()) : ?>
          <section class="service-hero">
            <?php the_post_thumbnail('full'); ?>
          </section>
        <?php endif; ?>

        <!-- Service Content -->
        <section class="service-content">
          <div class="container">
            <h1 class="service-title"><?php the_title(); ?></h1>

            <?php if (has_excerpt()) : ?>
              <div class="service-excerpt">
                <?php the_excerpt(); ?>
              </div>
            <?php endif; ?>

            <div class="service-body">
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
        </section>

        <!-- Related Services -->
        <section class="related-services">
          <div class="container">
            <h2><?php esc_html_e('Other Services', 'xtremez'); ?></h2>

            <?php
            $related = get_posts([
              'post_type'      => 'service',
              'posts_per_page' => 3,
              'exclude'        => get_the_ID(),
              'orderby'        => 'menu_order',
              'order'          => 'ASC',
            ]);

            if ($related) :
            ?>
              <div class="related-grid">
                <?php
                foreach ($related as $post) :
                  setup_postdata($post);
                ?>
                  <div class="related-item">
                    <?php if (has_post_thumbnail()) : ?>
                      <div class="related-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                          <?php the_post_thumbnail('medium'); ?>
                        </a>
                      </div>
                    <?php endif; ?>

                    <h3 class="related-title">
                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                  </div>
                <?php
                endforeach;
                wp_reset_postdata();
                ?>
              </div>
            <?php
            endif;
            ?>
          </div>
        </section>

        <!-- Comments Section -->
        <?php
        if (comments_open() || get_comments_number()) :
          comments_template();
        endif;
        ?>
      </article>
  <?php
    endwhile;
  endif;
  ?>

</main>

<?php get_footer();
