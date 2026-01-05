<?php

/**
 * 404 Not Found Template
 * 
 * Displays when a page is not found.
 * 
 * @package Xtremez
 * @since 1.0.0
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<main id="main-content" class="site-main">
  <div class="container">
    <section class="error-404 not-found">

      <header class="page-header">
        <h1 class="page-title"><?php esc_html_e('Oops! That page cannot be found.', 'xtremez'); ?></h1>
      </header>

      <div class="page-content">
        <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'xtremez'); ?></p>

        <?php
        get_search_form([
          'echo' => true,
        ]);
        ?>

        <h2><?php esc_html_e('Most Used Categories', 'xtremez'); ?></h2>
        <ul>
          <?php
          wp_list_categories([
            'orderby'    => 'count',
            'order'      => 'DESC',
            'show_count' => 1,
            'title_li'   => '',
            'number'     => 10,
          ]);
          ?>
        </ul>

        <h2><?php esc_html_e('Recent Posts', 'xtremez'); ?></h2>
        <ul>
          <?php
          $recent_posts = wp_get_recent_posts([
            'numberposts' => 5,
            'post_status' => 'publish',
          ]);

          foreach ($recent_posts as $post) :
          ?>
            <li>
              <a href="<?php echo esc_url(get_permalink($post['ID'])); ?>">
                <?php echo esc_html($post['post_title']); ?>
              </a>
            </li>
          <?php
          endforeach;
          wp_reset_postdata();
          ?>
        </ul>
      </div>
    </section>
  </div>
</main>

<?php get_footer();
