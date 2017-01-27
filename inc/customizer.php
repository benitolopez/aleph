<?php
/**
 * Aleph Theme Customizer
 *
 * @package Aleph
 */

/**
 * Add the theme configuration
 */
Aleph_Kirki::add_config( 'aleph', array(
	'option_type' => 'theme_mod',
	'capability'  => 'edit_theme_options',
) );

/**
 * Add the typography section
 */
Aleph_Kirki::add_section( 'typography', array(
	'title'      => esc_attr__( 'Typography', 'aleph' ),
	'priority'   => 20,
	'capability' => 'edit_theme_options',
) );

/**
 * Add the body-typography control
 */
Aleph_Kirki::add_field( 'aleph', array(
	'type'        => 'typography',
	'settings'    => 'body_typography',
	'label'       => esc_attr__( 'Body Typography', 'aleph' ),
	'description' => esc_attr__( 'Select the main typography options for your site.', 'aleph' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
		'font-family' => 'Open Sans',
		'variant'     => '400'
	),
	'output' => array(
		array(
			'element' => 'body',
		),
	),
) );

/**
 * Add the sidebar section
 */
Aleph_Kirki::add_section( 'sidebar', array(
	'title'      => esc_attr__( 'Sidebar', 'aleph' ),
	'priority'   => 21,
	'capability' => 'edit_theme_options',
) );

Aleph_Kirki::add_field( 'aleph', array(
	'type'        => 'select',
	'settings'    => 'site_layout',
	'label'       => __( 'Site Layout', 'aleph' ),
	'section'     => 'sidebar',
	'default'     => 'right-sidebar',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => array(
		'left-sidebar'  => esc_attr__( 'Left sidebar', 'aleph' ),
		'right-sidebar' => esc_attr__( 'Right sidebar', 'aleph' ),
		'no-sidebar'    => esc_attr__( 'No sidebar', 'aleph' ),
	),
) );
