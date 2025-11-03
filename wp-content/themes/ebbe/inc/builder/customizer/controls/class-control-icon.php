<?php
class Ebbe_Customizer_Control_Icon extends Ebbe_Customizer_Control_Base {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-ebbe-icon">';
		self::before_field();
		?>
		<#
		if ( ! _.isObject( field.value ) ) {
			field.value = { };
		}
		#>
		<?php echo self::field_header(); ?>
		<div class="ebbe-field-settings-inner">
			<div class="ebbe--icon-picker">
				<div class="ebbe--icon-preview">
					<input type="hidden" class="ebbe-input ebbe--input-icon-type" data-name="{{ field.name }}-type" value="{{ field.value.type }}">
					<div class="ebbe--icon-preview-icon ebbe--pick-icon">
						<# if ( field.value.icon ) {  #>
							<i class="{{ field.value.icon }}"></i>
						<# }  #>
					</div>
				</div>
				<input type="text" readonly class="ebbe-input ebbe--pick-icon ebbe--input-icon-name" placeholder="<?php esc_attr_e( 'Pick an icon', 'ebbe' ); ?>" data-name="{{ field.name }}" value="{{ field.value.icon }}">
				<span class="ebbe--icon-remove" title="<?php esc_attr_e( 'Remove', 'ebbe' ); ?>">
					<span class="dashicons dashicons-no-alt"></span>
					<span class="screen-reader-text">
					<?php _e( 'Remove', 'ebbe' ); ?></span>
				</span>
			</div>
		</div>
		<?php
		self::after_field();
		echo '</script>';
		?>
		<div id="ebbe--sidebar-icons">
			<div class="ebbe--sidebar-header">
				<a class="customize-controls-icon-close" href="#">
					<span class="screen-reader-text"><?php _e( 'Cancel', 'ebbe' ); ?></span>
				</a>
				<div class="ebbe--icon-type-inner">
					<select id="ebbe--sidebar-icon-type">
						<option value="all"><?php _e( 'All Icon Types', 'ebbe' ); ?></option>
					</select>
				</div>
			</div>
			<div class="ebbe--sidebar-search">
				<input type="text" id="ebbe--icon-search" placeholder="<?php esc_attr_e( 'Type icon name', 'ebbe' ); ?>">
			</div>
			<div id="ebbe--icon-browser"></div>
		</div>
		<?php
	}
}
