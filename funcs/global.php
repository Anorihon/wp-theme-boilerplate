<?php
// ANCHOR print_debug
/**
 * Print content in pre tags
 * Can be hidden by class if second argument = true
 */
function print_debug($s, $is_hidden = false)
{
	echo '<pre class="' . ($is_hidden == true ? 'hidden' : '') . '">';
	print_r($s);
	echo '</pre>';
}


// SECTION Theme support
// ANCHOR title-tag
/*
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 */
add_theme_support('title-tag');

// ANCHOR Enable thumbnails
add_theme_support('post-thumbnails');
// !SECTION


// ANCHOR Custom menus
if (function_exists('register_nav_menus')) {
	register_nav_menus(array(
		'main_nav' => 'Главное меню',
		'footer_nav' => 'Меню в футере',
	));
}


// ANCHOR Control revisions count
function my_revisions_to_keep($revisions)
{
	return 0;
}
add_filter('wp_revisions_to_keep', 'my_revisions_to_keep');


// ANCHOR Remove admin bar
show_admin_bar(false);


// ANCHOR Clean up the <head>
function removeHeadLinks()
{
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');


// ANCHOR ACF settings
if (function_exists('acf_add_options_page')) {
	// Add global options page
	acf_add_options_page(array(
		'page_title' 	=> 'Общие настройки',
		'menu_title'	=> 'Общие настройки',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'post_id' => 'options',
		'redirect'	=> false
	));

	// acf_add_options_sub_page(array(
	//     'page_title' 	=> 'Theme Footer Settings',
	//     'menu_title'	=> 'Footer',
	//     'parent_slug'	=> 'theme-general-settings',
	//      'menu_slug' => "foot",
	// 	 'post_id' => 'foot',
	// ));
}

// ANCHOR get_tel func
/**
 * Return phone for link with tel href
 * 
 * @param string $phone
 * @return string phone in fromat for use in link href
 */
function get_tel($phone)
{
	return preg_replace('/[^\++0-9]/', '', $phone);
}

// ANCHOR Languages
// add_action('after_setup_theme', 'my_theme_setup');
// function my_theme_setup()
// {
// 	load_theme_textdomain('boilerplate', get_template_directory() . '/languages');
// }

// ANCHOR Add image sizes
if (function_exists('add_image_size')) {
	// x-axis (left, center, right) and y-axis (top, center, bottom)

	// add_image_size('product_thumb', 540, 470, array('center', 'bottom'));
	// add_image_size('intro_photo', 1255, 600, array('center', 'bottom'));
}

// ANCHOR nl2p func
function nl2p($string, $line_breaks = true, $xml = true)
{

	$string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);

	// It is conceivable that people might still want single line-breaks
	// without breaking into a new paragraph.
	if ($line_breaks == true)
		return '<p>' . preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '$1<br' . ($xml == true ? ' /' : '') . '>$2'), trim($string)) . '</p>';
	else
		return '<p>' . preg_replace(
			array("/([\n]{2,})/i", "/([\r\n]{3,})/i", "/([^>])\n([^<])/i"),
			array("</p>\n<p>", "</p>\n<p>", '$1<br' . ($xml == true ? ' /' : '') . '>$2'),

			trim($string)
		) . '</p>';
}


// SECTION Remove WP emoji's
/**
 * Disable the emoji's
 */
function disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
	add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
	if ('dns-prefetch' == $relation_type) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

		$urls = array_diff($urls, array($emoji_svg_url));
	}

	return $urls;
}
// !SECTION

// Remove comments from pages
add_action('init', 'remove_comment_support', 100);

function remove_comment_support()
{
	remove_post_type_support('page', 'comments');
}

// ANCHOR Admin menu
add_action('admin_menu', 'remove_menus');
function remove_menus()
{

	// remove_menu_page( 'index.php' );                  // Консоль
	// remove_menu_page('edit.php');                   // Записи
	// remove_menu_page( 'upload.php' );                 // Медиафайлы
	// remove_menu_page( 'edit.php?post_type=page' );    // Страницы
	// remove_menu_page('edit-comments.php');          // Комментарии
	// remove_menu_page( 'themes.php' );                 // Внешний вид
	// remove_menu_page( 'plugins.php' );                // Плагины
	// remove_menu_page( 'users.php' );                  // Пользователи
	// remove_menu_page( 'tools.php' );                  // Инструменты
	// remove_menu_page( 'options-general.php' );        // Параметры
}

// Remove H2 from pagination template
add_filter('navigation_markup_template', 'my_navigation_template', 10, 2);
function my_navigation_template($template, $class)
{
	/*
	Base template:
	<nav class="navigation %1$s" role="navigation">
		<h2 class="screen-reader-text">%2$s</h2>
		<div class="nav-links">%3$s</div>
	</nav>
	*/

	return '
	<nav class="navigation %1$s" role="navigation">
		<div class="nav-links">%3$s</div>
	</nav>    
	';
}

// Remove empty paragraphs
add_filter('the_content', 'remove_empty_p', 20, 1);
function remove_empty_p($content)
{
	$content = force_balance_tags($content);
	return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
}

// Get first image from post content
function get_post_first_image()
{
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $post->post_content, $matches);
	$first_img = $matches[1][0];

	// if (empty($first_img)) { //Defines a default image
	// 	//   $first_img = "/images/default.jpg";
	// 	$first_img = null;
	// }
	return $first_img;
}

// ANCHOR Excerpt
/**
 * Excerpt more
 */
add_filter('excerpt_more', function ($more) {
	return '...';
});

/**
 * Limit excerpt to a number of characters
 * 
 * @param string $excerpt
 * @return string
 */
function setup_excerpt($excerpt)
{
	return mb_substr($excerpt, 0, 50) . '...';
}
add_filter('the_excerpt', 'setup_excerpt');

function get_custom_excerpt($string, $len = 50)
{
	return mb_strlen($string) > $len ? mb_substr($string, 0, $len) . "..." : $string;
}

// Remove update alerts for all except admin
// add_action('admin_head', function () {
// 	if (!current_user_can('manage_options')) {
// 		remove_action('admin_notices', 'update_nag', 3);
// 		remove_action('admin_notices', 'maintenance_nag', 10);
// 	}
// });

// SECTION Rewrite urls
// ANCHOR Fix WordPress custom taxonomy pagination 404 error
function generate_taxonomy_rewrite_rules($wp_rewrite)
{
	$rules = array();

	$post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects');
	$taxonomies = get_taxonomies(array('public' => true, '_builtin' => false), 'objects');

	foreach ($post_types as $post_type) {
		$post_type_name = $post_type->name;
		$post_type_slug = $post_type->rewrite['slug'];

		foreach ($taxonomies as $taxonomy) {
			if ($taxonomy->object_type[0] == $post_type_name) {
				$terms = get_categories(array('type' => $post_type_name, 'taxonomy' => $taxonomy->name, 'hide_empty' => 0));
				foreach ($terms as $term) {
					$rules[$post_type_slug . '/' . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
					$rules[$post_type_slug . '/' . $term->slug . '/page/?([0-9]{1,})/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug . '&paged=' . $wp_rewrite->preg_index(1);
				}
			}
		}
	}

	$wp_rewrite->rules = $rules + $wp_rewrite->rules;
}

add_action('generate_rewrite_rules', 'generate_taxonomy_rewrite_rules');
// !SECTION