<?php

include_once 'inc/sberbank/Gateway.php';

//add_action( 'wp_head', 'redirect_non_logged_users_to_specific_page' );

function redirect_non_logged_users_to_specific_page() {

	if ( !is_user_logged_in() ) {
		wp_redirect( '/preland/index.html' );
    	exit;
	}
}


function theme_includes(){
	include_once( get_stylesheet_directory() . '/inc/dynamic-fields.php' );
	include_once( get_stylesheet_directory() . '/inc/global_function.php' );

	include_once( get_stylesheet_directory() . '/inc/post_type/tickets.php' );
	include_once( get_stylesheet_directory() . '/inc/post_type/citys.php' );
	include_once( get_stylesheet_directory() . '/inc/post_type/post.php' );

	include_once( get_stylesheet_directory() . '/inc/post_type/order.php' );
	include_once( get_stylesheet_directory() . '/inc/alfabank/controller.php' );



	include_once( get_stylesheet_directory() . '/inc/validator/index.php');


	//include_once( get_stylesheet_directory() . '/inc/menu/index.php' );


	include_once( get_stylesheet_directory() . '/inc/admin/material/index.php' );
	include_once( get_stylesheet_directory() . '/inc/admin/polyarix.php' );

	if (get_current_user_id() != 1 ) {
		include_once( get_stylesheet_directory() . '/inc/admin-custom.php' );
		add_filter('acf/settings/show_admin', '__return_false'); // Hide ACF field group menu item /edit.php?post_type=acf-field-group
	}


}

function theme_settings() {
	add_image_size( '480x470', 480, 470, array( 'center', 'center' ));
	add_image_size( '700x340', 700, 340, array( 'center', 'center' ));
	add_image_size( '700x465', 700, 465, array( 'center', 'center' ));
	add_image_size( '580x600', 580, 600, array( 'center', 'center' ));

	add_image_size( '1920x510', 1920, 510, array( 'center', 'center' ));
	add_image_size( '1920x750', 1920, 750, array( 'center', 'center' ));

	add_image_size( '1180x715', 1180, 715, array( 'center', 'center' ));

	add_image_size( '480x512', 480, 512, false);
	add_image_size( '300x406', 300, 406, false);
	add_image_size( '212x127', 212, 127, false);
	add_image_size( '780x425', 780, 425, true);
	add_image_size( '380x425', 380, 425, array( 'center', 'center' ));
	add_image_size( '380x217', 380, 217, array( 'center', 'center' ));
	add_image_size( '380x316', 380, 316, array( 'center', 'center' ));
	add_image_size( '380x260', 380, 260, array( 'center', 'center' ));
	add_image_size( '364x364', 364, 364, array( 'center', 'center' ));
	add_image_size( 'big', 1024, 768, false);
}

theme_settings();

theme_includes();


add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

