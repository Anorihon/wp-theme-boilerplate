<?php if (function_exists('pll_the_languages')) : ?>
    <div class="lang-choose">
        <?php
        $translations = pll_the_languages(['raw' => 1, 'hide_if_empty' => 0]);
        $count = count($translations);
        $i = 0;

        foreach ($translations as $translation) :
            $url = $translation['url'];

            echo sprintf(
                '<a href="%s" class="%s">%s</a>%s',
                $url,
                ($translation['current_lang'] == true ? 'active' : ''),
                strtoupper($translation['slug']),
                $i++ < $count - 1 ? '<span class="separator"></span>' : ''
            );
        endforeach;
        ?>
    </div>
<?php endif; ?>