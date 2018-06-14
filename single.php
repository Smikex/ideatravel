<?php

include_once( get_stylesheet_directory() . '/header.php' );

global $post;

the_post();



	if( isset($_GET['errorcode']) && isset($_GET['orderstatus']) ) {



		$erroa_rray = [

				0 => 'Обработка запроса прошла без системных ошибок.',

                2 => 'Заказ отклонен по причине ошибки в реквизитах платежа.',

                5 => 'Доступ запрещён; Пользователь должен сменить свой пароль; Номер заказа не указан.',

                6 => 'Неизвестный номер заказа.',

                7 => 'Системная ошибка.'

            ];



		$status_rray = [

				0 => 'Заказ зарегистрирован, но не оплачен.',

                1 => 'Предавторизованная сумма захолдирована (для двухстадийных платежей).',

                2 => _x('Full authorization of the order amount was done.','theme-text-idea'),

                3 => 'Авторизация отменена.',

                4 => 'По транзакции была проведена операция возврата.',

                5 => 'Инициирована авторизация через ACS банка-эмитента.',

                6 => 'Авторизация отклонена.'

            ];



		echo "<script>window.error_str = '" .$erroa_rray[ $_GET['errorcode'] ]. "'; window.status_str = '" . $status_rray[ $_GET['orderstatus'] ] . "';</script>";

	}

?>



<section class="main-section">

	<div class="background"><img src="<?php echo get_the_post_thumbnail_url( $post->ID, '1920x510' ); ?>" alt="<?= $post->post_title ?>"></div>

	<?= $header_html ?>

	<div class="container main-section__content">

		<h1><?= $post->post_title ?></h1>

		<p class="page-subtitle"><?= $post->post_excerpt ?></p>

	</div>

</section>

<section class="breadcrumbs-section">

	<div class="container">

		<div class="row">

			<div class="col-lg-12"><?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(); ?></div>

		</div>

	</div>

</section>

<?php if ( $fields['dates'] ){

	$new_arrey = array_map(function ($d) {

		return date('d.m.y', strtotime($d['start'])) . ' - ' . date('d.m.y', strtotime($d['end']));

	}, $fields['dates']);



	usort($new_arrey, function($a, $b){

		preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $a, $new_a);

		preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $b, $new_b);



		$a_date = DateTime::createFromFormat('d.m.y', $new_a[0]);

		$b_date = DateTime::createFromFormat('d.m.y', $new_b[0]);



		if($a_date == $b_date) {

			return 0;

		}

		return ($a_date < $b_date) ? -1 : 1;

	});



	$date_arrey = array_chunk($new_arrey, ceil( count($new_arrey) / 3));

?>

<section class="tour-dates">

	<div class="container">

		<div class="row">

			<div class="col-lg-5 col-md-5 col-sm-3">

				<div class="info">

					<div class="tour-dates__icon"><svg><use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#porthole"></use></svg></div>

					<h5><?php _e('Dates of departures in','theme-text-idea') ?> <?= date("Y"); ?>:</h5>

				</div>

			</div>

			<div class="col-lg-6 col-lg-offset-1 col-md-6 col-md-offset-1 col-sm-9">

				<div class="dates-list">

					<?php

						$curent_date = new DateTime('NOW');

						foreach ( $date_arrey as $dates ){

							echo '<div class="dates-list__col">';

								foreach ($dates as $date) {

									preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $date, $a);

									preg_match('/\d{1,2}.\d{1,2}.\d{2,4}$/', $date, $b);



									if( DateTime::createFromFormat('d.m.y', $a[0]) < $curent_date || DateTime::createFromFormat('d.m.y', $b[0]) < $curent_date ) {

										echo '<span style="opacity: 0.5">'.$date.'</span>';

									} else {

										echo '<span>'.$date.'</span>';

									}

								}

							echo '</div>'."\n";

						}

					?>

				</div>

				<div class="dates-switcher">

					<button><span><?php _e('More dates','theme-text-idea') ?></span><span><?php _e('hide','theme-text-idea') ?></span></button>

				</div>

			</div>

		</div>

	</div>

</section>

<?php } ?>



