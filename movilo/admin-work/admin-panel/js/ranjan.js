

var app = angular.module('myApp', ['ui.bootstrap']);
	app.controller('customersCtrl', function($scope,$http) {	 
	   $scope.searchFun = function(){		
		$http({	
          method: "POST",		
		  url: 'customers_mysql.php',
		  data: $scope.filterObj
		}).then(function successCallback(response) {
			//console.log(response.data);
			$scope.names=response.data;
		  }, function errorCallback(response) { 
			
		  });  

	  }
      $scope.viewby = 10;
  $scope.totalItems = $scope.data.length;
  $scope.currentPage = 4;
  $scope.itemsPerPage = $scope.viewby;
  $scope.maxSize = 5; //Number of pager buttons to show

  $scope.setPage = function (pageNo) {
    $scope.currentPage = pageNo;
  };

  $scope.pageChanged = function() {
    console.log('Page changed to: ' + $scope.currentPage);
  };

$scope.setItemsPerPage = function(num) {
  $scope.itemsPerPage = num;
  $scope.currentPage = 1; //reset to first page
}	  
	  
	});
