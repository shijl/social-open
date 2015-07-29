<?php

return [
    'adminEmail' => 'admin@example.com',
	'api_apply_agree' => [
		0=>'待审核',
		1=>'通过',
		2=>'不通过',
	],
	'rate' => [
		'unit'=>'/mins',
		'value'=>[
			1=>10,
			2=>30,
			3=>50,
		]
	],
	'api' => [
		'type' => [
			1=>'微信',
			2=>'微博',
		],
		'status' => [
			1=>'启用',
			2=>'停用',
		]
	]
];