function my_scripts_method() {
	wp_deregister_script( 'jquery' );
	//wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js', '', '', true);
	wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery.min.js', '', '', true);
	wp_enqueue_script( 'jquery' );

	wp_enqueue_script('vendor', get_template_directory_uri() . '/js/vendor.js', array(), '1.0.0', true);
	wp_enqueue_script('main', 	get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true);
	wp_enqueue_script('wp', 	get_template_directory_uri() . '/js/wp.js', array(), '1.1.0', true);

	if( is_singular( 'citys' ) || is_page_template( 'page-contacts.php' ) ) {

		if( is_singular( 'citys' ) ) 						$callback = 'cityMapInit';
		if( is_page_template( 'page-contacts.php' ) ) 		$callback = 'contactsMapInit';

		wp_enqueue_script('googlemap', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBEMVHST3aq0Ig-GJGoAVk2cxb4V3_-jRs&amp;callback='.$callback, array(), '', true);
	}

	if( is_page_template( 'page-transfers.php' ) ) {
		wp_enqueue_script('inputmask', 	get_template_directory_uri() . '/js/jquery.inputmask.bundle.min.js', array(), '1.0.0', true);
	}

	wp_localize_script( 'wp', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	//wp_enqueue_script('wp-util');
}


add_filter( 'body_class', function( $classes ) {
	$classes_new = [];

	if ( is_front_page() )                                          $classes_new[] = 'index';
	if ( is_singular( 'citys' ) )                                   $classes_new[] = 'city-page';
	if ( is_singular( 'tickets' ) )                                 $classes_new[] = 'event';
	if ( is_post_type_archive('citys') )							$classes_new[] = 'cities-page';
	if ( is_post_type_archive('tickets') )							$classes_new[] = 'tickets-page';
	if ( is_singular('post') )										$classes_new[] = 'tour-page';
	if ( is_page_template( 'tours-archive.php' ) )                  $classes_new[] = 'tours-page';
	if ( is_page_template( 'page-transfers.php' ) )                 $classes_new[] = 'transfer-page';
	if ( is_page_template( 'search-filter.php' ) )                  $classes_new[] = 'results-page';
	if ( is_search() )                                    			$classes_new[] = 'results-page';
	if ( is_category()  )                                           $classes_new[] = 'tours-page';

	return $classes_new;
} );



function custom_posts_per_page($query){
	if(is_post_type_archive('tickets') ){
		$query->set('posts_per_page',10);
		$query->set('post_status',array( 'publish', 'future' ));
	}
	if(is_category()){
		$query->set('posts_per_page',8);
	}
	if( is_page_template( 'search-filter.php' ) ){
		$query->set('is_paged',true);
	}
}
add_action('pre_get_posts','custom_posts_per_page');


register_nav_menus(array(
	'desc-menu'    => 'Меню',    //Название месторасположения меню в шаблоне
));




//---<VIEWS POST>
add_action( 'wp', 'city_views_cookie' );
function city_views_cookie() {

	if( is_post_type_archive('citys') ){
		global $post;

		$id= $post->ID;


		if( is_singular( 'citys' ) ) {
			if( !isset($_COOKIE['post_'.$id]) ) {
				$count = get_field('views', $id) + 1;
				setcookie( 'post_'.$id, $count );
				update_field( 'views', $count, $id );
			}
		}
	}

}
//---</VIEWS POST>

if (defined('DOING_AJAX') && DOING_AJAX) {
	add_action('setup_theme', 'mytheme_setup_theme');
}

/**
 * React early in WordPress execution on an AJAX request to set the current language.
 */
function mytheme_setup_theme() {
	global $sitepress;

	// Switch lang if necessary - check for our AJAX action
	if (method_exists($sitepress, 'switch_lang') && isset($_GET['wpml_lang']) && $_GET['wpml_lang'] !== $sitepress->get_default_language()) {
		$sitepress->switch_lang($_GET['wpml_lang'], true);
	}
}

// Function to change email address

function wpb_sender_email( $original_email_address ) {
  return 'info@ideatravelrussia.com';
}

// Function to change sender name
function wpb_sender_name( $original_email_from ) {
  return 'Idea Travel Russia';
}

// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

//

function get_mail() {
	$email_list='';

	$email_array = get_field('field_mail_to','option');

	//$email_array - array
	end($email_array); // перемещаем указатель в конец массива
	$last = key($email_array); // получаем последний ключ
	foreach ($email_array as $k => $v){
		$email_list .= $v['mail'];//
		if ($k !== $last) {
			$email_list .=  ', ';
		} // если текущий ключ не последний, выводим запятую
	}

	return $email_list;
}

function get_bcc_mail() {
	$email_bcc = '';
	if ($email_bcc_array = get_field('field_mail_bcc','option')) {

		end($email_bcc_array); // перемещаем указатель в конец массива
		$last = key($email_bcc_array); // получаем последний ключ
		foreach ($email_bcc_array as $k => $v):
			$email_bcc .= $v['mail'];//
			if ($k !== $last) {
				$email_bcc .=  ', ';
			} // если текущий ключ не последний, выводим запятую
		endforeach;
	}

	return $email_bcc;
}
//-------------------< ajax>--------------------

function ajax_transfer_mail() {
	$input = $_POST;

	//var_dump($_POST);

	$response = array();
	$response['errors'] = array();


	$fields = array(
		'fields' => $input,
		'required' => array(
			'author'    => $input['author'],
			'phone'     => $input['phone'],
			'mail'     => $input['mail'],
			'from[date]'     => $input['from']['date'],
			'from[time]'     => $input['from']['time'],
			'from[place]'     => $input['from']['place'],
			'from[address]'     => $input['from']['address']
		)
	);

	if( isset($input['to']) ) {
		$required = array_merge($fields['required'], [
			'to[date]'     => $input['to']['date'],
			'to[time]'     => $input['to']['time'],
			'to[place]'     => $input['to']['place'],
			'to[address]'     => $input['to']['address']
		]);

		$fields['required'] = $required;
	}

	$response['errors'] = Validator::validate_fields( $fields, $response['errors'] );


	if( count($response['errors'])){
		wp_send_json_error($response);
	}else{
		//--WP mail----
		///--email----
		$email_list = get_mail();
		$email_bcc = get_bcc_mail();

		///--subject----
		$subject = 'Заявка Трансфера';
		$type = 'Заполнена заявка.';



		$client_ip = $_SERVER['REMOTE_ADDR'];


		///--message----

		$message = 'Со страницы '.$_SERVER['HTTP_REFERER'].' '.$type . "<br>\r\n";
		$message .= 'Имя: '.$input['author'] . "<br>\r\n";
		$message .= 'Телефон: '.$input['phone'] . "<br>\r\n";

		$message .= 'Туда:' . "<br>\r\n";
		$message .= '- Дата:' . $input['from']['date'] . "<br>\r\n";
		$message .= '- Время:' . $input['from']['time'] . "<br>\r\n";
		$message .= '- Тип станции:' . $input['from']['type'] . "<br>\r\n";
		$message .= '- Место прибытия:' . $input['from']['place'] . "<br>\r\n";
		$message .= '- Адресс куда:' . $input['from']['address'] . "<br>\r\n";

		if( isset($input['to']) ) {
			$message .= 'Обратно:' . "<br>\r\n";
			$message .= '- Дата:' . $input['to']['date'] . "<br>\r\n";
			$message .= '- Время:' . $input['to']['time'] . "<br>\r\n";
			$message .= '- Адресс откуда:' . $input['to']['address'] . "<br>\r\n";
			$message .= '- Место куда:' . $input['to']['place'] . "<br>\r\n";
			$message .= '- Тип станции:' . $input['to']['type'] . "<br>\r\n";
		}

		$message .= 'Тип автомобиля:' . $input['car'] . "<br>\r\n";

		$message .= 'IP-адрес пользователя: '.$client_ip . "<br>\r\n";


		///--headers----
		$headers[] = 'From: ' . get_field('field_mail_from', 'option') . "\r\n";
		$headers[] = 'BCC: ' . $email_bcc . "\r\n";
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		$attachments = '';



		//var_dump($email_list);

		///--SEND----
		$sendSuccess = wp_mail(
			$email_list,
			$subject,
			$message,
			$headers,
			$attachments
		);



		if(!$sendSuccess){
			wp_send_json_error("WP_mail  not send");
		}else {
			wp_send_json_success([
				'title' => _x('','theme-text-idea') ,
				'text' => _x('Thank you for your order','theme-text-idea')
			]);
		}

	}

	die();

}
add_action( "wp_ajax_transfer_mail", "ajax_transfer_mail" );
add_action( "wp_ajax_nopriv_transfer_mail", "ajax_transfer_mail" );


function ajax_ticket_mail() {
	$input = $_POST;

	$response = array();
	$response['errors'] = array();


	$fields = array(
		'fields' => $input,
		'required' => array(
			'author'    => $input['author'],
			'phone'     => $input['phone'],
			'mail'     => $input['mail']
		)
	);

	$response['errors'] = Validator::validate_fields( $fields, $response['errors'] );

	if( count($response['errors'])){
		wp_send_json_error($response);
	}else{
		//--WP mail----
		///--email----
		$email_list = get_mail();
		$email_bcc = get_bcc_mail();
		$payment = get_sberbank_url();
    
		///--subject----
		$subject = 'Заявка Билета';
		$type = 'Заполнена заявка.';
    
		///--message----
		$message = 'Со страницы '.$_SERVER['HTTP_REFERER'].' '.$type . "<br>\r\n";
		$message .= 'Имя: '.$input['author'] . "<br>\r\n";
		$message .= 'Телефон: '.$input['phone'] . "<br>\r\n";
		$message .= 'E-mail: '.$input['mail'] . "<br>\r\n";
		$message .= 'Название Поста: ' . get_the_title( $input['postid'] ) . "<br>\r\n";
		$message .= 'Ссылка на Пост: ' . get_permalink( $input['postid'] ) ."<br>\r\n";
		$message .= 'IP-адрес пользователя: '. $_SERVER['REMOTE_ADDR'] . "<br>\r\n";
    $message .= 'Номер заказа: '. $_POST['orderNumber'] . "<br>\r\n";
    
		///--headers----
		$headers[] = 'From: ' . get_field('field_mail_from', 'option') . "\r\n";
		$headers[] = 'BCC: ' . $email_bcc . "\r\n";
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		wp_mail($email_list, $subject, $message, $headers);
    
		if($payment['error']){
      $response['errors']['payment'] = $payment['value'];
      wp_send_json_error($response);
    } else {
      wp_send_json_success([
          'title' => _x('Thank you!','theme-text-idea'),
          'formUrl' => $payment['url']
        //'text' => _x('Message senks from Buy Ticket','theme-text-idea')
      ]);
    }
	}

	die();
}
add_action( "wp_ajax_ticket_mail", "ajax_ticket_mail" );
add_action( "wp_ajax_nopriv_ticket_mail", "ajax_ticket_mail" );


function ajax_tour_mail() {
	$input = $_POST;

	//var_dump($_POST);

	$response = array();
	$response['errors'] = array();


	$fields = array(
		'fields' => $input,
		'required' => array(
			'phone'     => $input['phone']
		)
	);


	if( isset($input['author']) ) {
		$fields['required']['author'] =  $input['author'];
	}
	if( isset($input['mail']) ) {
		$fields['required']['mail'] =  $input['mail'];
	}


	$response['errors'] = Validator::validate_fields( $fields, $response['errors'], $input['mail'] );
  

	if( count($response['errors'])){
		wp_send_json_error($response);
	}else{
		/// ORDER post
		$order_id = (int)get_option( 'order_id' );
    $payment = get_sberbank_url();

		if(!$order_id ){
			$order_id = 1;
		} else {
			$order_id++;
		}
		update_option('order_id',$order_id);

		$time = current_time('timestamp');

		if( $order_id ) {
			if ($order_post_id = wp_insert_post([
					'post_title' => 'order_' . $order_id,
					'post_content' => '',
					'post_type' => 'orders',
					'post_status' => 'pending',
					'post_date' => date("Y-m-d H:i:s", $time)
				]
			)
			) {
				wp_update_post( array(
					'ID'           => $order_post_id,
					'post_title'   => (int)$order_id . '_' . (int)$order_post_id . '_' . (int)$input['postid'],
				) );

				update_post_meta($order_post_id, "name", trim($input['author']));
				update_post_meta($order_post_id, "phone", trim($input['phone']));
				update_post_meta($order_post_id, "email", trim($input['mail']));

				update_post_meta($order_post_id, "tour", (int)$input['postid'] );
				update_post_meta($order_post_id, "date", trim($input['date']) );

				update_post_meta($order_post_id, "price", get_field( 'price_curent', $input['postid']  ) );
			}
		}
		/// ORDER post END

		//--WP mail----
		///--email----
		$email_list = get_mail();
		$email_bcc = get_bcc_mail();

		///--subject----
		$subject = 'Заявка Тура';
		$type = 'Заполнена заявка.';

		$client_ip = $_SERVER['REMOTE_ADDR'];


		///--message----

		$message = 'Со страницы '.$_SERVER['HTTP_REFERER'].' '.$type . "<br>\r\n";
		$message .= 'Имя: '.$input['author'] . "<br>\r\n";
		$message .= 'Телефон: '.$input['phone'] . "<br>\r\n";
		$message .= 'E-mail: '.$input['mail'] . "<br>\r\n";

		$message .= 'Дата путешествия: ' . $input['date'] ."<br>\r\n";

		$message .= 'Название Поста: ' . get_the_title( $input['postid'] ) . "<br>\r\n";
		$message .= 'Ссылка на Пост: ' . get_permalink( $input['postid'] ) ."<br>\r\n";

		$message .= 'Ссылка на Заказ: ' . get_edit_post_link( $order_post_id ) ."<br><br>\r\n";

		$message .= 'IP-адрес пользователя: '.$client_ip . "<br>\r\n";
    

		///--headers----
		$headers[] = 'From: ' . get_field('field_mail_from', 'option') . "\r\n";
		$headers[] = 'BCC: ' . $email_bcc . "\r\n";
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		$attachments = '';

		///--SEND----
		$sendSuccess = wp_mail(
			$email_list,
			$subject,
			$message,
			$headers,
			$attachments
		);

		
		if( isset($input['paid']) && $order_post_id ) {
//			$orderNumber = (int)$order_id . '_' . (int)$order_post_id . '_' . (int)$input['postid'];
//			$amount = get_field( 'price_curent', (int)$input['postid'] ) * 100;
//
//			//$amount = number_format( $amount, 2, '.', '');
//
//
//			$return_url = get_permalink( (int)$input['postid'] );
//
//			$alfabank = new Alfabank;
//			$response = $alfabank->dataform( $orderNumber, $amount, $input['mail'] );
			
//			if (isset($response['errorCode'])) { // В случае ошибки вывести ее
//				wp_send_json_error('Ошибка #' . $response['errorCode'] . ': ' . $response['errorMessage'] );
//			} else { // В случае успеха перенаправить пользователя на плетжную форму
//				wp_send_json_success([
//					'formUrl' => $response['formUrl']
//				]);
//			}
		}

    if($payment['error']){
      $response['errors']['payment'] = $payment['value'];
      wp_send_json_error($response);
    } else {
      wp_send_json_success([
          'title' => _x('Thank you!','theme-text-idea'),
          'formUrl' => $payment['url']
        //'text' => _x('Message senks from Buy Ticket','theme-text-idea')
      ]);
    }

//		if(!$sendSuccess){
//			wp_send_json_error("WP_mail  not send");
//		}else {
//			wp_send_json_success([
//				'title' => _x('Thank you!','theme-text-idea'),
//				'text' => _x('Message senks from Buy Tour 1 click','theme-text-idea')
//			]);
//		}

	}

	die();

}

add_action( "wp_ajax_tour_mail", "ajax_tour_mail" );
add_action( "wp_ajax_nopriv_tour_mail", "ajax_tour_mail" );

function ajax_tour_popup() {
	$id = $_POST['id'];
	//var_dump(ICL_LANGUAGE_CODE);
    ?>
	<div style="display: block" class="buy-form-popup">
		<h5><?php _e('Buy a single click','theme-text-idea') ?></h5>
		<form method="post" class="buy-form by_tour_one_click">
			<label><span><?php _e('Your name','theme-text-idea') ?></span>
				<input type="text" name="author" class="buy-form__item buy-form__item_text">
			</label>
			<label><span><?php _e('Phone number','theme-text-idea') ?></span>
				<input type="text" name="phone" class="buy-form__item buy-form__item_text">
			</label>
			<label><span><?php _e('E-mail address','theme-text-idea') ?></span>
				<input type="text" name="mail" class="buy-form__item buy-form__item_text">
			</label>

			<?php if ( $dates = get_field('dates', $id) ){?>
			<label class="dates-container"><span class="field-title"><?php _e('Choose the date','theme-text-idea') ?></span>
				<select class="buy-form-dates" name="date">
					<option value="other"><?php _e('Other','theme-text-idea') ?></option>
					<?php

					$new_arrey = array_map(function ($d) {
						return date('d.m.y', strtotime($d['start'])) . ' - ' . date('d.m.y', strtotime($d['end']));
					}, $dates);

					usort($new_arrey, function($a, $b){
						preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $a, $new_a);
						preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $b, $new_b);

						$a_date = DateTime::createFromFormat('d.m.y', $new_a[0]);
						$b_date = DateTime::createFromFormat('d.m.y', $new_b[0]);

						if($a_date == $b_date) {
							return 0;
						}
						return ($a_date < $b_date) ? -1 : 1;
					});

					$curent_date = new DateTime('NOW');
					foreach ($new_arrey as $date) {
						preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $date, $a);
						preg_match('/\d{1,2}.\d{1,2}.\d{2,4}$/', $date, $b);

						if (DateTime::createFromFormat('d.m.y', $a[0]) < $curent_date || DateTime::createFromFormat('d.m.y', $b[0]) < $curent_date) {
							echo '<option disabled>' . $date . '</option>';
						} else {
							echo '<option>' . $date . '</option>';
						}
					}
					?>
				</select>
			</label>
			<?php } ?>

			<button type="submit" class="buy-form__submit"><?php _e('Send','theme-text-idea') ?></button>
			<input type="hidden" name="postid" value="<?= $id ?>" readonly>
		</form>
	</div>

	<?php

	die();

}
add_action( "wp_ajax_tour_popup", "ajax_tour_popup" );
add_action( "wp_ajax_nopriv_tour_popup", "ajax_tour_popup" );


