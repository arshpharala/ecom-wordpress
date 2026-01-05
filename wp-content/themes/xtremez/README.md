# Xtremez WordPress Theme

A modern, high-performance WordPress theme built specifically for digital marketing and creative agencies. Featuring a professional hook-based architecture, custom post types, and a clean component-driven design.

---

## 📋 Table of Contents

- [Features](#-features)
- [Installation](#-installation)
- [Quick Start](#-quick-start)
- [Theme Structure](#-theme-structure)
- [Customization](#-customization)
- [Development](#-development)
- [Custom Post Types](#-custom-post-types)
- [Settings & Configuration](#-settings--configuration)
- [Form Management](#-form-management)
- [Code Standards](#-code-standards)
- [Support & Credits](#-support--credits)

---

## ✨ Features

- **Modern PHP Architecture** - Built on WordPress hooks and filters
- **Custom Services CPT** - Dedicated post type for service showcase
- **Professional Styling** - SCSS compilation with npm scripts
- **Form Management** - Built-in newsletter and contact form handling
- **Theme Settings Panel** - Easy customization via WordPress admin
- **Responsive Design** - Mobile-first approach
- **WooCommerce Ready** - Compatible with e-commerce needs
- **Accessibility** - WCAG 2.1 compliance
- **SEO Optimized** - Proper heading hierarchy and semantic markup
- **Developer Friendly** - Well-documented code and clear structure

---

## 🚀 Installation

### Prerequisites

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Node.js 14+ (for development/SCSS compilation)

### Steps

1. **Upload the theme**

   ```bash
   # Copy the xtremez folder to wp-content/themes/
   cp -r xtremez /path/to/wordpress/wp-content/themes/
   ```

2. **Activate the theme**

   - Go to WordPress Admin → Appearance → Themes
   - Find "Xtremez" and click Activate

3. **Install dependencies** (for development)

   ```bash
   cd wp-content/themes/xtremez
   npm install
   ```

4. **Configure theme settings**
   - Go to WordPress Admin → Xtremez Settings
   - Fill in your contact information and social links

---

## 📖 Quick Start

### Basic Setup

1. **Create a Primary Menu**

   - Admin → Appearance → Menus
   - Create a menu with your pages
   - Assign to "Primary Menu" location

2. **Create a Footer Menu** (optional)

   - Create another menu
   - Assign to "Footer Menu" location

3. **Set Up Services**

   - Click "Services" in the left sidebar
   - Add new service posts with title, description, and featured image
   - Order them using "Menu Order" field

4. **Configure Theme Options**
   - Admin → Xtremez Settings
   - Add your contact details
   - Add social media links (JSON format)
   - Add features/benefits (JSON format)

---

## 📁 Theme Structure

```
xtremez/
├── index.php                 # Fallback template
├── 404.php                   # 404 error page
├── page.php                  # Single page template
├── search.php                # Search results template
├── comments.php              # Comments template
├── single-service.php        # Single service post
├── archive-service.php       # Service archive page
├── header.php                # Header template
├── footer.php                # Footer template
├── style.css                 # Theme metadata
├── functions.php             # Theme bootstrap
├── package.json              # Node.js dependencies
│
├── inc/                      # Theme functionality
│   ├── setup.php             # Theme support setup
│   ├── enqueue.php           # Asset registration
│   ├── helpers.php           # Utility functions
│   ├── cpt-services.php      # Service post type
│   ├── settings.php          # Theme options page
│   └── forms.php             # Form handlers
│
├── assets/
│   ├── src/
│   │   └── scss/
│   │       └── style.scss    # Source styles
│   ├── dist/
│   │   ├── css/app.css       # Compiled styles
│   │   └── js/
│   │       ├── main.js       # Main JS
│   │       └── form.js       # Form logic
│   ├── images/               # Theme images
│   └── fonts/                # Custom fonts
└── languages/                # Translation files
```

---

## 🎨 Customization

### Theme Settings

All theme settings are managed via **Admin → Xtremez Settings**:

- **Address** - Your physical location
- **Phone** - Contact phone number
- **WhatsApp** - WhatsApp business number (digits only)
- **Email** - Contact email address
- **Social Links** - JSON array of social profiles
- **Features/Why Choose** - JSON array of key benefits

### Social Links JSON Format

```json
[
	{
		"platform": "Facebook",
		"link": "https://facebook.com/xtremez",
		"icon": "images/facebook.svg"
	},
	{
		"platform": "Instagram",
		"link": "https://instagram.com/xtremez",
		"icon": "images/instagram.svg"
	}
]
```

### Features JSON Format

```json
[
	{
		"icon": "images/icon1.png",
		"title": "END-TO-END SOLUTIONS",
		"short_description": "Complete solutions from concept to launch"
	},
	{
		"icon": "images/icon2.png",
		"title": "CREATIVE EXPERTISE",
		"short_description": "Award-winning creative team"
	}
]
```

---

## 🛠️ Development

### SCSS Compilation

```bash
# Build CSS once
npm run build:css

# Watch for changes during development
npm run watch:css
```

The SCSS source file is at `assets/src/scss/style.scss` and compiles to `assets/dist/css/app.css`.

### Code Standards

- **PHP** - PSR-12 style with WordPress conventions
- **Escaping** - All output is properly escaped
- **Nonces** - Security tokens for form submissions
- **Sanitization** - User input is sanitized
- **Documentation** - DocBlock comments on all functions

### Adding Hooks

To extend functionality without modifying core files, use WordPress hooks:

```php
// In your plugin or child theme
add_action('xtremez_after_hero', function() {
  // Your custom content
});

add_filter('xtremez_service_title', function($title) {
  return strtoupper($title);
});
```

---

## 📝 Custom Post Types

### Services CPT

**Post Type:** `service`
**Slug:** `/services/`
**Supports:** Title, Editor, Excerpt, Featured Image

**Usage:**

- Create service posts from Admin → Services
- Reorder using Menu Order field
- Add custom content in the editor
- Use featured images for service thumbnails

---

## ⚙️ Settings & Configuration

### Theme Constants

Defined in `functions.php`:

```php
XTREMEZ_THEME_VERSION    // Current theme version
XTREMEZ_THEME_DIR        // Theme directory path
XTREMEZ_THEME_URI        // Theme directory URI
```

### Database Options

All settings are stored in single `xtremez_settings` option:

```php
// Get a setting
$settings = get_option('xtremez_settings');
echo $settings['phone'];

// Or use the helper function
echo xtremez_option('phone');
```

---

## 📧 Form Management

### Contact Form

**Endpoint:** `/wp-admin/admin-post.php?action=xtremez_contact`
**Method:** POST
**Required Fields:** name, email, phone, message

Submissions are stored as private posts in the "Enquiries" section.

### Newsletter Subscription

**Endpoint:** `/wp-admin/admin-post.php?action=xtremez_subscribe`
**Method:** POST
**Required Fields:** email

Subscriptions are stored as private posts in the "Enquiries" section.

### Form Security

- All forms include WordPress nonce verification
- User input is sanitized and validated
- Submissions are stored with post metadata
- Email validation using `is_email()`

---

## 🔒 Security Features

- **CSRF Protection** - Nonce tokens on all forms
- **Input Sanitization** - `sanitize_text_field()`, `sanitize_email()`
- **Output Escaping** - `esc_html()`, `esc_url()`, `esc_attr()`
- **Capability Checks** - `current_user_can()` for admin features
- **No Direct Access** - `if (!defined('ABSPATH')) exit;` in all files

---

## 📱 Responsive Design

The theme is built mobile-first with breakpoints at:

- Mobile: 320px - 599px
- Tablet: 600px - 999px
- Desktop: 1000px+

---

## 🌍 Internationalization

The theme is fully translatable with text domain `xtremez`.

Create translations in `languages/` directory:

```
languages/
├── xtremez.pot
├── xtremez-fr_FR.po
└── xtremez-fr_FR.mo
```

---

## 🐛 Debugging

Enable WordPress debug mode in `wp-config.php`:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Check debug logs at `/wp-content/debug.log`

---

## 📚 Template Hierarchy

WordPress loads templates in this order:

1. `front-page.php` - Homepage
2. `page-{slug}.php` - Specific page
3. `page.php` - Generic page
4. `single-service.php` - Service post
5. `archive-service.php` - Service archive
6. `search.php` - Search results
7. `404.php` - 404 error
8. `index.php` - Fallback

---

## ✅ Performance Tips

1. **Image Optimization** - Use WebP with fallbacks
2. **Lazy Loading** - Use native `loading="lazy"`
3. **Cache** - Use WP Super Cache or similar
4. **CDN** - Serve static assets from CDN
5. **Minification** - Already included in compiled CSS/JS

---

## 🤝 Support & Credits

**Theme Author:** Xtremez Development Team  
**Website:** https://xtremez.com  
**License:** GPL-2.0-or-later

### Built With

- WordPress Hooks & Filters
- PHP 7.4+
- SASS/SCSS
- jQuery
- SweetAlert2

---

## 📄 License

This theme is licensed under GNU General Public License v2.0 or later. See `license.txt` for details.

---

## 🎯 Version History

### 1.0.0 (January 5, 2026)

- ✨ Initial release
- 🎨 Complete theme design
- ⚙️ Theme settings panel
- 📧 Form management system
- 🏗️ Services custom post type
- 📱 Responsive design
- 🔒 Security implementation
- 📖 Full documentation

---

**Need Help?** Contact support@xtremez.com or visit our [documentation wiki](https://xtremez.com/docs)
