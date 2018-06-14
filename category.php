<?php
include_once( get_stylesheet_directory() . '/header.php' );
$description    = category_description();
$getcat         = get_the_category();
$getcatid       = isset($getcat[0]) ? $getcat[0]->cat_ID : '';
?>



<section class="main-section">
    <div class="background"><img src="/wp-content/uploads/2017/05/tours-page-bgd.jpg" alt=""></div>
    <?= $header_html ?>
    <div class="container main-section__content">
        <h1><?= isset($getcat[0]) ? $getcat[0]->name : '' ?></h1>
        <p class="page-subtitle"><?= strip_tags ($description, '<br>'); ?></p>
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
    <section class="tours-cards">
        <div class="container">
            <div class="row products-list">
                <?php
                //---get one citys post
                global $wpdb;

                $sql = "SELECT p.ID, p.post_title, p.post_excerpt, p.post_modified
                              FROM $wpdb->posts AS p 
                             WHERE p.post_status = 'publish' 
                               AND p.post_type = 'citys'
                               ORDER BY RAND() LIMIT 1
                    ";

                $citys_query = $wpdb->get_results( $sql );
                //---------------------------

                $count_post = 0;

                while ( have_posts() ) {
                    the_post();
                    
                    include( get_stylesheet_directory() . '/thumbnail_tour.php' );

                    if( in_array($count_post, [4]) ) {
                        if( $count_post == 4 ) {
                            $citys = $citys_query[0];
                        }
                        include( get_stylesheet_directory() . '/thumbnail_city.php' );
                    }
                    $count_post++;
                }
                ?>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php kama_pagenavi(); ?>
                </div>
            </div>
        </div>
    </section>
</article>

<?php include_once( get_stylesheet_directory() . '/footer.php' ); ?>
