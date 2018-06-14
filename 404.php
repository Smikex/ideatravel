<?php
include_once( get_stylesheet_directory() . '/header.php' );
?>
<div class="not-found">
	<div class="not-found__content">
		<div class="not-found__photo"><img src="<?= $template_uri ?>/img/pages/404.jpg" alt=""></div>
		<div class="not-found__info">
			<h1><?php _e('Sorry!','theme-text-idea') ?></h1>
			<h5><?php _e('The page you were looking for<br>could not be found','theme-text-idea') ?></h5>
			<a href="<?= home_url() ?>" class="return-link"><?php _e('To main','theme-text-idea') ?></a>
		</div>
	</div>
	<p class="not-found__copy">Idea travel.com  2016 ©</p>
</div>
</body>
</html>