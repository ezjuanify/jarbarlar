jQuery(function ($) {
    const checkbox = $('#promo_banner_countdown_enabled');
    const datetime = $('#promo_banner_countdown_end');

    console.log(checkbox);

    if (checkbox.length === 0 || datetime.length === 0) return;

    flatpickr('#promo_banner_countdown_end', {
        enableTime: true,
        time_24hr: true,
        defaultHour: 23,
        defaultMinute: 59,
        dateFormat: 'Y-m-d\\TH:i',
    });

    function updateState() {
        if (checkbox.is(':checked')) {
            datetime.prop('disabled', false);
        } else {
            datetime.prop('disabled', true);
            datetime.val('');
        }
    }

    checkbox.on('change', updateState);
    updateState();
});