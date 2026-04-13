<?php

namespace Tests\Unit;

use App\Support\SeoContact;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SeoContactTest extends TestCase
{
    #[Test]
    public function locations_include_maps_embed_src_from_address(): void
    {
        config()->set('seo.psychologist.locations', [
            [
                'name' => 'Test',
                'street_address' => 'Via Roma 1',
                'address_locality' => 'Tivoli',
                'address_region' => 'RM',
                'postal_code' => null,
                'address_country' => 'IT',
            ],
        ]);

        $contact = SeoContact::forView();
        $this->assertArrayHasKey('locations', $contact);
        $this->assertCount(1, $contact['locations']);
        $src = $contact['locations'][0]['maps_embed_src'] ?? null;
        $this->assertIsString($src);
        $this->assertStringContainsString('https://www.google.com/maps?', $src);
        $this->assertStringContainsString('output=embed', $src);
        $this->assertStringContainsString(rawurlencode('Via Roma 1, Tivoli, RM, Italia'), $src);
    }

    #[Test]
    public function maps_embed_url_overrides_generated_src(): void
    {
        config()->set('seo.psychologist.locations', [
            [
                'name' => 'X',
                'maps_embed_url' => 'https://www.google.com/maps/embed?pb=test',
            ],
        ]);

        $contact = SeoContact::forView();
        $this->assertSame(
            'https://www.google.com/maps/embed?pb=test',
            $contact['locations'][0]['maps_embed_src'] ?? null
        );
    }

    #[Test]
    public function maps_url_query_is_preferred_over_address(): void
    {
        config()->set('seo.psychologist.locations', [
            [
                'name' => 'Y',
                'street_address' => 'Via Roma 1',
                'address_locality' => 'Tivoli',
                'address_region' => 'RM',
                'address_country' => 'IT',
                'maps_url' => 'https://maps.google.com/?q=Piazza+Santa+Croce+12,+Tivoli',
            ],
        ]);

        $contact = SeoContact::forView();
        $src = $contact['locations'][0]['maps_embed_src'] ?? '';

        $this->assertStringContainsString(rawurlencode('Piazza Santa Croce 12, Tivoli'), $src);
        $this->assertStringNotContainsString(rawurlencode('Via Roma 1, Tivoli, RM, Italia'), $src);
    }
}
