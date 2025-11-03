<?php
/**
 * Ebbe builder init
 *
 * @since 0.2.9
 * @package ebbe
 */
class Ebbe_Panel_Builder {
	public function __construct() {
		$this->includes();
		$this->init();
	}

	public function includes() {
		$path = get_template_directory();
		require_once $path . '/inc/builder/panel-builder/class-abstract-layout-frontend.php';
		require_once $path . '/inc/builder/panel-builder/class-builder-panel.php';
		require_once $path . '/inc/builder/panel-builder/class-layout-builder.php';
		require_once $path . '/inc/builder/panel-builder/class-layout-builder-frontend.php';
		require_once $path . '/inc/builder/panel-builder/class-layout-builder-frontend-v2.php';
		require_once $path . '/inc/builder/panel-builder/builder-functions.php';
	}

	private function init() {
		/**
		 * Initial Layout Builder
		 */
		Ebbe_Customize_Layout_Builder()->init();

		/**
		 * Add Header Content To Frontend
		 */
		add_action( 'ebbe/site-start', 'ebbe_customize_render_header' );
		/**
		 * Add Footer Content To Frontend
		 */
		add_action( 'ebbe/site-end', 'ebbe_customize_render_footer' );
	}

}

new Ebbe_Panel_Builder();

