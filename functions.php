<?php
/**
 * SiteOrigin Unwind functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package siteorigin-unwind
 * @since siteorigin-unwind 0.1
 * @license GPL 2.0
 */

define( 'SITEORIGIN_THEME_VERSION', '1.7.0' );
define( 'SITEORIGIN_THEME_JS_PREFIX', '.min' );
define( 'SITEORIGIN_THEME_CSS_PREFIX', '.min' );

// Load theme specific files.
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/jetpack.php';
require get_template_directory() . '/inc/siteorigin-panels.php';
require get_template_directory() . '/inc/settings/settings.php';
require get_template_directory() . '/inc/settings.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/deprecated.php';

if ( ! function_exists( 'siteorigin_unwind_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function siteorigin_unwind_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on siteorigin_unwind, use a find and replace
	 * to change 'siteorigin-unwind' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'siteorigin-unwind', get_template_directory() . '/languages' );

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

	/*
	 * Enable support for the custom logo.
	 */
	add_theme_support( 'custom-logo' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'siteorigin-unwind' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'gallery',
		'image',
		'video',
	) );

	// Custom image sizes.
	add_image_size( 'siteorigin-unwind-263x174-crop', 263, 174, true );
	add_image_size( 'siteorigin-unwind-360x238-crop', 360, 238, true );
	add_image_size( 'siteorigin-unwind-500x500-crop', 500, 500, true );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'siteorigin_unwind_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	/*
	 * Enable support for Gutenberg Editor Styles.
	 * https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#editor-styles
	 */
	add_theme_support( 'editor-styles' );

	/*
	 * Allow shortcodes to be use in category descriptions.
	 * See https://developer.wordpress.org/reference/functions/term_description/
	 */
	add_filter( 'term_description', 'shortcode_unautop' );
	add_filter( 'term_description', 'do_shortcode' );

	if ( ! defined( 'SITEORIGIN_PANELS_VERSION' ) ) {
		// Only include panels lite if the panels plugin doesn't exist.
		include get_template_directory() . '/inc/panels-lite/panels-lite.php';
	}

	/**
	 * Support SiteOrigin Page Builder plugin.
	 */
	add_theme_support( 'siteorigin-panels', array(
		'home-page'  => true,
	) );

	/**
	 * Use the SiteOrigin archive theme settings.
	 */
	add_theme_support( 'siteorigin-template-settings' );

}
endif; // siteorigin_unwind_setup.
add_action( 'after_setup_theme', 'siteorigin_unwind_setup' );

/**
 * Add the theme's custom WooCommerce functions.
 */
