<?php

/**
 * Search Results Template
 * 
 * Displays search results with filtering options.
 * 
 * @package Xtremez
 * @since 1.0.0
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<main id="main-content" class="site-main">
  <div class="container">

    <header class="search-header">
      <h1 class="search-title">
        <?php
        /* translators: %s: search query */
        printf(esc_html__('Search Results for: %s', 'xtremez'), '<span>' . get_search_query() . '</span>');
        ?>
      </h1>
    </header>

    <?php
    if (have_posts()) :
    ?>
      <div class="search-results">
        <?php
        while (have_posts()) :
          the_post();
        ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class('search-result'); ?>>

            <h2 class="result-title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>

            <div class="result-meta">
              <span class="result-date"><?php echo esc_html(get_the_date()); ?></span>
              <span class="result-type"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></span>
            </div>

            <div class="result-excerpt">
              <?php
              if (has_excerpt()) {
                the_excerpt();
              } else {
                echo wp_trim_words(get_the_content(), 50);
              }
              ?>
            </div>

            <a href="<?php the_permalink(); ?>" class="result-link">
              <?php esc_html_e('View Full Content', 'xtremez'); ?>
            </a>
          </article>
        <?php
        endwhile;
        ?>
      </div>

      <?php
      the_posts_pagination([
        'prev_text' => esc_html__('Previous', 'xtremez'),
        'next_text' => esc_html__('Next', 'xtremez'),
      ]);
      ?>
    <?php
    else :
    ?>
      <div class="no-results">
        <h2><?php esc_html_e('Nothing Found', 'xtremez'); ?></h2>
        <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'xtremez'); ?></p>

        <?php get_search_form(); ?>
      </div>
    <?php
    endif;
    ?>

  </div>
</main>

<?php get_footer();
