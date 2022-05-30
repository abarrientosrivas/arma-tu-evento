'use strict';

angular.module('Client')
	.controller('LoginAdminCtrl', function($scope, AuthService) {
		$scope.userType = 'administrador';
		$scope.login = function() {
			AuthService.login({email: $scope.email,password: $scope.password}, '/authenticate/admin', 'homepage', 'navbar.admin.html');
		}
	})

	.controller('ListRubroCtrl', function($scope, RubroResource, $state){
		$scope.rubros = RubroResource.query({action: 'posts'});
	})

	.controller('AdminPlataformaCtrl', function($scope, $state, ClienteResource, 
		ProveedorResource, RubroResource, ResenaResource, PostResource, PagoResource, EventoResource){
			$scope.clientes = ClienteResource.query();
			$scope.proveedores = ProveedorResource.query();
			$scope.rubros = RubroResource.query();
			$scope.eventos = EventoResource.query();
			$scope.resenas = ResenaResource.query();
			$scope.posts = PostResource.query();

			$scope.viewPost = function(postId){
				$state.go('postsView', {postId: postId});
			}
			$scope.viewResena = function(resId){
				$state.go('resenasView', {resId: resId});
			}
	});