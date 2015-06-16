@extends('app')

@section('content')
<h2 class="text-center">Marcas</h2><br>
<div class="container">
    <div class="col-md-6">
        <div class="row">
            <a class="btn btn-default" href="{{url('marcas/create')}}">Nuevo</a>
            <span>Hay <strong>{{$marcas->total()}}</strong> productos</span>

            {!!Form::open(['route' => 'marcas.index', 'method'=>'GET', 'class'=>'navbar-form navbar-right', 'role'=>'search'])!!}
            <div class="form-group">
                {!! Form::text('q', null, ['class'=> 'form-control', 'placeholder'=> 'Buscar'])!!}
            </div>
            <button type="submit" class="btn btn-default">Buscar</button>
            {!!Form::close()!!}
        </div>
        <table id="marcas-tabla" class=" table table-hover">
            <thead>
            <tr>
                <td>Id</td>
                <td>Nombre</td>
                <td>Eliminar</td>
            </tr>
            </thead>
            <tbody>
            @foreach($marcas as $marca)
                <tr>
                    <td>{{$marca->id}}</td>
                    <td><strong>{{$marca->nombre}}</strong></td>
                    <td><a href="{{route('marcas.destroy', $marca->id)}}" class="btn btn-danger">Eliminar</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $marcas->render() !!}
    </div>
</div>
@endsection