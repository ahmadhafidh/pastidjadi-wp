<?php
/**
 * AMP WP Core Customizer Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @category 	Core
 * @package 	Amp_WP/Functions
 * @version     1.0.0
 * @author      Pixelative <mohsin@pixelative.co>
 * @copyright   Copyright (c) 2018, Pixelative
 */

// Exit if accessed directly.
if( !defined( 'ABSPATH' ) ) { exit; }

if( !function_exists( 'amp_wp_get_default_theme_setting' ) ) :
    function amp_wp_get_default_theme_setting( $setting_id, $setting_index = '' ) {
        $settings = array(
			
            // Header
            'logo' => array(
                'height' => 40,
                'width' => 230,
                'flex-height' => false,
                'flex-width' => true,
            ),
            'sidebar-logo' => array(
                'height' => 150,
                'width' => 150,
                'flex-height' => true,
                'flex-width' => true,
            ),
            'amp-wp-header-logo-img'				=> '',
            'amp-wp-header-logo-text'				=> '',
			
			'amp-wp-header-preset-options'			=> 'logo-left-simple',
			'amp-wp-header-height'					=> '52',
			'amp-wp-header-text-color'				=> '#ffffff',
			'amp-wp-header-background-color'		=> '#000000',

            // Sidebar Window
            'amp-wp-sidebar-logo-text'				=> '',
            'amp-wp-sidebar-logo-img'				=> '',

            // Archive Listing
            'amp-wp-archive-listing'				=> '',

            // Posts
            'amp-wp-post-show-thumbnail'			=> '',
            'amp-wp-post-show-comment'				=> '',
            'amp-wp-post-show-related'				=> '', // Switch
            'amp-wp-post-related-count'				=> '',
            'amp-wp-post-related-algorithm'			=> '',
            'amp-wp-post-social-share-show'			=> '',
            'amp-wp-post-social-share-count'		=> '',
            
            'amp-wp-post-social-share-link-format'	=> '',
            'amp-wp-post-social-share'				=> array(
                'facebook'    => 1,
                'twitter'     => 1,
                'reddit'      => 1,
                'google_plus' => 1,
                'email'       => 1,
                'pinterest'   => 1,
                'linkedin'    => 1,
                'tumblr'      => 1,
                'telegram'    => 1,
                'vk'          => 1,
                'whatsapp'    => 1,
                'stumbleupon' => 1,
                'digg'        => 1,
            ),

            // Colors
            'amp-wp-color-theme'                      => '#e53935',
			'amp-wp-color-text'                       => '#333333',
            'amp-wp-color-bg'                         => '#ffffff',
            'amp-wp-color-footer-nav-bg'              => '#e53935',
            'amp-wp-color-footer-bg'                  => '#cd2a27',

            // Custom CSS Code
            'amp-wp-additional-css'                   => '',

            // Custom HTML Code
            'amp-wp-code-head'                        => '',
            'amp-wp-code-body-start'                  => '',
            'amp-wp-code-body-stop'                   => '',
        );
        if( $setting_index ) {
            if( isset( $settings[ $setting_id ][ $setting_index ] ) ) {
                return $settings[ $setting_id ][ $setting_index ];
            }
        } else {
            if( isset( $settings[ $setting_id ] ) ) {
                return $settings[ $setting_id ];
            }
        }
    }
endif;

if( !function_exists( 'amp_wp_is_customize_preview' ) ) :
    /**
     * Handy Function Customizer Preview State for Current Page
     *
     * @version 1.0.0
     * @since   1.0.0
     *
     * @return bool
     */
    function amp_wp_is_customize_preview() {
        static $is_customizer;
        if( is_null( $is_customizer ) ) {
            $is_customizer = is_customize_preview();
        }
        return $is_customizer;
    }
endif;

if( !function_exists( 'amp_wp_customizer_hidden_attr' ) ) :
    /**
     * Helper for Customizer Preview
     *
     * @since 1.0.0
     *
     * @param $theme_mod
     */
    function amp_wp_customizer_hidden_attr( $theme_mod ) {
        if( amp_wp_is_customize_preview() && !amp_wp_get_theme_mod( $theme_mod, false ) ) {
            echo ' style="display:none"';
        }
    }
endif;

if( !function_exists( 'amp_wp_enqueue_customizer_js' )) :
    /**
     * Callback: enqueue customizer preview javascript
     * Action  : customize_preview_init
     *
     * @since 1.0.0
     */
    function amp_wp_enqueue_customizer_js() {
        wp_enqueue_script(
            'amp-wp-customizer-preview',
            amp_wp_plugin_url( 'admin/js/customize-preview.js' ),
            array( 'customize-preview', 'jquery' )
        );
    }
