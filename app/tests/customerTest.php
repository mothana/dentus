<?php

/**
* test customer
*/
class customerTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		Route::enableFilters();
		Artisan::call('migrate');
		$this->seed();
		Auth::loginUsingId(1);
	}

	protected function _Post()
	{
		return $post = array(
			'first_name'=>'botata',
			'last_name'=>'alo',
			'nationality'=>'paki',
			'birthdate'=>'12/11/1986',
			'mobile_number'=>'0987656',
			'passport_number'=>'976139761397',
			'city'=>'dubai',
			'address'=>'dubai jbr',
			'work_status'=>'owner',
			'marital_status'=>'married',
			'childern'=>true,
			'company_name'=>'polo',
			'company_city'=>'dubai',
			'company_phone'=>'046787656',
			'email'=>'botata.alo@polo.com',
			'password'=>'DDubai@123',
			'serial_number'=>'1287987',
			'img_link'=>'img',
			'balance'=>'3000'
			);
	}

	public function testCallCustomerVisits()
	{
		$customer = $this->call('POST','api/v1/customers/visits',['id'=>1]);
		$this->assertContains('1',$customer->getContent());
	}

	public function testCallCustomersClinics()
	{
		$customer = $this->call('POST','api/v1/customers/clinics',['id'=>1]);
		$this->assertContains('1',$customer->getContent());
	}

	public function testCrateNewCustomer()
	{
		$customer = $this->call('POST','api/v1/customers/create',$this->_Post());
		$this->assertContains('New customer has been added successfully',$customer->getContent());
	}

	public function testUpdateCustomer()
	{
		$customer = $this->call('POST','api/v1/customers/update/1',$this->_Post());
		$this->assertContains('New customer has been updated successfully',$customer->getContent());
	}

	public function testDeleteCustomer()
	{
		$customer = $this->call('GET','api/v1/customers/delete/1');
		$this->assertContains('Customer has been deleted successfully',$customer->getContent());
	}
}