<!DOCTYPE html>
<html <?= function_exists('pll_current_language') ? 'lang="' . pll_current_language() . '"' : '' ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    $icons_url = get_bloginfo('template_url') . '/favicon';
    ?>
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $icons_url ?>/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= $icons_url ?>/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $icons_url ?>/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= $icons_url ?>/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= $icons_url ?>/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= $icons_url ?>/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= $icons_url ?>/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= $icons_url ?>/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $icons_url ?>/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= $icons_url ?>/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $icons_url ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= $icons_url ?>/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $icons_url ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= $icons_url ?>/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= $icons_url ?>/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php get_template_part('inc/svg-defs'); ?>

    <div id="mob-menu">
        <div class="wrap">
            <header>
                <?php get_template_part('inc/logo'); ?>
                <div class="burger active">
                    <span></span>
                </div>
            </header>
            <div class="content">
                <?php //get_template_part('inc/lang-choose'); ?>

                <?php
                wp_nav_menu([
                    'theme_location'  => 'main_nav',
                    'menu'            => '',
                    'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                    'container'       => 'nav',
                    'container_class' => 'mob-menu__menu-nav',
                    'menu_class'      => 'mob-menu__menu',
                ]);
                ?>
            </div>
        </div>
    </div>

    <header id="main-header">
        <div class="wrap">
            <?php get_template_part('inc/logo'); ?>

            <?php
            wp_nav_menu([
                'theme_location'  => 'main_nav',
                'menu'            => '',
                'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                'container'       => 'nav',
                'container_class' => 'main-header__menu-nav',
                'menu_class'      => 'main-header__menu',
            ]);
            ?>

            <?php //get_template_part('inc/lang-choose'); ?>

            <div class="burger">
                <span></span>
            </div>
        </div>
    </header>

    <main role="main">
        <?php if (function_exists('dimox_breadcrumbs') && !is_home() && !is_front_page()) dimox_breadcrumbs(); ?>