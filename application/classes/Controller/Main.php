<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_BaseLK
{
	public function action_index()
	{
		$data['fio'] = '';
		$data['number_p'] = '';
		$data['number_a'] = '';
		$data['material_number'] = '';
		$data['year'] = date('Y');
		$data['tab'] = 1;

		$statuses = array(
			1 => 'Зарегистрирован, в ожидании обработки',
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

		$count = ORM::factory('number')->select(array('patients.id', 'pid'), array('patients.fio', 'fio'));
		$numbers = ORM::factory('number')->select(array('patients.id', 'pid'), array('patients.fio', 'fio'));

		$count2 = ORM::factory('number')->select(array('patients.id', 'pid'), array('patients.fio', 'fio'));
		$numbers2 = ORM::factory('number')->select(array('patients.id', 'pid'), array('patients.fio', 'fio'));

		if($_GET)
		{
			foreach($data as $key => $val)
			{
				if(isset($_GET[$key]))
				{
					$data[$key] = $_GET[$key];
				}
			}

			if(isset($data['number_p']) && $data['number_p'] != '')
			{
				$count = $count->and_where('number.number_p', '=', $data['number_p']);
				$numbers = $numbers->and_where('number.number_p', '=', $data['number_p']);

				$count2 = $count2->and_where('number.number_p', '=', $data['number_p']);
				$numbers2 = $numbers2->and_where('number.number_p', '=', $data['number_p']);
			}

			if(isset($data['number_a']) && $data['number_a'] != '')
			{
				$count = $count->and_where('number.number_a', '=', $data['number_a']);
				$numbers = $numbers->and_where('number.number_a', '=', $data['number_a']);

				$count2 = $count2->and_where('number.number_a', '=', $data['number_a']);
				$numbers2 = $numbers2->and_where('number.number_a', '=', $data['number_a']);
			}

			if(isset($data['material_number']) && $data['material_number'] != '')
			{
				$count = $count->and_where('number.material_number', 'LIKE', '%'.$data['material_number'].'%');
				$numbers = $numbers->and_where('number.material_number', 'LIKE', '%'.$data['material_number'].'%');

				$count2 = $count2->and_where('number.material_number', 'LIKE', '%'.$data['material_number'].'%');
				$numbers2 = $numbers2->and_where('number.material_number', 'LIKE', '%'.$data['material_number'].'%');
			}

			if(isset($data['fio']) && $data['fio'] != '')
			{
				$count = $count->and_where('patients.fio', 'LIKE', '%'.$data['fio'].'%');
				$numbers = $numbers->and_where('patients.fio', 'LIKE', '%'.$data['fio'].'%');

				$count2 = $count2->and_where('patients.fio', 'LIKE', '%'.$data['fio'].'%');
				$numbers2 = $numbers2->and_where('patients.fio', 'LIKE', '%'.$data['fio'].'%');
			}

			if(isset($data['year']) && $data['year'] != '')
			{
				$count = $count->and_where('number.date_add', '>=', mktime(0, 0, 0, 1, 1, $data['year']))
                                ->and_where('number.date_add', '<=', mktime(23, 59, 59, 12, 31, $data['year']));
				$numbers = $numbers->and_where('number.date_add', '>=', mktime(0, 0, 0, 1, 1, $data['year']))
                                    ->and_where('number.date_add', '<=', mktime(23, 59, 59, 12, 31, $data['year']));

				$count2 = $count2->and_where('number.date_add', '>=', mktime(0, 0, 0, 1, 1, $data['year']))
                                ->and_where('number.date_add', '<=', mktime(23, 59, 59, 12, 31, $data['year']));
				$numbers2 = $numbers2->and_where('number.date_add', '>=', mktime(0, 0, 0, 1, 1, $data['year']))
                                    ->and_where('number.date_add', '<=', mktime(23, 59, 59, 12, 31, $data['year']));
			}

			/*if(!isset($_GET['year']) || $_GET['year'] == '')
			{
				$data['year'] = date('Y');
			}*/
		}

		if(isset($_GET['tab']))
		{
			$data['tab'] = $_GET['tab'];
		}

		$count = $count->join('patients', 'LEFT')
			->on('number.patient_id', '=', 'patients.id')
			->and_where('type_id', '=', '1')
			->order_by('number_p', 'desc')
			->count_all();

		$pagination = Pagination::factory(array(
			'total_items' => $count,
			'items_per_page' => 50,
			'view' => 'pagination/floating',
			'type' => 1
		));

		$count2 = $count2->join('patients', 'LEFT')
			->on('number.patient_id', '=', 'patients.id')
			->and_where('type_id', '=', '2')
			->order_by('number_p', 'desc')
			->count_all();

		$pagination2 = Pagination::factory(array(
			'total_items' => $count2,
			'items_per_page' => 50,
			'view' => 'pagination/floating',
			'type' => 2
		));

		$numbers = $numbers->join('patients', 'LEFT')
			->on('number.patient_id', '=', 'patients.id')
			->and_where('type_id', '=', '1')
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->order_by('number_p', 'desc');

		$numbers2 = $numbers2->join('patients', 'LEFT')
			->on('number.patient_id', '=', 'patients.id')
			->and_where('type_id', '=', '2')
			->limit($pagination2->items_per_page)
			->offset($pagination2->offset)
			->order_by('number_p', 'desc');

		$view = View::factory('BaseLK/main/index');

		$view->page_list = $pagination->render();
		//$view->start = $pagination->offset;

		$view->page_list2 = $pagination2->render();
		//$view->start2 = $pagination2->offset;

		$view->numbers = $numbers->find_all();
		$view->numbers2 = $numbers2->find_all();
		$view->data = $data;
		$view->tab = $data['tab'];
		$view->statuses = $statuses;

		$this->template->content = $view->render();
	}
}