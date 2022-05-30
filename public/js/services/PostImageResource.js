'use strict';

 angular.module('Client')
 	.factory('PostImageResource', function($resource) {
 		return $resource("/api/postImage/:id/",{ id: "@id" }, {
		 });	
	});