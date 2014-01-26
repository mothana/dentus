<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('users')->truncate();

		$users = array(
			[
				'first_name'=>'ahmed',
				'last_name'=>'taz',
				'email'=>'ahedm.taz@dentos.com',
				'password'=>Hash::make('DDubai@123'),
				'role'=>'admin',
				'user_id'=>'1'
			],
			[
				'first_name'=>'null',
				'last_name'=>'null',
				'email'=>'info@wellcaer.com',
				'password'=>Hash::make('DDubai@123'),
				'role'=>'clinic',
				'user_id'=>'1'
			]

		);


		// Uncomment the below to run the seeder
		DB::table('users')->insert($users);
	}

}
