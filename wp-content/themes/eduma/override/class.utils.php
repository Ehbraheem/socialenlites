<?php

abstract class Utils {
	
	public static function list_hooks( $hook = '' ) {
    global $wp_filter;

    if ( isset( $wp_filter[$hook]->callbacks ) ) {
        array_walk( $wp_filter[$hook]->callbacks, function( $callbacks, $priority ) use ( &$hooks ) {
            foreach ( $callbacks as $id => $callback )
                $hooks[] = array_merge( [ 'id' => $id, 'priority' => $priority ], $callback );
        });
    } else {
        return [];
    }

    foreach( $hooks as &$item ) {
        // skip if callback does not exist
        if ( !is_callable( $item['function'] ) ) continue;

        // function name as string or static class method eg. 'Foo::Bar'
        if ( is_string( $item['function'] ) ) {
            $ref = strpos( $item['function'], '::' ) ? new ReflectionClass( strstr( $item['function'], '::', true ) ) : new ReflectionFunction( $item['function'] );
            $item['file'] = $ref->getFileName();
            $item['line'] = get_class( $ref ) == 'ReflectionFunction'
                ? $ref->getStartLine()
                : $ref->getMethod( substr( $item['function'], strpos( $item['function'], '::' ) + 2 ) )->getStartLine();

            // array( object, method ), array( string object, method ), array( string object, string 'parent::method' )
        } elseif ( is_array( $item['function'] ) ) {

            $ref = new ReflectionClass( $item['function'][0] );

            // $item['function'][0] is a reference to existing object
            $item['function'] = array(
                is_object( $item['function'][0] ) ? get_class( $item['function'][0] ) : $item['function'][0],
                $item['function'][1]
            );
            $item['file'] = $ref->getFileName();
            $item['line'] = strpos( $item['function'][1], '::' )
                ? $ref->getParentClass()->getMethod( substr( $item['function'][1], strpos( $item['function'][1], '::' ) + 2 ) )->getStartLine()
                : $ref->getMethod( $item['function'][1] )->getStartLine();

            // closures
        } elseif ( is_callable( $item['function'] ) ) {
            $ref = new ReflectionFunction( $item['function'] );
            $item['function'] = get_class( $item['function'] );
            $item['file'] = $ref->getFileName();
            $item['line'] = $ref->getStartLine();

        }
    }

    return $hooks;
}

 public static function course_Level_dropdown($selected = 'not specified') {
        return '<option ' . ((strtolower($selected) == 'beginner') ? 'selected="selected"' : "") . ' value="beginner">Biginner</option>' .
                '<option ' . ((strtolower($selected) == 'intermediate') ? 'selected="selected"' : "") . ' value="intermediate">Intermediate</option>' .
                '<option ' . ((strtolower($selected) == 'expert') ? 'selected="selected"' : "") . ' value="expert">Expert</option>';
    }

    public static function subscription_type_dropdown($selected) {
        return '<option ' . (($selected == SwpmMembershipLevel::NO_EXPIRY) ? 'selected="selected"' : "") . ' value="' . SwpmMembershipLevel::NO_EXPIRY . '">No Expiry</option>' .
                '<option ' . (($selected == SwpmMembershipLevel::DAYS) ? 'selected="selected"' : "") . ' value="' . SwpmMembershipLevel::DAYS . '">Day(s)</option>' .
                '<option ' . (($selected == SwpmMembershipLevel::WEEKS) ? 'selected="selected"' : "") . ' value="' . SwpmMembershipLevel::WEEKS . '">Week(s)</option>' .
                '<option ' . (($selected == SwpmMembershipLevel::MONTHS) ? 'selected="selected"' : "") . ' value="' . SwpmMembershipLevel::MONTHS . '">Month(s)</option>' .
                '<option ' . (($selected == SwpmMembershipLevel::YEARS) ? 'selected="selected"' : "") . ' value="' . SwpmMembershipLevel::YEARS . '">Year(s)</option>' .
                '<option ' . (($selected == SwpmMembershipLevel::FIXED_DATE) ? 'selected="selected"' : "") . ' value="' . SwpmMembershipLevel::FIXED_DATE . '">Fixed Date</option>';
    }
	
