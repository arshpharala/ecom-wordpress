# Development Guide

## Getting Started

### Prerequisites

- PHP 7.4 or higher
- WordPress 5.0 or higher
- Node.js 14+ (for SCSS compilation)
- npm or yarn

### Setup

```bash
# 1. Navigate to theme directory
cd wp-content/themes/xtremez

# 2. Install dependencies
npm install

# 3. Start watching SCSS files
npm run watch:css
```

---

## Project Structure

### Directory Breakdown

**`inc/`** - Core functionality modules

- `setup.php` - Theme initialization and support
- `enqueue.php` - Script and style registration
- `helpers.php` - Utility functions
- `cpt-services.php` - Service post type registration
- `settings.php` - Admin settings panel
- `forms.php` - Form handling and validation

**`assets/src/scss/`** - SCSS source files

- `style.scss` - Main stylesheet (compile this)

**`assets/dist/`** - Compiled/minified assets

- `css/app.css` - Compiled stylesheet
- `js/main.js` - Main JavaScript
- `js/form.js` - Form handling script

**`assets/images/`** - Theme images

- `logo.png` - Main logo
- Banner images
- Icon files
- SVG graphics

**Root Templates**

- `index.php` - Fallback template
- `header.php` - Header template
- `footer.php` - Footer template
- `page.php` - Page template
- `single-service.php` - Single service template
- `archive-service.php` - Services archive template
- `search.php` - Search results
- `404.php` - 404 error page
- `comments.php` - Comments display

---

## Coding Standards

### PHP Style Guide

```php
<?php
/**
 * Function description
 *
 * Longer description if needed.
 *
 * @since 1.0.0
 * @param string $param Parameter description
 * @return type Return description
 */
function xtremez_my_function(string $param): string {
  // Implementation
  return 'result';
}
```

### Naming Conventions

- **Functions:** `xtremez_function_name()`
- **Hooks:** `xtremez_hook_name`
- **Classes:** `class Xtremez_Class_Name {}`
- **Constants:** `XTREMEZ_CONSTANT_NAME`
- **Variables:** `$variable_name`

### DocBlock Format

```php
/**
 * Short description
 *
 * Longer description if needed, explaining the purpose,
 * behavior, and any important notes.
 *
 * @since 1.0.0
 * @param string $param1 Description
 * @param array  $param2 Description
 * @return bool Whether the operation succeeded
 */
```

---

## Working with Hooks

### Action Hooks

Execute code at specific points:

```php
// Add action
add_action('wp_footer', 'xtremez_footer_scripts', 20);

// Remove action
remove_action('wp_footer', 'xtremez_footer_scripts');

// Execute action
do_action('xtremez_after_hero', $args);
```

### Filter Hooks

Modify data:

```php
// Add filter
add_filter('the_title', 'xtremez_modify_title', 10, 2);

// Apply filter
apply_filters('xtremez_service_title', $title, $post_id);

// Filter implementation
function xtremez_modify_title($title, $post_id) {
  if (get_post_type($post_id) === 'service') {
    return strtoupper($title);
  }
  return $title;
}
```

### Common Theme Hooks

```php
// After header
do_action('xtremez_after_header');

// Before footer
do_action('xtremez_before_footer');

// After service title
do_action('xtremez_after_service_title');

// Before services archive
do_action('xtremez_before_services_archive');
```

---

## SCSS Development

### Compilation

```bash
# Build once
npm run build:css

# Watch for changes
npm run watch:css

# View both variants
npm run build:css  # Creates minified
npm run watch:css  # Creates expanded for dev
```

### SCSS Structure

```scss
// Variable declaration
$primary-color: #ff6b35;
$font-stack: "Segoe UI", Tahoma, Geneva, Verdana;

// Mixins
@mixin flex-center {
	display: flex;
	justify-content: center;
	align-items: center;
}

// Media query
@media (max-width: 768px) {
	// Mobile styles
}

// Usage
.button {
	@include flex-center;
	background-color: $primary-color;
}
```

---

## Database Queries

### Using $wpdb

```php
global $wpdb;

// SELECT
$results = $wpdb->get_results(
  $wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE post_type = %s", 'service')
);

// INSERT
$wpdb->insert(
  $wpdb->posts,
  [
    'post_title' => $title,
    'post_content' => $content,
  ]
);

// UPDATE
$wpdb->update(
  $wpdb->posts,
  ['post_title' => $new_title],
  ['ID' => $post_id]
);

// DELETE
$wpdb->delete(
  $wpdb->posts,
  ['ID' => $post_id]
);
```

### WordPress Functions (Preferred)

```php
// Get post
$post = get_post($post_id);

// Insert post
$post_id = wp_insert_post([
  'post_title' => $title,
  'post_content' => $content,
  'post_type' => 'service',
]);

// Update post
wp_update_post([
  'ID' => $post_id,
  'post_title' => $new_title,
]);

// Get posts
$posts = get_posts([
  'post_type' => 'service',
  'posts_per_page' => 10,
]);
```

---

## Working with Custom Post Types

### Registering CPT

