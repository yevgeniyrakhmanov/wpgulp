<?php
/**
 * Шаблон отдельной записи
 * @package WordPress
 * @subpackage your-clean-template
 */
get_header(); ?>
<section>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php ?>
		<h1><?php the_title(); ?></h1>
		<p class="card-text">
			<small class="text-muted">Автор: <?php the_author(); ?></small><br>
			<small class="text-muted">Опубликовано: <?php the_time('j F Y'); ?> в <?php the_time('G:i'); ?></small><br>
			<small class="text-muted">Категории: <?php the_category(',') ?></small><br>
			<small class="text-muted">Тэги: <?php the_tags(' '); ?></small>
		</p>
		<?php the_content(); ?>
	</article>
<?php endwhile; ?>
<?php previous_post_link('%link', 'Предыдущий пост: %title', TRUE); ?> 
<?php next_post_link('%link', 'Следующий пост: %title', TRUE); ?> 
<?php if (comments_open() || get_comments_number()) comments_template('', true); ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
