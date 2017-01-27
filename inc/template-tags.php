<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Aleph
 */

if ( ! function_exists( 'aleph_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function aleph_posted_on() {
	$time_string = '<time class="post__time published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="post__time published" datetime="%1$s">%2$s</time><time class="post__time post__time--updated updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'aleph' ),
		'<a class="post__date-link" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'aleph' ),
		'<span class="post__author-name author vcard"><a class="post__author-link url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="post__date">' . $posted_on . '</span><span class="post__author"> ' . $byline . '</span>'; // WPCS: XSS OK.
}
endif;

if ( ! function_exists( 'aleph_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function aleph_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		$categories_list = '';
		$cats = get_the_category();
		if ( $cats && aleph_categorized_blog() ) : ?>
			<span class="post__categories">
				<span class="post__categories-label"><?php echo esc_html_x( 'Posted in', 'post_cats', 'aleph' ); ?></span>
				<?php
				foreach( $cats as $cat ) {
					$categories_list .= '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '" class="post__category-link" rel="category tag">' . esc_html( $cat->name ) . '</a>';
				}
				echo $categories_list; // WPCS: XSS OK.
			?>
			</span><!-- .post__categories -->
		<?php endif;

		$tags_list = '';
		$tags = get_the_tags();
		if ( $tags ) : ?>
			<span class="post__tags">
				<span class="post__tags-label"><?php echo esc_html_x( 'Tagged with', 'post_tags', 'aleph' ); ?></span>
				<?php
				foreach( $tags as $tag ) {
					$tags_list .= '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="post__tag-link" rel="tag">' . esc_html( $tag->name ) . '</a>';
				}
				echo $tags_list; // WPCS: XSS OK.
			?>
			</span><!-- .post__tags -->
		<?php endif;
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="post__comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'aleph' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'aleph_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function aleph_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post__thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post__thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
	</a>

	<?php endif; // End is_singular()
}
endif;

if ( ! function_exists( 'aleph_custom_logo' ) ) :
/**
 * Prints custom logo if available.
 *
 * The WordPress custom logo feature doesn't support retina displays.
 * So this function uses an "ugly" workaround, scaling down the logo.
 */
function aleph_custom_logo() {
	$logo_id = get_theme_mod( 'custom_logo' );
	$logo    = wp_get_attachment_image_src( $logo_id , 'full' );
	$width   = $logo[ 1 ] / 2;
	$height  = $logo[ 2 ] / 2;
	?>

	<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo[ 0 ] ); ?>" width="<?php echo intval( $width ); ?>" height="<?php echo intval( $height ); ?>" alt="<?php bloginfo('name'); ?>"></a>

	<?php
}
endif;

if ( ! function_exists( 'aleph_pagination' ) ) :
/**
 * Pagination.
 *
 * The WordPress `paginate_links()` function doesn't offer filters for
 * the markup. So the following function uses a `brutal` str_replace to
 * change the link classes and provide BEM support.
 *
 */
function aleph_pagination() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	?>

	<nav class="pagination">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Posts pagination', 'aleph' ); ?></h2>

		<?php
		$big = 999999999; // need an unlikely integer

		$pages = paginate_links( apply_filters( 'aleph_pagination_args', array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'add_args'  => '',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $wp_query->max_num_pages,
			'prev_text' => '&larr;',
			'next_text' => '&rarr;',
			'type'      => 'array',
			'end_size'  => 3,
			'mid_size'  => 3
		) ) );
		?>

		<ul class="pagination__list">
			<?php foreach ( $pages as $page ) :
				// Add BEM classes but maintain default WP classes for backward compatibility
				$page = str_replace( 'page-numbers', 'page-numbers pagination__link', $page );
				$page = str_replace( 'current', 'current pagination__link--current', $page );
				$page = str_replace( 'next', 'next pagination__link--next', $page );
				$page = str_replace( 'dots', 'dots pagination__link--dots', $page );
				?>
				<li class="pagination__item"><?php echo $page; // WPCS: XSS OK. ?></li>
			<?php endforeach; ?>
		</ul><!-- .pagination__list -->
	</nav><!-- .pagination -->
<?php
}
endif;

if ( ! function_exists( 'aleph_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function aleph_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$prevPost = get_previous_post( false );
    $nextPost = get_next_post( false );

	if ( ! $nextPost && ! $prevPost ) {
		return;
	}
	?>

	<nav class="post-navigation">
		<ul class="post-navigation__list">
			<?php if ( ! empty( $prevPost ) ): ?>
				<li class="post-navigation__item post-navigation__item--prev">
					<a class="post-navigation__link post-navigation__link--prev" href="<?php echo get_permalink( $prevPost->ID ); ?>" rel="prev"><?php echo esc_html( $prevPost->post_title ); ?></a>
				</li>
			<?php endif; ?>

			<?php if ( ! empty( $nextPost ) ): ?>
				<li class="post-navigation__item post-navigation__item--next">
					<a class="post-navigation__link post-navigation__link--next" href="<?php echo get_permalink( $nextPost->ID ); ?>" rel="next"><?php echo esc_html( $nextPost->post_title ); ?></a>
				</li>
			<?php endif; ?>
		</ul><!-- .post-navigation__list -->
	</nav><!-- .post-navigation -->
	<?php
}
endif;
