<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('AdminsTableSeeder');
		$this->call('ClincsTableSeeder');
		$this->call('CustomersTableSeeder');
		$this->call('VisitsTableSeeder');
		$this->call('UsersTableSeeder');
	}

}