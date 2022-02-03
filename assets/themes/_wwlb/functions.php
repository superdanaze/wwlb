<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( genesis_get_theme_handle(), get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
// require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
// require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
// require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
// require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
// require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

// add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

// Registers the responsive menus.
//	DEREGISTER FOR CUSTOM MOBILE NAV
if ( function_exists( 'genesis_register_responsive_menus' ) ) {
	// genesis_register_responsive_menus( genesis_get_config( 'responsive-menus' ) );
}

// add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles() {

	$appearance = genesis_get_config( 'appearance' );

	wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- see https://core.trac.wordpress.org/ticket/49742
		genesis_get_theme_handle() . '-fonts',
		$appearance['fonts-url'],
		[],
		null
	);

	wp_enqueue_style( 'dashicons' );

	if ( genesis_is_amp() ) {
		wp_enqueue_style(
			genesis_get_theme_handle() . '-amp',
			get_stylesheet_directory_uri() . '/lib/amp/amp.css',
			[ genesis_get_theme_handle() ],
			genesis_get_theme_version()
		);
	}

}

add_filter( 'body_class', 'genesis_sample_body_classes' );
/**
 * Add additional classes to the body element.
 *
 * @since 3.4.1
 *
 * @param array $classes Classes array.
 * @return array $classes Updated class array.
 */
function genesis_sample_body_classes( $classes ) {

	if ( ! genesis_is_amp() ) {
		// Add 'no-js' class to the body class values.
		$classes[] = 'no-js';
	}
	return $classes;
}

add_action( 'genesis_before', 'genesis_sample_js_nojs_script', 1 );
/**
 * Echo the script that changes 'no-js' class to 'js'.
 *
 * @since 3.4.1
 */
function genesis_sample_js_nojs_script() {

	if ( genesis_is_amp() ) {
		return;
	}

	?>
	<script>
	//<![CDATA[
	(function(){
		var c = document.body.classList;
		c.remove( 'no-js' );
		c.add( 'js' );
	})();
	//]]>
	</script>
	<?php
}

// add_filter( 'wp_resource_hints', 'genesis_sample_resource_hints', 10, 2 );
/**
 * Add preconnect for Google Fonts.
 *
 * @since 3.4.1
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function genesis_sample_resource_hints( $urls, $relation_type ) {

	if ( wp_style_is( genesis_get_theme_handle() . '-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = [
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		];
	}

	return $urls;
}

add_action( 'after_setup_theme', 'genesis_sample_theme_support', 9 );
/**
 * Add desired theme supports.
 *
 * See config file at `config/theme-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_theme_support() {

	$theme_supports = genesis_get_config( 'theme-supports' );

	foreach ( $theme_supports as $feature => $args ) {
		add_theme_support( $feature, $args );
	}

}

add_action( 'after_setup_theme', 'genesis_sample_post_type_support', 9 );
/**
 * Add desired post type supports.
 *
 * See config file at `config/post-type-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_post_type_support() {

	$post_type_supports = genesis_get_config( 'post-type-supports' );

	foreach ( $post_type_supports as $post_type => $args ) {
		add_post_type_support( $post_type, $args );
	}

}

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );
add_image_size( 'genesis-singular-images', 702, 526, true );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

/** 
 * Remove Skip Links 
 */

remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );


/** 
 * Deregister Genesis Default JS
 */

 function rp_deregister_genesis_scripts() {
	//	sueprfish nav
	wp_deregister_script('superfish');
	//	default responsive nav
	wp_deregister_script('_rp-responsive-menu');
	//	wp embed
	wp_deregister_script('wp-embed');
 }

 add_action( 'wp_enqueue_scripts', 'rp_deregister_genesis_scripts', 40 );




/**
 * 
 * 	ethosLA modifications
 * 
 */

