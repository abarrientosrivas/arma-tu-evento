'use strict'

angular.module('Client')
  .factory('ResenaResource', function($resource) {
    return $resource("/api/resena/:id/:action", {
      id: "@id", action: "@action"
    }, {
      update: {
        method: "PUT"
      }
    });
  });
