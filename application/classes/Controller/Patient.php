<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Patient extends Controller_BaseLK
{
	public function action_index()
	{
		$data['fio'] = '';
		$data['year'] = '';

		$count = ORM::factory('patient');
		$patients = ORM::factory('patient');

		if ($_GET)
		{
			foreach($data as $key => $val)
			{
				if(isset($_GET[$key]))
				{
					$data[$key] = $_GET[$key];
				}
			}

			if(isset($data['fio']) && $data['fio'] != '')
			{
				$count = $count->and_where('fio', 'LIKE', '%'.$data['fio'].'%');
				$patients = $patients->and_where('fio', 'LIKE', '%'.$data['fio'].'%');
			}

			if(isset($data['year']) && $data['year'] != '')
			{
				$count = $count->and_where('year', '=', $data['year']);;
				$patients = $patients->and_where('year', '=', $data['year']);;
			}
		}

		$count = $count->count_all();

		$pagination = Pagination::factory(array(
			'total_items' => $count,
			'items_per_page' => 30,
			'view' => 'pagination/floating',
		));

		$patients = $patients->order_by('id', 'desc')
		->limit($pagination->items_per_page)
		->offset($pagination->offset);

		$view = View::factory('BaseLK/patient/list_patients');

		$view->page_list = $pagination->render();
		$view->start = $pagination->offset;

		$view->data = $data;
		$view->patients = $patients->find_all();

		$this->template->content = $view->render();
	}
	
	public function action_add_patient()
	{
		$errors = array();
		$message = "";
		
		$data['fio'] = '';
		$data['sex'] = 0;
		$sex = array(0 => 'Мужской', 1 => 'Женский');
		$data['year'] = '';
		$data['department'] = '';
		$data['diagnosis'] = '';
		$data['history'] = '';
		$data['contacts'] = '';
		$data['phone'] = '';

		if($_POST)
		{
			$orm = ORM::factory('patient');

			$data = $_POST;
			$_POST['date_add'] = time();
			
			$post = Model_Patient::validation_patient($_POST);
			
			if (!$post->check())
			{
				$errors = $post->errors('projects/mes');
			}
			else
			{
				$orm->values($_POST)->create($post);

				$this->redirect('patient/data_patient/'.$orm->id);
			}
		}
		
		$view = View::factory('BaseLK/patient/add_patient');

		$view->data = $data;
		$view->sex = $sex;
		$view->errors = $errors;
		$view->message = $message;

		$this->template->content = $view->render();
	}
	
	public function action_data_patient()
	{
		$errors = array();
		$message = "";
		
		$id = $this->request->param('id');
		$data = ORM::factory('patient', $id);
		$statuses = Helper::get_list_orm('status', 'status');

		if(!$data->loaded())
		{
			$this->redirect('patient');
		}

        //$materials = ORM::factory('material')->where('number_id', '=', '');
		
		$view = View::factory('BaseLK/patient/data_patient');

		$numbers = $data->numbers->find_all();

		$view->data = $data;
		$view->numbers = $numbers;
		$view->statuses = $statuses;
		$view->admin = $this->admin->loaded();
		$view->errors = $errors;
		$view->message = $message;
		$view->id = $id;

		$this->template->content = $view->render();
	}

	public function action_update_patient()
	{
		$id = $this->request->param('id');
		$orm = ORM::factory('patient', $id);

		if(!$orm->loaded())
		{
			$this->redirect('/');
		}

		$errors = array();
		$message = "";
		$data = $orm->as_array();
		$sex = array(0 => 'Мужской', 1 => 'Женский');

		if ($_POST)
		{
			$post = Model_Patient::validation_patient($_POST);
			$data = $_POST;

			if (!$post->check())
			{
				$errors = $post->errors('projects/mes');
			}
			else
			{
				$orm->values($_POST)->update($post);
				$message = "Данные пациента успешно обновлёны";
			}
		}

		$view = View::factory('BaseLK/patient/update_patient');

		$view->id = $orm->id;
		$view->data = $data;
		$view->sex = $sex;
		$view->errors = $errors;
		$view->message = $message;

		$this->template->content = $view->render();
	}

	public function action_delete_patient()
	{
		$id = $this->request->param('id');
		$patient = ORM::factory('patient', $id);

		if(!$patient->loaded())
		{
			$this->redirect('/');
		}

		$user_id = Auth::instance()->get_user()->id;
		$admin = ORM::factory('user', $user_id)->roles->where('name', '=', 'admin')->find();

		if(!$admin->loaded())
		{
			$this->redirect('/');
		}

		/*$patient->remove('countries');

		$files = ORM::factory('file')->where('patient_id', '=', $id)->find_all();
		foreach($files as $file)
		{
			$file->delete();
		}

		$this->remove_dir(DOCROOT."files/".$id);
		$patient->delete();*/
		$this->redirect('/');
	}

	public function action_add_analysis()
	{
		$id = $this->request->param('id');
		$patient = ORM::factory('patient', $id);

		$errors = array();
		$message = "";

		$data['type_id'] = 1;
		$data['method_id'] = 1;
		$data['number_a'] = '';
		$data['material_number'] = '';
		$data['material_count'] = '';
		$data['comment'] = '';
		$data['notes'] = '';
		$data['user1_id'] = 0;
		$data['user2_id'] = 0;
		$data['user3_id'] = 0;
		$data['status'] = 1;
		$data['sms'] = 0;

		$types = Helper::get_list_orm('type', 'title');
		$analyzes = Helper::get_list_orm('analysis', 'title');
		$statuses = Helper::get_list_orm('status', 'status');

		$sings = array(0 => '');
		$orm = ORM::factory('user')->find_all();
		foreach($orm as $val){
			$sings[$val->id] = $val->name;
		}
		unset($sings[1]);

		if($_POST)
		{
			$methods = Helper::get_list_orm_method('type', 'title', $_POST['type_id']);
			$orm = ORM::factory('number');

			$_POST['patient_id'] = $id;
			$_POST['date_add'] = time();
			$_POST['date_comment'] = time();

			$data = $_POST;

			$post = Model_Number::validation_number($_POST);

			if (!$post->check())
			{
				$errors = $post->errors('projects/mes');
			}
			else
			{
				$orm_year = ORM::factory('year', $data['type_id']);
				$count = $orm_year->count;

				if($orm_year->year != Date('Y'))
				{
					$orm_year->values(array('year' => Date('Y'), 'count' => 0))->update(Validation::factory(array('year' => Date('Y'), 'count' => 0)));
					$count = 0;
				}

				$_POST['number_p'] = ++$count;
				$orm_year->values(array('count' => $count))->update(Validation::factory(array('count' => $count)));

				$orm->values($_POST)->create($post);

				foreach($methods as $k => $v)
				{
					if(isset($data['method_'.$k])){
						DB::insert('methods_numbers', array('method_id', 'number_id'))
							->values(array($k, $orm->id))
							->execute();
					}
				}

				foreach($analyzes as $k => $v)
				{
					if(isset($data['analysis_'.$k])){
						DB::insert('analyzes_numbers', array('analysis_id', 'number_id', 'status_id'))
							->values(array($k, $orm->id, $data['status_'.$k]))
							->execute();
					}
				}

				$this->redirect('patient/data_analysis/'.$orm->id);
			}
		}

		$methods = Helper::get_list_orm_method('type', 'title', 1);

		foreach($methods as $k => $v){
			if(!isset($data['method_'.$k])){
				$data['method_'.$k] = 0;
			}
		}

		foreach($analyzes as $k => $v){
			if(!isset($data['analysis_'.$k])){
				$data['analysis_'.$k] = 0;
				$data['status_'.$k] = 0;
			}
		}

		$view = View::factory('BaseLK/patient/add_analysis');

		$view->errors = $errors;
		$view->message = $message;
		$view->id = $id;
		$view->data = $data;
		$view->types = $types;
		$view->analyzes = $analyzes;
		$view->statuses = $statuses;
		$view->methods = $methods;
		$view->sings = $sings;
		$view->patient = $patient->fio;

		$this->template->content = $view->render();
	}

	public function action_data_analysis()
	{
		$id = $this->request->param('id');
		$data = ORM::factory('number', $id);

		if(!$data->loaded())
		{
			$this->redirect('/');
		}

		$errors = array();
		$message = "";
		$statuses = Helper::get_list_orm('status', 'status');

		$view = View::factory('BaseLK/patient/data_analysis');

		$view->data = $data;
		$view->patient = ORM::factory('patient', $data->patient_id);
		$view->admin = $this->admin->loaded();
		$view->errors = $errors;
		$view->message = $message;
		$view->statuses = $statuses;
		$view->id = $id;

		$this->template->content = $view->render();
	}

	public function action_update_analysis()
	{
		$id = $this->request->param('id');
		$data = ORM::factory('number', $id);

		if(!$data->loaded())
		{
			$this->redirect('/');
		}

		$patient = ORM::factory('patient', $data->patient_id);

		$errors = array();
		$message = "";
		$data2 = $data->as_array();

		$methods = Helper::get_list_orm_method('type', 'title', $data->type_id);
		$analyzes = Helper::get_list_orm('analysis', 'title');
		$statuses = Helper::get_list_orm('status', 'status');

		$sings = array(0 => '');
		$orm = ORM::factory('user')->find_all();
		foreach($orm as $val){
			$sings[$val->id] = $val->name;
		}
		unset($sings[1]);

		if ($_POST)
		{
			$_POST['date_comment'] = time();

			$post = Model_Number::validation_number($_POST);

			$data2 = $_POST;
			if($data->sms == NULL || $data->sms == 0)
			{
				$data2['sms'] = 0;
			}
			else
			{
				$data2['sms'] = 1;
			}

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
						DB::delete('methods_numbers')
							->where('number_id', '=', $id)
							->and_where('method_id', '=', $k)
							->execute();

						$data2['method_'.$k] = 0;
					}
					else
					{
						if(!$data->has('methods', $k))
						{
							DB::insert('methods_numbers', array('method_id', 'number_id'))
								->values(array($k, $id))
								->execute();
						}
					}
				}

				foreach($analyzes as $k => $v)
				{
					if(!isset($_POST['analysis_'.$k]))
					{
						DB::delete('analyzes_numbers')
							->where('number_id', '=', $id)
							->and_where('analysis_id', '=', $k)
							->execute();

						$data2['analysis_'.$k] = 0;
						$data2['status_'.$k] = 0;
					}
					else
					{
						if(!$data->has('analyzes', $k))
						{
							DB::insert('analyzes_numbers', array('analysis_id', 'number_id', 'status_id'))
								->values(array($k, $id, $data2['status_'.$k]))
								->execute();
						}
						else
						{
							DB::update('analyzes_numbers')
								->set(array('status_id' => $data2['status_'.$k]))
								->where('number_id', '=', $id)
								->and_where('analysis_id', '=', $k)
								->execute();
						}
					}
				}

				$message = "Данные анализа успешно обновлёны";
			}
		}

		foreach($methods as $k => $v){
			if(!isset($data2['method_'.$k]))
			{
				if($data->has('methods', $k)){
					$data2['method_'.$k] = 1;
				}else{
					$data2['method_'.$k] = 0;
				}
			}
		}


		$stat = DB::select('status_id', 'analysis_id')
					->from('analyzes_numbers')
					->where('number_id', '=', $id)
					->as_object()
					->execute();

		$statuses_arr = array();
		foreach($stat as $v)
		{
			$statuses_arr[$v->analysis_id] = $v->status_id;
		}

		foreach($analyzes as $k => $v){
			if(!isset($data2['analysis_'.$k]))
			{
				if($data->has('analyzes', $k)){
					$data2['analysis_'.$k] = 1;
					$data2['status_'.$k] = $statuses_arr[$k];
				}else{
					$data2['analysis_'.$k] = 0;
					$data2['status_'.$k] = 0;
				}
			}
		}

		$view = View::factory('BaseLK/patient/update_analysis');

		$view->errors = $errors;
		$view->message = $message;
		$view->data = $data2;
		$view->id = $id;
		$view->type = $data->type->title;
		$view->methods = $methods;
		$view->analyzes = $analyzes;
		$view->statuses = $statuses;
		$view->sings = $sings;
		$view->patient = $patient;

		$this->template->content = $view->render();
	}

	public function action_delete_analysis()
	{
		$id = $this->request->param('id');
		
		$data = ORM::factory('number', $id);

		$user_id = Auth::instance()->get_user()->id;
		$admin = ORM::factory('user', $user_id)->roles->where('name', '=', 'admin')->find();
		
		if(!$data->loaded() || !$admin->loaded())
		{
			$this->redirect('/');
		}
		
		$data->delete();
		$this->redirect('/');
	}
}