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
        $today = now();

        return view('home', [
            // 1. Projekty (stále platí)
            'featured_projects' => Project::where('visibility', 'public')
                ->orderBy('sort_order')
                ->take(3) // Snížíme na 3, ať stránka není moc dlouhá
                ->with('coverPhoto')
                ->get(),
                
            // 2. Výstavy (stále platí)
            'upcoming_exhibitions' => Exhibition::where('is_visible', true)
                ->where(function($query) {
                    $query->whereDate('end_date', '>=', now())
                          ->orWhereNull('end_date');
                })
                ->orderBy('start_date')
                ->take(1) // Stačí jen ta úplně nejbližší
                ->get(),

            // 3. NOVÉ: Poslední článek
            'latest_article' => Article::where('is_visible', true)
                ->orderBy('published_at', 'desc')
                ->first(),

            // 4. NOVÉ: Náhodný výběr fotek (Inspirace)
            'random_photos' => \App\Models\Photo::where('is_visible', true)
                ->inRandomOrder()
                ->take(8)
                ->get(),

            // 5. NOVÉ: Oslavenec dne
            'birthday_people' => Person::whereMonth('birth_date', $today->month)
                ->whereDay('birth_date', $today->day)
                ->with('avatar')
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
     * Detail projektu s kontrolou hesla
     */
    public function projectShow(string $slug): View
    {
        // 1. Najdeme projekt (povolíme public i password, ale ne private)
        $project = Project::where('slug', $slug)
            ->whereIn('visibility', ['public', 'password']) 
            ->firstOrFail();

        // 2. Pokud je zaheslovaný
        if ($project->visibility === 'password') {
            // Zkontrolujeme, zda už uživatel nemá "odemčeno" v session
            $sessionKey = 'project_unlocked_' . $project->id;
            
            if (!session($sessionKey)) {
                // Pokud NEMA odemčeno, zobrazíme formulář pro zadání hesla
                // Vrátíme speciální view, ne detail projektu
                return view('projects.password', compact('project'));
            }
        }

        // 3. Pokud je veřejný nebo odemčený, načteme data a zobrazíme
        $project->load(['photos' => function($query) {
            $query->orderByPivot('sort_order');
        }]);

        return view('projects.show', compact('project'));
    }

    /**
     * Zpracování hesla (POST request)
     */
    public function unlockProject(Request $request, string $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        if ($request->input('password') === $project->password) {
            // Heslo souhlasí -> Uložíme do session
            session(['project_unlocked_' . $project->id => true]);
            
            return redirect()->route('projects.show', $slug);
        }

        // Heslo nesouhlasí -> Zpět s chybou
        return back()->withErrors(['password' => 'Neplatné heslo.']);
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
     * Seznam výstav (Plánované a Proběhlé)
     */
    public function exhibitions(): View
    {
        $futureExhibitions = Exhibition::where('is_visible', true)
            ->where(function($query) {
                $query->whereDate('end_date', '>=', now())
                      ->orWhereNull('end_date');
            })
            ->orderBy('start_date', 'asc')
            ->get();

        $pastExhibitions = Exhibition::where('is_visible', true)
            ->whereDate('end_date', '<', now())
            ->orderBy('end_date', 'desc')
            ->get();

        return view('exhibitions.index', compact('futureExhibitions', 'pastExhibitions'));
    }

    /**
     * Detail výstavy
     */
    public function exhibitionShow(string $slug): View
    {
        $exhibition = Exhibition::where('slug', $slug)
            ->where('is_visible', true)
            ->firstOrFail();

        $exhibition->load(['photos' => function($query) {
            $query->where('is_visible', true)
                  ->orderByPivot('sort_order');
        }]);

        return view('exhibitions.show', compact('exhibition'));
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