function ajax_tour_now_popup() {
	$id = $_POST['id'];
	//var_dump(ICL_LANGUAGE_CODE);
	?>
	<div style="display: block" class="buy-form-popup">
		<h5><?php _e('Buy now','theme-text-idea') ?></h5>
		<form method="post" class="buy-form by_tour_one_click">
			<label><span><?php _e('Phone number','theme-text-idea') ?></span>
				<input type="text" name="phone" class="buy-form__item buy-form__item_text">
			</label>
			<label><span><?php _e('E-mail address','theme-text-idea') ?></span>
				<input type="text" name="mail" class="buy-form__item buy-form__item_text">
			</label>

			<?php if ( $dates = get_field('dates', $id) ){?>
				<label class="dates-container"><span class="field-title"><?php _e('Choose the date','theme-text-idea') ?></span>
					<select class="buy-form-dates" name="date">
						<option value="other"><?php _e('Other','theme-text-idea') ?></option>
						<?php

						$new_arrey = array_map(function ($d) {
							return date('d.m.y', strtotime($d['start'])) . ' - ' . date('d.m.y', strtotime($d['end']));
						}, $dates);

						usort($new_arrey, function($a, $b){
							preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $a, $new_a);
							preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $b, $new_b);

							$a_date = DateTime::createFromFormat('d.m.y', $new_a[0]);
							$b_date = DateTime::createFromFormat('d.m.y', $new_b[0]);

							if($a_date == $b_date) {
								return 0;
							}
							return ($a_date < $b_date) ? -1 : 1;
						});

						$curent_date = new DateTime('NOW');
						foreach ($new_arrey as $date) {
							preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $date, $a);
							preg_match('/\d{1,2}.\d{1,2}.\d{2,4}$/', $date, $b);

							if (DateTime::createFromFormat('d.m.y', $a[0]) < $curent_date || DateTime::createFromFormat('d.m.y', $b[0]) < $curent_date) {
								echo '<option disabled>' . $date . '</option>';
							} else {
								echo '<option>' . $date . '</option>';
							}
						}
						?>
					</select>
				</label>
			<?php } ?>

			<button type="submit" class="buy-form__submit"><?php _e('Buy now','theme-text-idea') ?></button>
			<input type="hidden" name="postid" value="<?= $id ?>" readonly>
			<input type="hidden" name="paid" value="" readonly>
		</form>
	</div>

	<?php
	die();

}
add_action( "wp_ajax_tour_now_popup", "ajax_tour_now_popup" );
add_action( "wp_ajax_nopriv_tour_now_popup", "ajax_tour_now_popup" );

