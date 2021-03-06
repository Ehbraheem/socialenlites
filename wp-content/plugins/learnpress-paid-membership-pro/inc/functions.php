<?php
/**
 * Custom functions
 */
defined( 'ABSPATH' ) || exit();
define( 'LP_PMPRO_TEMPLATE', learn_press_template_path() . '/addons/paid-membership-pro/' );

/**
 * Get template file for addon
 *
 * @param      $name
 * @param null $args
 */
function learn_press_pmpro_get_template ( $name, $args = null ) {
	if ( file_exists( learn_press_locate_template( $name, 'learnpress-paid-membership-pro', LP_PMPRO_TEMPLATE ) ) ) {
		learn_press_get_template( $name, $args, 'learnpress-paid-membership-pro/', get_template_directory() . '/' . LP_PMPRO_TEMPLATE );
	} else {
		learn_press_get_template( $name, $args, LP_PMPRO_TEMPLATE, LP_ADDON_PMPRO_PATH . '/templates/' );
	}
}

function learn_press_pmpro_locate_template ( $name ) {
	// Look in folder learnpress-paid-membership-pro in the theme first
	$file = learn_press_locate_template( $name, 'learnpress-paid-membership-pro', LP_PMPRO_TEMPLATE );

	// If template does not exists then look in learnpress/addons/paid-membership-pro in the theme
	if ( ! file_exists( $file ) ) {
		$file = learn_press_locate_template( $name, LP_PMPRO_TEMPLATE, LP_ADDON_PMPRO_PATH . '/templates/' );
	}

	return $file;
}

function lp_pmpro_query_course_by_level ( $level_id ) {
	global $learn_press_pmpro_cache;

	$level_id = intval( $level_id );

	if ( ! empty( $learn_press_pmpro_cache[ 'query_level_' . $level_id ] ) ) {
		return $learn_press_pmpro_cache[ 'query_level_' . $level_id ];
	}
	$post_type                                             = LP_COURSE_CPT;
	$args                                                  = array(
		'post_type'      => array( $post_type ),
		'post_status'    => array( 'publish' ),
		'posts_per_page' => - 1,
		'meta_query'     => array(
			array(
				'key'   => '_lp_pmpro_levels',
				'value' => $level_id,
			),
		),
	);
	$query  = new WP_Query( $args );
	$learn_press_pmpro_cache[ 'query_level_' . $level_id ] = $query;

	return $query;
}

function lp_pmpro_get_all_levels () {
	$pmpro_levels = pmpro_getAllLevels( false, true );
	$pmpro_levels = apply_filters( 'lp_pmpro_levels_array', $pmpro_levels );

	return $pmpro_levels;
}

function lp_pmpro_get_all_levels_id ( $pmpro_levels ) {
	if ( empty( $pmpro_levels ) ) {
		return array();
	}
	$return = array();
	foreach ( $pmpro_levels as $level ) {
		$return[] = $level->id;
	}

	return $return;
}

function lp_pmpro_list_courses ( $levels = null ) {

	global $current_user;
	$list_courses = array();

	if ( ! $levels ) {
		$levels = lp_pmpro_get_all_levels();
	}
	foreach ( $levels as $index => $level ) {
		$the_query = lp_pmpro_query_course_by_level( $level->id );
		if ( ! empty( $the_query->posts ) ) {
			foreach ( $the_query->posts as $key => $course ) {
				$list_courses[ $course->ID ]['id']   = $course->ID;
				$list_courses[ $course->ID ]['link'] = '<a href="' . get_the_permalink( $course->ID ) . '" >' . get_the_title( $course->ID ) . '</a>';
				if ( empty( $list_courses[ $course->ID ]['level'] ) ) {
					$list_courses[ $course->ID ]['level'] = array();
				}
				if ( ! in_array( $level->id, $list_courses[ $course->ID ]['level'] ) ) {
					$list_courses[ $course->ID ]['level'][] = $level->id;
				}
			}
		}

	}
	$list_courses = apply_filters( 'learn_press_pmpro_list_courses', $list_courses, $current_user, $levels );

	return $list_courses;
}

