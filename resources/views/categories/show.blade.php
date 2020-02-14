@extends('layouts.master')

@section('content')

    <div class="row" style="margin-top:15px">
        <div class="col-sm-8">
            <h2>{{$category->title}}</h2>
            @if ($category['adult']==true)
                <h4>No apta para menores</h4>
            @else
                <h4><b>Calificacion: </b> Apta para todas las edades</h4>
            @endif
            <h4><b>Descripcion: </b>{{$category->description}}</h4>
            <br>
        </div>
    </div>

    <div class="row" style="margin-top:15px">
        @foreach( $arrayPeliculas as $pelicula )
            <div class="col-xs-6 col-sm-4 col-md-3 text-center">

                <a href="{{ url('/catalog/show/' . $pelicula->id ) }}">
                    <img src="{{$pelicula->poster}}" style="height:200px"/>
                    <h4 style="min-height:45px;margin:5px 0 10px 0">
                        {{$pelicula->title}}
                    </h4>
                </a>

            </div>
        @endforeach
    </div>

@stop