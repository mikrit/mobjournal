<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Reports extends Controller_BaseLK
{
	public function action_index()
	{
		$this->template->content = View::factory('BaseLK/reports/index')->render();
	}

	public function action_patients()
	{
		$_count = ORM::factory('patient');
		$patients = ORM::factory('patient');

		$data['to'] = date('Y-01-01');
		$data['from'] = time();
		$data['department'] = '';
		$data['history'] = '';
		$data['payment'] = -1;
		$count = -1;

		if ($_POST)
		{
			$data = $_POST;

			$a = explode("-", $_POST['to']);
			if($a[0] != ''){
				$_POST['to'] = mktime(0,0,0,$a[1],$a[2],$a[0]);
			}else{
				$_POST['to'] = null;
			}

			$a = explode("-", $_POST['from']);
			if($a[0] != ''){
				$_POST['from'] = mktime(23,59,59,$a[1],$a[2],$a[0]);
			}else{
				$_POST['from'] = null;
			}

			if($_POST['to'] == null || $_POST['from'] == null)
			{
				$errors = array(0 => 'Одна из дат не заполнена');
			}
			else
			{
				if($data['department'] != '')
				{
					$_count = $_count->and_where('patient.department', 'LIKE', '%'.$data['department'].'%');
					$patients = $patients->and_where('patient.department', 'LIKE', '%'.$data['department'].'%');
				}

				if($data['history'] != '')
				{
					$_count = $_count->and_where('patient.history', 'LIKE', '%'.$data['history'].'%');
					$patients = $patients->and_where('patient.history', 'LIKE', '%'.$data['history'].'%');
				}

				if($data['payment'] != -1)
				{
					$_count = $_count->join('numbers', 'LEFT')->on('numbers.patient_id', '=', 'patient.id')->and_where('payment', '=', $data['payment']);
					$patients = $patients->join('numbers', 'LEFT')->on('numbers.patient_id', '=', 'patient.id')->and_where('payment', '=', $data['payment']);
				}

				$count = $_count->and_where('patient.date_add', '>=', $_POST['to'])->and_where('patient.date_add', '<=', $_POST['from'])->count_all();
				$patients = $patients->and_where('patient.date_add', '>=', $_POST['to'])->and_where('patient.date_add', '<=', $_POST['from'])->find_all();
			}
		}

		$view = View::factory('BaseLK/reports/patients');

		$view->data = $data;
		$view->patients = $patients;
		$view->count = $count;

		$this->template->content = $view->render();
	}

	public function action_analysis()
	{
		$_count = ORM::factory('number');
		$numbersO = ORM::factory('number');

		$data['to'] = date('Y-01-01');
		$data['from'] = time();
		$data['status_id'] = 0;
		$data['payment'] = -1;
		$data['analysis_id'] = 0;

		$count = -1;

		$analyzes = Helper::get_list_orm('analysis', 'title');

		foreach($analyzes as $k => $v)
		{
			$data['analysis_id'] = $k;
			break;
		}

		if($_POST)
		{
			if(!isset($_POST['status_id']))
			{
				$_POST['status_id'] = 0;
			}

			$data = $_POST;

			$a = explode("-", $_POST['to']);
			if($a[0] != '')
			{
				$_POST['to'] = mktime(0, 0, 0, $a[1], $a[2], $a[0]);
			}
			else
			{
				$_POST['to'] = NULL;
			}

			$a = explode("-", $_POST['from']);
			if($a[0] != '')
			{
				$_POST['from'] = mktime(23, 59, 59, $a[1], $a[2], $a[0]);
			}
			else
			{
				$_POST['from'] = NULL;
			}

			if($_POST['to'] == NULL || $_POST['from'] == NULL)
			{
				$errors = array(0 => 'Одна из дат не заполнена');
			}
			else
			{
				if($data['analysis_id'] != 0 || $data['status_id'] != 0)
				{
					$_count = $_count->join('analyzes_numbers')->on('analyzes_numbers.number_id', '=', 'number.id');
					$numbersO = $numbersO->join('analyzes_numbers')->on('analyzes_numbers.number_id', '=', 'number.id');
				}

				if($data['analysis_id'] != 0)
				{
					$_count = $_count->join('analyzes')->on('analyzes.id', '=', 'analyzes_numbers.analysis_id')->and_where('analyzes.id', '=', $data['analysis_id']);
					$numbersO = $numbersO->join('analyzes')->on('analyzes.id', '=', 'analyzes_numbers.analysis_id')->and_where('analyzes.id', '=', $data['analysis_id']);
				}

				if($data['status_id'] != 0)
				{
					$_count = $_count->join('statuses')->on('statuses.id', '=', 'analyzes_numbers.status_id')->and_where('statuses.id', '=', $data['status_id']);
					$numbersO = $numbersO->join('statuses')->on('statuses.id', '=', 'analyzes_numbers.status_id')->and_where('statuses.id', '=', $data['status_id']);
				}

				if($data['payment'] != -1)
				{
					$_count = $_count->and_where('payment', '=', $data['payment']);
					$numbersO = $numbersO->and_where('payment', '=', $data['payment']);
				}

				$count = $_count->and_where('date_add', '>=', $_POST['to'])->and_where('date_add', '<=', $_POST['from'])->count_all();
				$numbersO = $numbersO->and_where('date_add', '>=', $_POST['to'])->and_where('date_add', '<=', $_POST['from'])->find_all();
			}
		}

		$numbers_by_years = array();
		foreach($numbersO as $number)
		{
			$numbers_by_years[date('Y', $number->date_add)][] = $number;
		}

		$orm = ORM::factory('status')->where('analysis_id', '=', $data['analysis_id'])->find_all();

		$st[0] = '-';
		foreach($orm as $val)
		{
			$st[$val->id] = $val->status;
		}

		$orm = ORM::factory('analysis', $data['analysis_id']);

		$analises = $orm->title;

		$status = $st[$data['status_id']];
		$statuses = Form::select('status_id', $st, $data['status_id'], array('id' => 'st', 'class' => 'form-control'));

		$view = View::factory('BaseLK/reports/analysis');

		$view->data = $data;
		$view->numbers_by_years = $numbers_by_years;
		$view->analyzes = $analyzes;
		$view->analises = $analises;
		$view->statuses = $statuses;
		$view->status = $status;
		$view->count = $count;

		$this->template->content = $view->render();
	}

    public function action_notes()
    {
        $_count = ORM::factory('number');
        $numbers = ORM::factory('number');

        $count = -1;

        $data['to'] = date('Y-01-01');
        $data['from'] = time();
        $data['notes'] = '';

        if ($_POST)
        {
            $data = $_POST;

            $a = explode("-", $_POST['to']);
            if($a[0] != ''){
                $_POST['to'] = mktime(0,0,0,$a[1],$a[2],$a[0]);
            }else{
                $_POST['to'] = null;
            }

            $a = explode("-", $_POST['from']);
            if($a[0] != ''){
                $_POST['from'] = mktime(23,59,59,$a[1],$a[2],$a[0]);
            }else{
                $_POST['from'] = null;
            }

            if($_POST['to'] == null || $_POST['from'] == null)
            {
                $errors = array(0 => 'Одна из дат не заполнена');
            }
            else
            {
                if($data['notes'] != '')
                {
                    $_count = $_count->and_where('notes', 'LIKE', '%'.$data['notes'].'%');
                    $numbers = $numbers->and_where('notes', 'LIKE', '%'.$data['notes'].'%');
                }
                else
                {
                    $_count = $_count->and_where('notes', '<>', '');
                    $numbers = $numbers->and_where('notes', '<>', '');
                }

                $count = $_count->and_where('date_add', '>=', $_POST['to'])->and_where('date_add', '<=', $_POST['from'])->count_all();
                $numbers = $numbers->and_where('date_add', '>=', $_POST['to'])->and_where('date_add', '<=', $_POST['from'])->find_all();
            }
        }

        $view = View::factory('BaseLK/reports/notes');

        $view->data = $data;
        $view->numbers = $numbers;
        $view->count = $count;

        $this->template->content = $view->render();
    }

	public function action_status()
	{
		$_count = ORM::factory('number');
		$numbers = ORM::factory('number');

		$count = -1;

		$data['to'] = date('Y-01-01');
		$data['from'] = time();
		$data['status'] = '';

		$numbers = ORM::factory('number');

		$statuses = array(
			1 => 'Зарегистрирован',
			2 => 'Материал на отборе',
			3 => 'В работе',
			4 => 'Готов',
			5 => 'Отказ пациента',
			6 => 'Отказ по состоянию материала',
			7 => 'Отправлен пациенту',
			8 => 'Повтор',
			9 => 'Особый случай',
			10 => 'Договор',
			11 => 'ДМС',
		);

		if ($_POST)
		{
			$data = $_POST;

			$a = explode("-", $_POST['to']);
			if($a[0] != '')
			{
				$_POST['to'] = mktime(0, 0, 0, $a[1], $a[2], $a[0]);
			}
			else
			{
				$_POST['to'] = NULL;
			}

			$a = explode("-", $_POST['from']);
			if($a[0] != '')
			{
				$_POST['from'] = mktime(23, 59, 59, $a[1], $a[2], $a[0]);
			}
			else
			{
				$_POST['from'] = NULL;
			}

			if($_POST['to'] == NULL || $_POST['from'] == NULL)
			{
				$errors = array(0 => 'Одна из дат не заполнена');
			}
			else
			{
				$numbers = $numbers->where('date_add', '>=', $_POST['to'])->and_where('date_add', '<=', $_POST['from'])->and_where('status', '=', $_POST['status'])->find_all();
				$count = $_count->where('date_add', '>=', $_POST['to'])->and_where('date_add', '<=', $_POST['from'])->and_where('status', '=', $_POST['status'])->count_all();
			}
		}

		$view = View::factory('BaseLK/reports/status');

		$view->data = $data;
		$view->statuses = $statuses;
		$view->count = $count;
		$view->numbers = $numbers;

		$this->template->content = $view->render();
	}
}