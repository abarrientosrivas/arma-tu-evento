'use strict';

angular.module('Client')

	.controller('ListPagoCtrl', function($scope, PagoResource, $state){
		$scope.pagos = PagoResource.query();

		$scope.verPago = function(pagoId) {
			$state.go('verPago', {id: pagoId});
		};
	})

	.controller('AdminVerPagoCtrl', function($scope, $state, $filter, PagoResource, ProveedorResource, $stateParams){
		$scope.action = 'view';
		$scope.pago = PagoResource.get({id: $stateParams.id});
		$scope.pago.$promise.then(function(data){
			$scope.proveedor = ProveedorResource.get({id: $scope.pago.proveedor_id});
			$scope.proveedor.$promise.then(function(data){
				// console.log($scope.proveedor.nombre);
				$scope.pago.nombre = $scope.proveedor.nombre;
				$scope.pago.cuit = $scope.proveedor.cuit;
				$scope.pago.mail = $scope.proveedor.email;
				// var fecha = $filter('date')($scope.pago.fecha_pago,"yyyy-MM-dd");
				$scope.pago.fecha_pago = new Date($filter('date')($scope.pago.fecha_pago,"yyyy-MM-dd"));
			});
			
		});
		$scope.facturado = function(pagoId){
			$scope.pago = PagoResource.get({id: pagoId});
			$scope.pago.$promise.then(function(data){
				$scope.pago.facturado = true;
				PagoResource.update($scope.pago);
				$state.reload();
			})
			
		}
	})

	.controller('PagoRubroCtrl', function($scope, $rootScope, TipoPagoResource, ProveedorResource, $http, $window, $stateParams){
		$scope.mensaje = "Pagar rubro destacado";
		$scope.proveedor = ProveedorResource.get({id: $rootScope.currentUser.id});
		$scope.tipo = TipoPagoResource.get({id: 2}); // traer pago rubro
		$scope.tipo.$promise.then(function(data){
			$scope.monto = $scope.tipo.precio;
		});
		angular.extend($scope, {
            pagar: function() {
                $http({
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    url: 'todopago',
                    method: "POST",
					data: {
						productName: "pagar rubro",
						monto: $scope.monto,
						mail: document.getElementById("proveedor_mail").value,
						nombre: document.getElementById("proveedor_nombre").value,
						apellido: document.getElementById("proveedor_apellido").value
					}
                }).then(function(response){
					console.log(response.headers('Location'));
					if(response.headers('Location') != null){
						$window.location.assign(response.headers('Location'));
					}                    
                });
            }
        });
	})

	.controller('PagoPostCtrl', function($scope, $rootScope, TipoPagoResource, ProveedorResource, $http, $window, $stateParams){
		$scope.mensaje = "Pagar publicación destacada";
		$scope.proveedor = ProveedorResource.get({id: $rootScope.currentUser.id});
		$scope.tipo = TipoPagoResource.get({id: 1}); // traer pago post
		$scope.tipo.$promise.then(function(data){
			$scope.monto = $scope.tipo.precio;
		});
		angular.extend($scope, {
            pagar: function() {
                $http({
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    url: 'todopago',
                    method: "POST",
					data: {
						postId: parseInt($stateParams.postId),
						productName: "pagar post",
						monto: $scope.monto,
						mail: document.getElementById("proveedor_mail").value,
						nombre: document.getElementById("proveedor_nombre").value,
						apellido: document.getElementById("proveedor_apellido").value
					}
                }).then(function(response){
					console.log(response.headers('Location'));
					if(response.headers('Location') != null){
						$window.location.assign(response.headers('Location'));
					}                    
                });
            }
        });
	})

	.controller('PagoCtrl', function($scope, TipoPagoResource, ProveedorResource, $http, $window, $stateParams) {
		$scope.proveedor = ProveedorResource.get({id: $stateParams.id});
		$scope.tipo = {};
		// var tipo;
		// var amount = 80;
		$scope.proveedor.$promise.then(function(data){
			$scope.tipo = TipoPagoResource.get({id: $scope.proveedor.tipo_susc_id});
			$scope.tipo.$promise.then(function(data){
				$scope.monto = $scope.tipo.precio;
			});
			// $scope.proveedor.tipo_susc = data.tipo_susc;
			// tipo = $scope.proveedor.tipo_susc;

			// if (tipo == "Anual"){
			// 	$scope.monto = amount * 12;
			// }
			// if (tipo == "Trimestral"){
			// 	$scope.monto = amount * 3;
			// }
			// if (tipo == "Mensual"){
			// 	$scope.monto = amount;
			// }
		})
		angular.extend($scope, {
            pagar: function() {
                $http({
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    url: 'todopago',
                    method: "POST",
					data: {
						monto: $scope.monto,
						mail: document.getElementById("proveedor_mail").value,
						nombre: document.getElementById("proveedor_nombre").value,
						apellido: document.getElementById("proveedor_apellido").value
					}
                }).then(function(response){
					console.log(response.headers('Location'));
					if(response.headers('Location') != null){
						$window.location.assign(response.headers('Location'));
					}                    
                });
            }
        });

	});
