<?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <article id="post-<?php the_ID(); ?>">
        <h1><?php the_title(); ?></h1>

        <div>
            <?php echo get_the_date(); ?> | <?php the_author(); ?>
        </div>

        <?php if (has_post_thumbnail()) : ?>
            <div>
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>

        <div>
            <?php the_content(); ?>
        </div>
    </article>
<?php endwhile; ?>
