<?php
/**
 * Страница 404 ошибки
 * @package WordPress
 * @subpackage your-clean-template
 */
get_header(); // Подключаем header.php ?>
<section>
	<h1>404!</h1>
	<p>Страница не найдена</p>
</section>
<?php get_sidebar(); // подключаем sidebar.php ?>
<?php get_footer(); // подключаем footer.php ?>