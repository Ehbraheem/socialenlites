<ul class="nav navbar-nav">
	<?php
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'items_wrap'     => '%3$s'
		) );
	} else {
		wp_nav_menu( array(
			'theme_location' => '',
			'container'      => false,
			'items_wrap'     => '%3$s'
		) );
	}
	if ( is_active_sidebar( 'menu_right' ) ) {
		echo '<li class="menu-right"><ul>';
		dynamic_sidebar( 'menu_right' );
		echo '</ul></li>';
	}
	?>

</ul>

<?php
$login_mobile = get_theme_mod('thim_display_login_menu_mobile', true);
if ( $login_mobile ) {
	echo '<div class="thim-mobile-login">';
	if ( !is_user_logged_in() ) {
		echo '<div class="thim-link-login">
		<a href="' . esc_url( thim_get_register_url() ) . '">' . esc_html__( 'Register', 'eduma' ) . '</a>
		<a href="' . esc_url( thim_get_login_page_url() ) . '">' . esc_html__( 'Login', 'eduma' ) . '</a>
	</div>';
	} else {
		echo '<div class="thim-link-login">';
		if ( thim_plugin_active( 'learnpress/learnpress.php' ) ) {
			echo '<a class="profile" href="' . esc_url( learn_press_user_profile_link() ) . '">' . esc_html__( 'Profile', 'eduma' ) . '</a>';
		}
		echo '<a href="' . esc_url( wp_logout_url( thim_get_login_page_url() ) ) . '">' . esc_html__( 'Logout', 'eduma' ) . '</a>';
		echo '</div>';
	}
	echo '</div>';
}
