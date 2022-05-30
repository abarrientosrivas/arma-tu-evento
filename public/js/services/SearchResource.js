'use strict';

 angular.module('Client')
 	.factory('SearchResource', function($resource) {
 		return $resource("/api/search/:provId/:dateMillis/:cantPersonas/:rubrosStr",{ 
			 provId: "@provId",
			 dateMillis: "@fecha",
			 cantPersonas: "@cantPersonas",
			 rubrosStr: "@rubrosStr"
			}, {
				array: {
					method: 'GET',
					isArray: true
				}
		 });	
	});