function learn_press_pmpro_check_require_template () {

	global $current_user, $post;
	$user_id        = get_current_user_id();
	$user           = learn_press_get_user( $user_id, true );
	$levels_page_id = pmpro_getOption( "levels_page_id" );
	$all_levels     = lp_pmpro_get_all_levels();
	$all_levels_id  = lp_pmpro_get_all_levels_id( $all_levels );
	$course         = learn_press_get_course( $post->ID );
	$levels         = lp_pmpro_get_all_levels();
	$list_courses   = lp_pmpro_list_courses( $levels );

	/**
	 * Return if user have purchased this course
	 */
	if ( $user->has_purchased_course( $post->ID ) ) {
		return false;
	}

	/**
	 * Return if page is not include any levels membership
	 */
	if ( empty( $levels_page_id ) ) {
		return false;
	}

	/**
	 * Check if this course not assign anyone membership level
	 */
	if ( empty( $list_courses[ $course->ID ] ) ) {
		return false;
	}

	/**
	 * Return if current user is buy this level membership of current page
	 */
	if ( $current_user->membership_levels ) {

		// List memberships level is accessed into this course
		$list_memberships_of_course = lp_pmpro_list_courses( $current_user->membership_levels );

		foreach ( $current_user->membership_levels as $level ) {
			if ( in_array( $level->ID, $list_memberships_of_course ) ) {
				return false;
			}
		}
	}

	/**
	 * Return if not exists level membership
	 */
	if ( empty( $all_levels ) ) {
		return false;
	}

	return array(
		'current_user'   => $current_user,
		'post'           => $post,
		'user_id'        => $user_id,
		'user'           => $user,
		'levels_page_id' => $levels_page_id,
		'all_levels'     => $all_levels,
		'all_levels_id'  => $all_levels_id,
		'course'         => $course,
		'levels'         => $levels,
		'list_courses'   => $list_courses
	);

}


/**
 * get learn press order from current user
 * @global type $wpdb
 * @param type $level_id
 * @param type $user_id
 * @return lp_order
 */
function learn_press_pmpro_get_order_ids_by_membership_level( $level_id = null, $user_id = null ) {
	global $wpdb;
	if ( !$user_id ) {
		$user_id = learn_press_get_current_user_id();
	}
	if ( !$level_id ) {
		$user_level = pmpro_getMembershipLevelForUser( $user_id );
		$level_id = $user_level->id;
	}
	
	$sql = 'SELECT 
				`po`.`id`
				, po.checkout_id
				,`pm`.`post_id`
			FROM
				`lp`.`'.$wpdb->prefix.'pmpro_membership_orders` AS `po`
					LEFT JOIN
				`'.$wpdb->prefix.'postmeta` AS `pm` ON `pm`.`meta_key` = "_pmpro_membership_order_id"
					AND `pm`.`meta_value` = `po`.`id`
			WHERE
				`po`.`user_id` = 3
					AND `po`.`membership_id` = 1
					AND `po`.`status` = "success"
			ORDER BY `timestamp` DESC
			LIMIT 1';
	$row = $wpdb->get_row($sql);
	return $row;
}

/**
 * get Course by Memberships level id
 * @global type $wpdb
 * @param int $level_id
 * @return array object
 */