```php
add_action('init', function() {
  register_post_type('service', [
    'labels' => [
      'name' => 'Services',
      'singular_name' => 'Service',
    ],
    'public' => true,
    'show_in_rest' => true,
    'supports' => ['title', 'editor', 'thumbnail'],
    'menu_icon' => 'dashicons-admin-tools',
  ]);
});
```

### Querying CPT

```php
// Get all services
$services = get_posts([
  'post_type' => 'service',
  'posts_per_page' => -1,
]);

// Get single service
$service = get_post($post_id);
echo $service->post_title;

// Using WP_Query
$query = new WP_Query([
  'post_type' => 'service',
  'posts_per_page' => 10,
  'orderby' => 'menu_order',
  'order' => 'ASC',
]);
```

---

## Custom Metaboxes

### Register Metabox

```php
add_action('add_meta_boxes', function() {
  add_meta_box(
    'xtremez_service_details',
    'Service Details',
    'xtremez_service_details_callback',
    'service',
    'normal',
    'high'
  );
});

function xtremez_service_details_callback($post) {
  $price = get_post_meta($post->ID, 'service_price', true);
  ?>
  <input type="text" name="service_price" value="<?php echo esc_attr($price); ?>">
  <?php
}
```

### Save Metabox

```php
add_action('save_post_service', function($post_id) {
  if (isset($_POST['service_price'])) {
    update_post_meta($post_id, 'service_price', sanitize_text_field($_POST['service_price']));
  }
});
```

---

## JavaScript Development

### jQuery Usage

```javascript
jQuery(document).ready(function ($) {
	// DOM ready code

	// Selectors
	var elements = $(".xtremez-element");

	// Events
	elements.on("click", function () {
		console.log("Clicked!");
	});
});
```

### Using Theme Settings in JS

```javascript
// In form.js, XTREMEZ object is available
console.log(XTREMEZ.contact.email);
console.log(XTREMEZ.nonce);
console.log(XTREMEZ.ajaxUrl);
```

### AJAX Requests

```javascript
$.ajax({
	url: XTREMEZ.ajaxUrl,
	type: "POST",
	data: {
		action: "xtremez_contact",
		_wpnonce: XTREMEZ.nonce,
		name: name,
		email: email,
	},
	success: function (response) {
		console.log("Success!");
	},
	error: function () {
		console.log("Error occurred");
	},
});
```

---

## Adding New Features

### Step 1: Create Hook Point

In `functions.php` or relevant template:

```php
do_action('xtremez_custom_feature');
```

### Step 2: Document the Hook

Add comment above:

```php
/**
 * Fires after the hero section
 *
 * @since 1.0.0
 */
do_action('xtremez_after_hero');
```

### Step 3: Use in Child Theme

```php
add_action('xtremez_after_hero', function() {
  echo '<section class="custom-section">...</section>';
});
```

---

## Common Tasks

### Add a Settings Field

In `inc/settings.php`:

```php
<tr>
  <th><label><?php esc_html_e('New Setting', 'xtremez'); ?></label></th>
  <td>
    <input
      type="text"
      name="xtremez_settings[new_setting]"
      value="<?php echo esc_attr($opts['new_setting'] ?? ''); ?>"
      class="regular-text"
    >
  </td>
</tr>
```

### Add a Helper Function

In `inc/helpers.php`:

```php
/**
 * Get theme settings
 *
 * @since 1.0.0
 * @return array Theme settings
 */
function xtremez_get_settings(): array {
  return get_option('xtremez_settings', []);
}
```

### Add a Template Function

In `inc/helpers.php`:

```php
/**
 * Display hero banner
 *
 * @since 1.0.0
 */
function xtremez_display_hero() {
  get_template_part('template-parts/hero');
}
```

---

## Debugging Techniques

### Error Logging

```php
error_log('Debug info: ' . print_r($data, true));
```

### Variable Inspection

```php
wp_die('<pre>' . var_export($var, true) . '</pre>');
```

### Query Inspection

```php
if (WP_DEBUG) {
  global $wpdb;
  echo '<pre>';
  print_r($wpdb->queries);
  echo '</pre>';
}
```

### Browser Console

```javascript
console.log("Debug:", object);
console.table(array);
console.trace(); // Stack trace
```

---

## Performance Optimization

### Lazy Load Images

```html
<img src="image.jpg" loading="lazy" alt="Description" />
```

### Caching

```php
$cache_key = 'xtremez_services_' . get_current_blog_id();
$services = wp_cache_get($cache_key);

if (false === $services) {
  $services = get_posts(['post_type' => 'service']);
  wp_cache_set($cache_key, $services, '', 3600); // 1 hour
}
```

### Deferred Scripts

```php
wp_enqueue_script('xtremez-heavy', $url, [], false, true); // Load in footer
```

---

## Deployment Checklist

- [ ] All PHP validated
- [ ] No console errors
- [ ] No debug.log entries
- [ ] Performance optimized
- [ ] Mobile responsive
- [ ] Accessibility checked
- [ ] All links functional
- [ ] Security review complete
- [ ] Documentation updated
- [ ] Version number updated

---

For more information, visit the [WordPress Developer Handbook](https://developer.wordpress.org/)
