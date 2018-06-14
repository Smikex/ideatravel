<?php include_once( get_stylesheet_directory() . '/header.php' ); ?>
<?php
if(isset($_GET['email']) && isset($_GET['orderId'])){
  wp_mail(
      $_GET['email'],
      __('Заказ на ' . site_url()),
      __('Вы оплатили услугу на ' . site_url() . '.<br> Ваш номер заказа ' . $_GET['orderId']),
      'Content-Type: text/html; charset=UTF-8'
  );
}
?>
  <style>
    html, body, .page-content { min-height: 100vh; }
    .page-content { padding: 120px 0 0 0; }
    #footer {
      position: absolute;
      bottom: 0;
      width: 100%;
    }
  </style>
  <section class="main-section">
    <div class="background">
      <img src="<?php echo get_the_post_thumbnail_url(817, '1920x510'); ?>" alt="<?= $post->post_title ?>"></div> <?= $header_html ?>
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
      <div class="text-block_2 wp_style">
        <?php the_content() ?>
      </div>
    </div>
  </article>

<?php include_once( get_stylesheet_directory() . '/footer.php' ); ?>
