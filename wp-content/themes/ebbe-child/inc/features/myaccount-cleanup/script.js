jQuery(function ($) {
    const el = document.querySelector('.woocommerce-MyAccount-content p');
    if (!el) return;

    const cleaned = el.innerHTML.replace(/\(.*?\)/g, '');
    el.innerHTML = cleaned;
});