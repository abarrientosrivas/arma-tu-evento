'use strict';

 angular.module('Client')
 	.factory('RubroResource', function($resource) {
 		return $resource("/api/rubro/:id/:action",{ id:"@id", action:"@action" }, {
		 });
	
		//  function formDataObject(data) {
		// 	 if (data == undefined) {
		// 		return data;
		// 	 }

		// 	 var fd = new FormData();
		// 	 fd.append('File', data.file);
			
		// 	 fd.append('DocumentType', data.documentType)
		// 	 // Use JSON.stringify to format an array
		// 	 fd.append('DocumentName', JSON.stringify(data.documentName));
		// 	 fd.append('DocumentDesc', data.documentDesc)
 
		// 	 return fd;
		//  }
	
	});