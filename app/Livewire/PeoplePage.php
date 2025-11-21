<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Person;

class PeoplePage extends Component
{
    public $activeCategory = 'Vše'; // Výchozí stav
    public $limit = 12; // Kolik lidí ukázat na začátku
    
    // Seznam kategorií (musí odpovídat tomu, co jsi zadal v Adminu)
    // Můžeš přidat další podle potřeby
    public $categoriesList = [
        'Herec', 
        'Zpěvák', 
        'Politik', 
        'Sportovec', 
        'Model/ka',
        'Jiné'
    ];

    // Metoda pro přepnutí kategorie
    public function setCategory($category)
    {
        $this->activeCategory = $category;
        $this->limit = 12; // Resetujeme limit při změně kategorie
    }

    // Metoda pro načtení dalších
    public function loadMore()
    {
        $this->limit += 12;
    }

    // Pomocná metoda pro získání počtu lidí v kategorii
    public function getCountForCategory($category)
    {
        if ($category === 'Vše') {
            return Person::count();
        }
        // Hledáme v JSON sloupci
        return Person::whereJsonContains('categories', $category)->count();
    }

    public function render()
    {
        // 1. Připravíme dotaz
        $query = Person::query()->orderBy('last_name');

        // 2. Pokud není vybráno "Vše", filtrujeme podle JSON
        if ($this->activeCategory !== 'Vše') {
            $query->whereJsonContains('categories', $this->activeCategory);
        }

        // 3. Zjistíme, jestli je jich víc než limit (pro tlačítko)
        $totalCount = (clone $query)->count();
        $hasMore = $totalCount > $this->limit;

        // 4. Získáme data s limitem
        $people = $query->with('avatar')
            ->take($this->limit)
            ->get();

        return view('livewire.people-page', [
            'people' => $people,
            'hasMore' => $hasMore,
        ])->layout('components.layout', ['title' => 'Osobnosti']);
    }
}