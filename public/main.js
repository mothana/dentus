var dentus = angular.module('dentus', ['angularFileUpload']);


/*	===================================	Routes ===================================	*/

dentus.config(function ($routeProvider){
	$routeProvider
		.when('/',
		{
			controller : 'cms',
			templateUrl : 'home.html'
		})
		.when('/faq', {
			controller : 'cms',
			templateUrl : 'faq.html'	
		})
		.when('/signup/success', {
			controller : 'success',
			templateUrl : 'thanks.html'	
		})
		.when('/ContactUs', {
			controller : 'cms',
			templateUrl : 'ContactUs.html'	
		})
		.when('/login', {
			controller : 'logIn',
			templateUrl : 'login.html'	
		})
		.when('/admin', {
			controller : 'admin',
			templateUrl : 'admin.html'	
		})
		.when('/admin/applications', {
			controller : 'adminApplications',
			templateUrl : 'adminApplications.html'	
		})
		.when('/admin/users', {
			controller : 'adminUsers',
			templateUrl : 'adminUsers.html'	
		})
		.when('/admin/user/create', {                        
			controller : 'adminCreateuser',
			templateUrl : 'adminCreateuser.html'	
		})	
		.when('/users', {								
			controller : 'users',
			templateUrl : 'users.html'	
		})
		.when('/customervisit', {                      //not ready 
			controller : 'customervisit',    
			templateUrl : 'customervisit.html'	
		})
		.when('/admin/clinics', {
			controller : 'adminClinics',
			templateUrl : 'adminClinics.html'	
		})
		.when('/admin/clinic/create', {
			controller : 'adminCreateclinic',
			templateUrl : 'adminCreateclinic.html'	
		})
		.when('/clinics', {								//not ready
			controller : 'clinics',
			templateUrl : 'clinics.html'	
		})
		.when('/users/signup', {                             //not ready
			controller : 'usersSignup',
			templateUrl : 'usersSignup.html'	
		})
		.otherwise( {redirectTo : '/'} );

})


/*	===================================	Directives ===================================	*/

dentus.directive('orbit', function(){
	var linker = function(scope,element,attr){
		element.orbit();
	};
	
	return {
		restrict:'A',
		link: linker
	}
});

/*	===================================	Factories ===================================	*/

dentus.factory('queryDB', function($http){
	var factory = {};

	factory.adminVisits = function () {

	}

	factory.adminApplications = function () {
		$http.get('api/v1/customers')
		.success(function (data,success) {
		})
		.error(function (data,success) {
		});
	}

	factory.adminClinics = function () {
		$http.get('api/v1/customers')
		.success(function (data,success) {
		})
		.error(function (data,success) {
		});
	}

	factory.adminCustomers = function () {
		$http.get('api/v1/customers')
		.success(function (data,success) {
		})
		.error(function (data,success) {
		});
	}

	return factory;
});

dentus.factory('revealBoxManager',function () {
	var factory = {};

	factory.daTitle =  'Record was deleted successfully...';
	factory.daTitle2 = 'Record was added successfully...';
	factory.daTitle3 = 'Error occured! ...';

	factory.message = '';
	factory.daLink = 'Home';


	factory.setDaTitle = function (daContent) {

	}
	
	factory.setMessage = function (daContent) {
	}	

	factory.setDaLink = function (daContent) {
	}

	return factory;
});



/*	===================================	Controllers ===================================	*/

dentus.controller('admin',function ($location,$http,$scope,queryDB) {
	$http.get('api/v1/login/check')
		.success(function (data,success) {
			$http.get('api/v1/clinics/visits')
				.success(function (data,success) {
					$scope.visits = data;
					})
				.error(function (data,success) {
				});
		})	
		.error(function (data,success) {
			$location.path('login');
		});		
});

dentus.controller('logIn',function ($http,$location,$scope,queryDB) {
	
	//if the user is already logged in then redirect him/her to the home page
	$http.get('api/v1/login/check')
	.success(function () {
		$scope.loggedIn = true;
		$scope.loginBox = false;
	})
	.error(function () {
		$scope.loginBox = true;
		$scope.loggedIn = false;
	});

	$scope.logout = function () {
		$http.get('api/v1/login/logout')
		.success(function  () {
			$scope.loggedIn = false;
			$scope.loginBox = true;
		}).
		error(function  () {
			
		})
	}

	//get the login credentials and try to log in
	$scope.login = function() {
		var logData = {'email':$scope.email,'password':$scope.password}

		$http.post('api/v1/login',logData)
		.success(function (data,success) {
			switch(data)
			{
				case '"admin"':
					$location.path('admin');
					break;
				case '"user"':
					$location.path('users');
					break;
				case '"clinic"': 
					$location.path('clinics');
					break;
			}

		})
		.error(function (data,success) {
			$scope.errorMsg = true;
		});
	}
});

