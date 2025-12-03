# Dokumentace systému Fotogalerie

Tento dokument slouží jako technický přehled systému pro vývojáře a AI asistenty (např. Gemini). Popisuje architekturu, datový model a klíčové procesy aplikace.

## 1. Přehled technologií

Systém je postaven na moderním PHP stacku:
*   **Framework:** Laravel 12 (PHP 8.4)
*   **Admin Panel:** Filament PHP 3.2
*   **Frontend Interaktivita:** Laravel Livewire
*   **Správa souborů:** Spatie Media Library
*   **Databáze:** MySQL

## 2. Datový model a Entity

Jádrem systému jsou následující Eloquent modely umístěné v `app/Models`:

### Photo (Fotografie)
Centrální entita systému.
*   **Atributy:** `title`, `description`, `slug` (unikátní URL), `is_visible`, `sort_order`, `captured_at`.
*   **Media:** Využívá `Spatie\MediaLibrary` pro ukládání souborů (konverze `thumb`, `medium`, `large`).
*   **Vztahy:**
    *   `projects`: M:N relace s projekty (tabulka `project_photo`).
    *   `people`: M:N relace s osobnostmi (tabulka `photo_person`).
    *   `variants`: 1:N relace sama na sebe (`parent_id`) pro varianty téže fotky.
*   **Logika:** Při uložení se automaticky generuje unikátní `slug`.

### Project (Projekt)
Kolekce fotografií s možností omezení přístupu.
*   **Atributy:** `title`, `slug`, `description`, `visibility` (`public`, `password`, `private`), `password`, `sort_order`.
*   **Vztahy:**
    *   `photos`: M:N relace. V pivot tabulce se udržuje `sort_order` pro řazení fotek v rámci konkrétního projektu.
    *   `coverPhoto`: Odkaz na úvodní fotku projektu.

### Person (Osobnost)
Lidé zachycení na fotografiích.
*   **Atributy:** `first_name`, `last_name`, `categories` (uloženo jako JSON - např. Herec, Zpěvák...), `bio`.
*   **Vztahy:**
    *   `avatar`: Odkaz na `Photo`, která slouží jako profilovka.

### PhotoSlot & Message (Rezervační systém)
Jednoduchý systém pro objednávání focení.
*   **PhotoSlot:** Předdefinovaný termín (`start_at`, `status` - `free`, `pending`, `booked`).
*   **Message:** Objednávka/zpráva vázaná na slot. Obsahuje kontaktní údaje klienta.

### Další entity
*   **Exhibition:** Informace o výstavách (datum, místo).
*   **Article:** Odkazy na články v médiích.

## 3. Funkcionalita a Logika

### 3.1 Veřejná část (Frontend)

Frontend je renderován pomocí Blade šablon a Livewire komponent. Hlavní logiku obsluhuje `HomeController`.

*   **Homepage:** Zobrazuje výběr projektů, nejbližší výstavu, náhodné fotky a "oslavence dne" (podle `birth_date`).
*   **Projekty (`/projekty`):**
    *   Detail projektu (`ProjectShow`) kontroluje viditelnost.
    *   **Zaheslované projekty:** Pokud má projekt `visibility = 'password'`, systém vyžaduje zadání hesla. Po úspěšném zadání se uloží příznak do session (`project_unlocked_{id}`).
*   **Osobnosti (`/osobnosti`):**
    *   Řešeno přes Livewire komponentu `PeoplePage`.
    *   Umožňuje filtrování podle kategorií (načítá se z JSON sloupce).
    *   Detail osobnosti zobrazuje všechny fotky, na kterých je osoba označena.

### 3.2 Detail fotky a Navigace (`PhotoDetail`)

Detail fotky (`/foto/{slug}`) je Livewire komponenta s pokročilou logikou navigace (předchozí/další fotka). Chování závisí na kontextu:

1.  **Kontext Projektu (`?projectId=X`):**
    *   Pokud uživatel přijde z projektu, v URL se předává ID projektu.
    *   Navigace listuje pouze fotkami v daném projektu.
    *   **Řazení:** Respektuje `sort_order` definovaný v pivot tabulce projektu.

2.  **Globální kontext (Bez `projectId`):**
    *   Pokud uživatel přijde z homepage nebo přímým odkazem.
    *   **Řazení:** Náhodné, ale konzistentní během návštěvy.
    *   **Implementace:** Do session se uloží `photo_gallery_seed` (náhodné číslo). Toto číslo se použije pro deterministické zamíchání (`shuffle`) všech dostupných ID fotek. Tím je zajištěno, že uživatel při klikání na "Další" neuvidí stejnou fotku dvakrát a může se vracet zpět.

### 3.3 Rezervace (`BookingPage`)

Livewire komponenta pro výběr termínu.
*   Zobrazuje volné sloty seskupené po měsících.
*   Při odeslání formuláře se slot přepne do stavu `pending` a vytvoří se záznam v `Message`.

## 4. Administrace (Filament)

Administrace se nachází na `/admin`.
*   Standardní CRUD operace pro všechny entity.
*   Používá se plugin `spatie/laravel-medialibrary-plugin` pro nahrávání obrázků přímo ve formulářích.
*   **Generování slugů:** Probíhá automaticky v modelu (observer `saving`), pokud není vyplněn ručně. Řeší duplicity přidáním čísla.

## 5. Důležité poznámky pro vývoj

*   **Přiřazování fotek:** Fotky lze nahrávat hromadně v sekci Fotografie a následně je přiřazovat k projektům nebo osobnostem.
*   **Média:** Při změně definic konverzí (v `Photo.php`) je nutné přegenerovat obrázky pomocí `php artisan media-library:regenerate`.
*   **Route Cache:** Systém používá `Route::view` a standardní kontrolery. Při změnách rout nezapomenout na `php artisan route:clear`.
