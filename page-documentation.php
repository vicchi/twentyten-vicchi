<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 * Template Name: Documentation
 */

function vicchi_page_links () {
	/**
	 * Note: needs the Ambrosite Next/Previous Page Link Plus plugin to be installed
	 * and active - http://www.ambrosite.com/plugins/next-previous-page-link-plus-for-wordpress
	 */
	
	if (function_exists ('previous_page_link_plus') && function_exists ('next_page_link_plus')) {
		$prev_format = '&larr;%link';
		$next_format = '%link&rarr;';
		$args = array ('format' => $prev_format, 'return' => 'output');
		$content = array ();
		$content[] = '<div id="page-links">';
		$content[] = '<span class="prev-page-link">';
		$content[] = previous_page_link_plus ($args);
		$content[] = '</span>';
		$content[] = '<br />';
		$args['format'] = $next_format;
		$content[] = '<span class="next-page-link">';
		$content[] = next_page_link_plus ($args);
		$content[] = '</span>';
		$content[] = '</div>';
		echo implode (PHP_EOL, $content);
	}
}

get_header(); ?>

		<div id="container">
			<div id="content" role="main">
				<?php
				vicchi_page_links ();
				get_template_part( 'loop', 'page' );
				vicchi_page_links ();
			?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php
get_sidebar();
get_footer();
?>
