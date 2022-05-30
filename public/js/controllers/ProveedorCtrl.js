'use strict';

angular.module('Client')
	.controller('LoginProveedorCtrl', function($scope, AuthService) {
		$scope.userType = 'proveedor';
		$scope.login = function() {
			AuthService.login({email: $scope.email,password: $scope.password}, '/authenticate/proveedor', 'proveedoresProfile', 'navbar.proveedor.html');
		}
	})
	.controller('ListProveedorCtrl', function($scope, ProveedorResource, $state) {

		$scope.title = "Proveedores registrados";
		$scope.searchph = "Buscar";
		$scope.proveedores = ProveedorResource.query();

		//Remove proveedor function
		$scope.removeProveedor = function(delprov) {
			$scope.provHoldPromise = ProveedorResource.delete({ id: delprov.id });
			$scope.provHoldPromise.$promise.then(function(data){
				var index = $scope.proveedores.indexOf(delprov);
				$scope.proveedores.splice(index, 1); 
			}, function(error){
				console.log(error);
				return;
			});
		};

		//Redirect to proveedor view
		$scope.viewProveedor = function(idProv) {
			$state.go('proveedoresProfile',{id:idProv});
		};

	})
	.controller('CreateProveedorCtrl', function($scope, RubroResource, ProveedorResource, $state, $rootScope) {
		if ($rootScope.currentUser.rol != 'admin') { $state.go('homepage'); }

		$scope.title = "Registrar proveedor";
		$scope.submitButton = "Registrar";
		$scope.proveedor = {};
		$scope.action = 'new';

		$scope.rubros = RubroResource.query();

		$scope.rubros.$promise.then(function(data){
			$scope.proveedor.rubro = RubroResource.get({id:1});
		}, function(error){
			console.log(error);
			return;
		});

		$scope.saveProveedor = function() {
			$scope.proveedor.rubro_id = $scope.proveedor.rubro.id;
			$scope.proveedor = ProveedorResource.save($scope.proveedor);
			$scope.proveedor.$promise.then(function(data){
				alert("Registrado con exito");
				$scope.proveedor = data;
				$state.go('proveedoresList');
			}, function(error){
				alert("Error en la creación");
				console.log(error);
				return;
			});
		};

	})
	.controller('EditProveedorCtrl', function($scope, RubroResource, ProveedorResource, $state, $rootScope) {
		if ($rootScope.currentUser.rol != 'proveedor') { $state.go('homepage'); }

		$scope.title = "Modificar registro";
		$scope.submitButton = "Actualizar";
		$scope.action = 'edit';

		$scope.rubros = RubroResource.query();
		$scope.proveedor = ProveedorResource.get({
			id: $rootScope.currentUser.id
		});

		$scope.saveProveedor = function() {
			ProveedorResource.update($scope.proveedor, function(error, data){
				if(error){
					console.log(error);
					return;
				}
				$scope.proveedor = data;
			});
			$state.go('proveedoresList');
		};

	})
	.controller('ViewProveedorCtrl', function($scope, $http, ChatResource, RubroResource, ProveedorResource, PostResource, $stateParams, $state, $rootScope) {
		console.log($rootScope.currentUser.rol);

		$scope.postButton = "Nueva publicación";
		$scope.header = "Publicaciones";
		$scope.action = 'view';
		$scope.newPost = 'true';
		$scope.totalPosts = 0;
		$scope.totalContracts = 0;
		$scope.authenticated = $rootScope.authenticated;

		$scope.post = {};

		$scope.proveedor = ProveedorResource.get({ id: $stateParams.id	});
		// $scope.posts = $http({
		// 		headers: {
		// 			'Content-Type': 'application/json'
		// 		},
		// 		url: 'post/resenas',
		// 		method: "GET"
		// 		// data: {
		// 		// 	profileImage: $scope.image.dataURL,
		// 		// 	cliente_id: $rootScope.currentUser.id
		// 		// }
		// 	});

		$scope.proveedor.$promise.then(function(data){
				$scope.proveedor.profilePic = "default.jpg";
				$scope.title = $scope.proveedor.nombre;
				$scope.posts = $scope.proveedor.posts;
				
				$scope.posts.forEach(function(post){
					var promedio = 0;
					if(post.resenas.length > 0){
						post.resenas.forEach(function(resena){
							promedio = promedio + resena.calificacion;
						});
						// console.log("pormedio: " + promedio);
						promedio = promedio / post.resenas.length;
						post.promedio = promedio.toFixed(2);
						PostResource.update(post);
					}
				});
				// $scope.posts.forEach(function(post){
				// 	var promedio = $http({
				// 				headers: {
				// 					'Content-Type': 'application/json'
				// 				},
				// 				url: 'post/promedio/'+post.id,
				// 				method: "GET"
				// 				// data: {
				// 				// 	profileImage: $scope.image.dataURL,
				// 				// 	cliente_id: $rootScope.currentUser.id
				// 				// }
				// 			});
				// 	// promedio.forEach(function(p){
				// 	// 	post.promedio = p;	
				// 	// })
				// 	console.log("promedio: "+promedio);
				// 	post.promedio = promedio;
				// 	PostResource.update(post);
				// });
				// $scope.posts = PostResource.query({ action: 'resenas' });
				$scope.totalPosts = $scope.posts.length;
			}, function(error){
				console.log(error);
				return;
			});

		$scope.rubros = RubroResource.query({ action: 'posts'});

		$scope.rubros.$promise.then(function(data){
			$scope.post.rubro = $scope.rubros[0];
		}, function(error){
			console.log(error);
			return;
		});

		//Go to chat with cliente
		$scope.gotoChat = function(provId,cliId){
			if ($rootScope.currentUser.rol != 'cliente') { $state.go('homepage'); }

			var callback = ChatResource.find({action: 'find', id: provId, otherId: cliId});
			callback.$promise.then(function(data){
				$state.go('clienteChat',{chatId: data.id});
			})
		}

		//Remove post function
		$scope.removePost = function(delpost) {
			if ($rootScope.currentUser.rol != 'proveedor' || $rootScope.currentUser.id != $scope.proveedor.id) { $state.go('homepage'); }
			PostResource.delete({
				id: delpost.id
			});
			var index = $scope.posts.indexOf(delpost);
			$scope.posts.splice(index, 1);
		};

		$scope.pagarPost = function(post) {
			if ($rootScope.currentUser.rol != 'proveedor' ||
				$rootScope.currentUser.id != $scope.proveedor.id) { $state.go('homepage'); }
			
			$state.go('pagarPost', {postId: post.id});
		};

		$scope.savePost = function() {
			if ($rootScope.currentUser.rol != 'proveedor' || $rootScope.currentUser.id != $scope.proveedor.id) { $state.go('homepage'); }
			$scope.post.proveedor_id = $scope.proveedor.id;
			$scope.post.rubro_id = $scope.post.rubro.id;
			if ($scope.post.displayImage) { $scope.post.setFeatured = $scope.post.displayImage.dataURL; }
			$scope.post = PostResource.save($scope.post);
			$scope.savedRubro = $scope.post.rubro;

			$scope.post.$promise.then(function(data){
				$scope.post = data;
				$scope.post.rubro = $scope.savedRubro;
				$scope.posts.splice(0,0,$scope.post);
				$scope.totalPosts = $scope.posts.length;
				alert("Publicación exitosa");
				$('#exampleModal').modal('hide'); //or  $('#IDModal').modal('hide');
				$scope.post = {};
				$scope.post.rubro = $scope.rubros[0];
			}, function(error){
				console.log(error);
				return;
			});
		};

		$scope.viewPost = function(postId){
			$state.go('postsView', {postId: postId});
		}

		$scope.profileImage = function(){
				// var tmp = ProveedorResource.update({
				// 	id: $scope.proveedor.id,
				// 	profileImage: $scope.image.dataURL
				// });
				// tmp.$promise.then(function(){$state.reload()});
			if ($rootScope.currentUser.rol != 'proveedor' || $rootScope.currentUser.id != $scope.proveedor.id) { $state.go('homepage'); }
			$http({
				headers: {
					'Content-Type': 'application/json'
				},
				url: 'proveedor/profile',
				method: "PUT",
				data: {
					profileImage: $scope.image.dataURL,
					proveedor_id: $rootScope.currentUser.id
				}
			}).then(function(){
				$state.reload();
			})
		}

	})
	.controller('ProvCalendarCtrl', function($scope, SearchResource, ProveedorResource, $rootScope) {
		if ($rootScope.currentUser.rol != 'proveedor') { $state.go('homepage'); }

		$(document).ready(function() {

			$('#calendar').fullCalendar({
			  header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,listWeek'
			  },
			  height: 'auto',
			  locale: 'es',
			  navLinks: true, // can click day/week names to navigate views
			  editable: false,
			  eventLimit: true // allow "more" link when too many events
			});

			var calendar = $('#calendar').fullCalendar('getCalendar');

			$scope.proveedor = ProveedorResource.get({id: $rootScope.currentUser.id});
			$scope.activities = SearchResource.array({provId: $rootScope.currentUser.id});

			$scope.activities.$promise.then(function(data){
				console.log($scope.activities);
				$scope.activities.forEach(function(activity){
					calendar.renderEvent({
						title  : activity.titulo + " - " + activity.apellido + " " + activity.nombre,
						start  : activity.fecha,
						url: '#!/posts/view/'+activity.id,
						allDay: true
					}, 'stick');
				});
			}, function(error){
				console.log(error);
				return;
			});

		});

	})

	.controller('ProvSuscExitoCtrl', function($scope, $filter, TipoPagoResource, PagoResource, ProveedorResource, $rootScope, $state){
		var pago = {}; ///////////////
		$scope.proveedor = ProveedorResource.get({id: $rootScope.currentUser.id});
		$scope.proveedor.$promise.then(function(data){
			pago.proveedor_id = $scope.proveedor.id; ///////////////
			$scope.tipo = TipoPagoResource.get({id: $scope.proveedor.tipo_susc_id});
			var tiempoMilisegundos = 1;

			$scope.tipo.$promise.then(function(data){
				if($scope.tipo.periodo == "Mensual"){
					tiempoMilisegundos = 1000 * 60 * 60 * 24 * 30;
					pago.tipo = "Pago mensual";
				}
				if($scope.tipo.periodo == "Trimestral"){
					tiempoMilisegundos = 1000 * 60 * 60 * 24 * 90;
					pago.tipo = "Pago trimestral";
				}
				if($scope.tipo.periodo == "Anual"){
					tiempoMilisegundos = 1000 * 60 * 60 * 24 * 360;
					pago.tipo = "Pago anual";
				}
				let hoy = new Date();
				let suma = hoy.getTime() + tiempoMilisegundos; //getTime devuelve milisegundos de esa fecha
				let fechaFinSusc = new Date(suma);
				// console.log(fechaFinSusc);
				$scope.proveedor.fin_susc = $filter('date')(fechaFinSusc,"yyyy-MM-dd HH:mm:ss");
				ProveedorResource.update($scope.proveedor);

				pago.fecha_fin = $filter('date')(fechaFinSusc,"yyyy-MM-dd HH:mm:ss"); ///////////////
				pago.monto = $scope.tipo.precio; ///////////////
				pago.fecha_pago = $filter('date')(new Date(),"yyyy-MM-dd HH:mm:ss"); ///////////////
				PagoResource.save(pago); ///////////////
			})
			$scope.proveedor.pago = true;
			ProveedorResource.update($scope.proveedor);
		},function(error){
			console.log(error);
			return;
		});

		$scope.volver = function() {
			$state.go('proveedoresProfile',{id: $rootScope.currentUser.id});
		}
	})

	.controller('RubroExitoCtrl', function($scope, $filter, TipoPagoResource, PagoResource, ProveedorResource, $rootScope, $state){
		let pago = {};
		pago.tipo = "Pago rubro destacado";
		pago.fecha_pago = $filter('date')(new Date(),"yyyy-MM-dd HH:mm:ss");
		pago.proveedor_id = $rootScope.currentUser.id;
		var tipo = TipoPagoResource.get({id: 2}); // traer pago rubro
		tipo.$promise.then(function(data){
			pago.monto = tipo.precio;
			PagoResource.save(pago);
			console.log("monto: " + pago.monto);
		})

		$scope.proveedor = ProveedorResource.get({id: $rootScope.currentUser.id});
		$scope.proveedor.$promise.then(function(data){
			$scope.proveedor.destacado_rubro = 1;
			ProveedorResource.update($scope.proveedor);

		}, function(error){
			console.log("Error: " + error);
			return;
		});

		$scope.volver = function() {
			$state.go('proveedoresProfile',{id: $rootScope.currentUser.id});
		}
	})

	.controller('ProvSuscripcionCtrl', function($scope, TipoPagoResource, ProveedorResource, $rootScope, $state) {
		if ($rootScope.currentUser.rol != 'proveedor') { $state.go('homepage'); }
		$scope.action = 'editarPeriodo';
		$scope.title = "Elegir periodicidad de pago";
		$scope.tipos = TipoPagoResource.query();
		$scope.proveedor = ProveedorResource.get({id: $rootScope.currentUser.id});

		$scope.proveedor.$promise.then(function(data){
			if($scope.proveedor.tipo_susc_id != null){
				$scope.tipo = TipoPagoResource.get({id: $scope.proveedor.tipo_susc_id});
			}
		})

		$scope.elegir = function(tipoId) {
			$scope.proveedor.$promise.then(function(data){
			$scope.proveedor.tipo_susc_id = tipoId;
			ProveedorResource.update($scope.proveedor);
			$state.go('proveedoresSuscripcion',{id: $rootScope.currentUser.id});
			},function(error){
				console.log(error);
				return;
			})
		}

		$scope.saveSusc = function() {
			$scope.proveedor.$promise.then(function(data){
				$scope.proveedor.tipo_susc = data.tipo_susc;
				// console.log($scope.proveedor.tipo_susc);
				// console.log(data.tipo_susc);
				ProveedorResource.update($scope.proveedor);
				$state.go('proveedoresProfile',{id: $rootScope.currentUser.id});
			}, function(error){
				console.log(error);
				return;
			});
		};
	})
	.controller('ProvConversationsCtrl', function($scope, ChatResource, $rootScope, $state) {
		if ($rootScope.currentUser.rol != 'proveedor') { $state.go('homepage'); }
		$scope.action = 'proveedor';
		$scope.chats = ChatResource.query({action: 'proveedor', id:$rootScope.currentUser.id});

		$scope.viewChat = function(id){
			$state.go('proveedorChat', {id:$rootScope.currentUser.id,chatId:id})
		}

	})
	.controller('ProveedorChatCtrl', function($scope, ChatResource, $pusher, $stateParams, $rootScope, $state) {
		if ($rootScope.currentUser.rol != 'proveedor') { $state.go('homepage'); }
		$scope.action = 'proveedor';
		$scope.chat = ChatResource.get({id:$stateParams.chatId});
		$scope.chat.$promise.then(function(data){
			console.log(data);
			if ($rootScope.currentUser.id != data.proveedor_id) { $state.go('homepage'); }
			$scope.mensajes = data.messages;
		}, function(error){
			console.log(error.data.error);
		});

		var client = new Pusher("e20f13ba1c1961c8f5e7",{
			cluster: "us2",
		});
		var pusher = $pusher(client);
		var channel = pusher.subscribe('chat');
		channel.bind("App\\Events\\MessageSent",function(data){
			if (data.id == $stateParams.chatId) {
				var callback = ChatResource.find({action: 'message', id: data.message.id});
				callback.$promise.then(function(data){
					$scope.mensajes.push(data);
				})
			}
		});

		$scope.saveData = function (file) {
			var a = document.createElement("a");
			document.body.appendChild(a);
			a.style = "display: none";
			return function (file) {
				var l, d, array;
				d = file.binary;
				l = d.length;
				array = new Uint8Array(l);
				for (var i = 0; i < l; i++){
					array[i] = d.charCodeAt(i);
				}
				var blob = new Blob([array], {type: file.filetype}),
					url = window.URL.createObjectURL(blob);
				a.href = url;
				a.download = file.filename;
				a.click();
				window.URL.revokeObjectURL(url);
			};
		}();

		$scope.sendMessage = function(){
			ChatResource.save({id:$stateParams.chatId,action:"message"},{
				senderName: $rootScope.currentUser.nombre, 
				message: $scope.newMessage,
				fileMessage: $scope.fileMessage
			});
			$scope.newMessage = "";
			$scope.fileMessage = "";
		}
	});
