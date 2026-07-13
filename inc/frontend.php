<?php
/**
 * 前台相關功能。
 */
if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', 'develop_enqueue_frontend_assets');
add_shortcode('develop_message', 'develop_render_frontend_message');

function develop_enqueue_frontend_assets() {
    wp_enqueue_style('develop-frontend-css', plugin_dir_url(dirname(__FILE__)) . 'assets/css/frontend.css', array(), DEVELOP_PLUGIN_VERSION);
}

function develop_render_frontend_message($atts = array()) {
    $message = get_option(DEVELOP_PLUGIN_OPTION_NAME, '歡迎來到 WordPress Plugin 學習專案');

    return '<p class="develop-plugin-message">' . esc_html($message) . '</p>';
}
