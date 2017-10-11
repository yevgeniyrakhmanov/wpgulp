<?php
/**
 * Страница архивов записей
 * @package WordPress
 * @subpackage your-clean-template
 */
get_header(); ?> 
<section>
	<h1><?php
		if (is_day()) : printf('Daily Archives: %s', get_the_date());
		elseif (is_month()) : printf('Monthly Archives: %s', get_the_date('F Y'));
		elseif (is_year()) : printf('Yearly Archives: %s', get_the_date('Y'));
		else : 'Archives';
		endif; ?></h1>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php get_template_part('loop'); ?>
	<?php endwhile; 
	else: echo '<p>Нет записей.</p>'; endif; ?>	 
	<?php pagination(); ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>