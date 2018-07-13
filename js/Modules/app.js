//var app = angular.module("Appi",['ngRoute','chieffancypants.loadingBar', 'ngAnimate']);
var app = angular.module("Appi",[]);

/*app.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = true;
  });
app.config(function ($routeProvider) { 
  console.log($routeProvider);
  $routeProvider
  .when('/index.php?controller=Index&action=home',{      
      templateUrl: 'js/Views/Chart.html' 
    });  
	});*/

function js_form(data,Resource)
{
  this.Resource = Resource;
  this.data = data;
  this.loaded = [];
  this.init();  	
}

js_form.prototype.init = function()
{
  var self = this;
  var promise = new Promise( (resolve, reject) => {
    var request = self.Resource.META_COLUMNS(self.data);
    request.then(function(response){
      self.columns = response.data.columns;
      resolve("¡Done!");
    });
  });
  self.loaded.push(promise);  
}