function ajax_alfabank_return_url(){
	if( isset($_GET['orderId']) ) {
		$alfabank = new Alfabank;
		$response = $alfabank->afterpayment();

		$order_array = explode("_", $response['orderNumber']);

		$order_post_id = $order_array[1];
		$post_id = $order_array[2];

		if( $response['errorCode'] == 0 && $response['orderStatus'] == 2 ) {
			wp_update_post( array(
				'ID'           => $order_post_id,
				'post_status'   => 'paid',
			) );

			$mail_a = ( array_filter( $response['merchantOrderParams'], function($a){
				return $a["name"]=='mail';
			}) );

			$mail_m = $mail_a[1]['value'];

			//--WP mail to ADMIN----
			///--email----
			$email_list = get_mail();
			$email_bcc = get_bcc_mail();

			///--subject----
			$subject = 'Тур оплачен';

			///--message----
			$message = 'Ссылка на заказ: <a href="'.get_edit_post_link( $order_array[1] ).'">'.$response['orderNumber'].'</a>' . "<br>\r\n";

			///--headers----
			$headers = '';
			$headers[] = 'From: ' . get_field('field_mail_from', 'option') . "\r\n";
			$headers[] = 'BCC: ' . $email_bcc . "\r\n";
			$headers[] = 'Content-Type: text/html; charset=UTF-8';

			$attachments = '';

			///--SEND----
			wp_mail(
				$email_list,
				$subject,
				$message,
				$headers,
				$attachments
			);

			//--WP mail to CLIENT----
			///--email----

			///--subject----
			$subject = 'You by tour';

			///--message----
			$message = 'Thanks for your order!' . "<br>\r\n";
			$message .= 'Your order number: '.$response['orderNumber'] . '.'  . "<br><br>\r\n";
			$message .= 'You have purchased the tour - ' .get_the_title( $post_id ) . "<br>\r\n";
			$message .= 'Date ' . get_field('date', $order_array[1] ) . "<br>\r\n";
			$message .= 'Your order is ' . get_field('price', $order_array[1] ) .'₽'. "<br>\r\n";
			$message .= 'Our manager will contact you soon' . "<br>\r\n";

			///--headers----
			$headers = '';
			$headers[] = 'From: ' . get_field('field_mail_from', 'option') . "\r\n";
			$headers[] = 'Content-Type: text/html; charset=UTF-8';

			$attachments = '';

			///--SEND----
			wp_mail(
				$mail_m,
				$subject,
				$message,
				$headers,
				$attachments
			);

		}

		$url = get_permalink( $post_id );
		$url .= '?errorcode='.$response['errorCode'].'&orderstatus='.$response['orderStatus'];

		//wp_die();

		header('Location: ' . $url);
		//var_dump( $post_id );
		die();
	}

}
add_action( "wp_ajax_alfabank_return_url", 			"ajax_alfabank_return_url" );
add_action( "wp_ajax_nopriv_alfabank_return_url", 	"ajax_alfabank_return_url" );
//-------------------</ ajax>--------------------
function custom_upload_mimes ( $existing_mimes=array() ) {
$existing_mimes['dwg'] = 'application/dwg';
return $existing_mimes;
}
add_filter('upload_mimes','custom_upload_mimes');
/*
$unique_field_name = 'order_number';
add_filter('acf/validate_value/name='.$unique_field_name, 'acf_unique_value_field', 10, 4);
function acf_unique_value_field($valid, $value, $field, $input) {
  if (!$valid || (!isset($_POST['post_ID']) && !isset($_POST['post_id']))) {
    return $valid;
  }
  if (isset($_POST['post_ID'])) {
    $post_id = intval($_POST['post_ID']);
  } else {
    $post_id = intval($_POST['post_id']);
  }
  if (!$post_id) {
    return $valid;
  }
  $post_type = get_post_type($post_id);
  $field_name = $field['name'];
  $args = array(
      'post_type' => $post_type,
      'post_status' => 'publish, draft, trash',
      'post__not_in' => array($post_id),
      'meta_query' => array(
          array(
              'key' => $field_name,
              'value' => $value
          )
      )
  );
  $query = new WP_Query($args);
  if (count($query->posts)){
    return 'Поле ' . $field['label'] . ' должно иметь уникальное значение.';
  }
  return true;
}
*/

