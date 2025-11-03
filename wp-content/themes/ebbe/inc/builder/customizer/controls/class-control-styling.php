<?php
class Ebbe_Customizer_Control_Styling extends Ebbe_Customizer_Control_Modal {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-ebbe-styling">';
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="ebbe-actions">
			<a href="#" title="<?php esc_attr_e( 'Reset to default', 'ebbe' ); ?>" class="action--reset" data-control="{{ field.name }}"><span class="dashicons dashicons-image-rotate"></span></a>
			<a href="#" title="<?php esc_attr_e( 'Toggle edit panel', 'ebbe' ); ?>" class="action--edit" data-control="{{ field.name }}"><span class="dashicons dashicons-admin-customizer"></span></a>
		</div>
		<div class="ebbe-field-settings-inner">
			<input type="hidden" class="ebbe-hidden-modal-input ebbe-only" data-name="{{ field.name }}" value="{{ JSON.stringify( field.value ) }}" data-default="{{ JSON.stringify( field.default ) }}">
		</div>
		<?php
		self::after_field();
		echo '</script>';
		?>
		<script type="text/html" id="tmpl-ebbe-modal-settings">
			<div class="ebbe-modal-settings">
				<div class="ebbe-modal-settings--inner">
					<div class="ebbe-modal-settings--fields"></div>
				</div>
			</div>
		</script>
		<?php
	}
}
