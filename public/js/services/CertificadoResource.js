'use strict';

angular.module('Client')
    .factory('CertificadoResource', function($resource){
        return $resource("/api/certificado/:id/:action/:rubroId", {
            id : "@id", rubroId: "@rubroId", action: "@action"
        }, {
            update: {
                method: "PUT"
            }
        });
    });