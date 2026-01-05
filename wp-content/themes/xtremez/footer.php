<?php if (!defined('ABSPATH')) exit; ?>
<section class="campaignFooter">

  <section class="campaign">
    <div class="container">
      <img src="<?php echo esc_url(xtremez_asset('images/footerstart.webp')); ?>" alt="campaign" class="img-fluid campaignImg" />
    </div>
  </section>

  <?php
  $opts = get_option('xtremez_settings', []);
  $social = json_decode($opts['social_json'] ?? '[]', true);
  if (!is_array($social)) $social = [];
  ?>
  <section class="social">
    <div class="container">
      <?php foreach ($social as $platform): ?>
        <?php
        $link = $platform['link'] ?? '#';
        $icon = $platform['icon'] ?? '';
        $alt  = $platform['platform'] ?? '';
        $iconUrl = $icon ? xtremez_asset($icon) : '';
        ?>
        <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener">
          <?php if ($iconUrl): ?>
            <img src="<?php echo esc_url($iconUrl); ?>" alt="<?php echo esc_attr($alt); ?>">
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
        <img src="<?php echo esc_url(xtremez_asset('images/logo.png')); ?>" alt="XTREMEZ" class="logo-footer img-fluid" />
      </a>

      <nav class="navbar">
        <?php
        wp_nav_menu([
          'theme_location' => 'footer',
          'container'      => false,
          'fallback_cb'    => '__return_false',
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

      <a href="<?php echo esc_url(home_url('/#contact')); ?>">
        <div class="btn-white">
          LETS TALK
          <img src="<?php echo esc_url(xtremez_asset('images/bsmall-arrow.svg')); ?>" alt="Arrow Icon" />
        </div>
      </a>
    </div>

    <div class="footer-copyright">
      © <span id="year"></span> XTREMEZ. All Rights Reserved.
    </div>
  </footer>

  <div class="footer-overlay">
    <img src="<?php echo esc_url(xtremez_asset('images/footer-circle.png')); ?>" alt="Footer Circle Icon" />
  </div>
</section>

<script>
  document.getElementById("year").textContent = new Date().getFullYear();
</script>

<?php wp_footer(); ?>
</body>

</html>