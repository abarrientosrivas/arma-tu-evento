'use strict';

angular.module('Client')
	.controller('CreatePostCtrl', function($scope, PostResource, ProveedorResource, $stateParams) {

		$scope.title = "Nueva publicación";
		$scope.button = "Registrar";
		$scope.titleLabel = "Título:";
		$scope.bodyLabel = "Cuerpo:";
		$scope.post = {};

		$scope.proveedor = ProveedorResource.get({ id: $stateParams.provId	});

		$scope.proveedor.$promise.then(function(data){
				$scope.savePost = function() {
					$scope.post.proveedor_id = $scope.proveedor.id;
					PostResource.save($scope.post, function(error, data){
						if(error){
							console.log(error);
							return;
						}
						$scope.post = data;
					});
				};
			}, function(error){
				console.log(error);
				return;
			});

	})
	.controller('ViewPostCtrl', function($scope, RubroResource, ClienteResource, ResenaResource, PostResource, PostImageResource, $stateParams, $rootScope) {
		$scope.action = 'viewPost';

		$scope.post = PostResource.get({ id: $stateParams.postId	});
		$scope.resena = {};
		$scope.rubros = RubroResource.query({ action: 'posts'});
		// $scope.resenas = ResenaResource.query({ action: 'posts'});
		$scope.images = [];
		// $scope.cliente = ClienteResource.get({ id: $scope.resena.cliente_id });

		$scope.post.$promise.then(function(data){
				$scope.resenas = $scope.post.resenas;
				// console.log("cliente_id " + $scope.resena.cliente_id);
				$scope.resenas.forEach(function(resena){
					$scope.cliente = {};
					$scope.cliente = ClienteResource.get({ id: resena.cliente_id });
					// console.log("cliente: " + $scope.cliente);
				});
				$scope.rubro = $scope.post.rubro;
				// $scope.cliente = $scope.cliente;
				loadImages($scope.post.post_images);
			}, function(error){
				console.log(error);
				return;
			});

		function loadImages(array){
			$scope.images = [];
			array.forEach(function(item){
				$scope.images.push('/assets/post-album-images/' + item.filename);
			});
			if(array[0]){ $scope.currentImage = '/assets/post-album-images/' + array[0].filename; } else { $scope.currentImage = undefined; }
		}

		$scope.addImage = function() {
			if ($rootScope.currentUser.rol != 'proveedor' || $rootScope.currentUser.id != $scope.post.proveedor_id) { $state.go('homepage'); }
			if ($scope.images.length >= 6) { alert("Se ha alcanzado el máximo de imágenes"); return; }
			var callback = PostImageResource.save({
				postId: $scope.post.id,
				dataURL: $scope.image.dataURL
			});
			callback.$promise.then(function(data){
				$scope.post.post_images = data.post_images;
				loadImages(data.post_images);
			}, function(error){
				alert(error);
			});
		}
		$scope.showImage = function(img) {
			$scope.currentImage = img;
		}
		$scope.deleteImage = function(img) {
			if ($rootScope.currentUser.rol != 'proveedor' || $rootScope.currentUser.id != $scope.post.proveedor_id) { $state.go('homepage'); }
			var callback = PostImageResource.delete({id: $scope.post.post_images[$scope.images.indexOf(img)].id});
			callback.$promise.then(function(data){
				$scope.post.post_images.splice($scope.images.indexOf('/assets/post-album-images/' + data.filename),1);
				loadImages($scope.post.post_images);
			}, function(error){
				alert(error);
			});
		}


		$scope.saveResena = function() {
			if ($rootScope.currentUser.rol != 'cliente') { $state.go('homepage'); }
			$scope.resena.post_id = $scope.post.id;
			$scope.resena.cliente_id = $rootScope.currentUser.id;
			if($scope.resena.calificacion == 1){
				if(!$scope.resena.cuerpo){
					alert("Debe ingresar una descripción cuando la calificación es de una estrella");
					return;
				}
			}
			$scope.resena = ResenaResource.save($scope.resena);

			$scope.resena.$promise.then(function(data){
				$scope.resena = data;
				$scope.resenas.push($scope.resena);
				$('#exampleModalResena').modal('hide'); //or  $('#IDModal').modal('hide');
			}, function(error){
				console.log(error);
				return;
			});
			};

			$scope.removeResena = function(delResena) {
				if ($rootScope.currentUser.rol != 'cliente' || $rootScope.currentUser.id != delResena.cliente_id) { $state.go('homepage'); }
				if(confirm("¿Desea borrar esta reseña?")){
				ResenaResource.delete({ id: delResena.id });
				var index = $scope.resenas.indexOf(delResena);
				$scope.resenas.splice(index, 1);
				}
			};

	})

	.controller('PostExitoCtrl', function($scope, PostResource, PagoResource, TipoPagoResource, $stateParams, $state, $filter){
		let pago = {};
		pago.tipo = "Pago publicación destacada";
		pago.fecha_pago = $filter('date')(new Date(),"yyyy-MM-dd HH:mm:ss");
		var tipo = TipoPagoResource.get({id: 1}); // traer pago post
		tipo.$promise.then(function(data){
			pago.monto = tipo.precio;
		})
		$scope.post = PostResource.get({id: $stateParams.postId});
		$scope.post.$promise.then(function(data){
			$scope.post.destacado = 1;
			PostResource.update($scope.post);
			console.log("destacado: " + $scope.post.destacado);
			pago.proveedor_id = $scope.post.proveedor_id;
			PagoResource.save(pago);
			$scope.volver = function(){
				$state.go('proveedoresProfile', {id: $scope.post.proveedor_id});
			}
		}, function(error){
			console.log("Error: " + error);
			return;
		})

		
	})

	.controller('EditPostCtrl', function($scope, RubroResource, PostResource, $stateParams, $rootScope, $state) {

		$scope.title = "Modificar publicación";
		$scope.button = "Registrar";
		$scope.action = 'edit';

		$scope.post = PostResource.get({id: $stateParams.id});

		$scope.post.$promise.then(function(data){
			console.log(data.proveedor_id);
			console.log($rootScope.currentUser.id);
			if ($rootScope.currentUser.rol != 'proveedor' || $rootScope.currentUser.id != data.proveedor_id) { $state.go('homepage'); }
		})

		$scope.rubros = RubroResource.query({ action: 'posts'});

		$scope.savePost = function() {
			if ($rootScope.currentUser.rol != 'proveedor' || $rootScope.currentUser.id != $scope.post.proveedor_id) { $state.go('homepage'); }
			if ($scope.post.displayImage) { $scope.post.setFeatured = $scope.post.displayImage.dataURL; }
			$scope.post = PostResource.update($scope.post);

			$scope.post.$promise.then(function(data){
				$scope.post = data;
				$scope.displayImage = {};
				alert("Publicación actualizada");
			}, function(error){
				console.log(error);
				alert(error);
				return;
			});

		};

	});
