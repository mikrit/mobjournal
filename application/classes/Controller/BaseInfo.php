<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BaseInfo extends Controller_Template
{
	public $template = 'BaseInfo/base';

	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
	}

	public function before()
	{
		parent::before();

		$menu = View::factory('BaseInfo/menu');

		$this->template->menu = $menu->render();
		$this->template->content = '';
	}
}