<?php defined('SYSPATH') or die('No direct script access.');?>

<div id="title">Список пациентов</div>

<div class="noprint">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-6">
			<div id="title">Поиск</div>
			<?=Form::open('patient', array('method'=>'get', 'class' => 'form-horizontal'));?>
			<div class="form-group row">
				<label class="col-xs-3 col-sm-5">ФИО пациента:</label>
				<div class="col-xs-9 col-sm-7">
					<?=Form::input('fio', $data['fio'], array('class' => 'form-control', 'type' => 'text'));?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-xs-3 col-sm-5">Год рождения:</label>
				<div class="col-xs-9 col-sm-7">
					<?=Form::input('year', $data['year'], array('class' => 'form-control', 'type' => 'text'));?>
				</div>
			</div>
			<?=Form::input('submit', 'Поиск',array('id' => 'button', 'type'=>'submit', 'class' => 'btn btn-primary'));?>
			<?=Form::close();?>
			<br/><br/>
		</div>
	</div>
</div>

<table class="table table-striped">
	<thead>
        <tr>
            <td colspan="7" style="text-align: right">
                <?=Html::anchor('patient/add_patient/', '+ Добавить нового пациента')?>
            </td>
        </tr>
		<tr>
			<th>
				ФИО
			</th>
			<th>
				Пол
			</th>
			<th>
				Год рождения
			</th>
			<th>
				История болезни
			</th>
			<th>
				Отделение
			</th>
			<th>
				Диагноз
			</th>
			<th>
				Дата рег.
			</th>
		</tr>
	</thead>
	<? $i=1;
	foreach($patients as $patient){
		$class = ($i%2==1)?'class="task_1"':'class="task_2"';?>
		<tr <?=$class?>>
			<td style="white-space: nowrap;">
				<?=Html::anchor('patient/data_patient/'.$patient->id, $patient->fio)?>
			</td>
			<td>
				<?=$patient->sex==0?'Mужской':'Женский'?>
			</td>
			<td>
				<?=$patient->year?>
			</td>
			<td>
				<?=$patient->history?>
			</td>
			<td>
				<?=$patient->department?>
			</td>
			<td align="left">
				<?=$patient->diagnosis?>
			</td>
			<td>
				<?=date('d.m.Y', $patient->date_add)?>
			</td>
		</tr>
	<?}?>
</table>

<div id="pages" class="center"><?=$page_list?></div>