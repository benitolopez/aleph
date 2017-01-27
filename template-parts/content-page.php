<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Aleph
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page__header">
		<?php the_title( '<h1 class="entry-title page__title">', '</h1>' ); ?>
	</header><!-- .page__header -->

	<div class="entry-content page__content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links"><span class="page-links__label">' . esc_html__( 'Pages:', 'aleph' ) . '</span>',
				'after'  => '</div>',
			) );
		?>
	</div><!-- .page__content -->
</article><!-- #post-## -->
