<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Review;
use App\Category;
use App\Favorite;
use Illuminate\Support\Facades\Auth;
use Notify;

class CatalogController extends Controller
{
    /* Funcio amb la qual llistarem totes les movies de la BD en la view catalog.index */
    public function getIndex()
    {
		$movies = Movie::all();

        return view('catalog.index',array('arrayPeliculas'=>$movies));
    }


    /* Funcio amb la qual podrem veure la informació de una pelicula i comentaris d'aquesta, tot en la view catalog.show */
    public function getShow($id)
    {
		$movie = Movie::findOrFail($id);
        $reviews = Review::where('movie_id',$id)->get();

        //metode per comprobar si la pelicula esta en las llista de preferits del usuari
        $user = Auth::user()->id;
        $favoriteMovie = Favorite::where('user_id',$user)->where('movie_id',$id)->get();

        return view('catalog.show',array('pelicula'=>$movie,'reviews'=>$reviews,'favoriteMovie'=>$favoriteMovie));
    }

    /* Funcio la qual ens redirreccionarà a la view catalog.create
       (l'array de categories que li paso es per llistar-la en el formulari de la view)*/
    public function getCreate()
    {
        $category = Category::all();
        return view('catalog.create',array('arrayCategories'=>$category));
    }

    /* Funcio la qual ens redirreccionarà a la view catalog.edit per editar una movie de la BD
       (l'array de categories i la de movies que li paso es per llistar tota l'informacio en el formulari de la view)*/
    public function getEdit($id)
    {
        $movie = Movie::findOrFail($id);
        $category = Category::all();
        return view('catalog.edit', array('pelicula'=>$movie,'arrayCategories'=>$category));
    }

    /* Funcio la qual agafarà les dades del formulari de la view catalog.create per crear una nova movie a la BD */
    public function postCreate(Request $request)
    {
        $title = $request->input('title');
        $year = $request->input('year');
        $director = $request->input('director');
        $category_id = $request->input('category_id');
        $poster = $request->input('poster');
        $trailer = $request->input('trailer');
        $synopsis = $request->input('synopsis');

        $p = new Movie;
        $p->title = $title;
        $p->year = $year;
        $p->director = $director;
        $p->category_id = $category_id;
        $p->poster = $poster;
        $p->trailer = $trailer;
        $p->rented = false;
        $p->synopsis = $synopsis;
        $p->save();

        Notify::success('La pelicula ha estat creada...'); 
        //Notificació

        return redirect('/catalog');
    }

    /* Funcio que creara una nova review i la mostrarà en el catalog.show de la movie a la que se li fa la review */
    public function createReview(Request $request)
    {
        $title = $request->input('title');
        $stars = $request->input('stars');
        $review = $request->input('review');
        $movie_id = $request->input('pelID');
        $user_id = Auth::id();

        $r = new Review;
        $r->title = $title;
        $r->review = $review;
        $r->stars = $stars;
        $r->user_id = $user_id;
        $r->movie_id = $movie_id;
        $r->save();

        $movie = Movie::findOrFail($movie_id);
        
        Notify::success('Se ha enviado su opinion...'); 
        //Notificació

        return redirect('/catalog/show/'.$movie_id); 
    }


    /* Funcio la qual agafarà les dades del formulari de la view catalog.edit per editar una movie de la BD */
    public function putEdit(Request $request, $id)
    {
        $p = new Movie;
        $o = $p -> findOrFail($id);
        $o->title = $request->input('title');
        $o->year = $request->input('year');
        $o->director = $request->input('director');
        $o->category_id = $request->input('category_id');
        $o->poster = $request->input('poster');
        $o->trailer = $request->input('trailer');
        $o->synopsis = $request->input('synopsis');
        $o->save();

        $movie = Movie::findOrFail($id);
        $reviews = Review::where('movie_id',$id)->get();

        Notify::success('La pelicula ha estat editada amb exit...'); 
        //Notificació
        
        return redirect('/catalog/show/'.$id);
    }
 
    /* Funcio amb la qual editem el camp rented de una movie a true*/
    public function putRent($id){

        $p = new Movie;
        $o = $p -> findOrFail($id);
        $o->rented = 1;
        $o->save();

        $movie = Movie::findOrFail($id);

        Notify::success('La pelicula ha estat llogada...'); 
        //Notificació
        return redirect('/catalog/show/'.$id);
    }

    /* Funcio amb la qual editem el camp rented de una movie a false*/
    public function putReturn($id){

        $p = new Movie;
        $o = $p -> findOrFail($id);
        $o->rented = 0;
        $o->save();

        $movie = Movie::findOrFail($id);

        Notify::success('Has retornat la pelicula... '); 
        //Notificació
        return redirect('/catalog/show/'.$id);
    }

    /* Funcio amb la qual eliminem una movie de la BD */
    public function deleteMovie($id){

        $p = new Movie;
        $o = $p -> findOrFail($id);
        $o->delete();

        Notify::success('La pelicula ha quedat eliminada...'); 
        //Notificació
        return redirect('/catalog');
    }
    
    /* Funcio la qual se li aplicarà al buscador del menu per buscar pelicules */
    public function search(Request $request)
    {
        $q = $request->input('q');

        $arrayPeliculas = Movie::where('title', 'LIKE', '%' . $q . '%')->get();

        return view('catalog.index', compact('arrayPeliculas'));
    }

    /* Funcio amb la qual mostrarem les pelicules preferidas del mateix usuari en la view catalog.favorite*/
    public function showFav()
    {
        $user = Auth::user()->id;

        $favMovies = Favorite::where('user_id',$user)->get();
        
        return view('catalog.favorite',array('peliculasFav'=>$favMovies));   
    }

    /* Funcio amb la qual afegirem en la BD una pelicula preferida del usuari */
    public function addFav($id)
    {
        $user = Auth::id();
        $movie = Movie::findOrFail($id);

        $f = new Favorite;
        $f->user_id = $user;
        $f->movie_id = $id;
        $f->save();

        Notify::success('Se ha añadido la pelicula a favoritos'); 
        //Notificació
        return redirect('/catalog/show/'.$id);
    }

    /* Funcio amb la qual eliminarem de la BD la pelicula preferida del usuari */
    public function deleteFav($id)
    {
        $user = Auth::id();
        $movie = Movie::findOrFail($id);
       
        $f = new Favorite;
        $o = $f -> where('user_id',$user)->where('movie_id',$id)->firstOrFail();
        $o->delete();

        Notify::success('La pelicula ya no esta en favoritos...'); 
        //Notificació
        return redirect('/catalog/show/'.$id);
    }

    /* Funcio la qual mostrarà en la view catalog.review tots els comentaris que ha fet el usuari sobre totes les pelicules */
    public function showUserReviews(){
        $user = Auth::id();

        $reviews = Review::where('user_id',$user)->get();

        return view('catalog.review',array('reviews'=>$reviews));
    }

    /* Funcio la qual elimina un comentari que ha fet el usuari */
    public function deleteReview($id){
        $r = new Review;
        $o = $r -> findOrFail($id);
        $o->delete();

        Notify::success('El comentario ha quedado eliminado...'); 
        //Notificació
        return redirect('/review');
    }

}
