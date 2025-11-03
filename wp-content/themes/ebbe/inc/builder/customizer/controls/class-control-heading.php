<?php
class Ebbe_Customizer_Control_Heading extends Ebbe_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-ebbe-heading">
		<?php
		self::before_field();
		?>
		<h3 class="ebbe-field--heading">{{ field.label }}</h3>
		<?php
		self::after_field();
		?>
		</script>
		<?php
	}
}
