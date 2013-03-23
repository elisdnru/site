<?php

Yii::import('ext.phpBB.phpBB');

class phpBBDump extends phpBB
{
	public function init()
	{
	}

	public function login($username, $password)
	{
		return true;
	}

	public function logout()
	{
		return true;
	}

	public function userAdd($username, $password, $email, $group_id = 2)
	{
		return true;
	}

	public function userDelete($user)
	{
		return true;
	}

	public function changePassword($user, $password)
	{
		return true;
	}

	public function loggedin()
	{
		return false;
	}

	public function user_update($phpbb_vars)
	{
		return true;
	}
}
