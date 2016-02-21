<?php

add_action( 'wp_enqueue_scripts', 'lightning_parent_theme_enqueue_styles' );
function lightning_parent_theme_enqueue_styles() {
    wp_enqueue_style( 'lightning-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'lightning-woo-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'lightning-style' )
    );

}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
