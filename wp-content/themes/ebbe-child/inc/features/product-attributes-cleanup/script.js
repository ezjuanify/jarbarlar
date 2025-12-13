jQuery(function ($) {
    const p = document.querySelector('.custom_product.product_meta.extractdetails .metaBox_content.characteristics p');

    if (!p) return;

    const value = p.innerHTML.trim();

    if (value === '' || value === 'No attributes found.') {
        const container = document.querySelector('.custom_product.product_meta.extractdetails');
        if (container) {
            container.style.display = 'none';
        }
    }
});