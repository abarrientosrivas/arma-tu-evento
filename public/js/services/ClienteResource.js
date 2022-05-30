'use strict';

angular.module('Client')
	.factory('ClienteResource', function($resource) {
		return $resource("/api/cliente/:id", {
			id: "@id"
		}, {
			update: {
				method: "PUT"
			}
		});
	});