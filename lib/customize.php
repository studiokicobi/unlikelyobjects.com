<?php
/**
 * Adds the Customizer additions to the UO-custom Theme.
 *
 */

add_action( 'customize_register', 'uo-custom_customizer_register' );
/**
 * Registers settings and controls with the Customizer.
 *
 * @since 2.2.3
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function uo-custom_customizer_register( $wp_customize ) {

	$wp_customize->add_setting(
		'uo-custom_link_color',
		array(
			'default'           => uo-custom_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'uo-custom_link_color',
			array(
				'description' => __( 'Change the color of post info links, hover color of linked titles, hover color of menu items, and more.', 'uo-custom' ),
				'label'       => __( 'Link Color', 'uo-custom' ),
				'section'     => 'colors',
				'settings'    => 'uo-custom_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'uo-custom_accent_color',
		array(
			'default'           => uo-custom_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'uo-custom_accent_color',
			array(
				'description' => __( 'Change the default hovers color for button.', 'uo-custom' ),
				'label'       => __( 'Accent Color', 'uo-custom' ),
				'section'     => 'colors',
				'settings'    => 'uo-custom_accent_color',
			)
		)
	);

	$wp_customize->add_setting(
		'uo-custom_logo_width',
		array(
			'default'           => 350,
			'sanitize_callback' => 'absint',
		)
	);

	// Add a control for the logo size.
	$wp_customize->add_control(
		'uo-custom_logo_width',
		array(
			'label'       => __( 'Logo Width', 'uo-custom' ),
			'description' => __( 'The maximum width of the logo in pixels.', 'uo-custom' ),
			'priority'    => 9,
			'section'     => 'title_tagline',
			'settings'    => 'uo-custom_logo_width',
			'type'        => 'number',
			'input_attrs' => array(
				'min' => 100,
			),

		)
	);

}
