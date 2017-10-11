<?php
/**
 * Шаблон обычной страницы
 * @package WordPress
 * @subpackage your-clean-template
 */
get_header(); ?>
<section>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php ?>
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</article>
<?php endwhile; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>