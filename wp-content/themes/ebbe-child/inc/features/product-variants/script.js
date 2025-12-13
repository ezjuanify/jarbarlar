jQuery(function ($) {
    function buildPriceHTML(price, formatted = false) {
        const e_wrapper = document.createElement("div");
        const e_price   = document.createElement("span");
        const e_amount  = document.createElement("span");
        const e_bdi     = document.createElement("bdi");

        e_wrapper.classList.add("woocommerce-variation-price");
        e_price.classList.add("price");
        e_amount.classList.add("woocommerce-Price-amount", "amount");

        if (formatted) {
            const e_currency = document.createElement("span");
            e_currency.classList.add("woocommerce-Price-currencySymbol");
            e_currency.innerText = "$";

            e_bdi.appendChild(currency);
            e_bdi.appendChild(document.createTextNode(parseFloat(price).toFixed(2)));
        } else {
            e_bdi.innerText = price;
        }

        e_amount.append(e_bdi);
        e_price.append(e_amount);
        e_wrapper.append(e_price);

        return e_wrapper;
    }

    function updateVariant(radio) {
        const $radio       = $(radio);
        const product_id   = $radio.attr("name").split('-')[1];
        const price_val    = $radio.data("price");
        const variation_id = $radio.data("variation-id");

        const $price_container = $(`#product-price-${product_id}`);

        if ($price_container.length && price_val) {
            const is_formatted = $(".prd_item").length > 0;
            const price_html   = buildPriceHTML(price_val, is_formatted);

            $price_container.empty().append(price_html);
        }

        const $add_to_cart_button = $(`#add-to-cart-button-${product_id}`);
        const $variation_input    = $(`#variation-id-${product_id}`);

        if ($add_to_cart_button.length && $variation_input.length) {
            $variation_input.val(variation_id);
            $add_to_cart_button.text("Add to Cart");
            $add_to_cart_button.prop("disabled", false);
            $add_to_cart_button.removeClass("select-options").addClass("add-to-cart");
        }
    }

    $('input[type="radio"]').on("change", function () {
        updateVariant(this);
    });
});