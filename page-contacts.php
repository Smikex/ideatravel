<?php /*Template Name: Contacts*/
include_once(get_stylesheet_directory() . '/header.php');
global $post; ?>
    <section class="main-section">
        <div class="background"><img src="<?php echo get_the_post_thumbnail_url($post->ID, '1920x510'); ?>"
                                     alt="<?= $post->post_title ?>"></div> <?= $header_html ?>
        <div class="container main-section__content"><h1><?= $post->post_title ?></h1>
            <p class="page-subtitle"><?= $fields['header__text'] ?></p></div>
    </section>
    <section class="breadcrumbs-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12"><?php kama_breadcrumbs(); ?></div>
            </div>
        </div>
    </section>
    <article class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div id="contacts-map" data-lat-center="<?= $fields['map']['lat'] ?>"
                     data-lng-center="<?= $fields['map']['lng'] ?>" data-zoom="17"
                     data-marker="<?= $template_uri ?>/img/pages/location-mark.svg" class="contacts-map"></div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="contacts-container">
                    <div class="contact">
                        <div
                            class="contact__title"><?= get_field('phone_title', $homeID) ?></div> <?php $phones = explode(",", get_field('phone', $homeID));
                        foreach ($phones as $k => $phone) {
                            if ($k != 0) {
                                echo '<br>';
                            } ?>                <a href="tel:<?= preg_replace('/[^0-9+]/', '', $phone) ?>"
                                                   class="contact__phone"><?= $phone ?></a>            <?php } ?>
                    </div>
                    <div class="contact">
                        <div class="contact__title">Address</div>
                        <div
                            class="contact__address"><?= !empty($fields['address']) ? $fields['address'] : $fields['map']['address']; ?></div>
                    </div> <?php if ($fields['mail']) : ?>
                        <div class="contact">
                            <div class="contact__title">E-mail</div>
                            <a href="mailto:<?= $fields['mail'] ?>" class="contact__mail"><?= $fields['mail'] ?></a>
                        </div>            <?php endif; ?>          </div>
            </div>
        </div>
        <div style="margin-top: 15px; float: left; margin-right: 30px;" class="contact__address">LLC “Idea Travel”<br> ITIN 7842143757<br>
            KPP 784201001<br> ОGRN 1177847363858<br> ОKPO 20146208<br> ОКАTO 40298000000<br> ОКТМО 40912000000<br> ОКОGU
            4210014<br> <br> Legal address: 191167 St Petersburg, Atamanskaya str, 3/6,<br> building “SH”, office 2<br> <br>
            Bank details:<br> PAO “Sberbank”<br>
            Current acc: 40702810555000001912<br> Corr. Acc. 30101810500000000653<br> BIC 044030653
            <br><br>

            <a href="http://ideatravelrussia.com/terms-of-payment-and-return/">Terms of payment and return </a>
        </div>
        <div style="margin-top: 15px; float: left" class="contact__address">
            ООО "Идея Тревел"<br>
            ИНН 7842143757<br>
            КПП  784201001<br>
            ОГРН 1177847363858<br>
            ОКПО 20146208<br>
            ОКАТО 40298000000<br>
            ОКТМО 40912000000<br>
            ОКОГУ 4210014<br><br>
            Юридический адрес: 191167,г.Санкт-Петербург, ул.Атаманская, д. 3/6, литера Ш,<br> помещение 2<br><br>
            Банковские реквизиты:<br>
            Наименование банка ПАО Сбербанк<br>
            Расчетный счет № 40702810555000001912<br>
            Корреспондентский счет № 30101810500000000653<br>
            БИК 044030653<br>
            ФИО руководителя Захарова Полина Сергеевна<br>
            Действует на основании Устава<br><br>

            <a href="http://ideatravelrussia.com/terms-of-payment-and-return/">Условия оплаты и возврата </a>
        </div>
    </div>  </article><?php include_once(get_stylesheet_directory() . '/footer.php'); ?>