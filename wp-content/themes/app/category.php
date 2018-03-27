<?php get_header(); ?> 
<h1><?php single_cat_title(); ?></h1>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?php the_permalink(); ?>">
		<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
		<?php the_title(); ?>
		<?php the_excerpt();?>
	</a>
</div>
<?php endwhile;
else: echo 'No singles.'; endif; ?>
<?php pagination(); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>