<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Aleph
 */

get_header(); ?>

	<main id="main" <?php aleph_site_main_classes(); ?>>

	<?php
	if ( have_posts() ) : ?>

		<header class="page__header">
			<?php
				the_archive_title( '<h1 class="page__title">', '</h1>' );
				the_archive_description( '<div class="page__description">', '</div>' );
			?>
		</header><!-- .page__header -->

		<?php
		/* Start the Loop */
		while ( have_posts() ) : the_post();

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );

		endwhile;

		aleph_pagination();

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif; ?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
