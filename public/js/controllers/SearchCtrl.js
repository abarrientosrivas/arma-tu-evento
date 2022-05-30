'use strict';

angular.module('Client')
	.controller('SearchCtrl', function($scope, EventoResource, SearchResource, RubroResource, NotificacionResource, $state, $filter, $stateParams, $rootScope) {

		$scope.action = 'results';
		$scope.posts = {};
		$scope.search = {};
		$scope.newEvent = {};
		$scope.newEvent.posts = [];
		$scope.rubros = RubroResource.query({action: 'posts'});

		if (parseInt($stateParams.dateMillis)) { $scope.search.fecha = new Date(parseInt($stateParams.dateMillis)); }
		else { $scope.search.fecha = new Date(); }
		$scope.newEvent.fecha = $scope.search.fecha;

		$scope.search.dateMillis = $scope.search.fecha.getTime();
		$scope.search.cantPersonas = parseInt($stateParams.cantPers);

		function nullLast(array){
			var aux = [];
			array.forEach(function(item){
				if(!item.destacado && (item.maxPersonas == 0 || item.maxPersonas == null)){
					aux.push(item);
				}
			});
			aux.forEach(function(itemAux){
				array.splice(array.indexOf(itemAux), 1);
				array.push(itemAux);
			});
		};
		
		var allPosts = SearchResource.array($scope.search);
		allPosts.$promise.then(function(data){
			$scope.posts = allPosts;
			nullLast($scope.posts);
		}, function(error){
			console.log(error);
			return;
		});

		$scope.searchPosts = function() {
			$scope.action = 'results';
			$scope.search.dateMillis = $scope.search.fecha.getTime();
			if($scope.search.cantPersonas == ''){$scope.search.cantPersonas = '-'}
			allPosts = SearchResource.array($scope.search);
			allPosts.$promise.then(function(data){
				$scope.posts = allPosts;
				nullLast($scope.posts);
			}, function(error){
				console.log(error);
				return;
			});
			$scope.newEvent.fecha = $scope.search.fecha;
		};

		$scope.filterPosts = function(rubro) {
			$scope.posts = [];
			allPosts.forEach(function(post){
				if(post.rubro.id == rubro.id){
					$scope.posts.push(post);
				}
			});
			nullLast($scope.posts);
		};

		$scope.allPosts = function() {
			$scope.posts = allPosts;
			nullLast($scope.posts);
		};

		$scope.viewPost = function(postId){
			$state.go('postsView', {postId: postId});
		}

		$scope.addToEvent = function(post){
			$scope.newEvent.posts.push(post);
			post.added = true;
		}

		$scope.removeFromEvent = function(post){
			$scope.newEvent.posts.splice($scope.newEvent.posts.indexOf(post), 1);
			post.added = false;
		}

		$scope.createEvent = function(){
			if ($rootScope.currentUser.rol != 'cliente') { $state.go('homepage'); }
			if($scope.newEvent.posts.length == 0){
				alert("Ninguna publicación seleccionada");
				return;
			}
			if(!$scope.search.cantPersonas || $scope.search.cantPersonas == "-"){
				alert("Indique la cantidad de participantes");
				return;
			}
			$scope.action = 'newEvent';
			$scope.search.fecha = $scope.newEvent.fecha;
			$scope.newEvent.cantPersonas = $scope.search.cantPersonas;
			$scope.newEvent.cliente_id = $rootScope.currentUser.id;

			$scope.newEvent.posts.forEach(function(post){
				var changed;
				if(post.maxPersonas!=null && post.maxPersonas!=0 && post.maxPersonas < $scope.newEvent.cantPersonas){
					$scope.newEvent.cantPersonas = post.maxPersonas;
					changed = true;
				}
				if(changed){
					alert("La cantidad de asistentes se ajustó en base a las publicaciones seleccionadas.");
					$scope.search.cantPersonas = $scope.newEvent.cantPersonas;
				}
			});

			$scope.posts = $scope.newEvent.posts;
		}

		$scope.saveEvent = function(){
			// save event
			if($scope.newEvent.posts.length == 0){
				alert("No se han seleccionado publicaciones");
				return;
			}
			$scope.newEvent.posts.forEach(function(post){
				console.log('saving' + post.titulo);
				NotificacionResource.save({proveedor_id: post.proveedor_id, title: 'Nueva solicitud', body: 'Tu publicación ha sido solicitada', reference: 'solicitudes'});
			});
			$scope.newEvent.fecha = $filter('date')($scope.search.fecha,"yyyy-MM-dd");
			$scope.newEvent = EventoResource.save($scope.newEvent);
			$scope.newEvent.$promise.then(function(data){
				alert("Evento guardado con éxito.");
				$state.go('clientesProfile', {id: $scope.newEvent.cliente_id});
			}, function(error){
				alert(error);
				console.log(error);
				return;
			});
		}
	});