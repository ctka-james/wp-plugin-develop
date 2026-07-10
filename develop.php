<?php
/**
 * Plugin Name: Develop Learn Plugin
 * Plugin URI: https://example.com/
 * Description: 這是一個用來學習 WordPress plugin 開發的最小範例，程式碼內含中文註解。
 * Version: 0.1.0
 * Author: Annie
 * License: GPL-2.0-or-later
 */

// 防止直接存取這個檔案，避免外部直接讀取插件程式碼。
if (!defined('ABSPATH')) {
    exit;
}

// 定義插件版本，方便之後在不同地方共用。
if (!defined('DEVELOP_PLUGIN_VERSION')) {
    define('DEVELOP_PLUGIN_VERSION', '0.1.0');
}

// 這個函式會在 WordPress 管理後台建立一個選單項目。
add_action('admin_menu', 'develop_register_menu');

function develop_register_menu() {
    add_menu_page(
        'Develop Plugin',      // 頁面標題
        'Develop Plugin',      // 選單名稱
        'manage_options',      // 需要的權限
        'develop-plugin',     // 選單 slug
        'develop_render_admin_page', // 點擊後要顯示的函式
        'dashicons-smiley',   // 選單圖示
        20                    // 選單順序
    );
}

// 這個函式負責在管理頁面中輸出內容。
function develop_render_admin_page() {
    echo '<div class="wrap">';
    echo '<h1>WordPress Plugin 學習範例</h1>';
    echo '<p>這是一個最小可運作的插件，接下來我們會一步一步加入更多功能。</p>';
    echo '<p>目前版本：' . esc_html(DEVELOP_PLUGIN_VERSION) . '</p>';
    echo '</div>';
}

// 這個 hook 會在管理頁面顯示一條提示訊息，讓你確認插件已載入。
add_action('admin_notices', 'develop_admin_notice');

function develop_admin_notice() {
    $screen = get_current_screen();

    if ($screen && $screen->id === 'toplevel_page_develop-plugin') {
        echo '<div class="notice notice-info is-dismissible">';
        echo '<p>這是插件學習版，後續會加入設定頁、短碼與資料庫功能。</p>';
        echo '</div>';
    }
}