var adminCreateclinic = [ '$http','$scope', '$upload','$location', 'revealBoxManager',function($http,$scope,$upload,$location,revealBoxManager) {

	$scope.create = function () {
		$http.post('api/v1/clinics/create',$scope.clinic)
		.success(function (data,success) {
			$location.path('admin/clinics')
		})
		.error(function (data,success) {
		    revealBoxManager.setDaTitle('error');
			revealBoxManager.setMessage('Error : Could not create new clinic');
			revealBoxManager.setDaLink('Home');
			$('#myModal').reveal();
		});
	}

	$scope.onFileSelect = function($files) {
    	//$files: an array of files selected, each file has name, size, and type.
	    for (var i = 0; i < $files.length; i++) {
	      var file = $files[i];
	      $scope.upload = $upload.upload({
	        url: 'api/v1/clinics/create', //upload.php script, node.js route, or servlet url
	        // method: POST or PUT,
	        // headers: {'headerKey': 'headerValue'}, withCredential: true,
	        data: {myObj: $scope.myModelObj},
	        file: file,
	        // file: $files, //upload multiple files, this feature only works in HTML5 FromData browsers
	        /* set file formData name for 'Content-Desposition' header. Default: 'file' */
	        //fileFormDataName: myFile, //OR for HTML5 multiple upload only a list: ['name1', 'name2', ...]
	        /* customize how data is added to formData. See #40#issuecomment-28612000 for example */
	        //formDataAppender: function(formData, key, val){} 
	      }).progress(function(evt) {
	        console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
	      }).success(function(data, status, headers, config) {
	      	console.log('ok');
	        // file is uploaded successfully
	        console.log('error');
	      });
	      //.error(...)
	      //.then(success, error, progress); 
	    }
	};
}];


var adminCreateuser = [ '$http','$scope', '$upload','$location', 'revealBoxManager',function($http,$scope,$upload,$location,revealBoxManager) {

	//Make the birthdate field a JQuery date picker file
	$(function() {
		$( "#birthdate" ).datepicker();
	});

	$scope.signUp = function () {
		$http.post('api/v1/customers/create',$scope.user)
		.success(function (data,success) {
			$location.path('admin/users');
		})
		.error(function (data,success) {
		    revealBoxManager.setDaTitle('error');
			revealBoxManager.setMessage('Could not sign you up!.Kindly , fill up all of the form fields and click the Sign Up.');
			revealBoxManager.setDaLink('Home');
			$('#myModal').reveal();
		});
	}

  $scope.onFileSelect = function($files) {
    //$files: an array of files selected, each file has name, size, and type.
    for (var i = 0; i < $files.length; i++) {
      var file = $files[i];
      $scope.upload = $upload.upload({
        url: 'api/v1/customers/create', //upload.php script, node.js route, or servlet url
        // method: POST or PUT,
        // headers: {'headerKey': 'headerValue'}, withCredential: true,
        data: {myObj: $scope.myModelObj},
        file: file,
        // file: $files, //upload multiple files, this feature only works in HTML5 FromData browsers
        /* set file formData name for 'Content-Desposition' header. Default: 'file' */
        //fileFormDataName: myFile, //OR for HTML5 multiple upload only a list: ['name1', 'name2', ...]
        /* customize how data is added to formData. See #40#issuecomment-28612000 for example */
        //formDataAppender: function(formData, key, val){} 
      }).progress(function(evt) {
        console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
      }).success(function(data, status, headers, config) {
        // file is uploaded successfully
        
      });
      //.error(...)
      //.then(success, error, progress); 
    }
  };
}];

