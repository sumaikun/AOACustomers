app.factory('ChartService',['$http','$q',function($http,$q){
	
	var ChartService = {};
    var defered = $q.defer();
    var promise = defered.promise;

    ChartService.area = function(week){

		return $http.post("index.php?controller=Chart&action=areachart",week);		

	}

	ChartService.bar = function(week){

		return $http.post("index.php?controller=Chart&action=barchart",week);		

	}

	ChartService.pie = function(week){

		return $http.post("index.php?controller=Chart&action=piechart",week);		

	}
	
	
	return ChartService;	
	
}]);