define('NEW_CLIENT','((CLIENT_DIR))');
define('E_TEMPLATE','page-templates/template');
define('E_TEMPLATES','page-templates/template-parts/template');
define('E_FLEX','page-templates/template-parts/flex');
define('E_PARTS', '/template-parts/template');
define('IMG_ROOT','/assets/stuff/');
define('IMG_USER_PATH','assets/themes/_((CLIENT_DIR))/images/');

//	mobile detect
require_once 'lib/Mobile_Detect.php';
$detect = new Mobile_Detect;


#-----------------------------------------------------------------#
# Load custom stylesheets 
#-----------------------------------------------------------------#

function ethosLA_enqueue_style() {
	wp_enqueue_style( NEW_CLIENT . "-generibus", get_stylesheet_directory_uri() . "/css/generibus-1.1.2.min.css", array(), null);
	wp_enqueue_style( NEW_CLIENT . "-main", get_stylesheet_directory_uri() . "/css/main.css", array(), null);
	wp_enqueue_style( NEW_CLIENT . "-style", get_stylesheet_directory_uri() . "/css/style.css", array(), null);
	wp_enqueue_style( NEW_CLIENT . "-responsive", get_stylesheet_directory_uri() . "/css/responsive.css", array(), null);
}
	
add_action( 'wp_enqueue_scripts', 'ethosLA_enqueue_style' );


#-----------------------------------------------------------------#
# Load custom login stylesheet + script 
#-----------------------------------------------------------------#

function ethosLA_enqueue_login_items() {
	wp_enqueue_style( NEW_CLIENT . '-login_style', get_stylesheet_directory_uri() . '/assets/css/login.css');
	wp_enqueue_script( NEW_CLIENT. '-login_script', get_stylesheet_directory_uri() . '/assets/js/login.js',array(),false,true);
}
	
//	add_action( 'login_enqueue_scripts', 'ethosLA_enqueue_login_items' );


#-----------------------------------------------------------------#
# Load ethosLA custom scripts 
#-----------------------------------------------------------------#

function ethosLA_enqueue_scripts() {
	wp_enqueue_script('font-awesome', get_stylesheet_directory_uri() . '/js/fontawesome-all.min.js',array(),null,true);
	wp_enqueue_script('((CLIENT_DIR))-ui', 'https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js',array(),null,true);
	wp_enqueue_script( NEW_CLIENT . "-script", get_stylesheet_directory_uri() . "/js/script.js",array(),null,true);
}

add_action( 'wp_enqueue_scripts', 'ethosLA_enqueue_scripts' );

	
#-----------------------------------------------------------------#
# Load custom admin stylesheet + script 
#-----------------------------------------------------------------#

function ethosLA_enqueue_admin_items() {
	wp_enqueue_style( NEW_CLIENT . '-admin_style', get_stylesheet_directory_uri() . '/assets/css/admin.css');
	// wp_enqueue_script( NEW_CLIENT. '-admin_script', get_stylesheet_directory_uri() . '/assets/js/admin.js',array(),false,true);
}
	
add_action( 'admin_enqueue_scripts', 'ethosLA_enqueue_admin_items' );



#-----------------------------------------------------------------#
#	FUNCTIONS
#-----------------------------------------------------------------#

class ELA_Funcs {

	public function __construct() {
		$this->allcss = array();
	}

	public static function test($thing) {
		?>
		<pre>
		<?php print_r( $thing ); ?>
		</pre>
		<?php
	}


	public static function imgsize( $arr, $size = false ) {
		global $detect;

		if (!$arr || $arr == null) return;

		switch ( true ) {
			//	desktop
			case !$detect->isMobile() :
				return !$size ? $arr['url'] : $arr['sizes']['large'];
			break;

			//	tablet
			case $detect->isTablet() :
				return !$size ? $arr['sizes']['1536x1536'] : $arr['sizes']['medium_large'];
			break;

			//	mobile
			case $detect->isMobile() && !$detect->isTablet() :
				return $arr['sizes']['medium_large'];
			break;
		}
	}


