<?php

namespace App\Controllers;

class Index extends \MvcCore\Controller
{
	public function Init() {
		date_default_timezone_set('Europe/Prague');
	}
    public function IndexAction () {
		$cfg = [
			'driver'	=> 'mysql',
			'host'		=> 'localhost',
			'user'		=> 'root',
			'password'	=> '1234',
			'database'	=> 'tests'
		];
		if ($_SERVER['SERVER_NAME'] == 'dev.tests.tomflidr.cz') {
			$cfg['user'] = 'tests';
			$cfg['password'] = '4g%88v§kgaYJH@tVw';
		}
		$db = \MvcCore\Model::GetDb($cfg);
		$select = $db->prepare(
			"SELECT * FROM langs_and_locales t"
			//." WHERE win_strftime_support = 1"
		);
		$select->execute();
		$data = $select->fetchAll(\PDO::FETCH_ASSOC);
		foreach ($data as $key => $value) $data[$key] = (object) $value;


		$this->view->data = $data;
	}
}
