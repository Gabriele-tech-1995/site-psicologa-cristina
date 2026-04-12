<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

/**
 * JSON-LD globale del layout: la parte WebSite/Person/Psychologist è cacheata
 * (stessa per tutte le URL) per ridurre CPU/TTFB su ogni richiesta.
 */
final class SeoLayoutLinkedData
{
    private const CACHE_TTL_SECONDS = 3600;

    public static function ogImage(): string
    {
        $psy = config('seo.psychologist', []);

        return asset($psy['og_image'] ?? 'img/og-image.jpg');
    }

    /**
     * URL pubblico del woff2 del font titoli (600 latin, da manifest Vite), per preload nel layout.
     */
    public static function headingFontLatin600Woff2Url(): ?string
    {
        $path = public_path('build/manifest.json');
        if (! is_readable($path)) {
            return null;
        }

        $manifest = json_decode(file_get_contents($path), true);
        if (! is_array($manifest)) {
            return null;
        }

        foreach ($manifest as $key => $entry) {
            if (! is_string($key) || ! is_array($entry)) {
                continue;
            }
            if (! str_contains($key, 'source-serif-4-latin-600-normal.woff2')) {
                continue;
            }
            $file = $entry['file'] ?? null;
            if (! is_string($file) || $file === '') {
                return null;
            }

            return asset('build/'.$file);
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    public static function graph(string $currentUrl, string $metaTitle, string $metaDescription): array
    {
        $siteUrl = url('/');
        $static = self::cachedStaticGraphNodes($siteUrl);

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                $static['website'],
                $static['person'],
                $static['psychologist'],
                [
                    '@type' => 'WebPage',
                    '@id' => $currentUrl.'#webpage',
                    'url' => $currentUrl,
                    'name' => $metaTitle,
                    'description' => $metaDescription,
                    'isPartOf' => ['@id' => $siteUrl.'/#website'],
                    'about' => ['@id' => $siteUrl.'/#person'],
                    'inLanguage' => 'it-IT',
                ],
            ],
        ];
    }

    /**
     * @return array{website: array<string, mixed>, person: array<string, mixed>, psychologist: array<string, mixed>}
     */
    private static function cachedStaticGraphNodes(string $siteUrl): array
    {
        $psy = config('seo.psychologist', []);
        $cacheKey = 'seo.ld.static.v1.'.md5(serialize($psy).$siteUrl);

        return Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, static function () use ($siteUrl, $psy): array {
            $sameAs = $psy['same_as'] ?? ['https://wa.me/393441122785'];

            $postalFromLocation = static function (array $loc): array {
                return array_filter([
                    '@type' => 'PostalAddress',
                    'streetAddress' => $loc['street_address'] ?? null,
                    'addressLocality' => $loc['address_locality'] ?? null,
                    'addressRegion' => $loc['address_region'] ?? null,
                    'postalCode' => $loc['postal_code'] ?? null,
                    'addressCountry' => $loc['address_country'] ?? 'IT',
                ], fn ($v) => $v !== null && $v !== '');
            };

            $locationsConfig = $psy['locations'] ?? [];
            $psyPostal = isset($locationsConfig[0])
                ? $postalFromLocation($locationsConfig[0])
                : array_filter([
                    '@type' => 'PostalAddress',
                    'streetAddress' => data_get($psy, 'address.street_address'),
                    'addressLocality' => data_get($psy, 'address.address_locality', 'Tivoli'),
                    'addressRegion' => data_get($psy, 'address.address_region', 'RM'),
                    'postalCode' => data_get($psy, 'address.postal_code'),
                    'addressCountry' => data_get($psy, 'address.address_country', 'IT'),
                ], fn ($v) => $v !== null && $v !== '');

            $psyPlaceLocations = [];
            foreach ($locationsConfig as $loc) {
                $addr = $postalFromLocation($loc);
                if ($addr === []) {
                    continue;
                }
                $place = [
                    '@type' => 'Place',
                    'name' => $loc['name'] ?? null,
                    'address' => $addr,
                ];
                if (! empty($loc['maps_url'])) {
                    $place['hasMap'] = $loc['maps_url'];
                }
                $psyPlaceLocations[] = array_filter($place, fn ($v) => $v !== null && $v !== '');
            }

            $psychologistNode = [
                '@type' => 'Psychologist',
                '@id' => $siteUrl.'/#practice',
                'name' => $psy['practice_name'] ?? ($psy['name'] ?? 'Dott.ssa Cristina Pacifici'),
                'url' => $siteUrl,
                'image' => asset($psy['image'] ?? 'img/cristina.webp'),
                'telephone' => $psy['telephone'] ?? null,
                'email' => $psy['email'] ?? null,
                'address' => $psyPostal,
                'contactPoint' => [
                    array_filter([
                        '@type' => 'ContactPoint',
                        'telephone' => $psy['telephone'] ?? null,
                        'contactType' => 'customer support',
                        'areaServed' => 'IT',
                        'availableLanguage' => ['it'],
                    ], fn ($v) => $v !== null && $v !== ''),
                ],
                'areaServed' => $psy['area_served'] ?? ['Tivoli', 'Online'],
                'availableLanguage' => ['it'],
                'sameAs' => $sameAs,
            ];

            if (count($psyPlaceLocations) === 1) {
                $psychologistNode['location'] = $psyPlaceLocations[0];
            } elseif (count($psyPlaceLocations) > 1) {
                $psychologistNode['location'] = $psyPlaceLocations;
            }

            $psychologistNode = array_filter(
                $psychologistNode,
                fn ($v) => $v !== null && $v !== ''
            );

            return [
                'website' => [
                    '@type' => 'WebSite',
                    '@id' => $siteUrl.'/#website',
                    'url' => $siteUrl,
                    'name' => $psy['name'] ?? 'Dott.ssa Cristina Pacifici',
                    'inLanguage' => 'it-IT',
                ],
                'person' => [
                    '@type' => 'Person',
                    '@id' => $siteUrl.'/#person',
                    'name' => $psy['name'] ?? 'Dott.ssa Cristina Pacifici',
                    'jobTitle' => $psy['job_title'] ?? 'Psicologa',
                    'url' => $siteUrl,
                    'knowsAbout' => $psy['knows_about'] ?? [],
                    'sameAs' => $sameAs,
                ],
                'psychologist' => $psychologistNode,
            ];
        });
    }
}
