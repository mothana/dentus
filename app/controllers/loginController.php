<?php

/**
* loginController
*/
class loginController extends BaseController
{
	public function postIndex()
	{

		Auth::logout();

		$Rules = array(
				'email'=>'email|required',
				'password'=>'required'
			);

		$email = Input::get('email');
		$password = Input::get('password');

		$check = array('email'=>$email,'password'=>$password);

		$Validator = Validator::make($check,$Rules);

		if($Validator->fails()) return Response::json('Error : Failed to validate',400);

		if(!Auth::attempt($check)) return Response::json('Error : password-email comination is not correct',404);

		return Response::json(Auth::user()->role,200);
	}

	public function getLogout()
	{
		Auth::logout();
		Session::flush();
		return Response::json('ok',200);
	}

	public function getCheck()
	{
		return $status = Auth::check() ? Response::json('true',200) : Response::json('false',400);	
	}

	public function getRole()
	{
		return Auth::user()->role;
	}
}