if ( function_exists( 'is_woocommerce' ) ) {
	require get_template_directory() . '/woocommerce/functions.php';
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function siteorigin_unwind_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'siteorigin_unwind_content_width', 1140 );
}
add_action( 'after_setup_theme', 'siteorigin_unwind_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function siteorigin_unwind_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'siteorigin-unwind' ),
		'id'            => 'main-sidebar',
		'description'   => esc_html__( 'Visible on posts and pages that use the Default or Full Width, With Sidebar layout.', 'siteorigin-unwind' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title heading-strike">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'siteorigin-unwind' ),
		'id'            => 'footer-sidebar',
		'description'   => esc_html__( 'A column will be automatically assigned to each widget inserted', 'siteorigin-unwind' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title heading-strike">',
		'after_title'   => '</h2>',
	) );

	if ( function_exists( 'is_woocommerce' ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Shop', 'siteorigin-unwind' ),
			'id'            => 'shop-sidebar',
			'description'   => esc_html__( 'Displays on WooCommerce pages.', 'siteorigin-unwind' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title heading-strike">',
			'after_title'   => '</h2>',
		) );
	}

	register_sidebar( array(
		'name'          => esc_html__( 'Masthead', 'siteorigin-unwind' ),
		'id'            => 'masthead-sidebar',
		'description'   => esc_html__( 'Replaces the logo and description. Works with all header layouts except Menu inline with logo.', 'siteorigin-unwind' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title heading-strike">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'siteorigin_unwind_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function siteorigin_unwind_scripts() {
	// Theme stylesheet.
	wp_enqueue_style( 'siteorigin-unwind-style', get_template_directory_uri() . '/style' . SITEORIGIN_THEME_CSS_PREFIX . '.css', array(), SITEORIGIN_THEME_VERSION );

	// Flexslider.
	wp_register_style( 'siteorigin-unwind-flexslider', get_template_directory_uri() . '/css/flexslider.css' );
	wp_register_script( 'jquery-flexslider', get_template_directory_uri() . '/js/jquery.flexslider' . SITEORIGIN_THEME_JS_PREFIX . '.js', array( 'jquery' ), '2.6.3', true );

	if ( ( is_home() && siteorigin_setting( 'blog_featured_slider' ) && siteorigin_unwind_has_featured_posts() ) || ( is_single() && has_post_format( 'gallery' ) ) ) {
		wp_enqueue_style( 'siteorigin-unwind-flexslider' );
		wp_enqueue_script( 'jquery-flexslider' );
	}

	// FitVids.
	wp_register_script( 'jquery-fitvids', get_template_directory_uri() . '/js/jquery.fitvids' . SITEORIGIN_THEME_JS_PREFIX . '.js', array( 'jquery' ), '1.1', true );

	if ( ! ( function_exists( 'has_blocks' ) && has_blocks() ) ) {
		wp_enqueue_script( 'jquery-fitvids' );
	}

	// Jetpack Portfolio
	if ( post_type_exists( 'jetpack-portfolio' ) ) {
		wp_register_script( 'jquery-isotope', get_template_directory_uri() . '/js/isotope.pkgd' . SITEORIGIN_THEME_JS_PREFIX . '.js', array( 'jquery' ), '3.0.4', true );
	}

	// Theme JavaScript.
	wp_enqueue_script( 'siteorigin-unwind-script', get_template_directory_uri() . '/js/unwind' . SITEORIGIN_THEME_JS_PREFIX . '.js', array( 'jquery' ), SITEORIGIN_THEME_VERSION, true );

	// Skip link focus fix.
	wp_enqueue_script( 'siteorigin-unwind-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix' . SITEORIGIN_THEME_JS_PREFIX . '.js', array(), '20130115', true );

	// Comment reply.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'siteorigin_unwind_scripts' );

/**
 * Enqueue the Flexslider scripts and styles.
 */
function siteorigin_unwind_enqueue_flexslider() {
	wp_enqueue_style( 'siteorigin-unwind-flexslider' );
	wp_enqueue_script( 'jquery-flexslider' );
}

/**
 * Enqueue Block Editor styles.
 */
function siteorigin_unwind_block_editor_styles() {
	wp_enqueue_style( 'siteorigin-unwind-block-editor-styles', get_template_directory_uri() . '/style-editor.css', SITEORIGIN_THEME_VERSION );
}
add_action( 'enqueue_block_editor_assets', 'siteorigin_unwind_block_editor_styles' );

if ( ! function_exists( 'siteorigin_unwind_post_class_filter' ) ) :
/**
* Filter post classes as required.
* @link https://codex.wordpress.org/Function_Reference/post_class.
*/
function siteorigin_unwind_post_class_filter( $classes ) {
	$classes[] = 'post';

	// Resolves structured data issue in core. See https://core.trac.wordpress.org/ticket/28482.
	if ( is_page() ) {
		$class_key = array_search( 'hentry', $classes );

		if ( $class_key !== false) {
			unset( $classes[ $class_key ] );
		}
	}

	$classes = array_unique( $classes );
	return $classes;
}
endif;
add_filter( 'post_class', 'siteorigin_unwind_post_class_filter' );

if ( ! function_exists( 'siteorigin_unwind_premium_setup' ) ) :
/**
 * Add support for SiteOrigin Premium theme addons.
 */
function siteorigin_unwind_premium_setup() {

	// No Attribution addon.
	add_theme_support( 'siteorigin-premium-no-attribution', array(
		'filter'             => 'siteorigin_unwind_footer_credits',
		'enabled'            => ! siteorigin_setting( 'branding_attribution' ),
		'siteorigin_setting' => '!branding_attribution'
	) );

	// Ajax Comments addon.
	add_theme_support( 'siteorigin-premium-ajax-comments', array(
		'enabled'            => siteorigin_setting( 'blog_ajax_comments' ),
		'siteorigin_setting' => 'blog_ajax_comments'
	) );
}
endif;
add_action( 'after_setup_theme', 'siteorigin_unwind_premium_setup' );



/**
 * Customize @r
 */
 function add_my_files() {
  //スタイルシートの読み込み
	$handle = "my-style";
	$src = get_template_directory_uri() . "/css/custom.css";
	$deps = array();
	$ver = false;
	$media = 'all';

  wp_enqueue_style( $handle, $src, $deps, $ver, $media );

  //JavaScript の読み込み
  // wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
}
//アクションフック（wp_enqueue_scripts）への登録
add_action('wp_enqueue_scripts', 'add_my_files');

// Add js file
function add_my_script() {
  wp_enqueue_script(
    'bgswitcher-script',
    get_template_directory_uri() . '/js/jquery.bgswitcher.js',
		array(),
		'',
  );
  wp_enqueue_script(
    'custom-script',
    get_template_directory_uri() . '/js/custom.js',
		array(),
		'',
  );
}
add_action( 'wp_enqueue_scripts', 'add_my_script' );


function pagenation($pages = '', $range = 3){
    $showitems = ($range * 1)+1;
    global $paged;
    if(empty($paged)) $paged = 1;
    if($pages == ''){
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages){
            $pages = 1;
        }
    }
    if(1 != $pages){
        // 画像を使う時用に、テーマのパスを取得
        $img_pass = get_template_directory_uri();
        echo "<div class='pagenation-wrapper'>";
        // ページ番号を出力
        echo "<ul class='pagenation-list'>";
        for ($i=1; $i <= $pages; $i++){
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
                echo ($paged == $i)? "<li class='current'>".$i."</li>": // 現在のページの数字はリンク無し
                    "<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
            }
        }
        echo "</ul>\n";
    }
}
/* add Global site tag (gtag.js, グローバル サイトタグ）for Google Analytics */
add_action('wp_head', 'add_google_analytics');
function add_google_analytics(){
	?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-HV2L471YKX"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-HV2L471YKX');
	</script>
	<?php
};

/**
 *  Add custom Post type
 * "My work"
* ref: https://nanimonaikedo.jp/markup/1305/
 */
function myworks_custom_post_type(){
  // $labels = array(
  //   'name' => _x('My Works', 'post type general name'),
  //   'singular_name' => _x('My Works', 'post type singular name'),
  //   'add_new' => _x('Add New', 'news'),
  //   'parent_item_colon' => ''
  // );
  // $args = array(
  //   'labels' => $labels,
  //   'public' => true,
  //   'publicly_queryable' => true,
  //   'show_ui' => true,
  //   'query_var' => true,
  //   'rewrite'  => true,
  //   'capability_type' => 'post',
  //   'hierarchical' => false,
  //   'menu_position' => 4,
  //   'has_archive' => true,
  //   'rewrite' => array( 'slug' => 'projects'),
  //   'supports' => array('title','editor','thumbnail')
  // );
  // register_post_type('news',$args);

	$labels2 = array(
		'name' => _x('My Works', 'post type general name'),
		'singular_name' => _x('My Works', 'post type singular name'),
		'add_new' => _x('Add New', 'projects'),
		'parent_item_colon' => ''
	);
	$args2 = array(
		'labels' => $labels2,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite'  => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 4,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'projects'),
		'supports' => array('title','editor','thumbnail')
	);
	register_post_type('projects',$args2);

  $args = array(
    'label' => 'Role',
    'public' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'show_admin_column' => true,
    'hierarchical' => true,
    'query_var' => true
  );
  register_taxonomy('project_cat','projects',$args);

  $args = array(
    'label' => 'Technologies',
    'public' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'show_admin_column' => true,
    'show_ui' => true,
    'hierarchical' => false,
    'query_var' => true
  );
  register_taxonomy('project_tag','projects',$args);
}
add_action('init', 'myworks_custom_post_type');

/**
 *  Add custom Post type
 * "Sandbox"
* ref: https://nanimonaikedo.jp/markup/1305/
 */
function sandbox_custom_post_type(){

	$labels3 = array(
		'name' => _x('Sandbox', 'post type general name'),
		'singular_name' => _x('Sandbox', 'post type singular name'),
		'add_new' => _x('Add New', 'sandbox'),
		'parent_item_colon' => ''
	);
	$args3 = array(
		'labels' => $labels3,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite'  => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'menu_position' => 5,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'sandbox'),
		'supports' => array('title','editor','thumbnail', 'page-attributes')
	);
	register_post_type('sandbox',$args3);

  $args = array(
    'label' => 'Categories',
    'public' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'show_admin_column' => true,
    'hierarchical' => true,
    'query_var' => true
  );
  register_taxonomy('sandbox_cat','sandbox',$args);

  $args = array(
    'label' => 'Tags',
    'public' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'show_admin_column' => true,
    'show_ui' => true,
    'hierarchical' => false,
    'query_var' => true
  );
  register_taxonomy('sandbox_tag','sandbox',$args);
}
add_action('init', 'sandbox_custom_post_type');


// Change the title placeholder
function title_placeholder_change( $title ) {
    $screen = get_current_screen();
    if ( $screen->post_type == 'projects' ) {
        $title = 'Project Name';
    }
    return $title;
}
add_filter( 'enter_title_here', 'title_placeholder_change' );

// 全てのエラー出力をオフにする
// hide Warning
// error_reporting(0);



/**
 * カスタム投稿"My wWrks"の管理画面に投稿IDを出力する
 * (post_type=projects)
 * ref: https://nobu-portfolio.com/wordpress/add_filter_add_action/
*/
function manage_myworks_columns ($columns) {
    $columns = array(
				// th#id => 'display label'
        'cb' => '<input type="checkbox" />',
        'title' => 'Project Name',
				'taxonomy-project_cat' => 'Role',
				'taxonomy-project_tag' => 'Technologies',
				'post_id' => 'Post ID', // <- this one!
        'date' => 'Date',
    );
    return $columns;
}
function add_postid_row($column, $post_id) {
	if( $column == 'post_id' ) {
		echo $post_id;
	}
}
add_filter('manage_edit-projects_columns', 'manage_myworks_columns');
add_action( 'manage_posts_custom_column', 'add_postid_row', 10, 2 );


/**
 * OWL Corousel
 * CSS, JS 読み込み
 * ref: https://qumeru.com/magazine/494
 */
function add_files() {
	// JS
	wp_enqueue_script('owl-js', get_template_directory_uri() . '/js/owl.carousel.js',
		array( 'jquery' ), '20210811', true );

	if ('sandbox' == 	get_post_type()) {
		wp_enqueue_script('google-map-js', get_template_directory_uri() . '/js/google-map.js',
			array(), '20220208', true );
	}

	// CSS
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css',
	 	"", '20210811' );
	wp_enqueue_style( 'owl-theme', get_template_directory_uri() . '/css/owl.theme.default.css',
		"", '20210811' );
}
add_action('wp_enqueue_scripts', 'add_files');

/**
 * DashboardのメニューのIDを確認する
 */
// function remove_menus() {
// 	global $menu;
// 	// var_dump( $menu );
// }
// add_action( 'admin_menu', 'remove_menus');
/**
 * DashboardのサブメニューのIDを確認する
 */
// function remove_menus() {
// 	global $submenu;
// 	var_dump( $submenu );
// }
// add_action( 'admin_menu', 'remove_menus');


// function hogeFunc() {
// 	return get_bloginfo('name');
// }
// add_shortcode('hoge', 'hogeFunc');

function hogeFunc($atts) {
    extract(shortcode_atts(array(
        'num' => 0,
    ), $atts));

    return $num * 2;
}
add_shortcode('hoge', 'hogeFunc');

/**
* Add shop post type setting with custome post type
*/
function create_shop_post_type() {
    register_post_type(
    'shop',
        array(
            'label' => 'Shops',
            'labels' => array(
                'singular_name' => 'Shop',
                'menu_name' => 'Shops',
                'all_items' => 'All Shops',
                'add_new_item' => 'Add New',
                'add_new' => 'Add New',
                'new_item' => 'Add New',
                'edit_item' => 'Edit',
                'view_item' => 'Show',
                'not_found' => 'Canot find',
                'not_found_in_trash' => 'ゴミ箱にはありません。',
                'search_items' => 'ショップ検索',
                ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
            'rest_base' => 'shops',
            'query_var' => false,
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 5,
            'rewrite' => true,
            'supports' => array( 'title', 'editor', 'thumbnail'),
        )
    );
    register_taxonomy(
        'shop_category',
        'shop',
            array(
            'hierarchical' => true,
            'update_count_callback' => '_update_post_term_count',
            'label' => 'Categories',
            'singular_label' => 'Category',
            'public' => true,
            'show_ui' => true,
            'show_in_rest' => true
        )
    );
}
// アクションにcreate_shop_post_type関数をフック
add_action( 'init', 'create_shop_post_type' );
/**
* shop custom post type.
* add colum
* https://b-risk.jp/blog/2017/02/wp_admin_list_columns/
*/
function set_shop_columns($columns) { //管理画面の一覧に表示するタイトルを設置
    $columns = [
        'title' => 'Title',
				'taxonomy-shop_category' => 'Category',
				'date' => 'Date',
    ];
    return $columns;
}
function add_shop_column($column_name, $post_id) { //管理画面の一覧に内容を表示
    if (in_array($column_name, [
					'title',
					'start_date',
					'finish_date',
					'price','venue',
					'phone',
					'web',
					'email',
					'organiser'])) {
        $stitle = get_post_meta($post_id, $column_name, true);
    }
    if (isset($stitle) && $stitle) {
        echo esc_attr($stitle);
    } else {
        echo __('None');
    }
}
add_filter('manage_shop_posts_columns', 'set_shop_columns'); //set_shop_columnsを発動
add_action('manage_shop_posts_custom_column', 'add_shop_column', 10, 2); //add_snowholiday_columnを発動

/**
* Read a file called "admin-ajax.php" only when list page
* WordPressでAjaxを使うには"admin-ajax.php"が必要
*/
function add_my_ajaxurl() {
  // if ( is_page( 'shop-ajax-and-google-map-api' ) ) {
	if ('sandbox' == get_post_type()) {
    ?>
      <script>
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
      </script>
			<!-- Google Map API -->
			<!-- <script defer src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyAwiIOLEx1VGuwXCz6ARuqlPjUaIvXiQFY&callback=initMap"></script> -->
    <?php
  }
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );

/**
* get posts according to the specified category
* Ajaxを受け取るアクションを指定(google-map.js)
* ref: https://haniwaman.com/wordpress-ajax/
*/
function get_select_post() {
  // Items by category
  $terms = "all"; // category name
  $args = []; // parameter for get_posts()
  $info = []; // marker items on google map
	$taxonomy = 'shop_category';
  global $post;

  if (isset($_POST['cat']) && ($_POST['cat'] !== 'all')) {
    $terms = htmlspecialchars($_POST['cat']);
    $args = array(
    	 'posts_per_page' => -1,
    	 'post_type' => 'shop',
    	 'post_status' => 'publish',
       'tax_query' => array(
                    		array(
                    			'taxonomy' => $taxonomy,
                    			'field' => 'slug',
                    			'terms' => $terms
                    		)
    	 ),
    );
  } else {
    // get all items
    $args = array(
      'post_type' => 'shop',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      // 'paged' => $paged
    );
  }


  $posts_array = get_posts($args);
  $tmp = [];
  foreach ($posts_array as $post) {
    setup_postdata($post);
    array_push(
      $tmp,
      array(
				'name' => $post->post_title,
        'address' => get_field('address'),
        'phone' => get_field('phone'),
        'email' => get_field('email'),
        'website' => get_field('website'),
      )
    );
    wp_reset_postdata();
  }
  $info[$terms] = $tmp;
  $json = json_encode($info[$terms], JSON_UNESCAPED_UNICODE);
   echo $json;

   wp_die();
}
// for logged in user
add_action( 'wp_ajax_get_select_post', 'get_select_post' );
// for user who is not logged in
add_action( 'wp_ajax_nopriv_get_select_post', 'get_select_post' );
