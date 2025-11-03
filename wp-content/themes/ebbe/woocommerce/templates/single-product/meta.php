<?php

if (!defined('ABSPATH')) {
	exit;
}

global $product;
?>

<div class="product_meta">

	<?php do_action('woocommerce_product_meta_start'); ?>

	<?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>

		<span class="sku_wrapper"><?php esc_html_e('SKU:', 'woocommerce'); ?> <span class="sku"><?php echo ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'woocommerce'); ?></span></span>

	<?php endif; ?>

	<?php echo wc_get_product_category_list($product->get_id(), ', ', '<span class="posted_in">' . _n('Category:', 'Categories:', count($product->get_category_ids()), 'woocommerce') . ' ', '</span>'); ?>

	<?php echo wc_get_product_tag_list($product->get_id(), ', ', '<span class="tagged_as">' . _n('Tag:', 'Tags:', count($product->get_tag_ids()), 'woocommerce') . ' ', '</span>'); ?>

	<?php do_action('woocommerce_product_meta_end'); ?>

</div>
<?php 
 if ( ! $product || ! $product->get_id() ) {
	return;
}

// Get the product URL and title
$product_url = get_permalink( $product->get_id() );
$product_title = get_the_title( $product->get_id() );
$encoded_url = urlencode( $product_url );
$encoded_title = urlencode( $product_title );

// Social share URLs
$facebook_url = "https://www.facebook.com/sharer.php?u={$encoded_url}";
$twitter_url = "https://twitter.com/intent/tweet?text={$encoded_title}&url={$encoded_url}";
$pinterest_url = "https://pinterest.com/pin/create/button/?url={$encoded_url}&description={$encoded_title}";

// Render the share buttons
echo '<div class="product-share-buttons">';
echo '<span>Share: </span>';

// Facebook button
echo '<a href="' . esc_url($facebook_url) . '" target="_blank" class="share-button facebook" title="Share on Facebook">';
echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.729 0-1.325.597-1.325 1.326v21.348c0 .729.597 1.326 1.325 1.326h11.492v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.794.143v3.237l-1.918.001c-1.504 0-1.794.715-1.794 1.763v2.315h3.587l-.467 3.622h-3.12v9.293h6.116c.729 0 1.325-.597 1.325-1.326v-21.348c0-.729-.597-1.326-1.325-1.326z"/></svg>';
echo '</a>';

// Twitter button
echo '<a href="' . esc_url($twitter_url) . '" target="_blank" class="share-button twitter" title="Share on Twitter">';
echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 512 512" id="twitter">
  <g clip-path="url(#clip0_84_15697)">
    <rect width="512" height="512" fill="#000" rx="60"></rect>
    <path fill="#fff" d="M355.904 100H408.832L293.2 232.16L429.232 412H322.72L239.296 302.928L143.84 412H90.8805L214.56 270.64L84.0645 100H193.28L268.688 199.696L355.904 100ZM337.328 380.32H366.656L177.344 130.016H145.872L337.328 380.32Z"></path>
  </g>
  <defs>
    <clipPath id="clip0_84_15697">
      <rect width="512" height="512" fill="#fff"></rect>
    </clipPath>
  </defs>
</svg>';
echo '</a>';

// Pinterest button
echo '<a href="' . esc_url($pinterest_url) . '" target="_blank" class="share-button pinterest" title="Share on Pinterest">';
echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12 0 5.173 3.175 9.601 7.692 11.304-.107-.957-.203-2.426.041-3.473.223-.96 1.436-6.085 1.436-6.085s-.367-.735-.367-1.82c0-1.705.988-2.978 2.214-2.978 1.043 0 1.547.782 1.547 1.718 0 1.047-.667 2.617-1.011 4.071-.287 1.214.607 2.203 1.801 2.203 2.162 0 3.818-2.278 3.818-5.553 0-2.899-2.085-4.924-5.065-4.924-3.451 0-5.478 2.587-5.478 5.263 0 1.049.405 2.175.913 2.785.101.121.115.227.084.348-.091.381-.302 1.214-.343 1.381-.054.227-.178.277-.413.166-1.549-.722-2.519-2.99-2.519-4.815 0-3.925 2.854-7.531 8.228-7.531 4.321 0 7.675 3.081 7.675 7.192 0 4.281-2.706 7.725-6.455 7.725-1.26 0-2.445-.655-2.849-1.423 0 0-.606 2.318-.751 2.892-.274 1.053-1.016 2.364-1.514 3.166.905.277 1.859.428 2.851.428 6.627 0 12-5.373 12-12s-5.373-12-12-12z"/></svg>';
echo '</a>';

echo '</div>';
	?>
<!-- <div class="custom_service">
	<div class="product__delivery">
		<div class="product__deliverycont">
			<div class="product__delivery-icon">
				<svg height="800px" width="800px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" style="
       background: #000;
    border-radius: 100%;
    height: 30px;
    width: 30px;
    padding: 5px;
