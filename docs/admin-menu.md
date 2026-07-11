# admin_menu Hook 功能說明

## 這個 hook 的用途

`add_action('admin_menu', 'develop_register_menu');` 的作用，是在 WordPress 的管理後台準備建立選單時，執行我們自訂的 `develop_register_menu()` 函式。

這表示我們把自己的功能「掛」到 WordPress 的管理選單流程上，讓外掛在適當的時機自動顯示出來。

## 這段程式碼在做什麼

在這個外掛中，`develop_register_menu()` 會做兩件事：

1. 建立主選單
   - 例如「Develop 外掛學習」
2. 建立子選單
   - 例如「設定」

## 作用流程

1. WordPress 啟動管理後台
2. 觸發 `admin_menu` 這個 hook
3. 執行 `develop_register_menu()`
4. 使用 `add_menu_page()` 與 `add_submenu_page()` 建立選單
5. 使用者就能在後台看到外掛的入口

## 相關函式說明

### `add_menu_page()`

這個函式用來建立主選單。

它通常會接收這幾個參數：

- 頁面標題 $page_title string required
- 選單名稱 $menu_title string required
- 權限 $capability string required
- 選單 slug $menu_slug string required
- 點擊後要顯示的頁面函式 $function callable optional
- 圖示 $icon_url string optional
- 排列順序 $position int|float optional

### `add_submenu_page()`

這個函式用來建立子選單。
它通常用來把外掛的相關設定頁面掛在主選單之下。
它通常會接收這幾個參數：

- 主選單 slug $parent_slug string required
- 頁面標題 $page_title string required
- 選單名稱 $menu_title string required
- 權限 $capability string required
- 選單 slug $menu_slug string required
- 點擊後要顯示的頁面函式 $function callable optional

## 這個 hook 的學習重點

- `add_action()` 用來把自己的函式掛到 WordPress 的事件流程中
- `admin_menu` 是管理後台選單建立時的事件點
- 透過這個 hook，外掛可以在後台自動註冊入口

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

`admin_menu` hook 是 WordPress plugin 開發中非常常見的入口點。

它讓外掛能夠在管理後台中加入自己的選單與頁面，這是建立後台功能的第一步。