endif;
add_action( 'customize_preview_init', 'amp_wp_enqueue_customizer_js' );

if( !function_exists( 'amp_wp_add_customizer_script' )) :
    function amp_wp_add_customizer_script() {
        global $wpdb;

        wp_enqueue_script(
            'amp-wp-customizer',
            amp_wp_plugin_url( 'admin/js/customizer.js' ),
            array( 'jquery' )
        );
        wp_enqueue_style(
            'amp-wp-customizer-style',
            amp_wp_plugin_url( 'admin/css/customizer.css' )
        );

        $sql    = 'SELECT term_id FROM ' . $wpdb->term_taxonomy . ' WHERE taxonomy=\'category\' ORDER BY count DESC LIMIT 1';
        $cat_ID = (int) $wpdb->get_var( $sql );

        $sql     = 'SELECT ID FROM ' . $wpdb->posts . ' as p INNER JOIN ' . $wpdb->postmeta . ' as pm on(p.ID = pm.post_id)' .
                   ' WHERE p.post_type=\'post\' AND p.post_status=\'publish\' AND pm.meta_value != \'\'' .
                   ' AND NOT EXISTS( SELECT post_id FROM ' . $wpdb->postmeta . ' WHERE post_id = p.ID AND meta_key = \'disable-amp-wp\')' .
                   ' AND pm.meta_key = \'_thumbnail_id\' LIMIT 1';
        $post_ID = (int) $wpdb->get_var( $sql );

        wp_localize_script( 'amp-wp-customizer', 'amp_wp_customizer', array(
            'amp_url' => amp_wp_site_url(),
            'archive_url' => Amp_WP_Content_Sanitizer::transform_to_amp_url( get_category_link( $cat_ID ) ),
            'post_url' => Amp_WP_Content_Sanitizer::transform_to_amp_url( get_the_permalink( $post_ID ) ),
        ));
    }
endif;
add_action( 'customize_controls_enqueue_scripts', 'amp_wp_add_customizer_script' );
   
/**
 * Adds the individual sections, settings, and controls to the theme customizer
 * 
 * Action Used in customize_register
 *
 * @since 1.0.0
 *
 */
class amp_wp_initialise_customizer_settings {
    
    public function __construct() {
        
        // Register Extented Classes of WP_Customize_Control
        add_action( 'customize_register', array( $this, 'amp_wp_add_custom_controls' ) );
        
        // Register our Panels
        add_action( 'customize_register', array( $this, 'amp_wp_add_customizer_panels' ) );
        
        // Register our sections
        add_action( 'customize_register', array( $this, 'amp_wp_add_customizer_sections' ) );
        
        // Register Our Header  Controls
        add_action( 'customize_register', array( $this, 'amp_wp_register_header_controls' ) );
        
        // Register our homepage controls
        add_action( 'customize_register', array( $this, 'amp_wp_register_page_controls' ) );
        
        // Register our color controls
        add_action( 'customize_register', array( $this, 'amp_wp_register_color_controls' ) );
        
        // Register our custom CSS code controls
        add_action( 'customize_register', array( $this, 'amp_wp_register_custom_css_code_controls' ) );
        
        // Register our custom HTML code controls
        add_action( 'customize_register', array( $this, 'amp_wp_register_custom_html_code_controls' ) );
    }
    
	/**
	 * Added Custom Controls
	 * - Divider
	 * - Switch
	 * - Image Radio Button
	 * - Multiple Select Control
	 * - Accordion
	 * 
	 * @since		1.0.0
	 * @since		1.1.1 Added Accordion Control
	 */
    public function amp_wp_add_custom_controls () {
        require_once AMP_WP_DIR_PATH . 'includes/customizer/class-amp-wp-customize-divider-control.php';
		require_once AMP_WP_DIR_PATH . 'includes/customizer/class-amp-wp-customize-slider-control.php';
        require_once AMP_WP_DIR_PATH . 'includes/customizer/class-amp-wp-customize-switch-control.php';
        require_once AMP_WP_DIR_PATH . 'includes/customizer/class-amp-wp-customize-image-radio-button-control.php';
        require_once AMP_WP_DIR_PATH . 'includes/customizer/class-amp-wp-customize-multiple-select-control.php';
		require_once AMP_WP_DIR_PATH . 'includes/customizer/class-amp-wp-customize-heading-control.php';
    }
    
	/**
	 * Register the Customizer panels
	 * 
	 * @param   WP_Customize_Manager $wp_customize
	 * @since   1.0.0
	 */
    public function amp_wp_add_customizer_panels( $wp_customize ) {
        
		/**
		 * Add AMP Panel
		 */
        $wp_customize->add_panel( 'amp-wp-panel',
            array(
                'title' => __( 'AMP WP Theme', 'amp-wp' ),
                'description' => esc_html__( 'Setup AMP WP Options.', 'amp-wp' ),
                'priority' => 0,
            )
        );
    }
    
