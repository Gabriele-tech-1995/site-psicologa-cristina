<?php

namespace App\Support;

final class SeoContact
{
    /**
     * @return array{
     *     email: string,
     *     mailto: string,
     *     telephone: string,
     *     telephone_display: string,
     *     telephone_display_spaced: string,
     *     whatsapp_url: string,
     *     albo_registration_url: string,
     *     aspic_url: string,
     *     locations: array<int, array<string, mixed>>
     * }
     */
    public static function forView(): array
    {
        $psy = config('seo.psychologist', []);

        $email = strtolower((string) ($psy['email'] ?? ''));
        $tel = (string) ($psy['telephone'] ?? '');
        $digits = preg_replace('/\D/', '', $tel) ?? '';

        $whatsappUrl = $psy['whatsapp_url']
            ?? collect($psy['same_as'] ?? [])->first(static fn ($u) => is_string($u) && str_contains($u, 'wa.me'))
            ?? ($digits !== '' ? 'https://wa.me/'.$digits : '#');

        $nationalDigits = self::nationalDigits($digits);
        $telDisplay = $nationalDigits;
        $telDisplaySpaced = self::spaceItalianMobile($nationalDigits);

        $locations = $psy['locations'] ?? [];
        $locations = is_array($locations)
            ? array_map(static fn ($loc) => is_array($loc) ? self::withMapsEmbed($loc) : $loc, $locations)
            : [];

        $alboUrl = (string) ($psy['albo_registration_url'] ?? '');
        $aspicUrl = (string) ($psy['aspic_url'] ?? '');

        return [
            'email' => $email,
            'mailto' => $email !== '' ? 'mailto:'.$email : '#',
            'telephone' => $tel,
            'telephone_display' => $telDisplay,
            'telephone_display_spaced' => $telDisplaySpaced,
            'whatsapp_url' => is_string($whatsappUrl) ? $whatsappUrl : '#',
            'albo_registration_url' => $alboUrl,
            'aspic_url' => $aspicUrl,
            'locations' => $locations,
        ];
    }

    /**
     * @param  array<string, mixed>  $loc
     * @return array<string, mixed>
     */
    private static function withMapsEmbed(array $loc): array
    {
        $loc['maps_embed_src'] = self::mapsEmbedSrc($loc);

        return $loc;
    }

    /**
     * @param  array<string, mixed>  $loc
     */
    private static function mapsEmbedSrc(array $loc): ?string
    {
        if (! empty($loc['maps_embed_url']) && is_string($loc['maps_embed_url'])) {
            $url = trim($loc['maps_embed_url']);

            return $url !== '' ? $url : null;
        }

        // Prefer explicit map query/place data over plain address geocoding.
        $query = self::extractMapsQueryFromUrl($loc['maps_url'] ?? null);
        if ($query === '') {
            $query = self::locationGeocodeQuery($loc);
        }
        if ($query === '') {
            return null;
        }

        return 'https://www.google.com/maps?q='.rawurlencode($query).'&hl=it&output=embed';
    }

    /**
     * @param  array<string, mixed>  $loc
     */
    private static function locationGeocodeQuery(array $loc): string
    {
        $country = $loc['address_country'] ?? 'IT';
        $countryLabel = strtoupper((string) $country) === 'IT' ? 'Italia' : (string) $country;

        $parts = array_filter([
            $loc['street_address'] ?? null,
            $loc['address_locality'] ?? null,
            $loc['postal_code'] ?? null,
            $loc['address_region'] ?? null,
            $countryLabel,
        ], static fn ($v) => is_string($v) && $v !== '');

        return implode(', ', $parts);
    }

    private static function extractMapsQueryFromUrl(?string $url): string
    {
        if ($url === null || $url === '') {
            return '';
        }

        $parts = parse_url($url);

        if (! empty($parts['query'])) {
            parse_str($parts['query'], $query);
            if (! empty($query['q']) && is_string($query['q'])) {
                return $query['q'];
            }
        }

        // Handle URLs like .../maps/place/NomeLuogo+Tivoli/...
        $path = (string) ($parts['path'] ?? '');
        if ($path !== '' && preg_match('#/maps/place/([^/]+)#', $path, $matches) === 1) {
            return str_replace('+', ' ', urldecode($matches[1]));
        }

        return '';
    }

    private static function nationalDigits(string $digits): string
    {
        if ($digits === '') {
            return '';
        }

        if (str_starts_with($digits, '39') && strlen($digits) >= 12) {
            return substr($digits, 2);
        }

        return $digits;
    }

    private static function spaceItalianMobile(string $national): string
    {
        if (strlen($national) === 10) {
            return substr($national, 0, 3).' '.substr($national, 3, 2).' '.substr($national, 5, 2).' '.substr($national, 7);
        }

        return $national;
    }
}
