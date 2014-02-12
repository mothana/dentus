<?php

/**
* clinics controller
*/
class clinicsController extends BaseController
{
	public function getIndex()
	{
		return clinicsModel::all();
	}

	public function getProfile()
	{
		$clinic_id = (Auth::user()->role == "clinic") ? Auth::user()->user_id : Input::get('id');
		return clinicsModel::find($clinic_id);
	}

	public function postSearch()
	{
		$Rule = array('serial_number'=>'required');
		$Validator = Validator::make(Input::all(),$Rule);
		if($Validator->fails()) return Response::json('Error : failed to validate',400);
		$result = CustomersModel::where('serial_number','=',Input::get('serial_number'))->where('active','=','true')->first();

		if($result) return Response::json($result,200);
		
		return Response::json('Error : user has not been found',404); 
	}

	public function getCustomers()
	{
		$clinic_id = (Auth::user()->role == "clinic") ? Auth::user()->user_id : Input::get('id');
		return Response::json(clinicsModel::find($clinic_id)->customers(),200);
	}

	public function getVisits()
	{
		return Response::json(clinicsModel::visits(),200);
	}

	public function postCreate()
	{

		if (Input::hasFile('file'))
		{
			$prefix = date('y').date('m').date('d');

			if(Session::get('clinicLogo'))
			{
				Session::put('clinicPic',$prefix.Input::file('file')->getFileName());
				Input::file('file')->move('uploads',Session::get('clinicPic'));			
			}
			else
			{
				Session::put('clinicLogo',$prefix.Input::file('file')->getFileName());
				Input::file('file')->move('uploads',Session::get('clinicLogo'));	
			}

			return Response::json('true',200);
		}

		$clinic = new clinicsModel;
		$result = $clinic->saveItem($clinic);
		if(!$result) return Response::json('Error : could not add new clinic',400);

		$user = new UsersModel;
		$user->first_name = 'null';
		$user->last_name = 'null';
		$user->email = $result->email;
		$user->password = Hash::make(Input::get('password'));
		$user->role = 'clinic';
		$user->user_id = $result->id;
		$user->save();

		return Response::json('New clinic has been added successfuly',200);
	}

	public function postUpdate()
	{
		$clinic = clinicsModel::find(Input::get('id'));
		if($clinic->saveItem($clinic)) return Response::json('Clinic has been updated successfuly',200);
		return Response::json('Error : could not update clinic',400);
	}

	public function getDelete($id = 0)
	{
		$clinic = clinicsModel::find($id);
		if(empty($clinic)) return Response::json('Error : Clinic could not be found ,Failed to delte clinic',404);
		$clinic->delete();
		return Response::json('Clinic has been deleted successfuly',200);
	}

	public function postNewvisit()
	{
		$Rules = array(
				'customer_id'=>'required',
				'diagnosis'=>'required',
				'cost'=>'required'
			);

		$Validator = Validator::make(Input::all(),$Rules);

		if($Validator->fails()) return Response::json('Error : failed to validate',400);

		$visit = new visitsModel;
		$visit->customer_id = Input::get('customer_id');
		$visit->clinic_id = Auth::user()->user_id;
		$visit->diagnosis = Input::get('diagnosis');
		$visit->cost = Input::get('cost');
		$visit->save();

		$customer = customersModel::find(Input::get('customer_id'));
		$customer->balance =  $customer->balance - Input::get('cost');
		$customer->save();

		return Response::json('Visit has been recorded successfuly',200);
	}
}