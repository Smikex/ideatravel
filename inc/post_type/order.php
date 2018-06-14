<?php


function orders_post_types(){

	register_post_type( 'orders',
		array(
			'labels' => array(
				'name' => 'Order',
				'singular_name' => 'Order',
				'menu_name' => 'Orders',
				'all_items' => 'All Orders',
				'add_new' => 'Add Orders',
				'add_new_item' => 'Add New Orders',
				'edit_item' => 'Edit Order',
				'new_item' => 'New Order',
				'view_item' => 'View Order',
				'search_items' => 'Find Order',
				'not_found' => 'Orders not found',
				'not_found_in_trash' => 'В корзине Заказы не найдены',
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'show_ui' => true,
			'menu_position' => 1,
			'menu_icon' => 'dashicons-cart',
			//'taxonomies' => array('post_tag'),
			'supports' => array( 'title' ),
			'has_archive' => true,
			//'capability_type' => 'post',
			'rewrite' => false,
			'show_in_nav_menus' => true,
		)
	);



	//-----------------------------------------------------------------------------------------------------
}

add_action( 'init', 'orders_post_types' );
flush_rewrite_rules(); //first stert

function orders_acf_load_field( $field ) {
	//var_dump($field);
	switch ( $field['type'] ) {
		case 'post_object':
			$field['disabled'] = true;
			break;
		default:
			$field['readonly'] = 1;
	}


	return $field;
}
add_filter('acf/load_field/key=field_58c6ab3a62063', 'orders_acf_load_field');
add_filter('acf/load_field/key=field_58c6ab4562064', 'orders_acf_load_field');
add_filter('acf/load_field/key=field_58c6abcf62065', 'orders_acf_load_field');
add_filter('acf/load_field/key=field_58c6ac036e072', 'orders_acf_load_field');
add_filter('acf/load_field/key=field_58c6abf96e071', 'orders_acf_load_field');
add_filter('acf/load_field/key=field_58cbffb4131c7', 'orders_acf_load_field');





//-----------------------------------------------------------------------------------------------------
function theme_orders_add_columns_head($def) {
	$new = array();
	foreach( $def as $key => $val ) {
		$cc++;
		$new[$key] = $val;

		if ( $cc == 2 ) $new['order_contact'] = 'Контакты';
		if ( $cc == 2 ) $new['order_good'] = 'Товар';


		if ( $cc == 2 ) $new['ord_date'] = 'Дата заказа';
		if ( $cc == 2 ) $new['ord_status'] = 'Статус Заявки';

	}
	return $new;
}
function theme_orders_add_columns_body($column_name, $post_ID) {
	if ($column_name == 'order_contact') { ?>
		<?php the_field('name'); ?><br>
		<a href="mailto:<?php the_field('email'); ?>"><?php the_field('email'); ?></a><br>
		<a href="tel:+<?php preg_replace('/[^0-9]/', '', the_field('phone')); ?>"><?php the_field('phone'); ?></a><br>
		<?php
	}


	if ($column_name == 'order_good') {
		$tour_id = get_field('tour') ;
		if( $tour_id ) {
			echo '<a href="'.get_edit_post_link($tour_id).'">'.get_the_title( $tour_id ).'</a><br>';
			echo '<span>Выбранная Дата: '.get_field( 'date' ).'</span>';
		}

	}

	if ($column_name == 'ord_date') {
		echo get_the_date('d.m.Y H:i');
	}
	if ($column_name == 'ord_status') {
		//var_dump( get_post_stati() );

		$status = get_post_status();
		$disabled = $status == 'publish' ? 'disabled' : '';
		
		$pending = $status == 'pending' ? 'selected' : '';
		$publish = $status == 'publish' ? 'selected' : '';
		$paid = $status == 'paid' ? 'selected' : '';

		?>
		<div style="padding-top:7px;position: relative;">
			<span class="spinner" style="position: absolute;left: -40px;"></span>
			<select <?= $disabled ?> class="js_confirm-order" data-post-id="<?php echo get_the_ID(); ?>">
				<option <?= $pending ?> value="pending">На утверждении</option>
				<option <?= $publish ?> value="publish">Обработано</option>
				<option <?= $paid ?> value="paid">Оплачено</option>
			</select>
		</div>
		<?php
	}

}
add_filter('manage_orders_posts_columns', 		'theme_orders_add_columns_head');
add_action('manage_orders_posts_custom_column', 	'theme_orders_add_columns_body', 10, 2);


add_action( 'init', 'orders_custom_post_status' );
function orders_custom_post_status(){
	register_post_status( 'paid', array(
		'label'                     => 'Оплачено',
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Unread <span class="count">(%s)</span>', 'Unread <span class="count">(%s)</span>' ),
	) );
}

function add_to_post_status_dropdown($post){ ?>
	<script>
		jQuery(document).ready(function($){
			$("select#post_status").append("<option value=\"paid\" <?php selected('paid', $post->post_status); ?>>Оплачено</option>");
		});
	</script>
	<?php
}

add_action( 'post_submitbox_misc_actions', 'add_to_post_status_dropdown');

/**
 * All Styles
 */
function theme_post_types_columns_style() {
	?>
	<style>
		body.post-type-orders #the-list tr:nth-child(odd).status-pending th,
		body.post-type-orders #the-list tr:nth-child(odd).status-pending td {
			background: #ddffdd;
		}
		body.post-type-orders #the-list tr:nth-child(even).status-pending th,
		body.post-type-orders #the-list tr:nth-child(even).status-pending td {
			background: #DDFFCC;
		}

		body.post-type-orders #the-list tr:nth-child(odd).status-paid th,
		body.post-type-orders #the-list tr:nth-child(odd).status-paid td {
			background: #bdc8f1;
		}
		body.post-type-orders #the-list tr:nth-child(even).status-paid th,
		body.post-type-orders #the-list tr:nth-child(even).status-paid td {
			background: #d5deff;
		}
	</style>
	<?php
}

