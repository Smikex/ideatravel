<?php

//----
if( is_admin() ){
    add_action( 'admin_head', 'polyarix_css_fix' );
}

add_action('login_head', 'polyarix_css_fix_login', 99 );


function polyarix_css_fix() {
      ?>
      <style>
          #adminmenuwrap:before {
              content: '';
              text-align: center;
              width: 100%;
              height: 84px;
              display: block;
              background-size: contain;
          }
          #adminmenuwrap:before {
              background-image: url(<?php echo get_bloginfo('template_directory')?>/inc/admin/polyarix_logo.png)!important;
          }
      </style>
      <?php
}


function polyarix_css_fix_login(){
?>
    <style>
        body {
            overflow: hidden;
        }
        .login form p label {
            font-size: 0;
        }

        .login form p label input {
            font-size: 14px;
        }

    body, #wp-auth-check-wrap #wp-auth-check{
        background-image:url(<?php echo get_bloginfo('template_directory')?>/inc/admin/bg1.jpg);
        background-size: cover;
        background-position:center top; 
    }

    #login {
        z-index: 100;
        position: relative;
    }

    #snow {
        position: absolute;
        left: 0px;
        top: 0px;
        right: 0px;
        bottom: 0px;
        overflow: hidden;
        z-index: 50;
    }

    .login h1 a { background-image: url(<?php echo get_bloginfo('template_directory')?>/inc/admin/polyarix_logo.png);}

    .login h1 a {
        height: 115px;
        font-size: 23px;
        font-weight: 400;
        line-height: 23px;
        margin: 0px auto 0px auto;
        padding: 0;
        text-decoration: none;
        max-width: 391px;
        width: 100%;
        background-size: contain;
    }

    </style>
    <?php
}



//----!


