<?php

/**
* test admins
*/
class adminsTest extends TestCase
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
		return array(
				'id'=>'1',
				'first_name'=>'munz',
				'last_name'=>'suli',
				'email'=>'munz.suli@dentous.com',
				'password'=>'DDubai@123'
			);
	}

	public function testViewAllAdmins()
	{
		$admin = $this->call('GET','api/v1/admins');
		$this->assertContains('1',$admin->getContent());
	}

	public function testDeleteAdmin()
	{
		$admin = $this->call('GET','api/v1/admins/delete/1');
		$this->assertContains('Admin has been deleted successfuly',$admin->getContent());
	}

	public function testCreateNewAdmin()
	{
		$admin = $this->call('POST','api/v1/admins/create',$this->_Post());
		$this->assertContains('New admin has been created successfuly',$admin->getContent());
	}

	public function testUpdateAdmin()
	{
		$admin = $this->call('POST','api/v1/admins/update',$this->_Post());
		$this->assertContains('Admin has been updated successfuly',$admin->getContent());
	}
}