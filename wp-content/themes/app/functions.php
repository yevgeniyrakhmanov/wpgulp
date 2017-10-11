<?php
/**
 * Функции шаблона (function.php)
 * @package WordPress
 * @subpackage your-clean-template
 */

// функция вывода тайтла
function typical_title() { 
	global $page, $paged;
	$site_name = get_bloginfo('name');
	$site_description = get_bloginfo('name');
	$page_name = wp_title('', true, 'right');
	if (is_single() && isset($site_name))
		unset($site_name);
	if (is_page() && isset($site_name))
		unset($site_name);
	if (is_home())
		unset($site_name);
	if (is_front_page())
		echo "$site_description";
	if ($paged >= 2 || $page >= 2)
		echo ' | '.sprintf(__( 'Страница %s'), max($paged, $page));
}

// Регистрируем меню
register_nav_menus(array( // Регистрируем меню
	'top_menu' => 'Верхнее', // Верхнее
	'bottom_left_menu' => 'Нижнее левое', // Внизу слева
	'bottom_center_menu' => 'Нижнее центральное', // Внизу по центру
	'bottom_right_menu' => 'Нижнее правое' // Внизу справа
));

// Убираем лишние классы в меню
add_filter('nav_menu_css_class', 'my_css_attributes_filter');
add_filter('nav_menu_item_id', 'my_css_attributes_filter');
add_filter('page_css_class', 'my_css_attributes_filter');
function my_css_attributes_filter( $var ) {
$allow = array(
'current-menu-item'
);
return is_array( $var ) ? array_intersect( $var, $allow ):'';
}

// Добавляем классы бутстрап-4 тегам li
add_filter('nav_menu_css_class' , 'li_nav_class' , 10 , 2);
function li_nav_class ( $classes ){
	$classes[] = 'nav-item';
	return $classes;
}

// Добавляем классы бутстрап-4 тегам a
add_filter( 'nav_menu_link_attributes', 'nav_link_filter', 10, 4 );
function nav_link_filter( $atts, $item, $args, $depth ){
    $atts['class'] = 'nav-link';
    return $atts;
}

// Добавляем класс активному пункту меню active для бутстрап
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class ($classes, $item) {
	if (in_array('current-menu-item', $classes) ){
		$classes[] = 'active';
	} return $classes;
}

// включаем поддержку миниатюр
add_theme_support('post-thumbnails'); 
set_post_thumbnail_size(570, 395, true); // задаем размер миниатюрам 250x150
 //add_image_size('big-thumb', 400, 400, true); добавляем еще один размер картинкам 400x400 с обрезкой

// количество слов в анонсе статьи
function new_excerpt_length($length) {
	return 17;
}
add_filter('excerpt_length', 'new_excerpt_length');

// убираем [...] в конце анонса
add_filter('excerpt_more', function($more) {
	return '';
});

// комментарии
class clean_comments_constructor extends Walker_Comment {
	public function start_lvl( &$output, $depth = 0, $args = array()) {
		$output .= '<ul class="children list-unstyled ml-48 mt-3">' . "\n";
	}
	public function end_lvl( &$output, $depth = 0, $args = array()) {
		$output .= "</ul>\n";
	}
    protected function comment( $comment, $depth, $args ) {
    	$classes = implode(' ', get_comment_class()).($comment->comment_author_email == get_the_author_meta('email') ? ' author-comment' : '');
        echo '<li id="li-comment-'.get_comment_ID().'" class="'.$classes.'" itemprop="comment" itemscope="itemscope" itemtype="http://schema.org/UserComments">'."\n";
    	echo '
    	<div id="comment-'.get_comment_ID().'">
		<div class="d-flex align-self-start">
		<div class="mr-3">
    	'."\n";
    	echo get_avatar($comment, 32)."\n";
    	echo '</div><div><strong itemprop="creator">'.get_comment_author_link()."\n";
    	echo '</strong><br>';
    	echo ' 
		<small class="text-muted" itemprop="commentTime" content="'.get_comment_date('Y-m-d').'T'.get_comment_time('H:i:s').'">'.get_comment_date('d.m.Y').' в '.get_comment_time()."\n";
		echo '</small></div></div><div itemprop="commentText">';
    	if ( '0' == $comment->comment_approved ) echo 'Ваш комментарий будет опубликован после проверки модератором.'."\n";
        comment_text()."\n";
        echo '';
        $reply_link_args = array(
        	'depth' => $depth,
        	'reply_text' => 'Ответить',
			'login_text' => 'Чтобы ответить, вы должны быть залогинены'
        );
        echo get_comment_reply_link(array_merge($args, $reply_link_args));
        echo '</div></div>'."\n";
    }
    public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}

// Поменять местами поля в форме комментирования
function sort_comment_fields( $fields ){
	$new_fields = array();
	$myorder = array('author','email','comment');
	foreach( $myorder as $key ){
		$new_fields[ $key ] = $fields[ $key ];
		unset( $fields[ $key ] );
	}
	if( $fields )
		foreach( $fields as $key => $val )
			$new_fields[ $key ] = $val;
	return $new_fields;
}
add_filter('comment_form_fields', 'sort_comment_fields' );

// пагинация
function pagination() { // функция вывода пагинации
	global $wp_query; // текущая выборка должна быть глобальной
	$big = 999999999; // число для замены
	echo paginate_links(array( // вывод пагинации с опциями ниже
		'base' => str_replace($big,'%#%',esc_url(get_pagenum_link($big))), // что заменяем в формате ниже
		'format' => '?paged=%#%', // формат, %#% будет заменено
		'current' => max(1, get_query_var('paged')), // текущая страница, 1, если $_GET['page'] не определено
		'type' => 'list', // ссылки в ul
		'prev_text'    => 'Назад', // текст назад
    	'next_text'    => 'Вперед', // текст вперед
		'total' => $wp_query->max_num_pages, // общие кол-во страниц в пагинации
		'show_all'     => false, // не показывать ссылки на все страницы, иначе end_size и mid_size будут проигнорированны
		'end_size'     => 15, //  сколько страниц показать в начале и конце списка (12 ... 4 ... 89)
		'mid_size'     => 15, // сколько страниц показать вокруг текущей страницы (... 123 5 678 ...).
		'add_args'     => false, // массив GET параметров для добавления в ссылку страницы
		'add_fragment' => '',	// строка для добавления в конец ссылки на страницу
		'before_page_number' => '', // строка перед цифрой
		'after_page_number' => '' // строка после цифры
	));
}

// сайдбар
register_sidebar(array( // регистрируем левую колонку, этот кусок можно повторять для добавления новых областей для виджитов
	'name' => 'Сайдбар', // Название в админке
	'id' => "sidebar", // идентификатор для вызова в шаблонах
	'description' => 'Сайдбар', // Описалово в админке
	'before_widget' => '<div id="%1$s" class="widget %2$s">', // разметка до вывода каждого виджета
	'after_widget' => "</div>\n", // разметка после вывода каждого виджета
	'before_title' => '<span class="widgettitle">', //  разметка до вывода заголовка виджета
	'after_title' => "</span>\n", //  разметка после вывода заголовка виджета
));

// вывод системной статистики
function sys_stat() { 
    printf(('System statistic : %d queries / %s seconds'), get_num_queries(), timer_stop(0, 3));
    if ( function_exists('memory_get_usage') ) echo ' / ' . round(memory_get_usage()/1024/1024, 2) . ' mb';
}

?>