	public static function numemployee_dropdown($selected) {
        $employeelistoptions = array( '1', '2 to 5', '6 to 10', '11 to 25','26 to 50','51 to 200','201 to 1,000','1,001 to 10,000','10,001 or more' );
        $output = '';
        for( $i=0; $i<count($employeelistoptions); $i++ ) {
            $output .= '<option ' . ($selected == $employeelistoptions[$i] ? ' selected="selected"' : '') . '>'
                . $employeelistoptions[$i]
                . '</option>';
        }

        return $output;
    }
	
	public static function companyrole_dropdown($selected) {
        $roleoptions = array( 'C-Level/SVP', 'VP/Director', 'Manager', 'Individual Contributor','Student/Intern','Other' );
        $output = '';
        for( $i=0; $i<count($roleoptions); $i++ ) {
            $output .= '<option '
                . ($selected == $roleoptions[$i] ? ' selected="selected"' : '' ) . '>'
                . $roleoptions[$i]
                . '</option>';
        }

        return $output;
    }
	
	public static function memberinterest_dropdown($selected) {
        $memberinterestoptions = array( 'Finance', 'Construction', 'Computing', 'Banking','Education','Health' );
        $output = '';
        for( $i=0; $i<count($memberinterestoptions); $i++ ) {
            $res = '';
            $arrList = (is_array($selected) ? $selected : array());

            foreach ($arrList as $item) {
                if($item == $memberinterestoptions[$i]){
                    $res = 'selected="selected"';
                    break;
                }
                else {
                    $res = '';
                }
            }
            $output .= '<option value="'
                . $memberinterestoptions[$i] . '" ' . $res . '>'
                . $memberinterestoptions[$i]
                . '</option>';
        }
        return $output;
	}

    public static function academicachievement_dropdown($selected)
    {
        $academicbackgroundoptions = array( 'High School Diploma', 'Associates', 'Bachelor', 'MBA','PHd','LLD', 'LLB' );
        $output = '';
        for( $i=0; $i<count($academicbackgroundoptions); $i++ ) {
            $res = '';
            $arrList = (is_array($selected) ? $selected : array());

            foreach ($arrList as $item) {
                if($item == $academicbackgroundoptions[$i]){
                    $res = 'selected="selected"';
                    break;
                }
                else {
                    $res = '';
                }
            }
            $output .= '<option value="'
                . $academicbackgroundoptions[$i] . '" ' . $res . '>'
                . $academicbackgroundoptions[$i]
                . '</option>';
        }
        return $output;
    }
	
