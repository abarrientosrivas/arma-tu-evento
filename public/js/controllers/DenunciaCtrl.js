	'use strcit'

angular.module('Client')
	.controller('CreateDenunciaCtrl', function($scope, $stateParams, DenunciaResource, ClienteResource, PostResource, $window, $timeout, $routeParams) {

		$scope.denuncia = {};
		$scope.post = PostResource.get({ id: $stateParams.postId	});

		$scope.post.$promise.then(function(data){
				console.log($scope.post);
				$scope.saveDenuncia = function() {
					$scope.denuncia.post_id = $scope.post.id;
					console.log($scope.denuncia);
					// $scope.cliente = ClienteResource.get({id: $scope.cliente_id});
					console.log("cliente_id: " + $scope.denuncia.cliente_id);
					// $scope.denuncia.cliente_id = $scope.cliente.id;
					$scope.denuncia = DenunciaResource.save($scope.denuncia);
					$scope.denuncia.$promise.then(function(data){
						alert("Denuncia registrada con exito");
						$scope.denuncia = data;
						$window.location.href = '/#!/proveedores/profile/' + $scope.post.proveedor_id;
					}, function(error){
						alert("Error en cargar la denuncia");
						console.log(error);
						return;
					});
				};
		});
	})

	.controller('ListClienteDenunciaCtrl', function($scope, ClienteResource, DenunciaResource, $state, $stateParams){
		$scope.action = 'verClienteDenuncias'
		$scope.cliente = ClienteResource.get({ id: $stateParams.id });
		// $scope.certificados = CertificadoResource.query();
		// console.log("proveedor remove: " + $scope.proveedor.id);
		$scope.cliente.$promise.then(function(data){
			$scope.denuncias = $scope.cliente.denuncias;
		},function(error){
			console.log(error);
			return;
		});

		$scope.removeDenuncia = function(denuncia){
			if(confirm("¿Desea borrar esta denuncia?")){
				DenunciaResource.delete({id: denuncia.id});
				var index = $scope.denuncias.indexOf(denuncia);
				$scope.denuncias.splice(index, 1);
				// $state.reload();
			}
		};

	})

	.controller('ListDenunciaCtrl', function($scope, DenunciaResource, $state, $timeout, $window){
		$scope.denuncias = DenunciaResource.query();

		$scope.viewDenuncia = function(denunciaId){
			$window.location.href = '/#!/denuncias/view/' + denunciaId;
		};

		$scope.removeDenuncia = function(denuncia){
			if(confirm("¿Desea borrar esta denuncia?")){
				DenunciaResource.delete({id: denuncia.id});
				var index = $scope.denuncias.indexOf(denuncia);
				$scope.denuncias.splice(index, 1);
				// $state.reload();
			}
		};
	})

	.controller('ViewDenunciaCtrl', function($scope, $stateParams, DenunciaResource, $routeParams){
		$scope.action = 'view';
		console.log("id: " + $stateParams.id);
		$scope.denuncia = DenunciaResource.get({id: $stateParams.id});
	});
