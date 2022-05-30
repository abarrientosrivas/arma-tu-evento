'use strict';

angular.module('Client')
	.controller('CreateResenaCtrl', function($scope, ResenaResource, PostResource, $stateParams) {

		// $scope.title = "Nueva resena";
		// $scope.button = "Registrar";
		$scope.resena = {};

		$scope.post = PostResource.get({ id: $stateParams.postId	});

		$scope.post.$promise.then(function(data){
				$scope.saveResena = function() {
					$scope.resena.post_id = $scope.post.id;
					console.log($scope.resena);
					ResenaResource.save($scope.resena, function(error, data){
						if(error){
							console.log(error);
							return;
						}
						$scope.resena = data;
					});
				};
			}, function(error){
				console.log(error);
				return;
			});
	})

	.controller('ListClienteResenaCtrl', function($scope, $state, $stateParams, ClienteResource, ResenaResource, $rootScope){
		$scope.action = 'verClienteResenas'
		$scope.cliente = ClienteResource.get({ id: $stateParams.id });
		// $scope.certificados = CertificadoResource.query();
		// console.log("proveedor remove: " + $scope.proveedor.id);
		$scope.cliente.$promise.then(function(data){
			$scope.resenas = $scope.cliente.resenas;
		},function(error){
			console.log(error);
			return;
		});

		$scope.removeResena = function(resena){
			if ($rootScope.currentUser.rol != 'cliente' || $rootScope.currentUser.id != resena.cliente_id) { $state.go('homepage'); }
			if(confirm("¿Desea borrar esta reseña?")){
				ResenaResource.delete({id: resena.id});
				var index = $scope.resenas.indexOf(resena);
				$scope.resenas.splice(index, 1);
				// $state.reload();
			}
		};
	})

	.controller('ViewResenaCtrl', function($scope, ResenaResource, $stateParams, $state, $rootScope) {
		// $scope.title = "Editar Cliente";
		// $scope.button = "Actualizar";
		$scope.action = 'view';
		$scope.resena = ResenaResource.get({id: $stateParams.resId});

		$scope.resena.$promise.then(function(data){
		});

	})

	.controller('EditResenaCtrl', function($scope, ResenaResource, $stateParams, $state, $rootScope) {
		// $scope.title = "Editar Cliente";
		// $scope.button = "Actualizar";
		$scope.action = 'edit';
		$scope.resena = ResenaResource.get({id: $stateParams.resId});

		$scope.resena.$promise.then(function(data){
			if ($rootScope.currentUser.rol != 'cliente' || $rootScope.currentUser.id != data.cliente_id) { $state.go('homepage'); }
		})

		$scope.saveResena = function() {
			if ($rootScope.currentUser.rol != 'cliente' || $rootScope.currentUser.id != $scope.resena.cliente_id) { $state.go('homepage'); }
			//console.log($scope.resena);
			ResenaResource.update($scope.resena, function(error, data){
				if(error){
					console.log(error);
					return;
				}
				$scope.resena = data;
				// Materialize.toast('Cliente Actualizado.', 5000, 'green accent-4');
			});
				$state.go('postsView',{postId: $scope.resena.post_id});
		};
	});
