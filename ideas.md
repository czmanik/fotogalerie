# PROJEKTY
1) ADMINISTRACE
    1.1) v detailu projektu je výpis fotek. Pokud kliknu na tlačítko edit nebo na řádek s fotkou, zobrazí se mi pop-up ve kterém mohu upravit název fotky. Ale očekával bych, že po kliknutí na edit se dostanu na editaci fotky jako takové. 
    1.2) není jakým způsobem změnit pořadí fotek. Tlačítko nad výpisem fotek Reorder records nefunguje. Neexistuje způsob jak přeskládat fotogfrafie.
        * chyba z tlačítka reorder records: Illuminate\Database\QueryException
            vendor\laravel\framework\src\Illuminate\Database\Connection.php:824
            SQLSTATE[23000]: Integrity constraint violation: 1052 Column 'sort_order' in order clause is ambiguous (Connection: mysql, SQL: select `project_photo`.`project_id` as `pivot_project_id`, `project_photo`.`photo_id` as `pivot_photo_id`, `project_photo`.`sort_order` as `pivot_sort_order`, `project_photo`.*, `photos`.* from `photos` inner join `project_photo` on `photos`.`id` = `project_photo`.`photo_id` where `project_photo`.`project_id` = 3 order by `project_photo`.`sort_order` asc, `sort_order` asc)
    1.3) výpis osobností v detailu projektu by měl fungovat jako odkaz na editaci profilu osobnosti
2) ZAHESLOVANÉ PROJEKTY - jakým způsobem bude implementováno? Navrhujuji následující řešení. Zaheslovaný projekt bude mít standartní URL (možnost vytvořit slug, nyní již implementováno). Projekt se nezobrazuje logicky ve výpisu projektů (implementováno). Při zadání URL zaheslovaného projektu musí proběhnout kontrola že je projekt zaheslovaný nebo veřejný! Dotaz na heslo a pak následně puštění do vnitř po zadání hesla.

# FOTKY 
1) DETAIL FOTOGRAFIE - veřejná část - vytvořit stránku pro prezentování detailu fotografie. Zde bude fotka, název, popis, výpis osobností na fotce, projekty kde je fotka uvedena, fotografie které jsou variantou fotky, pokud jsou nějaké.
    1.1) jak vyřešíme listováním fotek? Protože rozhoduje jakým způsobem se na fotku dostanu. Pokud se na ni dostanu z náhodného výpisu na homepage, jaké fotky by měli být v listování jako další? Pokud jdu ze stránky projektu, musím pak listovat v rámci projektu. Proto je potřeba vymyslet jakým způsobem nabízet další fotky pro listování.
2) ADMINISTRACE - cílem je zvýšit celkový UX zážitek z práce s fotkami. 
    2.1) do základního výpisu admin/photos přidáme vedle názvu i unikátní ID fotky. Pro lepší přehled.
    2.2) výpis fotek v administraci umožníme zobrazit i jako tabulkový výpis fotek
    2.3) přidáme filtrování fotek podle: projektů, kategorií osobností, jmen, viditelnosti

# NAHRÁVÁNÍ FOTOGRAFIÍ
1) nefunguje hromadné nahrávání (nelze vybrat více položek) - jakým způsobem to můžeme řešit? Popiš možnosti a aspekty řešení. 
2) v projektu když kliknu na přidat fotky
    2.1) nyní je to pomocí selectu s názvy fotek. Názvy ale můžou být stejné, proto bych přidáme id fotky. Tedy: id - název
3) když vyhledávám osobnosti při přidání, hledá mi to jen podle přijímení, ne podle křestního jména.

