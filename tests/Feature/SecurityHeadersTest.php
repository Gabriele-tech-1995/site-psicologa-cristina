<?php

namespace Tests\Feature;

use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_when_security_headers_disabled_home_has_no_csp(): void
    {
        config(['security.headers_enabled' => false]);

        $this->get(route('home'))->assertOk()->assertHeaderMissing('Content-Security-Policy');
    }

    public function test_when_security_headers_enabled_sets_csp_coop_and_corp(): void
    {
        config(['security.headers_enabled' => true]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('Cross-Origin-Opener-Policy', 'same-origin');
        $response->assertHeader('Cross-Origin-Resource-Policy', 'same-origin');
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("script-src 'nonce-", $csp);
        $this->assertStringContainsString("'strict-dynamic'", $csp);
        $this->assertStringContainsString("'unsafe-inline'", $csp);
        $this->assertStringContainsString('frame-ancestors', $response->headers->get('Content-Security-Policy'));
    }

    public function test_hsts_includes_preload_when_https_and_config(): void
    {
        config(['security.headers_enabled' => true]);
        config(['security.hsts_preload' => true]);
        config(['security.hsts_max_age' => 63072000]);

        $response = $this->withHeaders([
            'X-Forwarded-Proto' => 'https',
        ])->get(route('home'));

        $response->assertOk();
        $hsts = $response->headers->get('Strict-Transport-Security');
        $this->assertNotNull($hsts);
        $this->assertStringContainsString('max-age=63072000', $hsts);
        $this->assertStringContainsString('includeSubDomains', $hsts);
        $this->assertStringContainsString('preload', $hsts);
    }
}
