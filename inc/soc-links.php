<?php if (functions_exists('have_rows') && have_rows('soc_links', 'option')) : ?>
    <nav class="social-links">
        <?php while (have_rows('soc_links', 'option')) : the_row(); ?>
            <?php
            $instagram = get_sub_field('instagram');
            $youtube = get_sub_field('youtube');
            $facebook = get_sub_field('facebook');
            ?>

            <?php if (!empty($instagram)) : ?>
                <a class="social-links__instagram" target="_blank" rel="nofollow" href="<?= $instagram ?>">
                    <svg width="35" height="35">
                        <use xlink:href="#svg-icon--insta"></use>
                    </svg>
                </a>
            <?php endif ?>

            <?php if (!empty($youtube)) : ?>
                <a class="social-links__youtube" target="_blank" rel="nofollow" href="<?= $youtube ?>">
                    <svg width="40" height="32">
                        <use xlink:href="#svg-icon--youtube"></use>
                    </svg>
                </a>
            <?php endif ?>

            <?php if (!empty($facebook)) : ?>
                <a class="social-links__facebook" target="_blank" rel="nofollow" href="<?= $facebook ?>">
                    <svg width="21" height="35">
                        <use xlink:href="#svg-icon--fb"></use>
                    </svg>
                </a>
            <?php endif ?>
        <?php endwhile; ?>
    </nav>
<?php endif; ?>