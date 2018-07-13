app.factory('RegisterService',['$http','$q',function($http,$q){
	
	var RegisterService = {};
    var defered = $q.defer();
    var promise = defered.promise;

    
	RegisterService.get_asegs = function(data){

		return $http.post("index.php?controller=Register&action=get_asegs",data);		

	}

	RegisterService.get_citys = function(data){

		return $http.post("index.php?controller=Register&action=get_citys",data);		

	}

	RegisterService.get_offices = function(data){

		return $http.post("index.php?controller=Register&action=get_offices",data);		

	}

	RegisterService.register_data = function(data){

		return $http.post("index.php?controller=Register&action=register_data",data);		

	}

	return RegisterService;	
	
}]);
