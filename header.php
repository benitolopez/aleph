<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aleph
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<div class="wrapper">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'aleph' ); ?></a>

		<header id="masthead" class="site-header">
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) {
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title semantic"><?php bloginfo( 'name' ); ?></h1>
					<?php else : ?>
						<p class="site-title semantic"><?php bloginfo( 'name' ); ?></p>
					<?php
					endif;

					// Print custom logo
					aleph_custom_logo();
				} else {
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
					endif;
				}

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif; ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="site-navigation site-navigation--main">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Site navigation', 'aleph' ); ?></h2>
				<?php wp_nav_menu( array(
					'theme_location' => 'menu-primary',
					'menu_id' => 'primary-menu',
					'container' => false,
					'menu_class' => 'site-navigation__list'
				) ); ?>
			</nav><!-- #site-navigation -->
		</header><!-- #masthead -->

		<div id="content" class="site-content">