dentus.controller('adminUsers',function (revealBoxManager,$location,$http,$scope,queryDB) {
	$http.get('api/v1/login/check')
	.success(function (data,success) {
		$http.get('api/v1/customers')
			.success(function (data,success) {
			$scope.users = data;
		})
		.error(function (data,success) {
	});

$scope.daLinkusers = function (info,index) {
			$http.get('api/v1/customers/delete/' + info)
				.success(function (data,success) {
				    $scope.users.splice(index, 1);
					revealBoxManager.setDaTitle('Operation is done ... ');
					revealBoxManager.setMessage('Next');
					$('#myModal').reveal();
				})

			.error(function (data,success) {
		 		revealBoxManager.setDaTitle('Error');
		 		revealBoxManager.setMessage('Operation Filed ...');
		 		revealBoxManager.setDaLink("false");
		 		$('#myModal').reveal();
		 	});	
	}	
		})
	.error(function (data,success) {
		$location.path('login');
	});
	
});

dentus.controller('adminClinics',function (revealBoxManager,$location,$http,$scope,queryDB) {
	$http.get('api/v1/login/check')
	.success(function (data,success) {
		$http.get('api/v1/clinics')
			.success(function (data,success) {
			$scope.clinics = data;
		})
		.error(function (data,success) {
	});

	$scope.daLinkclinic = function (info,index) {
			$http.get('api/v1/clinics/delete/' + info)
				.success(function (data,success) {
				    $scope.clinics.splice(index, 1);
					revealBoxManager.setDaTitle('Operation is done ... ');
					revealBoxManager.setMessage('Next');
					$('#myModal').reveal();
				})

			.error(function (data,success) {
		 		revealBoxManager.setDaTitle('Error');
		 		revealBoxManager.setMessage('Operation Filed ...');
		 		revealBoxManager.setDaLink("false");
		 		$('#myModal').reveal();
		 	});	
	}	

	})

	
	.error(function (data,success) {
		$location.path('login');
	});
	
});

dentus.controller('adminApplications',function (revealBoxManager,$location,$http,$scope,queryDB) {
	$http.get('api/v1/login/check')
	.success(function (data,success) {
	$http.get('api/v1/customers/applications')
		.success(function (data,success) {
			if(data.length == 0){
				$scope.showApplications = false;
				$scope.theMsg = 'No applications are available';
				$scope.errorMsg = true;
			} else {
				$scope.showApplications = true;
				$scope.users = data;
			}
		})
		.error(function (data,success) {
	});

	$scope.errorMsgClose = function () {
		$scope.errorMsg = false;
	}

	$scope.accept = function (info,index) {
		$http.get('api/v1/customers/accept/' + info);
		$scope.users.splice(index, 1);
		revealBoxManager.setDaTitle('CUSTOMER WAS ACCEPTED ... ');
		revealBoxManager.setMessage('3rd Error');
		revealBoxManager.setDaLink('Home');
		$('#myModal').reveal();
	}
	
	$scope.reject = function (info,index) {
$http.get('api/v1/customers/delete/' + info)
	.success(function (data,success) {
	    $scope.users.splice(index, 1);
	    revealBoxManager.setDaTitle('Operation is done ... ');
		revealBoxManager.setMessage('Next');
		revealBoxManager.setDaLink('Home');
		$('#myModal').reveal();
})
	.error(function (data,success) {
		revealBoxManager.setDaTitle('Error... ');
		revealBoxManager.setMessage('Next');
		revealBoxManager.setDaLink('Home');
		$('#myModal').reveal();	
});

	}
	})
	.error(function (data,success) {
		$location.path('login');
	});

});

dentus.controller('users',function ($http,$scope) {
	$http.get('api/v1/customers/profile/1')
		.success(function (data,success) {
			$scope.user = data;
		})
		.error(function (data,success) {
	});

	$http.get('api/v1/customers/clinics/1')
		.success(function (data,success) {
			$scope.clinics = data;
		})
		.error(function (data,success) {
	});
});

