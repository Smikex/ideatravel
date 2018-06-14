<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <a href="" class="company-logo"><svg><use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#company-logo-two"></use></svg></a>
            </div>
        </div>
        <div class="row info">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 left-side"><span class="copyright">Idea travel.com  2017 ©</span></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 right-side"><a href="https://polyarix.com/" target="_blank" class="dev-link">Made in Polyarix</a></div>
        </div>
    </div>
</footer>

<a href="#header" class="scroll-link">
    <svg>
        <use xlink:href="<?= $template_uri ?>/img/sprite-inline.svg#scroll-top"></use>
    </svg></a>
    <?php
        my_scripts('footer'); /* Опции темы -> Скрипты */
        include( get_stylesheet_directory() . '/popup.php' );
        wp_footer();
    ?>
</body>
</html>