<?php
if (!defined('ABSPATH')) exit;
get_header();

$opts = get_option('xtremez_settings', []);

$why = json_decode($opts['why_json'] ?? '[]', true);
if (!is_array($why)) $why = [];
?>
<main class="mainBody">

  <main class="headHero bg-black">
    <section class="hero">
      <div class="container">
        <div class="hero-content">
          <h1 class="hero-title font-zum">ELEVATE YOUR BRAND WITH <span class="highlight">XTREMEZ</span></h1>
        </div>

        <div class="hero-info">
          <p class="hero-description">Your Partner for Digital Marketing, Creative Design, and Engaging Experiences.</p>
          <div class="hero-buttons">
            <?php $wa = $opts['whatsapp'] ?? ''; ?>
            <a href="<?php echo esc_url($wa ? 'https://wa.me/' . preg_replace('/\D+/', '', $wa) : '#'); ?>" target="_blank" rel="noopener">
              <div class="btn-white">GET A QUOTE</div>
            </a>
            <a href="#services">
              <div class="btn-white-outline">EXPLORE SERVICES</div>
            </a>
          </div>
        </div>
      </div>

      <div class="hero-image">
        <img src="<?php echo esc_url(xtremez_asset('images/banner.webp')); ?>" class="img-fluid monkey-img" alt="">
        <img src="<?php echo esc_url(xtremez_asset('images/banner.webp')); ?>" class="img-fluid monkey-sm-img" alt="">
      </div>
    </section>
  </main>

  <!-- Crossed Bars: repeat service titles from CPT -->
  <?php
  $services = get_posts([
    'post_type'      => 'service',
    'post_status'    => 'publish',
    'posts_per_page' => 20,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
  ]);
  ?>
  <section class="crossed-bars">
    <div class="bg-black bar bar-1">
      <div class="bar-content">
        <?php for ($i = 0; $i < 2; $i++): ?>
          <?php foreach ($services as $s): ?>
            <span><?php echo esc_html(get_the_title($s)); ?></span>
          <?php endforeach; ?>
        <?php endfor; ?>
      </div>
    </div>

    <div class="bg-primary bar bar-2">
      <div class="bar-content">
        <?php for ($i = 0; $i < 2; $i++): ?>
          <?php foreach ($services as $s): ?>
            <span><?php echo esc_html(get_the_title($s)); ?></span>
          <?php endforeach; ?>
        <?php endfor; ?>
      </div>
    </div>
  </section>

  <!-- About (static for now; later we can move to page content or settings) -->
  <section class="about" id="about-us">
    <div class="container">
      <div class="about-content">
        <div class="about-left">
          <h3 class="about-subtitle orange-i-text">ENGAGEMENT, GROWTH, EXCELLENCE</h3>
          <h2 class="about-title section-heading">
            ABOUT <span><img src="<?php echo esc_url(xtremez_asset('images/smile.webp')); ?>" alt="About Xtremez" /></span>XTREMEZ
          </h2>
          <a href="#services">
            <div class="btn-primary">EXPLORE SERVICES</div>
          </a>
        </div>

        <div class="about-right">
          <h2 class="about-heading">WHO WE ARE</h2>
          <p class="about-description">
            For the past 7 years, Xtremez has been a catalyst for growth, helping businesses dominate the digital landscape. As strategic partners, we craft integrated solutions in digital marketing, creative design, and experiential events that deliver measurable results. From data-driven social media campaigns and bespoke web experiences to immersive event environments, we turn your vision into tangible success. At Xtremez, we innovate, strategize, and collaborate to unlock your brand's full potential.
          </p>
        </div>
      </div>

      <!-- Keep your stats as-is -->
      <!-- (Your original stats markup can remain unchanged; omitted here for brevity) -->
    </div>
  </section>

</main>

