# admin_init Hook 功能說明

## 這個 hook 的用途

`add_action('admin_init', 'develop_register_settings');` 會在 WordPress 管理後台初始化時執行 `develop_register_settings()`。

在目前的專案中，這段註冊是放在 [inc/admin.php](../inc/admin.php) 裡，並由 [develop.php](../develop.php) 透過 require_once 載入，因此外掛在後台啟動時就會建立設定相關功能。

## 目前專案結構與位置

這個外掛目前的結構已經分成兩個主要邏輯區塊：

- [develop.php](../develop.php)：外掛主檔案，定義常數、載入後台與前台檔案。
- [inc/admin.php](../inc/admin.php)：負責管理後台功能，包括選單、設定註冊與管理頁面。
- [inc/frontend.php](../inc/frontend.php)：負責前台顯示與短碼功能。

也就是說，`admin_init` 這個流程現在是由管理後台檔案來負責註冊，而不是把所有邏輯都寫在主檔案裡。

## 這段程式碼在做什麼

`develop_register_settings()` 會把外掛的設定項目註冊給 WordPress，讓後台設定頁能夠正常顯示與儲存。

這個函式目前會做三件事：

1. 使用 `register_setting()` 註冊設定欄位
2. 使用 `add_settings_section()` 建立設定區塊
3. 使用 `add_settings_field()` 建立設定欄位

## 執行流程

1. WordPress 進入管理後台
2. 觸發 `admin_init` 這個 hook
3. 執行 `develop_register_settings()`
4. 註冊設定項目、設定區塊與設定欄位
5. 之後管理頁面與設定頁就能顯示這些內容

## 這個函式裡包含的主要功能

### 1. `register_setting()`

這個函式用來註冊一個設定項目，讓 WordPress 知道要把資料存到哪裡。

目前這個外掛使用了 `DEVELOP_PLUGIN_OPTION_NAME` 這個常數，也就是 `develop_plugin_message`，並指定：

- 型別為字串
- 儲存前會做清理
- 預設值為一段歡迎訊息

```php
register_setting(
    'develop_plugin_settings_group',
    DEVELOP_PLUGIN_OPTION_NAME,
    array(
        'type' => 'string',
        'sanitize_callback' => 'develop_sanitize_message',
        'default' => '---歡迎來到 WordPress Plugin 學習專案---',
    )
);
```

### 2. `add_settings_section()`

這個函式用來建立一個設定區塊，讓相關欄位集中顯示。

目前建立的是「基本設定」區塊，對應後台的設定頁。

```php
add_settings_section(
    'develop_plugin_main_section',
    '基本設定',
    'develop_render_settings_section',
    'develop-plugin-settings'
);
```

### 3. `add_settings_field()`

這個函式用來建立一個設定欄位，讓管理者可以在後台輸入內容。

目前建立的是「顯示訊息」欄位，使用者可以輸入要顯示的文字。

```php
add_settings_field(
    'develop_plugin_message_field',
    '顯示訊息',
    'develop_render_message_field',
    'develop-plugin-settings',
    'develop_plugin_main_section'
);
```

## 相關函式說明

### `develop_sanitize_message()`

這個函式負責在設定被儲存前清理使用者輸入的內容。

目前使用 `sanitize_text_field()`，可以避免過多不必要的 HTML 或特殊字元。

### `develop_render_message_field()`

這個函式負責輸出設定欄位的 HTML 表單元件，並顯示目前已儲存的值。

### `develop_render_settings_page()`

這個函式負責呈現設定頁面表單，讓使用者可以透過後台介面修改設定。

## 這個 hook 的學習重點

- `admin_init` 是管理後台初始化時很重要的 hook
- 適合用來註冊設定項目與選項
- 這個流程通常是建立後台設定頁的第一個步驟
- 在目前專案中，這個流程已經被整理到管理後台相關檔案中

## 在這個專案中的實際範例

目前這個外掛使用了：

```php
add_action('admin_init', 'develop_register_settings');
```

而 `develop_register_settings()` 內部會呼叫：

```php
register_setting(...);
add_settings_section(...);
add_settings_field(...);
```

這些流程讓外掛在管理後台中能夠正確建立設定欄位與設定頁面。

## 小結

`admin_init` hook 是 WordPress 外掛中常見的設定註冊入口。

在目前這個專案裡，它已經和管理選單、後台顯示與設定頁面一起，被整理到 [inc/admin.php](../inc/admin.php) 中，讓外掛的後台功能更清楚地分層管理。
