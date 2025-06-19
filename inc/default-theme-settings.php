<?php

/**
 * Check and setup theme's default settings
 *
 * @package paddle
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Set secondary color
 * @return  string
 */

if ( ! function_exists( 'paddle_convert_rgba_to_hex' ) ) {
	function paddle_convert_rgba_to_hex( $opacity, $color ) {

		$color_with_opacity = $color . strval( $opacity );
		if ( preg_match( '|^#([A-Fa-f0-9]{4}){1,2}$|', $color_with_opacity ) ) {
			return strval( $color_with_opacity );
		}

	}
}

if ( ! defined( 'PADDLE_PRIMARY_COLOR' ) ) {
	$primary_color = get_theme_mod( 'paddle_primary_color') ? sanitize_hex_color( get_theme_mod( 'paddle_primary_color')) : '#000000';
	define( 'PADDLE_PRIMARY_COLOR', $primary_color );
}
/**
* Set our Customizer default options
*/
if ( ! function_exists( 'paddle_generate_defaults' ) ) {
	function paddle_generate_defaults() {
		$customizer_defaults = array(
			'social_newtab'                 => 0,
			'social_urls'                   => '',
			'social_alignment'              => 'alignright',
			'social_rss'                    => 0,
			'social_url_icons'              => '',
			'contact_phone'                 => '',
			'search_menu_icon'              => 0,
			'woocommerce_shop_sidebar'      => 1,
			'woocommerce_product_sidebar'   => 0,
			'paddle_header_layout_style'    => 'logo-left-style-2',
			'paddle_header_search_button'   => 1,
			'paddle_header_cta'             => 0,
			'paddle_header_cta_position'	=> 0,
			'header_media_height'           => 60,
			'header_logo_size'              => 150,
			'header_logo_padding'           => 16,
			'paddle_menu_text_to_uppercase' => 0,
			'paddle_menu_items_alignment'   => 'centered',
			'enable_top_bar'                => 0,
			'enable_top_bar_on_mobile'      => 0,
			'paddle_contact_phone'          => '',
			'topbar_select'                 => 'button',
			'enable_icon_bg'                => 0,
			'paddle_enable_banner_bgcolor'  => 1,
			'paddle_banner_border_radius'   => 1,
			'paddle_title_headings_solid_lines' => 0,
			'paddle_remove_woo_single_sidebar' => 0,
			'banner_arrow_button'			=> 0,
			'paddle_banner_box_shadow'      => 0,
			'banner_content_bg_opacity'     => get_theme_mod('banner_content_bg_opacity', 9),
			'paddle_menu_bgcolor'           => '#ffffff',
			'paddle_navlink_text_color'     => '#3c434a',
			'paddle_banner_header_color'    => '#ffffff',
			'paddle_banner_header_bg_color' => '#3e3c3c',
			'paddle_primary_color'          => PADDLE_PRIMARY_COLOR,
			'paddle_h1bg_color'			    => PADDLE_PRIMARY_COLOR,
			'paddle_secondary_color'        => paddle_convert_rgba_to_hex( '08', PADDLE_PRIMARY_COLOR ),
			'paddle_h1_alignment'           => 'left',
			'enable_secondary_color'        => 0,
			'opacity_slider_control'        => 2,
			'post_archive_layout'			=> 'grid',
			'paddle_footer_logo'			=> 0,
			'hide_archive_meta'				=> 0,
			'paddle_sidebar_position'		=> 'right-sidebar',
			'paddle_footer_social'			=> 1,
			'banner_align_position'			=> 'none',
			'banner_content_align'			=> 'left',
			'banner_overlay_opacity'		=> 2,
			'paddle_theme_credit'			=> 0,
			'paddle_slider_source'			=> 'latest-post',
			'header_media_select'			=> 'hero',
			'paddle_expand_grid_image'		=> 1,
			'paddle_enable_content_over_banner'	=> 1,
			'content_over_banner_position'  => 150,
			'header_banner_button_1'			=> 'Learn more',
			'header_banner_button_2'			=> '',
			'paddle_header_cta_text'			=> 'CTA Button',
			'topbar_header_button_text'		=> '',
			'paddle_privacy_policy'			=> 0,
			'footer_social_urls'			=> '',
			'hero_image'					=> 0,
			'paddle_slider_custom_url'		=> 0,
			'header_banner_title'			=> 'Build Your Dream Website with Paddle',
			'header_banner_description'		=> 'Go Forward and Conquer',
			'paddle_grid_columns'			=> '2-columns',
			'paddle_enable_author_bio'		=> 1,
			'header_menu_padding'			=> 18,
			'menu_item_margin'			    => 16,
			'menu_border_top'				=> 1,
			'use_default_banner_image'      => 1,
			'paddle_thumbnail_size'			=> 'paddle-featured-image',
			'site_title_font_size'			=> 40,
			'excerpt_length'				=> 55,
			'read_more_text'				=> 'Continue reading',
			'enable_blog_excerpt'			=> 1,
			'enable_image_before_site_title' => 1,
			'enable_same_height_image'      => 1,
			'banner_button_align'			=> 'right',
			'banner_button_transform'		=> 'uppercase',
			'paddle_placeholder_image'      => 1,
			'paddle_header_logo_align'		=> 'self-start'
		);

		return apply_filters( 'paddle_customizer_defaults', $customizer_defaults );
	}
}

