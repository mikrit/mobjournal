<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="col-lg-6 non-printable">
	<div id="title">По статусу готовности</div>

	<?=Form::open('reports/status', array('method'=>'post'));?>
		<table class="t_form">
			<tr>
				<td class="right" colspan="2">
					<div id="edit"><?=Html::anchor('reports', 'Назад')?></div>
				</td>
			</tr>
			<tr>
				<td><label>С:</label></td>
				<td><?=Form::input('to', preg_match('/\d{6,}/', $data['to']) ? date('Y-m-d', $data['to']) : $data['to'], array('name' => 'date', 'class' => 'form-control date_input'));?></td>
			</tr>
			<tr>
				<td><label>По:</label></td>
				<td><?=Form::input('from', preg_match('/\d{6,}/', $data['from']) ? date('Y-m-d', $data['from']) : $data['from'], array('name' => 'date', 'class' => 'form-control date_input'));?></td>
			</tr>
			<tr>
				<td><label>Статус:</label></td>
				<td><?=Form::select('status', $statuses, $data['status'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td class="right" colspan="2">
					<?=Form::input('submit', 'Поиск', array('id' => 'button_search', 'type'=>'submit', 'class' => 'btn btn-primary'));?>
				</td>
			</tr>
		</table>
	<?=Form::close();?>
</div>

<?if($count == 0){?>
	<center><h2>Ничего не найдено</h2></center>
<?}else if($count > 0){?>
	<table class="table table-striped table-bordered non-printable">
		<thead>
			<tr>
				<th width="4%">
					№
				</th>
				<th width="10%">
					Статус
				</th>
				<th width="10%">
					№ анализа
				</th>
				<th width="20%">
					ФИО
				</th>
				<th width="10%">
					Истор. бол.
				</th>
				<th width="10%">
					Дата приёма
				</th>
				<th width="18%">

				</th>
				<th width="18%">

				</th>
			</tr>
		</thead>
		<?foreach($numbers as $number){?>
			<tr>
				<th scope="row">
					<?=$number->number_p?>
				</th>
				<td>
					<?=$statuses[$number->status]?>
				</td>
				<td>
					<?=$number->number_a?>
				</td>
				<td>
					<?=$number->patient->fio?>
				</td>
				<td>
					<?=$number->patient->history?>
				</td>
				<td>
					<?=date('d.m.Y', $number->date_add)?>
				</td>
				<td>

				</td>
				<td>

				</td>
			</tr>
		<?}?>
	</table>
<?}?>

<?if($count > 0){?>
	<table class="table table-striped table-bordered printable">
		<thead>
			<tr>
				<th width="4%">
					№
				</th>
				<th width="10%">
					Статус
				</th>
				<th width="10%">
					№ анализа
				</th>
				<th width="20%">
					ФИО
				</th>
				<th width="10%">
					Истор. бол.
				</th>
				<th width="10%">
					Дата приёма
				</th>
				<th width="18%">

				</th>
				<th width="18%">

				</th>
			</tr>
		</thead>
		<?$i=1;foreach($numbers as $number){?>
			<?$class = ($i%2==1)?'class="cc1"':'class="cc2"';?>
			<tr <?=$class?>>
				<th scope="row">
					<?=$number->number_p?>
				</th>
				<td>
					<?=$statuses[$number->status]?>
				</td>
				<td>
					<?=$number->number_a?>
				</td>
				<td>
					<?=$number->patient->fio?>
				</td>
				<td>
					<?=$number->patient->history?>
				</td>
				<td>
					<?=date('d.m.Y', $number->date_add)?>
				</td>
				<td>

				</td>
				<td>

				</td>
			</tr>
			<?$i++;}?>
	</table>
<?}?>

<br/>