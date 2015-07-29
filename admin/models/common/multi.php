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
	
	public static function get_api(&$process)
	{
		$api_info = new set_api_info();
		$api_info->multi($process);
	}
}