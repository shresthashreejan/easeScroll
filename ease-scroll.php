<?php
/*
Plugin Name: EaseScroll
Description: Adds a simple scroll to top button on every page.
Version: 1.0
Author: shreejan
*/

// Enqueue scripts and styles
function ease_scroll_enqueue_scripts() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    wp_enqueue_script('ease-scroll', plugins_url('/easeScroll.js', __FILE__), array('jquery'), '1.0', true);

    // Pass PHP variables to JavaScript
    wp_localize_script('ease-scroll', 'ease_scroll_vars', array(
        'bg_color' => get_option('ease_scroll_bg_color', '#000'),
        'icon_color' => get_option('ease_scroll_icon_color', '#fff'), // New setting for icon color
    ));
    wp_enqueue_style('ease-scroll', plugins_url('/easeScroll.css', __FILE__), array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'ease_scroll_enqueue_scripts');

// Add settings page
function ease_scroll_settings_page() {
    add_options_page(
        'EaseScroll Settings',
        'EaseScroll',
        'manage_options',
        'ease-scroll-settings',
        'ease_scroll_render_settings_page'
    );
}
add_action('admin_menu', 'ease_scroll_settings_page');

// Render settings page
function ease_scroll_render_settings_page() {
    ?>
    <div class="wrap">
        <h2>EaseScroll Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('ease_scroll_settings');
            do_settings_sections('ease-scroll-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings and fields
function ease_scroll_register_settings() {
    // Add a new section for background and icon color
    add_settings_section('ease_scroll_style', 'Button Style', 'ease_scroll_style_callback', 'ease-scroll-settings');
    add_settings_field('ease_scroll_bg_color', 'Background Color', 'ease_scroll_bg_color_field_callback', 'ease-scroll-settings', 'ease_scroll_style');
    add_settings_field('ease_scroll_icon_color', 'Icon Color', 'ease_scroll_icon_color_field_callback', 'ease-scroll-settings', 'ease_scroll_style');

    register_setting('ease_scroll_settings', 'ease_scroll_bg_color');
    register_setting('ease_scroll_settings', 'ease_scroll_icon_color');
}
add_action('admin_init', 'ease_scroll_register_settings');

// Callback for the new section
function ease_scroll_style_callback() {
    echo '<p>Customize the style of the EaseScroll button</p>';
}

// Callback for background color field
function ease_scroll_bg_color_field_callback() {
    $bg_color = get_option('ease_scroll_bg_color', '#000');
    ?>
    <input type="color" name="ease_scroll_bg_color" value="<?php echo esc_attr($bg_color); ?>" />
    <?php
}

// Callback for icon color field
function ease_scroll_icon_color_field_callback() {
    $icon_color = get_option('ease_scroll_icon_color', '#fff');
    ?>
    <input type="color" name="ease_scroll_icon_color" value="<?php echo esc_attr($icon_color); ?>" />
    <?php
}

// Add inline styles to set the CSS variables
function ease_scroll_inline_styles() {
    $bg_color = get_option('ease_scroll_bg_color', '#000');
    $icon_color = get_option('ease_scroll_icon_color', '#fff');
    echo "<style>:root { --ease-scroll-bg-color: {$bg_color}; --ease-scroll-icon-color: {$icon_color}; }</style>";
}
add_action('wp_head', 'ease_scroll_inline_styles');

// Add settings link to plugin action links
function ease_scroll_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=ease-scroll-settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'ease_scroll_settings_link');
?>
