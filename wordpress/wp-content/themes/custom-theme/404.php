<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php \CustomTheme\Helpers\Assets\load_style('/assets/home.css'); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php \CustomTheme\Helpers\Components\load_once('/components/layouts/site-header.php'); ?>

    <main>
        <div class="error-404">
            <h1>404</h1>
            <h2>ページが見つかりません</h2>
            <p>お探しのページは存在しないか、移動または削除された可能性があります。</p>
            <p>
                <a href="<?php echo esc_url(home_url('/')); ?>">トップページに戻る</a>
            </p>
        </div>
    </main>

    <?php \CustomTheme\Helpers\Components\load_once('/components/layouts/site-footer.php'); ?>

    <?php \CustomTheme\Helpers\Assets\load_script('/assets/home.js'); ?>

    <?php wp_footer(); ?>
</body>
</html>
