<?php

namespace App\Support;

class SpamDetector
{
    /**
     * @var list<string>
     */
    private const KEYWORD_PATTERNS = [
        '/\bseo\b/i',
        '/\bsearch\s*engine\s*optimization\b/i',
        '/\bbacklinks?\b/i',
        '/\bguest\s*post(s|ing)?\b/i',
        '/\blink\s*building\b/i',
        '/\btraffic\b/i',
        '/\blead\s*generation\b/i',
        '/\bmarketing\s*agency\b/i',
        '/\bdigital\s*marketing\b/i',
        '/\brank(?:ing)?\s*(?:on|in)?\s*google\b/i',
        '/\bboost\s+(?:your\s+)?(?:site|website|business)\b/i',
        '/\bfirst\s*page\b/i',
        '/\bserp\b/i',
        '/\bdr\b\s*\d+/i',
    ];

    /**
     * @var list<string>
     */
    private const URL_SHORTENER_PATTERNS = [
        '/https?:\/\/(?:bit\.ly|tinyurl\.com|cutt\.ly|t\.co|rebrand\.ly)\//i',
    ];

    public static function isLikelySpam(string $text): bool
    {
        $normalized = self::normalize($text);

        if ($normalized === '') {
            return false;
        }

        if (self::keywordHits($normalized) >= 2) {
            return true;
        }

        if (preg_match_all('/https?:\/\/\S+/i', $normalized) >= 3) {
            return true;
        }

        foreach (self::URL_SHORTENER_PATTERNS as $pattern) {
            if (preg_match($pattern, $normalized) === 1) {
                return true;
            }
        }

        if (preg_match('/(?:whatsapp|telegram|skype|discord|wechat)\s*[:@]?\s*[A-Za-z0-9_.-]{4,}/i', $normalized) === 1
            && self::keywordHits($normalized) > 0) {
            return true;
        }

        return false;
    }

    private static function keywordHits(string $text): int
    {
        $hits = 0;

        foreach (self::KEYWORD_PATTERNS as $pattern) {
            if (preg_match($pattern, $text) === 1) {
                $hits++;
            }
        }

        return $hits;
    }

    private static function normalize(string $text): string
    {
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text) ?? '';

        return trim($text);
    }
}
