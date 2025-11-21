jQuery(function ($) {
    $(document).on('wc-blocks_added_to_cart', function () {
        console.log('jQuery', typeof jQuery);
        console.log("Added to cart");
        $('.alert-result').remove();
        const $link = $button.siblings('.added_to_cart.wc-forward').first();
        if ($link.length) {
            const alertContainer = $('.alert-result');
            if (!alertContainer.length) $('body').append('<div class="alert-result alert alert-success"></div>');

            $('.alert-result').empty().append($link.clone()).fadeIn(200);

            setTimeout(() => $('.alert-result').fadeOut(300), 5000);
        }
    });
});