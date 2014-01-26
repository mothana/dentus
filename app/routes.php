<?php

Route::get('/', function()
{
	return "Bism Allh , here is the dentos API";
});

Route::group(['prefix'=>'api/v1'],function()
{
	Route::controller('login','loginController');

	Route::group(['before'=>'auth.basic'],function()
	{
		Route::controller('admins','adminsController');
		Route::controller('customers','customersController');
		Route::controller('clinics','clinicsController');
		Route::controller('users','usersController');
		Route::controller('visits','visitsController');
	});
});