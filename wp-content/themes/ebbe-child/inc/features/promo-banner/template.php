<?php
$heading  = get_option('promo_banner_heading', '');
$enabled  = get_option('promo_banner_countdown_enabled', '0');
$date_end = get_option('promo_banner_countdown_end', '');
?>

<div class="promo-banner" data-countdown-enabled="<?php echo esc_attr($enabled); ?>" data-countdown-end="<?php echo esc_attr($date_end) ?>">
    <div class="promo-banner-content">
        <span class="promo-banner-heading">
            <?php echo esc_html($heading); ?>
        </span>

        <?php if ($enabled === '1' && !empty($date_end)): ?>
            <span class="promo-banner-countdown">
                <span class="promo-banner-countdown-box">
                    <span class="promo-banner-countdown-value countdown-days"></span>
                    <span class="promo-banner-countdown-label">d</span>
                </span>

                <span class="promo-banner-countdown-box">
                    <span class="promo-banner-countdown-value countdown-hours"></span>
                    <span class="promo-banner-countdown-label">h</span>
                </span>

                <span class="promo-banner-countdown-box">
                    <span class="promo-banner-countdown-value countdown-minutes"></span>
                    <span class="promo-banner-countdown">m</span>
                </span>

                <span class="promo-banner-countdown-box">
                    <span class="promo-banner-countdown-value countdown-seconds"></span>
                    <span class="promo-banner-countdown">s</span>
                </span>
            </span>
        <?php endif; ?>
    </div>
</div>