	public function aggregate_css($id, $css, $print = false) {
		if ( !$id ) return;

		if ( $css ) {
			if ( !array_key_exists( $id, $this->allcss ) ) $this->allcss[$id] = "";
			$this->allcss[$id] .= $css;
		}

		if ( $print ) {
			add_action( 'wp_head', function() use( $id ) {
				print self::minimizeCSS( sprintf('<style id="%s">%s</style>', $id, $this->allcss[$id] ) );
			});
		}
	}


	public static function minimizeCSS($css){
		$css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css);
		// negative look ahead
		$css = preg_replace('/\s{2,}/', ' ', $css);
		$css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
		$css = preg_replace('/;}/', '}', $css);
	
		return $css;
	}


	public static function rgba( $arr, $alpha = false ) {
		if ( $alpha ) {
			return sprintf( '%s,%s,%s,%s', $arr['red'], $arr['green'], $arr['blue'], $arr['alpha'] );
		} else {
			return sprintf( '%s,%s,%s', $arr['red'], $arr['green'], $arr['blue'] );
		}
	}

}



#-----------------------------------------------------------------#
#	MODS
#-----------------------------------------------------------------#

class ELA_Mods {

	public function __construct() {
		//	remove existing viewport settings
		remove_action( 'genesis_meta', 'genesis_responsive_viewport' );

		add_action( 'genesis_meta', array( $this, 'add_viewport' ), 2 );
		add_action( 'wp_head', array( $this, 'add_to_header' ), 2 );
		add_filter( 'body_class', array( $this, 'add_to_body_class' ) );
	}


	public function add_viewport() {
		$content = "width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no";
		$output = sprintf( '<meta name="viewport" content="%s">', $content ) . "\r\n";

		print $output;
	}


	public function add_to_header() {
		$output = '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\r\n";
		$output .= '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\r\n";
		// $output .= '<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">' . "\r\n";

		print $output;
	}


	public function add_to_body_class() {
		//	detect if is mobile
		global $detect;
		$classes[] = $detect->isMobile() ? "ismobile" : "nomobile";

		//	nav color
		// $classes[] = get_field('header_color_scheme');
		

		return $classes;
	}
	
}

$super_mods = new ELA_Mods;


#-----------------------------------------------------------------#
#	MISC 
#-----------------------------------------------------------------#

//	disable gutenberg editor
add_filter('use_block_editor_for_post', '__return_false', 10);

//	allow svg in uploads
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

//	increase media upload limit
function filter_site_upload_size_limit( $size ) {
	$size = 1024 * 6000;
	return $size;
}
// add_filter( 'upload_size_limit', 'filter_site_upload_size_limit', 20 );

//	convert #hex to rgb()
function hex2RGB($hexStr,$seperator = ',') {
	$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr);
	$rgbArray = array();
	$colorVal = hexdec($hexStr);
	$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
	$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
	$rgbArray['blue'] = 0xFF & $colorVal;
	
	return implode($seperator, $rgbArray);
}

//	make IDs
function makeID($id) {
	$data = trim( str_replace( " ", "_", strtolower($id) ) );
	$data = str_replace( "?", "", $data);
	$data = str_replace( "&", "", $data);
	return $data;
}


#-----------------------------------------------------------------#
#	CLEANUP
#-----------------------------------------------------------------#

class eLA_Cleanup {
    function __construct() {
        add_action( 'wp_default_scripts', array($this, 'remove_jquery_migrate') );
        add_action( 'pre_ping', array($this, 'disable_pingback') );
        add_action( 'init', array($this, 'stop_heartbeat'), 1 );
        add_action( 'wp_enqueue_scripts', array($this, 'sp_dequeue_dashicon') );
        add_filter( 'style_loader_src', array($this, 'remove_cssjs_ver'), 10, 2 );
        add_filter( 'script_loader_src', array($this, 'remove_cssjs_ver'), 10, 2 );
        $this->misc_items();
    }

