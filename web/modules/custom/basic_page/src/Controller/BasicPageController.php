<?php

namespace Drupal\basic_page\Controller;
use Drupal\Core\Controller\ControllerBase;

class BasicPageController extends ControllerBase{
	public function basicPage(){
	  return [
	  	'#title'=>'Basic Page Information',
	  	'#markup'=>'Hello World!. This is our basic page.'
	  ];
	}

	public function information(){
		$data = array(
			'name'=>'Arun Kumar',
			'email'=>'arun.k@gai.co.in'
		);
		return [
			'#title'=>'Information Page',
			'#theme'=>'information_page',
			'#items'=>$data
		];
	}
}