	/**
	 * Register the Customizer sections
	 * 
	 * @param   WP_Customize_Manager $wp_customize
	 * @since   1.0.0
	 */
    public function amp_wp_add_customizer_sections( $wp_customize ) {
		
		/**
		 * 1. Add Header Section
		 */
        $wp_customize->add_section( 'amp-wp-header-section',
            array(
                'title' => amp_wp_translation_get( 'header' ),
                'priority' => 5,
                'panel' => 'amp-wp-panel'
            )
        );
        
		/**
		 * 2. Add Sidebar Section
		 */
        $wp_customize->add_section( 'amp-wp-sidebar-section', array(
            'title' => amp_wp_translation_get( 'side-header' ),
            'priority' => 10,
            'panel' => 'amp-wp-panel'
        ));
        
		/**
		 * 3. Home Page Section
		 */
        $wp_customize->add_section( 'amp-wp-page-section', array(
            'title' => __( 'Homepage Settings', 'amp-wp' ),
            'priority' => 25,
            'panel' => 'amp-wp-panel'
        ));
        
		/**
		 * 4. Color Section
		 */
        $wp_customize->add_section( 'amp-wp-color-section', array(
            'title' => __( 'Color', 'amp-wp' ),
            'priority' => 30,
            'panel' => 'amp-wp-panel'
        ));
        
		/**
		 * 5. Additional CSS Section
		 */
        $wp_customize->add_section( 'amp-wp-css-section', array(
            'title' => __( 'Custom CSS Code', 'amp-wp' ),
            'priority' => 40,
            'panel' => 'amp-wp-panel'
        ));
        
		/**
		 * 6. Custom Code Section
		 */
        $wp_customize->add_section( 'amp-wp-custom-code-section', array(
            'title' => __( 'Custom HTML Code', 'amp-wp' ),
            'priority' => 45,
            'panel' => 'amp-wp-panel'
        ));
    }
	
	/**
	 * Register our header controls
	 * 
	 * @param   WP_Customize_Manager $wp_customize
	 * @since   1.0.0
	 */
    public function amp_wp_register_header_controls( $wp_customize ) {
		
		/**
         * Header Preset
         */
		$wp_customize->add_setting( 'amp-wp-header-presets', array( 'transport' => 'refresh','sanitize_callback' => 'amp_wp_sanitize_html' ));
        $wp_customize->add_control( new Amp_WP_Customize_Heading_Control( $wp_customize, 'amp-wp-header-presets', array(
			'description' => __( 'Presets' ),  // Required. Passing some text with some basic html content
            'section' => 'amp-wp-header-section'
        )));
        $wp_customize->add_setting( 'amp-wp-header-preset-options', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-header-preset-options' ),
			'transport' => 'refresh',
            'sanitize_callback' => 'amp_wp_text_sanitization'
        ));
        $wp_customize->add_control( new Amp_WP_Image_Radio_Button_Control( $wp_customize, 'amp-wp-header-preset-options',
            array(
                'label'    => __( 'Header Presets', 'amp-wp' ),
                'section'  => 'amp-wp-header-section',
                'choices' => array(
                    'logo-left-simple' => array(  // Required. Value for this particular radio button choice
                        'image' => amp_wp_plugin_url( 'admin/images/logo-left-simple.svg' ), // Required. URL for the image
                        'name' => __( 'Logo Left - Simple' )
                    ),
                    'logo-center-simple' => array(
                        'image' => amp_wp_plugin_url( 'admin/images/logo-center-simple.svg' ), // Required. URL for the image
                        'name' => __( 'Logo Center - Simple' )
                    )
                )
            )
        ));
		
		/**
		 * 1.0 Heading Control - Layout
		 */
        $wp_customize->add_setting( 'amp-wp-header-layout', array( 'transport' => 'refresh','sanitize_callback' => 'amp_wp_sanitize_html' ));
        $wp_customize->add_control( new Amp_WP_Customize_Heading_Control( $wp_customize, 'amp-wp-header-layout', array(
			'description' => __( 'Layout' ),  // Required. Passing some text with some basic html content
            'section' => 'amp-wp-header-section'
        )));
		
		$wp_customize->add_setting( 'amp-wp-header-height',
			array(
				'default' => amp_wp_get_default_theme_setting( 'amp-wp-header-height' ),
				'transport' => 'postMessage',
				'sanitize_callback' => 'amp_wp_sanitize_integer'
			)
		);

