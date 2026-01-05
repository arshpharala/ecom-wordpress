<?php

/**
 * Service Archive Template
 * 
 * Displays all services in a grid layout.
 * 
 * @package Xtremez
 * @since 1.0.0
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<main id="main-content" class="site-main">
  <div class="container">

    <header class="archive-header">
      <h1 class="archive-title"><?php post_type_archive_title(); ?></h1>

      <?php
      $post_type = get_post_type_object('service');
      if ($post_type && $post_type->description) :
      ?>
        <p class="archive-description"><?php echo esc_html($post_type->description); ?></p>
      <?php
      endif;
      ?>
    </header>

    <?php
    if (have_posts()) :
    ?>
      <div class="services-grid">
        <?php
        while (have_posts()) :
          the_post();
        ?>
          <div class="service-card">

            <?php if (has_post_thumbnail()) : ?>
              <div class="service-card-image">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium'); ?>
                </a>
              </div>
            <?php endif; ?>

            <div class="service-card-content">
              <h2 class="service-card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>

              <?php if (has_excerpt()) : ?>
                <div class="service-card-excerpt">
                  <?php the_excerpt(); ?>
                </div>
              <?php endif; ?>

              <a href="<?php the_permalink(); ?>" class="service-link">
                <?php esc_html_e('View Service', 'xtremez'); ?>
                <span class="arrow">→</span>
              </a>
            </div>
          </div>
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
      <div class="no-services">
        <h2><?php esc_html_e('No Services Found', 'xtremez'); ?></h2>
        <p><?php esc_html_e('Please check back soon.', 'xtremez'); ?></p>
      </div>
    <?php
    endif;
    ?>

  </div>
</main>

<?php get_footer();
