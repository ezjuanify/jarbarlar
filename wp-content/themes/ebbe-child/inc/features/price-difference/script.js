jQuery(function ($) {
    function extractPrice(node) {
        if (!node) return 0;

        const text = node.textContent || "";
        const numeric = parseFloat(text.replace(/[^0-9.]/g, ""));

        return isNaN(numeric) ? 0 : numeric;
    }

    $('.price').each(function () {
        const priceDiv = this;

        const insNode = priceDiv.querySelector('ins bdi');
        const delNode = priceDiv.querySelector('del bdi');

        if (!insNode || !delNode) return;

        const original = extractPrice(delNode);
        const sale = extractPrice(insNode);

        if (!original || !sale || sale >= original) return;

        const diff = (original - sale).toFixed(2);

        const el = document.createElement('span');
        el.classList.add('price-difference-amount');
        el.textContent = `Save $${diff}`;

        priceDiv.appendChild(el);
    });
});