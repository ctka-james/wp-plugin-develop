<?php
/**
 * 前台相關功能。
 */
if (!defined('ABSPATH')) {
    exit;
}

// 這裡可以後續加入 shortcode、前台顯示、模板輸出等功能。
function develop_render_frontend_message() {
    $message = get_option(DEVELOP_PLUGIN_OPTION_NAME, '歡迎來到 WordPress Plugin 學習專案');

    return '<p class="develop-plugin-message">' . esc_html($message) . '</p>';
}