<article class="page-content">

  <section>

		<div class="container">

			<div class="row">



        
				<div class="stickers col-lg-3 col-lg-push-9 col-md-3 col-md-push-9 col-sm-4 col-sm-push-8">
          

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

							if( $fields['sticker']['value'] != 'none' ) {

								?>

								<div class="tour-sticker">

									<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#<?= $arraey_icon[ $fields['sticker']['value'] ] ?>"></use></svg>

									<span><?= $fields['sticker']['label'] ?></span>

								</div>

								<?php

							}

							?>

							<div class="tour-price">
                <a href="#tour-price-go-to" class="tour-price-go-to"></a>


								<span class="tour-price__title">

									<?php _e('price','theme-text-idea') ?>

									<?php if( $fields['price_old'] ) {

										echo '<strike>'.number_format( $fields['price_old'], 0, ',', ' ').' ₽ *</strike>';

									} ?>

								</span>

								<?php if( $fields['price_curent'] ) {

									echo '<span class="tour-price__value">'.number_format( $fields['price_curent'], 0, ',', ' ').' ₽ *</span>';

								} ?>



							</div>

							<?php if( !$fields['transfer'] ) {?>

							<div class="buy-sticker">

								<p><?php _e('The shuttle service is not included in the tour','theme-text-idea') ?></p>

							</div>

							<?php } ?>

							<?php if( (get_field('price_old') || get_field('price_curent')) && !get_field('bank_pay', 'option') ) { ?>

								<a href="" data-id="<?= $post->ID ?>" class="buy-now_pro"><?php _e('Buy now','theme-text-idea') ?></a><br>

							<?php } ?>

							<a href="" data-id="<?= $post->ID ?>" class="buy-tour buy-click_pro">
                <?php _e('Buy in 1 click','theme-text-idea') ?>
              </a>
              <?php endif; ?>
						</div>

					</div>

          
				</div>


				

				<div class="col-lg-9 col-lg-pull-3 col-md-9 col-md-pull-3 col-sm-8 col-sm-pull-4 tour-schedule">
					<h5><?php

						$terms = get_the_terms( $post->ID, 'post_tag' );

						if( !empty($terms) ) {

							foreach ($terms as $k => $term ) {

								if( $k !=0 ) {

									echo ' - ';

								}

								echo $term->name;

							}

						}

						?>

						<br>
						<?php if( !empty($fields['programm']) ) { ?>
							<?php $count_days = count($fields['programm']); ?>
							<?=  $count_days ?> <?php _e('Days','theme-text-idea') ?> – <?=  $count_days-1 ?> <?php _e('Nights','theme-text-idea') ?>
						<?php } ?> 
					</h5>


					<?php if( !empty($fields['programm']) ) { ?>
					<?php 
						foreach ( $fields['programm'] as $k => $item ) { ?>

							<div class="schedule-item">

								<div class="schedule-item__date">

									<div class="day-number"><?php _e('Day','theme-text-idea') ?> <?= $k+1 ?></div>

								</div>

								<div class="schedule-item__content wp_style"><?= $item['text'] ?></div>

							</div>

						<? } ?>
					<?php } ?> 



				</div>

				

				<?php if( empty($fields['programm']) ) { ?>

					<section class="tour-info">

						<div class="container">

							<div class="row">

								<div class="col-lg-8 col-sm-8 col-sm-pull-3 col-lg-pull-3 wp_style">

									<?php the_content()?>

								</div>

							</div>

						</div>

					</section>

				<?php } ?>

			</div>

		</div>

	</section>
  
  <?php if(get_field('prices')): ?>
    <section>
      <div class="container">
    
        <div class="row">

          <div class="col-lg-8 col-sm-8">

            <div id="tour-price-go-to" class="tour-prices">
              <?php the_field('prices'); ?>
            </div>

          </div>
          
        </div>
      </div>
    </section>
  <?php endif; ?>

	<?php if($fields['gallery']) {?>

		<section class="tour-gallery">

			<div class="container">

				<div class="row">

					<div class="col-lg-9">

						<div class="tour-slider-container">

							<div class="tour-slider">

								<?php foreach($fields['gallery'] as $img) {?>

									<div class="photo-container">

										<a href="<?= $img['sizes']['big']?>" data-fancybox-group="tour-photo" class="photo"><img src="<?= $img['sizes']['380x316']?>" alt="<?= $img['alt'] ?>">

											<svg>

												<use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#zoom"></use>

											</svg></a>

									</div>

								<? } ?>

							</div>

							<div class="tour-slider-arrow tour-slider-arrow_prev"><svg><use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-left"></use></svg></div>

							<div class="tour-slider-arrow tour-slider-arrow_next"><svg><use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-right"></use></svg></div>

						</div>

					</div>

				</div>

			</div>

		</section>

	<? } ?>

	<?php if( !empty($fields['programm']) ) { ?>

	<section class="tour-info">

		<div class="container">

			<div class="row">

				<div class="col-lg-8 col-sm-8 wp_style">

					<?php the_content()?>

				</div>

			</div>

		</div>

	</section>

	<? } ?>

</article>





<?php include_once( get_stylesheet_directory() . '/footer.php' ); ?>