var usersSignup = [ '$http','$scope', '$upload','$location', 'revealBoxManager',function($http,$scope,$upload,$location,revealBoxManager) {

	//Make the birthdate field a JQuery date picker file
	$(function() {
		$( "#birthdate" ).datepicker();
	});

	$scope.signUp = function () {
		$http.post('api/v1/customers/create',$scope.user)
		.success(function (data,success) {
			$location.path('signup/success');
		})
		.error(function (data,success) {
		    revealBoxManager.setDaTitle('error');
			revealBoxManager.setMessage('Could not sign you up!.Kindly , fill up all of the form fields and click the Sign Up.');
			revealBoxManager.setDaLink('Home');
			$('#myModal').reveal();
		});
	}

  $scope.onFileSelect = function($files) {
    //$files: an array of files selected, each file has name, size, and type.
    for (var i = 0; i < $files.length; i++) {
      var file = $files[i];
      $scope.upload = $upload.upload({
        url: 'api/v1/customers/create', //upload.php script, node.js route, or servlet url
        // method: POST or PUT,
        // headers: {'headerKey': 'headerValue'}, withCredential: true,
        data: {myObj: $scope.myModelObj},
        file: file,
        // file: $files, //upload multiple files, this feature only works in HTML5 FromData browsers
        /* set file formData name for 'Content-Desposition' header. Default: 'file' */
        //fileFormDataName: myFile, //OR for HTML5 multiple upload only a list: ['name1', 'name2', ...]
        /* customize how data is added to formData. See #40#issuecomment-28612000 for example */
        //formDataAppender: function(formData, key, val){} 
      }).progress(function(evt) {
        console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
      }).success(function(data, status, headers, config) {
        // file is uploaded successfully
        
      });
      //.error(...)
      //.then(success, error, progress); 
    }
  };
}];


dentus.controller('clinics',function ($scope,$http,$location,queryDB) {
	$http.get('api/v1/login/check')
	.success(function (data,success) {
	$http.get('api/v1/clinics/profile')
	.success(function (data,success) {
		$scope.profile = data;
	})
		.error(function (data,success) {
	});

	$http.get('api/v1/clinics/customers')
	.success(function (data,success) {
		$scope.customers = data;
	})
	.error(function (data,success) {
	});

	$scope.register = function () {
		$scope.errorMsg = false;

		var visit = {
			customer_id : $scope.search.id,
			diagnosis : $scope.diagnosis,
			cost : $scope.cost
		};

		$http.post('api/v1/clinics/newvisit',visit)
		.success(function (data,success) {
			$scope.user.serial_number = '';
			$scope.message = false;
			$scope.errorMsg = false;
			$scope.theMsg = 'User visit has been registered successfully';
			$scope.errorMsg = true;
			$scope.customers.push({img_link : $scope.search.img_link, first_name : $scope.search.first_name, nationality : $scope.search.nationality, birthdate : $scope.search.birthdate, mobile_number : $scope.search.mobile_number, email : $scope.search.email});

			$scope.diagnosis = '';
			$scope.cost = '';
		})
		.error(function (data,success) {
			$scope.errorMsg = false;
			$scope.theMsg = 'falied to register new visit';
			$scope.errorMsg = true;
		});
	};

	$scope.cancel = function () {
		$scope.errorMsg = false;
		$scope.message = false;
		$scope.search = '';
		$scope.user.serial_number = '';
	};

	$scope.searchButton = function () {
		$scope.errorMsg = false;
		$scope.search = '';
		$scope.message = false;
		$http.post('api/v1/clinics/search',$scope.user)
		.success(function (data,success) {
			$scope.search = data;
			if(parseInt($scope.search.balance) <= 0){
				$scope.showCost = false;
				$scope.showDiagnosis = false;
				$scope.ShowCheckIn = false;
				$scope.showLowBalance = true;
			} else {
				$scope.showCost = true;
				$scope.showDiagnosis = true;
				$scope.ShowCheckIn = true;
				$scope.showLowBalance = false;
			}

			$scope.message = true;
		})
		.error(function (data,success) {
			$scope.errorMsg = false;
			$scope.theMsg = 'No user has been found';
			$scope.errorMsg = true;
		});		
	}

	$scope.errorMsgClose = function () {
		$scope.errorMsg = false;
	}
		})
		.error(function (data,success) {
		$location.path('login');
	});

});

dentus.controller('cms',function ($scope,queryDB) {

});

dentus.controller('success',function ($scope,$http,$location) {
	$http.get('api/v1/customers/checksignup')
	.success(function (data,success) {
		$http.get('api/v1/customers/forgetsignup');
	})
	.error(function (data,success) {
		$location.path('users/signup');
	});
});

dentus.controller('revealBox',function ($scope,revealBoxManager) {
	$scope.daTitle = revealBoxManager.daTitle;
	$scope.daTitle2 = revealBoxManager.daTitle2;
	$scope.daTitle3 = revealBoxManager.daTitle3;

	$scope.message = revealBoxManager.message;
	$scope.daLink = revealBoxManager.daLink;
});