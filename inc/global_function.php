<?php

//функция превода текста с кириллицы в траскрипт
//перевод имен файлов в нижний регистр
function ctl_sanitize_title($title) {
	global $wpdb;

	$iso9_table = array(
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G',
		'Ґ' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE',
		'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'J',
		'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K',
		'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N',
		'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
		'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS',
		'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '',
		'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g',
		'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye',
		'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'i', 'й' => 'j',
		'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k',
		'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n',
		'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
		'у' => 'u', 'ў' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
		'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'shh', 'ъ' => '',
		'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
	);	

	$locale = get_locale();
	switch ( $locale ) {
		case 'bg_BG':
			$iso9_table['Щ'] = 'SHT';
			$iso9_table['щ'] = 'sht'; 
			$iso9_table['Ъ'] = 'A';
			$iso9_table['ъ'] = 'a';
			break;
		case 'uk':
			$iso9_table['И'] = 'Y';
			$iso9_table['и'] = 'y';
			break;
	}

	$is_term = false;
	$backtrace = debug_backtrace();
	foreach ( $backtrace as $backtrace_entry ) {
		if ( $backtrace_entry['function'] == 'wp_insert_term' ) {
			$is_term = true;
			break;
		}
	}

	$term = $is_term ? $wpdb->get_var("SELECT slug FROM {$wpdb->terms} WHERE name = '$title'") : '';
	if ( empty($term) ) {
		$title = strtr($title, apply_filters('ctl_table', $iso9_table));
		$title = preg_replace("/[^A-Za-z0-9`'_\-\.]/", '-', $title);
	} else {
		$title = $term;
	}

	return strtolower($title);
}
add_filter('sanitize_title', 'ctl_sanitize_title', 9);
add_filter('sanitize_file_name', 'ctl_sanitize_title');
//end---------------------------

//------from PHP 5.5
if (! function_exists('array_column')) {
	function array_column(array $input, $columnKey, $indexKey = null)
	{
		$array = array();
		foreach ($input as $value) {
			if (!array_key_exists($columnKey, $value)) {
				trigger_error("Key \"$columnKey\" does not exist in array");
				return false;
			}
			if (is_null($indexKey)) {
				$array[] = $value[$columnKey];
			} else {
				if (!array_key_exists($indexKey, $value)) {
					trigger_error("Key \"$indexKey\" does not exist in array");
					return false;
				}
				if (!is_scalar($value[$indexKey])) {
					trigger_error("Key \"$indexKey\" does not contain scalar value");
					return false;
				}
				$array[$value[$indexKey]] = $value[$columnKey];
			}
		}
		return $array;
	}
}
//----------------------



//Миниатюра для постов в админке
if ( !function_exists('fb_AddThumbColumn') && function_exists('add_theme_support') ) {
 
    // for post and page
    add_theme_support('post-thumbnails', array( 'page', 'post', 'citys', 'tickets' ));

    function fb_AddThumbColumn($cols) {
 
        $cols['thumbnail'] = __('Thumbnail');
 
        return $cols;
    }
 
    function fb_AddThumbValue($column_name, $post_id) {
 
            $width = (int) 100;
            $height = (int) 100;
 
            if ( 'thumbnail' == $column_name ) {
                // thumbnail of WP 2.9
                $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
                // image from gallery
                $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
                if ($thumbnail_id)
                    $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
                elseif ($attachments) {
                    foreach ( $attachments as $attachment_id => $attachment ) {
                        $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
                    }
                }
                    if ( isset($thumb) && $thumb ) {
                        echo $thumb;
                    } else {
                        echo __('None');
                    }
            }
    }
 
    // for posts
    add_filter( 'manage_post_posts_columns', 'fb_AddThumbColumn' );
    add_action( 'manage_post_posts_custom_column', 'fb_AddThumbValue', 10, 2 );
//--------------------------------- 
    // for pages
    //add_filter( 'manage_pages_columns', 'fb_AddThumbColumn' );
    //add_action( 'manage_pages_custom_column', 'fb_AddThumbValue', 10, 2 );
}


