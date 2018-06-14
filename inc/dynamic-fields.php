<?php
// 1. customize ACF path
function my_acf_settings_path( $path ) {
    $path = get_stylesheet_directory() . '/inc/acf/';
    return $path; 
}
 
// 2. customize ACF dir
function my_acf_settings_dir( $dir ) {
    $dir = get_stylesheet_directory_uri() . '/inc/acf/';
    return $dir; 
}

function theme_acf_setup() {
	//add_filter('acf/settings/path', 'my_acf_settings_path'); // customize ACF path
	//add_filter('acf/settings/dir', 'my_acf_settings_dir'); // customize ACF dir
    add_filter( 'acf/settings/current_language',  '__return_false' ); // for options page in WPML
	
	//include_once( get_stylesheet_directory() . '/inc/acf/acf.php' ); // Include ACF


	//include_once( get_stylesheet_directory() . '/inc/acf/plugins/acf-field-date-time-picker/acf-date_time_picker.php' );


}

theme_acf_setup();

add_filter('acf/settings/google_api_key', function () {
    return 'AIzaSyBNtaAfhUtr2jzhlYnad_XLCnYrcyIO4gY';
});

    //ACF and Menu Custom------------------------------------------------
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title'    => 'Основные',
            'menu_title'    => 'Основные',
            'menu_slug'     => 'theme-options',
            'capability'    => 'manage_options',
            'parent_slug'   => '',
            'position'      => '1.1',
            'ico_url'       => false,
        ));
        acf_add_options_page(array(
            'page_title'    => 'Скрипты',
            'menu_title'    => 'Скрипты',
            'menu_slug'     => 'acf-options-scripts',
            'capability'    => 'manage_options',
            'parent_slug'   => 'theme-options',
            'position'      => false,
            'ico_url'       => false,
        ));
        acf_add_options_page(array(
            'page_title'    => 'Настройки',
            'menu_title'    => 'Настройки',
            'menu_slug'     => 'acf-options-sys',
            'position'      => false,
            'capability'    => 'manage_options',
            'parent_slug'   => 'theme-options',
            'ico_url'       => false,
        ));

    }

    //ACF and Menu Custom------------------------------------------------

    
function my_scripts( $position ){
        if( $scripts = get_field('scripts','option') ){
            foreach( $scripts as $script ){
                if( $script['script__on'] && ($script['script__position'] == $position || $position === NULL)){
                    echo $script['script__code'];
                }
            }
        }
}
    
if(function_exists("register_field_group") )
{
    //------------НАСТРОЙКИ
    acf_add_local_field_group(array (
        'id' => 'acf_-options__mail',
        'title' => 'System',
        'fields' => array (
//            array (
//                'key' => 'field_mail_from',
//                'label' => 'Почта "От:"',
//                'name' => 'email_from',
//                'type' => 'text',
//                'instructions' => 'к примеру mysite.ru < info@mysite.ru >',
//                'required' => 1,
//                'conditional_logic' => 0,
//                'wrapper' => array (
//                    'width' => '',
//                    'class' => '',
//                    'id' => '',
//                ),
//                'default_value' => '',
//                'placeholder' => '',
//                'prepend' => '',
//                'append' => '',
//                'maxlength' => '',
//                'readonly' => 0,
//                'disabled' => 0,
//            ),
            array (
                'key' => 'field_mail_to',
                'label' => 'Почта, для получения писем',
                'name' => 'email_true',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'min' => 1,
                'max' => '',
                'layout' => 'table',
                'button_label' => 'Добавить',
                'sub_fields' => array (
                    array (
                        'key' => 'field_mail_to_item',
                        'label' => 'mail',
                        'name' => 'mail',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                        'readonly' => 0,
                        'disabled' => 0,
                    ),
                ),
                'collapsed' => '',
            ),
            array (
                'key' => 'field_mail_bcc',
                'label' => 'Почта, для получения писем \'BCC:\'',
                'name' => 'email_true_bcc',
                'type' => 'repeater',
                'instructions' => 'Адреса получателей письма, чьи адреса не следует показывать другим получателям',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'min' => '',
                'max' => '',
                'layout' => 'table',
                'button_label' => 'Добавить',
                'sub_fields' => array (
                    array (
                        'key' => 'field_mail_bcc_item',
                        'label' => 'mail',
                        'name' => 'mail',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                        'readonly' => 0,
                        'disabled' => 0,
                    ),
                ),
                'collapsed' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-sys',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'seamless',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

    /*---------------------------------------------------------------------------*/
    /* ОПЦИИ ТЕМЫ - Скрипты                                                     */
    /*-------------------------------------------------------------------------*/
    register_field_group(array (
        'id' => 'acf_-options__scripts',
        'title' => 'Скрипты',
        'fields' => array (
            array (
                'key' => 'field_scripts',
                'label' => 'Скрипты',
                'name' => 'scripts',
                'type' => 'repeater',
                'instructions' => 'Вы можете вставить сюда скрипты Яндекс-Метрики, Гугл-Аналитики, сервисов обратной связи и прочие.<br>Вы можете на время отключить скрипт, сняв галочку. Если вы захотите вновь активировать скрипт, вам не придётся его искать.',
                'sub_fields' => array (
                    array (
                        'key' => 'field_script__code',
                        'label' => 'Код',
                        'name' => 'script__code',
                        'type' => 'textarea',
                        'column_width' => '',
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                        'formatting' => 'text',
                    ),
                    array (
                        'key' => 'field_script__position',
                        'label' => 'Положение',
                        'name' => 'script__position',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => 10,
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array (
                            'header' => 'header',
                            'footer' => 'footer',
                        ),
                        'default_value' => array (
                            'header' => 'header',
                        ),
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'ajax' => 0,
                        'placeholder' => '',
                        'disabled' => 0,
                        'readonly' => 0,
                    ),
                    array (
                        'key' => 'field_script__on',
                        'label' => 'Состояние',
                        'name' => 'script__on',
                        'type' => 'true_false',
                        'column_width' => 8,
                        'message' => '',
                        'default_value' => 1,
                    ),
                ),
                'row_min' => 0,
                'row_limit' => '',
                'layout' => 'table',
                'button_label' => 'Добавить скрипт',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-scripts',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ));
}

function my_acf_load_field( $field ) {

    $field['readonly'] = 1;
    return $field;

}
add_filter('acf/load_field/key=field_58873322c9c61', 'my_acf_load_field');


function my_acf_flexible_content_layout_title( $title, $field, $layout, $i ) {
    $map = get_sub_field('map');
    $name = get_sub_field('title');

    if ( empty($name) ) {
        $title .= ': '. $map['address'];
    } else {
        $title .= ': '. $name;
    }

    return $title;
}

add_filter('acf/fields/flexible_content/layout_title/name=places_geo', 'my_acf_flexible_content_layout_title', 10, 4);


function my_acf_flexible_content_layout_title_programm( $title, $field, $layout, $i ) {

    $title .= ': '. ($i + 1);

    return $title;
}

add_filter('acf/fields/flexible_content/layout_title/name=programm', 'my_acf_flexible_content_layout_title_programm', 10, 4);