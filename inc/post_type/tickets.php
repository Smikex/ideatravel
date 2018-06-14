<?php

// post, page post type
add_filter( 'post_link', 'future_permalink', 10, 3 );
// custom post types
add_filter( 'post_type_link', 'future_permalink', 10, 4 );

function future_permalink( $permalink, $post, $leavename, $sample = false ) {
	/* for filter recursion (infinite loop) */
	static $recursing = false;

	if ( empty( $post->ID ) ) {
		return $permalink;
	}

	if ( !$recursing ) {
		if ( isset( $post->post_status ) && ( 'future' === $post->post_status ) ) {
			// set the post status to publish to get the 'publish' permalink
			$post->post_status = 'publish';
			$recursing = true;
			return get_permalink( $post, $leavename ) ;
		}
	}

	$recursing = false;
	return $permalink;
}	

add_filter('the_posts', 'show_future_posts');
function show_future_posts($posts){
   global $wp_query, $wpdb;
   if(is_single() && $wp_query->post_count ==0){
      $ps = $wpdb->get_results($wp_query->request);

      if( $ps[0]->post_type == 'tickets' ) {
		$posts = $ps;
      }
   }
   return $posts;
};


// регистрирующая новые таксономии (create_tickets_taxonomies)

add_action( 'init', 'create_tickets_taxonomies', 0 );



function create_tickets_taxonomies(){

	// определяем заголовки для ''

	$labels = array(

		'name' => 'Города',

		'singular_name' => 'Города',

		'search_items' =>  'Найти Город',

		'all_items' => 'Все Города',

		'parent_item' => '',

		'parent_item_colon' => '',

		'edit_item' => 'Отредактировать Город',

		'update_item' => 'Обновить Город',

		'add_new_item' => 'Добавить Город',

		'new_item_name' => 'Новий Город',

		'menu_name' => 'Города'

	);



	$args = array(

		'labels'                => $labels,

		'show_ui'               => true, // равен аргументу public

		'hierarchical'          => false,

		'rewrite' => true,

		'query_var'             => true, //$taxonomy, // название параметра запроса

		'meta_box_cb'           => 'ticket_kod_metaboksa', // callback функция. Отвечает за html код метабокса (с версии 3.8): post_categories_meta_box или post_tags_meta_box. Если указать false, то метабокс будет отключен вообще

		'show_admin_column'     => true, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)

	);



	register_taxonomy('ticket_tag', array('tickets'), $args);



}





//----------<Делаем метабокс меток по типу рубрик>------------





/* Содержимое метабокса */

function ticket_kod_metaboksa($post) {

	// в данном случае мы просто получаем все метки на блоге в виде массива объектов

	$vse_metki = get_terms('ticket_tag', array('hide_empty' => 0) );



	// а теперь - все метки, которые присвоены к записи

	$vse_metki_posta = get_the_terms( $post->ID, 'ticket_tag' );



	// создаем массив меток поста, состоящий из их ID - он понадобится нам позднее

	$id_metok_posta = array();

	if ( $vse_metki_posta ) {

		foreach ($vse_metki_posta as $metka ) {

			$id_metok_posta[] = $metka->term_id;

		}

	}



	// начинаем выводить HTML

	echo '<div id="taxonomy-post_tag" class="categorydiv" style="max-height: 180px; overflow: auto;">';

	echo '<input type="hidden" name="tax_input[ticket_tag][]" value="0" />';

	echo '<ul>';

	// запускаем цикл для каждой из меток

	foreach( $vse_metki as $metka ){

		// по умолчанию чекбокс отключен

		$checked = "";

		// но если ID метки содержится в массиве присвоенных меток поста, то отмечаем чекбокс

		if ( in_array( $metka->term_id, $id_metok_posta ) ) {

			$checked = " checked='checked'";

		}

		// ID чекбокса (часть) и ID li-элемента

		$id = 'ticket_tag-' . $metka->term_id;

		echo "<li id='{$id}'>";

		echo "<label><input type='radio' name='tax_input[ticket_tag][]' id='in-$id'". $checked ." value='$metka->slug' /> $metka->name</label><br />";

		echo "</li>";

	}

	echo '</ul></div>'; // конец HTML

}

//----------</Делаем метабокс меток по типу рубрик>------------





//фильтр

function true_taxonomy_filter() {

	global $typenow; // тип поста

	if( $typenow == 'tickets' ){ // для каких типов постов отображать

		$taxes = array('ticket_tag'); // таксономии через запятую

		foreach ($taxes as $tax) {

			$current_tax = isset( $_GET[$tax] ) ? $_GET[$tax] : '';

			$tax_obj = get_taxonomy($tax);

			$tax_name = mb_strtolower($tax_obj->labels->name);

			// функция mb_strtolower переводит в нижний регистр

			// она может не работать на некоторых хостингах, если что, убирайте её отсюда

			$terms = get_terms($tax);

			if(count($terms) > 0) {

				echo "<select name='$tax' id='$tax' class='postform'>";

				echo "<option value=''>Все $tax_name</option>";

				foreach ($terms as $term) {

					echo '<option value='. $term->slug, $current_tax == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';

				}

				echo "</select>";

			}

		}

	}

}



add_action( 'restrict_manage_posts', 'true_taxonomy_filter' );


add_action( 'init', 'tickets_post_types' );

function tickets_post_types(){

	$labels = array(

		'name' => 'Tickets',

		'singular_name' => 'Tickets',

		'menu_name' => 'Tickets',

		'all_items' => 'All Tickets',

		'add_new' => 'Add Tickets',

		'add_new_item' => 'Add New Tickets',

		'edit_item' => 'Edit Tickets',

		'new_item' => 'New Tickets',

		'view_item' => 'View Tickets',

		'search_items' => 'Find Tickets',

		'not_found' => 'Tickets not found',

		'not_found_in_trash' => 'В корзине Tickets не найдены',

	);

	register_post_type( 'tickets',

		array(

			'labels' => $labels,

			'public' => true,

			'publicly_queryable' => true,

			'query_var' => true,

			'show_ui' => true,

			'menu_position' => 11,

			'menu_icon' => 'dashicons-tickets-alt',

			'taxonomies' => array('tickets_tag'),

			'supports' => array( 'title', 'editor', 'thumbnail','excerpt'),

			'has_archive' => true,

			'capability_type' => 'post',

			'rewrite' => array( 'slug' => 'tickets','with_front' => FALSE),

			'show_in_nav_menus' => true,

		)

	);



	//-----------------------------------------------------------------------------------------------------




}









//flush_rewrite_rules(); //first stert

