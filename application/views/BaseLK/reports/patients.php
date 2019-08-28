<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="t-center">
	<div id="title" style="width: 350px;">Поиск по пациентам</div>

	<?=Form::open('reports/patients', array('method'=>'post'));?>
		<table class="t_form">
			<tr>
				<td class="right">
					<div id="edit"><?=Html::anchor('reports', 'Назад')?></div>
				</td>
			</tr>
			<tr>
				<td>
					<label>С:</label>
					<?=Form::input('to', preg_match('/\d{6,}/', $data['to']) ? date('Y-m-d', $data['to']) : $data['to'], array('name' => 'date', 'class' => 'date_input form-control'));?>
				</td>
			</tr>
			<tr>
				<td>
					<label>По:</label>
					<?=Form::input('from', preg_match('/\d{6,}/', $data['from']) ? date('Y-m-d', $data['from']) : $data['from'], array('name' => 'date', 'class' => 'date_input form-control'));?>
				</td>
			</tr>
			<tr>
				<td>
					<label>Отделение:</label>
					<?=Form::input('department', $data['department'], array('class' => 'form-control'));?>
				</td>
			</tr>
			<tr>
				<td>
					<label>История болезни:</label>
					<?=Form::input('history', $data['history'], array('class' => 'form-control'));?>
				</td>
			</tr>
			<tr>
				<td>
					<label>Тип оплаты:</label>
					<?=Form::select('payment', array(-1 => 'Все', 0 => '-', 1 => 'Платно', 2 => 'ОМС', 3 => 'ДМС'), $data['payment'], array('class' => 'form-control'));?>
				</td>
			</tr>
			<tr>
				<td class="right">
					<?=Form::input('submit', 'Поиск', array('id' => 'button', 'type'=>'submit', 'class' => 'btn btn-primary'));?>
				</td>
			</tr>
		</table>
	<?=Form::close();?>
</div>

<br/><br/>

<?if($count == 0){?>
	<center><h2>Ничего не найдено</h2></center>
<?}else if($count > 0){?>
	<table id="proj_task">
		<tr id="head_tasks">
			<td colspan="4" style="text-align: left">
				Количество: <?=$count?>
			</td>
		</tr>
		<tr id="head_tasks">
			<td>
				ФИО
			</td>
			<td>
				Отделение
			</td>
			<td>
				История болезни
			</td>
			<td>
				Дата приёма
			</td>
		</tr>
		<?foreach($patients as $patient){?>
			<tr>
				<td>
					<?=Html::anchor('patient/data_patient/'.$patient->id, $patient->fio)?>
				</td>
				<td>
					<?=$patient->department?>
				</td>
				<td>
					<?=$patient->history?>
				</td>
				<td>
					<?=date('d.m.Y', $patient->date_add)?>
				</td>
			</tr>
		<?}?>
	</table>
<?}?>

<script>
	$($.date_input.initialize);
</script>