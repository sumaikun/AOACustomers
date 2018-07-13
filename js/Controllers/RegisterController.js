app.controller('RegisterController',['$scope','$filter','SystemService','RegisterService','$window',function($scope,$filter,SystemService,RegisterService,$window){
	
	$scope.current_form = {};

	$scope.formdata = {};

	$scope.test = "t3st";

	$scope.SiniestrosForm = new js_form({table:"siniestro"},SystemService);

	(function() {
		  var tables_array = [$scope.SiniestrosForm];
		  var promises = [];
		  tables_array.forEach(function(table_array){
		  		promises = promises.concat(table_array.loaded); 
		  });
		  console.log(promises);		  
		  Promise.all(promises).then(values => {		  	  			  	   
			  $scope.generate_form();
		  });

	}());


	$scope.generate_form = function(){
		$scope.$apply(function () {
			$scope.current_form = $scope.SiniestrosForm;
			
			var request = RegisterService.get_asegs({});
			request.then(function(response){
				$scope.select_options = response.data.aseguradoras;
				$scope.select_options.value = "ASEGURADORA";
				var request2 = RegisterService.get_citys({});
				request2.then(function(response){
					$scope.citys = response.data.citys;

					var request3 = RegisterService.get_offices({});

					request3.then(function(response){
					$scope.offices = response.data.offices;

						$scope.current_form.fields = [
							{fieldname:"NUMERO",alias:"Numero del siniestro",required:"required"},
							{fieldname:"CIUDAD",alias:"Ciudad",input:{type:"select",data:"offices",required:"required"}},
							{fieldname:"PLACA",alias:"Placa",required:"required"},
							{fieldname:"ASEGURADO_NOMBRE",alias:"Nombre del asegurado",required:"required"},
							{fieldname:"ASEGURADO_ID",alias:"Identificación",required:"required"},
							{fieldname:"DECLARANTE_CELULAR",alias:"Celular del declarante",required:"required"},
							{fieldname:"CIUDAD_ORIGINAL",alias:"Ciudad de origen",input:{type:"datalist",data:"citys",filter_by:["nombre","departamento"],catch_value:"codigo"},required:"required"},
							{fieldname:"CIUDAD_SINIESTRO",alias:"Ciudad del siniestro",input:{type:"datalist",data:"citys",filter_by:["nombre","departamento"],catch_value:"codigo"},required:"required"},
							{fieldname:"DIAS_SERVICIO",alias:"Días de servicio",required:"required"},
						];

					});								
					
				});			
				
			});              
        });		
	}

	$scope.get_from_scope = function(name)
	{	
		console.log($scope[name]);
		return $scope[name];
	}

	$scope.search_col_on_fields = function(field)
	{	
		var filter_object = {};
		filter_object["Field"] = field.fieldname;
		//console.log(filter_object);
		//console.log($scope.current_form);
		var element = $filter('filter')($scope.current_form.columns,filter_object)[0];
		console.log(element);
		return element;
	}


	$scope.datalist_assign = function(selectedlist,input_filter)
	{

		var array = selectedlist.split(",");

		//console.log(selectedlist);
		
		var filter_object = {};

		var i = 0;

		//console.log(input_filter);

		input_filter.filter_by.forEach(function(element){
			filter_object[element] = array[0];
			i++;
		});

		
		//console.log(filter_object);

		var element = $filter('filter')($scope[input_filter.data],filter_object)[0];

		//console.log(element);

		return element[input_filter.catch_value];
		
	}


	$scope.register_data = function(formdata)
	{
		console.log(formdata);
		RegisterService.register_data({form:formdata,table:"siniestro"}).then(
			function(response)
			{
				console.log(response);
			}
		);
	}	

}]);