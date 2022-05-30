'use strict'

angular.module('Client')
  .factory('DenunciaResource', function($resource) {
    return $resource("/api/denuncia/:id", {
      id: "@id"
    }, {
      update: {
        method: "PUT"
      }
    });
  });
