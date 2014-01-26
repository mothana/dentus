<?php

class ClincsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('clinics')->truncate();

		$clincs = 
		[
			array(
				'name'=>'wellcare',
				'email'=>'info@wellcaer.com',
				'phone_number'=>'0983676346',
				'city'=>'dubai',
				'address'=>'dubai al ghrahood area',
				'description'=>'A very well known nice place to take care of your beloveds',
				'password'=>Hash::make('DDubai@123'),
				'logo_link'=>'logo',
				'pic_link'=>'pic'
			),
			array(
				'name'=>'bestCare',
				'email'=>'info@bestCare.com',
				'phone_number'=>'0983676346',
				'city'=>'dubai',
				'address'=>'dubai al ghrahood area',
				'description'=>'A very well known nice place to take care of your beloveds',
				'password'=>Hash::make('DDubai@123'),
				'logo_link'=>'logo',
				'pic_link'=>'pic'
			)
		];

		// Uncomment the below to run the seeder
		DB::table('clinics')->insert($clincs);
	}

}
