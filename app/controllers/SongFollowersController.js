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

SoundMobApp.controller('SongFollowersController', function($scope, $http, $timeout, $location, $state, $stateParams, Upload) {
     $scope.$on('$viewContentLoaded', function() {
          // initialize core components
          Metronic.initAjax();
     });
     /*$scope.getRecords = function() {
          $http.get('api/module/playlists/getAll').success(function(data) {
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
                url: 'api/module/song-followers/getAll',
                method: "POST",
                params: {search: $scope.search, page: pageNumber,id: id}
            }).success(function(data) {
                $scope.list = data.data;
                if($scope.list.length > 0){
                    $scope.title = $scope.list[0].song_info;
                }
                $scope.totalItems = data.total;
            });
        } else {
            $http({
                url: 'api/module/song-followers/getAll',
                method: "POST",
                params: {page: pageNumber,id: id}
            }).success(function(data) {
                $scope.list = data.data;
                if($scope.list.length > 0){
                    $scope.title = $scope.list[0].song_info;
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

     $scope.edit_SongFollowers = function() {
          $scope.error = false;
          var id = $stateParams.id;
          $http({
               url: 'api/module/song-followers/getSongFollowers/',
               method: "POST",
               params: {id: id}
          }).success(function(data) {
               $scope.songfollowers = data.data;
               $http.get('api/module/common/getplaylists').success(function(playlistsdata) {
                    $scope.playlists = {
                         availableOptions: playlistsdata.data,
                         selectedOption: { id:data.data.playlist_id }
                    };
                    $scope.$broadcast('dataloaded');
               });
               $scope.$broadcast('dataloaded');
          });
     };
     $scope.$on('dataloaded', function() {
          $timeout(function() {
               Metronic.initAjax();
               $('#playlist').select2({
                    placeholder: "Select a Playlists",
                    allowClear: true
               });
          }, 0, false);
     });

     
     $scope.Update_SongFollowers = function() {
          var id = $stateParams.id;
          //$scope.playlistsfollowers.playlists = $scope.playlists.selectedOption.id;
          $http({
               url: 'api/module/song-followers/editSongFollowers/',
               method: "POST",
               params: $scope.songfollowers
          }).success(function(resdata) {
               if(resdata.success == 1){
                   $scope.success = true; 
                   $(".show-success").text('');
                   $(".show-success").text(resdata.error_code);
                   $scope.activePath = $location.path('/playlists/song-follower/' + $scope.songfollowers.song_id); 
               } else {
                    $scope.error_code=resdata.error_code;
                    $scope.error = true;
                    return;
               }
          });
     };
     
     $scope.Add_init = function() {
         $http.get('api/module/common/getplaylists').success(function(playlistsdata) {
               $scope.playlists = {
                    availableOptions: playlistsdata.data,
               };
               $scope.$broadcast('dataloaded');
          });
          
          $scope.playlistsfollowers = {
               status:'1'
          };
     };
     
     $scope.Add_PlaylistsFollowers = function() { 
           if (typeof $scope.playlists.selectedOption != 'undefined'){
                $scope.playlistsfollowers.playlists = $scope.playlists.selectedOption.id;
          }
          $http({
               url: 'api/module/song-followers/addPlaylistsFollowers/',
               method: "POST",
               params: $scope.playlistsfollowers
          }).success(function(resdata) {
               if(resdata.success == 1){
                   $scope.success = true; 
                   $(".show-success").text('');
                   $(".show-success").text(resdata.error_code);
                   $scope.activePath = $location.path('/playlists/playlists-follower'); 
               } else {
                    $scope.error_code=resdata.error_code;
                    $scope.error = true;
                    return;
               }
          });
     };
     
     
     $scope.Delete_SongFollowers = function(data) {
          var deletePlaylists = confirm('Are You Absolutely Sure You Want To Delete?');
          if (deletePlaylists) {
                $http({
                    url: 'api/module/song-followers/deleteSongFollowers',
                    method: "POST",
                    params: {id: data.id}
                }).success(function(resp) {
                    getRecords($scope.CurrentPage);
                });
          }        
      };
});