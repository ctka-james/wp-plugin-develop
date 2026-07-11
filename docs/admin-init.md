# admin_init Hook 功能說明

## 這個 hook 的用途

`add_action('admin_init', 'develop_register_settings');` 的作用，是在 WordPress 管理後台初始化時，執行我們自訂的 `develop_register_settings()` 函式。

這代表我們把插件的設定註冊流程，掛到管理後台啟動的某個時機點上，讓設定相關功能能夠被正確建立。

## 這段程式碼在做什麼

`develop_register_settings()` 這個函式主要負責把插件的設定項目註冊給 WordPress，讓後台設定頁可以正常顯示與儲存。

## 執行流程

1. WordPress 進入管理後台
2. 觸發 `admin_init` 這個 hook
3. 執行 `develop_register_settings()`
4. 註冊設定項目、設定區塊與設定欄位
5. 之後設定頁就能顯示這些內容

## 這個函式裡包含的主要功能

### 1. `register_setting()`

這個函式用來註冊一個設定項目，讓 WordPress 可以知道這個設定要被保存在哪裡。

在這個插件中，我們註冊了一個名為 `develop_plugin_message` 的設定欄位，並指定：

- 型別為字串
- 儲存前要先做清理
- 預設值為一段歡迎訊息

register_setting(
        'develop_plugin_settings_group', // 設定群組名稱 $option_name string required
        DEVELOP_PLUGIN_OPTION_NAME, // 設定名稱 $option_name string required
        array(
            'type' => 'string',
            'sanitize_callback' => 'develop_sanitize_message',
            'default' => '歡迎來到 WordPress Plugin 學習專案',
        )
    );

### 2. `add_settings_section()`

這個函式用來建立一個設定區塊。

例如我們建立了「基本設定」這個區塊，讓相關設定欄位集中顯示。

add_settings_section(
        'develop_plugin_main_section',
        '基本設定',
        'develop_render_settings_section',
        'develop-plugin-settings'
    );

### 3. `add_settings_field()`

這個函式用來建立一個設定欄位。

例如我們新增了「顯示訊息」欄位，讓管理者可以在後台輸入要顯示的內容。

add_settings_field(
        'develop_plugin_message_field',
        '顯示訊息',
        'develop_render_message_field',
        'develop-plugin-settings',
        'develop_plugin_main_section'
    );

## 相關函式說明

### `develop_sanitize_message()`

這個函式用來清理使用者輸入的內容。

這裡使用 `sanitize_text_field()`，是為了避免使用者輸入過多不必要的 HTML 或特殊字元。

### `develop_render_message_field()`

這個函式負責輸出設定欄位的 HTML 表單元件。

它會讀取目前已儲存的設定值，並把它顯示在輸入框中。

## 這個 hook 的學習重點

- `admin_init` 是管理後台初始化時的重要 hook
- 這個時機點很適合註冊設定項目
- 設定頁面的顯示與保存，通常都會依賴這個流程

## 在這個專案中的實際範例

目前這個插件使用了：

```php
add_action('admin_init', 'develop_register_settings');
```

而 `develop_register_settings()` 內部會呼叫：

```php
register_setting(...);
add_settings_section(...);
add_settings_field(...);
```

這些程式碼讓外掛的設定欄位能夠被 WordPress 正確識別與顯示。

## 小結

`admin_init` hook 是 WordPress 外掛中很常見的設定註冊入口。

它讓我們可以在管理後台初始化時，把設定項目、設定區塊與欄位一次性準備好，這是建立後台設定頁的關鍵步驟。
