<?php 

  include_once( get_stylesheet_directory() . '/header.php' );



  $all_post_id= icl_object_id( 242, 'page', false, ICL_LANGUAGE_CODE );

?>

  <section class="main-section">

    <div class="background"><img src="<?php echo get_the_post_thumbnail_url( $post->ID, '1920x750' ); ?>" alt="<?= $post->post_title ?>"></div>

    <?= $header_html ?>

    <div class="container main-section__content">

      <div class="row">

        <div class="col-lg-12 col-md-12">

          <h1><?= $fields['header_title'] ?></h1>

          <p class="page-subtitle"><?= $fields['header_text'] ?></p>

          <?php include_once( get_stylesheet_directory() . '/search_form.php' ); ?>

        </div>

      </div>

    </div>

  </section>



  <section class="search-form-container visible-xs"><div class="container"></div></section>



  <section class="shares">

    <div class="container">

      <div class="row">

        <?php

          if( $fields['baest_tour'] ) {

            $last_key = count($fields['baest_tour']) - 1;



            foreach ( $fields['baest_tour'] as $key => $post) {

              setup_postdata( $post );



              if( $key == 0 ) {?>

                <div class="col-lg-4 col-md-4 col-sm-6">

                  <div class="tour-card tour-card_rounded">

                    <a href="<?= get_permalink() ?>">

                      <div class="tour-card__rounded-photo"><div><img src="<?php echo get_the_post_thumbnail_url( $post->ID, '364x364' ); ?>"></div></div>

                      <h3><?= $post->post_title ?></h3>

                      <div class="price">

                          <span class="price__title">

                              price <?php

                            if( get_field('price_old') ) {

                              echo '<strike>'.number_format( get_field('price_old'), 0, ',', ' ').' €</strike>';

                            } ?>

                          </span>

                        <?php if( get_field('price_curent') ) {

                          echo '<span class="price__value">'.number_format( get_field('price_curent'), 0, ',', ' ').' €</span>';

                        } ?>

                      </div>

                      <?php

                      $arraey_icon = [

                          'hot_price' => 'sticker-flame',

                          'best_choice' => 'sticker-star',

                          'top_choice' => 'sticker-badge',

                          'sale' => 'sticker-percent'

                      ];

                      $sticker = get_field('sticker');

                      if( !empty($sticker) && $sticker['value'] != 'none' ) {?>

                        <div class="sticker">

                          <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#<?= $arraey_icon[ $sticker['value'] ] ?>"></use></svg>

                          <span><?= $sticker['label'] ?></span>

                        </div>

                      <?php } ?>

                    </a>

                  </div>

                </div>

                <?php

              } elseif( $last_key == $key){ ?>

                <div class="visible-sm"><?php include( get_stylesheet_directory() . '/thumbnail_tour.php' ); ?></div>

              <?}else {

                include( get_stylesheet_directory() . '/thumbnail_tour.php' );

              }

            }



          }

          wp_reset_postdata();

        ?>

      </div>

    </div>

  </section>



  <section class="about-us">

    <div class="container">

      <div class="row">

        <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6">

          <h2><?= $fields['aboutus_title'] ?></h2>

          <div class="text-slider-container">

            <div class="text-slider">

              <?php

                foreach ($fields['aboutus_slider'] as $slide) {

                  echo '<div>'.$slide['text'].'</div>';

                }

              ?>

            </div>

            <div class="text-slider-arrow text-slider-arrow_prev">

              <svg>

                <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-left"></use>

              </svg>

            </div>

            <div class="text-slider-arrow text-slider-arrow_next">

              <svg>

                <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-right"></use>

              </svg>

            </div>

          </div>

        </div>

        <div class="col-lg-6 col-md-6 col-lg-pull-6 col-md-pull-6">

          <picture>

            <source srcset="<?= $fields['aboutus_img']['sizes']['700x340'] ?>" media="(max-width: 991px)"><img src="<?= $fields['aboutus_img']['sizes']['480x470'] ?>" alt="<?= $fields['aboutus_title'] ?>">

          </picture>

        </div>

      </div>

    </div>

    <?php if( $fields['about_slogan'] ) {?>

    <div class="description">

      <div class="container">

        <div class="row">

          <div class="col-lg-offset-1 col-lg-6 col-md-6 col-md-offset-1">

            <?php echo '<h4>'.$fields['about_slogan'].'</h4>'; ?>

          </div>

        </div>

        <svg class="description__icon description__icon_1">

          <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#cup"></use>

        </svg>

        <svg class="description__icon description__icon_2">

          <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#location"></use>

        </svg>

        <svg class="description__icon description__icon_3">

          <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#rocket"></use>

        </svg>

      </div>

    </div>

    <?php } ?>

  </section>





  <section class="offers">

    <div class="container">

      <div class="row">

        <div class="col-lg-12 col-md-12">

          <h2>tour offers</h2>

        </div>

      </div>

    </div>

    <div class="container">

      <div id="tours-slider" class="row tours-slider">

        <?php

          $args = array(

              'post_type' => 'post',

              'posts_per_page' => 6,

              'paged' => $paged

          );



          $query = new WP_Query( $args );



          while ( $query->have_posts() ) {

            $query->the_post();



            include( get_stylesheet_directory() . '/thumbnail_tour.php' );



          }



        wp_reset_postdata();

        ?>

      </div>

      <div class="tours-slider-arrow tours-slider-arrow_prev">

        <svg>

          <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-left"></use>

        </svg>

      </div>

      <div class="tours-slider-arrow tours-slider-arrow_next">

        <svg>

          <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-right"></use>

        </svg>

      </div>

      <div class="row link-container">

        <div class="col-lg-12 col-md-12"><a href="<?php echo get_permalink( $all_post_id ); ?>" class="tours-link"><?php _e('All tours','theme-text-idea') ?></a></div>

      </div>

    </div>

  </section>



  <section class="seo-section">

    <div class="container">

      <div class="row">

        <div class="col-lg-6 col-md-6">

          <h2><?= $fields['besttrip_title'] ?></h2>

          <div class="text-slider-container">

            <div class="text-slider">

              <?php

                foreach ($fields['besttrip_slider'] as $slide) {

                  echo '<div>'.$slide['text'].'</div>';

                }

              ?>

            </div>

            <div class="text-slider-arrow text-slider-arrow_prev">

              <svg>

                <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-left"></use>

              </svg>

            </div>

            <div class="text-slider-arrow text-slider-arrow_next">

              <svg>

                <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-right"></use>

              </svg>

            </div>

          </div>

        </div>

        <div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1">

          <picture>

            <source srcset="<?= $fields['besttrip_img']['sizes']['700x340'] ?>" media="(max-width: 991px)"><img src="<?= $fields['besttrip_img']['sizes']['480x470'] ?>" alt="<?= $fields['besttrip_title'] ?>">

          </picture>

        </div>

      </div>

    </div>

  </section>







