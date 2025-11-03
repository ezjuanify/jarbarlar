<?php
class Ebbe_Customizer_Control_Media extends Ebbe_Customizer_Control_Base {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-ebbe-media">';
		self::before_field();
		?>
		<#
		if ( ! _.isObject(field.value) ) {
			field.value = {};
		}
		var url = field.value.url;
		#>
		<?php echo self::field_header(); ?>
		<div class="ebbe-field-settings-inner ebbe-media-type-{{ field.type }}">
			<div class="ebbe--media">
				<input type="hidden" class="attachment-id" value="{{ field.value.id }}" data-name="{{ field.name }}">
				<input type="hidden" class="attachment-url"  value="{{ field.value.url }}" data-name="{{ field.name }}-url">
				<input type="hidden" class="attachment-mime"  value="{{ field.value.mime }}" data-name="{{ field.name }}-mime">
				<div class="ebbe-image-preview <# if ( url ) { #> ebbe--has-file <# } #>" data-no-file-text="<?php esc_attr_e( 'No file selected', 'ebbe' ); ?>">
					<#

					if ( url ) {
						if ( url.indexOf('http://') > -1 || url.indexOf('https://') ){

						} else {
							url = Ebbe_Control_Args.home_url + url;
						}

						if ( ! field.value.mime || field.value.mime.indexOf('image/') > -1 ) {
							#>
							<img src="{{ url }}" alt="">
						<# } else if ( field.value.mime.indexOf('video/' ) > -1 ) { #>
							<video width="100%" height="" controls><source src="{{ url }}" type="{{ field.value.mime }}">Your browser does not support the video tag.</video>
						<# } else {
						var basename = url.replace(/^.*[\\\/]/, '');
						#>
							<a href="{{ url }}" class="attachment-file" target="_blank">{{ basename }}</a>
						<# }
					}
					#>
				</div>
				<button type="button" class="button ebbe--add <# if ( url ) { #> ebbe--hide <# } #>"><?php _e( 'Add', 'ebbe' ); ?></button>
				<button type="button" class="button ebbe--change <# if ( ! url ) { #> ebbe--hide <# } #>"><?php _e( 'Change', 'ebbe' ); ?></button>
				<button type="button" class="button ebbe--remove <# if ( ! url ) { #> ebbe--hide <# } #>"><?php _e( 'Remove', 'ebbe' ); ?></button>
			</div>
		</div>

		<?php
		self::after_field();
		echo '</script>';
	}
}
