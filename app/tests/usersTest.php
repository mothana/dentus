<?php

/**
* users test
*/
class usersTest extends TestCase
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
				'first_name'=>'ahmeda',
				'last_name'=>'taza',
				'email'=>'ahedma.taza@chetos.com',
				'password'=>'DDubai@123',
				'role'=>'admin',
				'user_id'=>'1'
			);
	}

	public function testViewAllUsers()
	{
		$user = $this->call('GET','api/v1/users');
		$this->assertContains('first_name',$user->getContent());
	}

	public function testDeleteUser($id = 0)
	{
		$user = $this->call('GET','api/v1/users/delete/1');
		$this->assertContains('User has been deleted successfuly',$user->getContent());
	}

	public function testCreateNewUser()
	{
		$user = $this->call('POST','api/v1/users/create',$this->_Post());
		$this->assertContains('New user has been added successfuly',$user->getContent());
	}

	public function testUpdateNewUser()
	{
		$user = $this->call('POST','api/v1/users/update',$this->_Post());
		$this->assertContains('New user has been updated successfuly',$user->getContent());
	}
}