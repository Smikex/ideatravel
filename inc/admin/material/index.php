<?php

function wpse_80236_Colorpicker(){
    // you forgot this probably it's the bundled CSS
    wp_enqueue_style( 'wp-color-picker');
    //
    wp_enqueue_script( 'wp-color-picker');
}

add_action('admin_enqueue_scripts', 'wpse_80236_Colorpicker');


//----
if( is_admin() ){

    add_action('admin_enqueue_scripts', 'admin_css', 1);
    add_action('admin_enqueue_scripts', 'admin_js', 99);
    add_action( 'admin_head', 'material_css_fix' );

    add_action( 'wp_after_admin_bar_render', 'div_ma_btn' );
}

add_action('login_head', 'material_login_loader', 99 );




function material_css_fix() {
    $url = get_template_directory_uri() . '/inc/admin/material/css/css_fix.css';
    wp_deregister_style('material-css_fix', $url);
    wp_register_style('material-css_fix', $url);
    wp_enqueue_style('material-css_fix');
}

function admin_css() {
    $url = get_template_directory_uri() . '/inc/admin/material/css/material_actions.css';
    wp_deregister_style('ma-admin', $url);
    wp_register_style('ma-admin', $url);
    wp_enqueue_style('ma-admin');


    $url = get_template_directory_uri() . '/inc/admin/material/css/style.css';
    wp_deregister_style('material-admin', $url);
    wp_register_style('material-admin', $url);
    wp_enqueue_style('material-admin');


    $url = get_template_directory_uri() . '/inc/admin/material/css/admin.css';
    wp_deregister_style('material-admin-2', $url);
    wp_register_style('material-admin-2', $url);
    wp_enqueue_style('material-admin-2');


    $url = get_template_directory_uri() . '/inc/admin/material/css/admin_bar_green.css';
    wp_deregister_style('material-admin-3', $url);
    wp_register_style('material-admin-3', $url);
    wp_enqueue_style('material-admin-3');


    $url = get_template_directory_uri() . '/inc/admin/material/css/admin_menu.css';
    wp_deregister_style('material-admin-4', $url);
    wp_register_style('material-admin-4', $url);
    wp_enqueue_style('material-admin-4');

    $url = get_template_directory_uri() . '/inc/admin/material/css/admin_menu_h.css';
    wp_deregister_style('material-admin-5', $url);
    wp_register_style('material-admin-5', $url);
    wp_enqueue_style('material-admin-5');



    wp_register_style('material-admin-6', get_template_directory_uri() . '/inc/admin/material/css/theme.css');
    wp_enqueue_style('material-admin-6');


}

function admin_js() {
    wp_register_script('jquery-ui', 'https://code.jquery.com/ui/1.12.0/jquery-ui.min.js', '', '', true);
    wp_enqueue_script('jquery-ui');

    wp_register_script('jquery.cookie', get_template_directory_uri() . '/inc/admin/material/js/jquery.cookie.js', '', '', true);
    wp_enqueue_script('jquery.cookie');


    wp_register_script('material-js-2', get_template_directory_uri() . '/inc/admin/material/js/main.js', '', '', true);
    wp_enqueue_script('material-js-2');

    wp_register_script('material-js-3', get_template_directory_uri() . '/inc/admin/material/js/dropdown.js', '', '', true);
    wp_enqueue_script('material-js-3');


    wp_register_script('ma-js-3', get_template_directory_uri() . '/inc/admin/material/js/common.min.js', '', '', true);
    wp_enqueue_script('ma-js-3');


    wp_register_script('ma-js-1', get_template_directory_uri() . '/inc/admin/material/js/actions_main.js', '', '', true);
    wp_enqueue_script('ma-js-1');

}


function material_login_loader() {
    $url = get_template_directory_uri() . '/inc/admin/material/css/login.css';
    wp_deregister_style('material-login-css', $url);
    wp_register_style('material-login-css', $url);
    wp_enqueue_style('material-login-css');
}

function div_ma_btn(){
    ?>
    <div id="mvp-plus-button-container" class="fixed-action-btn">
        <ul>


            <li>
                <a target="_self" onclick="" href="<?php echo get_home_url(); ?>" data-position="left" data-delay="01" data-tooltip="<?php _e( 'Visit Site' ); ?>" class="tooltiped btn-floating waves-effect waves-light yellow darken-1">
                    <i class="fa fa-home"></i>
                </a>
            </li>


            <!--<li>
                <a target="_self" onclick="" href="<?php echo admin_url( 'post-new.php' ); ?>" data-position="left" data-delay="01" data-tooltip="<?php _e( 'Add New Post' ); ?>" class="tooltiped btn-floating waves-effect waves-light green">
                    <i class="fa fa-pencil"></i>
                </a>
            </li>-->


            <li>
                <a target="_self" onclick="" href="<?php echo admin_url( 'post-new.php?post_type=page' ); ?>" data-position="left" data-delay="01" data-tooltip="<?php _e( 'Add New Page' ); ?>" class="tooltiped btn-floating waves-effect waves-light blue">
                    <i class="fa fa-file"></i>
                </a>
            </li>


            <li>
                <a target="_self" onclick="" href="<?php echo admin_url( 'options-general.php' ); ?>" data-position="left" data-delay="01" data-tooltip="<?php _e( 'Settings' ); ?>" class="tooltiped btn-floating waves-effect waves-light grey">
                    <i class="fa fa-cog"></i>
                </a>
            </li>


        </ul>

        <a id="material-admin-trigger" class="btn-floating btn-large waves-effect waves-light wp-ui-highlight">
            <i class="large mdi-content-add"></i>
        </a>
    </div>
    <?php
}