app.factory('SystemService',['$http','$q',function($http,$q){
	
	var SystemService = {};
    var defered = $q.defer();
    var promise = defered.promise;

    
	SystemService.META_COLUMNS = function(data){

		return $http.post("index.php?controller=System&action=META_COLUMNS",data);		

	}
	
	return SystemService;	
	
}]);
