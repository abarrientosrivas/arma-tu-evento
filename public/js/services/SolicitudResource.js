'use strict';

 angular.module('Client')
 	.factory('SolicitudResource', function($resource) {
 		return $resource("/api/solicitud/:id/:provId/:boolean",{ id:"@id", provId:"@provId", boolean:"@boolean" }, {
			reply: {
				method: "PUT"
			}});
	});