'use strict';

angular.module('Client')
    .controller('ListTipoPagoCtrl', function($scope, TipoPagoResource, $state, $stateParams, $window){
        $scope.title="Administrar precios de la plataforma";
        $scope.tipos = TipoPagoResource.query();
        // $scope.tipo = TipoPagoResource.get({id: precioId});

        $scope.editarPrecio = function(precioId){
            $window.location.href = '/#!/tipopago/edit/' + precioId;
        };
    })
    .controller('EditTipoPagoCtrl', function($scope, TipoPagoResource, $state, $stateParams){

        $scope.action = 'edit';
        $scope.title = "Editar precio";
        $scope.submitButton = "Editar";
        $scope.tipo = TipoPagoResource.get({id: $stateParams.id});

        $scope.editPrecio = function(){
            $scope.tipo = TipoPagoResource.update($scope.tipo);
            $scope.tipo.$promise.then(function(data){
                $scope.tipo = data;
                alert("Precio editado con exito");
                $state.go('precioPlataforma');
            },function(error){
                alert(error);
                return;
            });
        };

    });
