<?php
/**
 * Шаблон страницы с результатами поиска
 * @package WordPress
 * @subpackage your-clean-template
 */
get_header(); ?> 
<section class="align-items-start justify-content-around row">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="col-md-6 col-lg-4 mt-3">				
		<?php get_template_part('loop'); ?>
	</div>
<?php endwhile;
else: echo '<h2>Нет записей.</h2>'; endif; ?>
</section>
<section>
	<?php pagination(); ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>


