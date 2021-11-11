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

SoundMobApp.controller('PostsLikesController', function($scope, $http, $timeout, $location, $state, $stateParams, Upload) {
     $scope.$on('$viewContentLoaded', function() {
          // initialize core components
          Metronic.initAjax();
     });
     /*$scope.getRecords = function() {
          $http.get('api/module/posttype/getAll').success(function(data) {
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
        var id = $stateParams.id;
        if (!$.isEmptyObject($scope.libraryTemp)) {
            $http({
                url: 'api/module/postslikes/getAll',
                method: "POST",
                params: {search: $scope.search, page: pageNumber,id: id}
            }).success(function(data) {
                $scope.list = data.data;
                if($scope.list.length > 0){
                    $scope.title = $scope.list[0].title;
                }
                $scope.totalItems = data.total;
            });
        } else {
            $http({
                url: 'api/module/postslikes/getAll',
                method: "POST",
                params: {page: pageNumber,id: id}
            }).success(function(data) {
                $scope.list = data.data;
                if($scope.list.length > 0){
                    $scope.title = $scope.list[0].title;
                }
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
     
     
    $scope.edit_PostsLikes = function() {
          $scope.error = false;
          var id = $stateParams.id;
          $http({
               url: 'api/module/postslikes/getPostsLikesdetail/',
               method: "POST",
               params: {id: id}
          }).success(function(data) {
               $scope.postslikes = data.data;
               $scope.$broadcast('dataloaded');
          });
     };
     $scope.$on('dataloaded', function() {
          $timeout(function() {
               Metronic.initAjax();
          }, 0, false);
     })

     
     $scope.Update_PostLike = function() {
          var id = $stateParams.id;
          $http({
               url: 'api/module/postslikes/editPostLike/',
               method: "POST",
               params: $scope.postslikes
          }).success(function(resdata) {
               if(resdata.success == 1){
                   $scope.success = true; 
                   $(".show-success").text('');
                   $(".show-success").text(resdata.error_code);
                   $scope.activePath = $location.path('/posts/postslikes/' + $scope.postslikes.post_id); 
               } else {
                    $scope.error_code=resdata.error_code;
                    $scope.error = true;
                    return;
               }
          });
     };
     
     $scope.Add_PostType = function() {
          $http({
               url: 'api/module/postslikes/add_PostType/',
               method: "POST",
               params: $scope.posttype
          }).success(function(resdata) {
               if(resdata.success == 1){
                   $scope.success = true; 
                   $(".show-success").text('');
                   $(".show-success").text(resdata.error_code);
                   $scope.activePath = $location.path('/posttype'); 
               } else {
                    $scope.error_code=resdata.error_code;
                    $scope.error = true;
                    return;
               }
          });
     };
     
     
     $scope.Delete_PostsLikes = function(data) {
          var deleteActivityLevel = confirm('Are You Absolutely Sure You Want To Delete?');
          if (deleteActivityLevel) {
                $http({
                    url: 'api/module/postslikes/deletePostsLikes',
                    method: "POST",
                    params: {id: data.id}
                }).success(function(resp) {
                    getRecords($scope.CurrentPage);
                });
          }        
      };
});