<?php
/**
 * Template Name: All Tours
 */
include_once( get_stylesheet_directory() . '/header.php' );
global $post;
the_post();
?>

<section class="main-section">
    <div class="background"><img src="<?php echo get_the_post_thumbnail_url( $post->ID, '1920x510' ); ?>" alt="<?= $post->post_title ?>"></div>
    <?= $header_html ?>
    <div class="container main-section__content">
        <h1><?= $post->post_title ?></h1>
        <p class="page-subtitle"><?= $fields['header__text'] ?></p>
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
                    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 12,
                        'orderby'        => 'rand',
                        'paged' => $paged,
			    'suppress_filters' => true
                    );
    
                    $query = new WP_Query( $args );
    
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        include( get_stylesheet_directory() . '/thumbnail_tour.php' );
                    }
                ?>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php kama_pagenavi($before = '', $after = '', $echo = true, $args = array(), $wp_query = $query); ?>
                </div>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata(); ?>
</article>

<?php include_once( get_stylesheet_directory() . '/footer.php' ); ?>
