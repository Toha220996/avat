<?php
/**
 * avat functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package avat
 */

if ( ! function_exists( 'avat_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function avat_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on avat, use a find and replace
		 * to change 'avat' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'avat', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'avat' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'avat_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'avat_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function avat_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'avat_content_width', 640 );
}
add_action( 'after_setup_theme', 'avat_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function avat_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'avat' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'avat' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'avat_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function avat_scripts_frontend() {
	wp_enqueue_style( 'avat-style', get_stylesheet_uri() );
	wp_enqueue_style( 'avat-main', get_template_directory_uri() . '/css/main.min.css');
	wp_enqueue_style( 'avat-grid', get_template_directory_uri() . '/css/bootstrap-grid.css');
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css');
	wp_enqueue_script( 'avat-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'avat-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'avat-vertical-accordion-sidebar', get_template_directory_uri() . '/js/vertical-accordion-sidebar.js', array(), '20151215', true);
    wp_enqueue_script( 'avat-main', get_template_directory_uri() . '/js/main.js', array(), '20151215', true);
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'my_scripts_method', 99 );
function my_scripts_method() {
	// отменяем зарегистрированный jQuery
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.3.1.min.js', false, null, true );
	wp_enqueue_script( 'jquery' );
}    

add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

function avat_scripts_backend(){
	wp_enqueue_style( 'avat-admin-css', get_template_directory_uri() . '/css/admin.min.css');
	wp_enqueue_style( 'login-style', get_template_directory_uri() . '/css/login-style.min.css');
}


add_action( 'wp_enqueue_scripts', 'avat_scripts_frontend' );
add_action('admin_head', 'avat_scripts_backend');
add_action( 'login_enqueue_scripts', 'avat_scripts_backend' );
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Other PHP files
 */

require_once get_template_directory() .'/lib/custom-post.php';
require_once get_template_directory() .'/lib/custom-taxonomy.php';

function __build_tax_uri( $terms ){
	if( is_wp_error($terms) || empty($terms) || ! ( is_object(reset($terms)) || is_object($terms) ) )
		return 'no_terms';
	$term = is_object(reset($terms)) ? reset($terms) : $terms;
	$path = array( $term->slug );
	while( $term->parent ){
		$term = get_term( $term->parent );
		$path[] = $term->slug;
	}

	return implode('/', array_reverse($path) );
}


add_action('init', function(){
	global $wp_rewrite;
	add_permastruct( 'portfolio', 'portfolio/%brand%/%model%/car_id=%portfolio_id%/', array(
		'walk_dirs' => true,
	));
	//add_permastruct( 'model', 'portfolio/%brand%/%model%/', array(
	//	'walk_dirs' => true,
	//));

	add_rewrite_rule( 'portfolio/([^&]+)/([^&]+)/car_id=([^&]+)/?', 'index.php?brand=$matches[1]&model=$matches[2]&p=$matches[3]&post_type=portfolio', 'top' );
	add_rewrite_rule( 'portfolio/([^&]+)/([^&]+)/?', 'index.php?brand=$matches[1]&model=$matches[2]', 'top' );
	add_rewrite_rule( 'portfolio/([^&]+)/?', 'index.php?brand=$matches[1]', 'top' );
}, 2);

add_action('init', function(){
	global $wp_rewrite;
	add_permastruct( 'type_work', 'portfolio/type-work/%type_work%/');
	add_rewrite_rule( 'portfolio/type-work/([^&]+)/?', 'index.php?type_work=$matches[1]', 'top' );
}, 1);



add_filter( 'query_vars', function( $vars ){
	$vars[] = 'brand';
	$vars[] = 'model';
	$vars[] = 'type_work';
	return $vars;
} );

add_filter('term_link', 'brand_tax_link_fix', 10, 3);
function brand_tax_link_fix( $link, $term, $taxonomy){
	if( ! in_array( $taxonomy, array('brand', 'model') ) ) return $link;

	$uri = $_SERVER['REQUEST_URI'];
	$tax_path = __build_tax_uri($term);

	if ( $taxonomy == 'brand') {
		$link = '/portfolio/' . $tax_path;
		return $link;
	}
	elseif ( $taxonomy == 'model') {
		$parent_brand = get_term_meta($term->term_id , 'brand' , 1);
		$link = '/portfolio/' . $parent_brand . '/' . $tax_path;
		return $link;
	}
}

add_filter('post_type_link', 'portfolio_permalink', 1, 2);
function portfolio_permalink( $permalink, $post ){
	$brand_path = __build_tax_uri( get_the_terms( $post, 'brand') );
	$model_path = __build_tax_uri( get_the_terms( $post, 'model') );
	return strtr( $permalink, array(
		'%brand%'			=> $brand_path,
		'%model%'			=> $model_path,
		'%portfolio_id%'	=> $post->ID,
	) );
}


add_action('customize_register', function($customizer) {
    $customizer->add_section('main_settings', array(
			'title' => 'Основные настройки сайта',
			'description' => 'Контактная информация на сайте',
			'priority' => 11,
		));
	$customizer->add_setting('adress', array('default' => 'Адрес'));
	$customizer->add_control('adress', array(
		'label'		=> 'Адрес',
		'section'	=> 'main_settings',
		'type'		=> 'text',
	));
	$customizer->add_setting('phone', array('default' => 'Номер телефона'));
	$customizer->add_control('phone', array(
		'label'		=> 'Номер телефона',
		'section'	=> 'main_settings',
		'type'		=> 'text',
	));
	$customizer->add_setting('work_time', array('default' => 'Время работы'));
	$customizer->add_control('work_time', array(
		'label'		=> 'Время работы',
		'section'	=> 'main_settings',
		'type'		=> 'text',
	));
	});

//add_filter( 'nav_menu_css_class', 'add_my_class_to_nav_menu', 10, 2 );
//function add_my_class_to_nav_menu( $classes, $item ){
//	$classes[] = 'col-12 col-md-2';
//	return $classes;
//}

class magomra_walker_nav_menu extends Walker_Nav_Menu {

	// add classes to ul sub-menus
	function start_lvl( &$output, $depth ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array(
			'sub-menu',
			( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
			( $display_depth >=2 ? 'sub-sub-menu' : '' ),
			'menu-depth-' . $display_depth
			);
		$class_names = implode( ' ', $classes );

		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	// add main/sub classes to li's and links
	 function start_el( &$output, $item, $depth, $args ) {
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent


		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
		// build html
		$output .= $indent . '<li id="nav-menu-item-'. get_post($item->object_id)->post_name . '" class="' . $class_names . '">';

		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}













?>
