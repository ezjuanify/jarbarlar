jQuery(function ($) {
    const phone = "0000000000000";
    const text  = "Welcome to Jarbarlar Chat";

    const wrapper = document.createElement("div");
    wrapper.classList.add("wh-api");

    const fixed = document.createElement("div");
    fixed.classList.add("wh-fixed", "whatsapp-pulse");

    const anchor = document.createElement("a");
    anchor.href=`https://api.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(text)}`;
    anchor.target="_blank";

    const button = document.createElement("button");
    button.classList.add("wp-ap-btn");

    anchor.appendChild(button);
    fixed.appendChild(anchor)
    wrapper.appendChild(fixed);

    $("body").append(wrapper);
});
