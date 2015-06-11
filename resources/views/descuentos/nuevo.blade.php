@extends('app')

@section('content')
<div class="container">
        {!! Form::open(['route' => 'descuentos.store', 'method'=>'POST', 'class' => 'form-horizontal']) !!}
            @include('descuentos.partials.fields')
             <button type="submit" class="btn btn-default">Guardar</button>
        {!! Form::close() !!}
</div>
@endsection