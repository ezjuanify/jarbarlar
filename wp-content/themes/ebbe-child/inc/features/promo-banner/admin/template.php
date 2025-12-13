<div class="wrap">
    <h1>Promo Banner Settings</h1>

    <form method="post" action="options.php">
        <?php
        settings_fields('promo_banner_settings_group');
        do_settings_sections('promo-banner-settings');
        submit_button();
        ?>
    </form>
</div>