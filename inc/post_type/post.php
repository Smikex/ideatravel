<?php



function change_post_menu_label() {

	global $menu;

	global $submenu;



	$menu[5][0] = 'Tours';

	$submenu['edit.php'][5][0] = 'Все Tours';

	$submenu['edit.php'][10][0] = 'Добавить Tour';

	//$submenu['edit.php'][15][0] = 'Каталоги';

	$submenu['edit.php'][16][0] = 'Города';

	echo '';

}

function change_post_object_label() {

	global $wp_post_types;

	$labels = &$wp_post_types['post']->labels;

	$labels->name = 'Tours';

	$labels->singular_name = 'Tours';

	$labels->add_new = 'Добавить Tour';

	$labels->add_new_item = 'Добавить новый Tour"';

	$labels->edit_item = 'Изменить Tour';

	$labels->new_item = 'Новый Tour';

	$labels->view_item = 'Посмотреть Tour';

	$labels->search_items = 'Найти Tour';

	$labels->not_found = 'Не найдено';

	$labels->not_found_in_trash = 'В корзине ничего не найдено';

}





add_action( 'init', 'change_post_object_label' );

add_action( 'admin_menu', 'change_post_menu_label' );





/** Edit метабокса*/

add_action( 'admin_menu', 'edit_metaboks');

function edit_metaboks(){

	$id = 'tagsdiv-post_tag'; // ID

	$zagolovok = 'Посещаемые Города';

	$prioritet = 'default'; // приоритет вывода, нам подойдет default

	add_meta_box( $id, $zagolovok, 'post_tags_meta_box', 'post', 'side', $prioritet );

}





add_action( 'admin_head', 'add_custom_script' );



function add_custom_script() {

	?>

	<style>

		#tagsdiv-post_tag .tagchecklist > span:not(:last-child):after {

			content: ' 🡆';

		}

	</style>

	<?php

}





/** создаем новую колонку */

add_filter('manage_post_posts_columns', 'post_price_add_columns_head');



function post_price_add_columns_head( $columns ){

	$num = 4; // после какой по счету колонки вставлять новые



	$new_columns = array(

		'price' => 'Цена',

	);



	return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );

}



/** заполняем колонку данными */

add_filter('manage_post_posts_custom_column', 'post_price_add_columns_body', 5, 2); // wp-admin/includes/class-wp-posts-list-table.php



function post_price_add_columns_body($column_name, $post_id) {

	if( $column_name == 'price' ) {

		if( get_field('price_old', $post_id) ) {
			echo '<strike style="color:#ff0000;">'.number_format(get_field('price_old', $post_id), 2, ',', ' ').' ₽</strike><br>';
		}

		if( get_field('price_curent', $post_id) ) {
			echo '<strong style="color:#2ca21d;">'.number_format(get_field('price_curent', $post_id), 2, ',', ' ').' ₽</strong>';
		}

	}



}



/** добавляем возможность сортировать колонку */

add_filter('manage_edit-post_sortable_columns', 'add_price_sortable_column');

function add_price_sortable_column($sortable_columns){

	$sortable_columns['price'] = 'price_price';



	return $sortable_columns;

}



/** изменяем запрос при сортировке колонки */

add_filter( 'posts_clauses', 'add_column_views_request', 10, 2 );

function add_column_views_request( $clauses, $wp_query ){

	if( $wp_query->query['post_type'] = 'tickets' && isset($wp_query->query['orderby']) && 'price_price' == $wp_query->query['orderby'] ) {

		global $wpdb;



		$clauses['join'] .= " LEFT JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID={$wpdb->postmeta}.post_id";

		$clauses['where'] .= " AND {$wpdb->postmeta}.meta_key='price_curent'";

		$clauses['orderby']  = " {$wpdb->postmeta}.meta_value+0 ";

		$clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';

	}



	// еще изменяемые элементы

	//$clauses['groupby']

	//$clauses['distinct']

	//$clauses['fields'] // wp_posts.*

	//$clauses['limits'] // LIMIT 0, 20



	return $clauses;

}

