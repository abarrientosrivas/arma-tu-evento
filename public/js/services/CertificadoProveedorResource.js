'use strict';

angular.module('Client')
    .factory('CertificadoProveedorResource', function($resource) {
        return $resource("/api/certificadoProveedor/:id", { id : "@id" }, 
        {
            update: { method: "PUT" }
        });
    });