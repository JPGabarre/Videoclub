@extends('layouts.master')

@section('content')

    <div class="row" style="margin-top:15px">

    <div class="col-md-3">

        <img src="{{$pelicula->poster}}" style=" width:100%;"/>

    </div>

    <div class="col-md-8">

        <h2>{{$pelicula->title}}</h2>
        <h5>Año: {{$pelicula->year}}</h5>
        <h5>Director: {{$pelicula->director}}</h5>
        <h5>Categoria: {{$pelicula->category->title}}</h5>
        <br>
        <p><b>Resumen: </b>{{$pelicula->synopsis}}</p>
        <br>
        @if ($pelicula['rented']==true)
            <p><b>Estado: </b>Película actualmente alquilada</p>
            <div class="col-md-14">
                @if (sizeOf($favoriteMovie)!=0)
                    <form action="{{action('CatalogController@deleteFav', $pelicula->id)}}" method="POST" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger" style="display:inline">
                            <span class="glyphicon glyphicon-remove"></span> Quitar de favoritos
                        </button>
                     </form>
                @else
                    <form action="{{action('CatalogController@addFav', $pelicula->id)}}" method="POST" style="display:inline">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success" style="display:inline">
                            <span class="glyphicon glyphicon-heart"></span> Añadir a favoritos
                        </button>
                    </form>
                @endif
                <form action="{{action('CatalogController@putReturn', $pelicula->id)}}" method="POST" style="display:inline">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger" style="display:inline">
                        <span class="glyphicon glyphicon-circle-arrow-down"></span> Devolver película
                    </button>
                </form>
                <a href="{{ url('/catalog/edit/'. $pelicula->id ) }}" class="btn btn-warning" role="button"><span class="glyphicon glyphicon-pencil"></span> Editar película</a>
                <form action="{{action('CatalogController@deleteMovie', $pelicula->id)}}" method="POST" style="display:inline">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger" style="display:inline">
                        <span class="glyphicon glyphicon-remove"></span> Eliminar película
                    </button>
                </form>
                <a href="{{ url('/catalog/') }}" class="btn btn-dark" role="button"><span class="glyphicon glyphicon-chevron-left"></span> Volver al listado</a>
                
            </div>
        @else
            <p><b>Estado: </b>Película disponible</p> 
            <div class="col-md-14">
                @if (sizeOf($favoriteMovie)!=0)
                    <form action="{{action('CatalogController@deleteFav', $pelicula->id)}}" method="POST" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger" style="display:inline">
                            <span class="glyphicon glyphicon-remove"></span> Quitar de favoritos
                        </button>
                     </form>
                @else
                    <form action="{{action('CatalogController@addFav', $pelicula->id)}}" method="POST" style="display:inline">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success" style="display:inline">
                            <span class="glyphicon glyphicon-heart"></span> Añadir a favoritos
                        </button>
                    </form>
                @endif
                <form action="{{action('CatalogController@putRent', $pelicula->id)}}" method="POST" style="display:inline">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary" style="display:inline">
                        <span class="glyphicon glyphicon-circle-arrow-down"></span> Alquilar película
                    </button>
                </form>
                <a href="{{ url('/catalog/edit/'. $pelicula->id ) }}" class="btn btn-warning" role="button"><span class="glyphicon glyphicon-pencil"></span> Editar película</a>
                <form action="{{action('CatalogController@deleteMovie', $pelicula->id)}}" method="POST" style="display:inline">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger" style="display:inline">
                        <span class="glyphicon glyphicon-remove"></span> Eliminar película
                    </button>
                </form>
                <a href="{{ url('/catalog/') }}" class="btn btn-dark" role="button"><span class="glyphicon glyphicon-chevron-left"></span> Volver al listado</a>
               
            </div>  
        @endif
    </div>

    <div class="col-sm-12" style=" margin-top:25px; width:100%">
        <iframe id="trailer" src="{{ str_replace('watch?v=', 'embed/', $pelicula->trailer) }}" type="text/html" width="100%" height="395" frameborder="0" allowfullscreen></iframe>
    </div>

    <div class="col-sm-12">
        <h2>Comentarios</h2>
        <div>
            @foreach ($reviews as $review)
                <div style="border-left:7px solid #DEDEDE; padding:1px; padding-left:15px; margin:5px; margin-top:15px; margin-bottom:15px">
                    <h4><b>{{$review->title}}</b></h4>
                    <h5>{{$review->stars}} estrelles</h5>
                    <h5>{{$review->review}}</h5>
                    <p style="color:#CDCDCD">— {{$review->created_at->format('Y-m-d')}} -{{$review->user->name}}</p>
                </div>
            @endforeach
        </div>
        <div class="card-body">
            <form action="{{action('CatalogController@createReview')}}" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                <label for="title">Enviar comentario:</label>
                <input type="text" name="title" id="title" class="form-control" >
                </div>

                <div class="form-group">
                    <label for="title">Valoracion:</label>
                    <select id="stars" name="stars" class="form-control" style="height:30px">
                        <option value="1">1 estrella</option>
                        <option value="2">2 estrella</option>
                        <option value="3">3 estrella</option>
                        <option value="4">4 estrella</option>
                        <option value="5">5 estrella</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="review">Resumen</label>
                    <textarea name="review" id="review" class="form-control" rows="3" placeholder="Danos tu opinion"></textarea>
                </div>

                <div class="form-group">
                    <input type="hidden" id="pelID" name="pelID" value="{{$pelicula->id}}">

                    <button type="submit" class="btn btn-success" style="padding:8px 100px;margin-top:25px;">
                        Valorar
                    </button> 

                    <input type="reset" class="btn btn-dark" style="padding:8px 100px;margin-top:25px;" value="Cancel·lar">
                </div>
            </form>
        </div>
    </div>

    </div>

@stop