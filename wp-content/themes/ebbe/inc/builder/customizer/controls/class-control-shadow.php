<?php
class Ebbe_Customizer_Control_Shadow extends Ebbe_Customizer_Control_Base {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-ebbe-shadow">';
		self::before_field();
		?>
		<#
			if ( ! _.isObject( field.value ) ) {
			field.value = { };
			}

			var uniqueID = field.name + ( new Date().getTime() );
		#>
			<?php echo self::field_header(); ?>
			<div class="ebbe-field-settings-inner">

				<div class="ebbe-input-color" data-default="{{ field.default }}">
					<input type="hidden" class="ebbe-input ebbe-input--color" data-name="{{ field.name }}-color" value="{{ field.value.color }}">
					<input type="text" class="ebbe--color-panel" data-alpha="true" value="{{ field.value.color }}">
				</div>

				<div class="ebbe--gr-inputs">
					<span>
						<input type="number" class="ebbe-input ebbe-input-css change-by-js"  data-name="{{ field.name }}-x" value="{{ field.value.x }}">
						<span class="ebbe--small-label"><?php _e( 'X', 'ebbe' ); ?></span>
					</span>
					<span>
						<input type="number" class="ebbe-input ebbe-input-css change-by-js"  data-name="{{ field.name }}-y" value="{{ field.value.y }}">
						<span class="ebbe--small-label"><?php _e( 'Y', 'ebbe' ); ?></span>
					</span>
					<span>
						<input type="number" class="ebbe-input ebbe-input-css change-by-js" data-name="{{ field.name }}-blur" value="{{ field.value.blur }}">
						<span class="ebbe--small-label"><?php _e( 'Blur', 'ebbe' ); ?></span>
					</span>
					<span>
						<input type="number" class="ebbe-input ebbe-input-css change-by-js" data-name="{{ field.name }}-spread" value="{{ field.value.spread }}">
						<span class="ebbe--small-label"><?php _e( 'Spread', 'ebbe' ); ?></span>
					</span>
					<span>
						<span class="input">
							<input type="checkbox" class="ebbe-input ebbe-input-css change-by-js" <# if ( field.value.inset == 1 ){ #> checked="checked" <# } #> data-name="{{ field.name }}-inset" value="{{ field.value.inset }}">
						</span>
						<span class="ebbe--small-label"><?php _e( 'inset', 'ebbe' ); ?></span>
					</span>
				</div>
			</div>
			<?php
			self::after_field();
			echo '</script>';
	}
}