$defaults_options =  paddle_generate_defaults();
	define( 'PADDLE_DEFAULT_OPTION', $defaults_options );

if ( ! defined( 'PADDLE_DEFAULT_OPTION' ) ) {
	$defaults_options =  paddle_generate_defaults();
	define( 'PADDLE_DEFAULT_OPTION', $defaults_options );
}

if ( ! defined( 'PADDLE_PRIMARY_COLOR' ) ) {
	// Replace the version number of the theme on each release.
	$primary_color = get_theme_mod( 'paddle_primary_color', PADDLE_DEFAULT_OPTION['paddle_primary_color']) ? sanitize_hex_color( get_theme_mod( 'paddle_primary_color', PADDLE_DEFAULT_OPTION['paddle_primary_color'])) : '#000000';
	define( 'PADDLE_PRIMARY_COLOR', $primary_color );
}

/**
 * Dynamic CSS
 */
if ( ! function_exists( 'paddle_static_header_css' ) ) {

	/**
	 * Styles the header.
	 */
	function paddle_static_header_css() {
		$primary_color                           = sanitize_hex_color( get_theme_mod( 'paddle_primary_color', PADDLE_PRIMARY_COLOR ) );
		$paddle_header_logo_size				 = absint( get_theme_mod( 'header_logo_size', 150 ) );
		$paddle_header_logo_padding				 = absint( get_theme_mod( 'header_logo_padding', 16 ) );
		$paddle_menu_bgcolor_check               = sanitize_hex_color( get_theme_mod( 'paddle_menu_bgcolor', '#ffffff' ) );
		$paddle_navlink_text_color_check         = sanitize_hex_color( get_theme_mod( 'paddle_navlink_text_color', $primary_color ) );
		$paddle_h1bg_color_check                 = sanitize_hex_color( get_theme_mod( 'paddle_h1bg_color', $primary_color ) );
		$paddle_center_align_menu_check          = absint( get_theme_mod( 'paddle_center_align_menu' ) );
		$paddle_menu_items_alignment             = get_theme_mod('paddle_menu_items_alignment', 'centered');
		$paddle_menu_uppercase                   = absint( get_theme_mod( 'paddle_menu_text_to_uppercase' ) );
		//Header Banner
		$header_media_height                     = absint( get_theme_mod( 'header_media_height', PADDLE_DEFAULT_OPTION['header_media_height'] ) );
		$paddle_banner_header_color              = sanitize_hex_color( get_theme_mod( 'paddle_banner_header_color', PADDLE_DEFAULT_OPTION['paddle_banner_header_color'] ) );
		$paddle_banner_header_bgcolor            = sanitize_hex_color( get_theme_mod( 'paddle_banner_header_bg_color',  PADDLE_DEFAULT_OPTION['paddle_banner_header_bg_color'] ) );
		$paddle_enable_banner_bgcolor            = absint( get_theme_mod( 'paddle_enable_banner_bgcolor',  PADDLE_DEFAULT_OPTION['paddle_enable_banner_bgcolor'] ) );
		$paddle_enable_icon_bg                   = absint( get_theme_mod( 'enable_icon_bg', PADDLE_DEFAULT_OPTION['enable_icon_bg'] ) );
		$banner_content_bg_opacity               = absint( get_theme_mod( 'banner_content_bg_opacity', PADDLE_DEFAULT_OPTION['banner_content_bg_opacity'] ) );
		$paddle_banner_border_radius             = absint( get_theme_mod( 'paddle_banner_border_radius', PADDLE_DEFAULT_OPTION['paddle_banner_border_radius'] ) );
		$paddle_title_headings_solid_lines_check = absint( get_theme_mod( 'paddle_title_headings_solid_lines', PADDLE_DEFAULT_OPTION['paddle_title_headings_solid_lines'] ) );
		$paddle_remove_woo_single_sidebar_check  = absint( get_theme_mod( 'paddle_remove_woo_single_sidebar', PADDLE_DEFAULT_OPTION['paddle_remove_woo_single_sidebar'] ) );
		$paddle_cta_position  					 = absint( get_theme_mod( 'paddle_header_cta_position', PADDLE_DEFAULT_OPTION['paddle_header_cta_position'] ) );
		$menu_item_margin  					     = absint( get_theme_mod( 'menu_item_margin', PADDLE_DEFAULT_OPTION['menu_item_margin'] ) );
		$paddle_menu_border_top					 = absint( get_theme_mod( 'menu_border_top', PADDLE_DEFAULT_OPTION['menu_border_top'] ) );
		$banner_content_align                    = get_theme_mod( 'banner_content_align', PADDLE_DEFAULT_OPTION['banner_content_align'] );
		$content_over_banner_position            = absint( get_theme_mod( 'content_over_banner_position', PADDLE_DEFAULT_OPTION['content_over_banner_position'] ) );
		$site_title_font_size					 = absint( get_theme_mod( 'site_title_font_size', PADDLE_DEFAULT_OPTION['site_title_font_size'] ) );
		$enable_image_before_site_title			 = absint( get_theme_mod( 'enable_image_before_site_title', PADDLE_DEFAULT_OPTION['enable_image_before_site_title'] ) );
		$enable_same_height_image				 = absint( get_theme_mod( 'enable_same_height_image', PADDLE_DEFAULT_OPTION['enable_same_height_image'] ) );
		$paddle_expand_grid_image				 = absint( get_theme_mod( 'paddle_expand_grid_image', PADDLE_DEFAULT_OPTION['paddle_expand_grid_image'] ) );
		$banner_button_align                     = get_theme_mod( 'banner_button_align', PADDLE_DEFAULT_OPTION['banner_button_align'] );
		$banner_button_transform                = get_theme_mod( 'banner_button_transform', PADDLE_DEFAULT_OPTION['banner_button_transform'] );

		$css = '';

		// Site title
		$css .= '.site-header .site-title {font-size: '.$site_title_font_size.'px}';

		// Logo
		$css .= '
		@media screen and (min-width:992px) {
			.site-header .site-logo img {max-height: '.$paddle_header_logo_size.'px}
		  }
		  @media screen and (max-width:500px) {
			.site-header .site-logo img {max-height:60px}
		  }
		  body #masthead.site-header.header-style-2 #header-style-2 .site-branding-wrap {
			padding: '.$paddle_header_logo_padding.'px 0;
		  }
		  body .site-branding .site-logo {
			padding-top: '.$paddle_header_logo_padding.'px;
			padding-bottom: '.$paddle_header_logo_padding.'px;
		  }
		';

		if ( 1 === $paddle_menu_border_top ) {
			$css .= '#masthead.header-style-1 #main-header-navigation, #masthead.header-style-2  { border-top: 1px solid #f3f3f3}';
		}

		// Social icon background color
		if ( 0 === $paddle_enable_icon_bg ) {
			$css .= '
			#topbar ul.social-items li .bg-transform {
				background-color: transparent!important;
			}
			';
		}

		if ( 0 === $paddle_cta_position ) {
			$css .='@media screen and (min-width:992px) {
				[data-header-style="1"] ul #header-btn-cta { margin-left: '.$paddle_cta_position.'!important}
			  }
			';
		} else {
			$css .='@media screen and (min-width:992px) {
				[data-header-style="1"] ul #header-btn-cta { margin-left: auto!important}
			  }
			';
		}

		$css .='#masthead.site-header.header-style-2 #header-style-2 nav {
			width:100%
		}';

		if ( 'centered' === $paddle_menu_items_alignment ) {
			$css .= '
			#masthead [data-header-style="1"] ul {justify-content: center;}
			#masthead [data-header-style="1"] ul #header-btn-cta {margin-left:unset; }
			';
		} else if( 'left' === $paddle_menu_items_alignment ) {
			$css .= '
			#masthead [data-header-style="1"] ul {justify-content: flex-start;}
			[data-header-style="1"] ul #header-btn-cta {margin-left:auto; }
			';
		} else if ( 'right' === $paddle_menu_items_alignment ) {
			$css .= '
			#masthead [data-header-style="1"] ul {justify-content: flex-end;}
			[data-header-style="1"] ul #header-btn-cta {margin-left:unset; }
			';
		} else if ('justify' === $paddle_menu_items_alignment ) {
			$css .= '
			#masthead [data-header-style="1"] ul {justify-content: space-between;}
			[data-header-style="1"] ul #header-btn-cta {margin-left:unset; }
			';
		} else {
			$css .= '
			#masthead [data-header-style="1"] ul {justify-content: center;}
			';
		}

		if ( 1 === $paddle_menu_uppercase ) {
			$css .= '[data-header-style="1"] .menu-item a {text-transform: uppercase; }';
		}

		if ( 0 === $paddle_remove_woo_single_sidebar_check ) {
			$css .= 'body.single.single-product #primary.content-area {max-width:100%; flex: 0 0 100%; }';
		}


		/* Primary Colory */

		$css .= 'a {color: '.$primary_color.'}';
		$css .= 'a:focus-visible, button:focus-visible {outline: 2px solid  '.$primary_color.'}';
		$css .= '
		#masthead [data-header-style="1"] ul li a:hover,
		#masthead [data-header-style="1"] ul li:hover > a,
		#masthead [data-header-style="1"] .current_page_item > a,
		#masthead [data-header-style="1"] .current-menu-item > a,
		#masthead [data-header-style="1"] .current_page_ancestor > a,
		#masthead [data-header-style="1"] .current-menu-ancestor > a,
		#masthead [data-header-style="1"] ul li a:focus,
		#masthead [data-header-style="1"] ul li a:hover,
		[data-header-style="1"] ul li:focus > a {
			color: '.$paddle_navlink_text_color_check.';
			font-weight: 700;
		}';

		$css .= '
		#primary main .entry-title a:hover,
		#primary main .entry-title a:focus,
		.entry-title a:hover,
		.entry-title a:focus,
		#secondary .widget ul li a:hover,
		#secondary .widget ul li a:focus,
		.site-footer .widget ul li a:hover,
		.site-footer .widget ul li a:focus,
		.post-navigation .nav-links a:hover,
		.posts-navigation a:hover,
		.comments-area .comment-body .comment-metadata a:hover,
		.comments-area .comment-body .comment-metadata a:focus,
		.site-title a:hover, .site-title a:focus,
		#secondary .widget ul li a:hover, #secondary .widget ul li a:focus,
		.comments-area .comment-body .fn a:hover,
		.comments-area .comment-body .fn a:focus,
		.widget_rss .widget-title a:hover,
		.widget_rss .widget-title a:focus,
		.submenu-toggle:hover,
		.submenu-toggle:focus{
			color: '.$primary_color.';
		}';

		// buttons
		$css .= '
		button:not(.btn),
		input[type=button]:not(.btn),
		input[type=reset]:not(.btn),
		input[type=submit]:not(.btn),
		btn-primary,
		#searchModal .search-form-container .bg-close-cirle,
		#topbar, #topbar .cta a::after
		{
		background-color: '.$primary_color.';
		}
		';
		$css .='
		button:not(.btn):hover,
		input[type=button]:not(.btn):hover,
		input[type=reset]:not(.btn):hover,
		input[type=submit]:not(.btn):hover,
		btn-primary:hover
		{
			background-color: linear-gradient(217deg, '.paddle_rgba($primary_color, 8).', '.paddle_rgba($primary_color, 8).' 70.71%),
			linear-gradient(217deg, rgba(255,0,0,.8), rgba(255,0,0,0) 70.71%),
			linear-gradient(127deg, rgba(0,255,0,.8), rgba(0,255,0,0) 70.71%),
			linear-gradient(336deg, rgba(0,0,255,.8), rgba(0,0,255,0) 70.71%);
			background: '.$primary_color.'80;
			background-color: '.paddle_rgba($primary_color, 8).';
			color: currentColor;
		}
		button:not(.btn):active, button:not(.btn):focus, input[type=button]:not(.btn):active,
		input[type=button]:not(.btn):focus, input[type=reset]:not(.btn):active, input[type=reset]:not(.btn):focus,
		input[type=submit]:not(.btn):active, input[type=submit]:not(.btn):focus {
			border-color: '.$primary_color.';
		}
		#searchModal .search-form-container .close:focus {
			filter: unset;
		}
		#searchModal .search-form-container .close:focus + span { background-color: white; }
		#searchModal .search-form-container .close:focus {transform: rotate(25deg);}
		';


		$css .= '
		[data-menu=offcanvas] .offcanvas-header button.btn-close.text-reset {border-color: '.paddle_rgba($primary_color, 8).';}
		';
		if( '#000000' !== $paddle_navlink_text_color_check ) {
			$css .= '
			[data-header-style="1"] .menu>.menu-item>a { color: ' . $paddle_navlink_text_color_check . '; }
			[data-header-style="1"] ul .sub-menu .menu-item>a { color: ' . $paddle_navlink_text_color_check . '; }
			';
		}

		$css .='blockquote {border-left: 4px solid '.$primary_color.'; border-color: '.$primary_color.' }';


		if ( '' !== $primary_color ) {
			$css .= '
           li.menu-item.current-menu-item>a, [data-header-style="1"] .menu-item.current-menu-ancestor > a {
                color: ' . $primary_color  . ';
            }

            .btn-primary {
                background-color: ' . $primary_color . ';
                border-color: ' . $primary_color . ';
            }
			.btn-primary:hover,.btn-primary:focus,
			a.btn.btn-primary:hover,
			a.btn.btn-primary:focus,
			.btn-outline-primary {
                border-color: ' . $primary_color . ';
				color: ' . $primary_color . ';
            }

            .btn-check:focus+.btn-primary, .btn-primary:focus, .btn-close:focus,
			.btn-check:focus+.btn, .btn:focus,
			#searchform input[type=text]:focus,
			input:focus,
			.toggler button.navbar-toggler:active, .toggler button.navbar-toggler:focus {
				box-shadow: 0 0 0 0.25rem ' .paddle_rgba( $primary_color, 4 ) .'
			}


            [data-header-style="1"] .menu-item span svg {
                fill: ' . $primary_color . ';
              }

            .btn-primary:not(:disabled):not(.disabled):active,
			.btn-primary:not(:disabled):not(.disabled).active,
			.show > .btn-primary.dropdown-toggle, .btn-outline-primary:hover {
                background-color: ' . $primary_color . ';
                border-color: ' . $primary_color . ';
            }
			#home-header-image #hero .board, #paddle-slider .board { text-align: '.$banner_content_align.'}

            h1:not(.noline-title):before, h2:not(.noline-title):before, .headline.heading-line:before, .home-banner .home-banner-content .board {
                background: ' . $primary_color . ';
			}
			header.entry-header.has-post-thumbnail.slim-full-width .page__title-wrap{
				background-color: ' . $primary_color . ';
				color: #fff;
			}
			header.entry-header.has-post-thumbnail.slim-full-width .page__title-wrap h1:before{
				background: #ffffff;
			}

			#commentform input#submit {
				color: ' . $primary_color . ';
			}


			section[id*="recent-comments-"] ul li a:after , section[id*="recent-posts-"] ul li:before{
				background-color: ' . $primary_color . ';
			}

			.read-more:before {
				background-color: ' . $primary_color . ';
			}
			.read-more:after {
				color: ' . $primary_color . ';
			}

			.comment-body .reply a {
				background: ' . $primary_color . ';
				border: 1px solid ' . $primary_color . ';
			}

			article.sticky .thumbnail-container::after {
				box-shadow: -25px 20px 0 ' . $primary_color . ';
				background: ' . $primary_color . ';
			}
			';
		}

		// Nav Menu background color.
		if ( '#ffffff' !== $paddle_menu_bgcolor_check ) {
			$css .= '[data-header-style="1"], [data-header-style="1"] .sub-menu { background-color: ' . $paddle_menu_bgcolor_check . '; border-bottom: none; } ';
			$css .= '.header-style-2 [data-header-style="1"] {border-radius: 60px;}';
			$css .= '[data-header-style="1"] .submenu-expand svg {fill: '.$paddle_navlink_text_color_check.'}';
		}
		// Headings H1 background.
		if ( '#000000' !== $paddle_h1bg_color_check ) {
			$css .= 'body.boxed-header header:not(.no-bgcolor)>h1 { background-color: ' . $paddle_h1bg_color_check . '; } ';
		}

		if ( 1 === $enable_image_before_site_title ) {
			$css .= '.archive-grid article .post-thumbnail, .archive.category .thumbnail-container {
				order: -1;
				width: 100%;
			}';
			$css .='.has-post-thumbnail h2.entry-title, .has-placeholder-image h2.entry-title {
				margin-top: 18px;
			}';
			$css.=' .archive-grid.row h2.entry-title {margin-bottom: 24px;}';
		}

		if ( 1 === $enable_same_height_image ) {
			$css .= '.category-grid-layout .thumbnail-container {
				display: block;
				clear: both;
				position: relative;
				margin: 0 auto 15px 0;
				min-height: 1px;
				width: 100%;
				height: 100%;
				padding-top: 0!important;
				padding-bottom: 66.4815%;
				overflow: hidden;
			}

			.category-grid-layout .thumbnail-container img {
				height: auto;
				max-width: 100%;
				width: 100%;
				max-width: unset!important;
				width: 100%;
				height: 100%;
				top: 0;
				left: 0;
				position: absolute;
				-o-object-fit: cover;
				object-fit: cover;
			}
			.home.blog .thumbnail-container, .archive.category .thumbnail-container {
				margin-right: 0; margin-left:0;
				position: relative;
				width: 100%;
			}
			';
		}

		if ( 1 === $paddle_expand_grid_image ) {
			$css .= '.archive-grid.row article {padding: 0; padding-bottom: 50px;}
			.archive-grid.row .entry-content, .archive-grid.row h2.entry-title, .archive-grid.row article .entry-meta, .archive-grid.row article .entry-footer {padding: 0 22px;}
			.archive-grid.row article .thumbnail-container a.post-thumbnail, .archive-grid.row article .thumbnail-container .svg-holder {
				clear: both;
				position: relative;
				margin: 0 auto 0px 0;
				min-height: 1px;
				width: 100%;
				height: 100%;
				padding-top: 0!important;
				padding-bottom: 66.4815%!important;
				overflow: hidden;
			}
			.archive-grid.row article img.wp-post-image, .archive-grid.row article .thumbnail-container .svg-holder svg.fallback-svg {
				width: 100%;
				object-fit: cover;
				max-width: unset!important;
				width: 100%;
				height: 100%;
				top: 0;
				left: 0;
				position: absolute;
				-o-object-fit: cover;
				object-fit: cover;
			}
			.archive-grid.row article .entry-footer.grid-category-list {padding-right: 0; padding-left: 0; padding-bottom:22px; padding-top:5px }
			';

		}

		// Banner Height
		if ( 60 !== $header_media_height ) {
			$css .= '.home-banner  { height : '.$header_media_height.'vh } ';
		}

		// Banner Overlay
		$css .='
		.home-banner .home-banner-overlay {
			background: rgba(0, 0, 0, 0.'.absint( paddle_banner_opacity() ).');
		}
		';
		// Grundge image.
		$css .= '.paddle-front-page-slider .slideshow-content:before {opacity: .' . absint( paddle_banner_opacity() ) . ' ; }';


		// Banner Image
		$css .= '#home-header-image .home-banner-image {
			background-image: url('.esc_url(paddle_get_header_image_url()).')!important;
		}
		';


		// Banner Header Background Color.
		if ( 0 === $paddle_enable_banner_bgcolor ) {
			$css .= '.home-banner .home-banner-content .board  { background: transparent!important } ';
		} else {
			$css .= '.home-banner .home-banner-content .board  { background: ' . $paddle_banner_header_bgcolor . ' } ';
		}

		// Set the background color opacity.
		if ( 10 !== $banner_content_bg_opacity ) {
			$css .= '.home-banner .home-banner-content .board  { background: ' . paddle_rgba( $paddle_banner_header_bgcolor, $banner_content_bg_opacity ) . ' } ';
			$css .= '#paddle-slider .light-box-shadow  { background: ' . paddle_rgba( $paddle_banner_header_bgcolor, $banner_content_bg_opacity ) . ' } ';
		}

		// Banner button align
		$css .='.home-banner .home-banner-content .board .home-banner-cta-button-container {justify-content: '.$banner_button_align.'}';

		$css .='.home-banner .home-banner-content .board .home-banner-cta-button-container>a {text-transform: '.$banner_button_transform.'}';

		// Hide show arrow icon in button
		if (1 !== get_theme_mod('banner_arrow_button', 1)) {
			$css .= '.home-banner-cta-button-container>a:before {display:none;}
			';
		}

		if ( 0 !== get_theme_mod('paddle_banner_box_shadow', 0) ) {
			$css .= '#paddle-slider .light-box-shadow, #hero .board  { box-shadow: 0 0 10px 1px ' . $paddle_banner_header_bgcolor . '; } ';
		}

		if ( 0 === get_theme_mod('paddle_banner_box_shadow', 0) ) {
			$css .= ' #paddle-slider .light-box-shadow, #hero .board  { box-shadow: none; } ';
		}



		// Banner Text Color
		//if ( '#ffffff' !== $paddle_banner_header_color ) {
		$css .= ' .home-banner .home-banner-content .board { color: ' . $paddle_banner_header_color . '; } ';
		$css .= ' .home-banner .home-banner-content .board p { color: ' . $paddle_banner_header_color . '; } ';

		//}


		// Set banner text content border radius;
		if ( 1 === $paddle_banner_border_radius ) {
			$css .= '.home-banner .home-banner-content .board  { border-radius: 15px } ';
		}

		// Shift home .row up
		if(paddle_content_over_banner()) {
			$css .= '
			@media screen and (min-width: 992px) {
				.row.main-row {
					position: relative;
					margin-top: -'.$content_over_banner_position.'px;
					background: #fff;
					z-index: 2;
					padding-top: 3.2rem;
					padding-left: 2rem;
					padding-right: 2rem;
				}
			  }
			';
		}

		if ('center' === get_theme_mod('paddle_h1_alignment', 'left')) {
			$css .= '.single article h1.entry-title, header.entry-header, .archive h1.page-title, .page-header .archive-description,
			header .term-description, article .by-author,article .entry-meta, nav.woocommerce-breadcrumb {
				text-align: center;
			}
			header .term-description p, .page-header .archive-description p  {
				width:100%;
			}
			';

		}

		// Headings solid lines H1 and H2
		if ( 1 === $paddle_title_headings_solid_lines_check) {
			$css .='
			.row.main-row h1:not(.noline-title):before, .row.main-row h2:not(.noline-title):before, .headline.heading-line:before {
				background: $color__primary;
				content: "\020";
				display: block;
				height: 3px;
				margin: 1rem 0;
				width: 1em;
			  }
			  .row.main-row h2:not(.noline-title):before {
				width: 0.67em;
			  }
			  .entry-content h1:before, .entry-content h2:before, .woo-page h1:before, .woo-page h2:before {
				content: unset;
			  }
			';


		} // End Function.



		// Retrun all css

		return paddle_minimize_css( $css );
	}
}




/**
 * Display Dynamic CSS in the document header.
 */
function paddle_output_header_css() {
	if ( ! empty( paddle_static_header_css() ) ) : ?>
<style type="text/css" id="paddle-dynamic-css">
		<?php
		/* Static html */
			echo paddle_static_header_css();
		?>
</style>
		<?php
	endif;
}
add_action( 'wp_head', 'paddle_output_header_css' );

function paddle_sanitize_hex_color( $color ){
	if ( '' === $color )
		return '';

    // 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;
}
