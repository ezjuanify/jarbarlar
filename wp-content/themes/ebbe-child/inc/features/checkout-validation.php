<?php
add_action('woocommerce_after_checkout_validation', 'bks_validate_checkout_fields', 10, 2);
add_action('woocommerce_save_account_details_errors', 'bks_validate_account_details', 10, 1);
add_filter('woocommerce_add_error', 'bks_add_data_id_to_error_list', 10, 2);

function bks_validate_checkout_fields($fields, $errors) {
    validate_fields($fields, $errors);
}

function bks_validate_account_details($errors) {
    if (isset($_POST['account_first_name']) && !preg_match('/^[a-zA-Z ]+$/', $_POST['account_first_name'])) {
        $errors->add('validation_account_first_name', 'First name should only have characters.');
    }
    if (isset($_POST['account_last_name']) && !preg_match('/^[a-zA-Z ]+$/', $_POST['account_last_name'])) {
        $errors->add('validation_account_last_name', 'Last name should only have characters.');
    }
    if (isset($_POST['billing_phone']) && !preg_match('/^\+?[0-9 \-]+$/', $_POST['billing_phone'])) {
        $errors->add('validation_billing_phone', 'Phone number should only contain numbers, spaces, or +, - symbols.');
    }
}

function validate_fields($fields, $errors) {
    if (isset($fields['billing_first_name']) && !preg_match('/^[a-zA-Z ]+$/', $fields['billing_first_name'])) {
        $errors->add('validation_billing_first_name', 'First name should only have characters.');
    }
    if (isset($fields['billing_last_name']) && !preg_match('/^[a-zA-Z ]+$/', $fields['billing_last_name'])) {
        $errors->add('validation_billing_last_name', 'Last name should only have characters.');
    }
    if (isset($fields['billing_phone']) && !preg_match('/^\+?[0-9 \-]+$/', $fields['billing_phone'])) {
        $errors->add('validation_billing_phone', 'Phone number should only contain numbers, spaces, or +, - symbols.');
    }
}

function bks_add_data_id_to_error_list($error) {
    if (strpos($error, 'First name should only have characters.') !== false) {
        $error = '<li data-id="billing_first_name">' . $error . '</li>';
    } elseif (strpos($error, 'Last name should only have characters.') !== false) {
        $error = '<li data-id="billing_last_name">' . $error . '</li>';
    } elseif (strpos($error, 'Phone number should only contain numbers, spaces, or +, - symbols.') !== false) {
        $error = '<li data-id="billing_phone">' . $error . '</li>';
    }
    return $error;
}
?>