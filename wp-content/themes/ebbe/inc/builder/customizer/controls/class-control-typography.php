<?php
class Ebbe_Customizer_Control_Typography extends Ebbe_Customizer_Control_Base {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-ebbe-typography">';
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="ebbe-actions">
			<a href="#" class="action--reset" data-control="{{ field.name }}" title="<?php esc_attr_e( 'Reset to default', 'ebbe' ); ?>"><span class="dashicons dashicons-image-rotate"></span></a>
			<a href="#" class="action--edit" data-control="{{ field.name }}" title="<?php esc_attr_e( 'Toggle edit panel', 'ebbe' ); ?>"><span class="dashicons dashicons-editor-textcolor"></span></a>
		</div>
		<div class="ebbe-field-settings-inner">
			<input type="hidden" class="ebbe-typography-input ebbe-only" data-name="{{ field.name }}" value="{{ JSON.stringify( field.value ) }}" data-default="{{ JSON.stringify( field.default ) }}">
		</div>
		<?php
		self::after_field();
		echo '</script>';
		?>
		<div id="ebbe-typography-panel" class="ebbe-typography-panel">
			<div class="ebbe-typography-panel--inner">
				<input type="hidden" id="ebbe--font-type">
				<div id="ebbe-typography-panel--fields"></div>
			</div>
		</div>
		<?php
	}
}
