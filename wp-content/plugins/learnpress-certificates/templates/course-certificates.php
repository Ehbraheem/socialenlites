<?php
/**
 * Displaying the certs in user's profile
 *
 * @author ThimPress
 */

!defined( 'ABSPATH' ) && exit();

if ( sizeof( $certificates ) == 0 ) {
	if ( ( $message = apply_filters( 'learn_press_user_profile_no_certificates', __( 'You have not received any certificates yet!', 'learnpress-certificates' ) ) ) !== false ) {
		learn_press_display_message( $message );
	}
	return;
}
?>
<ul class="learn-press-user-profile-certs">
	<?php foreach ( $certificates as $cert ): ?>
		<?php learn_press_certificates_template( 'loop-cert.php', array( 'cert' => $cert ) ); ?>
	<?php endforeach; ?>
</ul>
