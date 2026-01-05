<?php

/**
 * Xtremez Theme Bootstrap
 * 
 * This is the main theme file that initializes all theme functionality
 * through WordPress hooks. All core functionality is organized in the
 * `/inc` directory for better maintainability.
 * 
 * @package Xtremez
 * @version 1.0.0
 * @author Xtremez Development Team
 * @license GPL-2.0-or-later
 */

if (!defined('ABSPATH')) exit;

/**
 * Theme Constants
 * 
 * Define essential theme constants for use throughout the application.
 */
define('XTREMEZ_THEME_VERSION', '1.0.0');
define('XTREMEZ_THEME_DIR', get_stylesheet_directory());
define('XTREMEZ_THEME_URI', get_stylesheet_directory_uri());

/**
 * Load Theme Modules
 * 
 * Include all theme functionality files in order of dependency.
 * Each file is responsible for hooking its functions into WordPress.
 */

// Helper functions (no dependencies)
require_once XTREMEZ_THEME_DIR . '/inc/helpers.php';

// Theme setup and support
require_once XTREMEZ_THEME_DIR . '/inc/setup.php';

// Asset registration and enqueuing
require_once XTREMEZ_THEME_DIR . '/inc/enqueue.php';

// Custom post types registration
require_once XTREMEZ_THEME_DIR . '/inc/cpt-services.php';

// Testimonials custom post type
require_once XTREMEZ_THEME_DIR . '/inc/cpt-testimonials.php';

// Theme settings admin panel
require_once XTREMEZ_THEME_DIR . '/inc/settings.php';

// Form handlers and submissions
require_once XTREMEZ_THEME_DIR . '/inc/forms.php';

/**
 * Theme Setup Action
 * 
 * Fires when the theme is first loaded. Use this to perform
 * any initial theme setup that requires all modules to be loaded.
 * 
 * @since 1.0.0
 */
do_action('xtremez_theme_loaded');
