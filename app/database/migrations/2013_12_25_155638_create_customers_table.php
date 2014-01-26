<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table) {
			$table->increments('id');
			$table->string('first_name',100);
			$table->string('last_name',100);
			$table->string('nationality',100);
			$table->string('birthdate',20);
			$table->string('mobile_number');
			$table->string('passport_number',20);
			$table->string('city',20);
			$table->text('address');
			$table->string('work_status',20);
			$table->string('marital_status',20);
			$table->string('childern');
			$table->string('company_name',100);
			$table->string('company_city',100);
			$table->string('company_phone',100);
			$table->string('email',200)->unique();
			$table->string('password',200);
			$table->string('serial_number',20);
			$table->string('img_link',200);
			$table->string('balance',20);
			$table->string('active');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers');
	}

}
