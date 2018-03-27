<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php typical_title();?></title>
	<meta name="keywords" content="<?php echo get_post_meta($post->ID, 'keywords', true); ?>">
	<meta name="description" content="<?php echo get_post_meta($post->ID, 'description', true); ?>">
	<meta property="og:title" content="<?php typical_title();?>">
	<meta property="og:description" content="<?php echo get_post_meta($post->ID, 'description', true); ?>">
	<meta property="og:type" content="article">
	<meta property="og:image" content="<?php the_post_thumbnail_url(); ?>">
	<meta property="og:url" content="<?php echo get_page_link();?>">
	<meta name="theme-color" content="#000">
	<link rel="icon" href="<?php echo get_template_directory_uri();?>/img/favicon/favicon.ico">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri();?>/img/favicon/apple-touch-icon-180x180.png">
	<link rel="alternate" type="application/rdf+xml" title="RDF mapping" href="<?php bloginfo('rdf_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="Comments RSS" href="<?php bloginfo('comments_rss2_url'); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
</head>
<body>
<?php echo get_home_url(); ?>
<?php bloginfo('name'); ?>
<?php wp_nav_menu( array('theme_location'=>'top_menu','container'=>'ul','menu_class'=>'menu','menu_id'=>'top_menu','echo'=>true,'fallback_cb'=>'wp_page_menu',)); ?>
<?php if ( ! is_user_logged_in() )
	echo '<a href="' . wp_login_url() . '"><span class="glyphicon glyphicon-log-in"></span></a>';
else
	echo '<a href="'. get_home_url() .'/wp-admin"><span class="glyphicon glyphicon-user"></span></a> <a class="nav-link" href="' . wp_logout_url($_SERVER['REQUEST_URI']) . '"><span class="glyphicon glyphicon-log-in"></span></a>';
?>
