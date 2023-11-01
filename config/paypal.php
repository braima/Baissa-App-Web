<?php

/**
* Paypal Config and Setting
*/
return[
    // Sandbox
    'sandbox_client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
    'sandbox_secret' => env('PAYPAL_SANDBOX_SECRET'),

    // Live
    'live_client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
    'live_secret' => env('PAYPAL_LIVE_SECRET'),

    // SDK Settings
    'settings' => [
        // Mode and TimeOut
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'http.ConnectionTimeOut' => 3000,

        // Logs
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() .'/logs/paypal.log',
        // Level, Debug, Info, Warn, Error
        'log.LogLevel' => 'DEBUG'
    ]
];

?>