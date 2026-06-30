<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Cookie consent', function () {
    describe('with Google Tag Manager configured', function () {
        beforeEach(function () {
            config()->set('services.google_tag_manager.id', 'GTM-TEST123');
        });

        it('should render the GTM snippet and the consent banner', function () {
            $response = $this->get('/');

            $response->assertOk()
                ->assertSee('GTM-TEST123', false)
                ->assertSee('googletagmanager.com/gtm.js', false)
                ->assertSee('Usamos cookies');
        });

        it('should emit Consent Mode defaults before the GTM loader', function () {
            $content = $this->get('/')->getContent();

            $consentPos = strpos($content, "gtag('consent', 'default'");
            $gtmPos = strpos($content, 'googletagmanager.com/gtm.js');

            expect($consentPos)->not->toBeFalse()
                ->and($gtmPos)->not->toBeFalse()
                ->and($consentPos)->toBeLessThan($gtmPos);
        });

        it('should expose the configured cookie name in the banner', function () {
            config()->set('services.cookie_consent.name', 'rental_cookie_consent');

            $this->get('/')
                ->assertOk()
                ->assertSee('rental_cookie_consent', false);
        });
    });

    describe('without Google Tag Manager configured', function () {
        beforeEach(function () {
            config()->set('services.google_tag_manager.id', null);
        });

        it('should not render GTM nor the consent banner', function () {
            $response = $this->get('/');

            $response->assertOk()
                ->assertDontSee('googletagmanager.com/gtm.js', false)
                ->assertDontSee('Usamos cookies');
        });
    });

    describe('when authenticated', function () {
        beforeEach(function () {
            config()->set('services.google_tag_manager.id', 'GTM-TEST123');
        });

        it('should not render GTM nor the consent banner for logged-in users', function () {
            $this->actingAs(User::factory()->create());

            $this->get('/')
                ->assertOk()
                ->assertDontSee('googletagmanager.com/gtm.js', false)
                ->assertDontSee('Usamos cookies');
        });
    });
});
