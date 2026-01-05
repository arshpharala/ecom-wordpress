<?php

/**
 * Testimonials Custom Post Type
 * 
 * Simplified testimonials CPT with core fields:
 * 1. Title (person's name)
 * 2. Excerpt (testimonial quote)
 * 3. Featured Image (person's photo)
 * 4. Company Logo (metabox)
 * 5. Position (job title, metabox)
 * 
 * @package Xtremez
 * @since 1.0.0
 */

if (!defined('ABSPATH')) exit;

/**
 * Register Testimonials Post Type
 * Clean UI - no custom fields, minimal supports
 * 
 * @since 1.0.0
 */
add_action('init', function () {
  $labels = [
    'name'               => __('Testimonials', 'xtremez'),
    'singular_name'      => __('Testimonial', 'xtremez'),
    'add_new'            => __('Add New', 'xtremez'),
    'add_new_item'       => __('Add New Testimonial', 'xtremez'),
    'edit_item'          => __('Edit Testimonial', 'xtremez'),
    'new_item'           => __('New Testimonial', 'xtremez'),
    'view_item'          => __('View Testimonial', 'xtremez'),
    'search_items'       => __('Search Testimonials', 'xtremez'),
    'not_found'          => __('No testimonials found', 'xtremez'),
    'not_found_in_trash' => __('No testimonials found in Trash', 'xtremez'),
    'menu_name'          => __('Testimonials', 'xtremez'),
  ];

  register_post_type('testimonial', [
    'labels'             => $labels,
    'public'             => false,
    'show_ui'            => true,
    'show_in_rest'       => true,
    'has_archive'        => false,
    'menu_position'      => 21,
    'menu_icon'          => 'dashicons-format-quote',
    'supports'           => ['title', 'thumbnail', 'excerpt'], // Added excerpt support
    'rewrite'            => false,
    'publicly_queryable' => false,
  ]);
});

/**
 * Hide unwanted metaboxes and add custom ones
 * 
 * @since 1.0.0
 */
add_action('add_meta_boxes', function () {
  // Remove custom fields metabox
  remove_meta_box('postcustom', 'testimonial', 'normal');

  // Add Logo metabox (sidebar)
  add_meta_box(
    'testimonial_logo',
    __('Company Logo', 'xtremez'),
    'xtremez_render_testimonial_logo_metabox',
    'testimonial',
    'side',
    'high'
  );

  // Add Position metabox (main content)
  add_meta_box(
    'testimonial_position',
    __('Position in Company', 'xtremez'),
    'xtremez_render_testimonial_position_metabox',
    'testimonial',
    'normal',
    'high'
  );
});

/**
 * Render Company Logo Metabox
 * Media uploader for company logo
 * 
 * @since 1.0.0
 * @param WP_Post $post The post object
 */
function xtremez_render_testimonial_logo_metabox($post)
{
  wp_nonce_field('xtremez_testimonial_nonce', '_testimonial_nonce');

  $logo_id = get_post_meta($post->ID, '_testimonial_logo_id', true);
  $logo_url = $logo_id ? wp_get_attachment_url($logo_id) : '';

  echo '<div class="testimonial-logo-wrapper">';

  if ($logo_url) {
    echo '<div class="testimonial-logo-preview" style="margin-bottom: 10px;">';
    echo '<img src="' . esc_url($logo_url) . '" alt="Logo" style="max-width: 100%; height: auto;">';
    echo '</div>';
  }

  echo '<input type="hidden" id="testimonial_logo_id" name="testimonial_logo_id" value="' . esc_attr($logo_id) . '">';
  echo '<button type="button" class="button button-primary button-block" id="upload_logo_btn">' . esc_html__('Upload Logo', 'xtremez') . '</button>';

  if ($logo_id) {
    echo '<button type="button" class="button button-secondary button-block" id="remove_logo_btn" style="margin-top: 5px;">' . esc_html__('Remove Logo', 'xtremez') . '</button>';
  }

  echo '</div>';

  ob_start();
?>
  <script>
    jQuery(function($) {
      var logoFrame;

      $('#upload_logo_btn').on('click', function(e) {
        e.preventDefault();

        if (logoFrame) {
          logoFrame.open();
          return;
        }

        logoFrame = wp.media({
          title: '<?php esc_attr_e('Select Company Logo', 'xtremez'); ?>',
          button: {
            text: '<?php esc_attr_e('Use This Logo', 'xtremez'); ?>'
          },
          multiple: false
        });

        logoFrame.on('select', function() {
          var attachment = logoFrame.state().get('selection').first().toJSON();
          $('#testimonial_logo_id').val(attachment.id);

          var preview = '<div class="testimonial-logo-preview" style="margin-bottom: 10px;"><img src="' + attachment.url + '" alt="Logo" style="max-width: 100%; height: auto;"></div>';
          $('.testimonial-logo-preview').remove();
          $('.testimonial-logo-wrapper').prepend(preview);

          if ($('#remove_logo_btn').length === 0) {
            $('#upload_logo_btn').after('<button type="button" class="button button-secondary button-block" id="remove_logo_btn" style="margin-top: 5px;"><?php esc_attr_e('Remove Logo', 'xtremez'); ?></button>');
          }
        });

        logoFrame.open();
      });

      $(document).on('click', '#remove_logo_btn', function(e) {
        e.preventDefault();
        $('#testimonial_logo_id').val('');
        $('.testimonial-logo-preview').remove();
        $('#remove_logo_btn').remove();
      });
    });
  </script>
<?php
  echo ob_get_clean();
}

