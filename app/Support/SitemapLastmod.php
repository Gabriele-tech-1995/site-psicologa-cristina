<?php

namespace App\Support;

final class SitemapLastmod
{
    /**
     * @var array<string, string>
     */
    private static array $cache = [];

    public static function forRoute(string $routeName): string
    {
        if (isset(self::$cache[$routeName])) {
            return self::$cache[$routeName];
        }

        $timestamps = [];
        foreach (self::sources()[$routeName] ?? [] as $relativePath) {
            $absolutePath = base_path($relativePath);
            if (is_file($absolutePath)) {
                $mtime = filemtime($absolutePath);
                if ($mtime !== false) {
                    $timestamps[] = $mtime;
                }
            }
        }

        $resolved = max($timestamps ?: [time()]);

        return self::$cache[$routeName] = gmdate(DATE_ATOM, $resolved);
    }

    /**
     * @return array<string, list<string>>
     */
    private static function sources(): array
    {
        return [
            'home' => [
                'resources/views/home.blade.php',
                'app/Http/Controllers/PublicController.php',
                'config/seo.php',
            ],
            'about' => [
                'resources/views/chi-sono.blade.php',
                'app/Http/Controllers/PublicController.php',
                'config/seo.php',
            ],
            'areas' => [
                'resources/views/aree.blade.php',
                'app/Http/Controllers/PublicController.php',
                'config/seo.php',
            ],
            'first-interview' => [
                'resources/views/primo-colloquio.blade.php',
                'app/Http/Controllers/PublicController.php',
                'config/seo.php',
            ],
            'contacts' => [
                'resources/views/contatti.blade.php',
                'app/Http/Controllers/PublicController.php',
                'config/seo.php',
            ],
            'testimonials' => [
                'resources/views/testimonianze.blade.php',
                'app/Http/Controllers/PublicController.php',
                'config/seo.php',
            ],
            'privacy' => [
                'resources/views/privacy.blade.php',
                'config/seo.php',
            ],
            'areas.show' => [
                'resources/views/area-show.blade.php',
                'app/Http/Controllers/PublicController.php',
                'config/seo.php',
            ],
        ];
    }
}
