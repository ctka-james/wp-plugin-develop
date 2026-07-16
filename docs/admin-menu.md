# admin_menu Hook 功能說明

## 這個 hook 的用途

`add_action('admin_menu', 'develop_register_menu');` 會在 WordPress 管理後台建立選單時執行 `develop_register_menu()`。

在目前的專案中，這段掛載是寫在 [inc/admin.php](../inc/admin.php) 裡，並由 [develop.php](../develop.php) 透過 `require_once` 載入，所以外掛啟動後，管理後台就會依照這個流程建立入口。

## 目前專案結構與位置

這個外掛目前的功能已經拆成不同檔案：

- [develop.php](../develop.php)：外掛主檔案，定義常數並載入管理與前台功能。
- [inc/admin.php](../inc/admin.php)：負責後台選單、設定頁與管理通知。
- [inc/frontend.php](../inc/frontend.php)：負責前台顯示與短碼。

因此，`admin_menu` 這個流程現在是由管理後台相關檔案來負責建立，而不是全部集中在主檔案中。

## 這段程式碼在做什麼

`develop_register_menu()` 目前會建立兩層管理入口：

1. 主選單
   - 名稱為「Develop 外掛學習」
2. 子選單
   - 名稱為「設定」

這代表外掛會在 WordPress 後台新增一個自己的管理入口，使用者可以從這裡進入外掛頁面。

## 執行流程

1. WordPress 進入管理後台
2. 觸發 `admin_menu` 這個 hook
3. 執行 `develop_register_menu()`
4. 使用 `add_menu_page()` 建立主選單
5. 使用 `add_submenu_page()` 建立子選單
6. 使用者就能在後台看到外掛入口

## 相關函式說明

### `add_menu_page()`

這個函式用來建立主選單，讓外掛有一個專屬的管理入口。

目前的實作是：

```php
add_menu_page(
    'Develop Plugin',
    'Develop 外掛學習',
    'manage_options',
    'develop-plugin',
    'develop_render_admin_page',
    'dashicons-welcome-learn-more',
    20
);
```

這段程式碼會在後台建立一個主選單，點擊後會顯示 `develop_render_admin_page()` 的內容。

### `add_submenu_page()`

這個函式用來建立子選單，通常是把設定頁掛在主選單底下。

目前的實作是：

```php
add_submenu_page(
    'develop-plugin',
    'Develop Plugin 設定',
    '設定',
    'manage_options',
    'develop-plugin-settings',
    'develop_render_settings_page'
);
```

這段程式碼會在主選單之下新增一個「設定」子選單，點擊後會顯示設定頁。

## 這個 hook 的學習重點

- `add_action()` 用來把自訂函式掛到 WordPress 的流程中
- `admin_menu` 是建立後台選單的關鍵 hook
- 透過這個 hook，外掛可以在管理後台自動加入自己的入口
- 在目前專案中，這個流程已經和設定頁、管理頁面一起整理在管理檔案中

## 在這個專案中的實際範例

目前這個外掛使用了：

```php
add_action('admin_menu', 'develop_register_menu');
```

而 `develop_register_menu()` 內部使用了：

```php
add_menu_page(...);
add_submenu_page(...);
```

這讓外掛在後台產生一個主選單與一個設定子選單。

## 小結

`admin_menu` hook 是 WordPress 外掛開發中非常常見的入口點。

在目前這個專案中，它已經和管理頁面、設定頁、後台資源載入一起，整理在 [inc/admin.php](../inc/admin.php) 中，讓外掛的後台功能更清楚地分層管理。
