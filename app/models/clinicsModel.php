<?php


/**
* clincks
*/
class clinicsModel extends Eloquent
{
	protected $table = 'clinics';

	public static function visits()
	{
		return DB::select('select customers.first_name as first_name,customers.last_name as last_name,clinics.name as name,visits.cost as cost,visits.diagnosis as diagnosis,visits.created_at as created_at from visits,customers,clinics where clinics.id = visits.clinic_id AND customers.id = visits.customer_id');
	}

	public function customers()
	{
		return DB::select('select customers.img_link,customers.first_name,customers.last_name,customers.nationality,customers.birthdate,customers.mobile_number,customers.email from customers,clinics,visits where clinics.id = visits.clinic_id AND customers.id = visits.customer_id ORDER BY visits.created_at DESC');
	}

	//save the udate and new clincs
	public function saveItem($clinic = false)
	{
		if(!is_object($clinic)) return false;

		$Rules = array(
				'name'=>'required',
				'email'=>'email|required',
				'phone_number'=>'required',
				'city'=>'required',
				'address'=>'required',
				'description'=>'required',
				'password'=>'required'
			);

		$Validator = Validator::make(Input::all(),$Rules);

		if($Validator->fails()) return false;

		$clinic->name = Input::get('name');
		$clinic->email = Input::get('email');
		$clinic->phone_number = Input::get('phone_number');
		$clinic->city = Input::get('city');
		$clinic->address = Input::get('address');
		$clinic->description = Input::get('description');
		$clinic->password = Hash::make(Input::get('password'));
		$clinic->logo_link = Session::get('clinicLogo');
		$clinic->pic_link = Session::get('clinicPic');
		$clinic->save();

		
		Session::forget('clinicLogo');
		Session::forget('clinicPic');

		return $clinic;
	}

}