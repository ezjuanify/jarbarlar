jQuery(function ($) {
    $('.custom_characteristics').each(function() {
        const e_attribute_name = this.querySelector('.attribute-name');

        if (e_attribute_name && e_attribute_name.innerText.trim() === "Bundle Deal") {
            this.classList.add("hide-bundle-deal");
        }
    });
});
