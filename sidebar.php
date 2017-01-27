<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aleph
 */

if ( ! is_active_sidebar( 'sidebar-main' ) ) {
	return;
}
?>

<aside id="secondary" <?php aleph_site_sidebar_classes(); ?>>
	<?php dynamic_sidebar( 'sidebar-main' ); ?>
</aside><!-- #secondary -->
