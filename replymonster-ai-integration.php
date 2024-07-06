<?php
/*
Plugin Name: ReplyMonster AI Chatbot Integration
Description: Integrate ReplyMonster AI Chatbot into your website in a few clicks
Version: 1.0
Author: replymonsterai
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Hook for plugin activation
register_activation_hook(__FILE__, 'replymonster_activate_plugin');

// Hook for plugin deactivation
register_deactivation_hook(__FILE__, 'replymonster_deactivate_plugin');

// Function to handle plugin activation
function replymonster_activate_plugin()
{
    // Redirect to settings page to enter the token
    add_option('replymonster_activation_redirect', true);
}

// Function to handle plugin deactivation
function replymonster_deactivate_plugin()
{
    // Remove the stored token
    delete_option('replymonster_token');
}

// Hook to handle redirection after activation
add_action('admin_init', 'replymonster_redirect_after_activation');
function replymonster_redirect_after_activation()
{
    if (get_option('replymonster_activation_redirect', false)) {
        delete_option('replymonster_activation_redirect');
        if (!isset($_GET['activate-multi'])) {
            wp_redirect(admin_url('options-general.php?page=replymonster-settings'));
            exit;
        }
    }
}

// Hook to add script to the frontend
add_action('wp_footer', 'replymonster_add_script');
function replymonster_add_script()
{
    $token = get_option('replymonster_token');
    if ($token) {
        ?>
        <script async src="https://api.replymonster.ai/widget/widget.js"
                token="<?php echo esc_attr($token); ?>"></script>
        <?php
    }
}

// Hook to add settings page
add_action('admin_menu', 'replymonster_add_settings_page');
function replymonster_add_settings_page()
{
    add_options_page(
        'ReplyMonster Settings',
        'ReplyMonster',
        'manage_options',
        'replymonster-settings',
        'replymonster_render_settings_page'
    );
}

// Enqueue admin scripts and styles
add_action('admin_enqueue_scripts', 'replymonster_enqueue_admin_assets');
function replymonster_enqueue_admin_assets($hook)
{
    if ($hook !== 'settings_page_replymonster-settings') {
        return;
    }
    wp_enqueue_style('replymonster-style', plugin_dir_url(__FILE__) . 'css/replymonster-style.css');
    wp_enqueue_script('replymonster-script', plugin_dir_url(__FILE__) . 'js/replymonster-script.js', array(), false, true);
}

// Render the settings page
function replymonster_render_settings_page()
{
    include plugin_dir_path(__FILE__) . 'replymonster-settings-page.php';
}

// Register settings
add_action('admin_init', 'replymonster_register_settings');
function replymonster_register_settings()
{
    register_setting('replymonster_settings', 'replymonster_token');

    add_settings_section(
        'replymonster_main_section',
        'Main Settings',
        null,
        'replymonster-settings'
    );

    add_settings_field(
        'replymonster_token',
        'Your personal access token<span style="color: red;">*</span>',
        'replymonster_token_field_callback',
        'replymonster-settings',
        'replymonster_main_section'
    );
}

function replymonster_token_field_callback()
{
    $token = get_option('replymonster_token');
    echo '<div class="form-group">';
    echo '<label for="replymonster_token">Token</label>';
    echo '<input type="text" id="replymonster_token" placeholder="Token" name="replymonster_token" value="' . esc_attr($token) . '" />';
    echo '</div>';
}

// Add settings link on plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'replymonster_settings_link');
function replymonster_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=replymonster-settings">' . __('Settings') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
?>
