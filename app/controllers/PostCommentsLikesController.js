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

SoundMobApp.controller('PostCommentsLikesController', function($scope, $http, $timeout, $location, $state, $stateParams, Upload) {
     $scope.$on('$viewContentLoaded', function() {
          // initialize core components
          Metronic.initAjax();
     });
     /*$scope.getRecords = function() {
          $http.get('api/module/posts/getAll').success(function(data) {
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
                url: 'api/module/postcommentslikes/getAll',
                method: "POST",
                params: {search: $scope.search, page: pageNumber,id: id}
            }).success(function(data) {
                $scope.list = data.data;
                if($scope.list.length > 0){
                    $scope.title = $scope.list[0].title;
                    $scope.comment = $scope.list[0].comment;
                }
                $scope.totalItems = data.total;
            });
        } else {
            $http({
                url: 'api/module/postcommentslikes/getAll',
                method: "POST",
                params: {page: pageNumber,id: id}
            }).success(function(data) {
                $scope.list = data.data;
                if($scope.list.length > 0){
                    $scope.title = $scope.list[0].title;
                    $scope.comment = $scope.list[0].comment;
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

     $scope.edit_PostCommentLike = function() {
          $scope.error = false;
          var id = $stateParams.id;
          $http({
               url: 'api/module/postcommentslikes/getPostCommentsLikes/',
               method: "POST",
               params: {id: id}
          }).success(function(data) {
               $scope.postcommentslikes = data.data;
               $http.get('api/module/common/getparentpost').success(function(parentpostdata) { 
                    $scope.post_title = {
                        availableOptions: parentpostdata.data,
                        selectedOption: {id:data.data.post_id}
                    };
                    $scope.$broadcast('dataloaded');
                });
          });
          $(document).click(function(e){
                //var clickElement = e.target;  // get the dom element clicked.
                var elementClassName = e.target.className;  // get the classname of the element clicked  
                if(elementClassName.indexOf("tree-dropdown") != -1 || elementClassName.indexOf("select") != -1 || elementClassName.indexOf("ng-binding") != -1){ 
                    $('.tree-dropdown').addClass("tree-dropdown-box");
                    $('.tree-dropdown .list').addClass("tree-dropdown-list");
                }else{
                    $('.tree-dropdown').removeClass("tree-dropdown-box");
                    $('.tree-dropdown .list').removeClass("tree-dropdown-list");
                }
            });
    };
     $scope.$on('dataloaded', function() {
          $timeout(function() {
               Metronic.initAjax();
          }, 0, false);
     });

     
     $scope.Update_PostCommentLike = function() {
          var id = $stateParams.id;
          /*var form_data = new FormData();
          if(typeof $scope.parentpost.selectedOption != 'undefined'){
                $scope.posts.parentpost = $scope.parentpost.selectedOption.id;
          }
          if (typeof $scope.posttypes.selectedOption != 'undefined' && typeof $scope.sources.selectedOption != 'undefined'){
                $scope.posts.posttype = $scope.posttypes.selectedOption.id;
                $scope.posts.sources = $scope.sources.selectedOption.id;
          }
          for ( var key in $scope.posts ) {
               form_data.append(key, $scope.posts[key]);
          }*/
          $http({
               url: 'api/module/postcommentslikes/editPostCommentLike/',
               method: "POST",
               params: $scope.postcommentslikes
          }).success(function(resdata) {
               if(resdata.success == 1){
                   $scope.success = true; 
                   $(".show-success").text('');
                   $(".show-success").text(resdata.error_code);
                   $scope.activePath = $location.path('/posts/postcommentslikes/' + $scope.postcommentslikes.id); 
               } else {
                    $scope.error_code=resdata.error_code;
                    $scope.error = true;
                    return;
               }
          });
     };
     
     $scope.Add_Posts = function() { 
          var form_data = new FormData();
          if(typeof $scope.parentpost.selectedOption != 'undefined'){
                $scope.posts.parentpost = $scope.parentpost.selectedOption;
          }
          if (typeof $scope.posttypes.selectedOption != 'undefined' && typeof $scope.sources.selectedOption != 'undefined'){
                $scope.posts.posttype = $scope.posttypes.selectedOption.id;
                $scope.posts.sources = $scope.sources.selectedOption.id;
          }
          for ( var key in $scope.posts ) {
               form_data.append(key, $scope.posts[key]);
          }
          $http({
               url: 'api/module/postcommentslikes/addPosts/',
               method: "POST",
               transformRequest: angular.identity,
               headers: {'Content-Type': undefined,'Process-Data': false},
               data: form_data
          }).success(function(resdata) {
               if(resdata.success == 1){
                   $scope.success = true; 
                   $(".show-success").text('');
                   $(".show-success").text(resdata.error_code);
                   $scope.activePath = $location.path('/posts'); 
               } else {
                    $scope.error_code=resdata.error_code;
                    $scope.error = true;
                    return;
               }
          });
     };
     
     $scope.$on('dataloaded', function() {
          $timeout(function() {
               Metronic.initAjax();
               /*$('#posttype').select2({
                    placeholder: "Select Post Type",
                    allowClear: true
               });
               $('#sources').select2({
                    placeholder: "Select Source",
                    allowClear: true
               });
               $('#parentpost').select2({
                    placeholder: "Select Parent Post",
                    allowClear: true
               });*/
          }, 0, false);
     });
     
     $scope.onFileSelect = function(file,filetype) {
          var id = $stateParams.id;
          $scope.posts.allValid = 0;
          if (filetype == 'image') {
                $(".image_error").text('');
                if (!file){ $(".image_error").text('* File Type Invalid'); $scope.posts.allValid = 1; return};
          } else if (filetype == 'video') {
                $(".video_error").text('');
                if (!file){ $(".video_error").text('* File Type Invalid'); $scope.posts.allValid = 1; return};
          } else if (filetype == 'audio') {
                $(".audio_error").text('');
                if (!file){ $(".audio_error").text('* File Type Invalid'); $scope.posts.allValid = 1; return};
          }
     };
     
     $scope.Add_init = function() {
         /*$http.get('api/module/common/getposttype').success(function(posttypedata) {
               $scope.posttypes = {
                    availableOptions: posttypedata.data,
               };
               $scope.$broadcast('dataloaded');
          });
          $http.get('api/module/common/getsources').success(function(sourcesdata) { //console.log(sourcesdata);
               $scope.sources = {
                    availableOptions: sourcesdata.data,
               };
               $scope.$broadcast('dataloaded');
          });*/
          $http.get('api/module/common/getparentpost').success(function(parentpostdata) { 
               $scope.parentpost = {
                    availableOptions: parentpostdata.data,
               };
               $scope.$broadcast('dataloaded');
          });
          $http.get('api/module/common/getparentpostcomment').success(function(parentpostcommentdata) { 
               $scope.parentpostcomment = {
                    availableOptions: parentpostcommentdata.data,
               };
               $scope.$broadcast('dataloaded');
          });
          $scope.postcomments = {
               status:'1'
          };
     };
     
     $scope.Delete_PostCommentLikes = function(data) {
          var deletePlaylists = confirm('Are You Absolutely Sure You Want To Delete?');
          if (deletePlaylists) {
                $http({
                    url: 'api/module/postcommentslikes/deletePostCommentLike',
                    method: "POST",
                    params: {id: data.id}
                }).success(function(resp) {
                    getRecords($scope.CurrentPage);
                });
          }        
      };
});