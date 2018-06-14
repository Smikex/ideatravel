<div class="col-lg-4 col-md-4 col-sm-6 card-container">
    <div class="tour-card"><a href="<?= get_permalink() ?>">
            <div class="tour-card__photo"><img src="<?php echo get_the_post_thumbnail_url( $post->ID, '380x260' ); ?>"></div>
            <div class="tour-card__text">
                <h5><?= $post->post_title ?></h5>
                <p><?php
                    if( empty($post->post_excerpt) ) {
                        $t = get_field('content')[0]['text'];
                        kama_excerpt("maxchar=200&text=$t");
                    }else{
                        kama_excerpt("maxchar=200");
                    }
                    ?></p>
            </div></a>
        <?php if((int) get_field('price_curent') !== 0): ?>
          <div class="tour-card__buy">
                <a href="" data-id="<?= $post->ID ?>" class="buy-click_pro"><?php _e('Buy in 1 click','theme-text-idea') ?></a>
                &nbsp
                <?php if( (get_field('price_old') || get_field('price_curent')) && !get_field('bank_pay', 'option') ) { ?>
                <a href="" data-id="<?= $post->ID ?>" class="buy-tour buy-now_pro"><?php _e('Buy now','theme-text-idea') ?></a>
                <?php } ?>
          </div>
      <?php endif; ?>
        <?php if(get_field('price_old') || get_field('price_curent')) { ?>
	<div class="price">
            <span class="price__title">
				price <?php
                if( get_field('price_old') ) {
                    echo '<strike>'.number_format( get_field('price_old'), 0, ',', ' ').' ₽</strike>';
                } ?>
			</span>
                <?php if( get_field('price_curent') ) {
                    echo '<span class="price__value">'.number_format( get_field('price_curent'), 0, ',', ' ').' ₽</span>';
                } ?>
        </div>
	<?php } ?>

        <?php
        $cat = get_the_category();
        if( !empty($cat) && !is_category() ) {
            echo ' <div class="category"><span>'.$cat[0]->name.'</span></div>';
        }
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
    </div>
</div>
