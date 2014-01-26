<?php

/**
* users controller
*/
class usersController extends BaseController
{
	protected function _Save($user)
	{
		if(!is_object($user)) return false;

		$Rules = array(
				'first_name' => 'required',
				'last_name' => 'required', 
				'email' => 'email|required', 
				'password' => 'required', 
				'role' => 'required',
				'user_id' => 'required'
			);

		$Validator = Validator::make(Input::all(),$Rules);

		if($Validator->fails()) return false;

		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));
		$user->role = Input::get('role');
		$user->user_id = Input::get('user_id');
		$user->save();

		return true;
	}

	public function getIndex()
	{
		return Response::json(usersModel::all(),200);
	}

	public function getProfile($id = 0)
	{
		return Response::json(usersModel::find($id),200);
	}

	public function postCreate()
	{
		$user = new usersModel;
		if(!$this->_Save($user)) return Response::json('Error : failed to create new user',400);
		return Response::json('New user has been added successfuly',200);
	}

	public function postUpdate()
	{
		$user = usersModel::find(Input::get('id'));
		if(!$this->_Save($user)) return Response::json('Error : failed to update user',400);
		return Response::json('New user has been updated successfuly',200);	
	}

	public function getDelete($id = 0)
	{
		$user = usersModel::find($id);
		$user->delete();
		return Response::json('User has been deleted successfuly',200);
	}
}