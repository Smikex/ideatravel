<div class="col-lg-4 col-md-4 col-sm-6 card-container">
    <div class="tickets-card">
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
      <a href="<?= get_permalink() ?>">
            <div class="tickets-card__photo"><img src="<?php echo get_the_post_thumbnail_url( $post->ID, '380x217' ); ?>"></div>
            <div class="tickets-card__text">
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
        <div class="tickets-card__buy"><span><?php
                $terms = get_the_terms( $post->ID, 'ticket_tag' );
                if( !empty($terms) ) {
                    foreach ($terms as $k => $term ) {
                        if( $k !=0 ) {
                            echo ', ';
                        }
                        echo $term->name;
                    }
                }
                ?></span>&nbsp<a href="<?= get_permalink() ?>" data-id="<?= $post->ID ?>" class="buy-now"><?php _e('Buy ticket','theme-text-idea') ?></a></div>
        <div class="tickets-card__date"><span class="day"><?= date("d", strtotime($post->post_date)) ?></span><span class="month"><?= date("F", strtotime($post->post_date)) ?></span></div>
    </div>
</div>