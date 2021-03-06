<?php
/**
 * @Author: ducnvtt
 * @Date  :   2016-03-03 10:34:45
 * @Last  Modified by:   leehld
 * @Last  Modified time: 2017-02-03 15:50:46
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$event    = new WPEMS_Event( get_the_ID() );
$user_reg = $event->booked_quantity( get_current_user_id() );

?>
<h3 class="book-title"><?php esc_html_e( 'Buy Ticket', 'eduma' ); ?></h3>

<div class="event_register_area">

    <form name="event_register" class="event_register" method="POST">

        <ul class="info-event">
            <li>
                <div class="label"><?php esc_html_e( 'Total Slots', 'eduma' ); ?></div>
                <div class="value"><?php echo absint( $event->qty ); ?></div>
            </li>
            <li>
                <div class="label"><?php esc_html_e( 'Booked Times', 'eduma' ); ?></div>
                <div class="value"><?php echo count( $event->load_registered() ); ?></div>
            </li>
            <li>
                <div class="label"><?php esc_html_e( 'Booked Slots', 'eduma' ); ?></div>
                <div class="value"><?php echo esc_html( $event->booked_quantity() ); ?></div>
            </li>
            <li class="event-cost">
                <div class="label"><?php esc_html_e( 'Cost', 'eduma' ); ?></div>
                <div class="value"><?php echo ( $event->get_price() ) ? wpems_format_price( $event->get_price() ) . esc_html__( '/Slot', 'eduma' ) : '<span class="free">' . esc_html__( 'Free', 'eduma' ) . '</span>'; ?></div>
            </li>
            <li>
				<?php if ( ( $event->get_price() && absint( $event->qty ) != 0 && 'tp-event-expired' !== $event->post->post_status ) ) : ?>
                    <div class="label"><?php esc_html_e( 'Quantity', 'eduma' ); ?></div>
                    <div class="value">
                        <input type="number" name="qty" value="1" min="1" id="event_register_qty"/>
                    </div>
				<?php else : ?>
                    <div class="label"><?php esc_html_e( 'Quantity', 'eduma' ); ?></div>
                    <div class="value">
                        <input disabled type="number" value="1" min="1" id="event_register_qty"/>
                        <input type="hidden" name="qty" value="1" min="1"/>
                    </div>
				<?php endif; ?>
            </li>
			<?php if ( intval( $event->get_price() ) > 0 ) : ?>
                <li class="event-payment">
                    <div class="label"><?php esc_html_e( 'Pay with', 'eduma' ); ?></div>
                    <div class="event_auth_payment_methods">
						<?php
						$payments = wpems_gateways_enable();

						if ( ! empty( $payments ) ) {
							$i = 0;
							foreach ( $payments as $id => $payment ) :
								?>
                                <input id="payment_method_<?php echo esc_attr( $id ); ?>" type="radio" name="payment_method" value="<?php echo esc_attr( $id ); ?>"<?php echo 0 === $i ? ' checked' : ''; ?>/>
                                <label for="payment_method_<?php echo esc_attr( $id ); ?>"><img width="115" height="50" src="<?php echo esc_attr( $payment->icon ); ?>"/></label>
								<?php
								$i ++;
							endforeach;
						}
						?>
                    </div>

                </li>
			<?php endif; ?>
        </ul>


        <!--Hide payment option when cost is 0-->

        <!--End hide payment option when cost is 0-->

        <div class="event_register_foot">
            <input type="hidden" name="event_id" value="<?php echo esc_attr( get_the_ID() ); ?>"/>
            <input type="hidden" name="action" value="event_auth_register"/>
			<?php wp_nonce_field( 'event_auth_register_nonce', 'event_auth_register_nonce' ); ?>
			<?php if ( 'tp-event-expired' === $event->post->post_status ) : ?>
                <button type="submit" disabled class="event_button_disable"><?php esc_html_e( 'Expired', 'eduma' ); ?></button>
			<?php elseif ( absint( $event->qty ) == 0 ) : ?>
                <button type="submit" disabled class="event_button_disable"><?php esc_html_e( 'Sold Out', 'eduma' ); ?></button>
			<?php else : ?>
				<?php if ( ! is_user_logged_in() ) { ?>
                    <a href="<?php echo esc_url( add_query_arg( 'redirect_to', get_permalink(), thim_get_login_page_url() ) ); ?>" class="event_register_submit event_auth_button"><?php esc_html_e( 'Login Now', 'coaching' ); ?></a>
                    <p></p>
                    <p class="login-notice">
						<?php echo esc_html__( 'You must login to our site to book this event!', 'coaching' ); ?>
                    </p>
				<?php } else { ?>
                    <button type="submit" class="event_register_submit event_auth_button"><?php esc_html_e( 'Book Now', 'coaching' ); ?></button>
				<?php } ?>
			<?php endif ?>

        </div>

    </form>

</div>
