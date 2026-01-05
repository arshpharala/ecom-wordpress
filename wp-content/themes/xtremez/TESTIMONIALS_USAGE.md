<?php
/**
 * Testimonials Usage Examples
 * 
 * This file shows how to use the testimonials custom post type
 * in your theme templates and pages.
 * 
 * @package Xtremez
 * @since 1.0.0
 */

// ============================================
// EXAMPLE 1: Display testimonials in a grid
// ============================================

$testimonials = xtremez_get_testimonials(6);

if ($testimonials) {
  echo '<div class="testimonials-grid">';
  
  foreach ($testimonials as $testimonial) {
    $data = xtremez_get_testimonial_data($testimonial->ID);
    ?>

    <div class="testimonial-card">
      <?php if ($data['image']) : ?>
        <div class="testimonial-image">
          <img src="<?php echo esc_url($data['image']); ?>" alt="<?php echo esc_attr($data['name']); ?>">
        </div>
      <?php endif; ?>

      <?php if ($data['logo']) : ?>
        <div class="testimonial-logo">
          <img src="<?php echo esc_url($data['logo']); ?>" alt="<?php echo esc_attr($data['position']); ?>">
        </div>
      <?php endif; ?>

      <div class="testimonial-content">
        <p class="testimonial-text"><?php echo wp_kses_post($data['text']); ?></p>

        <div class="testimonial-author">
          <strong><?php echo esc_html($data['name']); ?></strong>
          <span class="testimonial-position"><?php echo esc_html($data['position']); ?></span>
        </div>
      </div>
    </div>
    <?php

}

echo '</div>';
}

// ============================================
// EXAMPLE 2: Display testimonials carousel
// ============================================

$testimonials = xtremez_get_testimonials(10);

if ($testimonials) {
echo '<div class="testimonials-carousel">';

foreach ($testimonials as $testimonial) {
    $data = xtremez_get_testimonial_data($testimonial->ID);
?>
<div class="carousel-item">
<div class="quote-icon">"</div>
<p class="testimonial-text"><?php echo wp_kses_post($data['text']); ?></p>

      <div class="testimonial-footer">
        <?php if ($data['image']) : ?>
          <img src="<?php echo esc_url($data['image']); ?>" alt="<?php echo esc_attr($data['name']); ?>" class="avatar">
        <?php endif; ?>

        <div>
          <strong><?php echo esc_html($data['name']); ?></strong>
          <div class="position"><?php echo esc_html($data['position']); ?></div>
        </div>
      </div>
    </div>
    <?php

}

echo '</div>';
}

// ============================================
// EXAMPLE 3: Get single testimonial by ID
// ============================================

$testimonial_id = 123; // Replace with actual post ID
$data = xtremez_get_testimonial_data($testimonial_id);

if ($data['text']) {
  echo '<blockquote class="testimonial">';
  echo '<p>' . wp_kses_post($data['text']) . '</p>';
echo '<footer>';
echo '<cite><strong>' . esc_html($data['name']) . '</strong>, ' . esc_html($data['position']) . '</cite>';
echo '</footer>';
echo '</blockquote>';
}

// ============================================
// EXAMPLE 4: Display featured testimonials
// ============================================

$featured = xtremez_get_testimonials(3);

if ($featured) {
echo '<section class="featured-testimonials">';
echo '<h2>What Our Clients Say</h2>';
echo '<div class="testimonials-container">';

foreach ($featured as $testimonial) {
    $data = xtremez_get_testimonial_data($testimonial->ID);

    $classes = ['testimonial-box'];
    if ($data['image']) $classes[] = 'has-image';
    if ($data['logo']) $classes[] = 'has-logo';
    ?>
    <div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
      <?php if ($data['logo']) : ?>
        <img src="<?php echo esc_url($data['logo']); ?>" alt="Logo" class="company-logo">
      <?php endif; ?>

      <p class="quote"><?php echo wp_kses_post($data['text']); ?></p>

      <div class="author-info">
        <?php if ($data['image']) : ?>
          <img src="<?php echo esc_url($data['image']); ?>" alt="<?php echo esc_attr($data['name']); ?>" class="author-image">
        <?php endif; ?>

        <div>
          <h4><?php echo esc_html($data['name']); ?></h4>
          <p><?php echo esc_html($data['position']); ?></p>
        </div>
      </div>
    </div>
    <?php

}

echo '</div>';
echo '</section>';
}

// ============================================
// EXAMPLE 5: Get testimonials with custom ordering
// ============================================

// Get testimonials ordered by date, descending (newest first)
$recent = xtremez_get_testimonials(5, 'date', 'DESC');

// Get testimonials ordered by menu order
$ordered = xtremez_get_testimonials(5, 'menu_order', 'ASC');

// ============================================
// HELPER FUNCTION REFERENCE
// ============================================

/\*\*

- Get all testimonials
-
- @param int $limit Default: -1 (all)
- @param string $orderby Default: 'menu_order'
- @param string $order Default: 'ASC'
- @return array Array of testimonial posts
  \*/
  // $testimonials = xtremez_get_testimonials();

/\*\*

- Get testimonial data
-
- Returns array with keys:
- - id (post ID)
- - title (post title)
- - image (featured image URL)
- - logo (company logo URL)
- - text (testimonial content)
- - name (person's name)
- - position (person's position)
-
- @param int $post_id The testimonial post ID
- @return array Testimonial data
  \*/
  // $data = xtremez_get_testimonial_data($post_id);

// ============================================
// AVAILABLE DATA FIELDS
// ============================================

/_
Array (
'id' => 123, // Post ID
'title' => 'Testimonial Title', // Post title
'image' => 'https://example.com/image.jpg', // Featured image URL
'logo' => 'https://example.com/logo.png', // Company logo URL
'text' => 'The testimonial quote...', // Testimonial text
'name' => 'John Doe', // Person's name
'position' => 'Marketing Manager at Acme', // Person's position
)
_/

// ============================================
// CSS STYLING REFERENCE
// ============================================

/\*
Suggested CSS classes for styling:

.testimonials-grid { }
.testimonial-card { }
.testimonial-image { }
.testimonial-logo { }
.testimonial-content { }
.testimonial-text { }
.testimonial-author { }
.testimonial-position { }

.testimonials-carousel { }
.carousel-item { }
.quote-icon { }
.testimonial-footer { }
.avatar { }

.testimonial { }
.testimonial blockquote { }
.testimonial cite { }

.featured-testimonials { }
.testimonials-container { }
.testimonial-box { }
.testimonial-box.has-image { }
.testimonial-box.has-logo { }
.company-logo { }
.quote { }
.author-info { }
.author-image { }
\*/
