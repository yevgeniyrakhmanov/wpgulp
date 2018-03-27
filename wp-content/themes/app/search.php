<?php get_header(); ?> 
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?php the_permalink(); ?>">
		<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
		<?php the_title(); ?>
		<?php the_excerpt();?>
	</a>
</div>
<?php endwhile;
else: echo '<h2>Нет записей.</h2>'; endif; ?>
<?php pagination(); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>


