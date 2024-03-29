<?php
/**
 * Component for amp-instagram
 *
 * @category    Core
 * @package     Amp_WP/includes/components
 * @version     1.0.0
 * @author      Pixelative <mohsin@pixelative.co>
 * @copyright   Copyright (c) 2018 - 2019, Pixelative
 * @since       1.5.6
 */

class Amp_WP_Instagram_Component implements Amp_WP_Component_Interface {

	/**
	 * Flag to enable component scripts
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	public $enable_enqueue_scripts = false;

	/**
	 * Contract implementation
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function config() {
		return array(
			'scripts' => array(
				'amp-instagram' => 'https://cdn.ampproject.org/v0/amp-instagram-0.1.js',
			),
		);
	}

	/**
	 * Transform Instagram embed code to <amp-instagram> tags
	 *
	 * @since 1.0.0
	 *
	 * @param Amp_WP_Html_Util $instance
	 *
	 * @return Amp_WP_Html_Util
	 */
	public function transform( Amp_WP_Html_Util $instance ) {

		$elements = $instance->getElementsByTagName( 'blockquote' );
		/**
		 * @var DOMElement $element
		 */
		$nodes_count = $elements->length;
		if ( ! $nodes_count ) {
			return $instance;
		}
		for ( $i = $nodes_count - 1; $i >= 0; $i-- ) {
			
			$element = $elements->item( $i );
			if ( ! $element ) {
				continue;
			}
			
			$post_url = $element->getAttribute( 'data-instgrm-permalink' );
			if ( ! preg_match( '#^(?: https?:)?// (?: w{3}.)? instagram.com /+ p/+ ([^/]+) /*#ix', $post_url, $match ) ) {
				continue;
			}
			
			$this->enable_enqueue_scripts = true;
			$attributes                   = array(
				'data-shortcode' => $match[1],
				'width'          => '400',
				'height'         => '400',
				'layout'         => 'responsive',
			);
			
			$instance->replace_node( $element, 'amp-instagram', $attributes );
		}
		
		return $instance;
	}
}

// Register component class.
amp_wp_register_component( 'Amp_WP_Instagram_Component' );
