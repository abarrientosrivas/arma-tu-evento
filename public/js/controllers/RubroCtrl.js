'use strict';

angular.module('Client')
	.controller('RubroListCtrl', function($scope, $state, $stateParams, ProveedorResource) {
		$scope.title = $stateParams.rubroName;

		$scope.proveedores = ProveedorResource.query({action: 'rubro', id: encodeURIComponent($stateParams.rubroName)});

		$scope.viewProveedor = function(proveedor_id) {
			$state.go('proveedoresProfile',{id: proveedor_id});
		};
	})
	.controller('CreateRubroCtrl', function($scope, RubroResource, $rootScope, $state) {
		if ($rootScope.currentUser.rol != 'admin') { $state.go('homepage'); }

		$scope.rubro = {};

		$scope.saveRubro = function(){
			if ($scope.rubro.displayImage) { $scope.rubro.setFeatured = $scope.rubro.displayImage.dataURL; }
			var callback = RubroResource.save($scope.rubro);
			$state.go('rubros');
		};

	});