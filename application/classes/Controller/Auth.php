<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller_BaseInfo
{
	public function action_view_login()
	{
		$view = View::factory('auth/index');

		if(Auth::instance()->logged_in())
		{
			$view = View::factory('auth/logindex');
			$view->user_name = Auth::instance()->get_user()->username;
		}

		$this->template = $view;
	}

	public function action_login()
	{
		$this->auto_render = FALSE;
		
		$remember = 0;
		
		if(isset($_POST['remember']) && $_POST['remember'] == 1)
		{
			$remember = 1;
		}

		if (Request::initial()->is_ajax()) // выполняем только если запрос был через Ajax
		{
			if($_POST['login'] == '' || $_POST['password'] == '')
			{
				$result = array( // по умолчанию возвращаем код с ошибкой
					'code' => 'error',
					'error' => '<div class="alert alert-danger" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<span class="sr-only">Error:</span> Не введён логин или пароль
								</div>',
				);
			}
			else
			{
				if(Auth::instance()->login($_POST['login'], $_POST['password'], $remember))
				{
					$result = array(
						'code' => 'success',
						'error' => ''
					);
				}
				else
				{
					$result = array(
						'code' => 'error',
						'error' => '<div class="alert alert-danger" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<span class="sr-only">Error:</span> Неправильно введён логин или пароль
									</div>'
					);
				}
			}

			echo json_encode($result);
		}
	}

	public function action_logout()
	{
		Auth::instance()->logout();
		$this->redirect('/');
	}

	public function action_registration()
	{
		$this->auto_render = FALSE;
		
		$errors = array();

		if (Request::initial()->is_ajax()) // выполняем только если запрос был через Ajax
		{
			if ($_POST)
			{
				$user = ORM::factory('user');

				$validation = $user->validation_user($_POST);

				if ($validation->check())
				{
					$user->create_user($_POST, array('username', 'password', 'email'));
					$user->add('roles', ORM::factory('role', 1));

					$mess = 'Добро пожаловать в систему "Мой боджет"

Ваш логин: '.$_POST['username'].'
Ваш пароль: '.$_POST['password'].'

Приятной работы.';

					//Http::send_letter($_POST['email'], 'Регистрация пользователя', $mess);  //На сервере. В localhost почта не работает

					$result = array(
						'code' => 'success',
						'error' => '<div class="alert alert-success" role="alert">
										Удачная регистрация!
									</div>'
					);
				}
				else
				{
					$errors = $validation->errors('projects/mes');

					$e = '';
					foreach ($errors as $error)
					{
						$e .= $error."<br/>";
					}

                    var_dump($e);die;

					$result = array(
						'code' => 'error',
						'error' => '<div class="alert alert-danger form-control2" role="alert">
										'.$e.'
									</div>'
					);
				}
			}

			echo json_encode($result);
		}
	}
	
	public function action_forgotpassword()
	{
		$errors = array();
		
		if(Auth::instance()->logged_in()) //Нужно ли?
		{
			$this->redirect('/');
		}
		
		if($_POST)
		{
			$post = Validation::factory($_POST)
				->rule('email', 'not_empty')
				->rule('email', 'min_length', array(':value', 6))
				->rule('email', 'max_length', array(':value', 125))
				->rule('email', 'email');
			
			if(!$post->check())
			{
				$errors = $post->errors('validate');
			}
			else
			{
				$user = ORM::factory('user', array('email' => $post['email']));
				
				// сделать восстановку отправлением ссылки с сессией на почту, от туда человек попадает на страницу восстановление пароля
				if(!$user->loaded())
				{
					$error = 'E-mail не введён';
				}
				else
				{
					$user->password = 'Y7Fsa4J';
					$user->save();
					$subj = 'Новый пароль';
					$body = 'Ваш новый пароль: Y7Fsa4J';
							
					//Http::send_letter($user->email, $subj, $body);
					$mess = 'Пароль отправлен на e-mail';
				}
			}
		}
			
		$this->view_content = View::factory('auth/forgotpassword');
		$this->view_content->errors = $errors;
	}

	public function action_isset_login()
	{
		$this->auto_render = FALSE;
		
		if (Request::initial()->is_ajax()) // выполняем только если запрос был через Ajax
		{
			if(isset($_POST))
			{
				$user = ORM::factory('user')->where('username', '=', $_POST['username'])->count_all();
				
				if($user == 0)
				{
					$result = array(
						'code' => 'success',
						'message' => ''
					);
				}
				else
				{
					$result = array(
						'code' => 'error',
						'message' => '<div class="alert alert-danger form-control2" role="alert">Пользователь с таким логином уже существует</div>'
					);
				}
			}
			else
			{
				$result = array( // Возвращается ошибка если запрос не через POST
					'code' => 'error',
					'message' => 'No array POST'
				);
			}

			echo json_encode($result);
		}
	}

	public function action_isset_email()
	{
		$this->auto_render = FALSE;

		if (Request::initial()->is_ajax()) // выполняем только если запрос был через Ajax
		{
			if(isset($_POST))
			{
				$user = ORM::factory('user')->where('email', '=', $_POST['email'])->count_all();

				if($user == 0)
				{
					$result = array(
						'code' => 'success',
						'message' => ''
					);
				}
				else
				{
					$result = array(
						'code' => 'error',
						'message' => '<div class="alert alert-danger form-control2" role="alert">Такой Email уже занят</div>'
					);
				}
			}
			else
			{
				$result = array( // Возвращается ошибка если запрос не через POST
					'code' => 'error',
					'message' => 'No array POST'
				);
			}

			echo json_encode($result);
		}
	}
}