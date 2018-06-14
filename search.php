<?php
/**
 * Template Search Page
 */
include_once( get_stylesheet_directory() . '/header.php' );

?>

<section class="main-section">
    <div class="background"><img src="<?= $template_uri ?>/img/pages/results/results-bgd.jpg" alt=""></div>
    <?= $header_html ?>
    <div class="container main-section__content">
        <h1><?php _e('Travel with us','theme-text-idea') ?></h1>
        <p class="page-subtitle"><?php _e('In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede<br>Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.','theme-text-idea') ?></p>
    </div>
</section>
<section class="breadcrumbs-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12"><?php kama_breadcrumbs(); ?></div>
        </div>
    </div>
</section>

<?php
    if( isset($_GET['search']) ) {
        $filter = $_GET['search'];
    }
?>

<article class="page-content">
    <section class="result-cards">
        <div class="container" id="main">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                        include_once( get_stylesheet_directory() . '/search_form.php' );

                        global $wpdb;
                        global $wp_query;

                        $sql ="
                         SELECT *, pm.*, pm1.*
                           FROM $wpdb->posts p ";

                        if( isset($sitepress) ) {
                            $sql .=" LEFT JOIN idea_icl_translations AS ml ON ( p.ID = ml.element_id )";
                        }
                        $sql .="INNER JOIN $wpdb->postmeta AS pm ON ( p.ID = pm.post_id )
                           INNER JOIN $wpdb->postmeta AS pm1 ON ( p.ID = pm1.post_id ) 
                           
                           INNER JOIN $wpdb->term_relationships rel_0 ON p.ID = rel_0.object_id
                           INNER JOIN $wpdb->term_relationships rel_1 ON p.ID = rel_1.object_id
                           
                          WHERE post_status = 'publish' AND post_type = 'post'";

                        if( isset($sitepress) ) {
                            $sql .="AND ml.language_code = '".ICL_LANGUAGE_CODE."'";
                        }
                          

                        $term = [];

                        if ( !empty($filter['cat']) ) {
                            $term[] = $filter['cat'];
                        }
                        if ( !empty($filter['city']) ) {
                            $term[] = $filter['city'];
                        }

                        if ( !empty($term) ) {
                            if( count($term) < 2 ) {
                                $sql .= " AND rel_0.term_taxonomy_id IN (".$term[0].")";
                            } else {
                                $sql .= " AND(";
                                foreach ( $term as $k => $t ) {
                                    if( $k != 0 ) {
                                        $sql .=  ' AND ';
                                    }
                                    $sql .=  'rel_'.$k.'.term_taxonomy_id IN ('.$t.') ';
                                }
                                $sql .= ")";
                            }
                        }

                        if ( !empty($filter['date_start']) || !empty($filter['date_end']) ) {
                            $sql .= " AND ";
                            if( !empty($filter['date_start']) && !empty($filter['date_end']) ) {
                                $sql .= " ( ";
                            }
                            if( !empty($filter['date_start']) ) {
                                $date_0 = date( 'Ymd', strtotime( $filter['date_start'] ) );

                                $sql .= " ( pm.meta_key LIKE 'dates_%_start' AND CAST(pm.meta_value AS DATE) >= $date_0 ) ";
                            }

                            if( !empty($filter['date_start']) && !empty($filter['date_end']) ) {
                                $sql .= " AND ";
                            }

                            if( !empty($filter['date_end']) ) {
                                $date_1 = date( 'Ymd', strtotime( $filter['date_end'] ) );

                                $sql .= " ( pm1.meta_key LIKE 'dates_%_end' AND CAST(pm1.meta_value AS DATE) <= $date_1 )";
                            }


                            if( !empty($filter['date_start']) && !empty($filter['date_end']) ) {
                                $sql .= " AND ( REPLACE(pm.meta_key,'_start','') = REPLACE(pm1.meta_key,'_end','') ) ";
                                $sql .= ")";
                            }
                        }

                        $sql .= " GROUP BY p.ID ORDER BY p.post_date DESC";

                        $total_record = count($wpdb->get_results($sql, ARRAY_A));
                        $paged      = get_query_var('paged') ? get_query_var('paged') : 1;
                        $post_per_page  = get_option('posts_per_page');
                        $offset         = ($paged - 1)*$post_per_page;
                        $max_num_pages  = ceil($total_record/ $post_per_page);

                        $wp_query->found_posts = $total_record;
                        $wp_query->max_num_pages = $max_num_pages;


                        $sql .= " LIMIT ".$post_per_page." OFFSET ".$offset;

                        $db_query = $wpdb->get_results($sql, OBJECT);

                        if( $total_record > 0 ) {
                            echo '<h5 class="content-subtitle">'.__('Aenean imperdiet','theme-text-idea').'<br>'.$total_record.' '.__('themes were found for your request','theme-text-idea').'</h5>';
                        } else {
                            echo '<h5 class="content-subtitle">'.__('Not found','theme-text-idea').'</h5>';
                        }

                    ?>

                </div>
            </div>

            <div class="row products-list">
                <?php
                    if( !empty($db_query) ) {
                        foreach ($db_query as $post) {
                            setup_postdata($post);
                            include( get_stylesheet_directory() . '/thumbnail_tour.php' );
                        }
                    }
                ?>
                
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php kama_pagenavi($before = '', $after = '', $echo = true, $args = array(), $wp_query); ?>
                </div>
            </div>
        </div>
    </section>
</article>

<?php include_once( get_stylesheet_directory() . '/footer.php' ); ?>
