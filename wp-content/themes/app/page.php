<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php ?>
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>
</article>
<?php endwhile; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>