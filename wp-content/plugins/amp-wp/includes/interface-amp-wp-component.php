<?php
/**
 * Base Contact of the amp component
 *
 * @since 1.0.0
 */
interface Amp_WP_Component_Interface {

	/**
	 * Prepare HTML content before printing
	 *
	 * @param Amp_WP_Html_Util $instance
	 *
	 * @internal param string $content post_content html
	 *
	 * @since    1.0.0
	 */
	public function transform( Amp_WP_Html_Util $instance );

	/**
	 * Component config array {
	 *
	 *      @type array $shortcodes array {
	 *          'shortcode name' => 'shortcode handler callback'
	 *          ...
	 *      }
	 *      'scripts' => array(
	 *          'handle name' =>  'amp script url',
	 *          ...
	 *      )
	 * }
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function config();
}
