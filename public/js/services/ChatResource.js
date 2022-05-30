'use strict';

angular.module('Client')
	.factory('ChatResource', function($resource) {
		return $resource("conversations/:action/:id/:otherId", {
			id: "@id",
			otherId: "@otherId",
			action: "@action"
		}, { find: { method: "GET", isArray: false}});
	});