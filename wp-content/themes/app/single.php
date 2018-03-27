<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php ?>
		<h1><?php the_title(); ?></h1>
		<?php the_author(); ?>
		<?php the_time('j F Y'); ?> в <?php the_time('G:i'); ?>
		<?php the_category(',') ?>
		<?php the_tags(' '); ?>
		<?php the_content(); ?>
	</article>
<?php endwhile; ?>
<?php previous_post_link('%link', '<: %title', TRUE); ?> 
<?php next_post_link('%link', '>: %title', TRUE); ?> 
<?php if (comments_open() || get_comments_number()) comments_template('', true); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