		$wp_customize->add_control( new Amp_WP_Customize_Slider_Control( $wp_customize, 'amp-wp-header-height',
			array(
				'label' => esc_html__( 'Height (px)' ),
				'section' => 'amp-wp-header-section',
				'input_attrs' => array(
					'min' => 50, // Required. Minimum value for the slider
					'max' => 200, // Required. Maximum value for the slider
					'step' => 1, // Required. The size of each interval or step the slider takes between the minimum and maximum values
				),
			)
		));
		
		$wp_customize->add_setting( 'amp-wp-header-height-divider', array( 'sanitize_callback' => 'amp_wp_sanitize_html' ));
        $wp_customize->add_control( new Amp_WP_Customize_Divider_Control( $wp_customize, 'amp-wp-header-height-divider', array( 'section' => 'amp-wp-header-section' )));
		
		$wp_customize->add_setting( 'amp-wp-header-text-color', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-header-text-color' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'amp_wp_hex_rgba_sanitization',
            'sanitize_js_callback' => 'maybe_hash_hex_color'
        ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'amp-wp-header-text-color', array(
            'label' => esc_html__( 'Text Color', 'amp-wp' ),
            'section' => 'amp-wp-header-section',
        )));
		$wp_customize->add_setting( 'amp-wp-header-text-color-divider', array( 'sanitize_callback' => 'amp_wp_sanitize_html' ));
        $wp_customize->add_control( new Amp_WP_Customize_Divider_Control( $wp_customize, 'amp-wp-header-text-color-divider', array( 'section' => 'amp-wp-header-section' )));
		
		$wp_customize->add_setting( 'amp-wp-header-background-color', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-header-background-color' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'amp_wp_hex_rgba_sanitization',
            'sanitize_js_callback' => 'maybe_hash_hex_color'
        ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'amp-wp-header-background-color', array(
            'label' => esc_html__( 'Background Color', 'amp-wp' ),
            'section' => 'amp-wp-header-section',
        )));
		
		/**
		 * 1.0 Heading Control - Top Nav
		 */
        $wp_customize->add_setting( 'amp-wp-header-heading-1', array(
			'transport' => 'refresh',
            'sanitize_callback' => 'amp_wp_sanitize_html',
        ));
        $wp_customize->add_control( new Amp_WP_Customize_Heading_Control( $wp_customize, 'amp-wp-header-heading-1', array(
			'description' => __( 'Top Nav' ),  // Required. Passing some text with some basic html content
            'section' => 'amp-wp-header-section',
        )));
		
		/**
		 * 1.1 Text Logo Control
		 */
        $wp_customize->add_setting( 'amp-wp-header-logo-text', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-header-logo-text' ),
            'transport' => 'postMessage',
        ));
        $wp_customize->add_control( 'amp-wp-header-logo-text', array(
            'label' => __( 'Text Logo', 'amp-wp' ),
            'section' => 'amp-wp-header-section',
        ));
        if( $wp_customize->selective_refresh ) {
            $wp_customize->selective_refresh->add_partial( 'amp-wp-header-logo-text', array(
                'settings' => array( 'amp-wp-header-logo-text' ),
                'selector' => '.branding',
                'render_callback' => 'amp_wp_default_theme_logo',
                'container_inclusive' => true,
            ));
        }
		
		/**
		 * 1.2 Divider - Text Logo Control
		 */
        $wp_customize->add_setting( 'amp-wp-header-divider-logo-text', array(
            'sanitize_callback' => 'amp_wp_sanitize_html',
        ));
        $wp_customize->add_control( new Amp_WP_Customize_Divider_Control( $wp_customize, 'amp-wp-header-divider-logo-text', array(
            'section' => 'amp-wp-header-section',
        )));
		
		/**
		 * 1.3 Image Logo Control
		 */
        $wp_customize->add_setting( 'amp-wp-header-logo-img', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-header-logo-img' ),
            'transport' => 'postMessage',
        ));
        $logo_settings = amp_wp_get_default_theme_setting( 'logo' );
        $control_class = class_exists( 'WP_Customize_Cropped_Image_Control' ) ? 'WP_Customize_Cropped_Image_Control' : 'WP_Customize_Image_Control';
        $wp_customize->add_control( new $control_class( $wp_customize, 'amp-wp-header-logo-img', array(
            'label' => __( 'Logo', 'amp-wp' ),
            'section' => 'amp-wp-header-section',
            'height' => $logo_settings['height'],
            'width' => $logo_settings['width'],
            'flex_height' => $logo_settings['flex-height'],
            'flex_width' => $logo_settings['flex-width'],
            'button_labels' => array(
                'select' => __( 'Select logo', 'amp-wp' ),
                'change' => __( 'Change logo', 'amp-wp' ),
                'remove' => __( 'Remove', 'amp-wp' ),
                'default' => __( 'Default', 'amp-wp' ),
                'placeholder' => __( 'No logo selected', 'amp-wp' ),
                'frame_title' => __( 'Select logo', 'amp-wp' ),
                'frame_button' => __( 'Choose logo', 'amp-wp' ),
            ),
        )));
        if( $wp_customize->selective_refresh ) {
            $wp_customize->selective_refresh->add_partial( 'amp-wp-header-logo-img', array(
                'settings' => array( 'amp-wp-header-logo-img' ),
                'selector' => '.branding',
                'render_callback' => 'amp_wp_default_theme_logo',
                'container_inclusive' => true,
            ));
        }
		
		/**
		 * Heading - Side Nav
		 */
        $wp_customize->add_setting( 'amp-wp-header-heading-side-nav', array(
			'transport' => 'refresh',
            'sanitize_callback' => 'amp_wp_sanitize_html',
        ));
		
        $wp_customize->add_control( new Amp_WP_Customize_Heading_Control( $wp_customize, 'amp-wp-header-heading-side-nav', array(
			'description' => __( 'Side Nav' ),  // Required. Passing some text with some basic html content
            'section' => 'amp-wp-header-section'
        )));
		
		/**
		 * Sidebar Text Logo Section
		 */
        $wp_customize->add_setting( 'amp-wp-sidebar-logo-text', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-sidebar-logo-text' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'amp_wp_text_sanitization'
        ));
        $wp_customize->add_control( 'amp-wp-sidebar-logo-text', array(
            'label' => __( 'Text Logo', 'amp-wp' ),
            'section' => 'amp-wp-header-section',
        ));
        if( $wp_customize->selective_refresh ) {
            $wp_customize->selective_refresh->add_partial( 'amp-wp-sidebar-logo-text', array(
                'settings' => array( 'amp-wp-sidebar-logo-text' ),
                'selector' => '.sidebar-brand .brand-name .logo',
                'render_callback' => 'amp_wp_default_theme_sidebar_logo',
                'container_inclusive' => true,
            ));
        }
		
		/**
		 * Sidebar Image Logo Section
		 */
		$wp_customize->add_setting( 'amp-wp-sidebar-logo-img', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-sidebar-logo-img' ),
            'transport' => 'postMessage',
        ) );
        $logo_settings = amp_wp_get_default_theme_setting( 'sidebar-logo' );
        $control_class = class_exists( 'WP_Customize_Cropped_Image_Control' ) ? 'WP_Customize_Cropped_Image_Control' : 'WP_Customize_Image_Control';
        $wp_customize->add_control( new $control_class( $wp_customize, 'amp-wp-sidebar-logo-img', array(
            'label' => __( 'Logo', 'amp-wp' ),
            'section' => 'amp-wp-header-section',
            'height' => $logo_settings['height'],
            'width' => $logo_settings['width'],
            'flex_height' => $logo_settings['flex-height'],
            'flex_width' => $logo_settings['flex-width'],
            'button_labels' => array(
                'select' => __( 'Select logo', 'amp-wp' ),
                'change' => __( 'Change logo', 'amp-wp' ),
                'remove' => __( 'Remove', 'amp-wp' ),
                'default' => __( 'Default', 'amp-wp' ),
                'placeholder' => __( 'No logo selected', 'amp-wp' ),
                'frame_title' => __( 'Select logo', 'amp-wp' ),
                'frame_button' => __( 'Choose logo', 'amp-wp' ),
            ),
        )));
        if( $wp_customize->selective_refresh ) {
            $wp_customize->selective_refresh->add_partial( 'amp-wp-sidebar-logo-img', array(
                'settings' => array( 'amp-wp-sidebar-logo-img' ),
                'selector' => '.sidebar-brand .brand-name .logo',
                'render_callback' => 'amp_wp_default_theme_sidebar_logo',
                'container_inclusive' => true,
            ));
        }
    }
    
	/**
	 * Register Our Page Controls
	 * 
	 * @param   WP_Customize_Manager $wp_customize
	 * @since   1.0.0
	 */
    public function amp_wp_register_page_controls( $wp_customize ) {
		/**
		 * 5.1 Front Page
		 */
        $wp_customize->add_setting( 'amp-wp-show-on-front', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-show-on-front' ),
            'sanitize_callback' => 'amp_wp_select_sanitization'
        ));
        $wp_customize->add_control( 'amp-wp-show-on-front', array(
            'label' => __( '', 'amp-wp' ),
			'description' => __('You can choose what’s displayed on the homepage of your amp site.', 'amp-wp'),
            'section' => 'amp-wp-page-section',
            'priority' => 8,
            'type' => 'radio',
            'choices' => array(
                'posts' => __( 'Your Latest Posts', 'amp-wp' ),
                'page'  => __( 'A Static Page (Select Below)', 'amp-wp' ),
            )
        ));

        $pages = get_pages( array(
            'echo' => 0,
            'value_field' => 'ID',
        ));

        $page_choices = array();
        if( $pages && ! is_wp_error( $pages ) ) {
            foreach ( $pages as $page ) {
                $page_choices[ $page->ID ] = $page->post_title ? $page->post_title : '#' . $page->ID . ' (no title)';
            }
        }
        $pages = null;
        $wp_customize->add_setting( 'amp-wp-page-on-front', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-page-on-front' ),
            'sanitize_callback' => 'amp_wp_select_sanitization'
        ));
        $wp_customize->add_control( 'amp-wp-page-on-front', array(
            'label' => __( 'Front Page', 'amp-wp' ),
            'section' => 'amp-wp-page-section',
            'priority' => 10,
            'type' => 'select',
            'choices' => $page_choices
        ));
    }
    
	/**
	 * Register our color controls
	 * 
	 * @param   WP_Customize_Manager $wp_customize
	 * @since   1.0.0
	 */
    public function amp_wp_register_color_controls( $wp_customize ) {
		/**
		 * 6.1 Theme Color
		 */
        $wp_customize->add_setting( 'amp-wp-color-theme', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-color-theme' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'amp_wp_hex_rgba_sanitization',
            'sanitize_js_callback' => 'maybe_hash_hex_color'
        ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'amp-wp-color-theme', array(
            'label' => __( 'Theme Color', 'amp-wp' ),
            'section' => 'amp-wp-color-section',
        )));

		/**
		 * 6.2 Text color
		 */
        $wp_customize->add_setting( 'amp-wp-color-text', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-color-text' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'amp_wp_hex_rgba_sanitization',
            'sanitize_js_callback' => 'maybe_hash_hex_color'
        ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'amp-wp-color-text', array(
            'label' => __( 'Text Color', 'amp-wp' ),
            'section' => 'amp-wp-color-section',
        )));

		/**
		 * 6.3 BG Color
		 */
        $wp_customize->add_setting( 'amp-wp-color-bg', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-color-bg' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'amp_wp_hex_rgba_sanitization',
            'sanitize_js_callback' => 'maybe_hash_hex_color'
        ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'amp-wp-color-bg', array(
            'label' => __( 'Background Color', 'amp-wp' ),
            'section' => 'amp-wp-color-section',
        )));

		/**
		 * 6.4 Footer NAV BG
		 */
        $wp_customize->add_setting( 'amp-wp-color-footer-nav-bg', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-color-footer-nav-bg' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'amp_wp_hex_rgba_sanitization',
            'sanitize_js_callback' => 'maybe_hash_hex_color'
        ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'amp-wp-color-footer-nav-bg', array(
            'label'   => __( 'Footer Navigation Background Color', 'amp-wp' ),
            'section' => 'amp-wp-color-section',
        )));

		/**
		 * 6.5 Footer BG
		 */
        $wp_customize->add_setting( 'amp-wp-color-footer-bg', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-color-footer-bg' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'amp_wp_hex_rgba_sanitization',
            'sanitize_js_callback' => 'maybe_hash_hex_color'
        ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'amp-wp-color-footer-bg', array(
            'label' => __( 'Footer Copyright Text Background Color', 'amp-wp' ),
            'section' => 'amp-wp-color-section',
        )));
    }
    
	/**
	 * Register our custom CSS code controls
	 * 
	 * @param   WP_Customize_Manager $wp_customize
	 * @since   1.0.0
	 */
    public function amp_wp_register_custom_css_code_controls( $wp_customize ) {
		/**
		 * 8.1 Additional CSS
		 */
        $wp_customize->add_setting( 'amp-wp-additional-css', array(
            //'sanitize_callback' => 'wp_strip_all_tags'
			'sanitize_callback' => 'amp_wp_sanitize_css'
        ));

        $wp_customize->add_control( 'amp-wp-additional-css', array(
            'section' => 'amp-wp-css-section',
            'priority' => 26,
            'type' => 'textarea',
            'input_attrs' => array(
                'class' => 'amp-wp-code',
            ),
        ));
    }
    
    /**
     * Register our custom HTML code controls
     * 
     * @param   WP_Customize_Manager $wp_customize
     * @since   1.0.0
     */
    public function amp_wp_register_custom_html_code_controls( $wp_customize ) {
        
        $wp_customize->add_setting( 'amp-wp-code-head', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-code-head' ),
        ));
        $wp_customize->add_control( 'amp-wp-code-head', array(
            'label' => __( 'Codes between &#x3C;head&#x3E; and &#x3C;/head&#x3E; tags', 'amp-wp' ),
            'section' => 'amp-wp-custom-code-section',
            'priority' => 29,
            'type' => 'textarea',
            'description' => __( 'Please be careful. Bad codes can make invalidation issue for your AMP pages.', 'amp-wp' ),
        ));
        
        $wp_customize->add_setting( 'amp-wp-code-body-start', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-code-body-start' ),
        ));
        $wp_customize->add_control( 'amp-wp-code-body-start', array(
            'label' => __( 'Codes right after &#x3C;body&#x3E; tag', 'amp-wp' ),
            'section' => 'amp-wp-custom-code-section',
            'priority' => 29,
            'type' => 'textarea',
            'description' => __( 'Please be careful. Bad codes can make invalidation issue for your AMP pages.', 'amp-wp' ),
        ));
        
        $wp_customize->add_setting( 'amp-wp-code-body-stop', array(
            'default' => amp_wp_get_default_theme_setting( 'amp-wp-code-body-stop' ),
        ));
        $wp_customize->add_control( 'amp-wp-code-body-stop', array(
            'label' => __( 'Codes right before &#x3C;/body&#x3E; tag', 'amp-wp' ),
            'section' => 'amp-wp-custom-code-section',
            'priority' => 29,
            'type' => 'textarea',
            'description' => __( 'Please be careful. Bad codes can make invalidation issue for your AMP pages.', 'amp-wp' ),
        ));
    }
}
$amp_wp_settings = new amp_wp_initialise_customizer_settings();

