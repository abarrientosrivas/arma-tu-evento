'use strict';

 angular.module('Client')
 	.factory('TipoPagoResource', function($resource) {
        return $resource("/api/tipoPago/:id",{ id: "@id" }, 
        {
		    update: { method: "PUT" }
		});	
	});