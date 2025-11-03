<?php
class Ebbe_Customizer_Control_Textarea extends Ebbe_Customizer_Control_Base {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-ebbe-textarea">';
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="ebbe-field-settings-inner">
			<textarea rows="10" class="ebbe-input" data-name="{{ field.name }}">{{ field.value }}</textarea>
		</div>
		<?php
		self::after_field();
		echo '</script>';
	}
}