	  public static function industry_dropdown($selected) {
		  $array = array(    
    "Agriculture & Forestry/Wildlife" => array("Extermination/Pest Control","Farming(Animal Production)","Farming(Crop Production)","Fishing/Hunting","Landscape Services","Lawn care Services","Other (Agriculture & Forestry/Wildlife)"),
	"Business & Information" => array("Consultant","Employment Office","Fundraisers","Going out of Business Sales","Marketing/Advertising","Non Profit Organization","Notary Public","Online Business","Other (Business & Information)","Publishing Services","Record Business","Retail Sales","Technology Services","Telemarketing","Travel Agency","Video Production"),
    "Construction/Utilities/Contracting" => array("AC & Heating","Architect","Building Construction","Building Inspection","Concrete Manufacturing","Contractor","Engineering/Drafting","Equipment Rental","Other (Construction/Utilities/Contracting)","Plumbing","Remodeling","Repair/Maintenance"),
    "Education" => array("Child Care Services","College/Universities","Cosmetology School","Elementary & Secondary Education","GED Certification","Other (Education)","Private School","Real Estate School","Technical School","Trade School","Tutoring Services","Vocational School"),
	"Finance & Insurance" => array("Accountant","Auditing","Bank/Credit Union","Bookkeeping","Cash Advances","Collection Agency","Insurance","Investor","Other (Finance & Insurance)","Pawn Brokers","Tax Preparation"),
	"Food & Hospitality" => array("Alcohol/Tobacco Sales","Alcoholic Beverage Manufacturing","Bakery","Caterer","Food/Beverage Manufacturing","Grocery/Convenience Store(Gas Station)","Grocery/Convenience Store(No Gas Station)","Hotels/Motels(Casino)","Hotels/Motels(No Casino)","Mobile Food Services","Other (Food & Hospitality)","Restaurant/Bar","Specialty Food(Fruit/Vegetables)","Specialty Food(Meat)","Specialty Food(Seafood)","Tobacco Product Manufacturing","Truck Stop","Vending Machine"),
    "Gaming" => array("Auctioneer","Boxing/Wrestling","Casino/Video Gaming","Other (Gaming)","Racetrack","Sports Agent"),
	"Health Services" => array("Acupuncturist","Athletic Trainer","Child/Youth Services","Chiropractic Office","Dentistry","Electrolysis","Embalmer","Emergency Medical Services","Emergency Medical Transportation","Hearing Aid Dealers","Home Health Services","Hospital","Massage Therapy","Medical Office","Mental Health Services","Non Emergency Medical Transportation","Optometry","Other (Health Services)","Pharmacy","Physical Therapy","Physicians Office","Radiology","Residential Care Facility","Speech/Occupational Therapy","Substance Abuse Services","Veterinary Medicine","Vocational Rehabilitation","Wholesale Drug Distribution"),
	"Motor Vehicle" => array("Automotive Part Sales","Car Wash/Detailing","Motor Vehicle Rental","Motor Vehicle Repair","New Motor Vehicle Sales","Other (Motor Vehicle)","Recreational Vehicle Sales","Used Motor Vehicle Sales"),
	"Natural Resources/Environmental" => array(" Conservation Organizations","Environmental Health","Land Surveying","Oil & Gas Distribution","Oil & Gas Extraction/Production","Other (Natural Resources/Environmental)","Pipeline","Water Well Drilling"),
	"Other" => array("Other(Business Type Not Listed)"),
	"Personal Services" => array("Animal Boarding","Barber Shop","Beauty Salon","Cemetery","Diet Center","Dry cleaning/Laundry","Entertainment/Party Rentals","Event Planning","Fitness Center","Florist","Funeral Director","Janitorial/Cleaning Services","Massage/Day Spa","Nail Salon","Other (Personal Services)","Personal Assistant","Photography","Tanning Salon"),
	"Real Estate & Housing" => array("Home Inspection","Interior Design","Manufactured Housing","Mortgage Company","Other (Real Estate & Housing)","Property Management","Real Estate Broker/Agent",
"Warehouse/Storage"),
	"Safety/Security & Legal" => array("Attorney","Bail Bonds","Court Reporter","Drug Screening","Locksmith","Other (Safety/Security & Legal)","Private Investigator","Security Guard","Security System Services"),
	"Transportation" => array("Air Transportation","Boat Services","Limousine Services","Other (Transportation)","Taxi Services","Towing","Truck Transportation(Fuel)","Truck Transportation(Non Fuel)")
	);
	$retVal = '';
	foreach ( $array as $key => &$value )
{
	$retVal .='<optgroup label="'.$key.'">';
         
    foreach($value as $arr)
	{
		 $retVal .='<option value="'.$arr.'" ' . ((strtolower($selected) == strtolower($arr)) ? 'selected="selected"' : "") . ' >'. $arr .'</option>';
	}
	$retVal .='</optgroup>';
}
	return $retVal;
         }
	
	

    // $subscript_period must be integer.
    public static function calculate_subscription_period_days($subcript_period, $subscription_duration_type) {
        if ($subscription_duration_type == SwpmMembershipLevel::NO_EXPIRY) {
            return 'noexpire';
        }
        if (!is_numeric($subcript_period)) {
            throw new Exception(" subcript_period parameter must be integer in SwpmUtils::calculate_subscription_period_days method");
        }
        switch (strtolower($subscription_duration_type)) {
            case SwpmMembershipLevel::DAYS:
                break;
            case SwpmMembershipLevel::WEEKS:
                $subcript_period = $subcript_period * 7;
                break;
            case SwpmMembershipLevel::MONTHS:
                $subcript_period = $subcript_period * 30;
                break;
            case SwpmMembershipLevel::YEARS:
                $subcript_period = $subcript_period * 365;
                break;
        }
        return $subcript_period;
    }

