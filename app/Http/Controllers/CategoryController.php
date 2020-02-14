<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Movie;
use Notify;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //funcio amb la qual enseñarem totes les categories de la BD en la view categories.index
    public function index()
    {
        $category = Category::all();

        return view('categories.index',array('arrayCategories'=>$category));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //funcio la qual retornarà la view categories.create a on es troba el formulari per crear una nova categoria
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //funcio la qual guardarà les dades del formulari de categories.create per crear una nova categoria a la base de dades
    public function store(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $adult = $request->input('adult');
        if($adult==1)$adult=true;
        else $adult=false;

        $c = new Category;
        $c->title = $title;
        $c->description = $description;
        $c->adult = $adult;
        $c->save();

        Notify::success('Se ha creado una categoria'); 
        //Notificació

        $category = Category::all();

        return view('categories.index',array('arrayCategories'=>$category));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*funcio la qual es redirecciona a categories.show i allà ens mostrarà una taula 
      de pelicules que son la mateixa categoria de la que tenim el id*/
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $movie = Movie::where('category_id',$id)->get();
        return view('categories.show', array('category'=>$category,'arrayPeliculas'=>$movie));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //funcio que farà un get en la view categories.edit i allà ens mostrarà un formulari per editar una categoria
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', array('category'=>$category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*funcio que desarà les dades que hem introduit o canviat en el formulari de categories.edit
      i ens editarà la categoria que tenim a la BD */
    public function update(Request $request, $id)
    {
        $adult = $request->input('adult');
        if($adult==1)$adult=true;
        else $adult=false;

        $c = new Category;
        $o = $c -> findOrFail($id);
        $o->title = $request->input('title');
        $o->description = $request->input('description');
        $o->adult = $adult;
        $o->save();

        Notify::success('Se ha editado la categoria ...'); 
        //Notificació

        return redirect('/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* funcio per eliminar una categoria de la BD */
    public function destroy($id)
    {
        $c = new Category;
        $o = $c -> findOrFail($id);
        $o->delete();

        Notify::success('La categoria se ha eliminado...'); 
        //Notificació
        
        $category = Category::all();

        return view('categories.index',array('arrayCategories'=>$category));
    }
}
