<?php

/**
 * Asset Enqueue
 * 
 * Registers and enqueues all CSS and JavaScript files for the Xtremez theme.
 * 
 * @package Xtremez
 * @since 1.0.0
 */

if (!defined('ABSPATH')) exit;

/**
 * Enqueue frontend scripts and styles.
 * 
 * @since 1.0.0
 */
add_action('wp_enqueue_scripts', function () {

  // Main compiled stylesheet (generated from SCSS)
  $css_file = XTREMEZ_THEME_DIR . '/assets/dist/css/app.css';
  wp_enqueue_style(
    'xtremez-app',
    xtremez_asset('dist/css/app.css'),
    [],
    file_exists($css_file) ? filemtime($css_file) : XTREMEZ_THEME_VERSION
  );

  // WordPress bundled jQuery
  wp_enqueue_script('jquery');

  // SweetAlert2 library for notifications
  wp_enqueue_script(
    'sweetalert2',
    'https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js',
    [],
    '11.7.0',
    true
  );

  // Theme main JavaScript file
  $main_js = XTREMEZ_THEME_DIR . '/assets/dist/js/main.js';
  wp_enqueue_script(
    'xtremez-main',
    xtremez_asset('dist/js/main.js'),
    ['jquery'],
    file_exists($main_js) ? filemtime($main_js) : XTREMEZ_THEME_VERSION,
    true
  );

  // Form handler JavaScript
  $form_js = XTREMEZ_THEME_DIR . '/assets/dist/js/form.js';
  wp_enqueue_script(
    'xtremez-form',
    xtremez_asset('dist/js/form.js'),
    ['jquery', 'sweetalert2'],
    file_exists($form_js) ? filemtime($form_js) : XTREMEZ_THEME_VERSION,
    true
  );

  // Eyes animation JavaScript
  $eyes_js = XTREMEZ_THEME_DIR . '/assets/dist/js/eyes-animation.js';
  wp_enqueue_script(
    'xtremez-eyes',
    xtremez_asset('dist/js/eyes-animation.js'),
    [],
    file_exists($eyes_js) ? filemtime($eyes_js) : XTREMEZ_THEME_VERSION,
    true
  );

  // Pass theme settings to JavaScript
  $settings = get_option('xtremez_settings', []);
  wp_localize_script('xtremez-form', 'XTREMEZ', [
    'ajaxUrl' => admin_url('admin-post.php'),
    'nonce'   => wp_create_nonce('xtremez_nonce'),
    'contact' => [
      'address'  => isset($settings['address']) ? sanitize_text_field($settings['address']) : '',
      'phone'    => isset($settings['phone']) ? sanitize_text_field($settings['phone']) : '',
      'whatsapp' => isset($settings['whatsapp']) ? sanitize_text_field($settings['whatsapp']) : '',
      'email'    => isset($settings['email']) ? sanitize_email($settings['email']) : '',
    ],
  ]);
});

/**
 * Enqueue admin scripts and styles.
 * 
 * @since 1.0.0
 */
add_action('admin_enqueue_scripts', function () {
  wp_enqueue_style('wp-jquery-ui-dialog');
  wp_enqueue_script('jquery-ui-dialog');
});
