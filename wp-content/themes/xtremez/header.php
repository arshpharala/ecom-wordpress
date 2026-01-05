<?php if (!defined('ABSPATH')) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header class="header bg-black">
    <div class="container">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
        <img src="<?php echo esc_url(xtremez_asset('images/logo.png')); ?>" alt="XTREMEZ" class="logo-img img-fluid" />
      </a>

      <nav class="navbar">
        <button type="button" class="cross-btn">
          <img src="<?php echo esc_url(xtremez_asset('images/cross.svg')); ?>" alt="Menu Cross Icon" width="35" />
        </button>

        <?php
        // For your one-page anchors, create menu items as "Custom Links" in WP admin:
        // Home: /
        // About: /#about-us
        // Services: /#services
        // Contact: /#contact
        wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'fallback_cb'    => '__return_false',
          'menu_class'     => '',
          'items_wrap'     => '%3$s',
          'depth'          => 1,
          'walker'         => new class extends Walker_Nav_Menu {
            public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
            {
              $output .= '<div class="nav-item"><a class="nav-link" href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></div>';
            }
          }
        ]);
        ?>
      </nav>

      <button type="button" id="menu-btn" name="menu-btn">
        <img src="<?php echo esc_url(xtremez_asset('images/menu.png')); ?>" alt="Menu Icon" width="35" />
      </button>

      <?php $opts = get_option('xtremez_settings', []); ?>
      <?php $wa = $opts['whatsapp'] ?? ''; ?>
      <a href="<?php echo esc_url($wa ? 'https://wa.me/' . preg_replace('/\D+/', '', $wa) : '#'); ?>" class="lets-talk" target="_blank" rel="noopener">
        <div class="btn-white">
          LETS TALK
          <img src="<?php echo esc_url(xtremez_asset('images/bsmall-arrow.svg')); ?>" alt="Arrow Icon" />
        </div>
      </a>
    </div>
  </header>