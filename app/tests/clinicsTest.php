<?php

/**
* clinicsTest
*/
class clinicsTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		Route::enableFilters();
		Artisan::call('migrate');
		$this->seed();
		Auth::loginUsingId(1);
	}

	protected function post()
	{
		return	array(
					'id'=>'1',
					'name'=>'theBestCare',
					'email'=>'info@theBestCare.com',
					'phone_number'=>'0908786734',
					'city'=>'Silicon valy',
					'address'=>'somewhere in there',
					'description'=>'the place where most web app and tech stuff started',
					'password'=>'Dubai@123',
					'logo_link'=>'the_logo_goes_here',
					'pic_link'=>'the_pic_link_must_be_here'
				);
	}

	public function testViewAllClinics()
	{
		$clinic = $this->Call('GET','api/v1/clinics');
		$this->assertContains('1',$clinic->getContent());
	}

	public function testViewClinicCustomers()
	{
		$clinic = $this->Call('POST','api/v1/clinics/customers',['id'=>1]);
		$this->assertContains('first_name',$clinic->getContent());
	}

	public function testViewClinicVisits()
	{
		$clinic = $this->Call('POST','api/v1/clinics/visits',['id'=>1]);
		$this->assertContains('1',$clinic->getContent());
	}

	public function testCreateNewClinic()
	{
		$clinic = $this->call('POST','api/v1/clinics/create',$this->post());
		$this->assertContains('added',$clinic->getContent());
	}

	public function testUpdateClinic()
	{
		$clinic = $this->call('POST','api/v1/clinics/update',$this->post());
		$this->assertContains('updated',$clinic->getContent());
	}

	public function testClinicsNewVisit()
	{
		$clinic = $this->call('POST','api/v1/clinics/newvisit',['customer_id'=>'1','clinic_id'=>'1','diagnosis'=>'somthing new','cost'=>'250']);
		$this->assertContains('Visit has been recorded successfuly',$clinic->getContent());
	}
}