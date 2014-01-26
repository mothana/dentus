<?php

/**
* admins class
*/
class adminsModel extends Eloquent
{
	protected $table = 'admins';

	public function saveItem($admin = false)
	{
		if(!is_object($admin)) return false;
	
		$Rules = array(
				'first_name'=>'required',
				'last_name'=>'required',
				'email'=>'required',
				'password'=>'required'
			);

		$Validator = Validator::make(Input::all(),$Rules);

		if($Validator->fails()) return false;

		$admin->first_name = Input::get('first_name');
		$admin->last_name = Input::get('last_name');
		$admin->email = Input::get('email');
		$admin->password = Hash::make(Input::get('password'));
		$admin->save();
		return true;
	}
}