if( !function_exists( 'amp_wp_url_sanitization' ) ) :
    /**
     * URL Sanitization
     *
     * @param   string	Input to Be Sanitized (Either a String Containing a Single URL or Multiple, Separated by Commas)
     * @since   1.0.0
     * @return  string	Sanitized Input
     */
    function amp_wp_url_sanitization( $input ) {
        if( strpos( $input, ',' ) !== false) {
            $input = explode( ',', $input );
        }
        if( is_array( $input ) ) {
            foreach ($input as $key => $value) {
                $input[$key] = esc_url_raw( $value );
            }
            $input = implode( ',', $input );
        } else {
            $input = esc_url_raw( $input );
        }
        return $input;
    }
endif;

if( !function_exists( 'amp_wp_switch_sanitization' ) ) :
    /**
     * Switch Sanitization
     *
     * @param   string  Switch Value
     * @since   1.0.0
     * @return  integer Sanitized Value
     */
    function amp_wp_switch_sanitization( $input ) {
        if( true === $input ) {
            return 1;
        } else {
            return '';
        }
    }
endif;

if( !function_exists( 'amp_wp_radio_sanitization' ) ) :
    /**
     * Radio Button and Select Sanitization
     *
     * @param   string      Radio Button Value
     * @since   1.0.0
     * @return  integer     Sanitized Value
     */
    function amp_wp_radio_sanitization( $input, $setting ) {
        
        // Get the List of Possible Radio Box or Select Options
        $choices = $setting->manager->get_control( $setting->id )->choices;
        
        if( array_key_exists( $input, $choices ) ) {
            return $input;
        } else {
            return $setting->default;
        }
    }
