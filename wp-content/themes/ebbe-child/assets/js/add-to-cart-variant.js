(function ($) {
    'use strict';

    $(document).on('change', '.product_variants input[type="radio"]', function () {
        const variantId = $(this).data('variant-id');
        const productWrapper = $(this).closest('.products-wrapper');
        const addToCartBtn = productWrapper.find('.add_to_cart_button');

        if (!addToCartBtn.length) return;

        // Update the Add to Cart button dynamically
        addToCartBtn
            .attr('data-product_id', variantId)
            .attr('href', `?add-to-cart=${variantId}`)
            .removeClass('product_type_variable')
            .addClass('ajax_add_to_cart product_type_simple')
            .text('Add to Cart');

        // Remove any previously added WooCommerce "Add to cart" notice
        productWrapper.find('.added_to_cart.wc-forward').remove();

        // Restore button visibility
        addToCartBtn.css('display', 'flex');
    });
})(jQuery);
