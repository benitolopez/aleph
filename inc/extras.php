<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * @package Aleph
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function aleph_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'aleph_body_classes' );

/**
 * Removes hentry class from the array of post classes.
 * And add `post__item` and `page__item` classes.
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function aleph_post_classes( $classes ) {
	if ( 'page' === get_post_type() ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
		$classes[] = 'page__item';
	}

	if ( 'post' === get_post_type() ) {
		$classes[] = 'post__item';
	}

	return $classes;
}
add_filter( 'post_class', 'aleph_post_classes' );

/**
 * Adds custom class to comment item.
 *
 * @param array $classes Classes for the comment element.
 * @return array
 */
function aleph_comment_classes( $classes ) {
	$classes[] = 'comment__item';

	return $classes;
}
add_filter( 'comment_class', 'aleph_comment_classes' );

/**
 * Adds custom class to comment author link.
 *
 * @param array $link The HTML-formatted comment author link.
 * @return string
 */
function aleph_comment_author_link( $link ) {
	$link = str_replace( "class='url'", "class='url comment__author-link'", $link );

	return $link;
}
add_filter( 'get_comment_author_link', 'aleph_comment_author_link' );

/**
 * Adds custom classes to the `site-main` div.
 *
 * @return string
 */
function aleph_site_main_classes() {
	echo 'class="' . join( ' ', aleph_get_site_main_classes()) . '"'; // WPCS: XSS ok, sanitization ok.
}

/**
 * Retrieves the classes for the `site-main` div as an array.
 *
 * @return array Array of classes.
 */
function aleph_get_site_main_classes() {
	$classes = array(
		'site-main',
		'site-main--' . get_theme_mod( 'site_layout', 'right-sidebar' )
	);

	// Filter for developers
	$classes = apply_filters( 'aleph_site_main_class', $classes );

	// Sanitize classes
	$classes = array_map( 'esc_attr', $classes );

	return array_unique( $classes );
}

/**
 * Adds custom classes to the `site-sidebar` div.
 *
 * @return string
 */
function aleph_site_sidebar_classes() {
	echo 'class="' . join( ' ', aleph_get_site_sidebar_classes()) . '"'; // WPCS: XSS ok, sanitization ok.
}

/**
 * Retrieves the classes for the `site-sidebar` div as an array.
 *
 * @return array Array of classes.
 */
function aleph_get_site_sidebar_classes() {
	$classes = array(
		'site-sidebar',
		'site-sidebar--' . get_theme_mod( 'site_layout', 'right-sidebar' )
	);

	// Filter for developers
	$classes = apply_filters( 'aleph_site_sidebar_class', $classes );

	// Sanitize classes
	$classes = array_map( 'esc_attr', $classes );

	return array_unique( $classes );
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function aleph_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'aleph_pingback_header' );

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function aleph_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'aleph_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'aleph_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so aleph_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so aleph_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in aleph_categorized_blog.
 */
function aleph_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'aleph_categories' );
}
add_action( 'edit_category', 'aleph_category_transient_flusher' );
add_action( 'save_post', 'aleph_category_transient_flusher' );

/**
 * Add custom BEM classes to each menu item of the primary menu
 */
function aleph_menu_item_classes( $classes, $item, $args, $depth ) {
	if ( $args->theme_location == 'menu-primary' ) {
		$classes[] = 'site-navigation__item';

		// Add custom class if it is a child item
		if ( $depth > 0 ) {
			$classes[] = 'site-navigation__item--child';
		// Different class for first-level items
		} elseif ( $depth == 0 ) {
			$classes[] = 'site-navigation__item--first-level';
		}

		// Add custom class if it has child items
		if ( in_array( 'menu-item-has-children', $classes ) ) {
			$classes[] = 'site-navigation__item--has-children';

			// Another class for first-level items
			if ( $depth > 0 ) {
				$classes[] = 'site-navigation__item--parent';
			}
		}
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'aleph_menu_item_classes', 10, 4 );

/**
 * Add custom BEM classes to each menu item link of the primary menu
 */
function aleph_menu_link_classes( $atts, $item, $args, $depth ) {
	if ( $args->theme_location == 'menu-primary' ) {
		$atts[ 'class' ] = 'site-navigation__link';
	}

	// Add custom class if it is a child item
	if ( $depth > 0 ) {
		$atts[ 'class' ] .= ' site-navigation__link--child';
	// Different class for first-level items
	} elseif ( $depth == 0 ) {
		$atts[ 'class' ] .= ' site-navigation__link--first-level';
	}

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'aleph_menu_link_classes', 10, 4 );

/**
 * Modify the read more link and add a custom class
 */
function aleph_read_more_link( $element, $text ) {
	return '<a class="button button--more" href="' . get_permalink() . '">' . esc_html( $text ) . '</a>';
}
add_filter( 'the_content_more_link', 'aleph_read_more_link', 10, 2 );

/**
 * Add custom BEM class to previous comments link
 */
function aleph_previous_comments_link_attributes() {
	$class = 'class="comment-navigation__link comment-navigation__link--prev"';

	return $class;
}
add_filter( 'previous_comments_link_attributes', 'aleph_previous_comments_link_attributes' );

/**
 * Add custom BEM class to next comments link
 */
function aleph_next_comments_link_attributes() {
	$class = 'class="comment-navigation__link comment-navigation__link--next"';

	return $class;
}
add_filter( 'next_comments_link_attributes', 'aleph_next_comments_link_attributes' );

