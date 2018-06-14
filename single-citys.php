<?php
	include_once( get_stylesheet_directory() . '/header.php' );
	global $post;
?>

	<section class="main-section">
		<div class="background"><img src="<?php echo get_the_post_thumbnail_url( $post->ID, '1920x510' ); ?>" alt=""></div>
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

	<article class="page-content">
		<?php
			function template_right($data) {
				?>
				<section class="city-block">
					<div class="container">
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="text wp_style">
									<?php if(!empty($data['title'])) echo '<h2>'.$data['title'].'</h2>' ?>
									<?= $data['text'] ?>
								</div>
							</div>
							<div class="col-lg-offset-1 col-lg-5 col-md-5 col-md-offset-1">
								<div class="photo">
									<picture>
									<source srcset="<?= $data['image']['sizes']['700x340'] ?>"" media="(max-width: 991px)">
									<img src="<?= $data['image']['sizes']['480x512'] ?>" alt="<?= $data['image']['alt'] ?>">
									</picture>
									<?php if($data['image_title']) echo '<h3>'.$data['image_title'].'</h3>' ?>
									<?php
									if(  isset($data['image_flag']) ) {
										echo '<div class="flag">
											<img src="'.$data['image_flag']['sizes']['212x127'].'" alt="'.$data['image_flag']['alt'].'">
										</div>';
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php
			}

			function template_left($data) {
				?>
				<section class="city-block">
					<div class="container">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								<div class="photo">
									<picture>
										<source srcset="<?= $data['image']['sizes']['700x340'] ?>"" media="(max-width: 991px)">
										<img src="<?= $data['image']['sizes']['300x406'] ?>" alt="<?= $data['image']['alt'] ?>">
									</picture>
									<?php if($data['image_title']) echo '<h3>'.$data['image_title'].'</h3>' ?>
									<?php
									if(  isset($data['image_flag']) ) {
										echo '<div class="flag"><img src="'.$data['image_flag']['sizes']['212x127'].'" alt="'.$data['image_flag']['alt'].'"></div>';
									}
									?>
								</div>
							</div>
							<div class="col-lg-offset-1 col-lg-7 col-md-7 col-md-offset-1">
								<div class="text wp_style">
									<?php if(!empty($data['title'])) echo '<h2>'.$data['title'].'</h2>' ?>
									<?= $data['text'] ?>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php
			}

			foreach( $fields['content'] as $item){
				if( $item['layout'] == 'right' ) {
					template_right($item);
				}
				if( $item['layout'] == 'left' ) {
					template_left($item);
				}
			}
		?>
		<?php if( $fields['places_geo'] ) {
			$map_array = array_map(function($n){
				$new = $n['map'];
				unset($new['address']);

				$new['title'] = $n['title'];

				if( !$n['text'] ) {
					$new['description'] = $n['map']['address'];
				} else {
					$new['description'] = $n['text'];
				}

				return $new;
			}, $fields['places_geo']);

			$sum_lat = array_sum(array_column($map_array,'lat'));
			$sum_lng = array_sum(array_column($map_array,'lng'));
			$count_map = count($map_array);

			$center_lat = $sum_lat / $count_map;
			$center_lng = $sum_lng / $count_map;
			?>
			<script>var cityMarkers = <?= json_encode($map_array); ?>;</script>
			<section class="places">
			<div class="container">
				<div class="row">
					<?php
						if($fields['places_title']) {
							echo '<div class="col-lg-12"><h2>'.$fields['places_title'].'</h2></div>';
						}
					?>
					<div class="col-lg-12">
						<div id="city-map" data-lat-center="<?= $center_lat ?>" data-lng-center="<?= $center_lng ?>" data-zoom="14" data-marker="<?= $template_uri ?>/img/pages/marker.svg" class="city-map"></div>
					</div>
				</div>
			</div>
		</section>
		<?php } ?>
		<section class="tours">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<h2><?php _e('tour','theme-text-idea') ?></h2>
					</div>
				</div>
			</div>
			<div class="container tours-slider-container">
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
					?>
				</div>
				<div class="tours-slider-arrow tours-slider-arrow_prev">
					<svg><use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-left"></use></svg>
				</div>
				<div class="tours-slider-arrow tours-slider-arrow_next">
					<svg><use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#arrow-right"></use></svg>
				</div>
			</div>
		</section>
	</article>
<?php include_once( get_stylesheet_directory() . '/footer.php' ); ?>