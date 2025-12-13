<?php

namespace Tests\Feature;

use App\Filament\Resources\HeroSlideResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminHeroSlideTest extends TestCase
{
    use RefreshDatabase;

    public function test_hero_slide_resource_page_loads()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(HeroSlideResource::getUrl('index'))
            ->assertSuccessful();
    }
}
