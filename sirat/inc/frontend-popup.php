<?php
/**
 * Front-end promo popup for pro theme upgrade.
 *
 * Shown bottom-right on the front end to super admins only.
 * Closing it hides it for 48 hours per user (persisted via user meta).
 * The snooze is reset whenever the theme is activated or deactivated.
 *
 * @package Sirat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SIRAT_POPUP_META_KEY', 'sirat_popup_dismissed' );
define( 'SIRAT_POPUP_NONCE', 'sirat_popup_dismiss' );
define( 'SIRAT_POPUP_SNOOZE', 2 * DAY_IN_SECONDS );
define( 'SIRAT_PRO_SLUG', 'multipurpose-wordpress-theme' );
define( 'SIRAT_PRO_PRICE_URL', 'https://www.vwthemes.com/products/' . SIRAT_PRO_SLUG . '.js' );
define( 'SIRAT_PRO_PRICE_TRANSIENT', 'sirat_pro_price' );

/**
 * Fetch the premium theme price from the store by product slug.
 *
 * Cached for 12 hours (1 hour on failure). Returns a formatted price
 * such as "$60", or an empty string if the price could not be fetched.
 */
function sirat_get_pro_price() {
	$sirat_price = get_transient( SIRAT_PRO_PRICE_TRANSIENT );

	if ( false !== $sirat_price ) {
		return $sirat_price;
	}

	$sirat_price    = '';
	$sirat_response = wp_remote_get( SIRAT_PRO_PRICE_URL, array( 'timeout' => 10 ) );

	if ( ! is_wp_error( $sirat_response ) && 200 === wp_remote_retrieve_response_code( $sirat_response ) ) {
		$sirat_product = json_decode( wp_remote_retrieve_body( $sirat_response ) );

		// Store returns price in cents.
		if ( isset( $sirat_product->price ) && is_numeric( $sirat_product->price ) ) {
			$sirat_amount = $sirat_product->price / 100;
			$sirat_price  = '$' . number_format_i18n( $sirat_amount, floor( $sirat_amount ) == $sirat_amount ? 0 : 2 );
		}
	}

	set_transient( SIRAT_PRO_PRICE_TRANSIENT, $sirat_price, '' === $sirat_price ? HOUR_IN_SECONDS : 12 * HOUR_IN_SECONDS );

	return $sirat_price;
}

/**
 * Whether the popup should render for the current request.
 */
function sirat_popup_should_show() {
	if ( is_admin() || ! is_user_logged_in() || ! is_super_admin() ) {
		return false;
	}

	// A child theme that ships its own popup takes over.
	if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/inc/frontend-popup.php' ) ) {
		return false;
	}

	$sirat_dismissed = (int) get_user_meta( get_current_user_id(), SIRAT_POPUP_META_KEY, true );

	return ( time() - $sirat_dismissed ) >= SIRAT_POPUP_SNOOZE;
}

/**
 * Render popup in the front-end footer.
 */
function sirat_frontend_promo_popup() {

	if ( ! sirat_popup_should_show() ) {
		return;
	}

	$sirat_logo_url = get_template_directory_uri() . '/assets/images/final-logo.png';
	$sirat_buy_url  = defined( 'SIRAT_BUY_NOW' ) ? SIRAT_BUY_NOW : 'https://www.vwthemes.com/products/multipurpose-wordpress-theme';
	$sirat_demo_url = defined( 'SIRAT_LIVE_DEMO' ) ? SIRAT_LIVE_DEMO : 'https://preview.vwthemesdemo.com/vw-sirat/';
	$sirat_nonce    = wp_create_nonce( SIRAT_POPUP_NONCE );
	$sirat_price    = sirat_get_pro_price();
	?>
	<div class="vw-upsell-popup" role="dialog" aria-labelledby="vw-upsell-popup-title" data-nonce="<?php echo esc_attr( $sirat_nonce ); ?>">
		<div class="vw-upsell-popup__inner">
			<img src="<?php echo esc_url( $sirat_logo_url ); ?>" alt="<?php esc_attr_e( 'VW Themes', 'sirat' ); ?>" class="vw-upsell-popup__logo" />
			<h2 id="vw-upsell-popup-title" class="vw-upsell-popup__title"><?php esc_html_e( 'Take Your Website Further with Sirat Pro', 'sirat' ); ?></h2>
			<p class="vw-upsell-popup__text"><?php
				if ( $sirat_price ) {
					printf(
						/* translators: %s: Pro theme price. */
						esc_html__( 'Upgrade to Pro & get access to premium features, extra sections and Customizations just at %s', 'sirat' ),
						'<strong>' . esc_html( $sirat_price ) . '</strong>'
					);
				} else {
					esc_html_e( 'Upgrade to Pro & get access to premium features, extra sections and Customizations', 'sirat' );
				}
				?>
			</p>
			<div class="vw-upsell-popup__actions">
				<a href="<?php echo esc_url( $sirat_buy_url ); ?>" class="vw-upsell-popup__btn vw-upsell-popup__btn--buy" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Get Pro Now', 'sirat' ); ?></a>
				<?php if ( $sirat_demo_url ) : ?>
					<a href="<?php echo esc_url( $sirat_demo_url ); ?>" class="vw-upsell-popup__btn vw-upsell-popup__btn--demo" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Live Demo', 'sirat' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
		<button type="button" class="vw-upsell-popup__close" aria-label="<?php esc_attr_e( 'Close', 'sirat' ); ?>">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<?php
}
add_action( 'wp_footer', 'sirat_frontend_promo_popup' );

/**
 * Enqueue popup CSS + JS on the front end.
 */
function sirat_frontend_promo_popup_assets() {

	if ( ! sirat_popup_should_show() ) {
		return;
	}

	$sirat_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'sirat-upsell-popup',
		get_template_directory_uri() . '/assets/css/frontend-popup.css',
		array(),
		$sirat_version
	);

	wp_enqueue_script(
		'sirat-upsell-popup',
		get_template_directory_uri() . '/assets/js/frontend-popup.js',
		array(),
		$sirat_version,
		true
	);

	wp_localize_script(
		'sirat-upsell-popup',
		'SiratPopup',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'action'  => 'sirat_dismiss_popup',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'sirat_frontend_promo_popup_assets' );

/**
 * AJAX handler: snooze the popup for the current user.
 */
function sirat_dismiss_popup_handler() {

	if ( ! is_super_admin() ) {
		wp_send_json_error( array( 'message' => 'forbidden' ), 403 );
	}

	check_ajax_referer( SIRAT_POPUP_NONCE, 'nonce' );

	update_user_meta( get_current_user_id(), SIRAT_POPUP_META_KEY, time() );

	wp_send_json_success();
}
add_action( 'wp_ajax_sirat_dismiss_popup', 'sirat_dismiss_popup_handler' );

/**
 * Reset the snooze for all users so the popup shows again
 * whenever this theme is activated (fresh install or re-activation).
 */
function sirat_reset_popup_dismissal() {
	delete_metadata( 'user', 0, SIRAT_POPUP_META_KEY, '', true );
}
add_action( 'after_switch_theme', 'sirat_reset_popup_dismissal' );

/**
 * Also clear it when switching away from this theme (deactivation).
 */
add_action( 'switch_theme', 'sirat_reset_popup_dismissal' );
