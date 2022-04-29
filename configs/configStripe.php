<?php
require_once('vendor/autoload.php');

//xejx-uksl-pdsc-pjyl-ylvw
$stripe = [
  "secret_key"      => "sk_test_51K0tCgKnLQRB9YMGkDAFwO4jL4guZqczNPIU2GuEbkenVSKYCi1VO21zG7pPGgOGkSVLcrMgIA2oICeSMuMpjd9G00J6DVx0eq",
  "publishable_key" => "pk_test_51K0tCgKnLQRB9YMGlxiaZXNGU37Fp9lVvNQiCob7rvwccp7zWVU09RiNzsBeedlQeru0NClQ7anxdu0fnL38X5Nw00PnexIyrt",
];

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