//-----------<Сменить надпись в подвале консоли WordPress>-----------------
function remove_footer_admin () {
    echo "<span style='display: inline-block; vertical-align: middle;'>Developed by</span> <a href='http://polyarix.com/' target='_blank' style='display: inline-block; vertical-align: middle;'><svg style='height: 25px; margin-left: 4px' viewBox=\"0 0 419.4 112.61\">
  <g>
    <path d=\"M0,26.31H24.5a48.65,48.65,0,0,1,10.3,1,24.32,24.32,0,0,1,8.4,3.4,16.6,16.6,0,0,1,5.6,6.4,20.6,20.6,0,0,1,2.1,9.8,21,21,0,0,1-2.1,9.7,19.77,19.77,0,0,1-5.7,6.8,23.53,23.53,0,0,1-8.3,3.9,36.79,36.79,0,0,1-10.1,1.3H15.3v21.7H0v-64H0Zm23.6,30.8c8.2,0,12.4-3.4,12.4-10.2,0-3.3-1-5.7-3.1-7.1s-5.2-2.1-9.2-2.1H15.2V57h8.4v0.1Zm95.9-30.8h15.2v51.8h26.6v12.2H119.6l-0.1-64h0Zm56.1,41.2-20.3-41.2h16.3l6,14.7c0.9,2.3,1.8,4.7,2.7,7s1.8,4.6,2.7,7.1h0.4c1-2.5,1.9-4.9,2.8-7.1s1.9-4.7,2.8-7l6.1-14.7H211l-20.3,41.2v22.8H175.6V67.51h0Zm72.2,7.6H227.3l-4.1,15.2H207.7l21-64H247l21,64H252Zm-3.1-11.3-1.5-5.9c-1-3.4-1.9-6.8-2.8-10.2s-1.8-6.9-2.7-10.4h-0.4c-0.8,3.4-1.7,6.9-2.5,10.5s-1.8,7-2.7,10.2l-1.7,5.9,14.3-.1h0Zm67,26.5-12.9-23.1h-8.3v23.1H275.4v-64h24.2a45.21,45.21,0,0,1,10,1,25.18,25.18,0,0,1,8.2,3.3,17.32,17.32,0,0,1,5.6,6.1,19.63,19.63,0,0,1,2.1,9.5,19.87,19.87,0,0,1-3.2,11.6,20.26,20.26,0,0,1-8.7,6.8l15.3,25.6-17.2.1h0Zm-21.2-34.5h7.8c4,0,7-.8,9.1-2.4s3.1-4,3.1-7.1-1-5.3-3.1-6.6-5.1-1.9-9.1-1.9h-7.8v18Zm48.3-29.5H354v64H338.9v-64h-0.1Zm42.9,31.1-17.5-31.1h16.9l5.9,12.1c0.8,1.6,1.5,3.2,2.3,4.8s1.6,3.5,2.6,5.5h0.4c0.7-1.9,1.4-3.7,2.2-5.5s1.4-3.3,2.1-4.8l5.4-12.1h16.2l-17.4,31.8,18.6,32.2H402.5l-6.7-13.1-2.4-5.1c-0.9-1.8-1.7-3.6-2.6-5.4h-0.4c-0.8,2-1.5,3.8-2.3,5.4s-1.5,3.4-2.3,5.1l-6.3,13.1H363.2l18.5-32.9h0Z\" fill=\"#7db100\"/>
    <path d=\"M42.1,58.41a38.66,38.66,0,0,1-.3-4.8A41.27,41.27,0,0,1,83,12.41h1.3v1.4H83.1a39.84,39.84,0,0,0-39.8,39.8,34.4,34.4,0,0,0,.3,4.6C43.5,58.21,42.1,58.41,42.1,58.41ZM83,94.81a40.73,40.73,0,0,1-24.7-8.2l0.9-1.1A39.34,39.34,0,0,0,83,93.41a40.28,40.28,0,0,0,4.9-.3l0.2,1.4a43.61,43.61,0,0,1-5.1.3h0Z\" fill=\"#7db100\"/>
    <path d=\"M54.1,30.71l-1.1-.9A38.27,38.27,0,0,1,91.4,16l-0.3,1.4a35.68,35.68,0,0,0-8-.9,37.47,37.47,0,0,0-29,14.2h0Zm29,61a38.22,38.22,0,0,1-29-13.3l1.1-.9a36.94,36.94,0,0,0,27.9,12.8,36,36,0,0,0,17.6-4.5l0.7,1.3a38.81,38.81,0,0,1-18.3,4.6h0Z\" fill=\"#7db100\"/>
    <path d=\"M50.5,46.31L49.1,46a34.75,34.75,0,0,1,54.7-20.3l-0.9,1.1a33.29,33.29,0,0,0-52.4,19.5h0Zm32.6,42a34.62,34.62,0,0,1-26.3-12.1l1.1-.9a33.08,33.08,0,0,0,25.3,11.6,33.54,33.54,0,0,0,25.4-11.7l1.1,0.9a35.66,35.66,0,0,1-26.6,12.2h0Z\" fill=\"#7db100\"/>
    <path d=\"M83,84.91a31.3,31.3,0,0,1,0-62.6,31.89,31.89,0,0,1,16.2,4.5L98.5,28a30,30,0,1,0,9.5,9.2l1.2-.8a31.76,31.76,0,0,1,5.1,17.2A31.35,31.35,0,0,1,83,84.91h0Z\" fill=\"#7db100\"/>
    <path d=\"M83.2,81.41a28,28,0,1,1,28-28,28.08,28.08,0,0,1-28,28h0Zm0-54.6a26.55,26.55,0,1,0,26.5,26.5,26.63,26.63,0,0,0-26.5-26.5h0Z\" fill=\"#7db100\"/>
    <path d=\"M83.1,77.71a24.2,24.2,0,0,1,0-48.4,25.22,25.22,0,0,1,8.2,1.4L90.8,32a22.82,22.82,0,1,0-7.7,44.3A21.14,21.14,0,0,0,90.6,75l0.5,1.3a24.5,24.5,0,0,1-8,1.4h0Z\" fill=\"#7db100\"/>
    <path d=\"M83,73.91a20.42,20.42,0,0,1-20.4-20.4,20,20,0,0,1,2.3-9.3l1.3,0.7a18.63,18.63,0,0,0-2.1,8.7,19,19,0,1,0,38,0,18.48,18.48,0,0,0-.1-2.3l1.4-.2a22.86,22.86,0,0,1,.2,2.5A20.64,20.64,0,0,1,83,73.91h0Z\" fill=\"#7db100\"/>
    <path d=\"M82.9,70.61a17,17,0,0,1,0-34,16.54,16.54,0,0,1,5.4.9L87.9,39a16.87,16.87,0,0,0-5-.8,15.5,15.5,0,1,0,15.4,17.7l1.4,0.2a17,17,0,0,1-16.8,14.5h0Z\" fill=\"#7db100\"/>
    <path d=\"M95.6,53.81A12.8,12.8,0,1,1,82.8,41a12.82,12.82,0,0,1,12.8,12.8h0Z\" fill=\"#7db100\"/>
    <path d=\"M82.8,67.21a13.5,13.5,0,1,1,13.5-13.5,13.51,13.51,0,0,1-13.5,13.5h0Zm0-25.5a12.05,12.05,0,1,0,12,12.1,11.93,11.93,0,0,0-12-12.1h0Zm-42.7,7.4L38.7,49a44.58,44.58,0,0,1,27.8-36.8l0.5,1.3a43.18,43.18,0,0,0-26.9,35.6h0Zm43,49.2a44.51,44.51,0,0,1-33.5-15.2l1.1-.9a43.2,43.2,0,0,0,53.2,9.4l0.7,1.3a46,46,0,0,1-21.5,5.4h0Z\" fill=\"#7db100\"/>
    <path d=\"M37.8,41.31l-1.4-.4A48.48,48.48,0,0,1,83,5.41a47,47,0,0,1,16.7,3l-0.5,1.3A46.47,46.47,0,0,0,83,6.81a47.08,47.08,0,0,0-45.2,34.5h0ZM83,102a48.3,48.3,0,0,1-42.1-24.6l1.2-.7A47.11,47.11,0,0,0,83,100.61a48.7,48.7,0,0,0,13.1-1.8l0.4,1.4A51.08,51.08,0,0,1,83,102h0Z\" fill=\"#7db100\"/>
    <path d=\"M34.6,40l-1.4-.4a51.54,51.54,0,0,1,23-30.3l0.7,1.2A50.86,50.86,0,0,0,34.6,40Zm37.1,64.2a52.21,52.21,0,0,1-27.9-16.8l1.1-.9A50.24,50.24,0,0,0,72,102.81l-0.3,1.4h0Z\" fill=\"#7db100\"/>
    <path d=\"M31.9,36.61l-1.4-.5a55.89,55.89,0,0,1,13.6-21.7l1,1a55,55,0,0,0-13.2,21.2h0ZM79.5,109a54.52,54.52,0,0,1-38.4-19.1l1.1-.9a53.52,53.52,0,0,0,37.4,18.6L79.5,109h0Z\" fill=\"#7db100\"/>
    <path d=\"M28,37.51l-1.4-.4A58.61,58.61,0,0,1,52.7,3.41l0.7,1.2A56.91,56.91,0,0,0,28,37.51h0Zm55,75.1a59.3,59.3,0,0,1-47.3-23.8l1.1-.8a57.55,57.55,0,0,0,46.1,23.3c1.2,0,2.4,0,3.6-.1l0.1,1.4H83ZM43,74.91a2.69,2.69,0,0,1-2.7,2.7h0a2.7,2.7,0,1,1,0-5.4h0a2.75,2.75,0,0,1,2.7,2.7h0Z\" fill=\"#7db100\"/>
    <path d=\"M40.3,78.31a3.4,3.4,0,1,1,3.4-3.4,3.37,3.37,0,0,1-3.4,3.4h0Zm0-5.3a2,2,0,0,0-2,1.9h0a2,2,0,0,0,4,0,1.92,1.92,0,0,0-2-1.9h0Zm64.6-24a2.69,2.69,0,0,1-2.7,2.7h0A2.69,2.69,0,0,1,99.5,49h0a2.69,2.69,0,0,1,2.7-2.7,2.82,2.82,0,0,1,2.7,2.7h0Z\" fill=\"#7db100\"/>
    <path d=\"M102.2,52.41A3.37,3.37,0,0,1,98.8,49a3.4,3.4,0,0,1,6.8,0,3.37,3.37,0,0,1-3.4,3.4h0Zm0-5.3a2,2,0,1,0,2,2.1h0a2,2,0,0,0-2-2.1h0Zm1.7-38.7a2.68,2.68,0,0,1-4.5,2.9,2.64,2.64,0,0,1,.8-3.7,2.7,2.7,0,0,1,3.7.8h0Z\" fill=\"#7db100\"/>
    <path d=\"M101.7,13.31a3.65,3.65,0,0,1-2.9-1.5,3.39,3.39,0,0,1,1-4.7,3.09,3.09,0,0,1,1.8-.5,3.48,3.48,0,0,1,2.9,1.6,3.39,3.39,0,0,1-1,4.7,5.26,5.26,0,0,1-1.8.4h0Zm0-5.4a2,2,0,0,0-1.1.3,2,2,0,1,0,2.7.6,2,2,0,0,0-1.6-.9h0Z\" fill=\"#7db100\"/>
    <g>
      <path d=\"M56.2,1.61a2.18,2.18,0,0,1-.6,2.9,2.2,2.2,0,0,1-2.9-.6A2.18,2.18,0,0,1,53.3,1a2.2,2.2,0,0,1,2.9.6h0Z\" fill=\"#7db100\"/>
      <path d=\"M54.4,5.61a2.65,2.65,0,0,1-2.3-1.3,2.87,2.87,0,0,1,.8-3.9,2.88,2.88,0,0,1,3.9.9,2.87,2.87,0,0,1-.8,3.9,4.19,4.19,0,0,1-1.6.4h0Zm0-4.2A1.37,1.37,0,0,0,53,2.81a1.45,1.45,0,0,0,.2.7,1.42,1.42,0,0,0,1.9.4A1.34,1.34,0,0,0,55.6,2a1.43,1.43,0,0,0-1.2-.6h0Z\" fill=\"#7db100\"/>
    </g>
    <g>
      <path d=\"M106.6,26.61a2.09,2.09,0,1,1-3.5,2.3h0a2.18,2.18,0,0,1,.6-2.9,2,2,0,0,1,2.9.6h0Z\" fill=\"#7db100\"/>
      <path d=\"M104.9,30.51a2.77,2.77,0,0,1-2.3-1.3,2.87,2.87,0,0,1,.8-3.9,3,3,0,0,1,3.9.8,2.87,2.87,0,0,1-.8,3.9,3.32,3.32,0,0,1-1.6.5h0Zm0-4.2a1.37,1.37,0,0,0-1.4,1.4,1.45,1.45,0,0,0,.2.7,1.37,1.37,0,0,0,2.3-1.5,1.36,1.36,0,0,0-1.1-.6h0Z\" fill=\"#7db100\"/>
    </g>
    <g>
      <path d=\"M108.5,89.61a2.68,2.68,0,1,1-3.7-.8,2.62,2.62,0,0,1,3.7.8h0Z\" fill=\"#7db100\"/>
      <path d=\"M106.3,94.41a3.48,3.48,0,0,1-2.9-1.6,3.4,3.4,0,1,1,4.7,1A3,3,0,0,1,106.3,94.41Zm0-5.3a2.28,2.28,0,0,0-1.1.3,2,2,0,1,0,2.7.6,1.7,1.7,0,0,0-1.6-.9h0Z\" fill=\"#7db100\"/>
    </g>
  </g>
</svg></a>";
}

add_filter('admin_footer_text', 'remove_footer_admin');
//-----------</Сменить надпись в подвале консоли WordPress>-----------------

/*Заменить ссылку под лого на странице входа в админку*/
function gb_custom_loginlogo_url( $url )
{
    return esc_url( home_url( '/' ) );
}
add_filter( 'login_headerurl', 'gb_custom_loginlogo_url' );

/*Заменить title лого на странице входа в админку*/
function gb_custom_loginlogo_title( $url ) {
    return 'Разаработано POLYARIX';
}
add_filter( 'login_headertitle', 'gb_custom_loginlogo_title' );
//-----------</Стиль экрана входа>-----------------