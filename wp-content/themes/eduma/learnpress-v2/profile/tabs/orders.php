<?php
/**
 * Template for displaying user's orders
 *
 * @author  ThimPress
 * @package LearnPress/Template
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit();

$user_id = learn_press_get_current_user_id();
$page    = get_query_var( 'paged', 1 );
$limit   = 10;

if( !function_exists('_learn_press_get_user_profile_orders') ) {
	$orders = $user->get_orders();
}else{
	$orders = _learn_press_get_user_profile_orders( $user_id, $page, $limit );
}

if ( $orders ):
	if ( empty( $orders['rows'] ) ) {
		$orders['rows'] = array();
	}
	if ( $orders['rows'] ) :
		?>
		<table class="table-orders">
			<thead>
			<th class="order-number"><?php _e( 'Order', 'eduma' ); ?></th>
			<th><?php _e( 'Date', 'eduma' ); ?></th>
			<th><?php _e( 'Status', 'eduma' ); ?></th>
			<th><?php _e( 'Total', 'eduma' ); ?></th>
			<th><?php _e( 'Action', 'eduma' ); ?></th>
			</thead>
			<tbody>
			<?php foreach ( $orders['rows'] as $order ): $order = learn_press_get_order( $order ); ?>
				<tr>
					<td class="order-number"><?php echo $order->get_order_number(); ?></td>
					<td><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></td>
					<td>
						<?php echo $order->get_order_status(); ?>
						<?php
						if ( $order->has_status( 'pending' ) ) :
							printf( '(<small><a href="%s" class="%s">%s</a></small>)', $order->get_cancel_order_url(), 'cancel-order', __( 'Cancel', 'eduma' ) );
						endif;
						?>
					</td>
					<td><?php echo $order->get_formatted_order_total(); ?></td>
					<td>
						<?php
						$actions['view'] = array(
							'url'  => $order->get_view_order_url(),
							'text' => __( 'View', 'eduma' )
						);
						$actions         = apply_filters( 'learn_press_user_profile_order_actions', $actions, $order );

						foreach ( $actions as $slug => $option ) {
							printf( '<a href="%s">%s</a>', $option['url'], $option['text'] );
						}
						?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<?php
		learn_press_paging_nav( array(
			'num_pages' => $orders['num_pages'],
			'base'      => learn_press_user_profile_link( $user_id, LP()->settings->get( 'profile_endpoints.profile-orders' ) )
		) );
		?>

	<?php else: ?>
		<?php learn_press_display_message( __( 'You have not got any orders yet!', 'eduma' ) ); ?>
	<?php endif; ?>

<?php else: ?>
	<?php learn_press_display_message( __( 'You have not got any orders yet!', 'eduma' ) ); ?>
<?php endif; ?>
