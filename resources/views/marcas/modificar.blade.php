@extends('app')

@section('content')
<div class="container">
    @include('productos.partials.mensajes')
    @if(session()->has('message'))
        <div class="alerta alert alert-success" role="alert">{{ session('message')}}</div>
    @endif
    {!! Form::model($marca, ['route' => ['marcas.update', $marca->id], 'method'=>'PUT', 'class' => 'form-horizontal']) !!}
        @include('marcas.partials.fields')
        <button type="submit" class="btn btn-default">Guardar</button>
    {!! Form::close() !!}
</div>
@endsection
