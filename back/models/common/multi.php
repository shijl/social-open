<?php
namespace app\models\common;

class multi
{
	public static function get_multi(&$process)
	{
		$agree = new set_is_agree();
		$user = new set_user($agree);
		$api = new set_api($user);
		$api->multi($process);
	}
}