<?php
/*
Plugin Name: Easy Scroll Progress Indicator
Plugin URI:  https://www.adhityar.com/plugins/easy-scroll-progress-indicator
Description: Reading page scroll progress indicator bar
Version:     1.0.1
Author:      Adhitya
Author URI:  https://profile.wordpress.org/adhitya03
Text Domain: espi
License:     GPL2

Easy Scroll Progress Indicator is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Easy Scroll Progress Indicator is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Easy Scroll Progress Indicator. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function espi_cutomizer( $wp_customize ) {

	if ( ! isset( $wp_customize ) ) {
		return;
	}

	$wp_customize->add_section( 'espi-section' , array(
		'title' => esc_html__('Scroll Progress Indicator ', 'espi' ),
		'priority' => 160
	) );

	$wp_customize-> add_setting( 'espi-background-color-setting', array(
		'type' => 'theme_mod',
		'default' => '#000',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'espi-color-control',
			array(
				'label' => esc_html__( 'Scroll indicator color', 'espi' ),
				'section' => 'espi-section',
				'settings' => 'espi-background-color-setting'
			)
		)
	);

	$wp_customize-> add_setting( 'espi-size-setting', array(
		'type' => 'theme_mod',
		'default' => 5,
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control(
		'espi-size-control',
		array(
			'label' => esc_html__( 'Scroll indicator size in pixel', 'espi' ),
			'section' => 'espi-section',
			'settings' => 'espi-size-setting',
			'type' => 'number'
		)
	);

	//select sanitization function
	function espi_sanitize_select( $input, $setting ){

		//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
		$input = sanitize_key($input);

		//get the list of possible select options
		$choices = array( 'top', 'bottom', 'left', 'right' );

		//return input if valid or return default option
		return ( in_array( $input, $choices ) ? $input : $setting->default );

	}

	$wp_customize-> add_setting( 'espi-position-setting', array(
		'type' => 'theme_mod',
		'default' => 'top',
		'sanitize_callback' => 'espi_sanitize_select'
	) );

	$wp_customize->add_control(
		'espi-position-control',
		array(
			'label' => esc_html__( 'Scroll indicator position', 'espi' ),
			'section' => 'espi-section',
			'settings' => 'espi-position-setting',
			'type' => 'select',
			'choices' => array(
				'top' => esc_html__( 'Top', 'espi' ),
				'bottom' => esc_html__( 'Bottom', 'espi' ),
				'left' => esc_html__( 'Left', 'espi' ),
				'right' => esc_html__( 'Right', 'espi' )
			)
		)
	);
}
add_action( 'customize_register', 'espi_cutomizer' );

function espi_indicator(){
	$indicator_progress = '<div id="espi-indicator-progress"></div>';
	echo $indicator_progress;
}
add_action( 'wp_body_open', 'espi_indicator' );

function espi_indicator_style(){
	$espi_background_color = esc_html( get_theme_mod('espi-background-color-setting') );
	$espi_size = esc_html( get_theme_mod('espi-size-setting') );
	$espi_position = get_theme_mod('espi-position-setting');
	if( $espi_position == 'top' ){
		$espi_horizontal_position = 'top: 0;';
		$espi_vertical_position = 'left: 0;';
		$espi_WidthorHeight = 'width';
	}elseif( $espi_position == 'bottom' ){
		$espi_horizontal_position = 'bottom: 0;';
		$espi_vertical_position = 'left: 0;';
		$espi_WidthorHeight = 'width';
	}elseif( $espi_position == 'left' ){
		$espi_horizontal_position = 'top: 0;';
		$espi_vertical_position = 'left: 0;';
		$espi_WidthorHeight = 'height';
	}else{
		$espi_horizontal_position = 'top: 0;';
		$espi_vertical_position = 'right: 0;';
		$espi_WidthorHeight = 'height';
	}

	$espi_style = '#espi-indicator-progress{position: fixed; '.$espi_horizontal_position.' '.$espi_vertical_position.' background-color: '.$espi_background_color.'; padding: '.$espi_size.'px; z-index: 9;}';
	wp_register_style( 'espi_indicator_style', false );
	wp_enqueue_style( 'espi_indicator_style' );
	wp_add_inline_style( 'espi_indicator_style', $espi_style );

	$espi_script = "jQuery(window).scroll(function(){
        var scroll = jQuery(window).scrollTop(),
            dh = jQuery(document).height(),
            wh = jQuery(document).width();
        value = ( scroll / (dh-wh)) * 100;
        jQuery('#espi-indicator-progress').css( '$espi_WidthorHeight' , value + '%')
    })";

	wp_register_script( 'espi_indicator_script', false);
	wp_enqueue_script( 'espi_indicator_script', false, array('jquery'), '1.0.0', true );
	wp_add_inline_script( 'espi_indicator_script', $espi_script);
}
add_action( 'wp_enqueue_scripts', 'espi_indicator_style' );
?>