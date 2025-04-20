<?php
define('RAZORPAY_KEY_ID', 'rzp_test_90K0mMoxixnleY');
define('RAZORPAY_KEY_SECRET', '8qYtZhj2FG9NARNsh4XHxjN5');

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use Razorpay\Api\Api;

function getRazorpayInstance() {
    return new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
}
?>
