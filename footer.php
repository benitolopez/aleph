<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aleph
 */

?>

		</div><!-- #content -->

		<footer id="colophon" class="site-footer">
			<div class="site-footer__info">
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'aleph' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'aleph' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'aleph' ), 'Aleph', '<a href="http://lopezb.com/" rel="designer">Benito Lopez</a>' ); ?>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- .wrapper -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
