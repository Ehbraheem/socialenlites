<?php
/**
 * Form for editing basic information of user in profile page
 *
 * @author  ThimPress
 * @version 2.1.1
 * @package LearnPress/Templates
 */

defined( 'ABSPATH' ) || exit;
$lp_info = get_the_author_meta( 'lp_info', $user->user->data->ID );
			
      
$lp_info['lmp_memberinterest'] = get_user_meta( $user->user->data->ID, 'lmp_memberinterest',true );
$lp_info['lmp_memberlevel'] = get_user_meta( $user->user->data->ID, 'lmp_memberlevel',true );
$lp_info['lmp_position'] = get_user_meta( $user->user->data->ID, 'lmp_position',true );
$lp_info['lmp_company'] = get_user_meta( $user->user->data->ID, 'lmp_company',true );
$lp_info['lmp_mobile_phone'] = get_user_meta( $user->user->data->ID, 'lmp_mobile_phone' ,true);
$lp_info['lmp_office_phone'] = get_user_meta( $user->user->data->ID, 'lmp_office_phone',true );
$lp_info['lmp_academicbackground'] = get_user_meta( $user->user->data->ID, 'lmp_academicbackground',true );
$lp_info['lmp_usertype'] = get_user_meta( $user->user->data->ID, 'lmp_usertype',true );
$lp_info['lmp_schoolname'] = get_user_meta( $user->user->data->ID, 'lmp_schoolname',true );
$lp_info['lmp_schoolyear'] = get_user_meta( $user->user->data->ID, 'lmp_schoolyear',true );
$lp_info['lmp_industry'] = get_user_meta( $user->user->data->ID, 'lmp_industry',true );
$lp_info['lmp_numemployee'] = get_user_meta( $user->user->data->ID, 'lmp_numemployee',true );
$lp_info['lmp_role'] = get_user_meta( $user->user->data->ID, 'lmp_role',true );

?>

<ul class="lp-form-field-wrap">
  <?php do_action( 'learn_press_before_' . $section . '_edit_fields' ); ?>
  <li class="lp-form-field">
    <label class="lp-form-field-label">
      <?php _e( 'Biographical Info', 'eduma' ); ?>
    </label>
    <div class="lp-form-field-input">
      <p class="description">
        <?php _e( 'Share a little biographical information to fill out your profile. This may be shown publicly.', 'eduma' ); ?>
      </p>
      <textarea name="description" id="description" rows="5" cols="30">
        <?php echo esc_html( $user_info->description ); ?>
      </textarea>
    </div>
  </li>
  <li class="lp-form-field">
    <label class="lp-form-field-label">
      <?php _e( 'First Name', 'eduma' ); ?>
    </label>
    <div class="lp-form-field-input">
      <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $first_name ); ?>" class="regular-text">
    </div>
  </li>
  <li class="lp-form-field">
    <label class="lp-form-field-label">
      <?php _e( 'Last Name', 'eduma' ); ?>
    </label>
    <div class="lp-form-field-input">
      <input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $last_name ); ?>" class="regular-text">
    </div>
  </li>
  <li class="lp-form-field">
    Contact Info
    <div>
      <label for="lmp_office_phone">
        <?php _e( 'Office#', 'learnpress-paid-membership-pro' ); ?>
      </label>
      <input id="lmp_office_phone" name="lmp_office_phone" type="text" class="input" size="30"
             value="<?php echo isset($_POST['lmp_office_phone']) ? $_POST['lmp_office_phone'] : isset( $lp_info['lmp_office_phone'] ) ? $lp_info['lmp_office_phone'] : ''; ?>" />
    </div>
  </li>
  <li class="lp-form-field">
    <div>
      <label for="lmp_mobile_phone">
        <?php _e( 'Company', 'learnpress-paid-membership-pro' ); ?>
      </label>
      <input id="lmp_company" name="lmp_company" type="text" class="input" size="30"
             value="<?php echo isset($_POST['lmp_company']) ? $_POST['lmp_company'] : isset( $lp_info['lmp_company'] ) ? $lp_info['lmp_company'] : ''; ?>" />
    </div>
  </li>
  <li class="lp-form-field">
    <div>
      <label for="lmp_position">
        <?php _e( 'Position', 'learnpress-paid-membership-pro' ); ?>
      </label>
      <input id="lmp_position" name="lmp_position" type="text" class="input" size="30" value="<?php echo isset($_POST['lmp_position']) ? $_POST['lmp_position'] : isset( $lp_info['lmp_position'] ) ? $lp_info['lmp_position'] : ''; ?>" />
    </div>
  </li>
  <li class="lp-form-field">
    <p>
      <strong>
        User Level: <strong>
                        </p>
    <div>
      <select id="lmp_memberlevel" name="lmp_memberlevel">
        <option value="please_select">Select Current Level</option>
        <?php echo Utils::course_Level_dropdown(isset($_POST['lmp_memberlevel']) ? $_POST['lmp_memberlevel'] : isset( $lp_info['lmp_memberlevel'] ) ? $lp_info['lmp_memberlevel'] : ''); ?>
      </select>
    </div>
  </li>
  <li class="lp-form-field">
    <div>
      <label for="lmp_memberinterest">Interests</label>
      <select id="lmp_memberinterest[]" name="lmp_memberinterest[]" multiple="multiple">
        <?php echo Utils::memberinterest_dropdown(isset($_POST['lmp_memberinterest']) ? $_POST['lmp_memberinterest'] : (isset( $lp_info['lmp_memberinterest'] ) ? $lp_info['lmp_memberinterest'] : array()));
 ?>        
      </select>
    </div>
  </li>
  <li class="lp-form-field">
    <label class="lp-form-field-label">
      <?php _e( 'Nickname', 'eduma' ); ?>
    </label>
    <div class="lp-form-field-input">
      <input type="text" name="nickname" id="nickname" value="<?php echo esc_attr( $user_info->nickname ) ?>" class="regular-text" />
    </div>
  </li>
  <li class="lp-form-field">
    <label class="lp-form-field-label">
      <?php _e( 'Display name publicly as', 'eduma' ); ?>
    </label>
    <div class="lp-form-field-input">
      <select name="display_name" id="display_name">
        <?php
				$public_display = learn_press_get_display_name_publicly( $user_info );
				foreach ( $public_display as $id => $item ) {
					?>
        <option
          <?php selected( $user_info->display_name, $item ); ?>><?php echo $item; ?>
        </option>
        <?php
				}
				?>
      </select>
    </div>
  </li>
  <li class="lp-form-field">
    <label class="lp-form-field-label">
      <?php _e( 'User Type', 'eduma' ); ?>
    </label>

    <div >
      Student <input type="radio" name="lmp_usertype"
