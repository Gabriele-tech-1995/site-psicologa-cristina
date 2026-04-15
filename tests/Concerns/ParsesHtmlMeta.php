<?php

namespace Tests\Concerns;

trait ParsesHtmlMeta
{
    protected function parseHtmlTitle(string $html): string
    {
        preg_match('#<title>(.*?)</title>#s', $html, $m);

        return isset($m[1]) ? html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8') : '';
    }

    protected function parseMetaDescription(string $html): string
    {
        preg_match('#<meta\s+name="description"\s+content="([^"]*)"#', $html, $m);

        return isset($m[1]) ? html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8') : '';
    }

    protected function countH1(string $html): int
    {
        return preg_match_all('/<h1\b/i', $html) ?: 0;
    }

    protected function parseCanonicalHref(string $html): string
    {
        preg_match('#<link rel="canonical" href="([^"]+)"#', $html, $m);

        return $m[1] ?? '';
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function areasFromController(): array
    {
        $controller = $this->app->make(\App\Http\Controllers\PublicController::class);
        $method = new \ReflectionMethod($controller, 'getAreas');
        $method->setAccessible(true);

        return $method->invoke($controller);
    }
}
