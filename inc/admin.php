<?php
/**
 * 後台相關功能。
 */
if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'develop_register_menu');
add_action('admin_init', 'develop_register_settings');
add_action('admin_notices', 'develop_admin_notice');
add_action('admin_enqueue_scripts', 'develop_enqueue_admin_assets');

function develop_enqueue_admin_assets($hook_suffix) {
    if ($hook_suffix === 'toplevel_page_develop-plugin' || $hook_suffix === 'develop-plugin_page_develop-plugin-settings') {
        wp_enqueue_style('develop-admin-css', plugin_dir_url(dirname(__FILE__)) . 'assets/css/admin.css', array(), DEVELOP_PLUGIN_VERSION);
        wp_enqueue_script('jquery');
        wp_enqueue_script('develop-jquery-example', plugin_dir_url(dirname(__FILE__)) . 'assets/js/jquery-example.js', array('jquery'), DEVELOP_PLUGIN_VERSION, true);
    }
}

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

function develop_admin_notice() {
    $screen = get_current_screen();

    if ($screen && $screen->id === 'toplevel_page_develop-plugin') {
        echo '<div class="notice notice-info is-dismissible">';
        echo '<p>這是外掛學習版，後續會加入設定頁、短碼與資料庫功能。</p>';
        echo '</div>';
    }
}
