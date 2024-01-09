<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoriaController extends Controller
{
    private $token = 'c686a242c8693cda4e5819e0c5445efe';
    private $domainname = 'http://localhost/moodle';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //declarar funcion
        $functionname = 'core_course_get_categories';
        $serverurl = $this->domainname . '/webservice/rest/server.php'. '?wstoken=' . $this->token . '&wsfunction='.$functionname.'&moodlewsrestformat=json';
        $categorias = Http::get($serverurl);
        return view('admin.categoria.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $functionname = 'core_course_get_categories';
        $serverurl = $this->domainname . '/webservice/rest/server.php'. '?wstoken=' . $this->token . '&wsfunction='.$functionname.'&moodlewsrestformat=json';
        $categorias = Http::get($serverurl);
        return view('admin.categoria.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'scategoria' => 'required',
            'idnumber' => 'required',
            'description' => 'required',
        ]);
        $name =$request->input('name');
        $parent =$request->input('scategoria');
        $idnumber =$request->input('idnumber');
        $description =$request->input('description');
        $descriptionformat = 1;
        $functionname = 'core_course_create_categories';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json
        &categories[0][name]='.$name
        .'&categories[0][parent]='.$parent
        .'&categories[0][idnumber]='.$idnumber
        .'&categories[0][description]='.$description
        .'&categories[0][descriptionformat]='.$descriptionformat;
        $createcategory = Http::get($serverurl);
        return redirect()->route('admin.categorias.index')->with('info', 'Se creo la categoría');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $functionname = 'core_course_get_categories';
        $serverurl = $this->domainname . '/webservice/rest/server.php'. '?wstoken=' . $this->token . '&wsfunction='.$functionname.'&moodlewsrestformat=json';
        $serverurl2 = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&addsubcategories=0&criteria[0][key]=id&criteria[0][value]='.$id;
        $categorias = Http::get($serverurl);
        $ecategoria = Http::get($serverurl2);
        return view('admin.categoria.edit', compact('categorias', 'ecategoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'scategoria' => 'required',
            'idnumber' => 'required',
            'description' => 'required',
        ]);
        $name =$request->input('name');
        $parent =$request->input('scategoria');
        $idnumber =$request->input('idnumber');
        $description =$request->input('description');
        $descriptionformat = 1;
        $functionname = 'core_course_update_categories';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&categories[0][id]='.$id
        .'&categories[0][name]='.$name
        .'&categories[0][parent]='.$parent
        .'&categories[0][idnumber]='.$idnumber
        .'&categories[0][description]='.$description
        .'&categories[0][descriptionformat]='.$descriptionformat;
        $ucategoria = Http::get($serverurl);
        return redirect()->route('admin.categorias.index')->with('info', 'Se modifico la categoría');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function veliminar(string $id)
    {
        $functionname = 'core_course_get_categories';
        $functionname2 = 'core_course_get_courses_by_field';
        //listado de categoria
        $serverurl = $this->domainname . '/webservice/rest/server.php'. '?wstoken=' . $this->token . '&wsfunction='.$functionname.'&moodlewsrestformat=json';
        //categoria especifica sin subcategorias
        $serverurl2 = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&addsubcategories=0&criteria[0][key]=id&criteria[0][value]='.$id;
        //categoria especifica con subcategorias
        $serverurl3 = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&addsubcategories=1&criteria[0][key]=id&criteria[0][value]='.$id;
        //saber cuantos cursos tiene una categoria
        $serverurl4 = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname2
        .'&moodlewsrestformat=json&field=category&value='.$id;

        $categorias = Http::get($serverurl);
        $ecategoria = Http::get($serverurl2);
        $scategoria = Http::get($serverurl3);
        $ncursos = Http::get($serverurl4);
        $contador = 0;
        $contador2 = 0;
        foreach (json_decode($scategoria) as $item) {
            $contador = $contador + 1;
        }
        foreach (json_decode($ncursos)->courses as $item) {
            $contador2 = $contador2 + 1;
        }

        return view('admin.categoria.eliminar', compact('categorias', 'ecategoria', 'scategoria', 'contador', 'contador2'));
    }

    public function eliminar(Request $request, string $id)
    {
        $recursive =$request->input('recursive');
        $newparent =$request->input('newparent'); 
        $functionname = 'core_course_delete_categories';
        $serverurl = $this->domainname . '/webservice/rest/server.php'
        . '?wstoken=' . $this->token 
        . '&wsfunction='.$functionname
        .'&moodlewsrestformat=json&categories[0][id]='.$id
        .'&categories[0][newparent]='.$newparent
        .'&categories[0][recursive]='.$recursive;
        Http::get($serverurl);
        return redirect()->route('admin.categorias.index')->with('info', 'Se elimino la categoría');
    }
}
