<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Print extends Controller_Template
{
	public $template = 'BaseLK/print';

	public function before()
	{
		parent::before();
		$this->template->content = '';
	}

	public function action_print_data()
	{
		$id = $this->request->param('id');
		$data = ORM::factory('number', $id);

		if(!$data->loaded())
		{
			$this->redirect('patient');
		}

		$view = View::factory('BaseLK/print/print_data');

		$view->data = $data;
		$view->analizis = $data->analyzes->find_all()->as_array();
		$view->analizis_count = $data->analyzes->count_all();

		$this->template->content = $view->render();
	}

	public function action_print_data2()
	{
		$id = $this->request->param('id');
		$data = ORM::factory('number', $id);

		if(!$data->loaded())
		{
			$this->redirect('patient');
		}

		$view = View::factory('BaseLK/print/print_data2');

		$view->data = $data;
		$view->analizis = $data->analyzes->find_all()->as_array();
		$view->analizis_count = $data->analyzes->count_all();

		$this->template->content = $view->render();
	}

	public function action_print_data3()
	{
		$id = $this->request->param('id');
		$data = ORM::factory('number', $id);

		if(!$data->loaded())
		{
			$this->redirect('patient');
		}

		$view = View::factory('BaseLK/print/print_data3');

		$view->data = $data;
		$view->analizis = $data->analyzes->find_all()->as_array();
		$view->analizis_count = $data->analyzes->count_all();

		$this->template->content = $view->render();
	}

	public function action_print_conclusion()
	{
		$id = $this->request->param('id');
		$data = ORM::factory('number', $id);

		if(!$data->loaded())
		{
			$this->redirect('patient');
		}

		$view = View::factory('BaseLK/print/print_conclusion');

		$view->data = $data;
		$view->analizis = $data->analyzes->find_all()->as_array();
		$view->analizis_count = $data->analyzes->count_all();

		$this->template->content = $view->render();
	}
}