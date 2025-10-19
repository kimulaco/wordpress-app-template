<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php \CustomTheme\Helpers\Assets\load_style('/assets/css/main.css'); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php \CustomTheme\Helpers\Components\load_once('/components/layouts/site-header.php'); ?>

    <main>
        <?php if (have_posts()) : ?>
            <?php \CustomTheme\Helpers\Components\load_once('/components/modules/post-card-list.php'); ?>

            <?php the_posts_pagination(); ?>
        <?php endif; ?>
    </main>

    <?php \CustomTheme\Helpers\Components\load_once('/components/layouts/site-footer.php'); ?>

    <?php \CustomTheme\Helpers\Assets\load_script('/assets/js/main.js'); ?>

    <?php wp_footer(); ?>
</body>
</html>
