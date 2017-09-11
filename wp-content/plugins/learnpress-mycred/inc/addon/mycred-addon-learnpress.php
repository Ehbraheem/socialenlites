<?php
/**
 * Addon: LearnPress
 * Addon URI: http://thimpress.com/learnpress
 * Version: 1.0
 * Description: Integrating with learning management system provided by LearnPress.
 * Author: ThimPress
 * Author URI: http://thimpress.com
 */

if ( !defined( 'myCRED_VERSION' ) ) exit;

/**
 * Register hooks LearnPress
 */
$root_path = dirname( dirname( __FILE__ ) );
require_once( $root_path . '/hooks/mycred-hook-learnpress-learner.php' );
require_once( $root_path . '/hooks/mycred-hook-learnpress-instructor.php' );

/**
 * Class myCRED_LearnPress_Module
 */
class myCRED_LearnPress_Module extends myCRED_Module {
	function __construct() {
		parent::__construct( 'myCRED_LearnPress_Module', array(
			'module_name' => 'learnpress',
			'option_id'   => '',
			'defaults'    => array(),
			'labels'      => array(
				'menu'       => '',
				'page_title' => ''
			),
			'register'    => false,
			'screen_id'   => '',
			'add_to_core' => true,
			'accordion'   => false,
			'menu_pos'    => 10
		) );
	}

	/**
	 * Setting Page
	 *
	 * @param $mycred
	 */
	public function after_general_settings( $mycred = null ) {
		?>
		<!--		<h4>-->
		<!--			<div class="icon icon-active"></div>--><?php //_e( 'LearnPress', 'mycred' ); ?><!--</h4>-->
		<!--		<div class="body" style="display:none;">-->
		<!---->
		<!--		</div>-->
		<?php

	}

}