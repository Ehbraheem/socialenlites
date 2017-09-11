<?php
/**
 * Created by PhpStorm.
 * User: DeeVexx
 * Date: 7/23/2017
 * Time: 3:52 PM
 * Template Name: SocialEnlites */
get_header(); ?>

<?php

include 'connection.php';
session_start();
$_SESSION['message']='';

if($_SERVER['REQUEST_METHOD']=='POST') {
    if ($_POST['acctype'] <> 'select') {
        if ($_POST['password'] == $_POST['confirmpassword']) {
            $firstname = $mysqli->real_escape_string($_POST['firstname']);
            $lastname = $mysqli->real_escape_string($_POST['lastname']);
            $username = $mysqli->real_escape_string($_POST['username']);
            $street = $mysqli->real_escape_string($_POST['street']);
            $town = $mysqli->real_escape_string($_POST['town']);
            $state = $mysqli->real_escape_string($_POST['state']);
            $email = $mysqli->real_escape_string($_POST['email']);
            $telephone = $mysqli->real_escape_string($_POST['telephone']);
            $account = $mysqli->real_escape_string($_POST['acctype']);
            $companyname = $mysqli->real_escape_string($_POST['companyname']);
            $password = md5($_POST['password']);
            $avatar_path = $mysqli->real_escape_string('images/avatars/' . $_FILES['avatar']['name']);

            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

                if (preg_match("!image!", $_FILES['avatar']['type'])) {
                    if (copy($_FILES['avatar']['tmp_name'], $avatar_path)) {
                        $_SESSION['username'] = $username;
                        $_SESSION['avatar'] = $avatar_path;
                        $UID = $username . time();

                        $sql = "INSERT INTO Users(UID, FirstName, LastName,username, password, Street, Town, State, email, telephone, account,company, avatar)"
                            . "VALUES ('$UID', '$firstname', '$lastname', '$username', '$password', '$street', '$town', '$state', '$email', '$telephone', '$account', '$companyname', '$avatar_path')";

                        if ($mysqli->query($sql) === true) {
                            $_SESSION['message'] = "Registration successful";

                            header("location: welcome.php");
                        } else {
                            $_SESSION['message'] = "ERROR!!!. account not created";
                        }
                    } else {
                        $_SESSION['message'] = "File upload failed";
                    }
                } else {
                    $_SESSION['message'] = "Please upload file of type GIF, JPG or PNG";
                }
            }
            else{
                $_SESSION['message'] = "Invalid email entered";
            }
        } else {
            $_SESSION['message'] = "Password did not match";
        }
    }
    else{
        $_SESSION['message']="Please select a account type from drop down";
    }
}
?>

    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php
                while ( have_posts() ) : the_post();

                    get_template_part( 'template-parts/page/content', 'page' );

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

                endwhile; // End of the loop.
                ?>

            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .wrap -->


<?php get_footer();
