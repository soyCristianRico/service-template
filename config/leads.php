<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Notification email
    |--------------------------------------------------------------------------
    |
    | When set, every captured Lead is mailed to this address. When left empty,
    | the notification falls back to the first registered user (the site owner),
    | so leads are never silently lost on a fresh deploy.
    |
    */

    'notify_email' => env('LEAD_NOTIFY_EMAIL'),
];
