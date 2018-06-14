<?php
    /*Template Name: About*/
    include_once( get_stylesheet_directory() . '/header.php' );
    global $post;
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
    <div class="container company-info">
      <?php
        foreach ( $fields['content'] as $block) {
          if($block['acf_fc_layout'] == 'image__left'){
            ?>
            <div class="row company-info__block">
              <div class="col-lg-5 col-md-5 col-sm-8">
                <picture>
                  <source srcset="<?= $block['img']['sizes']['580x600'] ?>" media="(max-width: 767px)">
                  <img src="<?= $block['img']['sizes']['480x512'] ?>" alt="<?= $block['img']['alt'] ?>">
                </picture>
              </div>
              <div class="col-lg-6 col-lg-offset-1 col-md-6 col-md-offset-1 col-sm-12">
                <div class="text-block wp_style"><?= $block['text'] ?></div>
              </div>
            </div>
            <?php
          }
          if($block['acf_fc_layout'] == 'big__img'){
            ?>
            <div class="row company-info__block">
              <div class="col-lg-12">
                <picture>
                  <source srcset="<?= $block['img']['sizes']['700x465'] ?>" media="(max-width: 767px)">
                  <img src="<?= $block['img']['sizes']['1180x715'] ?>" alt="<?= $block['img']['alt'] ?>">
                </picture>
              </div>
            </div>
            <?php
          }
          if($block['acf_fc_layout'] == 'image__right'){
            ?>
            <div class="row company-info__block">
              <div class="col-lg-6 col-md-6">
                <div class="text-block_2 wp_style"><?= $block['text'] ?>
                </div>
              </div>
              <div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-8 col-sm-offset-4">
                <div class="photo-container">
                  <picture>
                    <source srcset="<?= $block['img']['sizes']['580x600'] ?>" media="(max-width: 767px)">
                    <img src="<?= $block['img']['sizes']['480x512'] ?>" alt="<?= $block['img']['alt'] ?>">
                  </picture>
                </div>
              </div>
            </div>
            <?php
          }
          if($block['acf_fc_layout'] == 'text'){
            ?>
            <div class="row company-info__block">
              <div class="col-xs-12">
                <div class="text-block_2 wp_style"><?= $block['text'] ?>
              </div>
            </div>
            <?php
          }
        }
      ?>
    </div>
  </article>

<?php include_once( get_stylesheet_directory() . '/footer.php' ); ?>