<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;

class APICatalogController extends Controller
{
    public function index() {
        return response()->json( Movie::all() );
    }

    public function show($id){
        return response()->json( Movie::findOrFail($id) );
    }

    public function postCreate(Request $request) 
    {
        Movie::create([
            'title' => $request['title'],
            'year' => $request['year'],
            'director' => $request['director'],
            'poster' => $request['poster'],
            'synopsis' => $request['synopsis']
        ]);
        return response()->json( ['error' => false,
                              'msg' => 'La película s\'ha crerat correctament' ] );
    }

    public function update(Request $request, $id){
        $m = Movie::findOrFail( $id );
        if ($request->has('title')){
            $m->title = $request->input('title');
        }
        if ($request->has('year')){
            $m->year = $request->input('year');
        }
        if ($request->has('director')){
            $m->director = $request->input('director');
        }
        if ($request->has('poster')){
            $m->poster = $request->input('poster');
        }
        if ($request->has('synopsis')){
            $m->synopsis = $request->input('synopsis');
        }
        $m->save();
        return response()->json( ['error' => false,
                              'msg' => 'La película ha estat editada' ] );
    }

    public function destroy($id){
        $m = Movie::findOrFail( $id );
        $m->delete();
        return response()->json( ['error' => false,
                              'msg' => 'La película ha estat eliminada' ] );
    }

    public function putRent($id) {
        $m = Movie::findOrFail( $id );
        $m->rented = true;
        $m->save();
        return response()->json( ['error' => false,
                              'msg' => 'La película se ha marcado como alquilada' ] );
    }

    public function putReturn($id) {
        $m = Movie::findOrFail( $id );
        $m->rented = false;
        $m->save();
        return response()->json( ['error' => false,
                              'msg' => 'La película se ha devuelto' ] );
    }

}
