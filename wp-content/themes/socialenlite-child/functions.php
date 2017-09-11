<?php
function thim_child_enqueue_styles() {
	// Enqueue parent style
	wp_enqueue_style( 'thim-parent-style', get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'thim_child_enqueue_styles', 1001 );