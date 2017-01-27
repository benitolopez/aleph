<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Aleph
 */

get_header(); ?>

	<main id="main" <?php aleph_site_main_classes(); ?>>

		<section class="page__error-404">
			<header class="page__header">
				<h1 class="page__title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'aleph' ); ?></h1>
			</header><!-- .page__header -->

			<div class="page__content page__content--error-404">
				<p class="no-results no-results--error-404"><?php esc_html_e( 'It looks like nothing was found at this location. Perhaps searching can help.', 'aleph' ); ?></p>

				<?php get_search_form(); ?>

			</div><!-- .page__content -->
		</section><!-- .page__error-404 -->

	</main><!-- #main -->

<?php
get_footer();
