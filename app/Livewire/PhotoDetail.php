<?php

namespace App\Livewire;

use App\Models\Photo;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;

class PhotoDetail extends Component
{
    public $slug;
    public $photo;

    #[Url]
    public $projectId;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->loadPhoto();
    }

    public function loadPhoto()
    {
        $this->photo = Photo::where('slug', $this->slug)
            ->where('is_visible', true)
            ->with(['projects', 'people'])
            ->firstOrFail();

        // If the URL changes (e.g. via navigation), we update the slug property
        if ($this->slug !== $this->photo->slug) {
            $this->slug = $this->photo->slug;
        }
    }

    /**
     * Get the previous photo based on context.
     */
    public function getPreviousPhotoProperty()
    {
        return $this->getAdjacentPhoto('previous');
    }

    /**
     * Get the next photo based on context.
     */
    public function getNextPhotoProperty()
    {
        return $this->getAdjacentPhoto('next');
    }

    private function getAdjacentPhoto($direction)
    {
        if ($this->projectId) {
            return $this->getProjectAdjacentPhoto($direction);
        }

        return $this->getGlobalAdjacentPhoto($direction);
    }

    /**
     * Navigation within a Project.
     */
    private function getProjectAdjacentPhoto($direction)
    {
        $project = Project::find($this->projectId);

        if (!$project) {
            // Fallback to global if project not found
            $this->projectId = null;
            return $this->getGlobalAdjacentPhoto($direction);
        }

        // Get all visible photo IDs in this project, ordered by pivot
        $ids = $project->photos()
            ->where('photos.is_visible', true)
            ->orderByPivot('sort_order')
            ->pluck('photos.id')
            ->toArray();

        return $this->findAdjacentId($ids, $direction);
    }

    /**
     * Global Navigation (Randomized).
     */
    private function getGlobalAdjacentPhoto($direction)
    {
        // 1. Get or create a random seed for this session
        $seed = Session::get('photo_gallery_seed');
        if (!$seed) {
            $seed = rand();
            Session::put('photo_gallery_seed', $seed);
        }

        // 2. Fetch all visible photo IDs
        // Note: For very large datasets, fetching all IDs might be heavy.
        // Given the likely scale, this is acceptable. Optimized approach would use a temp table or cursor.
        $ids = Photo::where('is_visible', true)
            ->pluck('id')
            ->toArray();

        // 3. Shuffle deterministically based on seed
        mt_srand($seed);
        shuffle($ids);
        mt_srand(); // Reset random number generator

        return $this->findAdjacentId($ids, $direction);
    }

    private function findAdjacentId($ids, $direction)
    {
        $currentIndex = array_search($this->photo->id, $ids);

        if ($currentIndex === false) {
            // Current photo not in the list (maybe hidden or removed from project?)
            // Return random/first
            return isset($ids[0]) ? Photo::find($ids[0]) : null;
        }

        if ($direction === 'next') {
            $newIndex = $currentIndex + 1;
            if ($newIndex >= count($ids)) {
                $newIndex = 0; // Loop to start
            }
        } else {
            $newIndex = $currentIndex - 1;
            if ($newIndex < 0) {
                $newIndex = count($ids) - 1; // Loop to end
            }
        }

        return Photo::find($ids[$newIndex]);
    }

    public function render()
    {
        return view('livewire.photo-detail', [
            'photo' => $this->photo,
            'nextPhoto' => $this->nextPhoto,
            'previousPhoto' => $this->previousPhoto,
        ])->layout('components.layout');
    }
}
