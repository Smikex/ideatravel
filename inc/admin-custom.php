<?php
	//-----------<выводим масив параметров меню>-----------------
	function wpse_136058_debug_admin_menu() {
		echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre>';
	}
	//add_action( 'admin_init', 'wpse_136058_debug_admin_menu' ); //debug
	//-----------</выводим масив параметров меню>-----------------



	//-----------<добовляем style>-----------------
	function admin_menu_css() {
	    ?>
	    <style>
	        li.toplevel_page_acf-options-scripts .dashicons-admin-generic:before {
	        	content: "\f325";
	        }
			table.pages #post-2 .trash,
			#post-2 .check-column input,
			#category-add-toggle,
			#cb-select-all-1, #cb-select-all-2
			{
				display: none;
			}
			.dashicons-admin-post:before {
			    /*content: "\f174";*/
			}
	    </style>
	    <?php
	}

	add_action( 'admin_head', 'admin_menu_css' );
	//-----------</добовляем style>-----------------


	//-----------<запретить вывод генерируемые meta в области head>-----------------
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
	//-----------</запретить вывод генерируемые meta в области head>-----------------

	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );

	//-----------<Удаляем emoji>-----------------
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	//-----------</Удаляем emoji>-----------------

	//-----------<Удаляем еще что-то>-----------------
	remove_action('wp_head', 'wp_print_scripts');
	remove_action('wp_head', 'wp_print_head_scripts', 9);
	//-----------</Удаляем еще что-то>-----------------

	// Отменить регистрацию ненужных виджетов

	add_action('widgets_init', 'unregister_default_widgets', 11);

	function unregister_default_widgets() {
		unregister_widget('WP_Widget_Pages');
		unregister_widget('WP_Widget_Calendar');
		unregister_widget('WP_Widget_Archives');
		unregister_widget('WP_Widget_Links');
		unregister_widget('WP_Widget_Meta');
		unregister_widget('WP_Widget_Recent_Comments');
		unregister_widget('WP_Widget_RSS');
		unregister_widget('WP_Widget_Tag_Cloud');
		unregister_widget('Akismet_Widget');
	}

	//-----------<Удалить элементы меню из верхней панели>-----------------
	function remove_admin_bar_links() {
	    global $wp_admin_bar;
	    $wp_admin_bar->remove_menu('new-content');
	    $wp_admin_bar->remove_menu('new-link');
		$wp_admin_bar->remove_menu('comments');
	}
	add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );
	//-----------</Удалить элементы меню из верхней панели>-----------------

	//-----------<Удалить элементы меню в левой панели админки WP>-----------------
	function wps_admin_bar() {
	    global $wp_admin_bar;
	    $wp_admin_bar->remove_menu('wp-logo');
	    $wp_admin_bar->remove_menu('about');
	    $wp_admin_bar->remove_menu('wporg');
	    $wp_admin_bar->remove_menu('documentation');
	    $wp_admin_bar->remove_menu('support-forums');
	    $wp_admin_bar->remove_menu('feedback');
	    $wp_admin_bar->remove_menu('view-site');
	}

	add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );
	//-----------</Удалить элементы меню в левой панели админки WP>-----------------


	// Запрещаем доступ к редактору файлов по прямой ссылке wp-admin/theme-editor.php:
	function nelza_redaktirovat_temi() {

		if ( $_SERVER['PHP_SELF'] == '/wp-admin/theme-editor.php' ) :
			wp_redirect(admin_url());
			exit;
		endif;
	}

	add_action('admin_init', 'nelza_redaktirovat_temi', 999);


	//-----------<редактируем меню>-----------------
	function edit_admin_menus() {
		global $menu;
		global $submenu;
		//remove_menu_page( 'CF7DBPluginSubmissions' );
		remove_menu_page( 'wpcf7' );
		remove_menu_page( 'sitepress-multilingual-cms/menu/languages.php' );
		remove_menu_page( 'wpseo_dashboard' );

		unset($submenu['themes.php'][6]);			//Удалить Настройки темы
		unset($submenu['themes.php'][5]);			//Запретить смену темы в WordPress
		unset($submenu['themes.php'][15]);			//Запретить смену темы в WordPress


		//unset($submenu['edit.php'][15]);			//рубрики
		//unset($submenu['edit.php'][16]);			//метки


		remove_submenu_page( 'plugins.php', 'plugin-editor.php' ); // Убрать htlfrnjh gkfunyjd
		remove_submenu_page('themes.php', 'theme-editor.php');
		remove_submenu_page('themes.php', 'widgets.php'); //убираем виджеты

		//print_r($submenu); exit;

		add_menu_page('admin-menu', 'Редактор Языков', 'manage_options', '/admin.php?page=wpml-string-translation%2Fmenu%2Fstring-translation.php&context=theme-text-idea', '', 'dashicons-translation', 31 );

		//add_menu_page('admin-menu', 'Заявки', 'manage_options', '/admin.php?page=CF7DBPluginSubmissions', '', 'dashicons-email-alt', 1.9 );

		//add_menu_page('admin-menu', 'Редактор Форм', 'manage_options', '/admin.php?page=wpcf7', '', 'dashicons-email-alt', 31 );
	}
	add_action( 'admin_menu', 'edit_admin_menus' );

	function remove_menus(){
		global $menu;
		$restricted = array(
			__('Dashboard'),
			//__('Posts'),
			//__('Media'),
			__('Links'),
			//__('Pages'),
			//__('Appearance'),
			__('Tools'),
			__('Users'),
			__('Settings'),
			//__('Comments'),
			__('Plugins')
		);
		end ($menu);
		while (prev($menu)){
			$value = explode(' ', $menu[key($menu)][0]);
			if( in_array( ($value[0] != NULL ? $value[0] : "") , $restricted ) ){
				unset($menu[key($menu)]);
			}
		}


	}
	//add_action('admin_menu', 'remove_menus');



	//-----------</редактируем меню>-----------------


	//-----------<полное скрытие верхней панели от всех>-----------------
	function hide_toolbar() {
	?>
	<style type="text/css">
	    .show-admin-bar {
	        display: none;
	    }
	</style>
	<?php
	}
	function wph_disable_toolbar() {
	    add_filter('show_admin_bar', '__return_false');
	    add_action('admin_print_scripts-profile.php', 'hide_toolbar');
	}
	//add_action('init', 'wph_disable_toolbar', 9);
	//add_filter('show_admin_bar', '__return_false');
	//-----------</полное скрытие верхней панели от всех>-----------------


	//-----------<Прячим плагины из списка>-----------------
	function hide_plugin_trickspanda() {
	  global $wp_list_table;
		$hidearr = array('mp-timetable/mp-timetable.php');
		$myplugins = $wp_list_table->items;
	  foreach ($myplugins as $key => $val) {
	    if (in_array($key,$hidearr)) {
	      unset($wp_list_table->items[$key]);
	    }
	  }
	}

	add_action('pre_current_active_plugins', 'hide_plugin_trickspanda');
	//-----------</Прячим плагины из списка>-----------------


	//-----------<Проставляем separator>-----------------
	add_action( 'admin_init', 'add_admin_menu_separator' );

	function add_admin_menu_separator( $position ) {

		global $menu;

		$menu[ $position ] = array(
			0	=>	'',
			1	=>	'read',
			2	=>	'separator' . $position,
			3	=>	'',
			4	=>	'wp-menu-separator'
		);

	}

	add_action( 'admin_menu', 'set_admin_menu_separator' );

	function set_admin_menu_separator() {
		do_action( 'admin_init', 21 );
		do_action( 'admin_init', 30 );
	} // end set_admin_menu_separator
	//-----------</Проставляем separator>-----------------

	// Удаление версии WordPress со страниц, RSS, скриптов и стилей
	add_filter('the_generator', '__return_empty_string');
	function rem_wp_ver_css_js( $src ) {
		if ( strpos( $src, 'ver=' ) )
			$src = remove_query_arg( 'ver', $src );
		return $src;
	}
	add_filter( 'style_loader_src', 'rem_wp_ver_css_js', 9999 );
	add_filter( 'script_loader_src', 'rem_wp_ver_css_js', 9999 );


	// Удаление версии WP из футера админки
	function kill_footer_version ($default) {
		return '';
	}
	add_filter ('update_footer', 'kill_footer_version', 999);

	// Удаление сообщений "Спасибо, что выбрали WordPress"
	function kill_footer_filter ($default) {
		return '';
	}

	add_filter ('admin_footer_text', 'kill_footer_filter');