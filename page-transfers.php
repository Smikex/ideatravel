<?php
/*Template Name: Transfers*/
include_once(get_stylesheet_directory() . '/header.php');
global $post;
?>

  <section class="main-section">
    <div class="background"><img src="<?php echo get_the_post_thumbnail_url($post->ID, '1920x510'); ?>"
                                 alt="<?= $post->post_title ?>"></div>
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

  <article class="page-content transfer">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2><?php _e('transfer selection', 'theme-text-idea') ?></h2>
        </div>
      </div>
      <div class="row">
        <form method="post" class="transfer-form" id="transfer-form">
          <fieldset class="col-lg-12">
            <span class="label transfer-form__name">
              <span class="field-title"><?php _e('Your name', 'theme-text-idea') ?></span>
                <input type="text" name="author">
            </span>
            <span class="label transfer-form__name">
              <span class="field-title"><?php _e('Phone number', 'theme-text-idea') ?></span>
                <input type="tel" name="phone">
            </span>
            <span class="label transfer-form__phone">
              <span class="field-title"><?php _e('E-mail address', 'theme-text-idea') ?></span>
                <input type="mail" name="mail">
            </span>
          </fieldset>

          <fieldset class="col-lg-12">
            <h5><?php _e('Departure', 'theme-text-idea') ?></h5>

            <span class="label transfer-form__date">
              <span class="field-title"><?php _e('Dates', 'theme-text-idea') ?></span>
                <div class="field-wrapper">
                  <input type="text" name="from[date]" id="departure-date" class="datepicker">
                </div>
            </span>

            <span class="label transfer-form__time">
              <span class="field-title"><?php _e('Time', 'theme-text-idea') ?></span>
                <input type="text" name="from[time]">
            </span>

            <span class="label transfer-form__type">
              <span class="field-title"><?php _e('Type', 'theme-text-idea') ?></span>
                <select class="type-select" name="from[type]">
                  <option value="<?php _e('Airport', 'theme-text-idea') ?>"><?php _e('Airport', 'theme-text-idea') ?></option>
                  <option value="<?php _e('Railway station', 'theme-text-idea') ?>"><?php _e('Railway station', 'theme-text-idea') ?></option>
                </select>
            </span>

            <span class="label transfer-form__place">
              <span class="field-title"><?php _e('From', 'theme-text-idea') ?></span>
                <input type="text" name="from[place]">
            </span>

            <span class="label transfer-form__address"><span
                      class="field-title"><?php _e('To', 'theme-text-idea') ?></span>
                <input type="text" name="from[address]">
            </span>

          </fieldset>


          <fieldset class="col-lg-12 dep-reversed">
            <h5><?php _e('Departure reversed', 'theme-text-idea') ?></h5>

            <span class="label transfer-form__date"><span
                      class="field-title"><?php _e('Dates', 'theme-text-idea') ?></span>
                <div class="field-wrapper">
                  <input type="text" name="to[date]" disabled id="departure-rev-date" class="datepicker">
                </div>
            </span>

            <span class="label transfer-form__time"><span
                      class="field-title"><?php _e('Time', 'theme-text-idea') ?></span>
                <input type="text" name="to[time]" disabled>
            </span>

            <span class="label transfer-form__address">
              <span class="field-title"><?php _e('To', 'theme-text-idea') ?></span>
                <input type="text" name="to[address]" disabled>
            </span>


            <span class="label transfer-form__place"><span
                      class="field-title"><?php _e('From', 'theme-text-idea') ?></span>
                <input disabled type="text" name="to[place]">
            </span>

            <span class="label transfer-form__type"><span
                      class="field-title"><?php _e('Type', 'theme-text-idea') ?></span>
                <select disabled name="to[type]" class="type-select">
                  <option value="<?php _e('Airport', 'theme-text-idea') ?>"><?php _e('Airport', 'theme-text-idea') ?></option>
                  <option value="<?php _e('Railway station', 'theme-text-idea') ?>"><?php _e('Railway station', 'theme-text-idea') ?></option>
                </select>
            </span>

          </fieldset>
          <div class="col-lg-12">
            <button class="way-button">
              <span><?php _e('Transfer back', 'theme-text-idea') ?></span><span><?php _e('Only one way', 'theme-text-idea') ?></span>
            </button>
          </div>
          <fieldset class="col-lg-10 col-md-10 car-types">
            <h6><?php _e('Select car', 'theme-text-idea') ?></h6>

            <?php
            foreach ($fields['cars'] as $i => $car): ?>
              <input type="radio" name="car" id="car-type-<?php echo $i ?>" value="<?php echo $car['name'] ?>">
              <label for="car-type-<?php echo $i ?>" class="transfer-form__car">
                <div class="content">
                  <svg class="checkmark">
                    <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#checkmark"></use>
                  </svg>
                  <svg class="car-icon">
                    <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#<?php echo $car['icon'] ?>"></use>
                  </svg>
                  <span><?php _e($car['name'], 'theme-text-idea') ?></span>
                </div>
                <div class="price"><?php echo $car['price'] ?></div>
              </label>
            <?php endforeach; ?>
          </fieldset>
          <fieldset class="col-lg-10 col-md-10 submit-container">
            <button type="submit"
                    class="transfer-form__submit"><?php _e('Order transfer', 'theme-text-idea') ?></button>
          </fieldset>
        </form>
      </div>
      <div class="row transfer-seo">
        <div class="col-lg-4 col-md-4 col-lg-push-7 col-md-push-7 col-lg-offset-1 col-md-offset-1">
          <picture>
            <source srcset="<?= $fields['img']['sizes']['700x465'] ?>" media="(max-width: 991px)">
            <img src="<?= $fields['img']['sizes']['300x406'] ?>" alt="">
          </picture>
        </div>
        <div class="col-lg-7 col-md-7 col-lg-pull-5 col-md-pull-5 wp_style table_container"><?= $fields['text'] ?></div>
      </div>
    </div>
  </article>

<?php include_once(get_stylesheet_directory() . '/footer.php'); ?>