endif;

if( !function_exists( 'amp_wp_integer_sanitization' ) ) :
    /**
     * Integer Sanitization
     *
     * @param   string  Input Value to Check
     * @since   1.0.0
     * @return  integer Returned Integer Value
     */
    function amp_wp_integer_sanitization( $input ) {
        return (int) $input;
    }
endif;

if( !function_exists( 'amp_wp_text_sanitization' ) ) :
    /**
     * Text Sanitization
     *
     * @param   string  Input to Be Sanitized (Either a String Containing a Single String or Multiple, Separated by Commas)
     * @since   1.0.0
     * @return  string  Sanitized input
     */
    function amp_wp_text_sanitization( $input ) {
        if( strpos( $input, ',' ) !== false ) {
            $input = explode( ',', $input );
        }
        if( is_array( $input ) ) {
            foreach( $input as $key => $value ) {
                $input[$key] = sanitize_text_field( $value );
            }
            $input = implode( ',', $input );
        } else {
            $input = sanitize_text_field( $input );
        }
        return $input;
    }
endif;

if( !function_exists( 'amp_wp_select_sanitization' ) ) :
    /**
     * Select Sanitization for AMP Version
     *
     * @param   string  $css String to Be Sanitized
     * @since   1.0.0
     * @return  string  Sanitized input
     */
    function amp_wp_select_sanitization( $input, $setting ){

        //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
        $input = sanitize_key($input);

        //get the list of possible select options 
        $choices = $setting->manager->get_control( $setting->id )->choices;

        //return input if valid or return default option
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
    }
