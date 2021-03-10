<?php
function get_manifest_assets($filename, $deps = [], $ver = '', $in_footer = true)
{
    $manifestPath = __DIR__ . '/../assets/manifest.json';

    if (!file_exists($manifestPath)) {
        return new \WP_Error('manifest', 'The Manifest file can not be found.', $manifestPath);
    }

    $manifest = json_decode(file_get_contents($manifestPath), true);

    // Attempt to match the requested file.
    if (!array_key_exists($filename, is_array($manifest) ? $manifest : [])) {
        return new \WP_Error('manifest', 'The requested file could not be matched.', $filename);
    }

    $dir = get_template_directory_uri() . '/assets/';

    if (isset($manifest[$filename]['css'])) {
        foreach ($manifest[$filename]['css'] as $css) :
            $basename = basename($css);
            $splited = explode('.', $basename);

            wp_enqueue_style($splited[0] . '_css', $dir . $css, array(), filemtime(__DIR__ . '/../assets/' . $css), false);
        endforeach;
    }

    foreach ($manifest[$filename]['js'] as $script) :
        $basename = basename($script);
        $splited = explode('.', $basename);
        $script_name = $splited[0] == 'vendor' ? $splited[1] : $splited[0];

        $file = $dir . $script;

        wp_enqueue_script(
            $script_name,
            $file,
            $deps,
            empty($ver) ? filemtime(__DIR__ . '/../assets/' . $script) : $ver,
            $in_footer
        );

    // $deps[] = $script_name;
    endforeach;
}

function custom_assets()
{
    // wp_deregister_script('jquery');
    wp_deregister_script('wp-embed');

    // wp_enqueue_script('jquery');

    get_manifest_assets('global');

    // Global variables
    wp_localize_script(
        'global',
        'myajax',
        array(
            'url' => admin_url('admin-ajax.php?lang=ru')
        )
    );

    // if (is_home() || is_front_page()) {
    //     get_manifest_assets('home', ['global']);
    // } elseif (is_page_template('page__contacts.php')) {
    //     get_manifest_assets('contacts', ['global']);
    // } 
}
add_action('wp_enqueue_scripts', 'custom_assets');


add_action('admin_enqueue_scripts', 'load_admin_assets');
function load_admin_assets()
{
    get_manifest_assets('admin');
}
