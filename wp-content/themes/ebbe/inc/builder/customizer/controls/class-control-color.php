<?php
class Ebbe_Customizer_Control_Color extends Ebbe_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-ebbe-color">
		<?php
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="ebbe-field-settings-inner">
			<div class="ebbe-input-color" data-default="{{ field.default }}">
				<input type="hidden" class="ebbe-input ebbe-input--color" data-name="{{ field.name }}" value="{{ field.value }}">
				<input type="text" class="ebbe--color-panel" placeholder="{{ field.placeholder }}" data-alpha="true" value="{{ field.value }}">
			</div>
		</div>
		<?php
		self::after_field();
		?>
		</script>
		<?php
	}
}
