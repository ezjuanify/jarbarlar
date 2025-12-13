jQuery(function ($) {
    function applyPhoneMask(selector) {
        $(selector).keydown(function (e) {
            var key = e.which || e.charCode || e.keyCode || 0;
            var phone = $(this);

            // Allow backspace, tab, delete, and number keys
            if (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
                if (phone.val().length >= 12 && key !== 8 && key !== 46) {
                    // Prevent further input if length is 12 (except backspace or delete)
                    return false;
                }

                if (key !== 8 && key !== 46) {
                    // Add dash after 3rd and 7th characters
                    if (phone.val().length === 3) {
                        phone.val(phone.val() + '-');
                    }
                    if (phone.val().length === 7) {
                        phone.val(phone.val() + '-');
                    }
                }
                return true;
            } else {
                return false; // Block all other keys
            }
        });
    }

    // Apply mask to all relevant fields
    applyPhoneMask('#billing_phone');
    applyPhoneMask('#shipping_phone');
    applyPhoneMask('#account_phone');
});