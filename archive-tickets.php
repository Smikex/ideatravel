<?php
    include_once( get_stylesheet_directory() . '/header.php' );
?>
<section class="main-section">
    <div class="background"><img src="<?= $template_uri ?>/img/pages/cities/cities-bgd.jpg" alt=""></div>
    <?= $header_html ?>
    <div class="container main-section__content">
        <h1><?php post_type_archive_title() ?></h1>
        <p class="page-subtitle"><?php _e('Choose tickets for performances, theater, museums and for the most interesting and important events.','theme-text-idea') ?></p>
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
    <section class="tickets-cards">
        <div class="container">
            <div class="row  products-list">
                <?php
                    //---get one citys post
                    global $wpdb;

                    $sql = "SELECT p.ID, p.post_title, p.post_excerpt, p.post_modified
                              FROM $wpdb->posts AS p 
                             WHERE p.post_status = 'publish' 
                               AND p.post_type = 'citys'
                               ORDER BY RAND() LIMIT 2
                    ";

                    $citys_query = $wpdb->get_results( $sql );
                    //---------------------------

                    $count_post = 0;
		    //query_posts('post_status=future');
                    while ( have_posts() ) {
                        the_post();
                        include( get_stylesheet_directory() . '/thumbnail_ticket.php' );

                        if( in_array($count_post, [4,7]) ) {
                            if( $count_post == 4 ) {
                                $citys = $citys_query[0];
                            }
                            if( $count_post == 7 ) {
                                $citys = $citys_query[1];
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

