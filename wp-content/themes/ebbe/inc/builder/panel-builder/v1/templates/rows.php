<script type="text/html" id="tmpl-ebbe--cb-panel">
	<div class="ebbe--cp-rows">

		<# if ( ! _.isUndefined( data.rows.top ) ) { #>
		<div class="ebbe--row-top ebbe--cb-row" data-id="{{ data.id }}_top">
			<a class="ebbe--cb-row-settings" title="{{ data.rows.top }}" data-id="top" href="#"></a>
			<div class="ebbe--row-inner">
				<div class="row--grid">
					<?php
					for ( $i = 1; $i <= 12; $i ++ ) {
						echo '<div></div>';
					}
					?>
				</div>
				<div class="ebbe--cb-items grid-stack gridster" data-id="top"></div>
			</div>
		</div>
		<# } #>

		<# if ( ! _.isUndefined( data.rows.main ) ) { #>
		<div class="ebbe--row-main ebbe--cb-row" data-id="{{ data.id }}_main">
			<a class="ebbe--cb-row-settings" title="{{ data.rows.main }}" data-id="main" href="#"></a>

			<div class="ebbe--row-inner">
				<div class="row--grid">
					<?php
					for ( $i = 1; $i <= 12; $i ++ ) {
						echo '<div></div>';
					}
					?>
				</div>
				<div class="ebbe--cb-items grid-stack gridster" data-id="main"></div>
			</div>
		</div>
		<# } #>


		<# if ( ! _.isUndefined( data.rows.bottom ) ) { #>
		<div class="ebbe--row-bottom ebbe--cb-row" data-id="{{ data.id }}_bottom">
			<a class="ebbe--cb-row-settings" title="{{ data.rows.bottom }}" data-id="bottom" href="#"></a>
			<div class="ebbe--row-inner">
				<div class="row--grid">
					<?php
					for ( $i = 1; $i <= 12; $i ++ ) {
						echo '<div></div>';
					}
					?>
				</div>
				<div class="ebbe--cb-items grid-stack gridster" data-id="bottom"></div>
			</div>
		</div>
		<# } #>
	</div>


	<# if ( data.device != 'desktop' ) { #>
		<# if ( ! _.isUndefined( data.rows.sidebar ) ) { #>
		<div class="ebbe--cp-sidebar">
			<div class="ebbe--row-bottom ebbe--cb-row" data-id="{{ data.id }}_sidebar">
				<a class="ebbe--cb-row-settings" title="{{ data.rows.sidebar }}" data-id="sidebar" href="#"></a>
				<div class="ebbe--row-inner">
					<div class="ebbe--cb-items ebbe--sidebar-items" data-id="sidebar"></div>
				</div>
			</div>
			<div>
		<# } #>
	<# } #>

</script>
