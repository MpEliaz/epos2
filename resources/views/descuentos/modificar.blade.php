@extends('app')

@section('content')
<div class="container">

    @if(session()->has('message'))
        <div class="alerta alert alert-success" role="alert">{{ session('message')}}</div>
    @endif
    {!! Form::model($descuento, ['route' => ['descuentos.update', $descuento->id], 'method'=>'PUT', 'class' => 'form-horizontal']) !!}
        @include('descuentos.partials.fields')
        <button type="submit" class="btn btn-default">Guardar</button>
    {!! Form::close() !!}
</div>
@endsection
