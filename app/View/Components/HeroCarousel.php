<?php

namespace App\View\Components;

use App\Models\HeroSlide;
use Illuminate\View\Component;

class HeroCarousel extends Component
{
    public $slides;

    public function __construct()
    {
        $this->slides = HeroSlide::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($slide) {
                // Determine image URL
                $imageUrl = null;
                if ($slide->hasMedia('hero')) {
                    $imageUrl = $slide->getFirstMediaUrl('hero');
                } elseif ($slide->photo) {
                    $imageUrl = $slide->photo->getFirstMediaUrl('default', 'large'); // Assuming 'large' conversion exists
                    if (!$imageUrl) {
                        $imageUrl = $slide->photo->getFirstMediaUrl('default');
                    }
                }

                // Fallback image if nothing found
                if (!$imageUrl) {
                    $imageUrl = 'https://images.unsplash.com/photo-1554048612-387768052bf7?q=80&w=2000&auto=format&fit=crop';
                }

                $slide->image_url = $imageUrl;
                return $slide;
            });
    }

    public function shouldRender(): bool
    {
        return $this->slides->isNotEmpty();
    }

    public function render()
    {
        return view('components.hero-carousel');
    }
}
