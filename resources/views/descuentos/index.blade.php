@extends('app')

@section('content')
<h2 class="text-center">Descuentos</h2><br>
<div class="container">
    <div class="row">
        <a class="btn btn-default" href="{{url('descuentos/create')}}">Nuevo</a>
        <span>Hay <strong>{{$total}}</strong> productos</span>

              {!!Form::open(['route' => 'descuentos.index', 'method'=>'GET', 'class'=>'navbar-form navbar-right', 'role'=>'search'])!!}
                <div class="form-group">
                  {!! Form::text('q', null, ['class'=> 'form-control', 'placeholder'=> 'Buscar'])!!}
                </div>
                <button type="submit" class="btn btn-default">Buscar</button>
              {!!Form::close()!!}
    </div>
	<table id="productos-tabla" class=" table table-hover">
    	<thead>
    		<tr>
    			<td>Id</td>
    			<td>Codigo descuento</td>
                <td>Titulo</td>
    			<td>Descripcion</td>
    			<td>Estado</td>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($descuentos as $desc)
    		    <tr>
	                <td>{{$desc->id}}</td>
	    			<td><strong>{{$desc->codigo_descuento}}</strong></td>
	    			<td>{{$desc->titulo}}</td>
	    			<td>{{$desc->descripcion}}</td>
	    			<td> @if($desc->estado === 1)<button onclick="desactivar_descuento({{$desc->id}})" class="btn btn-danger">Desactivar</button>
                        @elseif ($desc->estado === 0)
                            <button onclick="activar_descuento({{$desc->id}})" class="btn btn-success">Activar</button>
                        @endif</td>
                    <td><a href="{{route('descuentos.edit', $desc->id)}}" class="btn btn-primary">Modificar</a></td>
                </tr>
            @endforeach
    	</tbody>
    </table>
    {{--{!! $desc->render() !!}--}}
</div>
@endsection