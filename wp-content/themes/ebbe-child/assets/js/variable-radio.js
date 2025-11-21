jQuery(function ($) {

    const $form = $("form.variations_form");
    if (!$form.length) return;

    let variations;
    try {
        variations = JSON.parse($form.attr("data-product_variations"));
    } catch (e) {
        console.error("Variation JSON parse failed", e);
        return;
    }

    $("table.variations select").each(function () {

        const $select = $(this);
        const attr_name = $select.attr('name');
        const td = $select.closest("td");

        $select.find('option').each(function () {

            const $option = $(this);
            const val = $option.val();
            if (!val) return;

            // Build wrapper <span>
            const wrapper = document.createElement("span");
            wrapper.classList.add("variation-radio-wrapper");

            // Create radio input
            const radio = document.createElement("input");
            radio.type = "radio";
            radio.name = attr_name;
            radio.value = val;
            radio.id = `${attr_name}-${val}`;
            if ($option.is(":selected")) radio.checked = true;

            // Create label
            const label = document.createElement('label');
            label.setAttribute("for", radio.id);
            label.appendChild(document.createTextNode($option.text()));

            // Append DOM elements
            wrapper.appendChild(radio);
            wrapper.appendChild(label);
            td.appendChild(wrapper);

            radio.addEventListener("click", () => {
                $select.val(radio.value);
                $select.trigger('change');
            });
        });
        $select.hide();
    }); 
});