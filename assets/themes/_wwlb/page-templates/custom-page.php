<?php
/**
 * 
 *
 *
 * Template Name: Custom Page
 *
 */

//	custom hero atts
$custom_hero = get_field('add_custom_hero_section');
$hero_type = get_field('hero_section_type');


add_filter( 'body_class', 'rp_page_custom_body_class' );
/**
 * Adds landing page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function rp_page_custom_body_class( $classes ) {

	$classes[] = 'rp-page';
    if ( is_front_page() ) $classes[] = 'nav-abs';

	//	add custom hero class
	global $custom_hero;
	if ( $custom_hero ) $classes[] = 'has-hero';

	return $classes;

}

//  remove post title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//  remove main wrapper
add_filter( 'genesis_markup_content', '__return_null' );


//  custom hero area
// if ( $custom_hero ) get_template_part( E_TEMPLATES . '-hero', $hero_type );

//	if ACF flexible content
// if ( have_rows( 'sections' ) ) get_template_part( E_TEMPLATE, 'acf-flexible' );


// Runs the Genesis loop.
genesis();