<?php

trait SeleniumLoginTrait
{
	protected $_user;
	
	public function create_test_user()
	{
		$this->_user = factory(App\User::class)->create();
	}

	public function delete_test_user()
	{
		DB::table('users')->where('email', '=', $this->_user->email)->delete();
	}

	public function login_interface()
	{
		$this->byName('email')->value($this->_user->email);
		$this->byName('password')->value('password');
        $this->byId('Login')->submit();
	}

	public function login()
	{
		$this->create_test_user();
		$this->login_interface();
	}

	public function logout()
	{
		$this->delete_test_user();
	}

	public function truncateTable($table)
	{
		DB::table($table)->truncate();
	}

}