<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Data extends Controller_BaseLK
{
	public function action_index()
	{
		$this->template->content = View::factory('BaseLK/data/index')->render();
	}

	public function action_list_analyzes()
	{
		$view = View::factory('BaseLK/data/list_analyzes');
		$view->data = ORM::factory('analysis')->find_all();

		$this->template->content = $view->render();
	}

	public function action_add_analysis()
	{
		$errors = array();
		$message = "";
		$data['title'] = '';

		if($_POST)
		{
			$post = Validation::factory($_POST)->rule('title', 'not_empty'); //Model_Analysis::validation_analysis($_POST);
			$data = $_POST;

			if(!$post->check())
			{
				$errors = $post->errors('projects/mes');
			}
			else
			{
				$orm = ORM::factory('analysis');
				$orm->values($_POST)->create($post);
				$this->redirect('data/list_analyzes');
			}
		}

		$view = View::factory('BaseLK/data/add_analysis');
		$view->data = $data;
		$view->errors = $errors;
		$view->message = $message;

		$this->template->content = $view->render();
	}

	public function action_update_analysis()
	{
		$id = $this->request->param('id');
		$orm = ORM::factory('analysis', $id);

		if(!$orm->loaded())
		{
			$this->redirect('data/list_analyzes');
		}

		$errors = array();
		$message = "";
		$data = $orm->as_array();

		if($_POST)
		{
			$post = Model_Analysis::validation_analysis($_POST);
			$data = $_POST;

			if(!$post->check())
			{
				$errors = $post->errors('projects/mes');
			}
			else
			{
				$orm->values($_POST)->update($post);
				$message = "Анализа успешно обновлён";
			}
		}

		$view = View::factory('BaseLK/data/update_analysis');
		$view->id = $orm->id;
		$view->data = $data;
		$view->errors = $errors;
		$view->message = $message;

		$this->template->content = $view->render();
	}

	public function action_list_statuses()
	{
		$view = View::factory('BaseLK/data/list_statuses');
		$view->data = ORM::factory('status')->find_all();

		$this->template->content = $view->render();
	}

	public function action_add_status()
	{
		$errors = array();
		$message = "";
		$data['status'] = '';
		$data['analysis_id'] = 1;
		$analyzes = Helper::get_list_orm('analysis', 'title');

		if($_POST)
		{
			$post = Validation::factory($_POST)->rule('status', 'not_empty');
			$data = $_POST;

			if(!$post->check())
			{
				$errors = $post->errors('projects/mes');
			}
			else
			{
				$orm = ORM::factory('status');
				$orm->values($_POST)->create($post);
				$this->redirect('data/list_statuses');
			}
		}

		$view = View::factory('BaseLK/data/add_status');
		$view->data = $data;
		$view->errors = $errors;
		$view->message = $message;
		$view->analyzes = $analyzes;

		$this->template->content = $view->render();
	}

	public function action_update_status()
	{
		$id = $this->request->param('id');
		$orm = ORM::factory('status', $id);

		if(!$orm->loaded())
		{
			$this->redirect('data/list_statuses');
		}

		$errors = array();
		$message = "";
		$data = $orm->as_array();
		$analyzes = Helper::get_list_orm('analysis', 'title');

		if($_POST)
		{
			$post = Model_Status::validation_status($_POST);
			$data = $_POST;

			if(!$post->check())
			{
				$errors = $post->errors('projects/mes');
			}
			else
			{
				$orm->values($_POST)->update($post);
				$message = "Статус гена успешно обновлён";
			}
		}

		$view = View::factory('BaseLK/data/update_status');
		$view->id = $orm->id;
		$view->data = $data;
		$view->errors = $errors;
		$view->message = $message;
		$view->analyzes = $analyzes;

		$this->template->content = $view->render();
	}

	public function action_list_methods()
	{
		$view = View::factory('BaseLK/data/list_methods');
		$view->data = ORM::factory('method')->find_all();

		$this->template->content = $view->render();
	}

	public function action_add_method()
	{
		$errors = array();
		$message = "";
		$data['title'] = '';

		if($_POST)
		{
			$post = Validation::factory($_POST)->rule('title', 'not_empty');
			$data = $_POST;

			if(!$post->check())
			{
				$errors = $post->errors('projects/mes');
			}
			else
			{
				$orm = ORM::factory('method');
				$orm->values($_POST)->create($post);
				$this->redirect('data/list_methods');
			}
		}

		$view = View::factory('BaseLK/data/add_method');
		$view->data = $data;
		$view->errors = $errors;
		$view->message = $message;

		$this->template->content = $view->render();
	}

	public function action_update_method()
	{
		$id = $this->request->param('id');
		$orm = ORM::factory('method', $id);

		if(!$orm->loaded())
		{
			$this->redirect('data/list_methods');
		}

		$errors = array();
		$message = "";
		$data = $orm->as_array();

		if($_POST)
		{
			$post = Model_Method::validation_method($_POST);
			$data = $_POST;

			if(!$post->check())
			{
				$errors = $post->errors('projects/mes');
			}
			else
			{
				$orm->values($_POST)->update($post);
				$message = "Метод успешно обновлён";
			}
		}

		$view = View::factory('BaseLK/data/update_method');
		$view->id = $orm->id;
		$view->data = $data;
		$view->errors = $errors;
		$view->message = $message;

		$this->template->content = $view->render();
	}

	public function action_list_types()
	{
		$view = View::factory('BaseLK/data/list_types');
		$view->data = ORM::factory('type')->find_all();
		$view->methods = Helper::get_list_orm('method', 'title');

		$this->template->content = $view->render();
	}

	public function action_update_types()
	{
		$id = $this->request->param('id');
		$data = ORM::factory('type', $id);

		if(!$data->loaded())
		{
			$this->redirect('data/list_types');
		}

		$errors = array();
		$message = "";
		$data2 = $data->as_array();
		$methods = Helper::get_list_orm('method', 'title');
		$analyzes = Helper::get_list_orm('analysis', 'title');

		if ($_POST)
		{
			$post = Model_Type::validation_type($_POST);

			$data2 = $_POST;

			if (!$post->check())
			{
				$errors = $post->errors('projects/mes');
			}
			else
			{
				$data->values($_POST)->update($post);

				foreach($methods as $k => $v)
				{
					if(!isset($_POST['method_'.$k]))
					{
						DB::delete('methods_types')
							->where('type_id', '=', $id)
							->and_where('method_id', '=', $k)
							->execute();

						$data2['method_'.$k] = 0;
					}
					else
					{
						if(!$data->has('methods', $k))
						{
							DB::insert('methods_types', array('method_id', 'type_id'))
								->values(array($k, $id))
								->execute();
						}
					}
				}

				foreach($analyzes as $k => $v)
				{
					if(!isset($_POST['analysis_'.$k]))
					{
						DB::delete('analyzes_types')
							->where('type_id', '=', $id)
							->and_where('analysis_id', '=', $k)
							->execute();

						$data2['analysis_'.$k] = 0;
					}
					else
					{
						if(!$data->has('analyzes', $k))
						{
							DB::insert('analyzes_types', array('analysis_id', 'type_id'))
								->values(array($k, $id))
								->execute();
						}
					}
				}

				$message = "Данные анализа успешно обновлёны";
			}
		}

		foreach($methods as $k => $v)
		{
			if(!isset($data2['method_'.$k]))
			{
				if($data->has('methods', $k))
				{
					$data2['method_'.$k] = 1;
				}
				else
				{
					$data2['method_'.$k] = 0;
				}
			}
		}

		foreach($analyzes as $k => $v)
		{
			if(!isset($data2['analysis_'.$k]))
			{
				if($data->has('analyzes', $k))
				{
					$data2['analysis_'.$k] = 1;
				}
				else
				{
					$data2['analysis_'.$k] = 0;
				}
			}
		}

		$view = View::factory('BaseLK/data/update_types');
		$view->id = $id;
		$view->data = $data2;
		$view->errors = $errors;
		$view->message = $message;
		$view->methods = $methods;
		$view->analyzes = $analyzes;

		$this->template->content = $view->render();
	}
}