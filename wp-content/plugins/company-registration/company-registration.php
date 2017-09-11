<?php
/*
Plugin Name: LMP Company Registration
Plugin URI: http://
Description: LMP Company Registration
Author: Christopher Pearson
Version: 1.1.1.1
Author URI: http://
Requires at least: 3.8
Tested up to: 4.8

Text Domain: Chris
Domain Path: /languages/
*/
/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;


class lmp_company_registration_form
{
    private $username;
    private $email;
    private $password;
    private $website;
    private $first_name;
    private $last_name;
    private $nickname;
    private $bio;

    function __construct()
    {
        add_shortcode('lmp_company_registration_form', array($this, 'shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'flat_ui_kit'));
    }


    public function registration_form()
    {

        ?>

        <form id="company-registration-form" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
            <div class="login-form">
                <div class="form-group">
                    <span >Username</span>
                    <input name="lmp_username" type="text" class="form-control login-field"
                           value="<?php echo(isset($_POST['lmp_username']) ? $_POST['lmp_username'] : null); ?>"
                           placeholder="Username" id="lmp_username" required/>
                    <label class="login-field-icon fui-user" for="lmp_username"></label>
                </div>

                <div class="form-group">
                    <span >Email</span>
                    <input name="lmp_email" type="email" class="form-control login-field"
                           value="<?php echo(isset($_POST['lmp_email']) ? $_POST['lmp_email'] : null); ?>"
                           placeholder="Email" id="lmp_email" required/>
                    <label class="login-field-icon fui-mail" for="lmp_email"></label>
                </div>

                <div class="form-group">
                    <span >Password</span>
                    <input name="lmp_password" type="password" class="form-control login-field"
                           value="<?php echo(isset($_POST['lmp_password']) ? $_POST['lmp_password'] : null); ?>"
                           placeholder="Password" id="lmp_password" required/>
                    <label class="login-field-icon fui-lock" for="lmp_password"></label>
                </div>

                <div class="form-group">
                    <span >Website</span>
                    <input name="lmp_website" type="text" class="form-control login-field"
                           value="<?php echo(isset($_POST['lmp_website']) ? $_POST['lmp_website'] : null); ?>"
                           placeholder="Website" id="reg-website"/>
                    <label class="login-field-icon fui-chat" for="lmp_website"></label>
                </div>

                <div class="form-group">
                    <span >First Name</span>
                    <input name="lmp_fname" type="text" class="form-control login-field"
                           value="<?php echo(isset($_POST['lmp_fname']) ? $_POST['lmp_fname'] : null); ?>"
                           placeholder="First Name" id="lmp_fname"/>
                    <label class="login-field-icon fui-user" for="lmp_fname"></label>
                </div>

                <div class="form-group">
                    <span >Last Name</span>
                    <input name="lmp_lname" type="text" class="form-control login-field"
                           value="<?php echo(isset($_POST['lmp_lname']) ? $_POST['lmp_lname'] : null); ?>"
                           placeholder="Last Name" id="lmp_lname"/>
                    <label class="login-field-icon fui-user" for="lmp_lname"></label>
                </div>

                <div class="form-group">
                    <span >Nick Name</span>
                    <input name="lmp_nickname" type="text" class="form-control login-field"
                           value="<?php echo(isset($_POST['lmp_nickname']) ? $_POST['lmp_nickname'] : null); ?>"
                           placeholder="Nickname" id="lmp_nickname"/>
                    <label class="login-field-icon fui-user" for="lmp_nickname"></label>
                </div>

                <div class="form-group">
                    <span >Company Name</span>
                    <input name="lmp_companyname" type="text" class="form-control login-field"
                           value="<?php echo(isset($_POST['lmp_companyname']) ? $_POST['lmp_companyname'] : null); ?>"
                           placeholder="Company" id="lmp_companyname"/>
                    <label class="login-field-icon fui-user" for="lmp_companyname"></label>
                </div>

                <div class="form-group">
                    <span >Bio</span>
                    <input name="lmp_bio" type="text" class="form-control login-field"
                           value="<?php echo(isset($_POST['lmp_bio']) ? $_POST['lmp_bio'] : null); ?>"
                           placeholder="About / Bio" id="lmp_bio"/>
                    <label class="login-field-icon fui-new" for="lmp_bio"></label>
                </div>

                <div>
                    <label for="lmp_numemployee">
                        <?php _e( 'How many employees work there?', 'learnpress-paid-membership-pro' ); ?>
                    </label>
                    <select id="lmp_numemployee" name ="lmp_numemployee" >
                        <option value="">- Please select -</option>
                        <?php  echo Utils::numemployee_dropdown((isset($_POST['lmp_numemployee']) ? $_POST['lmp_numemployee'] : '')); ?>
                    </select>
                </div>

                <div>
                    <label for="lmp_role">
                        <?php _e( 'What is your role?', 'learnpress-paid-membership-pro' ); ?>
                    </label>
                    <select id="lmp_role" name="lmp_role" >
                        <option value="">- Please Select -</option>
                        <?php echo Utils::companyrole_dropdown((isset($_POST['lmp_role']) ? $_POST['lmp_role'] : '')); ?>
                    </select>
                </div>
                <input id="lmp_usertype" name="lmp_usertype" type="text" style="display:none;" value="corporate"/>
                <input class="btn btn-primary btn-lg btn-block" type="submit" name="lmp_submit" value="Register"/>
        </form>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function(){
            var form = jQuery("#company-registration-form"),
            jQuerysuccessMsg = jQuery(".alert");
            jQuery.validator.addMethod("letters", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z\s]*$/);
            });
            form.validate({
            rules: {
            lmp_username: {
            required: true,
            minlength: 5,
            letters: true
            },
            lmp_email: {
            required: true,
            email: true
            }
            },
            messages: {
                lmp_username: "Please specify your name (only letters and spaces are allowed)",
                lmp_email: "Please specify a valid email address"
            },
            submitHandler: function() {
            successMsg.show();
            }
            });
            });

        </script>
        <?php
    }

    function validation()
    {

        if (empty($this->username) || empty($this->password) || empty($this->email)) {
            return new WP_Error('field', 'Required form field is missing');
        }

        if (strlen($this->username) < 4) {
            return new WP_Error('username_length', 'Username too short. At least 4 characters is required');
        }

        if (strlen($this->password) < 5) {
            return new WP_Error('password', 'Password length must be greater than 5');
        }

        if (!is_email($this->email)) {
            return new WP_Error('email_invalid', 'Email is not valid');
        }

        if (email_exists($this->email)) {
            return new WP_Error('email', 'Email Already in use');
        }

        if (!empty($website)) {
            if (!filter_var($this->website, FILTER_VALIDATE_URL)) {
                return new WP_Error('website', 'Website is not a valid URL');
            }
        }

        $details = array('Username' => $this->username,
            'First Name' => $this->first_name,
            'Last Name' => $this->last_name,
            'Nickname' => $this->nickname,
            'bio' => $this->bio
        );

        foreach ($details as $field => $detail) {
            if (!validate_username($detail)) {
                return new WP_Error('name_invalid', 'Sorry, the "' . $field . '" you entered is not valid');
            }
        }

    }

    function registration()
    {

        $userdata = array(
            'user_login' => esc_attr($this->username),
            'user_email' => esc_attr($this->email),
            'user_pass' => esc_attr($this->password),
            'user_url' => esc_attr($this->website),
            'first_name' => esc_attr($this->first_name),
            'last_name' => esc_attr($this->last_name),
            'nickname' => esc_attr($this->nickname),
            'description' => esc_attr($this->bio),
        );

        if (is_wp_error($this->validation())) {
            echo '<div style="margin-bottom: 6px" class="btn btn-block btn-lg btn-danger">';
            echo '<strong>' . $this->validation()->get_error_message() . '</strong>';
            echo '</div>';
        } else {
            error_log("attempt Registration!!");
            $register_user = wp_insert_user($userdata);
            error_log("Registration Done!!");
            if (!is_wp_error($register_user)) {

                echo '<div style="margin-bottom: 6px" class="btn btn-block btn-lg btn-danger">';
                echo '<strong>Registration complete. Goto <a href="' . wp_login_url() . '">login page</a></strong>';
                echo '</div>';
            } else {
                echo '<div style="margin-bottom: 6px" class="btn btn-block btn-lg btn-danger">';
                echo '<strong>' . $register_user->get_error_message() . '</strong>';
                echo '</div>';
            }
        }

    }

    function flat_ui_kit()
    {
        //wp_register_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', array('jquery'), 3.3, true);
        wp_register_script('jquery_validate_scripts', get_theme_file_uri( '/assets/js/jquery.validate.min.js' ) , array( 'jquery' ), THIM_THEME_VERSION, true );
        wp_enqueue_script('jquery_validate_scripts');
        wp_enqueue_script('bootstrap');
        wp_enqueue_style( 'custom-company-registration-css', THIM_URI . 'assets/css/custom-vc.css', array(), THIM_THEME_VERSION );


    }

    function shortcode()
    {

        ob_start();

        if (isset($_POST['lmp_submit'])) {
            $this->username = $_POST['lmp_username'];
            $this->email = $_POST['lmp_email'];
            $this->password = $_POST['lmp_password'];
            $this->website = $_POST['lmp_website'];
            $this->first_name = $_POST['lmp_fname'];
            $this->last_name = $_POST['lmp_lname'];
            $this->nickname = $_POST['lmp_nickname'];
            $this->bio = $_POST['lmp_bio'];

            $this->validation();
            $this->registration();
        }

        $this->registration_form();
        return ob_get_clean();
    }

}

new lmp_company_registration_form();
