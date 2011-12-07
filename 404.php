<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

function twentyten_vicchi_strip_attachments($where) {
	$where .= ' AND post_type != "attachment"';
	return $where;
}

add_filter ('posts_where', 'twentyten_vicchi_strip_attachments');

get_header(); ?>

	<div id="container">
		<div id="content" role="main">

			<div id="post-0" class="post error404 not-found">
				<h1 class="entry-title"><?php _e( 'Welcome to Failure Street', 'twentyten' ); ?></h1>
				<div class="entry-content">
					<p><?php _e( 'This is where geolocation errors come to find themselves. It looks like we can\'t geolocate what you wanted. Maybe some more geocoding might help.', 'twentyten' ); ?></p>

					<p><a class="aligncenter" title="Failing Street" href="http://www.flickr.com/photos/cjdaniel/3312922051/">
						<img src="<?php echo get_stylesheet_directory_uri() . '/images/failing-street.jpg'?>" alt="Failing Street">
					</a></p>

					<p>All is not lost; there's always some options.</p>
					<?php 
						$s = preg_replace("/(.*)-(html|htm|php|asp|aspx)$/","$1",$wp_query->query_vars['name']);
						$posts = query_posts('post_type=any&name='.$s);
						$s = str_replace("-"," ",$s);
						if (count($posts) == 0) {
							$posts = query_posts('post_type=any&s='.$s);
						}
						if (count($posts) > 0) {
							echo "<ol><li>";
							echo "<p>Maybe you were trying to geolocate one of these pieces of bloggage?</p>";
							echo "<ul>";
							foreach ($posts as $post) {
								echo '<li><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></li>';
							}
							echo "</ul>";
							echo "</li>";
						} else {
							echo "<ol>";
						}
					?>
						<li>
							<strong>Try searching</strong> for the piece of bloggage:
							<form style="display:inline;" action="<?php bloginfo('siteurl');?>">
								<input type="text" value="<?php echo esc_attr($s); ?>" id="s" name="s"/> <input type="submit" value="Search"/>
							</form>
						</li>
						<li>
							<strong>If you typed in a URL...</strong> make sure the spelling, cApitALiZaTiOn, and punctuation are correct. Then try reloading the page.

						</li>
						<li>
							<strong>Give up, start all over again</strong> on the <a href="<?php bloginfo('siteurl');?>">homepage</a> (and please contact me to say what went wrong, so I can fix it).
						</li>
					</ol>
					<div class="credits">Failing Street photo credit: <a href="http://www.flickr.com/photos/cjdaniel/3312922051/">Chris Daniel</a> on Flickr.</div>
				</div><!-- .entry-content -->
			</div><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #container -->
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>