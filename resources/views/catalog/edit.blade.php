@extends('layouts.master')

@section('content')

<div class="row" style="margin-top:40px">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Modificar pelicula
         </div>
         <div class="card-body" style="padding:30px">

            <form method="POST">
            {{ csrf_field() }}
            {{method_field('PUT')}}
            

            <div class="form-group">
               <label for="title">Título</label>
               <input type="text" name="title" id="title" class="form-control" value="{{$pelicula->title}}">
            </div>

            <div class="form-group">
               {{-- TODO: Completa el input para el año --}}
               <label for="year">Año</label>
               <input type="text" name="year" id="year" class="form-control" value="{{$pelicula->year}}">
            </div>

            <div class="form-group">
               {{-- TODO: Completa el input para el director --}}
               <label for="director">Director</label>
               <input type="text" name="director" id="director" class="form-control" value="{{$pelicula->director}}">
            </div>

            <div class="form-group">
               {{-- TODO: Completa el input para la categoria --}}
               <label for="director">Categoria</label>
               <select id="category_id" name="category_id" class="form-control" style="height:30px">
                  @foreach ($arrayCategories as $category) 
                     @if ($category['id']==$pelicula['category_id'])
                        <option value="{{ $category->id }}" selected>{{ $category->title }}</option>
                     @else
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                     @endif
                  @endforeach
               </select>
            </div>

            <div class="form-group">
               {{-- TODO: Completa el input para el poster --}}
               <label for="picture">Imagen</label>
               <input type="text" name="poster" id="poster" class="form-control" value="{{$pelicula->poster}}">
            </div>

            <div class="form-group">
               {{-- TODO: Completa el input para el trailer --}}
               <label for="picture">URL del Trailer</label>
               <input type="text" name="trailer" id="trailer" class="form-control" value="{{$pelicula->trailer}}">
            </div>

            <div class="form-group">
               <label for="synopsis">Resumen</label>
               <textarea name="synopsis" id="synopsis" class="form-control" rows="3">{{$pelicula->synopsis}}</textarea>
            </div>

            <div class="form-group text-center">
               <button type="submit" class="btn btn-primary" style="padding:8px 100px;margin-top:25px;">
                    Modificar pelicula
               </button>
            </div>

            {{-- TODO: Cerrar formulario --}}

            </form>
            
         </div>
      </div>
   </div>
</div>

@stop