<?php
/**
 * Template for displaying all success messages from queue
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !$messages ) {
	return;
}

?>

<?php foreach ( $messages as $message ) : ?>
	<div class="message message-success learn-press-message">
		<?php echo wp_kses_post( $message ); ?>
	</div>
<?php endforeach; ?>
