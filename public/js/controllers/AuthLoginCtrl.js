'use strict';

angular.module('Client')
       .controller('AuthLoginCtrl', function($auth, AuthService, $state, $scope) {
            /*jshint validthis: true */
            $scope.userType = 'proveedor';

            $scope.login = function() {

                var credentials = {
                    email: $scope.email,
                    password: $scope.password
                }
    
                // Use Satellizer's $auth service to login
                $auth.login(credentials).then(function(data) {
    
                    // If login is successful, redirect to the users state
                    //$state.go('users', {});

                    // If login is successful, redirect to proveedor profile
                    $state.go('proveedoresProfile', {id: data.proveedor.id});
                }, function(error){
                });
            }

            $scope.logout = function(){
                AuthService.logout();
            }
       });