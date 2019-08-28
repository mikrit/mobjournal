<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BaseLK extends Controller_Template
{
	public $template = 'BaseLK/template';
	public $user_id = 0;
	public $admin = '';

	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);

		if(Auth::instance()->logged_in())
		{
			$this->user_id = Auth::instance()->get_user()->id;
		}
		else
		{
			$this->redirect('/');
		}
	}

	public function before()
	{
		parent::before();

		if(!Auth::instance()->logged_in())
		{
			$this->redirect('/');
		}

		$menu = View::factory('BaseLK/menu');

		$user_id = Auth::instance()->get_user()->id;
		$this->admin = ORM::factory('user', $user_id)->roles->where('name', '=', 'admin')->find();

		$url = 'https://gate.smsaero.ru/v2/balance';

		$request = Request::factory($url);

		$request->client()->options(array(
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_USERPWD => "sms@molbiolab.ru:0eVICWBTgXVqPTLns6ZapZIngtsK"
		));
		$answer = $request->execute()->body();

		if(strlen($answer) > 10)
		{
			$balance = json_decode($answer)->data->balance;
		}

		$menu->balance = $balance;
		$menu->admin = $this->admin->loaded();
		$this->template->menu = $menu->render();
		$this->template->content = '';
	}
}