(function() {
'use strict';


/**
 * Main Controller
 */
angular.module('app').controller('mainController', Controller);


	function Controller($scope) {
	
		$scope.loginForm = {};
		$scope.loginForm.user = '';
		$scope.loginForm.pwd = '';
		
		$scope.pwd1			= "";
		$scope.pwd2			= "";
		$scope.err_pwds		= false;
    	$scope.loginForm.submitTheForm = function(item, event) {
			console.log("--> Submitting form"+$scope.loginForm.email.$valid);
		};
		$scope.loginForm.requestRecovery = function(item, event) {
			console.log("--> Submitting form"+$scope.loginForm.email.$valid);
		};
		$scope.setNewPassword = function() {
			if($scope.pwd1 !="" && $scope.pwd2!=""){
				if($scope.pwd1 != $scope.pwd2){
							
					$scope.err_pwds		= true;
				}else{
					$scope.err_pwds		= false;
					$('#recoveryForm').submit();
				}
			}
		};
		
	}

})();