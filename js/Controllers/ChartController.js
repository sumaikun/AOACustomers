app.controller('ChartController',['$scope','ChartService','$window',function($scope,ChartService,$window){
	
	$scope.current_chart = {} ;

	$scope.title = 'Demo';


	$scope.change_areachart = function(){
		//console.log($("input[name=area_inicio]").val());
		$scope.current_chart.week = $("input[name=area_inicio]").val();
		var request = ChartService.area($scope.current_chart);
		request.then(function(response){
			verify_destroy_session(response.data);
			area_chart(response.data);
			//console.log(response);
		});
		/*request.then(function(response)
		{
			console.log("entrego response");
			area_chart(response.data);
			//console.log(response);
		},function(error){
			console.log('error in change_areachart');
			
		});	*/
	}

	$scope.first_load_areachart = function(current_week){
		var request = ChartService.area(current_week);		
		request.then(function(response){
			verify_destroy_session(response.data);
			area_chart(response.data);
		});
	}

	$scope.change_barchart = function(){
		//console.log($("input[name=area_inicio]").val());
		$scope.current_chart.month = $("input[name=sbar_month]").val();
		var request = ChartService.bar($scope.current_chart);
		request.then(function(response){
			verify_destroy_session(response.data);
			bar_chart(response.data);
		});
	
	}

	$scope.first_load_barchart = function(month){
		var request = ChartService.bar(month);		
		request.then(function(response){
			//console.log(response.data);
			verify_destroy_session(response.data);
			bar_chart(response.data);
		});
	} 

	$scope.change_piechart = function(){
		//console.log($("input[name=area_inicio]").val());
		$scope.current_chart.year = $("select[name=year_bar]").val();
		var request = ChartService.pie($scope.current_chart);
		request.then(function(response){
			verify_destroy_session(response.data);
			pie_chart(response.data);
		});
	
	}

	$scope.first_load_piechart = function(year){
		var request = ChartService.pie(year);		
		request.then(function(response){
			console.log(response.data);
			verify_destroy_session(response.data);
			pie_chart(response.data);
		});
	}

	function verify_destroy_session(str)
	{		
		if(typeof str !== 'object')
		{
			$window.location.reload();	
		}
		
	}        

}]);