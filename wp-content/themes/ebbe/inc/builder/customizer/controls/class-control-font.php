<?php
class Ebbe_Customizer_Control_Font extends Ebbe_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-ebbe-css-ruler">
		<?php
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="ebbe-field-settings-inner">
			<input type="hidden" class="ebbe--font-type" data-name="{{ field.name }}-type" >
			<div class="ebbe--font-families-wrapper">
				<select class="ebbe--font-families" data-value="{{ JSON.stringify( field.value ) }}" data-name="{{ field.name }}-font"></select>
			</div>
			<div class="ebbe--font-variants-wrapper">
				<label><?php _e( 'Variants', 'ebbe' ); ?></label>
				<select class="ebbe--font-variants" data-name="{{ field.name }}-variant"></select>
			</div>
			<div class="ebbe--font-subsets-wrapper">
				<label><?php _e( 'Languages', 'ebbe' ); ?></label>
				<div data-name="{{ field.name }}-subsets" class="list-subsets">
				</div>
			</div>
		</div>
		<?php
		self::after_field();
		?>
		</script>
		<?php
	}
}
