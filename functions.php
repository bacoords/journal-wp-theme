<?php
/**
 * journal-wp-theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package journal-wp-theme
 */

if ( ! function_exists( 'journal_wp_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function journal_wp_theme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on journal-wp-theme, use a find and replace
	 * to change 'journal-wp-theme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'journal-wp-theme', get_template_directory() . '/languages' );

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
		'primary' => esc_html__( 'Primary', 'journal-wp-theme' ),
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
	add_theme_support( 'custom-background', apply_filters( 'journal_wp_theme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'dark-editor-style' );
}
endif;
add_action( 'after_setup_theme', 'journal_wp_theme_setup' );


/**
 * Registers an editor stylesheet for the theme.
 */
function journal_wp_theme_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'journal_wp_theme_add_editor_styles' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function journal_wp_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'journal_wp_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'journal_wp_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function journal_wp_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'journal-wp-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'journal-wp-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'journal_wp_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function journal_wp_theme_scripts() {

  $the_theme = wp_get_theme();

	wp_enqueue_style( 'journal-wp-theme-style', get_stylesheet_uri(), array(), $the_theme->get( 'Version' ) );

	wp_enqueue_script( 'journal-wp-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), $the_theme->get( 'Version' ), true );

	wp_enqueue_script( 'journal-wp-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), $the_theme->get( 'Version' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'journal_wp_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


// Custom Stuff
function wpb_disable_feed() {
wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
}

add_action('do_feed', 'wpb_disable_feed', 1);
add_action('do_feed_rdf', 'wpb_disable_feed', 1);
add_action('do_feed_rss', 'wpb_disable_feed', 1);
add_action('do_feed_rss2', 'wpb_disable_feed', 1);
add_action('do_feed_atom', 'wpb_disable_feed', 1);
add_action('do_feed_rss2_comments', 'wpb_disable_feed', 1);
add_action('do_feed_atom_comments', 'wpb_disable_feed', 1);



function enqueue_category_color_classes(){

  $r = '<style type="text/css">';

  $cats = get_categories();

  foreach( $cats as $cat ){
    $r .= '.jwp-cat-bg--' . $cat->term_id . '{ background: '.  get_term_meta( $cat->term_id, 'color', true) .';}' . '.jwp-cat-color--' . $cat->term_id . '{ color: '.  get_term_meta( $cat->term_id, 'color', true) .';}';
  }

  $r .= '</style>';

  return $r;

}

function get_cat_class_bg(){



  $r = 'jwp-cat-bg--' . get_queried_object()->term_id;

  return $r;

}

function get_cat_class_color($term_id){

  $r = 'jwp-cat-color--' . $term_id;

  return $r;

}

// Block REST API from not-logged-in
// https://github.com/WP-API/WP-API/issues/1635
add_filter( 'rest_pre_dispatch', function() {
     if ( ! is_user_logged_in() ) {
        return new WP_Error( 'not-logged-in', 'API Requests are only supported for authenticated requests', array( 'status' => 401 ) );
    }
} );


//
//add_action( 'parse_request', 'journal_wp_theme_redirect_to_login_if_not_logged_in', 1 );
///**
// * Redirects a user to the login page if not logged in.
// *
// * @author Daan Kortenbach
// */
//function journal_wp_theme_redirect_to_login_if_not_logged_in() {
//	is_user_logged_in() || auth_redirect();
//}
//
//
//add_filter( 'login_url', 'journal_wp_theme_strip_loggedout', 1, 1 );
///**
// * Strips '?loggedout=true' from redirect url after login.
// *
// * @author Daan Kortenbach
// *
// * @param  string $login_url
// * @return string $login_url
// */
//function journal_wp_theme_strip_loggedout( $login_url ) {
//	return str_replace( '%3Floggedout%3Dtrue', '', $login_url );
//}
