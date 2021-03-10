<?php get_header(); ?>

<article>
    <div class="wrap">
        <?php while (have_posts()) : the_post(); ?>
            <h1 class="h1"><?php the_title(); ?></h1>
            <?php the_content(); ?>
        <?php endwhile; ?>
    </div>
</article>

<?php get_footer(); ?>