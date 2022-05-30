'use strict';

 angular.module('Client')
 	.factory('PostResource', function($resource) {
 		return $resource("/api/post/:id/:action",{ id: "@id", action: "@action" }, {
			 update: {
				method: "PUT"
			 }
		 });	
	});