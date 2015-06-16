@extends('app')

@section('content')
<div class="container">
        @include('marcas.partials.mensajes')
        {!! Form::open(['route' => 'marcas.store', 'method'=>'POST', 'class' => 'form-horizontal']) !!}
            @include('marcas.partials.fields')
             <button type="submit" class="btn btn-default">Guardar</button>
        {!! Form::close() !!}
</div>
@endsection