<!-- Services section (CPT-driven) -->
<section class="service-spectrum" id="services">
  <div class="container">
    <div class="service-header">
      <div class="service-header-left">
        <span class="service-subtitle orange-i-text">ENGAGEMENT, GROWTH, EXCELLENCE</span>
        <h2 class="service-title section-heading">SERVICE SPECTRUM</h2>
      </div>
      <div class="service-header-right">
        <p class="service-description">
          Unleash your digital potential with Xtremez. We are a premier digital agency where innovation meets expertise. Our integrated team of talented developers, visionary designers, and astute strategists specializes in crafting bespoke, high-performance digital solutions that resonate with your audience, amplify your brand, and propel your business towards unparalleled growth and achievement.
        </p>
      </div>
    </div>

    <div class="service-list">
      <?php foreach ($services as $s): ?>
        <div class="service-item">
          <div class="service-icon">
            <div class="service-icon">
              <img src="<?php echo esc_url(xtremez_asset('images/electric.webp')); ?>" alt="icon" />
            </div>
          </div>

          <h3><?php echo esc_html(get_the_title($s)); ?></h3>

          <p>
            <?php
            $excerpt = has_excerpt($s) ? $s->post_excerpt : wp_trim_words(wp_strip_all_tags($s->post_content), 28);
            echo esc_html($excerpt);
            ?>
          </p>

          <a class="service-arrow" href="<?php echo esc_url(get_permalink($s)); ?>">
            <img src="<?php echo esc_url(xtremez_asset('images/rounded-arrow.png')); ?>" alt="arrow" />
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Why Choose (settings JSON-driven) -->
<section class="why-choose">
  <div class="container">
    <div class="why-choose-header">
      <div class="why-choose-left">
        <p>
          Xtremez is a leading digital agency of skilled developers, creative designers, and strategic visionaries. We create impactful, user-centric digital experiences that engage audiences and drive our clients' growth and success.
        </p>
      </div>
      <div class="why-choose-right">
        <span class="subtitle orange-i-text">ENGAGEMENT, GROWTH, EXCELLENCE</span>
        <h2 class="title section-heading">WHY CHOOSE XTREMEZ?</h2>
      </div>
    </div>

    <div class="features-grid">
      <?php foreach ($why as $feature): ?>
        <?php
        $icon = $feature['icon'] ?? '';
        $iconUrl = $icon ? xtremez_asset($icon) : '';
        ?>
        <div class="feature-item">
          <div class="feature-icon">
            <?php if ($iconUrl): ?>
              <img src="<?php echo esc_url($iconUrl); ?>" alt="<?php echo esc_attr($feature['title'] ?? ''); ?> icon" />
            <?php endif; ?>
          </div>
          <h3><?php echo esc_html($feature['title'] ?? ''); ?></h3>
          <p><?php echo esc_html($feature['short_description'] ?? ''); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
$testimonials = get_posts([
  'post_type'      => 'testimonial',
  'post_status'    => 'publish',
  'posts_per_page' => 20,
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
]);
?>

<section class="testimonials">
  <div class="container">
    <div class="testimonial-slide">
      <div class="testimonial-content">
        <?php if (!empty($testimonials)): ?>
          <?php foreach ($testimonials as $index => $testimonial): ?>
            <?php $data = xtremez_get_testimonial_data($testimonial->ID); ?>
            <div class="testimonial-item" style="display: <?php echo $index === 0 ? 'flex' : 'none'; ?>;">
              <div class="testimonial-image">
                <?php if ($data['image']): ?>
                  <img src="<?php echo esc_url($data['image']); ?>" alt="<?php echo esc_attr($data['name']); ?>" />
                <?php else: ?>
                  <img src="<?php echo esc_url(xtremez_asset('images/placeholder.webp')); ?>" alt="Client testimonial" />
                <?php endif; ?>
              </div>
              <div class="testimonial-info">
                <div class="testimonial-info-content">
                  <?php if ($data['logo']): ?>
                    <img src="<?php echo esc_url($data['logo']); ?>" alt="Company logo" class="testimonial-logo" style="max-width: 100px; height: auto; margin-bottom: 15px;" />
                  <?php endif; ?>
                  <p class="testimonial-text"><?php echo esc_html($data['text']); ?></p>
                  <div class="testimonial-author">
                    <h2 class="testimonial-name"><?php echo esc_html($data['name']); ?></h2>
                    <h3 class="testimonial-desg"><?php echo esc_html($data['position']); ?></h3>
                  </div>
                </div>
                <div class="testimonial-nav">
                  <button class="nav-btn prev" aria-label="Previous testimonial">
                    <svg width="20" height="34" viewBox="0 0 20 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M18 2L3 17L18 32" stroke="black" stroke-width="4" />
                    </svg>
                  </button>
                  <button class="nav-btn next" aria-label="Next testimonial">
                    <svg width="20" height="34" viewBox="0 0 20 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M2 2L17 17L2 32" stroke="white" stroke-width="4" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="text-align: center; padding: 40px 0;"><?php esc_html_e('No testimonials available', 'xtremez'); ?></p>
        <?php endif; ?>
      </div>
    </div>
