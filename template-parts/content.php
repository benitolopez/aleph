<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Aleph
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="post__header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title post__title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title post__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="post__meta">
			<?php aleph_posted_on(); ?>
		</div><!-- .post__meta -->
		<?php
		endif; ?>
	</header><!-- .post__header -->

	<?php aleph_post_thumbnail(); ?>

	<div class="entry-content post__content">
		<?php
			the_content( esc_html__( 'Read more', 'aleph' ) );

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links__label">' . esc_html__( 'Pages:', 'aleph' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span class="page-links__item">',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .post__content -->

	<footer class="post__footer">
		<?php aleph_entry_footer(); ?>
	</footer><!-- .post__footer -->
</article><!-- #post-## -->
