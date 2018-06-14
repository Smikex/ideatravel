<?php
include_once(get_stylesheet_directory() . '/header.php');
global $post;
?>

  <section class="main-section">
    <div class="background"><img src="<?php echo get_the_post_thumbnail_url($post->ID, '1920x510'); ?>" alt=""></div>
    <?= $header_html ?>
    <div class="container main-section__content">
      <h1><?= $post->post_title ?></h1>
      <p class="page-subtitle"><?= $post->post_excerpt ?></p>
    </div>
  </section>

  <section class="breadcrumbs-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12"><?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(); ?></div>
      </div>
    </div>
  </section>
  <article class="page-content">
    <div class="buy-label">
      <div class="content">
        <?php if((int) get_field('price_curent') !== 0): ?>
        <?php
        $arraey_icon = [
            'hot_price' => 'sticker-flame',
            'best_choice' => 'sticker-star',
            'top_choice' => 'sticker-badge',
            'sale' => 'sticker-percent'
        ];
        if ($fields['sticker']['value'] != 'none') {
          ?>
          <div class="tour-sticker">
            <svg>
              <use xmlns:xlink="http://www.w3.org/1999/xlink"
                   xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#<?= $arraey_icon[$fields['sticker']['value']] ?>"></use>
            </svg>
            <span><?= $fields['sticker']['label'] ?></span>
          </div>
          <?php
        }
        ?>
        <div class="tour-price">
        <span class="tour-price__title">
          <?php _e('price', 'theme-text-idea') ?>
          <?php if ($fields['price_old']) {
            echo '<strike>' . number_format($fields['price_old'], 0, ',', ' ') . ' ₽</strike>';
          } ?>
        </span>
          <?php if ($fields['price_curent']) {
            echo '<span class="tour-price__value">' . number_format($fields['price_curent'], 0, ',', ' ') . ' ₽</span>';
          } ?>
        </div>
        <?php if (!$fields['transfer']) { ?>
          <div class="buy-sticker">
            <p><?php _e('The shuttle service is not included in the tour', 'theme-text-idea') ?></p>
          </div>
        <?php } ?>
        <?php if ((get_field('price_old') || get_field('price_curent')) && !get_field('bank_pay', 'option')) { ?>
          <a href="" data-id="<?= $post->ID ?>" class="buy-now_pro"><?php _e('Buy now', 'theme-text-idea') ?></a><br>
        <?php } ?>
        <a href="" data-id="<?= $post->ID ?>" class="buy-ticket buy-click_pro"><?php _e('Buy in 1 click', 'theme-text-idea') ?></a>
      <?php endif; ?>
      </div>
    </div>
    <?php
    function template_right($data)
    { ?>
      <section class="event-block">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="text wp_style">
                <?php if (!empty($data['title'])) echo '<h2>' . $data['title'] . '</h2>' ?>
                <?= $data['text'] ?>
              </div>
            </div>
            <div class="col-lg-offset-1 col-lg-5 col-md-5 col-md-offset-1">
              <div class="photo">
                <picture>
                  <source srcset="<?= $data['image']['sizes']['580x600'] ?>" media="(max-width: 767px)">
                  <source srcset="<?= $data['image']['sizes']['700x465'] ?>" media="(max-width: 991px)">
                  <img src="<?= $data['image']['sizes']['480x512'] ?>" alt="<?= $data['image']['alt'] ?>">
                </picture>
                <?php if ($data['image_title']) echo '<h3>' . $data['image_title'] . '</h3>' ?>
                <?php
                if (isset($data['image_flag'])) {
                  echo '<div class="flag"><img src="' . $data['image_flag']['sizes']['212x127'] . '" alt="' . $data['image_flag']['alt'] . '"></div>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php
    }

    function template_left($data)
    { ?>
      <section class="event-block">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-md-4">
              <div class="photo">
                <picture>
                  <source srcset="<?= $data['image']['sizes']['580x600'] ?>" media="(max-width: 767px)">
                  <img src="<?= $data['image']['sizes']['300x406'] ?>" alt="<?= $data['image']['alt'] ?>">
                </picture>
                <?php if ($data['image_title']) echo '<h3>' . $data['image_title'] . '</h3>' ?>
                <?php
                if (isset($data['image_flag'])) {
                  echo '<div class="flag"><img src="' . $data['image_flag']['sizes']['212x127'] . '" alt="' . $data['image_flag']['alt'] . '"></div>';
                }
                ?>
              </div>
            </div>
            <div class="col-lg-offset-1 col-lg-7 col-md-7 col-md-offset-1">
              <div class="text wp_style">
                <?php if (!empty($data['title'])) echo '<h2>' . $data['title'] . '</h2>' ?>
                <?= $data['text'] ?>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php
    }

    foreach ($fields['content'] as $item) {
      if ($item['layout'] == 'right') {
        template_right($item);
      }
      if ($item['layout'] == 'left') {
        template_left($item);
      }
    }
    ?>

    <section class="tickets">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2><?php _e('Tickets', 'theme-text-idea') ?></h2>
          </div>
        </div>
        <div class="row tickets-slider-container">
          <div class="tickets-slider">
            <?php
            $args = array(
                'post_type' => 'tickets',
                'posts_per_page' => 6,
                'paged' => $paged,
                'post_status' => array('publish', 'future')
            );

            $query = new WP_Query($args);

            while ($query->have_posts()) {
              $query->the_post();

              include(get_stylesheet_directory() . '/thumbnail_ticket.php');

            }
            ?>
          </div>
          <div class="tickets-slider-arrow tickets-slider-arrow_prev">
            <svg>
              <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-left"></use>
            </svg>
          </div>
          <div class="tickets-slider-arrow tickets-slider-arrow_next">
            <svg>
              <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-right"></use>
            </svg>
          </div>
        </div>
      </div>
    </section>
  </article>


<?php include_once(get_stylesheet_directory() . '/footer.php'); ?>