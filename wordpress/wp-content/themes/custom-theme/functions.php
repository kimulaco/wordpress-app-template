<?php

namespace CustomTheme;

$theme_dir = get_template_directory();

require_once "{$theme_dir}/config/assets.php";
require_once "{$theme_dir}/config/menus.php";
require_once "{$theme_dir}/config/widgets.php";
require_once "{$theme_dir}/functions/document-title.php";
require_once "{$theme_dir}/helpers/assets.php";
require_once "{$theme_dir}/helpers/components.php";

/**
 * サイトの設定
 */
add_action('after_setup_theme', function () {
    // <title>タグを出力
    add_theme_support('title-tag');

    // アイキャッチ画像を有効化
    add_theme_support('post-thumbnails');

    // RSS Feedリンクのレンダリングを有効化
    add_theme_support('automatic-feed-links');

    // 埋め込みコンテンツのレスポンシブ対応をサポート
    // add_theme_support('responsive-embeds');

    // WPのコンポーネントのレンダリングをHTML5形式にする
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ]);
});

add_filter(
    'document_title_parts',
    \CustomTheme\Functions\DocumentTitle\setup_document_title_parts(...),
);
add_filter(
    'document_title_separator',
    \CustomTheme\Functions\DocumentTitle\setup_document_title_separator(...),
);

/**
 * ダッシュボードの設定
 */
add_action('after_setup_theme', function () {
    // ブロックエディタをサポート
    add_theme_support('editor-styles');
    // add_editor_style('assets/css/editor-style.css');

    // ブロックエディタの幅設定を有効化
    add_theme_support('align-wide');

    // ダッシュボード->外観->メニュー の設定
    register_nav_menus(\CustomTheme\Config\Menus\MENUS_LOCATION);
});

add_action('widgets_init', function () {
    // ダッシュボード->外観->ウィジェット の設定
    foreach (\CustomTheme\Config\Widgets\WIDGETS_LISTS as $widget) {
        register_sidebar($widget);
    }
});
