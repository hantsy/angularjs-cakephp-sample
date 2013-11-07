(function() {
    var as = angular.module('myApp.controllers', []);
    as.controller('AppCtrl', function($scope, $rootScope, $http, i18n, $location) {
        $scope.language = function() {
            return i18n.language;
        };
        $scope.setLanguage = function(lang) {
            i18n.setLanguage(lang);
        };
        $scope.activeWhen = function(value) {
            return value ? 'active' : '';
        };

        $scope.path = function() {
            return $location.url();
        };

//        $scope.login = function() {
//            $scope.$emit('event:loginRequest', $scope.username, $scope.password);
//            //$location.path('/login');
//        };

        $scope.logout = function() {
            $rootScope.user = null;
            $scope.username = $scope.password = null;
            $scope.$emit('event:logoutRequest');
            $location.url('/');
        };

        $rootScope.appUrl = "http://localhost";

    });

    as.controller('PostListCtrl', function($scope, $rootScope, $http, $location) {
        var load = function() {
            console.log('call load()...');
            $http.get($rootScope.appUrl + '/posts.json')
                    .success(function(data, status, headers, config) {
                        $scope.posts = data.posts;
                        angular.copy($scope.posts, $scope.copy);
                    });
        }

        load();

        $scope.addPost = function() {
            console.log('call addPost');
            $location.path("/new-post");
        }

        $scope.editPost = function(index) {
            console.log('call editPost');
            $location.path('/edit-post/' + $scope.posts[index].Post.id);
        }

        $scope.delPost = function(index) {
            console.log('call delPost');
            var todel = $scope.posts[index];
            $http
                    .delete($rootScope.appUrl + '/posts/' + todel.Post.id + '.json')
                    .success(function(data, status, headers, config) {
                        load();
                    }).error(function(data, status, headers, config) {
            });
        }

    });

    as.controller('NewPostCtrl', function($scope, $rootScope, $http, $location) {

        $scope.post = {};

        $scope.savePost = function() {
            console.log('call savePost');
            var _data = {};
            _data.Post = $scope.post;
            $http
                    .post($rootScope.appUrl + '/posts.json', _data)
                    .success(function(data, status, headers, config) {
                        $location.path('/posts');
                    }).error(function(data, status, headers, config) {
            });
        }
    });

    as.controller('EditPostCtrl', function($scope, $rootScope, $http, $routeParams, $location) {

        var load = function() {
            console.log('call load()...');
            $http.get($rootScope.appUrl + '/posts/' + $routeParams['id'] + '.json')
                    .success(function(data, status, headers, config) {
                        $scope.post = data.post.Post;
                        angular.copy($scope.post, $scope.copy);
                    });
        }

        load();

        $scope.post = {};

        $scope.updatePost = function() {
            console.log('call updatePost');

            var _data = {};
            _data.Post = $scope.post;
            $http
                    .put($rootScope.appUrl + '/posts/' + $scope.post.id + '.json', _data)
                    .success(function(data, status, headers, config) {
                        $location.path('/posts');
                    }).error(function(data, status, headers, config) {
            });
        }
    });


    as.controller('RegisterCtrl', function($scope, $rootScope, $http, $location) {

        $scope.user = {};

        $scope.register = function() {
            console.log('call register');
            var _data = {};
            _data.User = $scope.user;
            $http
                    .post($rootScope.appUrl + '/users/add.json', _data)
                    .success(function(data, status, headers, config) {
                        $location.path('/login');
                    })
                    .error(function(data, status, headers, config) {
                    });
        }
    });

    as.controller('LoginCtrl', function($scope, $rootScope, $http, $location) {
        $scope.login = function() {
            $scope.$emit('event:loginRequest', $scope.username, $scope.password);
            //$location.path('/login');
        };
    });

}());