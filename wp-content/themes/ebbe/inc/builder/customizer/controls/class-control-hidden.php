<?php
class Ebbe_Customizer_Control_Hidden extends Ebbe_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-ebbe-hidden">
		<?php
		self::before_field();
		?>
		<input type="hidden" class="ebbe-input ebbe-only" data-name="{{ field.name }}" value="{{ field.value }}">
		<?php
		self::after_field();
		?>
		</script>
		<?php
	}
}
