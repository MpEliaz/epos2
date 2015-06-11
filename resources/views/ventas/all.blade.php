@extends('app')
@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Detalle productos</strong></div>
        <div class="panel-body">
            <table class="table table-condensed tabla_ventas" style="border-collapse:collapse;">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Vendedor</th>
                    <th>Fecha venta</th>
                    <th>Tipo pago</th>
                    <th>Estado venta</th>
                    <th>Pago con</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ventas as $v)
                    <tr data-toggle="collapse" data-target="#row{{$v->id}}" class="accordion-toggle">
                        <td>{{$v->id}}</td>
                        <td>{{$v->nombre_vendedor()}}</td>
                        <td>{{$v->fecha_para_humanos()}}</td>
                        <td>{{$v->tipo_pago}}</td>
                        <td>{{$v->estado_venta}}</td>
                        <td>1000</td>
                        <td>{{$v->total_venta}}</td>
                    <tr >
                        <td colspan="7" class="hiddenRow">
                            <div class="accordian-body collapse" id="row{{$v->id}}">
                                <table class="table venta_detalle_table">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Modelo</th>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Precio unitario</th>
                                    </tr>
                                    </thead>
                                    @foreach($v->productos as $p)
                                        <tr>
                                            <td width="25%">{{$p->nombre}}</td>
                                            <td width="20%">{{$p->modelo}}</td>
                                            <td width="40%">{{$p->descripcion_corta}}</td>
                                            <td width="5%">{{$p->pivot->cantidad}}</td>
                                            <td width="15%">{{$p->precio_venta}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
