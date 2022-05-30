'use strict';

angular.module('Client')
	.controller('HomepageCtrl', function($scope, $state, RubroResource) {

		$scope.search = {};
		$scope.search.fecha = new Date();
		// $scope.rubros = RubroResource.query({action: 'posts'});

		$scope.rubros = RubroResource.query({});

		$scope.gotoRubro = function(rubro) {
			$state.go('proveedoresRubro', {rubroName: rubro.nombre, rubroId: rubro.id})
		}

		$scope.searchPosts = function() {
			// var selectedRubros = '';
			// $scope.rubros.forEach(function(rubro){
			// 	if(rubro.isSelected){
			// 		if(selectedRubros!=''){selectedRubros += "-"};
			// 		selectedRubros += rubro.id;
			// 	}
			// });
			// if(selectedRubros == ''){ alert("No se han seleccionado rubros"); return; }
			$scope.dateMilis = $scope.search.fecha.getTime();
			if(!$scope.search.cantPersonas){$scope.search.cantPersonas=0};
			$state.go('searchResultados',{dateMillis:$scope.dateMilis, cantPers:$scope.search.cantPersonas});
		};
	});