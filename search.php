<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Aleph
 */

get_header(); ?>

	<main id="main" <?php aleph_site_main_classes(); ?>>

	<?php
	if ( have_posts() ) : ?>

		<header class="page__header">
			<h1 class="page__title"><?php printf( esc_html__( 'Search Results for: %s', 'aleph' ), '<span class="page__title-search-query">' . get_search_query() . '</span>' ); ?></h1>
		</header><!-- .page__header -->

		<?php
		/* Start the Loop */
		while ( have_posts() ) : the_post();

			/**
			 * Run the loop for the search to output the results.
			 * If you want to overload this in a child theme then include a file
			 * called content-search.php and that will be used instead.
			 */
			get_template_part( 'template-parts/content', 'search' );

		endwhile;

		aleph_pagination();

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif; ?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
