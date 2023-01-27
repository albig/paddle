<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package paddle
 */

if ( ! function_exists( 'paddle_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function paddle_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
		/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'paddle' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on text-muted">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'paddle_category_list' ) ) :
	/**
	 * Display category list
	 */
	function paddle_category_list() {

		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'paddle' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links"  title="' . __( 'Posted in', 'paddle' ) . '">%1$s</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}   //End if categories_list.
		}   // End if post type.
	}

endif; // End if function exist category_list.

if ( ! function_exists( 'paddle_grid_category_list' ) ) :
	/**
	 * Display category list
	 */
	function paddle_grid_category_list() {

		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'paddle' ) );
			if ( $categories_list ) { ?>
			<div class="entry-footer grid-category-list">
				<?php 
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links"  title="' . __( 'Posted in', 'paddle' ) . '">%1$s</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</div>
			<?php }   //End if categories_list.
		}   // End if post type.
	}

endif; // End if function exist category_list.

if ( ! function_exists( 'paddle_category_list_by_id' ) ) :
	/**
	 * Display category list
	 */
	function paddle_category_list_by_id( $id ) {

		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'paddle' ), '', $id );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links"  title="' . __( 'Posted in', 'paddle' ) . '">%1$s</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}   //End if categories_list.
		}   // End if post type.
	}

endif; // End if function exist category_list.


