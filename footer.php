<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package paddle
 */

use WP_CLI\Fetchers\Site;

?>



</div><!-- .row -->
</div><!-- .container -->
</div><!-- #content -->

<!-- Search Modal -->
<?php
$paddle_search_modal = new PaddleMenu();
if ( $paddle_search_modal->isSearchEnable() ) {
	do_action( 'paddle_action_search_modal' );
}
?>

<div class="clearfix"></div>

<?php do_action( 'paddle_before_main_footer' ); ?>


<footer id="paddle-footer-colophon" class="site-footer">
	<div class="footer-wrap">
		<div class="footer-main d-flex container">
			<div class="footer-branding">
			<?php 
				$paddle_footer_logo_active = get_theme_mod( 'paddle_footer_logo', PADDLE_DEFAULT_OPTION['paddle_footer_logo'] );
				$paddle_footer_logo_id = get_theme_mod( 'footer_logo_image', PADDLE_DEFAULT_OPTION['footer_logo_image'] ) > 0 ?  absint( get_theme_mod( 'footer_logo_image' ) ) : 0;
				$paddle_footer_about_active = absint(get_theme_mod( 'paddle_footer_about_enable', PADDLE_DEFAULT_OPTION['paddle_footer_about_enable'] ));
				$paddle_footer_about = get_theme_mod( 'paddle_footer_about', PADDLE_DEFAULT_OPTION['paddle_footer_about'] );
				$paddle_social_column = get_theme_mod( 'footer_social_column', PADDLE_DEFAULT_OPTION['footer_social_column'] );
				$paddle_footer_has_social = get_theme_mod( 'paddle_footer_social', PADDLE_DEFAULT_OPTION['paddle_footer_social'] );
				$paddle_enable_payment_badge = absint(get_theme_mod( 'enable_payment_badge', PADDLE_DEFAULT_OPTION['enable_payment_badge'] ));
				$paddle_payment_badge_source = get_theme_mod( 'payment_badge_source', PADDLE_DEFAULT_OPTION['payment_badge_source'] );
				$paddle_payment_badge_image = get_theme_mod( 'payment_badge_image', PADDLE_DEFAULT_OPTION['payment_badge_image'] ) > 0 ?  absint( get_theme_mod( 'payment_badge_image' ) ) : 0;
				$paddle_payment_badge_textarea_svg = get_theme_mod( 'payment_badge_textarea', PADDLE_DEFAULT_OPTION['payment_badge_textarea'] );
				$paddle_payment_badge_color = get_theme_mod( 'payment_badge_color', PADDLE_DEFAULT_OPTION['payment_badge_color'] );
				$paddle_payment_badge_column = get_theme_mod( 'footer_payment_badge_column', PADDLE_DEFAULT_OPTION['footer_payment_badge_column'] );
			
			 if( 1 === $paddle_footer_logo_active && $paddle_footer_logo_id > 0 ) { ?>
					<div id="footer-logo">
						<?php if(!is_home() || !is_front_page()) : ?>
							<a href="<?php echo esc_url(site_url()); ?>" >
						<?php endif; ?>
							<?php paddle_optimize_image_height_width_using_id($paddle_footer_logo_id, 'medium', 'footer-logo-image', 'logo'); ?>
						<?php if(!is_home() || !is_front_page()) : ?>
			 				</a>
						<?php endif; ?>
					</div>
			<?php } 

			if ( 1 === $paddle_footer_about_active && '' !==  wp_kses_post($paddle_footer_about) ) { ?>
					<div class="footer-tagline position-relative">
						<?php echo wp_kses_post( paddle_filter_footer_copyright($paddle_footer_about) ); ?>
					</div>

			<?php }

				if( 1 === $paddle_footer_has_social && 'with-logo' === $paddle_social_column ) {
					get_template_part( 'template-parts/footer/social', 'items' ); 
				}	
				?>
			</div>
		<?php
		/**
		 * Widgets Sidbar
		 */
		if ( is_active_sidebar( 'footer-1' ) ||
			is_active_sidebar( 'footer-2' ) ||
			is_active_sidebar( 'footer-3' ) ||
			is_active_sidebar( 'footer-4' ) ||
			is_active_sidebar( 'footer-5' ) ||
			1 === get_theme_mod( PADDLE_DEFAULT_OPTION['paddle_footer_logo'], 0 )
			) :

			get_template_part( 'template-parts/footer/widgets' );

		endif;
		?>
		</div><!--.footer-main-->
		<?php
		/**
		 * Footer Widget 5
		 */
		if ( is_active_sidebar( 'footer-5' ) ) :
			?>
			<div class="container widget-container footer-widget-5"><?php dynamic_sidebar( 'footer-5' ); ?></div>
		<?php endif; ?>

		<div class="site-info">
			<?php 
			if ( paddle_is_woocommerce_active() 
				&& 'top' === $paddle_payment_badge_column
				&& 1 === $paddle_enable_payment_badge
				&& !empty($paddle_payment_badge_textarea_svg) ) {  ?>
				<div class="container">
					<div class="col-lg-12 col-md-12 col-12 col_3 bt_payment_trust">
					<?php paddle_payment_badge() ;?>
					</div>
				</div>
			<?php } ?>
			<div class="container py-3 text-center">
				<?php
				/**
				 * Hook - paddle_action_footer.
				 *
				 * @hooked paddle_footer_copyrights - 10
				 */
				do_action( 'paddle_action_footer' );
				if ('bottom' === $paddle_payment_badge_column) {
					paddle_payment_badge() ;
				}
				?>
			</div><!-- .container -->
		</div><!-- .site-info -->
		
	</div><!-- .footer-wrap-->
</footer><!-- #colophon -->


</div><!-- #page -->


<?php wp_footer(); ?>

</body>

</html>
