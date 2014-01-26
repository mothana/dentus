<?php

class VisitsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('visits')->truncate();

		$visits = 
		[
			array(
				'customer_id'=>'1',
				'clinic_id'=>'1',
				'diagnosis'=>'something minor',
				'cost'=>'200'
			),
			array(
				'customer_id'=>'1',
				'clinic_id'=>'1',
				'diagnosis'=>'something serious',
				'cost'=>'900'
			)
		];
		// Uncomment the below to run the seeder
		DB::table('visits')->insert($visits);
	}

}