if ( ! function_exists( 'paddle_tag_lists' ) ) :
	/**
	 * Display tag list
	 */

	function paddle_tag_list() {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'paddle' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links" title="%2s">' . esc_html( '%2s' ) . '</span>', esc_attr__( 'Tagged', 'paddle' ), $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}   //    End paddle tag list

endif;  // End if exists paddle tag lists


if ( ! function_exists( 'paddle_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function paddle_posted_by() {
		$byline = sprintf(
		/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'paddle' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'paddle_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function paddle_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			do_action('paddle_before_post_entry_footer');

			if (is_single()) paddle_category_list();

			paddle_tag_list();

			if (is_single()) paddle_posted_on();

			do_action('padddle_after_post_entry_footer');
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'paddle' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'paddle' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;


if ( ! function_exists( 'paddle_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function paddle_post_thumbnail($size='') {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		$featured_thumbnail = isset($size) && '' !== $size ? $size : PADDLE_DEFAULT_OPTION['paddle_thumbnail_size'];

		//if( is_singular() ) { $featured_thumbnail = 'paddle-featured-image'; }

		if( is_archive() ) { $featured_thumbnail = 'paddle-small-thumb'; }

		if ( is_singular() || is_front_page() ) :
			?>

			<div class="post-thumbnail">
				<div class="thumbnail-container">
			<?php if ( is_front_page() ) : ?>
						<a class="post-thumbnail <?php echo esc_attr( 1 === get_theme_mod( 'paddle_expand_grid_image', PADDLE_DEFAULT_OPTION['paddle_expand_grid_image'] ) ? 'paddle-large-image' : 'paddle-small-thumb' ); ?>" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php the_post_thumbnail($featured_thumbnail); ?>
						</a>
						<?php else : ?>
							<?php the_post_thumbnail($featured_thumbnail); ?>
						<?php endif; ?>
				</div><!-- .thumbnail-container -->
			</div><!-- .post-thumbnail -->

		<?php else : ?>
			<div class="thumbnail-container not-single">
			<a class="post-thumbnail <?php echo esc_attr( 1 === get_theme_mod( 'paddle_expand_grid_image', PADDLE_DEFAULT_OPTION['paddle_expand_grid_image'] ) ? 'paddle-large-image' : 'paddle-small-thumb' ); ?>" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			
			<?php
			the_post_thumbnail(
				$featured_thumbnail,
				array(
					'alt' => the_title_attribute(
						array(
							'echo' => false,
						)
					),
				)
			);
			?>
			</a>
			</div><!-- .thumbnail-container -->
			

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @param  string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function paddle_excerpt_more( $link ) {
	$readmore = get_theme_mod( 'read_more_text', PADDLE_DEFAULT_OPTION['read_more_text'] );

	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf(
		'<div class="article-more-link"><a href="%1$s" class="read-more">%2$s</a></div><div class="clearfix"></div>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( $readmore, get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'paddle_excerpt_more' );


if ( ! function_exists( 'paddle_excerpt_length' ) ) :
	/**
	 * Changes the default 55 character in excerpt 
	*/
	function paddle_excerpt_length( $length ) {
		$excerpt_length = get_theme_mod( 'excerpt_length', PADDLE_DEFAULT_OPTION['excerpt_length'] );
		return is_admin() ? $length : absint( $excerpt_length );    
	}
endif;
add_filter( 'excerpt_length', 'paddle_excerpt_length', 999 );

/**
 * Banner button css class
 */
if ( ! function_exists( 'paddle_banner_btncss ' ) ) {
	function paddle_banner_btncss() {
		$css                 = '';
		$paddle_banner_btn_1 = get_theme_mod( 'header_banner_button_1', PADDLE_DEFAULT_OPTION['header_banner_button_1'] );
		$paddle_banner_btn_2 = get_theme_mod( 'header_banner_button_2', PADDLE_DEFAULT_OPTION['header_banner_button_2'] );
		if ( ! empty( $paddle_banner_btn_1 ) && ! empty( $paddle_banner_btn_2 && '' !== $paddle_banner_btn_2 ) ) {
			$css = 'btn__curves';
		}
		return $css;
	}
}

/**
* Content over homepage banner
*/
if ( ! function_exists( 'paddle_content_over_banner' ) ) {
	function paddle_content_over_banner() {
		$css          = false;
		$option_value = get_theme_mod( 'paddle_enable_content_over_banner', PADDLE_DEFAULT_OPTION['paddle_enable_content_over_banner'] );
		$media_value  = get_theme_mod( 'header_media_select', PADDLE_DEFAULT_OPTION['header_media_select'] );
		if ( is_home() || is_front_page() ) {
			if ( 1 === $option_value && 'hero' === $media_value ) {
				$css = true;
			}
		}
		return $css;
	}
}

/**
 * Trim word
 */
if ( ! function_exists( 'paddle_theme_trim_text ' ) ) :
	function paddle_theme_trim_text( $text, $count ) {
		$trimed = '';
		$text   = str_replace( '  ', ' ', $text );
		$string = explode( ' ', $text );
		for ( $word_counter = 0; $word_counter <= $count;$word_counter++ ) {
			if ( isset( $string[ $word_counter ] ) ) {
				$trimed .= $string[ $word_counter ];
			}
			if ( $word_counter < $count ) {
				$trimed .= ' '; } else {
						$trimed .= '...'; }
		}
		$trimed = trim( $trimed );
		return $trimed;
	}
endif;

/**
 * Remove Category name from the title
 */

add_filter( 'get_the_archive_title', 'paddle_replaceCategoryName' );
if (! function_exists('paddle_replaceCategoryName')) :
function paddle_replaceCategoryName( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	}
	return $title;
}
endif;

add_action( 'paddle_before_archive_excerpt', 'paddle_grid_category_list', 10 );

if( ! function_exists( 'paddle__get_image_sizes' ) ) :
	/**
	 * Get information about available image sizes
	 */
	function paddle_get_image_sizes( $size = '' ) {
	 
		global $_wp_additional_image_sizes;
	 
		$sizes = array();
		$get_intermediate_image_sizes = get_intermediate_image_sizes();
	 
		// Create the full array with sizes and crop info
		foreach( $get_intermediate_image_sizes as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
				$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
				$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array( 
					'width' => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
				);
			}
		} 
		// Get only 1 size if found
		if ( $size ) {
			if( isset( $sizes[ $size ] ) ) {
				return $sizes[ $size ];
			} else {
				return false;
			}
		}
		return $sizes;
	}
	endif;
	
	if ( ! function_exists( 'paddle__get_fallback_svg' ) ) :    
	/**
	 * Get Fallback SVG
	*/
	function paddle_get_fallback_svg( $post_thumbnail ) {
		if( ! $post_thumbnail ){
			return;
		}
		
		$image_size = paddle_get_image_sizes( $post_thumbnail );
		 
		if( $image_size ){ ?>
			<div class="svg-holder">
				 <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
						<rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:#f2f2f2;"></rect>
				</svg>
			</div>
			<?php
		}
	}
	endif;

if ( ! function_exists( 'paddle_thumbnail_svg_fallback' ) ) :    
	/**
	 * Get Fallback Thumbnail SVG.
	*/
	function paddle_thumbnail_svg_fallback() {
		if ( ! has_post_thumbnail() &&  1 ===  absint( get_theme_mod('paddle_placeholder_image', PADDLE_DEFAULT_OPTION['paddle_placeholder_image']) ) ) {
			if(  is_front_page() || is_archive() ) { ?>
				<div class="post-thumbnail">
					<div class="thumbnail-container">
						<?php paddle_get_fallback_svg( 'thumbnail' ); ?>
					</div>
				</div>
			<?php }
			
		}
	}
	
endif;