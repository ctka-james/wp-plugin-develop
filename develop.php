<?php
/**
 * Plugin Name: Develop Learn Plugin
 * Plugin URI: https://example.com/
 * Description: 這是一個用來學習 WordPress plugin 開發的最小範例，程式碼內含中文註解。
 * Version: 0.1.0
 * Author: Annie
 * License: GPL-2.0-or-later
 */

// 防止直接存取這個檔案，避免外部直接讀取外掛程式碼。
if (!defined('ABSPATH')) {
    exit;
}

// 定義外掛版本，方便之後在不同地方共用。
if (!defined('DEVELOP_PLUGIN_VERSION')) {
    define('DEVELOP_PLUGIN_VERSION', '0.1.0');
}

// 定義選項名稱，讓後續儲存與讀取設定時可以重複使用。
if (!defined('DEVELOP_PLUGIN_OPTION_NAME')) {
    define('DEVELOP_PLUGIN_OPTION_NAME', 'develop_plugin_message');
}

// 定義外掛路徑與網址，方便後續引入檔案與資源。
if (!defined('DEVELOP_PLUGIN_URL')) {
    define('DEVELOP_PLUGIN_URL', plugin_dir_url(__FILE__));
}

if (!defined('DEVELOP_PLUGIN_PATH')) {
    define('DEVELOP_PLUGIN_PATH', plugin_dir_path(__FILE__));
}

/**
 * 啟用外掛時執行的函式。
 * 這裡可以放置建立資料表、設定預設選項等初始化工作。
 */
function develop_plugin_activate() {
    // 這裡可以新增資料庫欄位或預設 option。
    // update_option( 'my_dev_plugin_option', '預設值' );
}
register_activation_hook( __FILE__, 'develop_plugin_activate' );

// 這個 hook 會在 WordPress 管理後台建立選單項目。
add_action('admin_menu', 'develop_register_menu');

// 這個 hook 會在管理頁面初始化時註冊設定欄位。
add_action('admin_init', 'develop_register_settings');

function develop_register_menu() {
    add_menu_page(
        'Develop Plugin',
        'Develop 外掛學習',
        'manage_options',
        'develop-plugin',
        'develop_render_admin_page',
        'dashicons-welcome-learn-more',
        20
    );

    add_submenu_page(
        'develop-plugin',
        'Develop Plugin 設定',
        '設定', 
        'manage_options',
        'develop-plugin-settings',
        'develop_render_settings_page'
    );
}

function develop_register_settings() {
    register_setting(
        'develop_plugin_settings_group',
        DEVELOP_PLUGIN_OPTION_NAME,
        array(
            'type' => 'string',
            'sanitize_callback' => 'develop_sanitize_message',
            'default' => '---歡迎來到 WordPress Plugin 學習專案---',
        )
    );

    add_settings_section(
        'develop_plugin_main_section',
        '基本設定',
        'develop_render_settings_section',
        'develop-plugin-settings'
    );

    add_settings_field(
        'develop_plugin_message_field',
        '顯示訊息',
        'develop_render_message_field',
        'develop-plugin-settings',
        'develop_plugin_main_section'
    );
}

function develop_sanitize_message($value) {
    // 將使用者輸入的內容做基本清理，避免 HTML 或不必要的字元污染。
    $value = sanitize_text_field($value);
    
    return $value;
}

function develop_render_settings_section() {
    echo '<p>在這裡設定外掛要顯示的內容，這是 WordPress Options API 的基本使用方式。</p>';
}

function develop_render_message_field() {
    $value = get_option(DEVELOP_PLUGIN_OPTION_NAME, '歡迎來到 WordPress Plugin 學習專案');
    echo '<input type="text" name="' . esc_attr(DEVELOP_PLUGIN_OPTION_NAME) . '" value="' . esc_attr($value) . '" class="regular-text" />';
}

// 這個函式負責在管理頁面中輸出內容。
function develop_render_admin_page() {
    $message = get_option(DEVELOP_PLUGIN_OPTION_NAME, '歡迎來到 WordPress Plugin 學習專案');

    echo '<div class="wrap">';
    echo '<h1>WordPress Plugin 學習範例</h1>';
    echo '<p>這是一個最小可運作的外掛，接下來我們會一步一步加入更多功能。</p>';
    echo '<p>目前版本：' . esc_html(DEVELOP_PLUGIN_VERSION) . '</p>';
    echo '<p>目前儲存的訊息：<strong>' . esc_html($message) . '</strong></p>';
    echo '</div>';
}

function develop_render_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    echo '<div class="wrap">';
    echo '<h1>Develop Plugin 設定</h1>';
    echo '<form method="post" action="options.php">';

    settings_fields('develop_plugin_settings_group');
    do_settings_sections('develop-plugin-settings');
    submit_button('儲存設定');

    echo '</form>';
    echo '</div>';
}

// 這個 hook 會在管理頁面顯示一條提示訊息，讓你確認外掛已載入。
add_action('admin_notices', 'develop_admin_notice');

function develop_admin_notice() {
    $screen = get_current_screen();

    if ($screen && $screen->id === 'toplevel_page_develop-plugin') {
        echo '<div class="notice notice-info is-dismissible">';
        echo '<p>這是外掛學習版，後續會加入設定頁、短碼與資料庫功能。</p>';
        echo '</div>';
    }
}

/**
 * 停用外掛時執行的函式。
 * 通常用來清理暫存資料或暫時停止功能。
 */
function develop_plugin_deactivate() {
    // 這裡可以清除暫存或暫停排程工作。
}
register_deactivation_hook( __FILE__, 'develop_plugin_deactivate' );
