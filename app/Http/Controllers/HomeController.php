<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\Project;
use App\Models\Person;
use App\Models\Exhibition;
use App\Models\Article;

class HomeController extends Controller
{
    /**
     * Hlavní stránka (Homepage)
     */
    public function index(): View
    {
        return view('home', [
            // 6 vybraných projektů pro "Portfolio" sekci na hlavní straně
            'featured_projects' => Project::where('visibility', 'public')
                ->orderBy('sort_order')
                ->take(6)
                ->with('coverPhoto') // Eager loading pro rychlost
                ->get(),
                
            // Nejbližší výstavy (budoucí nebo probíhající)
            'upcoming_exhibitions' => Exhibition::where('is_visible', true)
                ->where(function($query) {
                    $query->whereDate('end_date', '>=', now())
                          ->orWhereNull('end_date');
                })
                ->orderBy('start_date')
                ->take(3)
                ->get(),
        ]);
    }

    /**
     * Seznam všech projektů
     */
    public function projects(): View
    {
        return view('projects.index', [
            'projects' => Project::where('visibility', 'public')
                ->orderBy('sort_order')
                ->with('coverPhoto')
                ->get(), // Zde můžeme později dát ->paginate(12)
        ]);
    }

    /**
     * Detail konkrétního projektu
     */
    public function projectShow(string $slug): View
    {
        $project = Project::where('slug', $slug)
            ->where('visibility', '!=', 'private') // Ukážeme i password protected, heslo pořešíme v View
            ->with(['photos' => function($query) {
                $query->orderBy('sort_order'); // Fotky seřazené dle pivotu
            }])
            ->firstOrFail();

        return view('projects.show', compact('project'));
    }

    /**
     * Seznam osobností (Katalog)
     */
    public function people(): View
    {
        return view('people.index', [
            'people' => Person::orderBy('last_name')
                ->with('avatar')
                ->get() // Nebo ->paginate(20)
        ]);
    }

    /**
     * Detail osobnosti + fotky s ní
     */
    public function personShow(string $id): View // Hledáme podle ID, nemáme slug u lidí (zatím)
    {
        $person = Person::with(['photos' => function($query) {
                $query->where('is_visible', true);
            }])
            ->findOrFail($id);

        return view('people.show', compact('person'));
    }

    /**
     * O mně + Články + Výstavy
     */
    public function about(): View
    {
        return view('about', [
            'articles' => Article::where('is_visible', true)
                ->orderBy('published_at', 'desc')
                ->get(),
                
            'exhibitions' => Exhibition::where('is_visible', true)
                ->orderBy('start_date', 'desc') // Historie výstav
                ->get(),
        ]);
    }

    /**
     * Kontakt
     */
    public function contact(): View
    {
        return view('contact');
    }
}