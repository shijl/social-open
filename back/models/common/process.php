<?php
namespace app\models\common;

class process
{
	protected  $_obj = null;
	public function __construct($obj=null){
		if(!empty($obj))
			$this->_obj = $obj;
	}
	
	public function multi(&$pr){}
}