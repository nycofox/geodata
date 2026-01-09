<?php

namespace Tests\Feature\Api;

use App\Models\Geo\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CountryApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and authenticate
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    public function test_can_list_all_countries(): void
    {
        // Create some test countries
        Country::factory()->count(5)->create();

        $response = $this->getJson('/api/countries');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'cca2',
                        'cca3',
                        'name_common',
                        'name_official',
                        'region',
                    ],
                ],
            ])
            ->assertJsonCount(5, 'data');
    }

    public function test_can_search_countries_by_name(): void
    {
        Country::factory()->create([
            'name_common' => 'Spain',
            'cca2' => 'ES',
            'cca3' => 'ESP',
        ]);
        Country::factory()->create([
            'name_common' => 'France',
            'cca2' => 'FR',
            'cca3' => 'FRA',
        ]);

        $response = $this->getJson('/api/countries?search=Spain');

        $response->assertStatus(200)
            ->assertJsonFragment(['name_common' => 'Spain'])
            ->assertJsonMissing(['name_common' => 'France']);
    }

    public function test_can_search_countries_by_code(): void
    {
        Country::factory()->create([
            'name_common' => 'Spain',
            'cca2' => 'ES',
            'cca3' => 'ESP',
        ]);
        Country::factory()->create([
            'name_common' => 'France',
            'cca2' => 'FR',
            'cca3' => 'FRA',
        ]);

        $response = $this->getJson('/api/countries?search=ESP');

        $response->assertStatus(200)
            ->assertJsonFragment(['cca3' => 'ESP'])
            ->assertJsonMissing(['cca3' => 'FRA']);
    }

    public function test_can_filter_countries_by_region(): void
    {
        Country::factory()->create([
            'name_common' => 'Spain',
            'region' => 'Europe',
        ]);
        Country::factory()->create([
            'name_common' => 'Japan',
            'region' => 'Asia',
        ]);

        $response = $this->getJson('/api/countries?region=Europe');

        $response->assertStatus(200)
            ->assertJsonFragment(['name_common' => 'Spain'])
            ->assertJsonMissing(['name_common' => 'Japan']);
    }

    public function test_can_filter_countries_by_subregion(): void
    {
        Country::factory()->create([
            'name_common' => 'Spain',
            'region' => 'Europe',
            'subregion' => 'Southern Europe',
        ]);
        Country::factory()->create([
            'name_common' => 'Sweden',
            'region' => 'Europe',
            'subregion' => 'Northern Europe',
        ]);

        $response = $this->getJson('/api/countries?subregion=Southern+Europe');

        $response->assertStatus(200)
            ->assertJsonFragment(['name_common' => 'Spain'])
            ->assertJsonMissing(['name_common' => 'Sweden']);
    }

    public function test_can_sort_countries_by_name(): void
    {
        Country::factory()->create(['name_common' => 'Zambia']);
        Country::factory()->create(['name_common' => 'Albania']);
        Country::factory()->create(['name_common' => 'Morocco']);

        $response = $this->getJson('/api/countries?sort_by=name_common&sort_order=asc');

        $response->assertStatus(200);
        $data = $response->json('data');

        $this->assertEquals('Albania', $data[0]['name_common']);
    }

    public function test_can_sort_countries_descending(): void
    {
        Country::factory()->create(['name_common' => 'Zambia']);
        Country::factory()->create(['name_common' => 'Albania']);
        Country::factory()->create(['name_common' => 'Morocco']);

        $response = $this->getJson('/api/countries?sort_by=name_common&sort_order=desc');

        $response->assertStatus(200);
        $data = $response->json('data');

        $this->assertEquals('Zambia', $data[0]['name_common']);
    }

    public function test_can_paginate_countries(): void
    {
        // Create 25 countries
        Country::factory()->count(25)->create();

        $response = $this->getJson('/api/countries?per_page=10');

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');

        // Verify there are more pages
        $json = $response->json();
        $this->assertGreaterThan(10, $json['total'] ?? $json['meta']['total'] ?? 0);
    }

    public function test_pagination_respects_max_per_page(): void
    {
        Country::factory()->count(150)->create();

        $response = $this->getJson('/api/countries?per_page=200');

        $response->assertStatus(200);
        $this->assertLessThanOrEqual(100, count($response->json('data')));
    }

    public function test_can_get_single_country_by_id(): void
    {
        $country = Country::factory()->create([
            'name_common' => 'Spain',
            'cca2' => 'ES',
            'cca3' => 'ESP',
        ]);

        $response = $this->getJson("/api/countries/{$country->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name_common' => 'Spain',
                'cca2' => 'ES',
                'cca3' => 'ESP',
            ]);
    }

    public function test_can_get_single_country_by_cca2(): void
    {
        Country::factory()->create([
            'name_common' => 'Spain',
            'cca2' => 'ES',
            'cca3' => 'ESP',
        ]);

        $response = $this->getJson('/api/countries/ES');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name_common' => 'Spain',
                'cca2' => 'ES',
            ]);
    }

    public function test_can_get_single_country_by_cca3(): void
    {
        Country::factory()->create([
            'name_common' => 'Spain',
            'cca2' => 'ES',
            'cca3' => 'ESP',
        ]);

        $response = $this->getJson('/api/countries/ESP');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name_common' => 'Spain',
                'cca3' => 'ESP',
            ]);
    }

    public function test_returns_404_for_nonexistent_country(): void
    {
        $response = $this->getJson('/api/countries/XXX');

        $response->assertStatus(404)
            ->assertJsonFragment(['message' => 'Country not found']);
    }

    public function test_requires_authentication_for_countries_list(): void
    {
        // Remove authentication
        $this->app['auth']->forgetGuards();

        $response = $this->getJson('/api/countries');

        $response->assertStatus(401);
    }

    public function test_requires_authentication_for_single_country(): void
    {
        $country = Country::factory()->create();

        // Remove authentication
        $this->app['auth']->forgetGuards();

        $response = $this->getJson("/api/countries/{$country->id}");

        $response->assertStatus(401);
    }

    public function test_can_combine_search_filter_and_sort(): void
    {
        Country::factory()->create([
            'name_common' => 'Spain',
            'region' => 'Europe',
            'subregion' => 'Southern Europe',
        ]);
        Country::factory()->create([
            'name_common' => 'Italy',
            'region' => 'Europe',
            'subregion' => 'Southern Europe',
        ]);
        Country::factory()->create([
            'name_common' => 'France',
            'region' => 'Europe',
            'subregion' => 'Western Europe',
        ]);

        $response = $this->getJson('/api/countries?region=Europe&subregion=Southern+Europe&sort_by=name_common&sort_order=asc');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');

        $data = $response->json('data');
        $this->assertEquals('Italy', $data[0]['name_common']);
        $this->assertEquals('Spain', $data[1]['name_common']);
    }
}
