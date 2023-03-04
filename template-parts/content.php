<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package paddle
 */

 $paddle_title_order = has_post_thumbnail() ? ' order-is-0' : ' order-is-1';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( ( is_single() || ( is_page() && ! is_front_page() ) ) ) :
		get_template_part( 'template-parts/header/featured-header', 'image' );

	else :
		if ( is_singular() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
			if ( 1 === get_theme_mod( 'paddle_enable_blog_author', PADDLE_DEFAULT_OPTION['paddle_enable_blog_author'] ) ) {
				printf(
					'<span class="by-author"> %1$s<span class="author vcard"><a class="url" href="%2$s"> %3$s</a></span></span>',
					esc_html_x( 'By', 'post author', 'paddle' ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_html( get_the_author() )
				);
			}

			// Post date
			if ( 'before' === get_theme_mod( 'paddle_blog_date_position', PADDLE_DEFAULT_OPTION['paddle_blog_date_position'] ) ) {
				paddle_posted_on();
			}

			// Comment.
			$paddle_enable_blog_comment = get_theme_mod( 'paddle_enable_blog_comment', PADDLE_DEFAULT_OPTION['paddle_enable_blog_comment'] );
			paddle_get_post_comment( $paddle_enable_blog_comment );

		} else {
			// It is archive
			the_title( '<h2 class="entry-title heading-size-1"><a class="post-entry-link" href="' . esc_url( get_permalink() ) . '"  "rel="bookmark">', '</a></h2>' );
		}

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta<?php echo esc_attr($paddle_title_order);?>">
				<?php if ( 1 === absint( get_theme_mod( 'paddle_enable_archive_author', PADDLE_DEFAULT_OPTION['paddle_enable_archive_author'] ) ) ) : ?>
					<?php paddle_posted_by(); ?>
					<?php
				endif;

				if ( ! is_singular() ) {
					if ( 1 === absint( get_theme_mod( 'paddle_enable_archive_published_date', PADDLE_DEFAULT_OPTION['paddle_enable_archive_published_date'] ) ) ) {
						paddle_posted_on();
					}
				}

				paddle_grid_category_list();?>

			</div><!-- .entry-meta -->
			<?php
		endif;    // End if post type.

		do_action( 'paddle_after_post_title' );

		if ( 1 === absint( get_theme_mod( 'enable_archive_featured_image', PADDLE_DEFAULT_OPTION['enable_archive_featured_image'] ) ) ) {
			$paddle_archive_thumbnail_size = get_theme_mod( 'paddle_archive_thumbnail_size', PADDLE_DEFAULT_OPTION['paddle_archive_thumbnail_size'] );
			paddle_post_thumbnail($paddle_archive_thumbnail_size);
		}

	endif;
	?>

	<?php do_action( 'paddle_before_entry_content' ); ?>

	<div class="entry-content">
		<?php

		if ( is_search() || ! is_singular() ) {
			do_action( 'paddle_before_archive_excerpt' );

			$paddle_enable_blog_excerpt = get_theme_mod( 'enable_blog_excerpt', PADDLE_DEFAULT_OPTION['enable_blog_excerpt'] );
			if ( 1 === $paddle_enable_blog_excerpt ) {
				the_excerpt();
			}
		} else {
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'paddle' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
		}

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'paddle' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php do_action( 'paddle_after_entry_content' ); ?>

	<div class="clearfix"></div>

	<?php
	if(is_singular()) : ?>
	<footer class="entry-footer">
			<div class="entry-meta">
				<?php paddle_entry_footer(); ?>
			</div>
	</footer><!-- .entry-footer -->
	<?php endif; ?>
	
</article><!-- #post-<?php the_ID(); ?> -->

