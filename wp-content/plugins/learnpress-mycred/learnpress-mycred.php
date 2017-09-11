<?php
/*
Plugin Name: LearnPress - myCred Integration
Plugin URI: http://thimpress.com/learnpress
Description: Running with the point management system - myCred
Author: ThimPress
Version: 2.0.1
Author URI: http://thimpress.com
Tags: learnpress, lms, myCred
Text Domain: learnpress
Domain Path: /languages/
*/

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
define( 'LP_ADDON_MYCRED_FILE', __FILE__ );
define( 'LP_ADDON_MYCRED_PATH', plugin_dir_path( __FILE__ ) );
define( 'LP_ADDON_MYCRED_URL', plugin_dir_url( __FILE__ ) );
define( 'LP_ADDON_MYCRED_VER', '2.0' );
define( 'LP_ADDON_MYCRED_REQUIRE_VER', '2.0' );
if ( defined( 'LP_ADDON_MYCRED_FILE' ) ) {

	class LP_Addon_myCRED {

		protected static $_instance = null;

		/**
		 * Store notice messages
		 *
		 * @var array messages
		 */
		protected static $_notices = array();

		public function __construct() {
			if ( did_action( 'learn_press_addon_mycred_loaded' ) ) {
				return;
			}
			$this->init_hooks();
			do_action( 'learn_press_addon_mycred_loaded', $this );
		}

		public function init_hooks() {
			add_filter( 'mycred_setup_addons', array( $this, 'register_addon' ) );
			add_filter( 'mycred_load_modules', array( $this, 'load_learnpress_cred_addon' ), 10, 2 );
			add_filter( 'mycred_setup_hooks', array( $this, 'register_hook_instructor' ) );
			add_filter( 'mycred_setup_hooks', array( $this, 'register_hook_learner' ) );
			add_action( 'mycred_admin_enqueue', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Register add on LearnPress
		 *
		 * @param $installed
		 *
		 * @return mixed
		 */
		public function register_addon( $installed ) {
			$installed['learnpress'] = array(
				'name'        => 'LearnPress',
				'description' => __( 'Integrating with learning management system provided by LearnPress.', 'learnpress' ),
				'addon_url'   => 'https://thimpress.com/product/mycred-add-on-for-learnpress/',
				'version'     => '1.1',
				'author'      => 'ThimPress',
				'author_url'  => 'http://thimpress.com',
//                'path'          => LP_ADDON_MYCRED_PATH . '/inc/addon/mycred-addon-learnpress.php',
				'screenshot'  => 'https://thimpress.com/wp-content/uploads/2015/07/myCRED.jpg'
			);
			return $installed;
		}

		public function load_learnpress_cred_addon( $modules, $point_types ) {
			$file = LP_ADDON_MYCRED_PATH . '/inc/addon/mycred-addon-learnpress.php';
			if ( file_exists( $file ) ) {
				require_once $file;
				$modules['solo']['learnpress'] = new myCRED_LearnPress_Module();
				$modules['solo']['learnpress']->load();
			}
			return $modules;
		}

		/**
		 * Register hook LearnPress for instructor
		 *
		 * @param $installed
		 *
		 * @return mixed
		 */
		public function register_hook_instructor( $installed ) {
			$installed['learnpress_instructor'] = array(
				'title'       => __( 'LearnPress: for instructors', 'learnpress' ),
				'description' => __( 'Award %_plural% to users who are teaching in LearnPress courses system.', 'learnpress' ),
				'callback'    => array( 'myCred_LearnPress_Instructor' )
			);
			return $installed;
		}

		/**
		 * Register hook LearnPress for learner
		 *
		 * @param $installed
		 *
		 * @return mixed
		 */
		public function register_hook_learner( $installed ) {
			$installed['learnpress_learner'] = array(
				'title'       => __( 'LearnPress: for learners', 'learnpress' ),
				'description' => __( 'Award %_plural% to users who are learning in LearnPress courses system.', 'learnpress' ),
				'callback'    => array( 'myCred_LearnPress_Learner' )
			);
			return $installed;
		}

		public function enqueue_scripts() {
			wp_enqueue_style(
				'lp-mycred',
				plugins_url( 'inc/scripts/learnpress.css', LP_ADDON_MYCRED_FILE )
			);
		}

		public static function instance() {
			if ( !self::$_instance ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * 'plugins_loaded' hook
		 *
		 * if LearnPress and myCRED plugins is install and activated
		 *
		 * initialize LP_Addon_myCRED class
		 */
		public static function plugins_loaded() {
			add_action( 'init', array( __CLASS__, 'load_text_domain' ) );

			if ( !class_exists( 'myCRED_Core' ) ) {
				self::$_notices['notice-warning'][] = sprintf( __( '<strong>myCRED Integration</strong> addon for <strong>LearnPress</strong> requires <a href="%s">myCRED</a> plugin is installed.', 'learnpress' ), 'https://wordpress.org/plugins/mycred/' );
			}

			if ( !defined( 'LEARNPRESS_VERSION' ) || ( version_compare( LEARNPRESS_VERSION, LP_ADDON_MYCRED_REQUIRE_VER, '<' ) ) ) {
				self::$_notices['notice-warning'][] = sprintf( __( '<strong>myCred Integration</strong> addon version %s requires <strong>LearnPress</strong> version %s or higher', 'learnpress' ), LP_ADDON_MYCRED_VER, LP_ADDON_MYCRED_REQUIRE_VER );
			}


			/**
			 * Add notice
			 */
			add_action( 'admin_notices', array( __CLASS__, 'admin_notice' ) );

			if ( empty( self::$_notices ) ) {
				self::instance();
			}
		}

		/**
		 * Print notices
		 *
		 * @since 1.1
		 */
		public static function admin_notice() {
			if ( empty( self::$_notices ) ) return;

			foreach ( self::$_notices as $type => $messages ) : foreach ( $messages as $message ) : ?>
				<div class="error <?php echo esc_attr( $type ) ?>">
					<p><?php echo wp_kses( $message,
							array( 'a'  => array(
								'href'   => array(),
								'target' => array(),
							), 'strong' => array() ) ) ?></p>
				</div>
			<?php endforeach; endforeach;
		}

		/**
		 * Load Plugin text domain
		 *
		 * @since 1.1
		 */
		public static function load_text_domain() {
			if ( function_exists( 'learn_press_load_plugin_text_domain' ) ) {
				learn_press_load_plugin_text_domain( LP_ADDON_MYCRED_PATH, true );
			}
		}

	}

}

/**
 * plugins_loaded init the plugin
 */
add_action( 'plugins_loaded', array( 'LP_Addon_myCRED', 'plugins_loaded' ) );
