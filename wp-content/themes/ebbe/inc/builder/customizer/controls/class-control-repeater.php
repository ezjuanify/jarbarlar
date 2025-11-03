<?php

class Ebbe_Customizer_Control_Repeater extends Ebbe_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-ebbe-repeater">
			<?php
			self::before_field();
			?>
			<?php echo self::field_header(); ?>
			<div class="ebbe-field-settings-inner">
			</div>
			<?php
			self::after_field();
			?>
		</script>
		<script type="text/html" id="tmpl-customize-control-repeater-item">
			<div class="ebbe--repeater-item">
				<div class="ebbe--repeater-item-heading">
					<label class="ebbe--repeater-visible" title="<?php esc_attr_e( 'Toggle item visible', 'ebbe' ); ?>">
						<input type="checkbox" class="r-visible-input">
						<span class="r-visible-icon"></span>
						<span class="screen-reader-text"><?php _e( 'Show', 'ebbe' ); ?></label>
					<span class="ebbe--repeater-live-title"></span>
					<div class="ebbe-nav-reorder">
						<span class="ebbe--down" tabindex="-1">
							<span class="screen-reader-text"><?php _e( 'Move Down', 'ebbe' ); ?></span></span>
						<span class="ebbe--up" tabindex="0">
							<span class="screen-reader-text"><?php _e( 'Move Up', 'ebbe' ); ?></span>
						</span>
					</div>
					<a href="#" class="ebbe--repeater-item-toggle">
						<span class="screen-reader-text"><?php _e( 'Close', 'ebbe' ); ?></span></a>
				</div>
				<div class="ebbe--repeater-item-settings">
					<div class="ebbe--repeater-item-inside">
						<div class="ebbe--repeater-item-inner"></div>
						<# if ( data.addable ){ #>
						<a href="#" class="ebbe--remove"><?php _e( 'Remove', 'ebbe' ); ?></a>
						<# } #>
					</div>
				</div>
			</div>
		</script>
		<script type="text/html" id="tmpl-customize-control-repeater-inner">
			<div class="ebbe--repeater-inner">
				<div class="ebbe--settings-fields ebbe--repeater-items"></div>
				<div class="ebbe--repeater-actions">
				<a href="#" class="ebbe--repeater-reorder"
				data-text="<?php esc_attr_e( 'Reorder', 'ebbe' ); ?>"
				data-done="<?php _e( 'Done', 'ebbe' ); ?>"><?php _e( 'Reorder', 'ebbe' ); ?></a>
					<# if ( data.addable ){ #>
					<button type="button"
							class="button ebbe--repeater-add-new"><?php _e( 'Add an item', 'ebbe' ); ?></button>
					<# } #>
				</div>
			</div>
		</script>
		<?php
	}
}
