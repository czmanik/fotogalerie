<?php

namespace Tests\Feature;

use App\Models\HeroSlide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeroSlideTest extends TestCase
{
    use RefreshDatabase;

    public function test_hero_carousel_component_renders_slides()
    {
        $slide1 = HeroSlide::create([
            'title' => 'Slide 1',
            'description' => 'Desc 1',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $slide2 = HeroSlide::create([
            'title' => 'Slide 2',
            'description' => 'Desc 2',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Slide 1');
        $response->assertSee('Desc 1');
        $response->assertSee('Slide 2');
        $response->assertSee('Desc 2');
    }

    public function test_inactive_slides_are_not_rendered()
    {
        $slide1 = HeroSlide::create([
            'title' => 'Active Slide',
            'is_active' => true,
        ]);

        $slide2 = HeroSlide::create([
            'title' => 'Inactive Slide',
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Active Slide');
        $response->assertDontSee('Inactive Slide');
    }
}
