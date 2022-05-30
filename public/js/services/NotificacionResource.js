'use strict';

angular.module('Client')
    .factory('NotificacionResource', function($resource){
        return $resource("/api/notificacion/:action/:id", {
            id : "@id", action: "@action"
        }, { 
            read: { method: "PUT" }
        });
    });