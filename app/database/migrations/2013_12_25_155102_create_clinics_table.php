<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClinicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clinics', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email',200)->unique();
			$table->string('phone_number',20);
			$table->string('city');
			$table->text('address');
			$table->text('description');
			$table->string('password',200);
			$table->string('logo_link',200);
			$table->string('pic_link',200);
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
		Schema::drop('clinics');
	}

}
