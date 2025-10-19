<?php

namespace CustomTheme\Helpers\Assets;

function create_asset_handle(string $path): string
{
    $path_handle = \ltrim($path, '/');
    $path_handle = \preg_replace('/\.[^.]+$/', '', $path_handle);

    return \CustomTheme\Config\Assets\ASSETS_HANDLE_PREFIX
        . \str_replace('/', '-', $path_handle);
}

function load_style(string $path): void
{
    wp_enqueue_style(
        create_asset_handle($path),
        get_template_directory_uri() . $path,
        [],
        wp_get_theme()->get('Version')
    );
}

function load_script(string $path): void
{
    wp_enqueue_script(
        create_asset_handle($path),
        get_template_directory_uri() . $path,
        [],
        wp_get_theme()->get('Version'),
        true
    );
}
