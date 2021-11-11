'use strict';

angular.module('SoundMobApp')
        .factory('Auth', ['$http', '$rootScope', '$window', 'Session', 'AUTH_EVENTS', '$timeout', '$state',
     function($http, $rootScope, $window, Session, AUTH_EVENTS, $timeout, $state) {
          var authService = {};
          if($window.sessionStorage["userInfo"] != null){
                 var data = JSON.parse($window.sessionStorage["userInfo"]);
                 Session.create(data);       
          }
          //check if the user is authenticated
          authService.isAuthenticated = function() {
               return !!Session.user;
          };

          //check if the user is authorized to access the next route
          //this function can be also used on element level
          //e.g. <p ng-if="isAuthorized(authorizedRoles)">show this only to admins</p>
          authService.isAuthorized = function(authorizedRoles) {
               if (!angular.isArray(authorizedRoles)) {
                    authorizedRoles = [authorizedRoles];

               }
               return (authService.isAuthenticated() && authorizedRoles.indexOf(Session.userRole) !== -1);
          };

          //log out the user and broadcast the logoutSuccess event
          authService.logout = function() {
               Session.destroy();
               $window.sessionStorage.removeItem("userInfo");
			   $http({
                        url: 'api/module/common/logout',
                        method: "POST",
               });
               $rootScope.$broadcast(AUTH_EVENTS.logoutSuccess);
			   $rootScope.islogin = false;
               $state.go('dashboard');
               window.location.reload();
          }

          return authService;
     }]);