    <footer class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
        <div class="wrap">
            <div itemscope itemtype="http://schema.org/Organization" class="logo">
                <a itemprop="url" href="<?= get_bloginfo('url') ?>">
                    <img itemprop="logo" alt="Logo" src="" />
                </a>
            </div>

            <?php
            wp_nav_menu([
                'theme_location'  => 'footer_nav_1',
                'items_wrap' => sprintf('<div class="menu-title">%s</div>', __('Навигация', 'invest')) . '<ul class="%2$s">%3$s</ul>',
                'menu'            => '',
                'container'       => 'nav',
                'container_class' => 'footer-menu-nav',
                'menu_class'      => 'footer__menu',
            ]);
            ?>

            <div class="copyright">
                <span itemprop="copyrightYear"><?php echo date("Y"); ?></span> <?php bloginfo('name'); ?>
            </div>
            <div class="created-by site-footer__sidebar" itemprop="creator">
                <span>Produced by</span>
                <div itemscope itemtype="http://schema.org/Organization" class="logo">
                    <a itemprop="url" href="https://it-ava.com/" rel="nofollow" target="_blank">
                        <img class="logo__image" itemprop="logo" alt="AVA" src="<?= get_bloginfo('template_url') . '/assets/img/ava-logo.svg' ?>" />
                    </a>
                </div>
            </div>
        </div>
    </footer>

    </main>

    <?php wp_footer(); ?>
    </body>

    </html>