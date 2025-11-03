<?php

/*
Plugin Name: Atom Payment Gateway
Plugin URI: http://atomtech.in/
Description: Extends WooCommerce by Adding the Atom Paynetz Gateway.
Version: 2.0.3
WC tested up to: 3.2.3
Author: Vikas Kapadiya
Author URI: https://Kapadiya.net/
 */

// Include our Gateway Class and register Payment Gateway with WooCommerce

if (!defined('ABSPATH')) {
    exit;
}

add_action('plugins_loaded', 'woocommerce_atom_init', 0);

function woocommerce_atom_init()
{
    // If the parent WC_Payment_Gateway class doesn't exist
    // it means WooCommerce is not installed on the site
    // so do nothing
    if (!class_exists('WC_Payment_Gateway')) {
        return;
    }

    // If we made it this far, then include our Gateway Class
    class WC_Gateway_Atom extends WC_Payment_Gateway
    {

        // Setup our Gateway's id, description and other values
        function __construct()
        {
            $this->id = "atom";
            $this->icon = plugins_url('assets/img/logo.png', __FILE__);
            $this->method_title = __("Atom Payment Gateway", 'wc_gateway_atom');
            $this->method_description = "Atom Gateway setting page.";
            $this->has_fields = false;

            $this->init_form_fields();
            $this->init_settings();

            $this->title = $this->settings['title'];
            $this->description = $this->settings['description'];
            $this->url = $this->settings['atom_domain'];
            $this->atom_port = $this->settings['atom_port'];
            $this->login_id = $this->settings['login_id'];
            $this->password = $this->settings['password'];

            $this->atom_product_id = $this->settings['atom_prod_id'];
            $this->notify_url = home_url('?wc-api=wc_gateway_atom');

            add_action('woocommerce_api_' . strtolower(get_class($this)), array($this, 'check_atom_response'));

            if (version_compare(WOOCOMMERCE_VERSION, '2.0.0', '>=')) {
                add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
            } else {
                add_action('woocommerce_update_options_payment_gateways', array(&$this, 'process_admin_options'));
            }

        }

        // Build the administration fields for this specific Gateway
        public function init_form_fields()
        {
            $this->form_fields = array(
                'enabled' => array(
                    'title' => __('Enable/Disable', 'wc_gateway_atom'),
                    'type' => 'checkbox',
                    'label' => __('Enable Atom Paynetz Module.', 'wc_gateway_atom'),
                    'default' => 'no',
                    'description' => 'Show in the Payment List as a payment option',
                ),
                'title' => array(
                    'title' => __('Title:', 'wc_gateway_atom'),
                    'type' => 'text',
                    'default' => __('Atom Gateway Payments', 'wc_gateway_atom'),
                    'description' => __('This controls the title which the user sees during checkout.', 'wc_gateway_atom'),
                    'desc_tip' => true,
                ),
                'description' => array(
                    'title' => __('Description:', 'wc_gateway_atom'),
                    'type' => 'textarea',
                    'default' => __("Pay securely by Credit or Debit Card or Internet Banking through Atom Technologies Secure Servers."),
                    'description' => __('This controls the description which the user sees during checkout.', 'wc_gateway_atom'),
                    'desc_tip' => true,
                ),
                'atom_domain' => array(
                    'title' => __('Atom Domain', 'wc_gateway_atom'),
                    'type' => 'text',
                    'description' => __('Will be provided by Atom Paynetz Team after production movement', 'wc_gateway_atom'),
                    'desc_tip' => true,
                ),
                'login_id' => array(
                    'title' => __('Login Id', 'wc_gateway_atom'),
                    'type' => 'text',
                    'description' => __('As provided by Atom Paynetz Team', 'wc_gateway_atom'),
                    'desc_tip' => true,
                ),
                'password' => array(
                    'title' => __('Password', 'wc_gateway_atom'),
                    'type' => 'password',
                    'description' => __('As provided by Atom Paynetz Team', 'wc_gateway_atom'),
                    'desc_tip' => true,
                ),
                'atom_prod_id' => array(
                    'title' => __('Product ID', 'wc_gateway_atom'),
                    'type' => 'text',
                    'description' => __('Will be provided by Atom Paynetz Team after production movement', 'wc_gateway_atom'),
                    'desc_tip' => true,
                ),
                'atom_port' => array(
                    'title' => __('Port Number', 'wc_gateway_atom'),
                    'type' => 'text',
                    'description' => __('80 for Test Server & 443 for Production Server', 'wc_gateway_atom'),
                    'desc_tip' => true,
                ),
            );
        }
        function check_atom_response()
        {
            global $woocommerce;
            $msg['class'] = 'error';
            $msg['message'] = "Thank you for shopping with us. However, the transaction has been declined.";

            if (isset($_REQUEST['f_code'])) {
                $order = new WC_Order($_REQUEST['mer_txn']);

                $bank_name = wc_clean($_REQUEST['bank_name']);
                $bank_txn = wc_clean($_REQUEST['bank_txn']);

                if (wc_clean($_REQUEST['f_code']) == 'Ok') {
                    $msg['message'] = "Thank you for shopping with us. Your account has been charged <b>Rs " . wc_clean($_REQUEST['amt']) . "</b> and your transaction is successful. Bank Transaction ID is  : <b>" . wc_clean($_REQUEST['bank_txn']) . "</b>.";
                    $msg['class'] = 'success';
                    $order->payment_complete();
                    $order->add_order_note('Atom payment successful<br/>Transaction ID: ' . wc_clean($_REQUEST['bank_txn']));
                    $woocommerce->cart->empty_cart();
                } else {
                    $order->update_status('failed');
                    $msg['class'] = 'error';
                    $msg['message'] = "Thank you for shopping with us. However, the transaction has been declined.";
                }
                if (function_exists('wc_add_notice')) {
                    wc_add_notice($msg['message'], $msg['class']);

                } else {
                    if ($msg['class'] == 'success') {
                        $woocommerce->add_message($msg['message']);
                    } else {
                        $woocommerce->add_error($msg['message']);

                    }
                    $woocommerce->set_messages();
                }

                $redirect_url = $this->get_return_url($order);
                wp_redirect($redirect_url);

                exit;
            }
        }

        // Submit payment and handle response
        public function process_payment($order_id)
        {

            global $woocommerce;
            $order = new WC_Order($order_id);

            $user_email = $order->billing_email;
            $first_name = $order->billing_first_nam;
            $last_name = $order->billing_last_name;
            $phone_number = $order->billing_phone;
            $country = wc()->countries->countries[$order->billing_country];
            $state = $order->billing_state;
            $city = $order->billing_city;
            $postcode = $order->billing_postcode;
            $address_1 = $order->billing_address_1;
            $address_2 = $order->billing_address_2;
            $udf1 = $first_name . " " . $last_name;
            $udf2 = $user_email;
            $udf3 = $phone_number;
            $udf4 = $country . " " . $state . " " . $city . " " . $address_1 . " " . $address_2 . " " . $postcode;

            $atom_login_id = $this->login_id;
            $atom_password = $this->password;
            $atom_prod_id = $this->atom_product_id;
            $amount = $order->get_total();
            $currency = "INR";
            $custacc = "1234567890";
            $txnid = $order_id;
            $clientcode = urlencode(base64_encode(007));
            $datenow = date("d/m/Y h:m:s");
            $encodedDate = str_replace(" ", "%20", $datenow);
            $ru = $this->notify_url;

            $param = "&login=" . $atom_login_id . "&pass=" . $atom_password . "&ttype=NBFundTransfer" . "&prodid=" . $atom_prod_id . "&amt=" . $amount . "&txncurr=" . $currency . "&txnscamt=0" . "&clientcode=" . $clientcode . "&txnid=" . $txnid . "&date=" . $encodedDate . "&custacc=" . $custacc . "&udf1=" . $udf1 . "&udf2=" . $udf2 . "&udf3=" . $udf3 . "&udf4=" . $udf4 . "&ru=" . $ru;
            global $wpdb, $woocommerce;

            $success = false;
            $error = "";

            try {
                $ch = curl_init();
                $useragent = 'woo-commerce plugin';
                curl_setopt($ch, CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_PORT, $this->atom_port);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
                curl_setopt($ch, CURLOPT_SSLVERSION, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                //information received from gateway is stored in $response.
                $response = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($response === false) {
                    $success = false;
                    $error = 'Curl error: ' . curl_error($ch);
                } else {

                    if ($http_status === 200) {
                        $success = true;
                    } else {
                        $success = false;

                        $error = "ATOM_ERROR:Invalid Response <br/>" . $result;

                    }
                }
                //close connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = "WOOCOMMERCE_ERROR:Request to ATOM Failed";
            }

            if ($success === true) {
                $parser = xml_parser_create('');
                xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
                xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
                xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
                xml_parse_into_struct($parser, trim($response), $xml_values);
                xml_parser_free($parser);

                $returnArray = array();
                $returnArray['url'] = $xml_values[3]['value'];
                $returnArray['tempTxnId'] = $xml_values[5]['value'];
                $returnArray['token'] = $xml_values[6]['value'];

                //code to generate form action
                $xmlObjArray = $returnArray;
                $url = $xmlObjArray['url'];

                $postFields = "";
                $postFields .= "&ttype=NBFundTransfer";
                $postFields .= "&tempTxnId=" . $xmlObjArray['tempTxnId'];
                $postFields .= "&token=" . $xmlObjArray['token'];
                $postFields .= "&txnStage=1";
                $q = $url . "?" . $postFields;

                return array('result' => 'success', 'redirect' => $q);
                exit;
            } else {
                $this->msg['class'] = 'error';
                $this->msg['message'] = "There was a error . please try other payment optin";
            }

            if (function_exists('wc_add_notice')) {
                wc_add_notice($this->msg['message'], $this->msg['class']);
            } else {
                if ($this->msg['class'] == 'success') {
                    $woocommerce->add_message($this->msg['message']);
                } else {
                    $woocommerce->add_error($this->msg['message']);

                }
                $woocommerce->set_messages();
            }

        }
    }

    // Now that we have successfully included our class,
    // Lets add it too WooCommerce
    add_filter('woocommerce_payment_gateways', 'add_atom_gateway');
    function add_atom_gateway($methods)
    {
        $methods[] = 'WC_Gateway_Atom';
        return $methods;
    }
}
