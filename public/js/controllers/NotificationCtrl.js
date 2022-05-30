'use strict';

angular.module('Client')
	.controller('NotificationCtrl', function($scope, $pusher, $state, $rootScope, NotificacionResource) {
		$scope.notifications = [];
		$scope.newNotifications = 0;

		var callback = NotificacionResource.query({action: $rootScope.currentUser.rol, id: $rootScope.currentUser.id});

		callback.$promise.then(function(data){
			$scope.notifications = data;
			$scope.notifications.forEach(element => {if(!element.read){ $scope.newNotifications++; } });
		})

		var client = new Pusher("e20f13ba1c1961c8f5e7",{
			cluster: "us2",
		});
		var pusher = $pusher(client);
		var channel = pusher.subscribe('notificacion');
		channel.bind("App\\Events\\NotificacionSent",function(data){
			if ($rootScope.currentUser.rol == 'cliente' && data.notificacion.cliente_id == $rootScope.currentUser.id) {
				$scope.notifications.splice(0,0,data.notificacion);
				$scope.newNotifications++;
			}
			if ($rootScope.currentUser.rol == 'proveedor' && data.notificacion.proveedor_id == $rootScope.currentUser.id) {
				$scope.notifications.splice(0,0,data.notificacion);
				$scope.newNotifications++;
			}
		});

		$scope.clickNotif = function(notif){
			if(!notif.read){
				var callback = NotificacionResource.read({id: notif.id});
				callback.$promise.then(function(data){
					$scope.notifications.splice($scope.notifications.indexOf(notif),1,data);
					$scope.newNotifications--;
				})
			}
		}

		$scope.testNotif = function(){
			NotificacionResource.save({cliente_id: 1, title: 'test', body: 'test body for notification'});
		}

	});