">

					<g>
						<path class="st0" d="M311.069,130.515c-0.963-5.641-5.851-9.768-11.578-9.768H35.43c-7.61,0-13.772,6.169-13.772,13.765
		c0,7.61,6.162,13.772,13.772,13.772h64.263c7.61,0,13.772,6.17,13.772,13.773c0,7.603-6.162,13.772-13.772,13.772H13.772
		C6.169,175.829,0,181.998,0,189.601c0,7.603,6.169,13.764,13.772,13.764h117.114c6.72,0,12.172,5.46,12.172,12.18
		c0,6.72-5.452,12.172-12.172,12.172H68.665c-7.61,0-13.772,6.17-13.772,13.773c0,7.602,6.162,13.772,13.772,13.772h45.857
		c6.726,0,12.179,5.452,12.179,12.172c0,6.719-5.453,12.172-12.179,12.172H51.215c-7.61,0-13.772,6.169-13.772,13.772
		c0,7.603,6.162,13.772,13.772,13.772h87.014l5.488,31.042h31.52c-1.854,4.504-2.911,9.421-2.911,14.598
		c0,21.245,17.218,38.464,38.464,38.464c21.237,0,38.456-17.219,38.456-38.464c0-5.177-1.057-10.094-2.911-14.598h100.04
		L311.069,130.515z M227.342,352.789c0,9.146-7.407,16.553-16.553,16.553c-9.152,0-16.56-7.407-16.56-16.553
		c0-6.364,3.627-11.824,8.892-14.598h15.329C223.714,340.965,227.342,346.424,227.342,352.789z"></path>
						<path class="st0" d="M511.598,314.072l-15.799-77.941l-57.689-88.759H333.074l32.534,190.819h38.42
		c-1.846,4.504-2.904,9.421-2.904,14.598c0,21.245,17.219,38.464,38.456,38.464c21.246,0,38.464-17.219,38.464-38.464
		c0-5.177-1.057-10.094-2.91-14.598h16.741c6.039,0,11.759-2.708,15.582-7.386C511.273,326.136,512.8,319.988,511.598,314.072z
		 M392.529,182.882h26.314l34.162,52.547h-51.512L392.529,182.882z M456.14,352.789c0,9.146-7.407,16.553-16.56,16.553
		c-9.138,0-16.552-7.407-16.552-16.553c0-6.364,3.635-11.824,8.892-14.598h15.329C452.513,340.965,456.14,346.424,456.14,352.789z"></path>
					</g>
				</svg>
			</div>

			<p class="product__delivery-text">FREE delivery</p>
		</div>
		<div class="product__delivery-info tooltip-wrapper">
			<svg fill="#000000" width="800px" height="800px" viewBox="0 -8 528 528" xmlns="http://www.w3.org/2000/svg" style="
    width: 20px;
    height: 20px;
">
				<title>info</title>
				<path d="M264 456Q210 456 164 429 118 402 91 356 64 310 64 256 64 202 91 156 118 110 164 83 210 56 264 56 318 56 364 83 410 110 437 156 464 202 464 256 464 310 437 356 410 402 364 429 318 456 264 456ZM296 208L296 144 232 144 232 208 296 208ZM296 368L296 240 232 240 232 368 296 368Z"></path>
			</svg>

			<div class="tooltip-text">
				Free Next Day Delivery for orders before 6pm. Also available for same day delivery, 2hr delivery &amp; self-collection
			</div>
		</div>
	</div>
</div> -->
<!-- <div class="newBonny"> -->
<div class="custom_product product_meta extractdetails">

	<div class="metaBox_content characteristics">
		<?php

		$attributes = $product->get_attributes();

		if (!empty($attributes)) :
			echo '<ul class="product-attributes-list">';
			foreach ($attributes as $attribute) :
				if ($attribute->get_visible()) : // Check if the attribute is visible on the product page
					$name = wc_attribute_label($attribute->get_name()); // Get the attribute name
					$value = $attribute->is_taxonomy()
						? implode(', ', wc_get_product_terms($product->get_id(), $attribute->get_name(), ['fields' => 'names']))
						: implode(', ', $attribute->get_options()); // Get the attribute value(s)

					// Check if the attribute is "Country" or "Country of Origin"
					if (stripos($name, 'country') !== false) {
						$country = is_array($value) ? implode(', ', $value) : $value;

						// Fetch the flag using REST Countries API
						$api_url = "https://restcountries.com/v3.1/name/" . urlencode($country) . "?fields=flags";
						$response = wp_remote_get($api_url);
						$flag_url = '';

						if (!is_wp_error($response)) {
							$data = wp_remote_retrieve_body($response);
							$country_data = json_decode($data, true);

							if (isset($country_data[0]['flags']['png'])) {
								$flag_url = $country_data[0]['flags']['png'];
							}
						}

						// Display the country with the flag
						echo '<div class="custom_characteristics">';
						echo '<span class="attribute-name">' . esc_html($name) . '</span>';
						echo '<span class="middle_line"></span>';
						echo '<span class="attribute-value">';
						if (!empty($flag_url)) {
							echo '<img src="' . esc_url($flag_url) . '" alt="' . esc_attr($country) . ' Flag" style="width: 20px; height: 15px; margin-right: 5px;" />';
						}
						echo esc_html($country);
						echo '</span>';
						echo '</div>';
					} else {
						// Display other attributes normally
						echo '<div class="custom_characteristics">';
						echo '<span class="attribute-name">' . esc_html($name) . '</span>';
						echo '<span class="middle_line"></span>';
						echo '<span class="attribute-value">' . esc_html(is_array($value) ? implode(', ', $value) : $value) . '</span>';
						echo '</div>';
					}
				endif;
			endforeach;
			echo '</ul>';
		else :
			echo '<p>' . esc_html__('No attributes found.', 'woocommerce') . '</p>';
		endif;
		?>
	</div>
