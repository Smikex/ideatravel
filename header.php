<?php

    $template_uri   = get_template_directory_uri();

    $fields = get_fields();

    $homeID = get_option( 'page_on_front' );

?>



<!DOCTYPE html>

<html lang="<?= ICL_LANGUAGE_CODE ?>">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="format-detection" content="telephone=no">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:900" rel="stylesheet">

    <link rel="shortcut icon" href="<?= $template_uri ?>/favicon.png">



    <link rel="stylesheet" type="text/css" href="<?= $template_uri ?>/css/vendor.css">

    <link rel="stylesheet" type="text/css" href="<?= $template_uri ?>/css/main.css?ver=1.0">

    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_uri(); ?>?ver=<?php echo filemtime(get_template_directory().'/style.css'); ?>">



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->

    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <?php wp_head(); ?>

    <?php my_scripts('header'); /* Опции темы -> Скрипты */ ?>

</head>

<body <?php body_class(); ?>>



<?php ob_start(); ?>

<header id="header">

    <div class="container">

        <div class="row">

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6 menu-container">

                <div class="company-logo"><a href="<?= home_url() ?>">

                        <svg class="default-icon">

                            <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#company-logo"></use>

                        </svg>

                        <svg class="floating-icon">

                            <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#floating-logo"></use>

                        </svg></a></div>

                <nav>

                    <?php

                    wp_nav_menu( array(

                        'theme_location'  => 'desc-menu',

                        'menu_class'      => 'main-menu',

                        'echo'            => true,

                    ) );

                    ?>

                    <div class="main-phone visible-xs">

                        <svg>

                            <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#phone-handle"></use>

                        </svg><span class="main-phone__title"><?= get_field('phone_title', $homeID) ?></span><br>
			    <?php 
			    $phones = explode(",", get_field('phone', $homeID) );
			    foreach($phones as $phone) {
			    ?>
			    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $phone ) ?>" class="main-phone__number"><?= $phone ?></a>
			    <?php } ?>
                    </div>

                </nav>

            </div>

            <div class="col-lg-2 col-md-2 col-sm-3 phone-container">

                <div class="main-phone">

                    <svg>

                        <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#phone-handle"></use>

                    </svg><span class="main-phone__title"><?= get_field('phone_title', $homeID) ?></span><br>
			<?php 
			    $phones = explode(",", get_field('phone', $homeID) );
			    foreach($phones as $phone) {
			    ?>
			    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $phone ) ?>" class="main-phone__number"><?= $phone ?></a>
			    <?php } ?>
			

                </div>

            </div>

            <div class="col-lg-1 col-md-1 col-sm-2 lang-container">

                <?php

                $languages = icl_get_languages('skip_missing=1');



                if(0 < count($languages)){

                    echo '<ul class="lang-switcher">';

                    foreach($languages as $l){



                        if($l['active']) {

                            echo '<li class="active"><a>'.$l['language_code'].'</a></li>'."\n";

                        } else {

                            echo '<li><a href="'.$l['url'].'">'.$l['language_code'].'</a></li>'."\n";

                        }



                    }



                    echo '</ul>';

                }

                ?>

            </div>

            <div class="col-sm-1 col-xs-6 visible-sm-visible-xs">

                <div class="hamburger-box">

                    <div class="hamburger js-hamburger">

                        <div class="hamburger__line"></div>

                        <div class="hamburger__line"></div>

                        <div class="hamburger__line"></div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</header>

<?php

    $header_html = ob_get_contents();

    ob_end_clean();

?>