endif;

if( !function_exists( 'amp_wp_array_sanitization' ) ) :
    /**
     * Array Sanitization
     *
     * @param   array   Input to Be Sanitized
     * @since   1.0.0
     * @return  array   Sanitized Input
     */
    function amp_wp_array_sanitization( $input ) {
        if( is_array( $input ) ) {
            foreach ( $input as $key => $value ) {
                $input[$key] = sanitize_text_field( $value );
            }
        } else {
            $input = '';
        }
        return $input;
    }
endif;

if( !function_exists( 'amp_wp_hex_rgba_sanitization' ) ) :
    /**
     * Alpha Color (Hex & RGBa) Sanitization
     *
     * @param   string  Input to Be Sanitized
     * @since   1.0.0
     * @return  string  Sanitized Input
     */
    function amp_wp_hex_rgba_sanitization( $input, $setting ) {
        if( empty( $input ) || is_array( $input ) ) {
            return $setting->default;
        }
        if( false === strpos( $input, 'rgba' ) ) {
            // If string doesn't start with 'rgba' then santize as hex color
            $input = sanitize_hex_color( $input );
        } else {
            // Sanitize as RGBa color
            $input = str_replace( ' ', '', $input );
            sscanf( $input, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
            $input = 'rgba(' . amp_wp_in_range( $red, 0, 255 ) . ',' . amp_wp_in_range( $green, 0, 255 ) . ',' . amp_wp_in_range( $blue, 0, 255 ) . ',' . amp_wp_in_range( $alpha, 0, 1 ) . ')';
        }
        return $input;
    }
endif;

if( !function_exists( 'amp_wp_in_range' ) ) :
    /**
     * Only Allow Values Between a Certain Minimum & Maximum Range
     *
     * @param   number  Input to Be Sanitized
     * @since   1.0.0
     * @return  number  Sanitized Input
     */
    function amp_wp_in_range( $input, $min, $max ) {
        if( $input < $min ) { $input = $min; }
        if( $input > $max ) { $input = $max; }
        return $input;
    }
endif;

if( !function_exists( 'amp_wp_google_font_sanitization' ) ) :
    /**
     * Google Font Sanitization
     *
     * @param   string  JSON String to Be Sanitized
     * @since   1.0.0
     * @return  string  Sanitized Input
     */
    function amp_wp_google_font_sanitization( $input ) {
        $val = json_decode( $input, true );
        if( is_array( $val ) ) {
            foreach ( $val as $key => $value ) {
                $val[$key] = sanitize_text_field( $value );
            }
            $input = json_encode( $val );
        } else {
            $input = json_encode( sanitize_text_field( $val ) );
        }
        return $input;
    }
endif;

if( !function_exists( 'amp_wp_date_time_sanitization' ) ) :
    /**
     * Date Time Sanitization
     *
     * @param   string   Date/Time String to Be Sanitized
     * @since   1.0.0
     * @return  string   Sanitized Input
     */
    function amp_wp_date_time_sanitization( $input, $setting ) {
        $datetimeformat = 'Y-m-d';
        if( $setting->manager->get_control( $setting->id )->include_time ) {
            $datetimeformat = 'Y-m-d H:i:s';
        }
        $date = DateTime::createFromFormat( $datetimeformat, $input );
        if( $date === false ) {
            $date = DateTime::createFromFormat( $datetimeformat, $setting->default );
        }
        return $date->format( $datetimeformat );
    }
endif;

if( !function_exists( 'amp_wp_google_analytic_tracking_id_sanitization' ) ) :
    /**
     * Google Analytic Tracking ID Sanitization
     *
     * @param   string  Tracking ID string to be sanitized
     * @since   1.0.0
     * @return  string  Sanitized input
     */
    function amp_wp_google_analytic_tracking_id_sanitization( $input ) {
        return preg_match('/^ua-\d{4,10}(-\d{1,4})?$/i', strval($input));
    }
endif;

if( !function_exists( 'amp_wp_sanitize_html' ) ) :
    /**
     * HTML Sanitization Callback.
     *
     * - Sanitization: html tag hr
     * - Control: Divider
     * 
     * Sanitize content for allowed HTML tags for post content.
     * 
     * @see wp_kses_post() https://developer.wordpress.org/reference/functions/wp_kses_post/
     *
     * @param   string  $html   HTML to sanitize.
     * @return  string  Sanitized HTML.
     */
    function amp_wp_sanitize_html( $html ) {
        return wp_kses_post( force_balance_tags( $html ) );
    }
endif;


	
if( !function_exists( 'amp_wp_sanitize_integer' ) ) :
	/**
	 * Integer sanitization
	 *
	 * @param	string		Input value to check
	 * @return	integer		Returned integer value
	 */
	function amp_wp_sanitize_integer( $input ) {
		return (int) $input;
	}
endif;