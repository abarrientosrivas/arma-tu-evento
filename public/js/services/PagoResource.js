'use strict';

 angular.module('Client')
 	.factory('PagoResource', function($resource) {
        return $resource("/api/pago/:id",{ id: "@id" }, 
        {
		    update: { method: "PUT" }
		});	
	});