</section>

<!-- Newsletter (admin-post handler, nonce-based) -->
<section class="newsletter">
  <div class="container">
    <div class="newsletter-content">
      <div class="newsletter-left">
        <span class="newsletter-subtitle orange-i-text">ENGAGEMENT, GROWTH, EXCELLENCE</span>
        <h2 class="newsletter-title section-heading">STAY UP-TO-DATE WITH THE LATEST TRENDS</h2>
      </div>
      <div class="newsletter-right">
        <p class="newsletter-description">Subscribe to our newsletter and get 10% off your first project!</p>

        <form class="newsletter-form" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
          <input type="hidden" name="action" value="xtremez_subscribe">
          <?php wp_nonce_field('xtremez_nonce'); ?>
          <input type="email" name="email" placeholder="Email*" class="newsletter-input" required />
          <button type="submit" class="btn-black">
            SUBSCRIBE <img src="<?php echo esc_url(xtremez_asset('images/bsmall-arrow.svg')); ?>" alt="Arrow Icon" />
          </button>
        </form>

      </div>
    </div>
  </div>
</section>

<section class="cta" id="lets-talk">
  <div class="container">
    <div class="cta-content">
      <div class="cta-title-wrap">
        <h2 class="cta-title">READY TO TAKE YOUR</h2>
        <div class="cta-title-brand">
          BRAND
          <span class="eyes">
            <img src="<?php echo esc_url(xtremez_asset('images/eye.png')); ?>" alt="Eye Icon" class="img-fluid" />
          </span>
        </div>
        <h2 class="cta-title">TO THE NEXT LEVEL?</h2>
      </div>
      <div class="cta-left">
        <div class="eyes">
          <div class="eye">
            <div class="eyeball"></div>
          </div>
          <div class="eye">
            <div class="eyeball"></div>
          </div>
        </div>
        <div class="cta-button-wrap">
          <a href="#contact" class="">
            <div class="cta-button">
              <span>LETS TALK</span>
              <div class="cta-span">

                <span class="span1">LETS</span>
                <span class="span2">TALK </span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact -->
<section class="contact" id="contact">
  <div class="container">
    <div class="contact-content">
      <div class="contact-left">
        <div>
          <span class="contact-subtitle orange-i-text">ENGAGEMENT, GROWTH, EXCELLENCE</span>
          <h2 class="contact-title section-heading">CONTACT US!</h2>
        </div>

        <p class="contact-description">
          Ready to transform your vision into a digital reality? ...
        </p>

        <div class="contact-info">
          <div class="contact-item">
            <div class="contact-icon"><img src="<?php echo esc_url(xtremez_asset('images/electric.png')); ?>" alt="icon" /></div>
            <p class="office"><?php echo esc_html($opts['address'] ?? ''); ?></p>
          </div>

          <div class="contact-details">
            <div class="contact-item">
              <div class="contact-icon"><img src="<?php echo esc_url(xtremez_asset('images/whatsapp.png')); ?>" alt="whatsapp" /></div>
              <p class="office">
                <?php
                $wa = $opts['whatsapp'] ?? '';
                $waUrl = $wa ? 'https://wa.me/' . preg_replace('/\D+/', '', $wa) : '#';
                ?>
                <a href="<?php echo esc_url($waUrl); ?>" target="_blank" rel="noopener">
                  <?php echo esc_html($opts['phone'] ?? ''); ?>
                </a>
              </p>
            </div>

            <div class="contact-item">
              <div class="contact-icon"><img src="<?php echo esc_url(xtremez_asset('images/electric.png')); ?>" alt="email" /></div>
              <p class="office">
                <a href="mailto:<?php echo esc_attr($opts['email'] ?? ''); ?>">
                  <?php echo esc_html($opts['email'] ?? ''); ?>
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="contact-right">
        <form class="contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
          <input type="hidden" name="action" value="xtremez_contact">
          <?php wp_nonce_field('xtremez_nonce'); ?>

          <input type="text" name="name" placeholder="Name*" required />
          <input type="email" name="email" placeholder="Email*" required />
          <input type="tel" name="phone" placeholder="Phone Number*" required />
          <textarea name="message" placeholder="Message*" required rows="4"></textarea>

          <button type="submit" class="btn-black">
            SUBMIT NOW <img src="<?php echo esc_url(xtremez_asset('images/bsmall-arrow.svg')); ?>" alt="Arrow Icon" />
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>