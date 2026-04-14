<?php

namespace App\Providers;

use App\Support\SeoContact;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $maxPerMinute = max(1, (int) config('antispam.contact.max_attempts_per_minute', 3));
        $maxPerHour = max($maxPerMinute, (int) config('antispam.contact.max_attempts_per_hour', 12));
        $maxPerHourPerEmail = max(1, (int) config('antispam.contact.max_attempts_per_hour_per_email', 6));

        $throttleResponse = static function (Request $request, array $headers) {
            $retryAfterSeconds = max(1, (int) ($headers['Retry-After'] ?? 60));
            $retryAfterMinutes = max(1, (int) ceil($retryAfterSeconds / 60));
            $minutesLabel = $retryAfterMinutes === 1 ? 'minuto' : 'minuti';

            return redirect()
                ->route('contacts')
                ->withErrors([
                    'rate_limit' => "Per proteggere il modulo da invii automatici, può riprovare tra circa {$retryAfterMinutes} {$minutesLabel}.",
                ])
                ->withInput()
                ->withFragment('richiesta-colloquio');
        };

        RateLimiter::for('contact-form-submit', static function (Request $request) use (
            $maxPerMinute,
            $maxPerHour,
            $maxPerHourPerEmail,
            $throttleResponse
        ): array {
            $ip = (string) $request->ip();
            $email = trim(Str::lower((string) $request->input('email', '')));
            $emailKey = $email !== '' ? $email : 'no-email';

            return [
                Limit::perMinute($maxPerMinute)->by("contact-submit:ip-minute:{$ip}")->response($throttleResponse),
                Limit::perHour($maxPerHour)->by("contact-submit:ip-hour:{$ip}")->response($throttleResponse),
                Limit::perHour($maxPerHourPerEmail)->by("contact-submit:email-hour:{$emailKey}|ip:{$ip}")->response($throttleResponse),
            ];
        });

        View::composer('*', static function ($view): void {
            $view->with('seoContact', SeoContact::forView());
        });
    }
}