    public static function get_expiration_timestamp($user) {
        $permission = SwpmPermission::get_instance($user->membership_level);
        if (SwpmMembershipLevel::FIXED_DATE == $permission->get('subscription_duration_type')) {
            return strtotime($permission->get('subscription_period'));
        }
        $days = self::calculate_subscription_period_days($permission->get('subscription_period'), $permission->get('subscription_duration_type'));
        if ($days == 'noexpire') {
            return PHP_INT_MAX; // which is equivalent to
        }
        return strtotime($user->subscription_starts . ' ' . $days . ' days');
    }

    public static function is_subscription_expired($user) {
        $expiration_timestamp = SwpmUtils::get_expiration_timestamp($user);
        if($expiration_timestamp < time()){
            //Account expired.
            return true;
        }
        return false;        
    }

    /*
     * Returns a formatted expiry date string (of a member). This can be useful to echo the date value.
     */
    public static function get_formatted_expiry_date($start_date, $subscription_duration, $subscription_duration_type) {
        if ($subscription_duration_type == SwpmMembershipLevel::FIXED_DATE) { 
            //Membership will expire after a fixed date.
            return SwpmUtils::get_formatted_date_according_to_wp_settings($subscription_duration);
        }
        
        $expires = self::calculate_subscription_period_days($subscription_duration, $subscription_duration_type);
        if ($expires == 'noexpire') {
            //Membership is set to no expiry or until cancelled.
            return SwpmUtils::_('Never');
        }

        //Membership is set to a duration expiry settings.
        
        return date(get_option('date_format'), strtotime($start_date . ' ' . $expires . ' days'));
    }
    
    public static function gender_dropdown($selected = 'not specified') {
        return '<option ' . ((strtolower($selected) == 'male') ? 'selected="selected"' : "") . ' value="male">Male</option>' .
                '<option ' . ((strtolower($selected) == 'female') ? 'selected="selected"' : "") . ' value="female">Female</option>' .
                '<option ' . ((strtolower($selected) == 'not specified') ? 'selected="selected"' : "") . ' value="not specified">Not Specified</option>';
    }

    public static function get_account_state_options() {
        return array('active' => SwpmUtils::_('Active'),
            'inactive' => SwpmUtils::_('Inactive'),
            'pending' => SwpmUtils::_('Pending'),
            'expired' => SwpmUtils::_('Expired'),);
    }

    public static function account_state_dropdown($selected = 'active') {
        $options = self::get_account_state_options();
        $html = '';
        foreach ($options as $key => $value) {
            $html .= '<option ' . ((strtolower($selected) == $key) ? 'selected="selected"' : "") . '  value="' . $key . '"> ' . $value . '</option>';
        }
        return $html;
    }

    public static function membership_level_dropdown($selected = 0) {
        $options = '';
        global $wpdb;
        $query = "SELECT alias, id FROM " . $wpdb->prefix . "swpm_membership_tbl WHERE id != 1";
        $levels = $wpdb->get_results($query);
        foreach ($levels as $level) {
            $options .= '<option ' . ($selected == $level->id ? 'selected="selected"' : '') . ' value="' . $level->id . '" >' . $level->alias . '</option>';
        }
        return $options;
    }

    public static function get_all_membership_level_ids() {
        global $wpdb;
        $query = "SELECT id FROM " . $wpdb->prefix . "swpm_membership_tbl WHERE id != 1";
        return $wpdb->get_col($query);
    }
    
