<?php

/*
Theme Name: Twenty Ten - Vicchi
Theme URI: http://www.vicchi.org/codeage/twentyten-vicchi/
Description: Child theme for www.vicchi.org, extending the WordPress Twenty Ten theme
Author: Gary Gale
Author URI: http://www.garygale.com/
Template: twentyten
Version: 1.0.1
License: GNU General Public License
License URI: license.txt
Tags: purple, white, two-columns, fixed-width, custom-header, custom-background, threaded-comments, sticky-post, translation-ready, microformats, rtl-language-support, editor-style, custom-menu
*/

if (!function_exists ('twentyten_posted_on')) :
function twentyten_posted_on() {
	printf (__('<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date("jS F Y")
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if (!function_exists ('twentyten_setup')):
/**
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style ();

	// This theme uses post thumbnails
	add_theme_support ('post-thumbnails');

	// Add default posts and comments RSS feed links to head
	add_theme_support ('automatic-feed-links');

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain ('twentyten', TEMPLATEPATH . '/languages');

	$locale = get_locale ();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if (is_readable ($locale_file))
		require_once ($locale_file);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus (array (
		'primary' => __('Primary Navigation', 'twentyten'),
	));

	// This theme allows users to set a custom background
	add_theme_support ('custom-background', array ('default-color' => 'f1f1f1'));

	$custom_header_support = array(
		// The default image to use.
		// The %s is a placeholder for the theme template directory URI.
		'default-image' => '%s/images/headers/path.jpg',
		// The height and width of our custom header.
		'width' => apply_filters( 'twentyten_header_image_width', 940 ),
		'height' => apply_filters( 'twentyten_header_image_height', 198 ),
		// Support flexible heights.
		'flex-height' => true,
		// Don't support text inside the header image.
		'header-text' => false,
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'twentyten_admin_header_style',
	);
	
	add_theme_support( 'custom-header', $custom_header_support );
	
	if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', '' );
		define( 'NO_HEADER_TEXT', true );
		define( 'HEADER_IMAGE', $custom_header_support['default-image'] );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		add_custom_image_header( '', $custom_header_support['admin-head-callback'] );
		add_custom_background();
	}

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	// ... and thus ends the changeable header business.

	// Scan folder for available headers. %s is a placeholder for the theme template directory URI.

	if ($handle = opendir (STYLESHEETPATH . '/images/headers/')) {
		$headers = array ();
		
    	while (false !== ($file = readdir ($handle))) {
			$pos = strrpos ($file, '.');
			if ($pos !== false && $pos > 0) {
				$file_name = substr ($file, 0, $pos);
				if (strpos ($file_name, "-thumbnail") === false) {
					$file_ext = substr ($file, $pos+1);
					$file_ext_low = strtolower ($file_ext);
					if ($file_ext_low == "jpg" || $file_ext_low == "jpeg") {
						$headers[$file_name] = array (
							'url' => get_stylesheet_directory_uri () . '/images/headers/' . $file,
							'thumbnail_url' => get_stylesheet_directory_uri () . '/images/headers/' . $file_name . "-thumbnail." . $file_ext,
							'description' => __(str_replace ( "_", " ", $file_name), 'twentyten' )
						);
					}
				}
			}
    	}   
    	
     	closedir ($handle);
     	
     	register_default_headers ($headers);
	}
}
endif;

remove_action ('wp_head', 'wp_generator');
?>
