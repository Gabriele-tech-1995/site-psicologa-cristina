<?php

namespace Tests\Unit;

use App\Support\SeoContact;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SeoContactTest extends TestCase
{
    #[Test]
    public function locations_include_maps_open_url_from_address(): void
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
        $url = $contact['locations'][0]['maps_open_url'] ?? null;
        $this->assertIsString($url);
        $this->assertStringContainsString('https://www.google.com/maps/search/', $url);
        $this->assertStringContainsString('query=', $url);
        $this->assertStringContainsString(rawurlencode('Via Roma 1, Tivoli, RM, Italia'), $url);
    }

    #[Test]
    public function maps_embed_url_is_used_as_external_link_when_no_maps_url(): void
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
            $contact['locations'][0]['maps_open_url'] ?? null
        );
    }

    #[Test]
    public function maps_url_is_preferred_over_address_for_open_link(): void
    {
        config()->set('seo.psychologist.locations', [
            [
                'name' => 'Y',
                'street_address' => 'Via Roma 1',
                'address_locality' => 'Tivoli',
                'address_region' => 'RM',
                'address_country' => 'IT',
                'maps_url' => 'https://maps.google.com/?q=Centro+Imago+Tivoli',
            ],
        ]);

        $contact = SeoContact::forView();
        $this->assertSame(
            'https://maps.google.com/?q=Centro+Imago+Tivoli',
            $contact['locations'][0]['maps_open_url'] ?? null
        );
    }
}
