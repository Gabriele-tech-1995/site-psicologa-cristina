<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('security.headers_enabled')) {
            return $next($request);
        }

        Vite::useCspNonce();
        view()->share('cspNonce', Vite::cspNonce());

        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set(
            'Permissions-Policy',
            'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=(), browsing-topics=(), interest-cohort=()',
        );
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        if (config('security.corp_same_origin')) {
            $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');
        }

        if ($request->secure()) {
            $hstsParts = ['max-age='.max(0, (int) config('security.hsts_max_age', 63072000))];
            if (config('security.hsts_include_subdomains')) {
                $hstsParts[] = 'includeSubDomains';
            }
            if (config('security.hsts_preload')) {
                $hstsParts[] = 'preload';
            }
            $response->headers->set('Strict-Transport-Security', implode('; ', $hstsParts));
        }

        $nonce = Vite::cspNonce();
        $connectPieces = array_merge(
            ["'self'"],
            config('security.csp_connect_src_extra', []),
            [
                'https://www.google-analytics.com',
                'https://*.google-analytics.com',
                'https://*.analytics.google.com',
            ],
        );
        $connectPieces = array_values(array_unique($connectPieces));

        $directives = [
            "default-src 'self'",
            "script-src 'nonce-{$nonce}' 'strict-dynamic' 'unsafe-inline' https:",
            "style-src 'self' 'unsafe-inline'",
            "img-src 'self' data: https: blob:",
            "font-src 'self'",
            'connect-src '.implode(' ', $connectPieces),
            "worker-src 'none'",
            "manifest-src 'self'",
            "frame-src 'self' https://www.google.com https://www.gstatic.com https://maps.google.com https://*.google.com",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
        ];

        if ($request->secure()) {
            $directives[] = 'upgrade-insecure-requests';
        }

        $response->headers->set('Content-Security-Policy', implode('; ', $directives));

        return $response;
    }
}