//----------<YouTube SRC>----------------------------------------
function youtube_src( $url, $type='link' ) {
    preg_match('/src="(.+?)"/', $url, $matches_url );
    $src = $matches_url[1];
    preg_match('/embed(.*?)?feature/', $src, $matches_id );
    $vidID = $matches_id[1];
    $vidID = str_replace( str_split( '?/' ), '', $vidID );

    if ( $type == 'link') {
        return 'https://www.youtube.com/embed/'.$vidID;
    }

    if ( $type == 'img') {
        return 'http://i.ytimg.com/vi/'.$vidID.'/mqdefault.jpg';
    }

    if ( $type == 'vidID') {
        return $vidID;
    }
}
//----------</YouTube SRC>----------------------------------------

/**
 * Хлебные крошки для WordPress (breadcrumbs)
 *
 * @param  string [$sep  = '']      Разделитель. По умолчанию ' » '
 * @param  array  [$l10n = array()] Для локализации. См. переменную $default_l10n.
 * @param  array  [$args = array()] Опции. См. переменную $def_args
 * @return string Выводит на экран HTML код
 *
 * version 3.3.1
 */
function kama_breadcrumbs( $sep = '', $l10n = array(), $args = array() ){
	$kb = new Kama_Breadcrumbs;
	echo $kb->get_crumbs( $sep, $l10n, $args );
}

class Kama_Breadcrumbs {

	public $arg;

	// Локализация
	static $l10n = array(
		'home'       => 'Главная',
		'paged'      => 'Страница %d',
		'_404'       => 'Ошибка 404',
		'search'     => 'Результаты поиска по запросу - <b>%s</b>',
		'author'     => 'Архив автора: <b>%s</b>',
		'year'       => 'Архив за <b>%d</b> год',
		'month'      => 'Архив за: <b>%s</b>',
		'day'        => '',
		'attachment' => 'Медиа: %s',
		'tag'        => 'Записи по метке: <b>%s</b>',
		'tax_tag'    => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
		// tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
		// Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
	);

	// Параметры по умолчанию
	static $args = array(
		'on_front_page'   => true,  // выводить крошки на главной странице
		'show_post_title' => true,  // показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
		'show_term_title' => true,  // показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
		'title_patt'      => '<li><span class="kb_title">%s</span></li>', // шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
		'last_sep'        => true,  // показывать последний разделитель, когда заголовок в конце не отображается
		'markup'          => '', // 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
		// или можно указать свой массив разметки:
		// array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
		'priority_tax'    => array('category'), // приоритетные таксономии, нужно когда запись в нескольких таксах
		'priority_terms'  => array(), // 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
		// Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
		// 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
		// порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
		'nofollow' => false, // добавлять rel=nofollow к ссылкам?

		// служебные
		'sep'             => '',
		'linkpatt'        => '',
		'pg_end'          => '',
	);