add_action('admin_head', 'theme_post_types_columns_style');

function theme_post_types_columns_scripts() { ?>
	<script>
		jQuery(document).ready(function($) {
			/* Order - Confirm */
			$('.js_confirm-order').change(function(event){
				event.preventDefault();
				var button = $(this);
				var spinner = $(this).parent().find('.spinner');
				var data_post_id = $(button).data('post-id');
				var selected = button.val();

				console.log( selected );

				if( ! button.hasClass('button_process') && 0 == 0){
					button.addClass('button_process');
					spinner.addClass('is-active');

					$.ajax({
						url: '<?php echo site_url() ?>/wp-admin/admin-ajax.php',
						type: "POST",
						data: {
							action: 'confirm',
							post_id : data_post_id,
							post_status : selected,
						},
						dataType: 'json',
						success : function(data){
							var data = data || {};
							if(data.errors){

							} else {

							}
							spinner.removeClass('is-active');
							button.removeClass('button_process');
							button.closest('tr').removeClass('status-publish status-pending status-paid').addClass('status-' + selected);

							if( selected == 'publish' ) {
								button.prop('disabled', true);
							}
						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);
							console.log(xhr);
						}
					});
				}
			});
		});

	</script>
	<?php
}
add_action('admin_head', 'theme_post_types_columns_scripts');


function ajax_confirm() {
	if( $_POST['post_status'] == 'publish' ) {
		wp_publish_post( (int)$_POST['post_id'] );
	} else {
		wp_update_post(array(
			'ID'    =>  (int)$_POST['post_id'],
			'post_status'   =>  $_POST['post_status']
		));
	}

	$data['success_message'] = 'Заказ обработан!';
	echo json_encode($data);
	wp_die();
}

if( is_admin() ) {
	add_action("wp_ajax_confirm", "ajax_confirm");
}

/**
 * Show Pending Numbers
 */
function show_pending_number( $menu ){
	$types = array( 'orders' );
	$status = 'pending';
	$status_paid = 'paid';
	foreach( $types as $type )
	{
		$num_posts = wp_count_posts( $type, 'readable' );
		$pending_count = 0;
		$paid_count = 0;
		if ( !empty($num_posts->$status) ) {
			$pending_count = $num_posts->$status;
		}
		if ( !empty($num_posts->$status_paid) ) {
			$paid_count = $num_posts->$status_paid;
		}
		if ($type == 'post') {
			$menu_str = 'edit.php';
		} else {
			$menu_str = 'edit.php?post_type=' . $type;
		}
		foreach( $menu as $menu_key => $menu_data ) {
			if( $menu_str != $menu_data[2] ) continue;
			$menu[$menu_key][0].= '<span style="background-color: #dfd;color: #000;" class="awaiting-mod count-'.$pending_count.'"><span class="pending-count">'.$pending_count.'</span></span>';
			$menu[$menu_key][0].= '<span style="background-color: #bdc8f1;" class="awaiting-mod count-'.$paid_count.'"><span class="pending-count">'.$paid_count.'</span></span>';
		}
	}
	return $menu;
}
add_filter('add_menu_classes', 'show_pending_number');