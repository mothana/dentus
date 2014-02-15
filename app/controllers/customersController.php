<?php

/**
* customers controller
*/
class customersController extends BaseController
{
	public function getIndex()
	{
		return customersModel::where('active','=','true')->get();
	}

	public function getProfile($id = 0)
	{
		if($id == 0 && Auth::user()->role != 'admin')
		{
			$user_id = UsersModel::find(Auth::user()->id);
			return Response::json(customersModel::find($user_id->user_id),200);
		}
		return Response::json(customersModel::find($id),200);
	}

	public function getApplications()
	{
		return customersModel::where('active','=','false')->get();
	}

	public function getAccept($id=0)
	{
		$serial_number = date('y').date('m').date('d');

		$customer = customersModel::find($id);
		$customer->active = "true";
		$customer->serial_number = $serial_number.$customer->id;
		$customer->save();

		$user = new User;
		$user->first_name = $customer->first_name;
		$user->last_name = $customer->last_name;
		$user->email = $customer->email;
		$user->password = $customer->password;
		$user->role = 'user';
		$user->user_id = $customer->id;
		$user->save();
	}

	public function postVisits()
	{
		return Response::json(customersModel::find(Input::get('id'))->visits()->get(),200);
	}

	public function getClinics($id)
	{
		return Response::json(customersModel::find($id)->clinics()->get(),200);
	}

	public function postCreate()
	{
		if (Input::hasFile('file'))
		{
			$prefix = date('y').date('m').date('d');
			Session::put('fileName',$prefix.Input::file('file')->getFileName());
			Input::file('file')->move('uploads',Session::get('fileName'));
			return Response::json('true',200);	
		}

		$customer = new customersModel;

		if($customer->saveItem($customer))
		{
			if(Auth::user()->role == 'admin')
			{
				$user = new User;
				$user->first_name = $customer->first_name;
				$user->last_name = $customer->last_name;
				$user->email = $customer->email;
				$user->password = $customer->password;
				$user->role = 'user';
				$user->user_id = $customer->id;
				$user->save();
				return Response::json('New customer has been added successfully',200);
			}
			else
			{
				Session::put('signed','true');
				return Response::json('New customer has been added successfully',200);
			}
		}

		return Response::json('Error : validation has failed',400);
	}

	//check if the user  has signed up .... this is used to tell the frontEnd that the user has signed up
	//so show the "success" page which means the user has signed up successfully
	public function getChecksignup()
	{
		return $status = (Session::get('signed') == 'true') ? Response::json('true',200) : Response::json('false',400);
	}

	//used to tell the front end that this user is no longer able to view the "success" page
	public function getForgetsignup()
	{
		Session::forget('signed');
		return Response::json('true',200);
	}

	public function postUpdate($id = 0)
	{
		$customer = customersModel::find($id);
		if(!$customer->saveItem($customer)) Response::json('Error : validation has failed',400);
		return Response::json('New customer has been updated successfully',200);
	}

	public function getDelete($id = 0)
	{
		$customer = customersModel::find($id);
		$customer->delete();
		return Response::json('Customer has been deleted successfully',200);
	}
}