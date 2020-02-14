@extends('layouts.master')

@section('content')

<div class="row" style="margin-top:40px">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Añadir categoria
         </div>
         <div class="card-body" style="padding:30px">

            <form action="{{ url('/category/') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
               <label for="title">Título</label>
               <input type="text" name="title" id="title" class="form-control">
            </div>

            <div class="form-group">
               <label for="description">Descripcion</label>
               <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group text-center">
                <label for="description">Categoria para adultos</label>
                <input type="checkbox" name="adult" id="adult" class="form-control" value="1">
            </div>

            <div class="form-group text-center">
               <button type="submit" class="btn btn-primary" style="padding:8px 100px;margin-top:25px;">
                   Añadir Categoria
               </button>
            </div>

            {{-- TODO: Cerrar formulario --}}
            </form>
         </div>
      </div>
   </div>
</div>

@stop