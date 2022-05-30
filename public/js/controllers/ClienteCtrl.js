'use strict';

angular.module('Client')
	.controller('LoginClienteCtrl', function($scope, $state, AuthService, $rootScope) {
		$scope.userType = 'cliente';
		$scope.login = function() {
			AuthService.login({email: $scope.email,password: $scope.password}, '/authenticate/cliente', 'clientesProfile', 'navbar.cliente.html');
		}
	})
	.controller('ListClienteCtrl', function($scope, $state, $route, ClienteResource, $timeout) {
		$scope.Clientes = ClienteResource.query();
		$scope.removeCliente = function(id) {
			ClienteResource.delete({
				id: id
			});
			// Materialize.toast('Cliente Eliminado.', 5000, 'green accent-4');
			$timeout(function() {
					// $location.path('/clientes/list');
				$route.reload();
			}, 1000);
		};
		$scope.viewCliente = function(idCliente) {
			$state.go('clientesProfile',{id:idCliente});
		};
	})
	.controller('CreateClienteCtrl', function($scope, ClienteResource, $state, $rootScope) {
		// if ($rootScope.currentUser.authenticated) { $state.go('homepage'); }
		$scope.title = "Crear Usuario";
		$scope.button = "Crear";
		$scope.action = 'new';
		$scope.Cliente = {};

		var password = document.getElementById("cliente_password")
		var confirm_password = document.getElementById("confirm_password");

		function validatePassword(){
			if(password.value != confirm_password.value) {
				confirm_password.setCustomValidity("Passwords Don't Match");
			} else {
				confirm_password.setCustomValidity('');
			}
		}

		password.onchange = validatePassword;
		confirm_password.onkeyup = validatePassword;

		$scope.saveCliente = function() {
			$scope.Cliente = ClienteResource.save($scope.Cliente);
			$scope.Cliente.$promise.then(function(data){
				$scope.Cliente = data;
				alert("Cliente creado");
				$state.go('clientesList');
			}, function(error){
				alert("Error");
				return;
			});
		};
	})
	.controller('EditClienteCtrl', function($scope, ClienteResource, $state, $timeout, $rootScope) {
		if ($rootScope.currentUser.rol != 'cliente') { $state.go('homepage'); }

		$scope.action = 'edit';
		$scope.title = "Editar Cliente";
		$scope.button = "Actualizar";
		$scope.Cliente = ClienteResource.get({
			id: $rootScope.currentUser.id
		});

		$scope.saveCliente = function() {
			//console.log($scope.Cliente.id);
			ClienteResource.update($scope.Cliente, function(error, data){
				if(error){
					console.log(error);
					return;
				}
				$scope.Cliente = data;
				Materialize.toast('Cliente Actualizado.', 5000, 'green accent-4');
			});
			$timeout(function() {
				$state.go('clientesProfile',{id: $rootScope.currentUser.id});
			}, 1000);
		};
	})

	.controller('CambiarPasswordCtrl', function($scope, ClienteResource, $state, $timeout, $rootScope){
		$scope.Cliente = ClienteResource.get({
			id: $rootScope.currentUser.id
		});

		$scope.cambiarPassword = function(){
			if(document.getElementById("confirm_pass").value ==  document.getElementById("cliente_pass").value){
				$scope.Cliente.$promise.then(function(data){
					$scope.Cliente = data;
					ClienteResource.update($scope.Cliente);
					alert("Contraseña cambiada correctamente");
					$state.go('clientesProfile',{id: $rootScope.currentUser.id});
				}, function(error){
					console.log("ERROR: " + error);
					return;
				})			
			} else {
				alert("Las contraseñas no coinciden");
			}
		}
	})

	.controller('ViewClienteCtrl', function($scope, $http, $rootScope, $state, ChatResource, EventoResource, ClienteResource, $stateParams) {

		$scope.action = 'view';
		$scope.eventos = [];
		$scope.cliente = ClienteResource.get({id:$stateParams.id});
		$scope.totalEventos = 0;

		$scope.cliente.$promise.then(function(data){
			$scope.eventos = $scope.cliente.eventos;
			$scope.totalEventos = $scope.eventos.length;
		}, function(error){
			console.log(error);
			return;
		});

		$scope.cancelEvento = function(evento){
			if ($rootScope.currentUser.rol != 'cliente' || $rootScope.currentUser.id != $scope.cliente.id) { $state.go('homepage'); }
			$scope.evento = EventoResource.delete({ id: evento.id });
			$scope.evento.$promise.then(function(data){
				alert("Evento cancelado");
				$scope.eventos.splice($scope.eventos.indexOf(evento),1);
			},function(error){
				alert(error);
				console.log(error);
				return;
			});
		}

		//Go to chat with proveedor
		$scope.gotoChat = function(provId,cliId){
			if ($rootScope.currentUser.rol != 'proveedor') { $state.go('homepage'); }

			var callback = ChatResource.find({action: 'find', id: provId, otherId: cliId});
			callback.$promise.then(function(data){
				$state.go('proveedorChat',{chatId: data.id});
			})
		}

		$scope.profileImage = function(){
			if ($rootScope.currentUser.rol != 'cliente' || $rootScope.currentUser.id != $scope.cliente.id) { $state.go('homepage'); }
			$http({
				headers: {
					'Content-Type': 'application/json'
				},
				url: 'cliente/profile',
				method: "PUT",
				data: {
					profileImage: $scope.image.dataURL,
					cliente_id: $rootScope.currentUser.id
				}
			}).then(function(){
				$state.reload();
			})
		}

	})
	.controller('ClienteConversationsCtrl', function($scope, $state, ChatResource, $rootScope) {
		if ($rootScope.currentUser.rol != 'cliente') { $state.go('homepage'); }
		$scope.action = 'cliente';
		$scope.chats = ChatResource.query({action: 'cliente', id: $rootScope.currentUser.id});

		$scope.viewChat = function(id){
			$state.go('clienteChat', {id:$rootScope.currentUser.id,chatId:id})
		}
	})
	.controller('ClienteChatCtrl', function($scope, ChatResource, $stateParams, $rootScope, $pusher, $state) {
		if ($rootScope.currentUser.rol != 'cliente') { $state.go('homepage'); }
		$scope.action = 'cliente';
		$scope.chat = ChatResource.get({id:$stateParams.chatId});
		$scope.chat.$promise.then(function(data){
			if ($rootScope.currentUser.id != data.cliente_id) { $state.go('homepage'); }
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
				senderName: $rootScope.currentUser.nombre + " " + $rootScope.currentUser.apellido, 
				message: $scope.newMessage,
				fileMessage: $scope.fileMessage
			});
			$scope.newMessage = "";
			$scope.fileMessage = "";
		}
	}); //end view cliente

	// .controller('LoginClienteCtrl', function($scope, $http, $state){
	// 	angular.extend($scope, {
	// 		loginCliente: function() {
	// 			$http({
	// 				headers: {
	// 					'Content-Type': 'application/json'
	// 				},
	// 				url: 'cliente/login',
	// 				method: "POST",
	// 				data: {
	// 					mail: $scope.Cliente.mail,
	// 					password: $scope.Cliente.password
	// 				}
	// 			}).success(function(response){
	// 				console.log(response);
	// 				$state.go('clientesProfile');
	// 			}).error(function(data, status, headers){
	// 				console.log(data, status, headers);
	// 				alert(data);
	// 			});
	// 		}
	// 	});
	// });
