<?php
    include_once( get_stylesheet_directory() . '/header.php' );
?>
<section class="main-section">
    <div class="background"><img src="<?= $template_uri ?>/img/pages/cities/cities-bgd.jpg" alt=""></div>
    <?= $header_html ?>
    <div class="container main-section__content">
        <h1><?php post_type_archive_title() ?></h1>
        <p class="page-subtitle"><?php _e('','theme-text-idea') ?></p>
    </div>
</section>
<section class="breadcrumbs-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12"><?php kama_breadcrumbs(); ?></div>
        </div>
    </div>
</section>

<article class="page-content">
    <section class="cities-cards">
        <div class="container">
            <div class="row products-list">
                <?php
                function big_card( $data ) {?>
                    <div class="col-lg-8 col-md-8 col-sm-6 card-container"><a href="<?= get_permalink() ?>" class="city-card city-card_big">
                            <div class="city-card__photo"><img src="<?php echo get_the_post_thumbnail_url( $data->post_ID, '780x425' ); ?>"></div>
                            <div class="city-card__text">
                                <p class="date"><?= date("m / d / Y", strtotime($data->post_date)) ?></p>
                                <h5><?= $data->post_title ?></h5>
                                <p>
                                    <?php
                                    if( empty($data->post_excerpt) ) {
                                        $t = get_field('content', $data->post_ID)[0]['text'];
                                        kama_excerpt("maxchar=200&text=$t");
                                    }else{
                                        kama_excerpt("maxchar=200");
                                    }
                                    ?>
                                </p>
                                <?php
                                $views = get_field('views', $data->post_ID);
                                if( get_field('views', $data->post_ID) > 0 ) {?>
                                    <div class="views">
                                        <svg><use xlink:href="<?= get_template_directory_uri() ?>/img/sprite-inline.svg#eye"></use></svg>
                                        <span><?= $views ?></span>
                                    </div>
                                <?php } ?>
                            </div></a>
                    </div>
                    <?php
                }
                function small_card( $data ) {?>
                    <div class="col-lg-4 col-md-4 col-sm-6 card-container"><a href="<?= get_permalink() ?>" class="city-card">
                            <div class="city-card__photo"><img src="<?php echo get_the_post_thumbnail_url( $data->post_ID, '380x425' ); ?>"></div>
                            <div class="city-card__text">
                                <p class="date"><?= date("m / d / Y", strtotime($data->post_date)) ?></p>
                                <h5><?= $data->post_title ?></h5>
                                <p><?php
                                    if( empty($data->post_excerpt) ) {
                                        $t = get_field('content', $data->post_ID)[0]['text'];
                                        kama_excerpt("maxchar=200&text=$t");
                                    }else{
                                        kama_excerpt("maxchar=200");
                                    }
                                    ?></p>
                                <?php
                                $views = get_field('views', $data->post_ID);
                                if( $views > 0 ) {?>
                                    <div class="views">
                                        <svg><use xlink:href="<?= get_template_directory_uri() ?>/img/sprite-inline.svg#eye"></use></svg>
                                        <span><?= $views ?></span>
                                    </div>
                                <?php } ?>
                            </div></a>
                    </div>
                    <?php
                }
                function simple_card( $data ) {?>
                    <div class="col-lg-4 col-md-4 col-sm-6 card-container"><a href="<?= get_permalink() ?>" class="city-card city-card_simple">
                            <div class="city-card__text">
                                <p class="date"><?= date("m / d / Y", strtotime($data->post_date)) ?></p>
                                <h5><?= $data->post_title ?></h5>
                                <p><?php
                                    if( empty($data->post_excerpt) ) {
                                        $t = get_field('content', $data->post_ID)[0]['text'];
                                        kama_excerpt("maxchar=200&text=$t");
                                    }else{
                                        kama_excerpt("maxchar=200");
                                    }
                                    ?></p>
                                <?php
                                $views = get_field('views', $data->post_ID);
                                if( get_field('views', $data->post_ID) > 0 ) {?>
                                    <div class="views">
                                        <svg><use xlink:href="<?= get_template_directory_uri() ?>/img/sprite-inline.svg#eye"></use></svg>
                                        <span><?= $views ?></span>
                                    </div>
                                <?php } ?>
                            </div></a>
                    </div>
                    <?php
                }

                $count_post = 0;
                $count_in_line = 7;

                while ( have_posts() ) {
                    the_post();
                    $position = $count_post - floor( $count_post / $count_in_line ) * $count_in_line;

                    if( in_array($position, [0, 6]) ) big_card($post);

                    //if( in_array($position, [2]) ) simple_card($post);
                    if( in_array($position, [2]) ) small_card($post);

                    if( in_array($position, [1,3,4,5]) ) small_card($post);

                    $count_post++;
                }
                ?>
            </div>
        </div>
    </section>


    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12"><?php kama_pagenavi(); ?></div>
            </div>
        </div>
    </section>
</article>

<?php include_once( get_stylesheet_directory() . '/footer.php' ); ?>