/**
 * Render Person Position Metabox
 * Simple field for job title and company
 * 
 * @since 1.0.0
 * @param WP_Post $post The post object
 */
function xtremez_render_testimonial_position_metabox($post)
{
  $position = get_post_meta($post->ID, '_testimonial_position', true);

  echo '<label for="testimonial_position" style="display: block; margin-bottom: 8px; font-weight: 600;">' . esc_html__('Job Title & Company', 'xtremez') . '</label>';
  echo '<input type="text" id="testimonial_position" name="testimonial_position" value="' . esc_attr($position) . '" class="widefat" placeholder="' . esc_attr__('e.g., Brand Manager at Acme Corp', 'xtremez') . '">';
  echo '<p style="color: #666; font-size: 12px; margin-top: 8px;">' . esc_html__('Enter the person\'s job title and company name.', 'xtremez') . '</p>';
}

/**
 * Save Testimonial Metabox Data
 * Secure saving with nonce verification and sanitization
 * 
 * @since 1.0.0
 * @param int $post_id The post ID
 */
add_action('save_post_testimonial', function ($post_id) {
  // Verify nonce
  if (!isset($_POST['_testimonial_nonce']) || !wp_verify_nonce($_POST['_testimonial_nonce'], 'xtremez_testimonial_nonce')) {
    return;
  }

  // Avoid autosave
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  // Check user capability
  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  // Save logo ID
  if (isset($_POST['testimonial_logo_id'])) {
    $logo_id = absint($_POST['testimonial_logo_id']);
    if ($logo_id) {
      update_post_meta($post_id, '_testimonial_logo_id', $logo_id);
    } else {
      delete_post_meta($post_id, '_testimonial_logo_id');
    }
  }

  // Save position
  if (isset($_POST['testimonial_position'])) {
    $position = sanitize_text_field($_POST['testimonial_position']);
    if ($position) {
      update_post_meta($post_id, '_testimonial_position', $position);
    } else {
      delete_post_meta($post_id, '_testimonial_position');
    }
  }
});

/**
 * Helper function to get testimonials
 * 
 * Usage: $testimonials = xtremez_get_testimonials(6);
 * 
 * @since 1.0.0
 * @param int $limit Number of testimonials to retrieve
 * @param string $orderby How to order testimonials (default: 'menu_order')
 * @param string $order Order direction (default: 'ASC')
 * @return array Array of testimonial posts
 */
function xtremez_get_testimonials($limit = -1, $orderby = 'menu_order', $order = 'ASC')
{
  return get_posts([
    'post_type'      => 'testimonial',
    'posts_per_page' => $limit,
    'orderby'        => $orderby,
    'order'          => $order,
    'post_status'    => 'publish',
  ]);
}

/**
 * Helper function to get testimonial data
 * 
 * Usage: $data = xtremez_get_testimonial_data($post_id);
 * 
 * Returns data from:
 * - name: Post title (set in main editor)
 * - text: Post excerpt (set in excerpt field)
 * - image: Featured image
 * - logo: Logo metabox
 * - position: Position metabox
 * 
 * @since 1.0.0
 * @param int $post_id The testimonial post ID
 * @return array Testimonial data
 */
function xtremez_get_testimonial_data($post_id)
{
  $post = get_post($post_id);
  $image_id = get_post_thumbnail_id($post_id);
  $logo_id = get_post_meta($post_id, '_testimonial_logo_id', true);
  $position = get_post_meta($post_id, '_testimonial_position', true);

  return [
    'id'       => $post_id,
    'name'     => $post->post_title,           // Person's name from post title
    'text'     => $post->post_excerpt,        // Testimonial quote from excerpt
    'image'    => $image_id ? wp_get_attachment_url($image_id) : '',
    'logo'     => $logo_id ? wp_get_attachment_url($logo_id) : '',
    'position' => $position,
  ];
}
