/* Setup Rounting For All Pages */
SoundMobApp.config(['$stateProvider', '$urlRouterProvider','$httpProvider', 'USER_ROLES', function($stateProvider, $urlRouterProvider, $httpProvider , USER_ROLES) {
    
    // Redirect any unmatched url
    $urlRouterProvider.otherwise("/");

    $stateProvider
        // Dashboard
        .state('dashboard', {
            url: "/",
            templateUrl: "views/dashboard.html",            
            data: {pageTitle: 'Dashboard', pageSubTitle: 'statistics & reports',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "DashboardController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            './assets/global/plugins/morris/morris.css',
                            './assets/admin/pages/css/tasks.css',
                            
                            './assets/global/plugins/morris/morris.min.js',
                            './assets/global/plugins/morris/raphael-min.js',
                            './assets/global/plugins/jquery.sparkline.min.js',

                            './assets/admin/pages/scripts/index3.js',
                            './assets/admin/pages/scripts/tasks.js',

                             'app/controllers/DashboardController.js'
                        ] 
                    });
                }]
            }
        })
        
        // User Listing
        .state('users', {
            url: "/users",
            templateUrl: "views/users/index.html",            
            data: {pageTitle: 'Users', pageSubTitle: 'All Users',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "UsersController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/UsersController.js'
                        ] 
                    });
                }]
            }
        })
        
         // User Add
        .state('addspeadmin', {
            url: "/users/addspeadmin",
            templateUrl: "views/users/addspeadmin.html",            
            data: {pageTitle: 'Users', pageSubTitle: 'Add SPE Admin',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "UsersController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/UsersController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                             './assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                             './assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
                        ] 
                    });
                }]
            }
        })
        
        .state('adduser', {
            url: "/users/adduser",
            templateUrl: "views/users/adduser.html",            
            data: {pageTitle: 'Users', pageSubTitle: 'Add User',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "UsersController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/UsersController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                             './assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                             './assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
                             './assets/global/plugins/ckeditor/ckeditor.js',
                        ] 
                    });
                }]
            }
        })
        
        
        // User Edit
        .state('useredit', {
            url: "/users/edit/:id",
            templateUrl: "views/users/edit.html",            
            data: {pageTitle: 'Users', pageSubTitle: 'All users',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "UsersController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/UsersController.js',
                             './assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                             './assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
                        ] 
                    });
                }]
            }
        })
        
        // PostType
        .state('posttype', {
            url: "/posttype",
            templateUrl: "views/posttype/index.html",            
            data: {pageTitle: 'Post Type', pageSubTitle: 'All Post Type',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostTypeController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostTypeController.js'
                        ] 
                    });
                }]
            }
        })
        
        // PostType Add
        .state('posttypeadd', {
            url: "/posttype/add",
            templateUrl: "views/posttype/add.html",            
            data: {pageTitle: 'Post Type', pageSubTitle: 'Add Post Type',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostTypeController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostTypeController.js'
                        ] 
                    });
                }]
            }
        })
        
        // PostType Edit
        .state('posttypeedit', {
            url: "/posttype/edit/:id",
            templateUrl: "views/posttype/edit.html",            
            data: {pageTitle: 'Post type', pageSubTitle: 'Edit Post Type',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostTypeController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostTypeController.js'
                        ] 
                    });
                }]
            }
        })
        
        // All Sources
        .state('sources', {
            url: "/sources",
            templateUrl: "views/sources/index.html",            
            data: {pageTitle: 'Sources', pageSubTitle: 'All Sources',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "SourcesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/SourcesController.js'
                        ] 
                    });
                }]
            }
        })
        
        // Sources Add
        .state('sourcesadd', {
            url: "/sources/add",
            templateUrl: "views/sources/add.html",            
            data: {pageTitle: 'Sources', pageSubTitle: 'Add Source',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "SourcesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/SourcesController.js'
                        ] 
                    });
                }]
            }
        })
        
        // Sources Edit
        .state('Sourceedit', {
            url: "/sources/edit/:id",
            templateUrl: "views/sources/edit.html",            
            data: {pageTitle: 'Sources', pageSubTitle: 'Edit Source',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "SourcesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/SourcesController.js'
                        ] 
                    });
                }]
            }
        })
        
        // All Playlists
        .state('playlists', {
            url: "/playlists",
            templateUrl: "views/playlists/index.html",            
            data: {pageTitle: 'Playlists', pageSubTitle: 'All Playlists',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PlaylistsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PlaylistsController.js'
                        ] 
                    });
                }]
            }
        })
        
        // Playlists Add
        .state('playlistsadd', {
            url: "/playlists/add",
            templateUrl: "views/playlists/add.html",            
            data: {pageTitle: 'Playlists', pageSubTitle: 'Add Playlists',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PlaylistsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PlaylistsController.js'
                        ] 
                    });
                }]
            }
        })
        
        // Playlists Edit
        .state('playlistsedit', {
            url: "/playlists/edit/:id",
            templateUrl: "views/playlists/edit.html",            
            data: {pageTitle: 'Playlists', pageSubTitle: 'Edit Playlists',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PlaylistsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PlaylistsController.js'
                        ] 
                    });
                }]
            }
        })
        
        //All Playlists Followers
        .state('playlists-follower', {
            url: "/playlists/playlists-follower/:id",
            templateUrl: "views/playlists-followers/index.html",            
            data: {pageTitle: 'Playlists Followers', pageSubTitle: 'All Playlists Followers',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PlaylistsFollowersController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PlaylistsFollowersController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        // Playlists Followers Add
        .state('playlists-followeradd', {
            url: "/playlists/playlists-follower/add",
            templateUrl: "views/playlists-followers/add.html",            
            data: {pageTitle: 'Playlists Followers', pageSubTitle: 'Add Playlists Followers',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PlaylistsFollowersController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PlaylistsFollowersController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        
        // Playlists Followers Edit
        .state('playlists-followeredit', {
            url: "/playlists/playlists-follower/edit/:id",
            templateUrl: "views/playlists-followers/edit.html",            
            data: {pageTitle: 'Playlists Followers', pageSubTitle: 'Edit Playlists Followers',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PlaylistsFollowersController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PlaylistsFollowersController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        //All Song Followers
        .state('song-follower', {
            url: "/playlists/song-follower/:id",
            templateUrl: "views/song-followers/index.html",            
            data: {pageTitle: 'Song Followers', pageSubTitle: 'All Song Followers',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "SongFollowersController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/SongFollowersController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        // Song Followers Add
        .state('song-followeradd', {
            url: "/playlists/song-follower/add",
            templateUrl: "views/song-followers/add.html",            
            data: {pageTitle: 'Song Followers', pageSubTitle: 'Add Song Followers',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "SongFollowersController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/SongFollowersController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        
        // Song Followers Edit
        .state('song-followeredit', {
            url: "/playlists/song-follower/edit/:id",
            templateUrl: "views/song-followers/edit.html",            
            data: {pageTitle: 'Song Followers', pageSubTitle: 'Edit Song Followers',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "SongFollowersController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/SongFollowersController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        //All Users Follow
        .state('user-follow', {
            url: "/users/user-follow/:id",
            templateUrl: "views/user-follow/index.html",            
            data: {pageTitle: 'User Follow', pageSubTitle: 'All User Follow',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "UserFollowController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/UserFollowController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        // Users Follow Add
        /*.state('song-followeradd', {
            url: "/song-follower/add",
            templateUrl: "views/song-followers/add.html",            
            data: {pageTitle: 'Song Followers', pageSubTitle: 'Add Song Followers',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "SongFollowersController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/SongFollowersController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })*/
        
        
        // Users Follow Edit
        .state('user-followedit', {
            url: "/users/user-follow/edit/:id",
            templateUrl: "views/user-follow/edit.html",            
            data: {pageTitle: 'User Follow', pageSubTitle: 'Edit User Follow',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "UserFollowController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/UserFollowController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
               
        //All Users Libraries
        .state('user-libraries', {
            url: "/users/user-libraries/:id",
            templateUrl: "views/user-libraries/index.html",            
            data: {pageTitle: 'User Libraries', pageSubTitle: 'All User Libraries',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "UserLibrariesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/UserLibrariesController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        // Users Libraries Add
        .state('user-librariesadd', {
            url: "/users/user-libraries/add",
            templateUrl: "views/user-libraries/add.html",            
            data: {pageTitle: 'User Libraries', pageSubTitle: 'Add User Libraries',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "UserLibrariesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/UserLibrariesController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        
        // Users Libraries Edit
        .state('user-librariesedit', {
            url: "/users/user-libraries/edit/:id",
            templateUrl: "views/user-libraries/edit.html",            
            data: {pageTitle: 'User Libraries', pageSubTitle: 'Edit User Libraries',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "UserLibrariesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/UserLibrariesController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
         // All Playlist Songs
        .state('playlist-songs', {
            url: "/playlists/playlist-songs/:id",
            templateUrl: "views/playlist-songs/index.html",            
            data: {pageTitle: 'Playlist Songs', pageSubTitle: 'All Playlist Songs',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PlaylistSongsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PlaylistSongsController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                        ] 
                    });
                }]
            }
        })
        
        // Playlist Songs Add
        .state('playlist-songsadd', {
            url: "/playlists/playlist-songs/add",
            templateUrl: "views/playlist-songs/add.html",            
            data: {pageTitle: 'Playlist Songs', pageSubTitle: 'Add Playlist Songs',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PlaylistSongsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PlaylistSongsController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                        ] 
                    });
                }]
            }
        })
        
        // Playlist Songs Edit
        .state('playlist-songsedit', {
            url: "/playlists/playlist-songs/edit/:id",
            templateUrl: "views/playlist-songs/edit.html",            
            data: {pageTitle: 'Playlist Songs', pageSubTitle: 'Edit Playlist Songs',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PlaylistSongsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PlaylistSongsController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        // All Posts
        .state('posts', {
            url: "/posts",
            templateUrl: "views/posts/index.html",            
            data: {pageTitle: 'Posts', pageSubTitle: 'All Posts',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostsController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                        ] 
                    });
                }]
            }
        })
        
        // Posts Add
        .state('postsadd', {
            url: "/posts/add",
            templateUrl: "views/posts/add.html",            
            data: {pageTitle: 'Posts', pageSubTitle: 'Add Post',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostsController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                             './assets/global/plugins/tree-dropdown/tree-dropdown.css'
                        ] 
                    });
                }]
            }
        })
        
        // Postss Edit
        .state('postsedit', {
            url: "/posts/edit/:id",
            templateUrl: "views/posts/edit.html",            
            data: {pageTitle: 'Posts', pageSubTitle: 'Edit Post',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostsController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                             './assets/global/plugins/tree-dropdown/tree-dropdown.css'
                        ] 
                    });
                }]
            }
        })
        
        
        // All Posts Likes
        .state('postslikes', {
            url: "/posts/postslikes/:id",
            templateUrl: "views/postslikes/index.html",            
            data: {pageTitle: 'Posts Likes', pageSubTitle: 'All Posts Likes',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostsLikesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostsLikesController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                        ] 
                    });
                }]
            }
        })
        
        // Posts Likes Add 
        .state('postslikesadd', {
            url: "/posts/postslikes/add",
            templateUrl: "views/postslikes/add.html",            
            data: {pageTitle: 'Posts Likes', pageSubTitle: 'Add Post Likes',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostsLikesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostsController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        // Posts Likes Edit
        .state('postslikesedit', {
            url: "/posts/postslikes/edit/:id",
            templateUrl: "views/postslikes/edit.html",            
            data: {pageTitle: 'Posts Likes', pageSubTitle: 'View Post Like',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostsLikesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostsLikesController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js'
                        ] 
                    });
                }]
            }
        })
        
        // All Post Comments
        .state('postcomments', {
            url: "/posts/postcomments/:id",
            templateUrl: "views/postcomments/index.html",            
            data: {pageTitle: 'Posts Comments ', pageSubTitle: 'All Post Comments',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostCommentsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostCommentsController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                        ] 
                    });
                }]
            }
        })
        
        // Post Comments Add
        .state('postcommentsadd', {
            url: "/posts/postcomments/add",
            templateUrl: "views/postcomments/add.html",            
            data: {pageTitle: 'Posts Comments', pageSubTitle: 'Add Post Comment',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostCommentsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostCommentsController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                             './assets/global/plugins/tree-dropdown/tree-dropdown.css'
                        ] 
                    });
                }]
            }
        })
        
        // Post Comments Edit
        .state('postcommentsedit', {
            url: "/posts/postcomments/edit/:id",
            templateUrl: "views/postcomments/edit.html",            
            data: {pageTitle: 'Posts Comments', pageSubTitle: 'Edit Post Comment',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostCommentsController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostCommentsController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                             './assets/global/plugins/tree-dropdown/tree-dropdown.css'
                        ] 
                    });
                }]
            }
        })
        
        // All Post Comments Likes
        .state('postcommentslikes', {
            url: "/posts/postcommentslikes/:id",
            templateUrl: "views/postcommentslikes/index.html",            
            data: {pageTitle: 'Posts Comments Likes', pageSubTitle: 'All Post Comments Likes',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostCommentsLikesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostCommentsLikesController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                        ] 
                    });
                }]
            }
        })
        
        // Post Comments Likes Add
        .state('postcommentslikesadd', {
            url: "/posts/postcommentslikes/add",
            templateUrl: "views/postcommentslikes/add.html",            
            data: {pageTitle: 'Posts Comments Likes', pageSubTitle: 'Add Post Comment Like',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostCommentsLikesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostCommentsLikesController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                             './assets/global/plugins/tree-dropdown/tree-dropdown.css'
                        ] 
                    });
                }]
            }
        })
        
        // Post Comments Likes Edit
        .state('postcommentslikesedit', {
            url: "/posts/postcommentslikes/edit/:id",
            templateUrl: "views/postcommentslikes/edit.html",            
            data: {pageTitle: 'Posts Comments Likes', pageSubTitle: 'Edit Post Comment Like',authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor, USER_ROLES.guest]},
            controller: "PostCommentsLikesController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'SoundMobApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                             'app/controllers/PostCommentsLikesController.js',
                             './assets/global/plugins/select2/select2.css',
                             './assets/global/plugins/select2/select2.min.js',
                             './assets/global/plugins/tree-dropdown/tree-dropdown.css'
                        ] 
                    });
                }]
            }
        })
}]);