</div>
<div class="custom_product product_meta newdescriotion">
	<h3 class="product__info-title">
		<div class="titl">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff" width="800px" height="800px" viewBox="-51.2 -51.2 614.40 614.40" id="_x30_1" version="1.1" xml:space="preserve" stroke="#ffffff" stroke-width="0.00512">

				<g id="SVGRepo_bgCarrier" stroke-width="0">

					<rect x="-51.2" y="-51.2" width="614.40" height="614.40" rx="307.2" fill="#000000" strokewidth="0" />

				</g>

				<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

				<g id="SVGRepo_iconCarrier">
					<g>
						<path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M390.062,375.438 c0,20.193-16.37,36.562-36.562,36.562h-195c-20.193,0-36.562-16.37-36.562-36.562V136.562c0-20.193,16.37-36.562,36.562-36.562H256 c20.193,0,36.562,16.37,36.562,36.562v24.375c0,20.193,16.37,36.562,36.562,36.562H353.5c20.193,0,36.562,16.37,36.562,36.562 V375.438z" />
						<path d="M323.031,253.562H188.969c-10.096,0-18.281,8.185-18.281,18.281s8.185,18.281,18.281,18.281h134.062 c10.096,0,18.281-8.185,18.281-18.281S333.128,253.562,323.031,253.562z" />
						<path d="M323.031,326.688H188.969c-10.096,0-18.281,8.185-18.281,18.281s8.185,18.281,18.281,18.281h134.062 c10.096,0,18.281-8.185,18.281-18.281S333.128,326.688,323.031,326.688z" />
					</g>
				</g>

			</svg>
			Description
		</div>

		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" class="toggle-metaBox" data-toggle="description" version="1.1" id="Capa_1" width="800px" height="800px" viewBox="0 0 45.402 45.402" xml:space="preserve">
			<g>
				<path d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141   c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27   c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435   c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z"></path>
			</g>
		</svg>
	</h3>
	<div class="metaBox_content description">
		<p class="custom_descdib"><?php echo $product->get_description(); ?></p>
	</div>
</div>
</div>
<!-- </div> -->
 
<style>
	.metaBox_content {
		visibility: visible;
		/* Default visibility is visible */
		height: auto;
		/* Default height is auto */
		overflow: hidden;
		transition: visibility 0.3s, height 0.3s ease;
	}

	.metaBox_content.hidden {
		visibility: hidden;
		height: 0;
		margin: 0;
	}

	.toggle-metaBox {
		width: 18px !important;
		height: 18px !important;
	}

	.toggle-metaBox {
		cursor: pointer;
		transition: transform 0.3s ease;
	}

	.toggle-metaBox.active {
		transform: rotate(0deg);
	}

	.toggle-metaBox {
		transform: rotate(45deg);
	}

	.newBonny .product__info-title {
		align-items: center;
	}
</style>


<script>
	document.addEventListener("DOMContentLoaded", function() {
		const toggles = document.querySelectorAll(".product__info-title");

		toggles.forEach(toggle => {
			toggle.addEventListener("click", function() {
				const svgToggle = this.querySelector(".toggle-metaBox");
				const targetClass = svgToggle.getAttribute("data-toggle");
				const targetContent = document.querySelector(`.metaBox_content.${targetClass}`);

				if (targetContent.classList.contains("hidden")) {
					targetContent.classList.remove("hidden");
					svgToggle.classList.remove("active");
				} else {
					targetContent.classList.add("hidden");
					svgToggle.classList.add("active");
				}
			});
		});
		if (document.querySelector('.metaBox_content.characteristics').innerText == "") {
			document.querySelector('.custom_product.product_meta').style.display = 'none'
		}
		document.querySelectorAll('span[data-mce-fragment="1"]').forEach(function(span) {
			if (span.innerHTML.trim() === '&nbsp;') {
				span.style.display = 'none';
			}
		});
	});
	document.addEventListener("DOMContentLoaded", function() {
		const categoryCount = document.getElementById("category_count");
		const readMoreBtn = document.getElementById("read_more_btn");

		readMoreBtn.addEventListener("click", function() {
			if (categoryCount.classList.contains("expanded")) {
				categoryCount.classList.remove("expanded");
				readMoreBtn.textContent = "Read More";
			} else {
				categoryCount.classList.add("expanded");
				readMoreBtn.textContent = "Read Less";
			}
		});
		const categoryLinks = document.querySelectorAll('.category_count a');
		if (categoryLinks.length <= 5) {
			document.querySelector('.read-more').style.display = 'none';
		}


	});
</script>