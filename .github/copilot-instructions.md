# WordPress Codebase Guidelines for AI Agents

## Architecture Overview

WordPress uses a **hook-based plugin system** with procedural PHP. The codebase loads in this sequence:

1. **wp-load.php** → Defines ABSPATH and loads wp-config.php
2. **wp-config.php** → Sets database credentials, debug flags, and authentication salts
3. **wp-settings.php** → Initializes core constants, loads wp-includes, and sets up hooks
4. **wp-blog-header.php** → Frontend entry point; loads theme and calls template loader

### Key Systems

- **Hooks (Plugin API)**: Actions (`do_action()`, `add_action()`) and Filters (`apply_filters()`, `add_filter()`) in [wp-includes/plugin.php](wp-includes/plugin.php) enable extensibility without modifying core
- **Database**: Configured in wp-config.php (DB_NAME, DB_USER, DB_HOST); queries via global `$wpdb` object
- **Capabilities System**: Role-based access via `current_user_can()` function for permission checks

## Critical Workflows

### Development & Debugging

- **Enable Debug Mode**: Set `WP_DEBUG` to `true` in wp-config.php; logs appear in `/wp-content/debug.log`
- **Theme Location**: [wp-content/themes/](wp-content/themes/) - Default themes are twentytwentyfive, twentytwentyfour
- **Plugin Location**: [wp-content/plugins/](wp-content/plugins/) - Each plugin is a directory with an index.php
- **Admin Interface**: [wp-admin/](wp-admin/) - Dashboard loaded via wp-admin/index.php; uses same hook system

### Common Tasks

- **Add Functionality**: Use hooks instead of editing core files. Example: `add_action('wp_footer', 'my_function')`
- **Modify Post/User Data**: Use global `$wpdb` for queries or WordPress functions like `get_post()`, `get_user_by()`
- **Admin Pages**: Register custom admin pages in [wp-admin/includes/](wp-admin/includes/) using `add_menu_page()` hook

## Project-Specific Conventions

### Hook Patterns

- **Action Hooks**: Fire events; use `do_action()` to trigger. Common: `wp_footer`, `admin_init`, `init`
- **Filter Hooks**: Modify data; use `apply_filters()` to enable modification. Common: `the_content`, `post_type_labels`
- **Remove Hooks**: Use `remove_action()` or `remove_filter()` with matching priority (default 10) and accepted_args

### File Organization

- **Core Functions**: [wp-includes/functions.php](wp-includes/functions.php) for general utilities
- **Admin Functions**: [wp-admin/includes/](wp-admin/includes/) for admin-specific logic
- **Template Files**: [wp-includes/](wp-includes/) contains template functions (post-template.php, category-template.php)
- **Class-based Components**: Prefixed with `class-wp-` (e.g., [class-wp-query.php](wp-includes/class-wp-query.php))

### Code Style

- Use `define()` for constants, `global` to access them
- Wrap user input with sanitization functions (`sanitize_text_field()`, `esc_html()`)
- Check capabilities before sensitive operations: `if ( current_user_can( 'edit_posts' ) )`
- Inline documentation uses @since, @param, @return tags for DocBlocks

## Integration Points & Dependencies

### Database

- Primary DB config in [wp-config.php](wp-config.php) - defines table prefix (default `wp_`)
- WPDB class (global `$wpdb`) handles all queries
- Core tables: wp_posts, wp_postmeta, wp_users, wp_usermeta, wp_options, wp_comments

### External Services

- **Plugins Loaded**: `require_once ABSPATH . 'wp-admin/includes/plugin.php'` in [wp-settings.php](wp-settings.php#L52)
- **Requests Library**: [wp-includes/class-requests.php](wp-includes/class-requests.php) for HTTP calls
- **REST API**: [wp-includes/rest-api/](wp-includes/rest-api/) for programmatic access

### Theme/Child Theme Loading

- [wp-includes/theme.php](wp-includes/theme.php) loads active theme from [wp-content/themes/](wp-content/themes/)
- Child themes inherit parent via style.css header `Template:`

## Important Constants & Globals

- `ABSPATH` - Root directory path
- `WPINC` - Set to 'wp-includes'
- `WP_CONTENT_DIR` - Custom content directory path (default wp-content)
- `$wpdb` - Database object for queries
- `$wp_filter` - Global hooks registry
- `current_user_id()` - Logged-in user's ID

## When Debugging or Modifying

1. **Never edit core files directly** - Use hooks and filters to extend functionality
2. **Always check file exists** - Use `file_exists()` or `is_file()` before requiring
3. **Test capability checks** - Verify user roles before outputting admin features
4. **Verify hook priority** - Multiple callbacks on same hook run in priority order (lower = earlier)
5. **Check backwards compatibility** - Review version tags (@since) before using newer functions
