@extends('app')

@section('content')
    <div class="container" ng-app="ventasApp" ng-controller="VentasController">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Detalle productos</strong></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="navbar-form navbar-left" role="search">
                                <form ng-submit="codesearch()">
                                    <div class="form-group">
                                        <label for="">Busqueda por codigo:</label>
                                        <input type="text" ng-model="searchcode" placeholder="codigo de producto" class="form-control" autofocus tabindex="1">
                                    </div>
                                </form>
                            </div>
                            <div class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                    <label for="">Busqueda por nombre:</label>
                                    <input type="text" ng-model="searchText" placeholder="nombre de producto" typeahead="item.nombre for item in getLocation($viewValue)" typeahead-on-select="addProducto($item)" typeahead-loading="loadingLocations" class="form-control">
                                    <i ng-show="loadingLocations" class="glyphicon glyphicon-refresh"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row detalle-venta">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Descripcion</th>
                                    <th>Cantidad</th>
                                    <th>Valor Uni</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="prod in productos">
                                    <td>@{{ prod.nombre }}</td>
                                    <td>@{{ prod.descripcion_corta }}</td>
                                    <td><input class="cant_prod form-control" type="number" min="1" ng-model="prod.cant_venta" ng-change="updateCantProd(prod)" value="@{{prod.cant_venta}}"/></td>
                                    <td>@{{ prod.precio_venta | currency:undefined:0 }}</td>
                                    <td><i ng-click="removeProd(prod)" class="fa fa-trash-o"></i></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    {{--<div class="panel-heading"><strong>Total</strong></div>--}}
                    <div class="panel-body">
                        <h1 class="text-center"><strong>@{{ valorTotal | currency:undefined:0 }}</strong></h1>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Descuentos</strong></div>
                    <div class="panel-body">
                        <div class="form-inline">
                            <label for=""><strong>Agregar Codigo Descuento:</strong></label>

                            <form ng-submit="buscarDescuento()">
                                <div class="form-group">
                                    <input type="text" ng-model="desc_seach" class="form-control"/>
                                    <button class="btn btn-primary">agregar</button>
                                </div>
                            </form>
                        </div>
                        <br/>
                        <ul class="list-group" ng-repeat="desc in descuentos">
                            <li class="list-group-item">@{{ desc.titulo }}<span class="badge"><i ng-click="clearDesc()" class="glyphicon glyphicon-remove"></i></span></li>

                        </ul>
                    </div>
                </div>
                <button id="prepay" class="btn btn-success btn-lg btn-block" ng-disabled="productos.length == 0" data-toggle="modal" data-target="#paymodal" tabindex="2">PAGAR</button>
                <button class="btn btn-danger btn-lg btn-block" ng-click="clearAll()">LIMPIAR</button>
            </div>
        </div>
        <!-- start pay modal -->
        <div class="modal fade" id="paymodal" tabindex="-10" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-shopping-cart"></i> Total de la venta: @{{ valorTotal | currency:undefined:0 }}</h4>
                    </div>
                    <div class="modal-body">
                        <form ng-submit="cerrarVenta()" class="form-horizontal">
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label"><strong>Cancela con:</strong></label>
                                <div class="col-sm-9">
                                    <input id="in" type="number" ng-model="paga_con" class="form-control" autofocus/>
                                    <p id="msj_monto" style="display: none"><strong>Monto Insuficiente</strong></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label"><strong>Tipo pago:</strong></label>
                                <div class="col-sm-9">
                                    <label class="tipo_pago"><input ng-model="tipo_pago" name="tipo_pago" value="contado" type="radio">Contado <br/><i class="fa fa-money"></i></label>
                                    <label class="tipo_pago"><input ng-model="tipo_pago" name="tipo_pago" value="debito" type="radio">Debito <br/><i class="fa fa-credit-card"></i></label>
                                    <label class="tipo_pago"><input ng-model="tipo_pago" name="tipo_pago" value="credito" type="radio">Credito <br/><i class="fa fa-cc-visa"></i></label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Volver</button>
                        <button type="button" class="btn btn-success" ng-click="cerrarVenta()">Terminar venta</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end pay modal -->
        <!-- start final pay modal -->
        <div class="modal fade" id="endmodal" tabindex="-10" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-check"></i> Paso Final</h4>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-center">Venta terminada con éxito.</h3><br/>
                        <table style="width: 100%;">
                            <tr>
                                <td><h4>Cliente pago con:</h4></td>
                                <td><h4>@{{ _paga_con | currency:undefined:0}}</h4></td>
                            </tr>
                            <tr>
                                <td><h4>Total venta:</h4></td>
                                <td><h4>@{{ _valorTotal | currency:undefined:0}}</h4></td>
                            </tr>
                            <tr>
                                <td><h4><strong>Vuelto:</strong></h4></td>
                                <td><h4><strong>@{{ _vuelto | currency:undefined:0}}</strong></h4></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" data-dismiss="modal">Finalizar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end final pay modal -->
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        //$('#endmodal').modal('show');
        $('#in').keypress(function(){
            $("#in").removeClass("input_warning");
            $("#msj_monto").hide();
        });

        $('#paymodal').on('shown.bs.modal', function () {
            $('#in').focus();
        });
    </script>
@endsection
