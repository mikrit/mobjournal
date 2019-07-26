<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Info extends Controller_BaseInfo
{
	public function action_index()
	{
		$view = View::factory('BaseInfo/info/index');
		$this->template->content = $view->render();
	}

	public function action_vhod()
	{
        if(Auth::instance()->logged_in())
        {
            $this->redirect('main');
        }

		$view = View::factory('BaseInfo/info/login');

		$view->auth = Request::factory('auth/view_login')->execute()->body();
		$this->template->content = $view->render();
	}

	public function action_about()
	{
		$view = View::factory('BaseInfo/info/about');
		$this->template->content = $view->render();
	}
}