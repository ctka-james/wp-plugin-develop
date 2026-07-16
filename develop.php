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

// 定義外掛路徑，方便後續引入檔案。
if (!defined('DEVELOP_PLUGIN_PATH')) {
    define('DEVELOP_PLUGIN_PATH', plugin_dir_path(__FILE__));
}

require_once DEVELOP_PLUGIN_PATH . 'inc/admin.php';
require_once DEVELOP_PLUGIN_PATH . 'inc/frontend.php';

/**
 * 啟用外掛時執行的函式。
 * 這裡可以放置建立資料表、設定預設選項等初始化工作。
 */
function develop_plugin_activate() {
    // 這裡可以新增資料庫欄位或預設 option。
    // update_option( 'develop_plugin_option', '預設值' );
}
register_activation_hook( __FILE__, 'develop_plugin_activate' );

/**
 * 停用外掛時執行的函式。
 * 這裡會清掉外掛相關的設定選項，避免停用後仍保留舊資料。
 */
function develop_plugin_deactivate() {
    delete_option( DEVELOP_PLUGIN_OPTION_NAME );
    delete_option( 'develop_plugin_shortcode_message' );
}
register_deactivation_hook( __FILE__, 'develop_plugin_deactivate' );
