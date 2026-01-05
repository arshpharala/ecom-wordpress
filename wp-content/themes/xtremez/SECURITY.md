# Security & Best Practices

## Security Measures Implemented

### 1. CSRF Protection (Cross-Site Request Forgery)

All forms include WordPress nonce verification:

```php
// In form
wp_nonce_field('xtremez_nonce');

// In handler
if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'xtremez_nonce')) {
  wp_die('Invalid request.');
}
```

### 2. Input Sanitization

```php
// Text input
$text = sanitize_text_field($_POST['field']);

// Email input
$email = sanitize_email($_POST['email']);

// Textarea
$content = sanitize_textarea_field($_POST['message']);

// JSON
$json = wp_kses_post($_POST['json_data']);
```

### 3. Output Escaping

```php
// HTML context
echo esc_html($user_data);

// URL context
echo esc_url($link);

// Attribute context
echo esc_attr($value);

// JavaScript context
json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
```

### 4. Capability Checks

```php
// Check user permissions
if (!current_user_can('manage_options')) {
  wp_die('Unauthorized access.');
}
```

### 5. SQL Injection Prevention

- Uses WordPress `$wpdb` object with prepared statements
- Example: `$wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE ID = %d", $id)`

---

## Best Practices

### Code Organization

✅ **Do:**

- Use the hook system for extensibility
- Keep functions small and focused
- Use proper file structure and naming
- Document code with DocBlocks

❌ **Don't:**

- Modify core WordPress files
- Use global variables unnecessarily
- Write procedural code without comments
- Hardcode values

### Performance

✅ **Do:**

- Use `wp_enqueue_*()` for assets
- Implement caching where appropriate
- Optimize images
- Minimize database queries

❌ **Don't:**

- Include scripts/styles inline
- Use deprecated functions
- Query database in loops
- Load unused libraries

### Accessibility

✅ **Do:**

- Use semantic HTML (h1, h2, nav, etc.)
- Provide alt text for images
- Use proper ARIA labels
- Ensure keyboard navigation

❌ **Don't:**

- Use divs instead of semantic tags
- Forget alt attributes
- Use color as sole indicator
- Create keyboard traps

---

## Testing Checklist

- [ ] Test on mobile devices (iOS/Android)
- [ ] Test in multiple browsers (Chrome, Firefox, Safari, Edge)
- [ ] Validate HTML at W3C
- [ ] Check for JavaScript console errors
- [ ] Test form submissions
- [ ] Verify all links work
- [ ] Check image loading
- [ ] Test with screen reader
- [ ] Test with keyboard navigation
- [ ] Check WP debug.log for errors

---

## Debugging Tips

### Enable Debug Mode

In `wp-config.php`:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

### Check Debug Log

```bash
tail -f wp-content/debug.log
```

### Use WordPress Functions

```php
// Log to debug.log
error_log(print_r($data, true));

// Die with detailed output
wp_die('<pre>' . var_export($data, true) . '</pre>');
```

### Browser Console

Open DevTools (F12) and check:

- Console for JavaScript errors
- Network tab for failed requests
- Application tab for storage

---

## Code Review Checklist

Before deploying:

- [ ] All PHP follows PSR-12 standards
- [ ] All output is escaped
- [ ] All input is sanitized
- [ ] Nonces are used on forms
- [ ] Proper file structure
- [ ] Comments explain complex logic
- [ ] No hardcoded values
- [ ] No deprecated functions used
- [ ] Mobile responsive
- [ ] No console errors
- [ ] Accessible to screen readers
- [ ] Load time acceptable

---

## Helpful Resources

- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [Plugin Security Handbook](https://developer.wordpress.org/plugins/security/)
- [Theme Security](https://developer.wordpress.org/themes/advanced-topics/security/)
- [REST API Security](https://developer.wordpress.org/plugins/security/rest-api/)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
