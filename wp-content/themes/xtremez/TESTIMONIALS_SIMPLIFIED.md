# Testimonials CPT - Simplified & Optimized

## Overview

The Testimonials custom post type has been completely refactored to use WordPress native fields where possible, eliminating unnecessary custom metaboxes and simplifying the admin interface.

## Admin Form Structure (Clean & Simple)

### Native WordPress Fields (Auto-included)

1. **Title** - Person's name (main editor)
2. **Featured Image** - Person's photo (media uploader)
3. **Excerpt** - Testimonial quote (excerpt editor)

### Custom Metaboxes (Only 2)

1. **Company Logo** (Sidebar)
   - Media uploader for company logo
   - Shows preview with upload/remove buttons
2. **Position in Company** (Main area, below excerpt)
   - Simple text input
   - Placeholder: "e.g., Brand Manager at Acme Corp"

## Data Structure

### Database Storage

```php
// Post Table
- post_title      => Person's name
- post_excerpt    => Testimonial quote
- post_thumbnail  => Person's photo ID

// Postmeta Table
- _testimonial_logo_id    => Company logo attachment ID
- _testimonial_position   => Job title and company name
```

### Retrieval with xtremez_get_testimonial_data()

```php
$data = xtremez_get_testimonial_data($post_id);

// Returns:
[
  'id'       => 123,
  'name'     => 'John Doe',                    // from post_title
  'text'     => 'Great service!',              // from post_excerpt
  'image'    => 'https://site.com/image.jpg', // featured image URL
  'logo'     => 'https://site.com/logo.png',  // logo URL
  'position' => 'Brand Manager at Acme Corp', // from meta
]
```

## Admin Interface Changes

### Removed

- ❌ Separate "Person's Name" metabox
- ❌ Separate "Testimonial Text" metabox
- ❌ Custom fields metabox (hidden)

### Added

- ✅ Excerpt editor (WordPress native - for testimonial quote)
- ✅ Position metabox (simplified field)

### Result

- **Cleaner form** - only essential fields
- **Less data entry** - use native WordPress editors
- **Better UX** - familiar WordPress interface
- **Reduced code** - fewer custom functions

## Creating a Testimonial

### Steps in WordPress Admin

1. Go to **Testimonials** menu
2. Click **Add New**
3. Enter **Title** = Person's name
4. Set **Featured Image** = Person's photo
5. Write in **Excerpt** = Testimonial quote (use the excerpt editor below the main editor)
6. Fill **Company Logo** = Upload company logo image
7. Fill **Position in Company** = "Job Title at Company Name"
8. Click **Publish**

## Usage in Templates

### Get all testimonials

```php
$testimonials = xtremez_get_testimonials(6);

foreach ($testimonials as $testimonial) {
  $data = xtremez_get_testimonial_data($testimonial->ID);

  echo '<blockquote>' . esc_html($data['text']) . '</blockquote>';
  echo '<p>— ' . esc_html($data['name']) . ', ' . esc_html($data['position']) . '</p>';

  if ($data['logo']) {
    echo '<img src="' . esc_url($data['logo']) . '" alt="Logo">';
  }
}
```

## Migration Notes

### If You Have Old Testimonials

The old metaboxes (`_testimonial_name`, `_testimonial_text`) are no longer used. To migrate:

```php
// For each old testimonial:
$old_name = get_post_meta($post_id, '_testimonial_name', true);
$old_text = get_post_meta($post_id, '_testimonial_text', true);

// Update to new structure
wp_update_post([
  'ID'           => $post_id,
  'post_title'   => $old_name,
  'post_excerpt' => $old_text,
]);

// Delete old meta
delete_post_meta($post_id, '_testimonial_name');
delete_post_meta($post_id, '_testimonial_text');
```

## File Locations

- **CPT Definition**: [inc/cpt-testimonials.php](inc/cpt-testimonials.php)
- **Used in Functions**: [functions.php](functions.php#L30) - `require XTREMEZ_THEME_DIR . 'inc/cpt-testimonials.php'`

## Benefits of This Approach

| Aspect             | Before   | After              |
| ------------------ | -------- | ------------------ |
| Metaboxes          | 3 custom | 2 custom           |
| Admin form clutter | High     | Low                |
| Code complexity    | Complex  | Simple             |
| Data consistency   | Manual   | Auto-managed by WP |
| Mobile-friendly    | Limited  | Full support       |
| REST API ready     | Partial  | Full               |

---

**Version**: 1.0.0  
**Date**: 2024  
**Status**: Production Ready
