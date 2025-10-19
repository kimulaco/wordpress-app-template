<?php

namespace CustomTheme\Helpers\Components;

function load(string $component_path): void
{
    require get_template_directory() . $component_path;
}

function load_once(string $component_path): void
{
    require_once get_template_directory() . $component_path;
}