    public static function get_membership_level_row_by_id($level_id){
        global $wpdb;
        $query = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "swpm_membership_tbl WHERE id=%d", $level_id);
        $level_resultset = $wpdb->get_row($query);
        return $level_resultset;
    }
    
    public static function membership_level_id_exists($level_id){
        //Returns true if the specified membership level exists in the system. Returns false if the level has been deleted (or doesn't exist).
        $all_level_ids = SwpmUtils::get_all_membership_level_ids();
        if (in_array($level_id, $all_level_ids)) {
            //Valid level ID
            return true;
        } else {
            return false;
        }
    }
    
    public static function get_registration_link($for = 'all', $send_email = false, $member_id = '') {
        $members = array();
        global $wpdb;
        switch ($for) {
            case 'one':
                if (empty($member_id)) {
                    return array();
                }
                $query = $wpdb->prepare("SELECT * FROM  {$wpdb->prefix}swpm_members_tbl WHERE member_id =  %d", $member_id);
                $members = $wpdb->get_results($query);
                break;
            case 'all':
                $query = "SELECT * FROM  {$wpdb->prefix}swpm_members_tbl WHERE reg_code != '' ";
                $members = $wpdb->get_results($query);
                break;
        }
        $settings = SwpmSettings::get_instance();
        $separator = '?';
        $url = $settings->get_value('registration-page-url');
        if (strpos($url, '?') !== false) {
            $separator = '&';
        }
        $subject = $settings->get_value('reg-complete-mail-subject');
        if (empty($subject)) {
            $subject = "Please complete your registration";
        }
        $body = $settings->get_value('reg-complete-mail-body');
        if (empty($body)) {
            $body = "Please use the following link to complete your registration. \n {reg_link}";
        }
        $from_address = $settings->get_value('email-from');
        $links = array();
        foreach ($members as $member) {
            $reg_url = $url . $separator . 'member_id=' . $member->member_id . '&code=' . $member->reg_code;
            if (!empty($send_email) && empty($member->user_name)) {
                $tags = array("{first_name}", "{last_name}", "{reg_link}");
                $vals = array($member->first_name, $member->last_name, $reg_url);
                $body = html_entity_decode($body);
                $email_body = str_replace($tags, $vals, $body);
                $headers = 'From: ' . $from_address . "\r\n";
                $subject=apply_filters('swpm_email_complete_your_registration_subject',$subject);
                $email_body=apply_filters('swpm_email_complete_your_registration_body',$email_body);
                wp_mail($member->email, $subject, $email_body, $headers);
            }
            $links[] = $reg_url;
        }
        return $links;
    }

    public static function update_wp_user_Role($wp_user_id, $role) {
        $preserve_role = 'yes';
        if ($preserve_role) {
            return;
        }
        if (self::is_multisite_install()) {//MS install
            return; //TODO - don't do this for MS install
        }
        $caps = get_user_meta($wp_user_id, 'wp_capabilities', true);
        if (in_array('administrator', array_keys((array) $caps))) {
            return;
        }
        
        //wp_update_user() function will trigger the 'set_user_role' hook.
        wp_update_user(array('ID' => $wp_user_id, 'role' => $role));
        
        $roles = new WP_Roles();
        $level = $roles->roles[$role]['capabilities'];
        if (isset($level['level_10']) && $level['level_10']) {
            update_user_meta($wp_user_id, 'wp_user_level', 10);
            return;
        }
        if (isset($level['level_9']) && $level['level_9']) {
            update_user_meta($wp_user_id, 'wp_user_level', 9);
            return;
        }
        if (isset($level['level_8']) && $level['level_8']) {
            update_user_meta($wp_user_id, 'wp_user_level', 8);
            return;
        }
        if (isset($level['level_7']) && $level['level_7']) {
            update_user_meta($wp_user_id, 'wp_user_level', 7);
            return;
        }
        if (isset($level['level_6']) && $level['level_6']) {
            update_user_meta($wp_user_id, 'wp_user_level', 6);
            return;
        }
        if (isset($level['level_5']) && $level['level_5']) {
            update_user_meta($wp_user_id, 'wp_user_level', 5);
            return;
        }
        if (isset($level['level_4']) && $level['level_4']) {
            update_user_meta($wp_user_id, 'wp_user_level', 4);
            return;
        }
        if (isset($level['level_3']) && $level['level_3']) {
            update_user_meta($wp_user_id, 'wp_user_level', 3);
            return;
        }
        if (isset($level['level_2']) && $level['level_2']) {
            update_user_meta($wp_user_id, 'wp_user_level', 2);
            return;
        }
        if (isset($level['level_1']) && $level['level_1']) {
            update_user_meta($wp_user_id, 'wp_user_level', 1);
            return;
        }
        if (isset($level['level_0']) && $level['level_0']) {
            update_user_meta($wp_user_id, 'wp_user_level', 0);
            return;
        }
    }

    public static function update_wp_user($wp_user_name, $swpm_data) {
        $wp_user_info = array();
        if (isset($swpm_data['email'])) {
            $wp_user_info['user_email'] = $swpm_data['email'];
        }
        if (isset($swpm_data['first_name'])) {
            $wp_user_info['first_name'] = $swpm_data['first_name'];
        }
        if (isset($swpm_data['last_name'])) {
            $wp_user_info['last_name'] = $swpm_data['last_name'];
        }
        if (isset($swpm_data['plain_password'])) {
            $wp_user_info['user_pass'] = $swpm_data['plain_password'];
        }

        $wp_user = get_user_by('login', $wp_user_name);

        if ($wp_user) {
            $wp_user_info['ID'] = $wp_user->ID;
            return wp_update_user($wp_user_info);
        }
        return false;
    }

    public static function create_wp_user($wp_user_data) {
        
        //Check if the email belongs to an existing wp user account.
        $wp_user_id = email_exists($wp_user_data['user_email']);
        if ($wp_user_id) {
            //A wp user account exist with this email.
            
            //Check if the user has admin role.
            $admin_user = SwpmMemberUtils::wp_user_has_admin_role($wp_user_id);
            if($admin_user){
                //This email belongs to an admin user. Update is not allowed on admin users. Show error message then exit.
                $error_msg = '<p>This email address ('.$wp_user_data['user_email'].') belongs to an admin user. This email cannot be used to register a new account on this site.</p>';
                wp_die($error_msg);            
            }
        }

        //At this point 1) A WP User with this email doesn't exist. Or 2) The associated wp user doesn't have admin role
        //Lets create a new wp user record or attach the SWPM profile to an existing user accordingly.
        
        if (self::is_multisite_install()) {
            //WP Multi-Sit install
            global $blog_id;
            if ($wp_user_id) {
                //If user exists then just add him to current blog.
                add_existing_user_to_blog(array('user_id' => $wp_user_id, 'role' => 'subscriber'));
                return $wp_user_id;
            }
            $wp_user_id = wpmu_create_user($wp_user_data['user_login'], $wp_user_data['password'], $wp_user_data['user_email']);
            $role = 'subscriber'; //TODO - add user as a subscriber first. The subsequent update user role function to update the role to the correct one
            add_user_to_blog($blog_id, $wp_user_id, $role);
        } else {
            //WP Single site install
            if ($wp_user_id) {
                return $wp_user_id;
            }
            $wp_user_id = wp_create_user($wp_user_data['user_login'], $wp_user_data['password'], $wp_user_data['user_email']);
        }
        $wp_user_data['ID'] = $wp_user_id;
        wp_update_user($wp_user_data);//Core WP function. Updates the user info and role.

        return $wp_user_id;
    }

    public static function is_multisite_install() {
        if (function_exists('is_multisite') && is_multisite()) {
            return true;
        } else {
            return false;
        }
    }

    public static function _($msg) {
        return __($msg, 'swpm');
    }

    public static function e($msg) {
        _e($msg, 'swpm');
    }

    public static function is_admin() {
        //This function returns true if the current user has WordPress admin management permission (not to be mistaken with SWPM admin permission.
        
        //This function is NOT like the WordPress's is_admin() function which determins if we are on the admin end of the site.
        //TODO - rename this function to something like is_admin_user()
        return current_user_can('manage_options');
    }

    /* 
     * Formats the given date value according to the WP date format settings. This function is useful for displaying a human readable date value to the user.
     */
    public static function get_formatted_date_according_to_wp_settings($date){
        $date_format = get_option('date_format');
        if (empty($date_format)) {
            //WordPress's date form settings is not set. Lets set a default format.
            $date_format = 'Y-m-d';
        }

        $date_obj = new DateTime($date);
        $formatted_date = $date_obj->format($date_format);//Format the date value using date format settings
        return $formatted_date; 
    }
    
    public static function swpm_username_exists($user_name) {
        global $wpdb;
        $member_table = $wpdb->prefix . 'swpm_members_tbl';
        $query = $wpdb->prepare('SELECT member_id FROM ' . $member_table . ' WHERE user_name=%s', sanitize_user($user_name));
        return $wpdb->get_var($query);
    }

    public static function get_free_level() {
        $encrypted = filter_input(INPUT_POST, 'level_identifier');
        if (!empty($encrypted)) {
            return SwpmPermission::get_instance($encrypted)->get('id');
        }

        $is_free = SwpmSettings::get_instance()->get_value('enable-free-membership');
        $free_level = absint(SwpmSettings::get_instance()->get_value('free-membership-id'));

        return ($is_free) ? $free_level : null;
    }

    public static function is_paid_registration() {
        $member_id = filter_input(INPUT_GET, 'member_id', FILTER_SANITIZE_NUMBER_INT);
        $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
        if (!empty($member_id) && !empty($code)) {
            return true;
        }
        return false;
    }

    public static function get_paid_member_info() {
        $member_id = filter_input(INPUT_GET, 'member_id', FILTER_SANITIZE_NUMBER_INT);
        $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
        global $wpdb;
        if (!empty($member_id) && !empty($code)) {
            $query = 'SELECT * FROM ' . $wpdb->prefix . 'swpm_members_tbl WHERE member_id= %d AND reg_code=%s';
            $query = $wpdb->prepare($query, $member_id, $code);
            return $wpdb->get_row($query);
        }
        return null;
    }

    public static function get_incomplete_paid_member_info_by_ip() {
        global $wpdb;
        $user_ip = SwpmUtils::get_user_ip_address();
        if (!empty($user_ip)) {
            //Lets check if a payment has been confirmed from this user's IP and the profile needs to be completed (where username is empty).
            $username = '';
            $query = "SELECT * FROM " . $wpdb->prefix . "swpm_members_tbl WHERE last_accessed_from_ip=%s AND user_name=%s";
            $query = $wpdb->prepare($query, $user_ip, $username);
            $result = $wpdb->get_row($query);
            return $result;
        }
        return null;
    }

    public static function account_delete_confirmation_ui($msg = "") {
        ob_start();
        include(SIMPLE_WP_MEMBERSHIP_PATH . 'views/account_delete_warning.php');
        ob_get_flush();
        wp_die("", "", array('back_link' => true));
    }

    public static function delete_account_button() {
        $allow_account_deletion = SwpmSettings::get_instance()->get_value('allow-account-deletion');
        if (empty($allow_account_deletion)) {
            return "";
        }

        $account_delete_link = '<div class="swpm-profile-account-delete-section">';
        $account_delete_link .= '<a href="'.SIMPLE_WP_MEMBERSHIP_SITE_HOME_URL.'/?swpm_delete_account=1"><div class="swpm-account-delete-button">' . SwpmUtils::_("Delete Account") . '</div></a>';
        $account_delete_link .= '</div>';        
        return $account_delete_link;
    }

    public static function encrypt_password($plain_password) {
        include_once(ABSPATH . WPINC . '/class-phpass.php');
        $wp_hasher = new PasswordHash(8, TRUE);
        $password_hash = $wp_hasher->HashPassword(trim($plain_password));
        return $password_hash;
    }

    public static function get_restricted_image_url() {
        return SIMPLE_WP_MEMBERSHIP_URL . '/images/restricted-icon.png';
    }

    /*
     * Checks if the string exists in the array key value of the provided array. If it doesn't exist, it returns the first key element from the valid values.
     */

    public static function sanitize_value_by_array($val_to_check, $valid_values) {
        $keys = array_keys($valid_values);
        $keys = array_map('strtolower', $keys);
        if (in_array($val_to_check, $keys)) {
            return $val_to_check;
        }
        return reset($keys); //Return he first element from the valid values
    }

    public static function get_user_ip_address() {
        $user_ip = '';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $user_ip = $_SERVER['REMOTE_ADDR'];
        }

        if (strstr($user_ip, ',')) {
            $ip_values = explode(',', $user_ip);
            $user_ip = $ip_values['0'];
        }

        return apply_filters('swpm_get_user_ip_address', $user_ip);
    }
    
    public static function is_first_click_free(&$content){        
        $is_first_click = false;        
        $args = array($is_first_click, $content );
        $filtered = apply_filters('swpm_first_click_free', $args);
        list($is_first_click, $content) = $filtered;
        return $is_first_click;       
    }

    
}
