<?php
// SECTION Manage columns
// ANCHOR Product category
add_filter('manage_edit-' . 'product_category' . '_columns', 'admin_product_category_columns');
function admin_product_category_columns($columns)
{
	$num = 2; // after which columns to insert new ones

	// Add new columns
	$new_columns = array(
		'product_category_photo' => 'Фото',
	);

	// Remove description column
	unset($columns['description']);

	return array_slice($columns, 0, $num) + $new_columns + array_slice($columns, $num);
}

add_action('manage_' . 'product_category' . '_custom_column', 'fill_product_category_columns', 15, 3);
function fill_product_category_columns($row, $column_name, $term_id)
{
	if ($column_name === 'product_category_photo') {
		$photo_id = get_field('productions_photo', 'product_category_' . $term_id);
		$photo_url = wp_get_attachment_image_url($photo_id, 'product_thumb');

		return $row . '<img width="150" src="' . $photo_url . '">';
	}

	return $row;
}

// ANCHOR Product
add_filter('manage_edit-' . 'products' . '_columns', 'admin_products_columns');
function admin_products_columns($columns)
{
	$num = 2; // after which columns to insert new ones

	$new_columns = array(
		'photo' => 'Фото',
		'brand' => 'Бренд',
		'prod_type' => 'Категория',
	);

	return array_slice($columns, 0, $num) + $new_columns + array_slice($columns, $num);
}

add_action('manage_' . 'products' . '_posts_custom_column', 'fill_products_columns', 5, 2);
function fill_products_columns($colname, $post_id)
{
	if ($colname === 'photo') {
		echo '<img src="' . get_the_post_thumbnail_url($post_id, 'product_thumb') . '" height="150">';
	}

	if ($colname === 'brand') {
		$brands = wp_get_post_terms($post_id, 'brands');

		if (!empty($brands)) {
			echo $brands[0]->name;
		}
	}

	if ($colname === 'prod_type') {
		$types = wp_get_post_terms($post_id, 'product_category');

		if (!empty($types)) {
			foreach ($types as $type) {
				printf('<div>%s</div>', $type->name);
			}
		}
	}
}
// !SECTION

// ANCHOR Admin head
add_action('admin_head', function () {
	// Hide add new taxonomy button
?>
	<style type="text/css">
		#brands-adder,
		#product_category-adder {
			display: none;
		}
	</style>
<?php
});

// ANCHOR Add filter products by category
add_action('restrict_manage_posts', 'add_products_table_filters');
function add_products_table_filters($post_type)
{
	if ($post_type === 'products') {
		wp_dropdown_categories([
			'show_option_all' => 'Все категории',
			'name' => 'prod_cat',
			'taxonomy' => 'product_category',
			'selected' => !empty($_GET['prod_cat']) ? $_GET['prod_cat'] : ''
		]);
		wp_dropdown_categories([
			'show_option_all' => 'Все бренды',
			'name' => 'brand',
			'taxonomy' => 'brands',
			'selected' => !empty($_GET['brand']) ? $_GET['brand'] : ''
		]);
	}
}

add_action('pre_get_posts', 'add_event_table_filters_handler');
function add_event_table_filters_handler($query)
{
	$cs = function_exists('get_current_screen') ? get_current_screen() : null;

	if (!is_admin() || empty($cs->post_type) || $cs->post_type != 'products')
		return;

	if ($_GET['prod_cat'] > 0) {
		$query->set('tax_query', array(
			[
				'taxonomy' => 'product_category',
				'field' => 'term_id',
				'terms' => $_GET['prod_cat']
			]
		));
	}

	if ($_GET['brand'] > 0) {
		$tax_query = $query->get('tax_query');
		$arr = [
			[
				'taxonomy' => 'brands',
				'field' => 'term_id',
				'terms' => $_GET['brand']
			]
		];

		if(!empty($tax_query)){
			$arr = array_merge($arr, $tax_query);
			$arr['relation'] = 'AND';
		}

		$query->set('tax_query', $arr);
	}
}

// Removing the tabs "All Categories" and "Frequently Used" from the metaboxes of categories (taxonomies) on the post edit page.
add_action('admin_print_footer_scripts', 'hide_tax_metabox_tabs_admin_styles', 99);
function hide_tax_metabox_tabs_admin_styles()
{
	$cs = get_current_screen();
	if ($cs->base !== 'post' || empty($cs->post_type)) return; // не страница редактирования записи
?>
	<style>
		.postbox div.tabs-panel {
			max-height: 1200px;
			border: 0;
		}

		.category-tabs {
			display: none;
		}
	</style>
<?php
}
