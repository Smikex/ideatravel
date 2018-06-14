<div class="col-lg-4 col-md-4 col-sm-6 card-container"><a href="<?= get_permalink( $citys->ID ) ?>" class="tickets-card_big">
        <div class="city-card__photo"><img src="<?php echo get_the_post_thumbnail_url( $citys->ID, '380x425' ); ?>"></div>
        <div class="city-card__text">
            <p class="date"><?= date("m / d / Y", strtotime($citys->post_modified)) ?></p>
            <h5><?= $citys->post_title ?></h5>
            <p><?php
                if( empty($citys->post_excerpt) ) {
                    $t = get_field('content', $citys->ID)[0]['text'];
                }else{
                    $t = $citys->post_excerpt;
                }
                kama_excerpt("maxchar=120&text=$t");
                ?>
            </p>
            <?php
            $views = get_field('views', $citys->ID);
            if( $views > 0 ) {?>
                <div class="views">
                    <svg><use xlink:href="<?= get_template_directory_uri() ?>/img/sprite-inline.svg#eye"></use></svg>
                    <span><?= $views ?></span>
                </div>
            <?php } ?>
        </div></a>
</div>