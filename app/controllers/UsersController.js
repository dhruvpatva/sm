'use strict';
//angular.module('SoundMobApp', ['ngFileUpload']);
SoundMobApp.filter('startFrom', function() {
     return function(input, start) {
          if (input) {
               start = +start; //parse to int
               return input.slice(start);
          }
          return [];
     }
});

SoundMobApp.controller('UsersController', function($rootScope,$scope, $http, $timeout, $location, $state, $stateParams, Upload) {
     $scope.$on('$viewContentLoaded', function() {
          // initialize core components
          Metronic.initAjax();
     });
    /* $scope.getRecords = function() {
          $http.get('api/module/users/getAll').success(function(data) {
               $scope.list = data.data;
               $scope.currentPage = 1; //current page
               $scope.entryLimit = 10; //max no of items to display in a page
               $scope.filteredItems = $scope.list.length; //Initially for no filter  
               $scope.totalItems = $scope.list.length;
          });
          $scope.setPage = function(pageNo) {
               $scope.currentPage = pageNo;
          };
          $scope.filter = function() {
               $timeout(function() {
                    $scope.filteredItems = $scope.filtered.length;
               }, 10);
          };
          $scope.sort_by = function(predicate) {
               $scope.predicate = predicate;
               $scope.reverse = !$scope.reverse;
          };
     }*/
     
    $scope.list = [];
    $scope.libraryTemp = {};
    $scope.totalItemsTemp = {};
    $scope.CurrentPage = 1;
    
    $scope.totalItems = 0;
    $scope.pageChanged = function(newPage) {
        $scope.CurrentPage = newPage;
        getRecords(newPage);
    };
    
    getRecords(1);
    function getRecords(pageNumber) { 
        if (!$.isEmptyObject($scope.libraryTemp)) {
            $http({
                url: 'api/module/users/getAll',
                method: "POST",
                params: {search: $scope.search, page: pageNumber}
            }).success(function(data) {
                $scope.list = data.data;
                $scope.totalItems = data.total;
            });
        } else {
            $http({
                url: 'api/module/users/getAll',
                method: "POST",
                params: {page: pageNumber}
            }).success(function(data) {
                $scope.list = data.data;
                $scope.totalItems = data.total;
            });
        }
    }

    $scope.searchDB = function(){
        if($scope.search.length >= 3){
            if($.isEmptyObject($scope.libraryTemp)){
                $scope.libraryTemp = $scope.list;
                $scope.totalItemsTemp = $scope.totalItems;
                $scope.list = {};
            }
            getRecords(1);
        }else{
            if(! $.isEmptyObject($scope.libraryTemp)){
                $scope.list = $scope.libraryTemp ;
                $scope.totalItems = $scope.totalItemsTemp;
                $scope.libraryTemp = {};
            }
        }
    }
     
     
     
     
     $scope.InitSPEUser = function() {
          $scope.timezones = {
               availableOptions: $rootScope.timezoneoptions
          };
          $http.get('api/module/spe/getAllSpe').success(function(spedata) {
               $scope.allspe = {
                    availableOptions: spedata.data
               };
          });
          $scope.speuser = {
               gender:'male',
               status:'1',
          };
          $("#dob").datepicker();
          $scope.$broadcast('dataloaded');
     };
     
      $scope.Add_SpeAdmin = function() {
          var id = $stateParams.id;
          var form_data = new FormData();
          
          form_data.append('speid', $scope.allspe.SelectedOption.id);
          for ( var key in $scope.speuser ) {
               form_data.append(key, $scope.speuser[key]);
          }
          form_data.append('speadmin', '1');
          $http({
               url: 'api/module/users/AddUser/',
               method: "POST",
               transformRequest: angular.identity,
               headers: {'Content-Type': undefined,'Process-Data': false},
               data: form_data
          }).success(function(resdata) {
               if (resdata.success == 1) {
                    $scope.success = true;
                    $(".show-success").text('');
                    $(".show-success").text(resdata.error_code);
                    $scope.activePath = $location.path('/users');
               } else {
                    $scope.error_code = resdata.error_code;
                    $scope.error = true;
                    return;
               }
          });
     };
     $scope.InitUser = function() {
          /*$scope.timezones = {
               availableOptions: $rootScope.timezoneoptions
          };
          $http.get('api/module/specialities/getAll').success(function(spedata) {
               $scope.specialities = {
                    availableOptions: spedata.data
               };
          });*/
          $scope.user = {
               gender:'male',
               status:'1',
          };
          $("#dob").datepicker();
          $scope.$broadcast('dataloaded');
     };
     
     $scope.Add_User = function() {
          var id = $stateParams.id;
          var form_data = new FormData();
          var e=0;
          /*angular.forEach($scope.educations, function(value, key) {
                form_data.append("educations["+e+"][coursename]", value.coursename);
                form_data.append("educations["+e+"][universityname]",value.universityname);
                form_data.append("educations["+e+"][startyear]",value.startyear);
                form_data.append("educations["+e+"][endyear]",value.endyear);
                e++;
          });
          */
          //$scope.spi.timezone = $scope.spi.timezone.id;
          for ( var key in $scope.user ) {
               form_data.append(key, $scope.user[key]);
          }
          form_data.append('adduser', '1');
          /*angular.forEach($scope.spi.specialities, function(value, key) {
                form_data.append("specialities[]",value.id);
          });*/
         
          $http({
               url: 'api/module/users/AddUser/',
               method: "POST",
               transformRequest: angular.identity,
               headers: {'Content-Type': undefined,'Process-Data': false},
               data: form_data
          }).success(function(resdata) {
               if (resdata.success == 1) {
                    $scope.success = true;
                    $(".show-success").text('');
                    $(".show-success").text(resdata.error_code);
                    $scope.activePath = $location.path('/users');
               } else {
                    $scope.error_code = resdata.error_code;
                    $scope.error = true;
                    return;
               }
          });
     };

     $scope.editUser = function() {
          $scope.error = false;
          $("#dob").datepicker();
          var id = $stateParams.id;
          $http({
               url: 'api/module/users/getUserdetail/',
               method: "POST",
               params: {userid: id}
          }).success(function(data) {
               $scope.user = data.data;
               
               /*$scope.timezones = {
                    availableOptions: $rootScope.timezoneoptions,
                    selectedOption: {id: data.data.timezone}
               };
               $http.get('api/module/common/getactivelevel').success(function(leveldata) {
                    $scope.activelevel = {
                         availableOptions: leveldata.data,
                         selectedOption: {id: data.data.active_level}
                    };
               });*/
               $scope.$broadcast('dataloaded');
          });
     };
     
     $scope.$on('dataloaded', function() {
          $timeout(function() {
               Metronic.initAjax();
               /*$('#timezone').select2({
                    placeholder: "Select a Timezone",
                    allowClear: true
               });
               $('#allspe').select2({
                    placeholder: "Select a SPE",
                    allowClear: true
               });
               $('#specialities').select2({
                    placeholder: "Select a Specialities",
                    allowClear: true
               });
               
               $scope.educations = [{id: 'education1'}];
               $scope.addNewEducation = function() {
                 var newItemNo = $scope.educations.length+1;
                 $scope.educations.push({'id':'education'+newItemNo});
               };
                $scope.removeEducation = function() {
                 var lastItem = $scope.educations.length-1;
                 $scope.educations.splice(lastItem);
               }; */
          }, 0, false);
     })

     
     $scope.Update_User = function() {
          var id = $stateParams.id;
          //$scope.user.active_level = $scope.activelevel.selectedOption.id;
          //$scope.user.timezone = $scope.timezones.selectedOption.id;
          $http({
               url: 'api/module/users/editUser/',
               method: "POST",
               params: $scope.user
          }).success(function(resdata) {
               if(resdata.success == 1){
                   $scope.success = true; 
                   $(".show-success").text('');
                   $(".show-success").text(resdata.error_code);
                   $scope.activePath = $location.path('/users'); 
               } else {
                    $scope.error_code=resdata.error_code;
                    $scope.error = true;
                    return;
               }
          });
     };
     
     $scope.onFileSelect = function(file) {
          var id = $stateParams.id;
          $(".profile_error").text(''); 
          if (!file){ $(".profile_error").text('* File Type Invalid'); return};
          Upload.upload({
              url: 'api/module/users/setProfileImage',
              data: {profile_image: file, userid: id}
          }).then(function(resp) {
              $scope.editUser();
          });    
     };
     
     $scope.Delete_User = function(user) {
          var deleteUser = confirm('Are You Absolutely Sure You Want To Delete?');
          if (deleteUser) {
                $http({
                    url: 'api/module/users/deleteUser',
                    method: "POST",
                    params: {userid: user.id}
                }).success(function(resp) {
                    getRecords($scope.CurrentPage);
                });
          }        
      };
});