<?php

    $args = [

        'post_id'=> get_the_ID()

    ];



    $query = new WP_Comment_Query;

    $comments = $query->query( $args );



    $comments_e = array_map(function($n){

      return [

          'author' => $n->comment_author,

          'content' => $n->comment_content

      ];

    }, $comments);





  if( count($comments_e) > 0 ) {

?>

    <section class="comments-section">

      <div class="container">

        <div class="col-lg-12 col-md-12">

          <h2><?php _e('comments','theme-text-idea') ?></h2>

          <h6><?php _e('Reviews and comments of our customers','theme-text-idea') ?></h6>

        </div>

        <div class="col-lg-offset-1 col-lg-10 col-md-10 col-md-offset-1">

          <div class="commets-slider-container">

            <div id="comments-slider" class="comments-slider">

              <?php foreach ($comments_e as $comment) {?>

              <div class="comment">

                <div class="comment__text"><?= $comment['content'] ?></div>

                <p class="comment__author"><?= $comment['author'] ?></p>

              </div>

              <?php } ?>

            </div>

          </div>

        </div>

        <div class="comments-slider-arrow comments-slider-arrow_prev">

          <svg>

            <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-left"></use>

          </svg>

        </div>

        <div class="comments-slider-arrow comments-slider-arrow_next">

          <svg>

            <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-right"></use>

          </svg>

        </div>

      </div>

    </section>

<?php }

wp_reset_postdata();

?>





<?php include_once( get_stylesheet_directory() . '/footer.php' ); ?>