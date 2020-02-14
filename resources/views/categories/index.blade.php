@extends('layouts.master')
 

@section('content')


    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista de Categorias</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('category.create') }}"> Crear una nueva categoria</a>
            </div>
        </div>
    </div>

    <table class="table" style="text-align:center">
        <tr>
            <th style="text-align:center">ID</th>
            <th style="text-align:center">Titulo</th>
            <th style="text-align:center">Descripcion</th>
            <th style="text-align:center">Solo para adultos</th>
            <th style="padding-left:110px; width:280px;">Acciones</th>
        </tr>
    @foreach($arrayCategories as $category)
    <tr>
        <td>{{ $category->id }}</td>
        <td>{{ $category->title }}</td>
        <td>{{ $category->description }}</td>
        @if ($category['adult']==true)
        <td>Si</td>
        @else
        <td>No</td>
        @endif
        <td>
            <a class="btn btn-info" href="{{ route('category.show', $category->id) }}">Mostrar</a>
            <a class="btn btn-primary" href="{{ route('category.edit', $category->id) }}">Editar</a>
            <form action="{{action('CategoryController@destroy', $category->id)}}" method="POST" style="display:inline; float:right; margin-right:5px;">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger" style="display:inline">
                        Eliminar
                    </button>
            </form>
        </td>
    </tr>
    @endforeach
    </table>


@endsection