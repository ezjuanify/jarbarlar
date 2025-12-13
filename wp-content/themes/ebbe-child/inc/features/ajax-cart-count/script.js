jQuery(function ($) {
    const updateCartCount = () => {
        $.post(ajaxCartCount.ajaxUrl, { action: 'get_cart_count'})
            .done(response => {
                if (response.success) {
                    $('.cart-count').text(response.data.count);
                } else {
                    console.warn("Error retrieving updated cart count");
                }
            })
            .fail(() => console.error("Failed to fetch updated cart count"));
    };

    const addCartCountSpan = () => {
        const icon = $('.fas.fa-shopping-bag');
        if (icon.length && !$('.cart-count').length) {
            icon.after('<span class="cart-count">0</span>');
            updateCartCount();
        }
    }

    addCartCountSpan();

    $('body').on('click', '.add_to_cart_button', () => {
        setTimeout(updateCartCount, 1000);
    });

    $(document.body).on('updated_cart_totals updated_wc_div', updateCartCount);
});