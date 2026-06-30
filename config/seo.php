<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default OG image
    |--------------------------------------------------------------------------
    |
    | Path relative to public/ (passed to asset()). Set to null to omit the
    | og:image when a page does not provide one explicitly.
    |
    */

    'default_image' => env('SEO_DEFAULT_IMAGE'),

    /*
    |--------------------------------------------------------------------------
    | Landing slug separator
    |--------------------------------------------------------------------------
    |
    | Word inserted between the category slug and city slug when auto-building
    | a Landing slug. Default '' produces "alquiler-generadores-madrid".
    | Set to "en" via .env (LANDING_SLUG_SEPARATOR=en) for the longer, more
    | readable "alquiler-generadores-en-madrid".
    |
    */

    'landing_slug_separator' => env('LANDING_SLUG_SEPARATOR', ''),

    /*
    |--------------------------------------------------------------------------
    | Organization (JSON-LD)
    |--------------------------------------------------------------------------
    |
    | Seeded once per request into the global @graph. Each cloned site fills
    | this in with its own brand identity.
    |
    */

    'organization' => [
        'name' => env('SEO_ORG_NAME'), // null falls back to config('app.name')
        'type' => ['Organization'],
        'logo' => env('SEO_ORG_LOGO'), // path under public/, e.g. 'images/logo.png'
        'area_served' => ['@type' => 'Country', 'name' => 'España'],
        'same_as' => array_values(array_filter([
            env('SEO_ORG_LINKEDIN'),
            env('SEO_ORG_INSTAGRAM'),
            env('SEO_ORG_TWITTER'),
        ])),
    ],
];