<?php echo isset($_POST['lmp_usertype']) ? ($_POST['lmp_usertype'] == 'student' ? 'checked' : '') : isset( $lp_info['lmp_usertype'] ) ? ($lp_info['lmp_usertype'] == 'student' ? 'checked' : '') : ''; ?>
      value="student">
      Business Owner  <input type="radio" name="lmp_usertype"
<?php echo isset($_POST['lmp_usertype']) ? ($_POST['lmp_usertype'] == 'businessowner' ? 'checked' : '') : isset( $lp_info['lmp_usertype'] ) ? ($lp_info['lmp_usertype'] == 'businessowner' ? 'checked' : '') : '';?>
      value="businessowner">
    </div>
  </li>

  <li class="lp-form-field dvStudent">
    <div>
      <label for="lmp_schoolname">
        <?php _e( 'School Name', 'learnpress-paid-membership-pro' ); ?>
      </label>
      <input id="lmp_schoolname" name="lmp_schoolname" type="text" class="input" size="30" value="<?php echo isset($_POST['lmp_schoolname']) ? $_POST['lmp_schoolname'] : isset( $lp_info['lmp_schoolname'] ) ? $lp_info['lmp_schoolname'] : ''; ?>" />
    </div>
  </li>
  <li class="lp-form-field dvStudent">
    <div>
      <label for="lmp_schoolyear">
        <?php _e( 'schoolyear', 'learnpress-paid-membership-pro' ); ?>
      </label>
      <input id="lmp_schoolyear" name="lmp_schoolyear" type="text" class="input" size="30" value="<?php echo isset($_POST['lmp_schoolyear']) ? $_POST['lmp_schoolyear'] : isset( $lp_info['lmp_schoolyear'] ) ? $lp_info['lmp_schoolyear'] : ''; ?>" />
    </div>
  </li>
  
  <li class="lp-form-field dvBusinessOwner">
    <div>
      <label for="lmp_industry">
        <?php _e( 'Industry', 'learnpress-paid-membership-pro' ); ?>
      </label>
      <select id="lmp_industry" name="lmp_industry">
        <option value="please_select">Select Current Industry</option>
        <?php echo Utils::industry_dropdown(isset($_POST['lmp_industry']) ? $_POST['lmp_industry'] : isset( $lp_info['lmp_industry'] ) ? $lp_info['lmp_industry'] : ''); ?>
      </select>      
    </div>
  </li>

  <li class="lp-form-field dvBusinessOwner">
    <div>
      <label for="lmp_numemployee">
        <?php _e( 'How many employees work there?', 'learnpress-paid-membership-pro' ); ?>
      </label>
      <select id="lmp_numemployee" name ="lmp_numemployee" >
        <option value="">- Please select -</option>
        <?php  echo Utils::numemployee_dropdown((isset($_POST['lmp_numemployee']) ? $_POST['lmp_numemployee'] : (isset( $lp_info['lmp_numemployee'] ) ? $lp_info['lmp_numemployee'] : '') )); ?>
      </select>
    </div>
  </li>

  <li class="lp-form-field dvBusinessOwner">
    <div>
      <label for="lmp_role">
        <?php _e( 'What is your role?', 'learnpress-paid-membership-pro' ); ?>
      </label>
      <select id="lmp_role" name="lmp_role" >
        <option value="">- Please Select -</option>
        <?php  echo Utils::companyrole_dropdown((isset($_POST['lmp_role']) ? $_POST['lmp_role'] : (isset( $lp_info['lmp_role'] ) ? $lp_info['lmp_role'] : ''))); 
       ?>
      </select>
    </div>
  </li>
  <li class="lp-form-field dvBusinessOwner">
    <div>
      <label for="lmp_academicbackgroung">
        <?php _e( 'Academic Background', 'learnpress-paid-membership-pro' ); ?>
      </label>
      <select id="lmp_academicbackground[]" name="lmp_academicbackground[]" multiple="multiple">
        <?php echo Utils::academicachievement_dropdown(isset($_POST['lmp_academicbackground']) ? $_POST['lmp_academicbackground'] : (isset( $lp_info['lmp_academicbackground'] ) ? $lp_info['lmp_academicbackground'] : array())); ?>
      </select>

    </div>
  </li>

  <li class="lp-form-field">
    <label class="lp-form-field-label">
      <?php _e( 'Facebook', 'eduma' ); ?>
    </label>
    <div class="lp-form-field-input">
      <input type="text" name="lp_info[facebook]" id="facebook" value="<?php echo isset( $lp_info['facebook'] ) ? $lp_info['facebook'] : ''; ?>" class="regular-text">
    </div>
  </li>
  <li class="lp-form-field">
    <label class="lp-form-field-label">
      <?php _e( 'Twitter', 'eduma' ); ?>
    </label>
    <div class="lp-form-field-input">
      <input type="text" name="lp_info[twitter]" id="twitter" value="<?php echo isset( $lp_info['twitter'] ) ? $lp_info['twitter'] : ''; ?>" class="regular-text">
    </div>
  </li>
  <li class="lp-form-field">
    <label class="lp-form-field-label">
      <?php _e( 'Google Plus', 'eduma' ); ?>
    </label>
    <div class="lp-form-field-input">
      <input type="text" name="lp_info[google]" id="google" value="<?php echo isset( $lp_info['google'] ) ? $lp_info['google'] : ''; ?>" class="regular-text">
    </div>
  </li>
  <li class="lp-form-field">
    <label class="lp-form-field-label">
      <?php _e( 'LinkedIn', 'eduma' ); ?>
    </label>
    <div class="lp-form-field-input">
      <input type="text" name="lp_info[linkedin]" id="linkedin" value="<?php echo isset( $lp_info['linkedin'] ) ? $lp_info['linkedin'] : ''; ?>" class="regular-text">
    </div>
  </li>
  <li class="lp-form-field">
    <label class="lp-form-field-label">
      <?php _e( 'Youtube', 'eduma' ); ?>
    </label>
    <div class="lp-form-field-input">
      <input type="text" name="lp_info[youtube]" id="youtube" value="<?php echo isset( $lp_info['youtube'] ) ? $lp_info['youtube'] : ''; ?>" class="regular-text">
    </div>
  </li>
  <?php do_action( 'learn_press_after_' . $section . '_edit_fields' ); ?>

  <script type="text/javascript">
    jQuery(document).ready(function ()
    {

    if(jQuery("input[name='lmp_usertype']:checked").val() !== undefined)
    {
    if(jQuery("input[name='lmp_usertype']:checked").val()=="student")
    {
    jQuery('.dvStudent').show();
    jQuery('.dvBusinessOwner').hide();
    }
    else
    if(jQuery("input[name='lmp_usertype']:checked").val() == "businessowner")
    {
    jQuery('.dvStudent').hide();
    jQuery('.dvBusinessOwner').show();
    }
    else
    {
    jQuery('.dvStudent').hide();
    jQuery('.dvBusinessOwner').hide();
    }
    }
    else
    {
    jQuery('.dvStudent').hide();
    jQuery('.dvBusinessOwner').hide();
    }

    jQuery("input[name='lmp_usertype']").change(radioValueChanged);
    })

    function radioValueChanged()
    {
    radioValue = jQuery(this).val();

    if(jQuery(this).is(":checked") && radioValue == "student")
    {
    jQuery('.dvStudent').show();
    jQuery('.dvBusinessOwner').hide();
    }
    else if(jQuery(this).is(":checked") && radioValue == "businessowner")
    {
    jQuery('.dvBusinessOwner').show();
    jQuery('.dvStudent').hide();
    }
    }
  </script>
</ul>