<footer>
    <?php
    if (has_nav_menu('footer')) {
        wp_nav_menu([
            'theme_location' => 'footer',
            'container' => 'nav',
        ]);
    }
    ?>

    <p><small>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></small></p>
</footer>
