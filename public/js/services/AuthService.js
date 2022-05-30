'use strict';

angular.module('Client')
    .service('AuthService', ['$auth', '$state','$rootScope', 'SatellizerConfig', 
    function ($auth, $state, $rootScope, SatellizerConfig) {
    /*jshint validthis: true */
    this.login = function(user, loginUrl, nextState, navbarContent) {
        SatellizerConfig.loginUrl = loginUrl;

        var credentials = {
            email: user.email,
            password: user.password
        }

        // Use Satellizer's $auth service to login
        $auth.login(credentials).then(function(data) {                            
            // Stringify the returned data to prepare it
            // to go into local storage
            data.data.user.navbarContent = navbarContent;
            var user = JSON.stringify(data.data.user);
        
            // Set the stringified user data into local storage
            localStorage.setItem('user', user);
        
            // The user's authenticated state gets flipped to
            // true so we can now show parts of the UI that rely
            // on the user being logged in
            $rootScope.authenticated = true;
        
            // Putting the user's data on $rootScope allows
            // us to access it anywhere across the app
            $rootScope.currentUser = data.data.user;
        
            // Everything worked out so we can now redirect to
            // the users state to view the data

            // If login is successful, redirect to proveedor profile
            $state.go(nextState, {id: data.data.user.id});
            return;
        }, function(error){
            alert(error.data.error);
        })
    }

    // Cierra la sesión de token de Satellizer
    this.logout = function(){
        $auth.logout().then(function() {

            // Remove the authenticated user from local storage
            localStorage.removeItem('user');
    
            // Flip authenticated to false so that we no longer
            // show UI elements dependant on the user being logged in
            $rootScope.authenticated = false;
    
            // Remove the current user info from rootscope
            $rootScope.currentUser = null;

            // Set the basic navigation bar
            $rootScope.navbarContent = 'navbar.auth.html';

            // Redirects to homepage
            $state.go("homepage");
          });
    }
}]);