add_filter('acf/load_field/name=orders', 'read_only_field');
function read_only_field( $field ){ $field['disabled']='1'; return $field; }

function sberbank_payment (){
  $client = new Gateway(WSDL);
  $return_post_id = PRODUCTION ? 1102 : 1104;
  $return_post_id = apply_filters('wpml_object_id', $return_post_id , 'page');
  $return_url = get_permalink($return_post_id) . '?email=' . $_POST['mail'];
  $data = array('orderParams' => array(
      'returnUrl' => $return_url,
      'merchantOrderNumber' => urlencode($_POST['orderNumber']),
      'amount' => urlencode($_POST['amount'])
  ));

  /**
   * РЕГИСТРАЦИЯ ОДНОСТАДИЙНОГО ПЛАТЕЖА В ПЛАТЕЖНОМ ШЛЮЗЕ
   * Регистрация заказа без предавторизацией.
   *
   * ПАРАМЕТРЫ
   *		orderNumber			Уникальный идентификатор заказа в магазине.
   *		amount				Сумма заказа.
   *		returnUrl			Адрес, на который надо перенаправить пользователя в случае успешной оплаты.
   *
   * ОТВЕТ
   * 		В случае ошибки:
   * 			errorCode		Код ошибки. Список возможных значений приведен в таблице ниже.
   * 			errorMessage	Описание ошибки.
   *
   * 		В случае успешной регистрации:
   * 			orderId			Номер заказа в платежной системе. Уникален в пределах системы.
   * 			formUrl			URL платежной формы, на который надо перенаправить браузер клиента.
   *
   *	Код ошибки		Описание
   *		0			Обработка запроса прошла без системных ошибок.
   *		1			Заказ с таким номером уже зарегистрирован в системе;
   *					Неверный номер заказа.
   *		3			Неизвестная (запрещенная) валюта.
   *		4			Отсутствует обязательный параметр запроса.
   *		5			Ошибка значения параметра запроса.
   *		7			Системная ошибка.
   */
  $response = $client->__call('registerOrder', $data);

  /**
   * РЕГИСТРАЦИЯ ДВУХСТАДИЙНОГО ПЛАТЕЖА В ПЛАТЕЖНОМ ШЛЮЗЕ
   * Регистрация заказа с предавторизацией.
   *
   * Параметры и ответ точно такие же, как и в предыдущем методе.
   * Необходимо вызывать либо registerOrder, либо registerOrderPreAuth.
   */
//	$response = $client->__call('registerOrderPreAuth', $data);

  $result = [];
  
  if($response->errorCode === 0){
    $result['success'] = true;
    $result['url'] = $response->formUrl;
  } else {
    $result['error'] = true;
    $result['value'] = 'Ошибка #' . $response->errorCode . ': ' . $response->errorMessage;
  }
  return $result;
}

function get_sberbank_url(){
  $order_id = (int) get_field('orders', 'option') + 1;
  $_POST['orderNumber'] = $order_id;
  $_POST['orderDescription'] = get_the_title( $_POST['postid'] );
  $_POST['amount'] = (int) get_field('price_curent', $_POST['postid']) * 100;
  $payment = sberbank_payment();
  update_field('orders', $order_id,'option');
  return $payment;
//  return ['success' => true, 'url' => 'http://sberbank.ru'];
//  wp_send_json_success([
//      'sberbank' => $redirect_url
//  ]);
}
