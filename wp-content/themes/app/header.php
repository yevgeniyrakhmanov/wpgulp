<?php
/**
 * Шаблон шапки (header.php)
 * @package WordPress
 * @subpackage your-clean-template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php echo get_post_meta($post->ID, 'google-verification', true); ?>
	<title><?php typical_title();?></title>
	<meta name="keywords" content="<?php echo get_post_meta($post->ID, 'keywords', true); ?>">
	<meta name="description" content="<?php echo get_post_meta($post->ID, 'description', true); ?>">
	<meta property="og:title" content="<?php typical_title();?>">
	<meta property="og:description" content="<?php echo get_post_meta($post->ID, 'description', true); ?>">
	<meta property="og:type" content="article">
	<meta property="og:image" content="<?php the_post_thumbnail_url(); ?>">
	<meta property="og:url" content="<?php echo get_page_link();?>">
	<meta name="theme-color" content="#000">
	<meta name="msapplication-navbutton-color" content="#000">
	<meta name="apple-mobile-web-app-status-bar-style" content="#000">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri();?>/img/favicon/apple-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri();?>/img/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri();?>/img/favicon/apple-icon-114x114.png">
	<link rel="alternate" type="application/rdf+xml" title="RDF mapping" href="<?php bloginfo('rdf_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="Comments RSS" href="<?php bloginfo('comments_rss2_url'); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<style>html,body{margin:0;padding:0;width:100%;height:100%;}</style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="<?php echo get_home_url(); ?>"><?php bloginfo('name'); ?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<?php wp_nav_menu( array('theme_location'=>'top_menu','container'=>'ul','menu_class'=>'menu navbar-nav mr-auto','menu_id'=>'top_menu','echo'=>true,'fallback_cb'=>'wp_page_menu',)); ?>
				<ul class="navbar-nav align-self-end">
					<?php if ( ! is_user_logged_in() )
						echo '<li class="nav-item"><a class="nav-link" href="' . wp_login_url() . '"><span class="glyphicon glyphicon-log-in"></span> Войти</a></li>';
					else
						echo '<li class="nav-item"><a class="nav-link" href="'. get_home_url() .'/wp-admin"><span class="glyphicon glyphicon-user"></span> Личный кабинет</a></li><li class="nav-item"><a class="nav-link" href="' . wp_logout_url($_SERVER['REQUEST_URI']) . '"><span class="glyphicon glyphicon-log-in"></span> Выйти</a></li>';
					?>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">