function lp_pmpro_get_course_by_level_id ( $level_id ) {
	global $wpdb;
	$sql = $wpdb->prepare("SELECT 
						p.ID, CONCAT(p.ID,' - ', p.post_title) AS `title`
					FROM
						{$wpdb->posts} AS p
							INNER JOIN
						{$wpdb->postmeta} AS pm ON (p.ID = pm.post_id)
					WHERE
						1 = 1
							AND ((pm.meta_key = '_lp_pmpro_levels'
							AND pm.meta_value = %s))
							AND p.post_type = 'lp_course'
							AND ((p.post_status = 'publish'))
					GROUP BY p.ID
					ORDER BY p.post_date DESC", $level_id);
	$rows = $wpdb->get_results( $sql, OBJECT_K );
	return $rows;
}

/**
 * check user is able or not albe enroll course
 * @param type $course_id
 * @param type $user
 * @return boolean
 */
function learn_press_pmpro_user_can_enroll_course($course_id, $user = null){
	if( !$user ) {
		$user = learn_press_get_current_user();
	}
	if( !$user || !isset($user->id) ) {
		return false;
	}
	$course_levels = get_post_meta( $course_id,'_lp_pmpro_levels', false );
	$user_level = pmpro_getMembershipLevelForUser( $user->id );
	if( !$course_levels || empty( $course_levels ) || !$user_level || !isset( $user_level->id ) || !in_array( $user_level->id, $course_levels ) ) {
		return false;
	}
	return true;
}

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
/**
 * make user can enroll course
 */
#add_filter('learn_press_user_can_enroll_course', 'learn_press_pmpro_user_can_enroll_course_callback', 10, 3 );
function learn_press_pmpro_user_can_enroll_course_callback( $enrollable, $user, $course_id ){
	if(!$enrollable){
		$enrollable = learn_press_pmpro_user_can_enroll_course( $course_id, $user );
	}
	return $enrollable;
}


/**
 * without this add filter user cannot enroll course
 */
#add_filter( 'learn_press_is_free_course', 'learn_press_pmpro_is_free_course_callback', 10, 3 );
function learn_press_pmpro_is_free_course_callback( $is_free, $course ) {
	$user = learn_press_get_current_user();
	if($is_free){
		return $is_free;
	}
	$enrollable = learn_press_pmpro_user_can_enroll_course( $course->id, $user );
	if($enrollable){
		return true;
	}
	return false;
}


/**
 * over write
 */
add_filter( 'learn_press_course_price_html_free', 'learn_press_pmpro_course_price_html_free_callback', 10, 3);
function learn_press_pmpro_course_price_html_free_callback( $price_html, $course ) {
	$buy_through_membership = LP()->settings->get( 'buy_through_membership' );
	$course_levels = get_post_meta( $course->id,'_lp_pmpro_levels', false );
	if( $buy_through_membership == 'yes' && !empty($course_levels) ) {
		return '';
	}
	return $price_html;
}
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

/**
 * 
 * @param type $can_view
 * @param type $item_id
 * @param type $course_id
 * @param type $user_id
 * @return boolean
 */
function learn_press_pmpro_learn_press_user_can_view_item_callback( $can_view, $item_id, $course_id, $user_id ) {
	if ( $can_view ) {
		$user = learn_press_get_user( $user_id );
		$orders = $user->get_orders();
		if(  array_key_exists( $course_id, $orders)){
			$lp_pmpro_level = get_post_meta( $orders[$course_id]->ID, '_lp_pmpro_level', true );
			if( !$lp_pmpro_level ) {
				return $can_view;
			}
			$user_level = pmpro_getMembershipLevelForUser( $user_id );
			if( !$user_level || ( isset($user_level->ID ) && $lp_pmpro_level !== $user_level->ID ) ) {
				return false;
			}
		}
	}
	return $can_view;
}
add_filter( 'learn_press_user_can_view_item', 'learn_press_pmpro_learn_press_user_can_view_item_callback', 10, 4 );

/**
 * 
 * @param type $purchased
 * @param type $course_id
 * @param type $user_id
 * @return boolean
 */
function learn_press_pmpro_learn_press_user_has_purchased_course_filter_callback( $purchased, $course_id, $user_id ) {
	if(!$user_id) {
		return $purchased;
	}
	if ( $purchased ) {
		$course_levels = get_post_meta($course_id, '_lp_pmpro_levels');
		if(empty($course_levels)){
			return $purchased;
		}
		$user	= learn_press_get_user( $user_id );
		$orders = $user->get_orders();
		if( !array_key_exists( $course_id, $orders ) ) {
			return $purchased;
		}
		$lp_pmpro_level = get_post_meta( $orders[$course_id]->ID, '_lp_pmpro_level', true );
		if( !$lp_pmpro_level ) {
			return $purchased;
		}
		$user_level = pmpro_getMembershipLevelForUser( $user->id );
		if( !$user_level || ( isset($user_level->ID) && $lp_pmpro_level!== $user_level->ID ) ) {
			return false;
		}
	}
	return $purchased;
}
add_filter( 'learn_press_user_has_purchased_course', 'learn_press_pmpro_learn_press_user_has_purchased_course_filter_callback', 10, 4 );
