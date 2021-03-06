<?php

/**
* customers model
*/
class customersModel extends Eloquent
{
	protected $table = 'customers';

	//Not used so far
	public function visits()
	{
		return $this->belongsToMany('customersModel','visits','customer_id','clinic_id');
	}

	//Not used so far
	public function clinics()
	{
		return $this->belongsToMany('clinicsModel','visits','customer_id','clinic_id');
	}

	public function saveItem($customer)
	{
		if(!is_object($customer)) return false;

		$Rules = array(
			'first_name'=>'required',
			'last_name'=>'required',
			'nationality'=>'required',
			'birthdate'=>'required',
			'mobile_number'=>'required',
			'passport_number'=>'required',
			'city'=>'required',
			'address'=>'required',
			'work_status'=>'required',
			'marital_status'=>'required',
			'childern'=>'required',
			'company_name'=>'required',
			'company_city'=>'required',
			'company_phone'=>'required',
			'email'=>'required|unique:customers',
			'password'=>'required'
			);

		$Validator = Validator::make(Input::all(),$Rules);

		if($Validator->fails()) return false;

		$customer->first_name = Input::get('first_name');
		$customer->last_name = Input::get('last_name');
		$customer->nationality = Input::get('nationality');
		$customer->birthdate = Input::get('birthdate');
		$customer->mobile_number = Input::get('mobile_number');
		$customer->passport_number = Input::get('passport_number');
		$customer->city = Input::get('city');
		$customer->address = Input::get('address');
		$customer->work_status = Input::get('work_status');
		$customer->marital_status = Input::get('marital_status');
		$customer->childern = Input::get('childern');
		$customer->company_name = Input::get('company_name');
		$customer->company_city = Input::get('company_city');
		$customer->company_phone = Input::get('company_phone');
		$customer->email = Input::get('email');
		$customer->serial_number = 'null';
		$customer->password = Hash::make(Input::get('password'));
		$customer->img_link = Session::get('fileName');

		if(Input::get('balance'))
		{
			$customer->balance = Input::get('balance');
		}
		else
		{
			$customer->balance = '0';
		}
		
		$status = (Auth::user()->role == 'admin') ? 'true' : 'false';
		$customer->active = $status;
		$customer->save();

		$serial_number = date('y').date('m').date('d');
		$value = (Auth::user()->role == 'admin') ? $serial_number . $customer->id : 'null';
		$customer->serial_number = $value;
		$customer->save();

		return true;
	}

}