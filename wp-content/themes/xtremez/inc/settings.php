<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function () {
  add_menu_page(
    'Xtremez Settings',
    'Xtremez Settings',
    'manage_options',
    'xtremez-settings',
    'xtremez_render_settings_page',
    'dashicons-admin-generic',
    59
  );
});

add_action('admin_init', function () {
  register_setting('xtremez_settings_group', 'xtremez_settings', [
    'type'              => 'array',
    'sanitize_callback' => 'xtremez_sanitize_settings',
    'default'           => [],
  ]);
});

function xtremez_sanitize_settings($input)
{
  $out = [];

  $out['address']  = sanitize_text_field($input['address'] ?? '');
  $out['phone']    = sanitize_text_field($input['phone'] ?? '');
  $out['whatsapp'] = sanitize_text_field($input['whatsapp'] ?? '');
  $out['email']    = sanitize_email($input['email'] ?? '');

  // JSON blocks (optional but very useful)
  $out['social_json'] = wp_kses_post($input['social_json'] ?? '[]');
  $out['why_json']    = wp_kses_post($input['why_json'] ?? '[]');

  return $out;
}

function xtremez_render_settings_page()
{
  $opts = get_option('xtremez_settings', []);
?>
  <div class="wrap">
    <h1>Xtremez Settings</h1>

    <form method="post" action="options.php">
      <?php settings_fields('xtremez_settings_group'); ?>

      <h2>Contact Details</h2>
      <table class="form-table">
        <tr>
          <th><label>Address</label></th>
          <td><input type="text" name="xtremez_settings[address]" value="<?php echo esc_attr($opts['address'] ?? ''); ?>" class="regular-text"></td>
        </tr>
        <tr>
          <th><label>Phone</label></th>
          <td><input type="text" name="xtremez_settings[phone]" value="<?php echo esc_attr($opts['phone'] ?? ''); ?>" class="regular-text"></td>
        </tr>
        <tr>
          <th><label>WhatsApp (digits)</label></th>
          <td><input type="text" name="xtremez_settings[whatsapp]" value="<?php echo esc_attr($opts['whatsapp'] ?? ''); ?>" class="regular-text"></td>
        </tr>
        <tr>
          <th><label>Email</label></th>
          <td><input type="email" name="xtremez_settings[email]" value="<?php echo esc_attr($opts['email'] ?? ''); ?>" class="regular-text"></td>
        </tr>
      </table>

      <h2>Social Links JSON</h2>
      <p>Example:</p>
      <pre>[
  {"platform":"Facebook","link":"https://...","icon":"images/facebook.svg"},
  {"platform":"Instagram","link":"https://...","icon":"images/instagram.svg"}
]</pre>
      <textarea name="xtremez_settings[social_json]" rows="10" style="width:100%;"><?php echo esc_textarea($opts['social_json'] ?? '[]'); ?></textarea>

      <h2>Why Choose Features JSON</h2>
      <p>Example:</p>
      <pre>[
  {"icon":"images/end.png","title":"END-TO-END SOLUTIONS","short_description":"..."},
  {"icon":"images/creative.png","title":"CREATIVE EXPERTISE","short_description":"..."}
]</pre>
      <textarea name="xtremez_settings[why_json]" rows="10" style="width:100%;"><?php echo esc_textarea($opts['why_json'] ?? '[]'); ?></textarea>

      <?php submit_button(); ?>
    </form>
  </div>
<?php
}
