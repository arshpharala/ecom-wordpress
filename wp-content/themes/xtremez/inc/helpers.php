<?php

/**
 * Theme Helper Functions
 * 
 * Utility functions used throughout the Xtremez theme.
 * 
 * @package Xtremez
 * @since 1.0.0
 */

if (!defined('ABSPATH')) exit;

/**
 * Get the full URI for a theme asset.
 * 
 * @since 1.0.0
 * @param string $path Relative path to the asset file.
 * @return string Full URI to the asset file.
 */
function xtremez_asset(string $path): string
{
  return trailingslashit(get_stylesheet_directory_uri()) . 'assets/' . ltrim($path, '/');
}

/**
 * Get theme option value with default fallback.
 * 
 * @since 1.0.0
 * @param string $key Option key.
 * @param mixed $default Default value if not found.
 * @return mixed Option value or default.
 */
function xtremez_option(string $key, $default = '')
{
  $options = get_option('xtremez_settings', []);
  return isset($options[$key]) ? $options[$key] : $default;
}

/**
 * Check if a custom post type exists.
 * 
 * @since 1.0.0
 * @param string $post_type Post type slug.
 * @return bool True if post type is registered.
 */
function xtremez_post_type_exists(string $post_type): bool
{
  return post_type_exists($post_type);
}
