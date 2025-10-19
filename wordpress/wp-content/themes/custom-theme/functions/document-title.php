<?php

namespace CustomTheme\Functions\DocumentTitle;

/**
 * @param array<string, string> $title - title parts
 * @return array<string, string> $title - title parts
 */
function setup_document_title_parts(array $title): array
{
    // $title['title'] - ページタイトル
    // $title['page'] - ページ番号（2ページ目以降）
    // $title['tagline'] - サイトのキャッチフレーズ（トップページのみ）
    // $title['site'] - サイト名
    return $title;
}

/**
 * @param string $separator - default: '-'
 * @return string
 */
function setup_document_title_separator(string $separator): string
{
    return '|';
}
