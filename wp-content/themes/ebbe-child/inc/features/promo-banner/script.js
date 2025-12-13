jQuery(function ($) {
    var banner = $('.promo-banner');
    if (!banner.length) return;

    var countdown = $('.promo-banner-countdown');

    const countdown_enabled = banner.attr('data-countdown-enabled');
    const countdown_end     = banner.attr('data-countdown-end');

    if (countdown_enabled === '0' || !countdown_end || countdown_end.trim() === '') {
        countdown.remove();
        return;
    }

    var target_time = new Date(countdown_end).getTime();
    if (isNaN(target_time)) {
        countdown.remove();
        return;
    }

    var now = Date.now();
    if (target_time <= now) {
        countdown.remove();
        return;
    }

    function updateCountdown() {
        var now_time = Date.now();
        var diff = target_time - now_time;

        if (diff <= 0) {
            countdown.remove();
            clearInterval(interval_id);
            return;
        }

        var seconds_total = Math.floor(diff / 1000);

        var days = Math.floor(seconds_total / 86400);
        var hours = Math.floor((seconds_total % 86400) / 3600);
        var minutes = Math.floor((seconds_total % 3600) / 60);
        var seconds = seconds_total % 60;

        $('.countdown-days').text(pad(days));
        $('.countdown-hours').text(pad(hours));
        $('.countdown-minutes').text(pad(minutes));
        $('.countdown-seconds').text(pad(seconds));
    }

    function pad(value) {
        value = parseInt(value, 10);
        if (isNaN(value)) return '00';
        return value < 10 ? '0' + value : String(value);
    }

    updateCountdown();

    var interval_id = setInterval(updateCountdown, 1000);
});