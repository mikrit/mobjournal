<?php defined('SYSPATH') or die('No direct script access.');?>

<div id="ptt">
	<div id="title">Пациент "<?=$data->fio?>"</div>

	<table class="table">
		<tr>
			<td class="text-right" colspan="2">
				<?
					echo Html::anchor('patient/update_patient/'.$data->id, 'Редактировать данные пациента');
					if($admin)
					{
						echo " |".Html::anchor('patient/delete_patient/'.$data->id, 'Удалить пациента', array("onclick" => "return confirm('Удалить пациента \'$data->fio\'?')"));
					}
					echo " |".Html::anchor('patient', 'Назад');
				?>
				<br/><br/>
			</td>
		</tr>
	</table>

	<table class="table">
		<tr>
			<td style="height: 25px; width: 15%;">ФИО:</td>
			<td><b><?=$data->fio?></b></td>
		</tr>
		<tr>
			<td style="height: 25px;">Пол:</td>
			<td><b><?=$data->sex == 0 ? 'Mужской' : 'Женский'?></b></td>
		</tr>
		<tr>
			<td style="height: 25px;">Год рождения:</td>
			<td><b><?=$data->year?></b></td>
		</tr>
		<tr>
			<td style="height: 25px;">Телефон:</td>
			<td><b><?=$data->phone?></b></td>
		</tr>
		<tr>
			<td style="height: 25px;">Контакты:</td>
			<td><b><?=$data->contacts?></b></td>
		</tr>
		<tr>
			<td style="height: 25px;">История болезни:</td>
			<td><b><?=$data->history?></b></td>
		</tr>
		<tr>
			<td style="height: 25px;">Отделение:</td>
			<td><b><?=$data->department?></b></td>
		</tr>
		<tr>
			<td style="height: 25px;">Диагноз:</td>
			<td  style="line-height: 20px;"><b><?=$data->diagnosis?></b></td>
		</tr>
	</table>
	<br/><br/><br/>

	<div id="edit">
		<?=Html::anchor('patient/add_analysis/'.$id, '+ Добавить новый номер')?>
	</div>
	<table class="table table-sm">
		<thead class="thead-inverse">
			<tr>
				<th>
					№
				</th>
				<th>
					Исследования
				</th>
				<th>
					Статус гена
				</th>
				<th>
					Номер материала
				</th>
				<th>
					Кол-во материала
				</th>
				<th>
					Метод исследования
				</th>
				<th>
					Развёрнутый диагноз
				</th>
				<th>
					Дата приёма
				</th>
			</tr>
		</thead>
		<?foreach($numbers as $number){?>
			<tr>
				<td>
					<?=Html::anchor('patient/data_analysis/'.$number->id, $number->number_a)?>
				</td>
				<td>
					<?
					foreach($number->analyzes->find_all() as $v)
					{
						echo $v->title."<br/>";
					}
					?>
				</td>
				<td>
					<?
					foreach($number->analyzes->find_all() as $v)
					{
						$stat = DB::select('status_id', 'analysis_id')
							->from('analyzes_numbers')
							->where('number_id', '=', $number->id)
							->and_where('analysis_id', '=', $v->id)
							->as_object()
							->execute();

						foreach($stat as $val)
						{
							$status = ORM::factory('status', $val->status_id);
							echo $status->status."<br/>";
						}
					}
					?>
				</td>
				<td>
					<?=$number->material_number?>
				</td>
				<td>
					<?=$number->material_count?>
				</td>
				<td>
					<?=$number->method->title?>
				</td>
				<td>
					<?=$number->comment?>
				</td>
				<td>
					<?=date('d.m.Y', $number->date_add)?>
				</td>
			</tr>
		<?}?>
	</table>
</div>