    function remove_jquery_migrate( $scripts ) {
        if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
            $script = $scripts->registered['jquery'];
        
            if ( $script->deps ) { // Check whether the script has any dependencies
                $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
            }
        }
    }
    function disable_pingback( &$links ) {
        foreach ( $links as $l => $link ) {
            if ( 0 === strpos( $link, get_option( 'home' ) ) ) unset($links[$l]);
        }
    }
    function stop_heartbeat() {
        wp_deregister_script('heartbeat');
    }
    function sp_dequeue_dashicon() {
        if (current_user_can( 'update_core' )) return;
        wp_deregister_style('dashicons');
    }
    function remove_cssjs_ver( $src ) {
        if ( strpos( $src, '?ver=' ) ) $src = remove_query_arg( 'ver', $src );
        return $src;
    }
    function misc_items() {
        remove_action( 'wp_head', 'wp_generator' ) ;
        add_filter('xmlrpc_enabled', '__return_false');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_action( 'wp_head', 'rsd_link' ) ;
    }
}

$cleanup = new eLA_Cleanup;



#-----------------------------------------------------------------#
#	HEADER / NAVIGATION
#-----------------------------------------------------------------#

class ELA_Header_Nav {

	public function __construct() {
		add_filter( 'genesis_header', array( $this, 'add_mobile_nav_trigger' ), 10 );
		add_filter( 'genesis_header', array( $this, 'add_mobile_nav' ), 11 );
		add_filter( 'genesis_attr_nav-primary', array( $this, 'primary_nav' ) );
	}


	public function add_mobile_nav_trigger() {
		$spans = "";
		for ( $i = 0; $i < 3; $i++ ) {
			$spans .= sprintf( '<span class="nav-dash nav-dash-%s nopoint"></span>', $i + 1 );
		}

		genesis_markup(
			[
				'open'		=> '<div %s>',
				'context'	=> 'nav-trigger-wrap',
				'atts'		=> [ 'class' => "nav-trigger-wrap flex mike abs", 'data-action' => "nav-open" ],
				'content'	=> $spans,
				'close'		=> '</div>',
			]
		);
	}


	public function primary_nav() {
		$attributes['class'] = "nav-primary echo";

		return $attributes;
	}


	public function add_mobile_nav() {
		$rp_mobile_nav_inner = genesis_markup([
			'open'      => '<div %s>',
			'atts'      => [ 'class' => "mobile-menu-inner-wrap full__container full__height topleft flex horiz vert abs" ],
			'context'	=> 'rp-mobile-nav-inner',
			'content'	=> wp_nav_menu(array(
				'menu'			=> 'navigation',
				'menu_id'		=> "rp-mobile-navigation",
				'menu_class'	=> "menu full__height flex vert",
				'container'		=> false,
				'echo'			=> false
			)),
			'echo'      => false,
			'close'     => '</div>'
		]);
		
		genesis_markup(
			[
				'open'		=> '<div %s>',
				'context'	=> 'rp-mobile-nav-container',
				'atts'		=> [ 'class' => "mobile-menu-master-wrap full__container full__height topleft mike fixed" ],
				'content'	=> $rp_mobile_nav_inner,
				'close'		=> '</div>',
			]
		);
	}
}

$ela_header_nav = new ELA_Header_nav;



#-----------------------------------------------------------------#
#	ELEMENTS
#-----------------------------------------------------------------#


class ELA_Elements {
	
	public function __construct() {
		 // $this->key = $key;
	}

	public function vimeoVideo( $id, $cls = false, $poster = false ) {
		//	need to add poster code
		$v = '<iframe class="lazy loadImg full__container rel '. $cls .'" data-src="https://player.vimeo.com/video/'. $id .'?autoplay=0&loop=0&muted=0&byline=0&portrait=0&title=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

		return $v;
	}
	
}

?>