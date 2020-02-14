@extends('layouts.master')
 

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Historial de comentarios</h2>
        </div>
    </div>
</div>

<div>
    @foreach ($reviews as $review)
        <div class="row" style="margin-top:15px; width:100%;">
            <div class="col-xs-6 col-sm-4 col-md-3 text-center">
                <a href="{{ url('/catalog/show/' . $review->movie ) }}">
                    <img src="{{$review->movie->poster}}" style="height:200px"/>
                    <h4 style="min-height:45px;margin:5px 0 10px 0">
                        {{$review->movie->title}}
                    </h4>
                </a>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <h3><b>{{$review->title}}</b></h3>
                <h4>{{$review->stars}} estrelles</h4>
                <h4>{{$review->review}}</h4>
                <h4 style="color:#CDCDCD">— {{$review->created_at->format('Y-m-d')}}</h4>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-1" style="display:flex; align-items:center; margin-top:-5%; justify-content:center">
                <form action="{{action('CatalogController@deleteReview', $review->id)}}" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger">
                            Eliminar
                        </button>
                </form>
            </div>
        </div>
    @endforeach
</div>

@endsection