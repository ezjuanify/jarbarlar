<?php

class Ebbe_Builder_Item_HTML {

	public $id = 'html';

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'HTML 1', 'ebbe' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => 'header_html',
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		// Render callback function.
		$fn     = array( $this, 'render' );
		$config = array(
			array(
				'name'     => 'header_html',
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 200,
				'title'    => esc_html__( 'HTML 1', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_header_html',
				'type'            => 'textarea',
				'section'         => 'header_html',
				'selector'        => '.builder-header-html-item',
				'render_callback' => $fn,
				'theme_supports'  => '',
				'default'         => esc_html__( 'Add custom text here or remove it', 'ebbe' ),
				'title'           => esc_html__( 'HTML', 'ebbe' ),
				'description'     => esc_html__( 'Arbitrary HTML code.', 'ebbe' ),
			),

			array(
				'name'       => 'ebbe_header_html_typo',
				'type'       => 'typography',
				'section'    => 'header_html',
				'selector'   => '.builder-header-html-item.item--html p, .builder-header-html-item.item--html',
				'css_format' => 'typography',
				'title'      => esc_html__( 'Typography Setting', 'ebbe' ),
			),

		);

		// Item Layout.
		return array_merge( $config, ebbe_header_layout_settings( $this->id, 'header_html' ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		$content = Ebbe()->get_setting( 'ebbe_header_html' );
		echo '<div class="builder-header-html-item item--html">';
			echo apply_filters( 'ebbe_the_content', wp_kses_post( $content, true ) );
		echo '</div>';
	}
}

// Register the first HTML item
Ebbe_Customize_Layout_Builder()->register_item( 'header', new Ebbe_Builder_Item_HTML() );

// Add a second HTML item<?php

class Ebbe_Builder_Item_HTML2 {

	public $id = 'html2';

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'HTML 2', 'ebbe' ),
			'id'      => $this->id,
			'col'     => 1,
			'width'   => '4',
			'section' => 'header_html_2',
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		// Render callback function.
		$fn     = array( $this, 'render' );
		$config = array(
			array(
				'name'     => 'header_html_2',
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 201,
				'title'    => esc_html__( 'HTML 2', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_header_html_2',
				'type'            => 'textarea',
				'section'         => 'header_html_2',
				'selector'        => '.builder-header-html-item-2',
				'render_callback' => $fn,
				'theme_supports'  => '',
				'default'         => esc_html__( 'Add more custom text here or remove it', 'ebbe' ),
				'title'           => esc_html__( 'HTML 2', 'ebbe' ),
				'description'     => esc_html__( 'More arbitrary HTML code.', 'ebbe' ),
			),

			array(
				'name'       => 'ebbe_header_html_2_typo',
				'type'       => 'typography',
				'section'    => 'header_html_2',
				'selector'   => '.builder-header-html-item-2.item--html2 p, .builder-header-html-item-2.item--html2',
				'css_format' => 'typography',
				'title'      => esc_html__( 'Typography Setting', 'ebbe' ),
			),

		);

		// Item Layout.
		return array_merge( $config, ebbe_header_layout_settings( $this->id, 'header_html_2' ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		$content = Ebbe()->get_setting( 'ebbe_header_html_2' );
		echo '<div class="builder-header-html-item-2 item--html2">';
			echo apply_filters( 'ebbe_the_content', wp_kses_post( $content ) );
		echo '</div>';
	}
}

// Register the second HTML item
Ebbe_Customize_Layout_Builder()->register_item( 'header', new Ebbe_Builder_Item_HTML2() );
