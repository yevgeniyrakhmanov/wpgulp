<?php
/**
 * Запись в цикле
 * @package WordPress
 * @subpackage your-clean-template
 */ 
?>
<article class="card" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="bg-thumb" style="background-image:url(<?php echo get_the_post_thumbnail_url(); ?>)"></div>
	<div class="card-body">
		<h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="card-text text-justify"><?php the_excerpt();?></div>
		<p><a href="<?php the_permalink(); ?>" class="btn btn-primary">Подробнее</a></p>
	</div>
</article>

