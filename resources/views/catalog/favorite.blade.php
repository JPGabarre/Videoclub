@extends('layouts.master')

@section('content')

    <div class="row" style="margin-top:15px">
        @foreach( $peliculasFav as $peliculaFav )
            <div class="col-xs-6 col-sm-4 col-md-3 text-center">

                <a href="{{ url('/catalog/show/' . $peliculaFav->movie_id ) }}">
                    <img src="{{$peliculaFav->movie->poster}}" style="height:200px"/>
                    <h4 style="min-height:45px;margin:5px 0 10px 0">
                        {{$peliculaFav->movie->title}}
                    </h4>
                </a>

            </div>
        @endforeach
    </div>

@stop