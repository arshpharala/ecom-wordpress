<?php
if (!defined('ABSPATH')) exit;

// Create a private "enquiry" CPT to store form submissions (no plugin)
add_action('init', function () {
  register_post_type('xtremez_enquiry', [
    'labels' => [
      'name' => 'Enquiries',
      'singular_name' => 'Enquiry',
    ],
    'public' => false,
    'show_ui' => true,
    'menu_icon' => 'dashicons-email',
    'supports' => ['title'],
  ]);
});

// Newsletter submit
add_action('admin_post_nopriv_xtremez_subscribe', 'xtremez_handle_subscribe');
add_action('admin_post_xtremez_subscribe', 'xtremez_handle_subscribe');

function xtremez_handle_subscribe()
{
  if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'xtremez_nonce')) {
    wp_die('Invalid request.');
  }

  $email = sanitize_email($_POST['email'] ?? '');
  if (!$email || !is_email($email)) {
    wp_safe_redirect(home_url('/?subscribe=invalid'));
    exit;
  }

  wp_insert_post([
    'post_type'   => 'xtremez_enquiry',
    'post_status' => 'publish',
    'post_title'  => 'Newsletter: ' . $email,
    'meta_input'  => [
      'type'  => 'subscribe',
      'email' => $email,
    ],
  ]);

  wp_safe_redirect(home_url('/?subscribe=success'));
  exit;
}

// Contact submit
add_action('admin_post_nopriv_xtremez_contact', 'xtremez_handle_contact');
add_action('admin_post_xtremez_contact', 'xtremez_handle_contact');

function xtremez_handle_contact()
{
  if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'xtremez_nonce')) {
    wp_die('Invalid request.');
  }

  $name    = sanitize_text_field($_POST['name'] ?? '');
  $email   = sanitize_email($_POST['email'] ?? '');
  $phone   = sanitize_text_field($_POST['phone'] ?? '');
  $message = sanitize_textarea_field($_POST['message'] ?? '');

  if (!$name || !$email || !is_email($email) || !$phone || !$message) {
    wp_safe_redirect(home_url('/?contact=invalid'));
    exit;
  }

  wp_insert_post([
    'post_type'   => 'xtremez_enquiry',
    'post_status' => 'publish',
    'post_title'  => 'Contact: ' . $name . ' (' . $email . ')',
    'meta_input'  => [
      'type'    => 'contact',
      'name'    => $name,
      'email'   => $email,
      'phone'   => $phone,
      'message' => $message,
    ],
  ]);

  wp_safe_redirect(home_url('/?contact=success'));
  exit;
}
