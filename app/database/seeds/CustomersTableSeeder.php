<?php

class CustomersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('customers')->truncate();

		$customers = array(
			[
				'first_name'=>'mono',
				'last_name'=>'dodo',
				'nationality'=>'sweden',
				'birthdate'=>'12/11/1986',
				'mobile_number'=>'0987656',
				'passport_number'=>'976139761397',
				'city'=>'dubai',
				'address'=>'dubai jbr',
				'work_status'=>'owner',
				'marital_status'=>'married',
				'childern'=>true,
				'company_name'=>'moheera',
				'company_city'=>'dubai',
				'company_phone'=>'046787656',
				'email'=>'dodo@swededn.com',
				'password'=>Hash::make('DDubai@123'),
				'serial_number'=>'1287987',
				'img_link'=>'img',
				'balance'=>'3000',
				'active'=>'false'
			],
			[
				'first_name'=>'mohammed',
				'last_name'=>'ali',
				'nationality'=>'iran',
				'birthdate'=>'12/11/1986',
				'mobile_number'=>'0987656',
				'passport_number'=>'976139761397',
				'city'=>'dubai',
				'address'=>'dubai jbr',
				'work_status'=>'owner',
				'marital_status'=>'married',
				'childern'=>true,
				'company_name'=>'moheera',
				'company_city'=>'dubai',
				'company_phone'=>'046787656',
				'email'=>'mohammed.ali@moheera.com',
				'password'=>Hash::make('DDubai@123'),
				'serial_number'=>'1287987',
				'img_link'=>'img',
				'balance'=>'3000',
				'active'=>'true'
			]
		);

		// Uncomment the below to run the seeder
		DB::table('customers')->insert($customers);
	}

}
