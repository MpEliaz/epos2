angular.module("ventasApp", ['ui.bootstrap', 'LocalStorageModule'])
    .service('manejadorVenta', function (localStorageService) {

        this.key = 'venta';
        this.ventakey ='total';
        this.desckey ='desc_';

        if(localStorageService.get(this.key)) {
            this.productos = localStorageService.get(this.key);
        }
        else{
            this.productos = [];
        }
        if(localStorageService.get(this.ventakey)) {
            this.valorTotal = localStorageService.get(this.ventakey);
        }
        else{
            this.valorTotal = 0;
        }
        if(localStorageService.get(this.desckey)) {
            this.descuentos = localStorageService.get(this.desckey);
        }
        else{
            this.descuentos="";
        }
        this.add = function (prod) {
            console.log(prod);
            angular.forEach(this.productos, function (item) {
                if(prod.id == item.id){
                    if(item.cant_venta < item.stock)
                    {
                        item.cant_venta = item.cant_venta+1;
                    }
                    prod = null;
                }
            });

            if(prod!= null){this.productos.push(prod);}
            this.updateLocalStorage();
            this.updateTotal();
        };
        this.updateLocalStorage = function () {

            localStorageService.set(this.key, this.productos);
            console.log("productos actualizados");
        };
        this.updateDescuento = function () {

            localStorageService.set(this.desckey, this.descuentos);
            console.log("descuentos actualizados");
        };
        this.updateTotal = function () {
            var subtotal = 0;
            angular.forEach(this.productos, function (item) {

                for(i=0; i<item.cant_venta; i++)
                {
                    subtotal += parseInt(item.precio_venta);
                }
            });
            if(this.descuentos.length > 0){
                subtotal = this.AplicarDescuento(subtotal);
            }
            console.log("subtotal: "+subtotal);
            localStorageService.set(this.ventakey, subtotal);
            return this.valorTotal = subtotal;


        };
        this.clean = function () {
            this.productos = [];
            this.updateLocalStorage();
            this.updateTotal();
            return this.getAll();
        };
        this.cleanDesc = function () {
            this.descuentos = [];
            this.updateDescuento();
            this.updateTotal();
            return this.descuentos;
        };
        this.getAll = function () {
            return this.productos;
        };
        this.getAlldesc = function () {
            return this.descuentos;
        };
        this.removeItem = function (item) {
            this.productos = this.productos.filter(function(prod) {
                return prod !== item;
            });
            this.updateLocalStorage();
            this.updateTotal();
            return this.getAll();
        };
        this.getValorTotal = function () {
            return this.valorTotal;
        };
        this.cerrarVenta = function () {
            productos = this.getAll();
            productos_data=[];
            angular.forEach(productos, function (prod) {
                productos_data.push({'id': prod.id, 'cantidad': prod.cant_venta});
            });
            return productos_data;
        };
        this.agregarDescuento = function (desc) {
            this.descuentos=null;
            this.descuentos = desc;
            this.updateDescuento();
            return this.descuentos;
        };
        this.AplicarDescuento = function (subtotal) {
            console.log("DESCUENTO: "+this.descuentos[0].descuento);
            subtotal = subtotal *(1-(this.descuentos[0].descuento /100));
            console.log(subtotal);
            return subtotal;

        };

    })
    .controller("VentasController", function($scope, $http, $location, manejadorVenta){

        $scope.getLocation = function(val) {
            return $http.get('/hola/', {
                params: {
                    nombre: val
                }
            }).then(function(response){
                console.log(response);
                return response.data.map(function(item){
                    return item;
                });
            });
        };
        $scope.tipo_pago = "contado";
        $scope._valorTotal = 0;
        $scope._vuelto = 0;
        $scope._paga_con = 0;
        $scope.valorTotal = manejadorVenta.getValorTotal();
        $scope.productos = manejadorVenta.getAll();
        $scope.descuentos = manejadorVenta.getAlldesc();

        $scope.addProducto = function(prod) {
            $scope.newProd=prod;
            $scope.newProd['cant_venta']=1;
            manejadorVenta.add($scope.newProd);
            $scope.newProd ={};
            $scope.valorTotal = manejadorVenta.getValorTotal();
            $scope.searchText = "";


        };
        $scope.clearAll = function () {
            $scope.productos = manejadorVenta.clean();
            $scope.valorTotal = manejadorVenta.getValorTotal();
        };
        $scope.removeProd = function (item) {
            console.log(item);
            $scope.productos = manejadorVenta.removeItem(item);
            $scope.valorTotal = manejadorVenta.getValorTotal();
        };
        $scope.updateCantProd = function (prod) {

            if(prod.cant_venta <= prod.stock)
            {
                manejadorVenta.updateLocalStorage();
                manejadorVenta.updateTotal();
                $scope.valorTotal = manejadorVenta.getValorTotal();
            }
            else
            {
                prod.cant_venta = prod.stock;
                manejadorVenta.updateLocalStorage();
                manejadorVenta.updateTotal();
                $scope.valorTotal = manejadorVenta.getValorTotal();
            }
        };
        /*        $scope.cerrarVenta = function () {
         productos = manejadorVenta.cerrarVenta();
         $http.post('http://localhost:8000/send/', {
         params: productos
         }).success(function(response){
         console.log(response);
         });
         };*/
        $scope.buscarDescuento = function () {
            val = $scope.desc_seach;
            return $http.post('/desc_/', {
                cod_desc : val
            }).success(function(response){
                console.log(response);
                $scope.descuentos = manejadorVenta.agregarDescuento(response);
                $scope.valorTotal = manejadorVenta.updateTotal();
            });
        };
        $scope.clearDesc = function () {
            $scope.descuentos = manejadorVenta.cleanDesc();
            $scope.valorTotal = manejadorVenta.updateTotal();
        };
        $scope.cerrarVenta = function () {
            if($scope.paga_con >= manejadorVenta.getValorTotal()){
                $http.post('/ventas',{
                    detalle_venta : $scope.productos,
                    total : manejadorVenta.getValorTotal(),
                    paga_con : $scope.paga_con,
                    descuento: manejadorVenta.getAlldesc(),
                    tipo_pago : $scope.tipo_pago
                }).success(function (response) {
                    if(response.estado == "OK")
                    {
                        $('#paymodal').modal('hide');
                        $('#endmodal').modal('show');
                        $scope._vuelto = response.vuelto;
                        $scope._valorTotal = manejadorVenta.getValorTotal();
                        $scope._paga_con = $scope.paga_con;
                        $scope.paga_con = 0;
                        $scope.clearAll();

                    }
                });
            }
            else
            {
                $("#in").addClass("input_warning");
                $("#msj_monto").show();
                $('#in').focus();
                $('#in').val("");
            }
        };
        $scope.codesearch = function () {
            $code = $scope.searchcode;
            return $http.get('/search_code/', {
                params: {
                    codigo: $code
                }
            }).then(function(response){
                console.log(response.data);
                $scope.addProducto(response.data[0]);
                $scope.searchcode ="";
            });
        };
    });