	function get_crumbs( $sep, $l10n, $args ){
		global $post, $wp_query, $wp_post_types;

		self::$args['sep'] = $sep;

		// Фильтрует дефолты и сливает
		$l10n = array(
			'home'       => __('Main','theme-text-idea'),
			'paged'      => __('Page','theme-text-idea').' %d',
			'_404'       => __('Error 404','theme-text-idea'),
			'search'     => __('Search result','theme-text-idea'),
			'author'     => 'Архив автора: <b>%s</b>',
			'year'       => 'Архив за <b>%d</b> год',
			'month'      => 'Архив за: <b>%s</b>',
			'day'        => '',
			'attachment' => 'Медиа: %s',
			'tag'        => 'Записи по метке: <b>%s</b>',
			'tax_tag'    => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
			// tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
			// Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
		);


		$loc = (object) array_merge( apply_filters('kama_breadcrumbs_default_loc', self::$l10n ), $l10n );
		$arg = (object) array_merge( apply_filters('kama_breadcrumbs_default_args', self::$args ), $args );

		$arg->sep = '<li class="breadcrumbs__divider"><span><svg><use xlink:href="'.get_template_directory_uri().'/img/sprite-inline.svg#arrow-right"></use></svg></span></li>'; // дополним

		// упростим
		$sep = & $arg->sep;
		$this->arg = & $arg;

		// микроразметка ---
		if(1){
			$mark = & $arg->markup;

			// Разметка по умолчанию
			if( ! $mark ) $mark = array(
				'wrappatt'  => '<ul class="kama_breadcrumbs breadcrumbs">%s</ul>',
				'linkpatt'  => '<li><a href="%s">%s</a></li>',
				'sep_after' => '',
			);

			elseif( ! is_array($mark) )
				die( __CLASS__ .': "markup" parameter must be array...');

			$wrappatt  = $mark['wrappatt'];
			$arg->linkpatt  = $arg->nofollow ? str_replace('<a ','<a rel="nofollow"', $mark['linkpatt']) : $mark['linkpatt'];
			$arg->sep      .= $mark['sep_after']."\n";
		}

		$linkpatt = $arg->linkpatt; // упростим

		$q_obj = get_queried_object();

		// может это архив пустой таксы?
		$ptype = null;
		if( empty($post) ){
			if( isset($q_obj->taxonomy) )
				$ptype = & $wp_post_types[ get_taxonomy($q_obj->taxonomy)->object_type[0] ];
		}
		else $ptype = & $wp_post_types[ $post->post_type ];

		// paged
		$arg->pg_end = '';
		if( ($paged_num = get_query_var('paged')) || ($paged_num = get_query_var('page')) )
			$arg->pg_end = $sep . '<li><span>'. sprintf( $loc->paged, (int) $paged_num ). '</span></li>';

		$pg_end = $arg->pg_end; // упростим

		// ну, с богом...
		$out = '';

		if( is_front_page() ){
			return $arg->on_front_page ? sprintf( $wrappatt, ( $paged_num ? sprintf($linkpatt, get_home_url(), $loc->home) . $pg_end : $loc->home ) ) : '';
		}
		// страница записей, когда для главной установлена отдельная страница.
		elseif( is_home() ) {
			$out = $paged_num ? ( sprintf( $linkpatt, get_permalink($q_obj), esc_html($q_obj->post_title) ) . $pg_end ) : esc_html($q_obj->post_title);
		}
		elseif( is_404() ){
			$out = $loc->_404;
		}
		elseif( is_search() ){
			//$out = sprintf( $loc->search, esc_html( $GLOBALS['s'] ) );
			$out = sprintf( '<li><span>%s</span></li>', esc_html($loc->search) );
		}
		elseif( is_author() ){
			$tit = sprintf( $loc->author, esc_html($q_obj->display_name) );
			$out = ( $paged_num ? sprintf( $linkpatt, get_author_posts_url( $q_obj->ID, $q_obj->user_nicename ) . $pg_end, $tit ) : $tit );
		}
		elseif( is_year() || is_month() || is_day() ){
			$y_url  = get_year_link( $year = get_the_time('Y') );

			if( is_year() ){
				$tit = sprintf( $loc->year, $year );
				$out = ( $paged_num ? sprintf($linkpatt, $y_url, $tit) . $pg_end : $tit );
			}
			// month day
			else {
				$y_link = sprintf( $linkpatt, $y_url, $year);
				$m_url  = get_month_link( $year, get_the_time('m') );

				if( is_month() ){
					$tit = sprintf( $loc->month, get_the_time('F') );
					$out = $y_link . $sep . ( $paged_num ? sprintf( $linkpatt, $m_url, $tit ) . $pg_end : $tit );
				}
				elseif( is_day() ){
					$m_link = sprintf( $linkpatt, $m_url, get_the_time('F'));
					$out = $y_link . $sep . $m_link . $sep . get_the_time('l');
				}
			}
		}
		// Древовидные записи
		elseif( is_singular() && $ptype->hierarchical ){
			$out = $this->_add_title( $this->_page_crumbs($post), $post );
		}
		// Таксы, плоские записи и вложения
		else {
			$term = $q_obj; // таксономии

			// определяем термин для записей (включая вложения attachments)
			if( is_singular() ){
				// изменим $post, чтобы определить термин родителя вложения
				if( is_attachment() && $post->post_parent ){
					$save_post = $post; // сохраним
					$post = get_post($post->post_parent);
				}

				// учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
				$taxonomies = get_object_taxonomies( $post->post_type );
				// оставим только древовидные и публичные, мало ли...
				$taxonomies = array_intersect( $taxonomies, get_taxonomies( array('hierarchical' => true, 'public' => true) ) );

				if( $taxonomies ){
					// сортируем по приоритету
					if( ! empty($arg->priority_tax) ){
						usort( $taxonomies, function($a,$b)use($arg){
							$a_index = array_search($a, $arg->priority_tax);
							if( $a_index === false ) $a_index = 9999999;

							$b_index = array_search($b, $arg->priority_tax);
							if( $b_index === false ) $b_index = 9999999;

							return ( $b_index === $a_index ) ? 0 : ( $b_index < $a_index ? 1 : -1 ); // меньше индекс - выше
						} );
					}

					// пробуем получить термины, в порядке приоритета такс
					foreach( $taxonomies as $taxname ){
						if( $terms = get_the_terms( $post->ID, $taxname ) ){
							// проверим приоритетные термины для таксы
							$prior_terms = & $arg->priority_terms[ $taxname ];
							if( $prior_terms && count($terms) > 2 ){
								foreach( (array) $prior_terms as $term_id ){
									$filter_field = is_numeric($term_id) ? 'term_id' : 'slug';
									$_terms = wp_list_filter( $terms, array($filter_field=>$term_id) );

									if( $_terms ){
										$term = array_shift( $_terms );
										break;
									}
								}
							}
							else
								$term = array_shift( $terms );

							break;
						}
					}
				}

				if( isset($save_post) ) $post = $save_post; // вернем обратно (для вложений)
			}

			// вывод

			// все виды записей с терминами или термины
			if( $term && isset($term->term_id) ){
				$term = apply_filters('kama_breadcrumbs_term', $term );

				// attachment
				if( is_attachment() ){
					if( ! $post->post_parent )
						$out = sprintf( $loc->attachment, esc_html($post->post_title) );
					else {
						if( ! $out = apply_filters('attachment_tax_crumbs', '', $term, $this ) ){
							$_crumbs    = $this->_tax_crumbs( $term, 'self' );
							$parent_tit = sprintf( $linkpatt, get_permalink($post->post_parent), get_the_title($post->post_parent) );
							$_out = implode( $sep, array($_crumbs, $parent_tit) );
							$out = $this->_add_title( $_out, $post );
						}
					}
				}
				// single
				elseif( is_single() ){
					if( ! $out = apply_filters('post_tax_crumbs', '', $term, $this ) ){
						$_crumbs = $this->_tax_crumbs( $term, 'self' );
						$out = $this->_add_title( $_crumbs, $post );
					}
				}
				// не древовидная такса (метки)
				elseif( ! is_taxonomy_hierarchical($term->taxonomy) ){
					// метка
					if( is_tag() )
						$out = $this->_add_title('', $term, sprintf( $loc->tag, esc_html($term->name) ) );
					// такса
					elseif( is_tax() ){
						$post_label = $ptype->labels->name;
						$tax_label = $GLOBALS['wp_taxonomies'][ $term->taxonomy ]->labels->name;
						$out = $this->_add_title('', $term, sprintf( $loc->tax_tag, $post_label, $tax_label, esc_html($term->name) ) );
					}
				}
				// древовидная такса (рибрики)
				else {
					if( ! $out = apply_filters('term_tax_crumbs', '', $term, $this ) ){
						$_crumbs = $this->_tax_crumbs( $term, 'parent' );
						$out = $this->_add_title( $_crumbs, $term, esc_html($term->name) );
					}
				}
			}
			// влоежния от записи без терминов
			elseif( is_attachment() ){
				$parent = get_post($post->post_parent);
				$parent_link = sprintf( $linkpatt, get_permalink($parent), esc_html($parent->post_title) );
				$_out = $parent_link;

				// вложение от записи древовидного типа записи
				if( is_post_type_hierarchical($parent->post_type) ){
					$parent_crumbs = $this->_page_crumbs($parent);
					$_out = implode( $sep, array( $parent_crumbs, $parent_link ) );
				}

				$out = $this->_add_title( $_out, $post );
			}
			// записи без терминов
			elseif( is_singular() ){
				$out = $this->_add_title( '', $post );
			}
		}

		// замена ссылки на архивную страницу для типа записи
		$home_after = apply_filters('kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype );

		if( '' === $home_after ){
			// Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
			if( $ptype && $ptype->has_archive && ! in_array( $ptype->name, array('post','page','attachment') )
				&& ( is_post_type_archive() || is_singular() || (is_tax() && in_array($term->taxonomy, $ptype->taxonomies)) )
			){
				$pt_title = $ptype->labels->name;

				// первая страница архива типа записи
				if( is_post_type_archive() && ! $paged_num )
					$home_after = '<li><span>'.$pt_title.'</span></li>';
				// singular, paged post_type_archive, tax
				else{
					$home_after = sprintf( $linkpatt, get_post_type_archive_link($ptype->name), $pt_title );

					$home_after .= ( ($paged_num && ! is_tax()) ? $pg_end : $sep ); // пагинация
				}
			}
		}

		$before_out = sprintf( $linkpatt, home_url(), $loc->home ) . ( $home_after ? $sep.$home_after : ($out ? $sep : '') );

		$out = apply_filters('kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg );

		$out = sprintf( $wrappatt, $before_out . $out );

		return apply_filters('kama_breadcrumbs', $out, $sep, $loc, $arg );
	}

	function _page_crumbs( $post ){
		$parent = $post->post_parent;

		$crumbs = array();
		while( $parent ){
			$page = get_post( $parent );
			$crumbs[] = sprintf( $this->arg->linkpatt, get_permalink($page), esc_html($page->post_title) );
			$parent = $page->post_parent;
		}

		return implode( $this->arg->sep, array_reverse($crumbs) );
	}

	function _tax_crumbs( $term, $start_from = 'self' ){
		$termlinks = array();
		$term_id = ($start_from === 'parent') ? $term->parent : $term->term_id;
		while( $term_id ){
			$term       = get_term( $term_id, $term->taxonomy );
			$termlinks[] = sprintf( $this->arg->linkpatt, get_term_link($term), esc_html($term->name) );
			$term_id    = $term->parent;
		}

		if( $termlinks )
			return implode( $this->arg->sep, array_reverse($termlinks) ) /*. $this->arg->sep*/;
		return '';
	}

	// добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
	function _add_title( $add_to, $obj, $term_title = '' ){
		$arg = & $this->arg; // упростим...
		$title = $term_title ? $term_title : esc_html($obj->post_title); // $term_title чиститься отдельно, теги моугт быть...
		$show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

		// пагинация
		if( $arg->pg_end ){
			$link = $term_title ? get_term_link($obj) : get_permalink($obj);
			$add_to .= ($add_to ? $arg->sep : '') . sprintf( $arg->linkpatt, $link, $title ) . $arg->pg_end;
		}
		// дополняем - ставим sep
		elseif( $add_to ){
			if( $show_title )
				$add_to .= $arg->sep . sprintf( $arg->title_patt, $title );
			elseif( $arg->last_sep )
				$add_to .= $arg->sep;
		}
		// sep будет потом...
		elseif( $show_title )
			$add_to = sprintf( $arg->title_patt, $title );

		return $add_to;
	}

}
///---------------**

/**
 * Обрезка текста (excerpt). Шоткоды вырезаются. Минимальное значение maxchar может быть 22.
 * version 2.2
 *
 * @param  массив/строка $args аргументы. Смотрите переменную $default.
 * @return строка HTML
 */
function kama_excerpt( $args = '' ){
	global $post;

	$default = array(
		'maxchar'     => 350, // количество символов.
		'text'        => '',  // какой текст обрезать (по умолчанию post_excerpt, если нет post_content.
		// Если есть тег <!--more-->, то maxchar игнорируется и берется все до <!--more--> вместе с HTML
		'save_format' => false, // Сохранять перенос строк или нет. Если в параметр указать теги, то они НЕ будут вырезаться: пр. '<strong><a>'
		'more_text'   => 'Читать дальше...', // текст ссылки читать дальше
		'echo'        => true, // выводить на экран или возвращать (return) для обработки.
	);

	if( is_array($args) )
		$rgs = $args;
	else
		parse_str( $args, $rgs );

	$args = array_merge( $default, $rgs );

	extract( $args );

	if( ! $text ){
		$text = $post->post_excerpt ? $post->post_excerpt : $post->post_content;

		$text = preg_replace ('~\[[^\]]+\]~', '', $text ); // убираем шоткоды, например:[singlepic id=3]
		// $text = strip_shortcodes( $text ); // или можно так обрезать шоткоды, так будет вырезан шоткод и конструкция текста внутри него
		// и только те шоткоды которые зарегистрированы в WordPress. И эта операция быстрая, но она в десятки раз дольше предыдущей
		// (хотя там очень маленькие цифры в пределах одной секунды на 50000 повторений)

		// для тега <!--more-->
		if( ! $post->post_excerpt && strpos( $post->post_content, '<!--more-->') ){
			preg_match ('~(.*)<!--more-->~s', $text, $match );
			$text = trim( $match[1] );
			$text = str_replace("\r", '', $text );
			$text = preg_replace( "~\n\n+~s", "</p><p>", $text );

			$more_text = $more_text ? '<a class="kexc_moretext" href="'. get_permalink( $post->ID ) .'#more-'. $post->ID .'">'. $more_text .'</a>' : '';

			$text = '<p>'. str_replace( "\n", '<br />', $text ) .' '. $more_text .'</p>';

			if( $echo )
				return print $text;

			return $text;
		}
		elseif( ! $post->post_excerpt )
			$text = strip_tags( $text, $save_format );
	}

	// Обрезаем
	if ( mb_strlen( $text ) > $maxchar ){
		$text = mb_substr( $text, 0, $maxchar );
		$text = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ...', $text ); // убираем последнее слово, оно 99% неполное
	}

	// Сохраняем переносы строк. Упрощенный аналог wpautop()
	if( $save_format ){
		$text = str_replace("\r", '', $text );
		$text = preg_replace("~\n\n+~", "</p><p>", $text );
		$text = "<p>". str_replace ("\n", "<br />", trim( $text ) ) ."</p>";
	}

	//$out = preg_replace('@\*[a-z0-9-_]{0,15}\*@', '', $out); // удалить *some_name-1* - фильтр смайлов

	if( $echo ) return print $text;

	return $text;
}


/**
 * Альтернатива wp_pagenavi. Создает ссылки пагинации на страницах архивов.
 *
 * @param string $before   - текст до навигации
 * @param string $after    - текст после навигации
 * @param bool   $echo     - возвращать или выводить результат
 * @param array  $args     - аргументы функции
 * @param array  $wp_query - объект WP_Query на основе которого строится пагинация. По умолчанию глобальная переменная $wp_query
 *
 * Версия: 2.5
 * Автор: Тимур Камаев
 * Ссылка на страницу функции: http://wp-kama.ru/?p=8
 */
function kama_pagenavi( $before = '', $after = '', $echo = true, $args = array(), $wp_query = null, $paged = null, $max_page = null ) {
	$kp = new Kama_Paginavi($wp_query, $paged, $max_page);
	$kp->get_pagination( $before = '', $after = '', $echo = true, $args = array() );
}

class Kama_Paginavi {
	public $wp_query;
	private $posts_per_page;
	private $paged;
	private $max_page;

	function __construct( $wp_query, $paged, $max_page ) {
		if( !is_array($wp_query) ){
			$this->wp_query = $wp_query;

			if ( !$this->wp_query ) {
				wp_reset_query();
				global $wp_query;
				$this->wp_query = $wp_query;
			}

			$this->posts_per_page = (int)$wp_query->query_vars['posts_per_page'];
			$this->paged = (int)$wp_query->query_vars['paged'];
			$this->max_page = $wp_query->max_num_pages;
		} else {
			$this->paged = (int)$paged;
			$this->max_page = (int)$max_page;
		}

	}

	function get_pagination( $before = '', $after = '', $echo = true, $args = array() )
	{
//		if ( !$this->wp_query ) {
//			wp_reset_query();
//			global $wp_query;
//		}

		// параметры по умолчанию
		$default_args = array(
			'text_num_page' => '', // Текст перед пагинацией. {current} - текущая; {last} - последняя (пр. 'Страница {current} из {last}' получим: "Страница 4 из 60" )
			'num_pages' => 10, // сколько ссылок показывать
			'step_link' => 10, // ссылки с шагом (значение - число, размер шага (пр. 1,2,3...10,20,30). Ставим 0, если такие ссылки не нужны.
			'dotright_text' => '…', // промежуточный текст "до".
			'dotright_text2' => '…', // промежуточный текст "после".
			'back_text' => '« назад', // текст "перейти на предыдущую страницу". Ставим 0, если эта ссылка не нужна.
			'next_text' => 'вперед »', // текст "перейти на следующую страницу". Ставим 0, если эта ссылка не нужна.
			'first_page_text' => '« к началу', // текст "к первой странице". Ставим 0, если вместо текста нужно показать номер страницы.
			'last_page_text' => 'в конец »', // текст "к последней странице". Ставим 0, если вместо текста нужно показать номер страницы.
		);

		$default_args = apply_filters('kama_pagenavi_args', $default_args); // чтобы можно было установить свои значения по умолчанию

		$args = array_merge($default_args, $args);

		extract($args);

		$posts_per_page = $this->posts_per_page;
		$paged = $this->paged;
		$max_page = $this->max_page;

		//проверка на надобность в навигации
		if ($max_page <= 1)
			return false;

		if (empty($paged) || $paged == 0)
			$paged = 1;

		$pages_to_show = intval($num_pages);
		$pages_to_show_minus_1 = $pages_to_show - 1;

		$half_page_start = floor($pages_to_show_minus_1 / 2); //сколько ссылок до текущей страницы
		$half_page_end = ceil($pages_to_show_minus_1 / 2); //сколько ссылок после текущей страницы

		$start_page = $paged - $half_page_start; //первая страница
		$end_page = $paged + $half_page_end; //последняя страница (условно)

		if ($start_page <= 0)
			$start_page = 1;
		if (($end_page - $start_page) != $pages_to_show_minus_1)
			$end_page = $start_page + $pages_to_show_minus_1;
		if ($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = (int)$max_page;
		}

		if ($start_page <= 0)
			$start_page = 1;

		//выводим навигацию
		$out = '';
		$out = '<div id="pagination">';

		// создаем базу чтобы вызвать get_pagenum_link один раз
		$link_base = str_replace(99999999, '___', get_pagenum_link(99999999));
		$first_url = get_pagenum_link(1);
		if (false === strpos($first_url, '?'))
			$first_url = user_trailingslashit($first_url);


		if ($next_text && $paged != $end_page) {
			$out .= '<div class="load-tours">
                        <div class="loader-container" style="display: none"><div class="loader"></div></div>
                        <a href="' . str_replace('___', ($paged + 1), $link_base) . '" id="more_post" class="tours-link">More tours</a>
                    </div>';
		}


		$out .= $before . "<ul class='pagination wp-pagenavi'>\n";

		if ($text_num_page) {
			$text_num_page = preg_replace('!{current}|{last}!', '%s', $text_num_page);
			$out .= sprintf("<span class='pages'>$text_num_page</span> ", $paged, $max_page);
		}
		// назад
		if ($back_text && $paged != 1)
			$out .= '<li class="pagination__arrow pagination__arrow_prev"><a class="prev" href="' . (($paged - 1) == 1 ? $first_url : str_replace('___', ($paged - 1), $link_base)) . '"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . get_template_directory_uri() . '/img/sprite-inline.svg#arrow-left"></use></svg></a></li> ';
		// в начало
		if ($start_page >= 2 && $pages_to_show < $max_page) {
			$out .= '<a class="first" href="' . $first_url . '">' . ($first_page_text ? $first_page_text : 1) . '</a> ';
			if ($dotright_text && $start_page != 2) $out .= '<span class="extend">' . $dotright_text . '</span> ';
		}
		// пагинация
		for ($i = $start_page; $i <= $end_page; $i++) {
			if ($i == $paged)
				$out .= '<li class="active current"><span>' . $i . '</span></li> ';
			elseif ($i == 1)
				$out .= '<li><a href="' . $first_url . '">1</a></li> ';
			else
				$out .= '<li><a href="' . str_replace('___', $i, $link_base) . '">' . $i . '</a></li> ';
		}

		//ссылки с шагом
		$dd = 0;
		if ($step_link && $end_page < $max_page) {
			for ($i = $end_page + 1; $i <= $max_page; $i++) {
				if ($i % $step_link == 0 && $i !== $num_pages) {
					if (++$dd == 1)
						$out .= '<span class="extend">' . $dotright_text2 . '</span> ';
					$out .= '<a href="' . str_replace('___', $i, $link_base) . '">' . $i . '</a> ';
				}
			}
		}
		// в конец
		if ($end_page < $max_page) {
			if ($dotright_text && $end_page != ($max_page - 1))
				$out .= '<span class="extend">' . $dotright_text2 . '</span> ';
			$out .= '<li><a class="last" href="' . str_replace('___', $max_page, $link_base) . '">' . ($last_page_text ? $last_page_text : $max_page) . '</a></li> ';
		}
		// вперед
		if ($next_text && $paged != $end_page)
			$out .= '<li class="pagination__arrow pagination__arrow_next"><a class="next" href="' . str_replace('___', ($paged + 1), $link_base) . '"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . get_template_directory_uri() . '/img/sprite-inline.svg#arrow-right"></use></svg></a></li> ';

		$out .= "</ul>" . $after . "\n";

		$out .= "</div>" . "\n";

		$out = apply_filters('kama_pagenavi', $out);

		if ($echo)
			return print $out;

		return $out;
	}
}
/**
 * 2.5 - автоматический сброс основного запроса.
 */