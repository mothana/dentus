<?php

/**
* loginTest
*/
class loginTest extends TestCase
{
	public function testLogin()
	{
		$user = $this->call('POST','api/v1/login',['email'=>'ahedm.taz@dentos.com','password'=>'DDubai@123']);
		$this->assertContains('ok',$user->getContent());
	}

	public function testLogout()
	{
		$user = $this->call('GET','api/v1/login/logout');
		$this->assertContains('ok',$user->getContent());
	}
}