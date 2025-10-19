<?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <article id="post-<?php the_ID(); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>

        <?php if (is_home()) : ?>
            <h2>
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>
        <?php else : ?>
            <h1><?php the_title(); ?></h1>
        <?php endif; ?>

        <div>
            <?php echo get_the_date(); ?> | <?php the_author(); ?>
        </div>

        <div>
            <?php the_excerpt(); ?>
        </div>
    </article>
<?php endwhile; ?>
