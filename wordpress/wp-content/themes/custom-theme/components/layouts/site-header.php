<header>
    <?php if (is_home()) : ?>
        <h1><?php bloginfo('name'); ?></h1>
    <?php else : ?>
        <p><?php bloginfo('name'); ?></p>
    <?php endif; ?>

    <p><?php bloginfo('description'); ?></p>

    <?php
    if (has_nav_menu('global_nav')) {
        wp_nav_menu([
            'theme_location' => 'global_nav',
            'container' => 'nav',
        ]);
    }
    ?>
</header>
