<?php 

return [
    'seller_id' => env('TWOCHECKOUT_MERCHANT_ID'),
    'secret_key' => env('TWOCHECKOUT_SECRET_KEY'),
    'jwtExpireTime' => env('TWOCHECKOUT_JWT_EXIPRE_TIME'),
    'curlVerifySsl' => env('TWOCHECKOUT_CURL_SSL_VERIFY'),
];