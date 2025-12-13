jQuery(function ($) {
    $(document).on('change', '.product-variations input[type="radio"]', function () {
        const variantId     = $(this).val();
        const $closest      = $(this).closest('.product-bottom');
        const $addToCartBtn = $closest.find('.add_to_cart_button');

        if (!$addToCartBtn.length) return;

        // Update the Add to Cart button dynamically
        $addToCartBtn
            .attr('data-product_id', variantId)
            .attr('href', `?add-to-cart=${variantId}`)
            .addClass('button add_to_cart_button ajax_add_to_cart')
            .text('Add to Cart / Bundle')
            .css('display', 'flex');

        // Remove any previously added WooCommerce "Add to cart" notice
        $closest.find('.button.select-options').remove();
    });
});
