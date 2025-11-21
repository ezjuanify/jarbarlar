<?php

/**
 * Utils: Get Collection Metadata
 */
function get_collection_metadata($slug) {
    // Fetch collection
    $collection = get_term_by('slug', $slug, 'product_cat');
    if (!$collection) {
        return [
            'error'   => true,
            'message' => 'Collection not found.',
        ];
    }

    $thumbnail_id = get_term_meta($collection->term_id, 'thumbnail_id', true);

    return [
        'error'                => false,
        'term'                 => $collection,
        'slug'                 => $slug,
        'thumbnail_id'         => $thumbnail_id,
        'collection_image_url' => $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '',
        'collection_url'       => get_term_link($collection),
    ];
}


/**
 * Utils: Get Current User Loyalty Points
 */
function get_loyalty_points($product) {
    if (!$product instanceof WC_Product) {
        return 0;
    }

    $cache_key     = 'custom_loyalty_points_product_' . $product->get_id();
    $cached_points = get_transient($cache_key);

    if ($cached_points !== false) {
        return (int) $cached_points;
    }

    $points = 0;

    if (class_exists('Wlr\App\Helpers\EarnCampaign')) {
        $earn_campaign = Wlr\App\Helpers\EarnCampaign::getInstance();
        $user_email = is_user_logged_in() ? wp_get_current_user()->user_email : '';

        $extra = [
            'product'            => $product,
            'is_calculate_based' => 'product',
            'user_email'         => $user_email,
            'is_message'         => true,
        ];

        $cart_action_list = $earn_campaign->getProductActionList();
        $reward_list      = $earn_campaign->getActionEarning($cart_action_list, $extra);

        foreach ($reward_list as $rewards) {
            foreach ($rewards as $reward) {
                if (!empty($reward['point'])) {
                    $points += (int) $reward['point'];
                }
            }
        }
    }

    set_transient($cache_key, $points, HOUR_IN_SECONDS * 2);

    return (int) $points;
}


/**
 * Utils: Get Flag Image  via Country Code.
 */
function get_country_flag_url(WC_Product $product) {
    if (empty($product->get_attribute('country'))) return '';

    $country   = $product->get_attribute('country');
    $country   = strtolower(sanitize_text_field($country));
    $flag_url  = 'https://flagcdn.com/h40/' . $country . '.png';
    $ch        = curl_init($flag_url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 404) return;

    return $flag_url;
}
?>