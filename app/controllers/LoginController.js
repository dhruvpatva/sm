'use strict';

angular.module('SoundMobApp')
.controller('LoginCtrl', [ '$scope','$rootScope' ,'$state', '$modalInstance' , '$window', 'Auth', '$http','Session', 'AUTH_EVENTS',
function($scope, $rootScope, $state, $modalInstance, $window, Auth, $http, Session, AUTH_EVENTS ) {
	$scope.credentials = {};
	$scope.loginForm = {};
	$scope.error = false;
	
	//when the form is submitted
	$scope.submit = function(data) {
		$scope.submitted = true;
		if (!$scope.loginForm.$invalid) {
			$scope.login($scope.credentials); 
		} else {
			$scope.error = true;
			return;
		}
	};

	//Performs the login function, by sending a request to the server with the Auth service
	$scope.login = function(credentials) {
		$scope.error = false;
                $http({
                        url: 'api/module/users/login',
                        method: "POST",
                        data: {'user': credentials}
                })
                .then(function(response) {
                        // success
                        var loginData = response.data.data;
                        
                        if (response.data.success == 1) {
                             $window.sessionStorage["userInfo"] = JSON.stringify(loginData);
                             Session.create(loginData);
                             $rootScope.currentUser = loginData;
                             $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
                             $modalInstance.close();
                             $state.go('dashboard');
                        } else {
                             $rootScope.$broadcast(AUTH_EVENTS.loginFailed);
                             console.log("error");
                             $scope.error = true;
                        }
                },
                function(response) { // optional

                });
	};
        
       /* $http.get('api/module/users/session.php?task=getUser').success(function(response){   alert(response.data);
            if (response.data){ alert('bhkbjk');
                //$.each( response.data, function( key, value ) {
                    //alert( key + ": " + value );
                //});
                var credentials = JSON.parse(response.data);
                 $scope.login(credentials); 
                //$rootScope.currentUser = response.data;  //alert(angular.toJson(response.data));
                //loggedIn = true; //alert('bhk');
            }else{
                //loggedIn = false; 
                //alert('bhkk');
            }
            //console.log($rootScope.currentUser.user_id);

         });
	*/
	// if a session exists for current user (page was refreshed)
	// log him in again
	if ($window.sessionStorage["userInfo"]) { 
               var credentials = JSON.parse($window.sessionStorage["userInfo"]);
               //alert(credentials);
               //console.log(credentials);
               $scope.login(credentials);
	}
        /*$http.get('api/module/users/session.php?task=getUser').success(function(response){   //alert('bh'); alert(response); console.log(JSON.stringify(response.data));
        if (response.data){ alert('bhkbjk'); console.log(JSON.stringify(response.data));
            //$.each( response.data, function( key, value ) {
                //alert( key + ": " + value );
            //});
            var credentials = JSON.stringify(response.data);
           $scope.login(credentials); 
            //$rootScope.currentUser = response.data;  //alert(angular.toJson(response.data));
            //loggedIn = true; //alert('bhk');
        }else{
            //loggedIn = false; 
            alert('bhkk');
        }
        //console.log($rootScope.currentUser.user_id);

     });*/
} ]);
