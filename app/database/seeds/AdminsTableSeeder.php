<?php

class AdminsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('admins')->truncate();

		$users = array(
			'first_name'=>'ahmed',
			'last_name'=>'taz',
			'email'=>'ahedm.taz@dentos.com',
			'password'=>Hash::make('DDubai@123')
		);

		// Uncomment the below to run the seeder
		DB::table('admins')->insert($users);
	}

}
