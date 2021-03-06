<?php
namespace app\models\libs;

class Tools
{
	public static function get_secret()
	{
		// 密码字符集，可任意添加你需要的字符
		$chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
				'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
				't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',
				'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',
				'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',
				'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!',
				'@','#', '$', '%', '^', '&', '*', '(', ')', '-', '_',
				'[', ']', '{', '}', '<', '>', '~', '`', '+', '=', ',',
				'.', ';', ':', '/', '?', '|');
		
		// 在 $chars 中随机取 $length 个数组元素键名
		$keys = array_rand($chars, 32);
		
		$str = '';
		for($i = 0; $i < 32; $i++)
		{
		// 将 $length 个数组元素连接成字符串
			$str .= $chars[$keys[$i]];
		}
		
		return strtr(substr(base64_encode($str), 0, 32), '+/', '_-');
	}
}