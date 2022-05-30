	'use strcit'

angular.module('Client')
	.controller('SolicitudesCtrl', function($scope, $state, $rootScope, NotificacionResource, SolicitudResource) {
		if ($rootScope.currentUser.rol != 'proveedor') { $state.go('homepage'); }

		$scope.solicitudes = SolicitudResource.query({provId: $rootScope.currentUser.id});

		$scope.viewPost = function(postId){
			$state.go('postsView', {postId: postId})
		}
		
		$scope.viewCliente = function(id){
			$state.go('clientesProfile', {id: id})
		}

		$scope.replySolicitud = function(solicitud, boolean){
			var callback = SolicitudResource.reply({id: solicitud.id, boolean: boolean});
			callback.$promise.then(function(data){
				console.log(data);
				if(data.aceptada){ 
					NotificacionResource.save({cliente_id: data.evento.cliente_id, title: 'Solicitud aceptada', body: 'Tu solicitud ha sido aceptada', reference: 'clientesProfile({id:'+ data.evento.cliente_id +'})'});
					alert('Se ha aceptado la solicitud correctamente.'); 
				}
				if(data.rechazada){ 
					NotificacionResource.save({cliente_id: data.evento.cliente_id, title: 'Solicitud rechazada', body: 'Tu solicitud ha sido rechazada', reference: 'clientesProfile({id:'+ data.evento.cliente_id +'})'});
					alert('Se ha rechazado la solicitud correctamente.'); 
				}
			})
		}
	});
