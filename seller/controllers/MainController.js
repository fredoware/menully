// controllers/MainController.js
angular.module('myApp')
    .controller('MainController', ['$scope', function($scope) {
        $scope.sideBarView = 'fragments/sideBar.html';
        $scope.pageSpinner = false;
        $scope.menuButton = true;


        // Side Nav ============================================================== 
        $scope.openNav = function() {
            $scope.menuButton = false;
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("sideBackdrop").style.width = "100vw";
        }

        $scope.closeNav = function() {
            $scope.menuButton = true;
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("sideBackdrop").style.width = "0";
        }

        // Bottom Sheet ============================================================== 
        $scope.openBottomSheet = function() {
            document.getElementById("bottomSheet").style.bottom = "0";
            document.getElementById("bottomBackdrop").style.width = "100vw";
        }

        $scope.closeBottomSheet = function() {
            document.getElementById("bottomSheet").style.bottom = "-100%";
            document.getElementById("bottomBackdrop").style.width = "0";
        }


        // Back drop ============================================================== 

        $scope.closeBackdrop = function() {
            $scope.closeNav();
            $scope.closeBottomSheet();
        }


        // Decove string with special characters 
        $scope.decodeHtml = function(html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        };


    }]);