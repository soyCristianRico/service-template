{{-- Google Consent Mode v2 — default state. MUST be placed before the GTM snippet. --}}
{{-- Tags load (no hard blocking) but run in a cookieless/denied state until the --}}
{{-- visitor accepts via the cookie banner. Returning visitors restore their stored choice. --}}
@php($cookieName = config('services.cookie_consent.name'))
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }

    (function () {
        var stored = null;
        try {
            var match = document.cookie.match(/(?:^|;\s*){{ $cookieName }}=([^;]+)/);
            if (match) { stored = JSON.parse(decodeURIComponent(match[1])); }
        } catch (e) { stored = null; }

        var analytics = stored && stored.analytics ? 'granted' : 'denied';
        var marketing = stored && stored.marketing ? 'granted' : 'denied';

        gtag('consent', 'default', {
            ad_storage: marketing,
            ad_user_data: marketing,
            ad_personalization: marketing,
            analytics_storage: analytics,
            wait_for_update: 500
        });
    })();
</script>
