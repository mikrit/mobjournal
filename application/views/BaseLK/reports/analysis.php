<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="col-lg-6 non-printable">
	<div id="title">Поиск по исследованиям</div>

	<?=Form::open('reports/analysis', array('method'=>'post'));?>
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
			<td><label>Исследование:</label></td>
			<td><?=Form::select('analysis_id', $analyzes, $data['analysis_id'], array('id' => 'analisis', 'class' => 'form-control'));?></td>
		</tr>
		<tr>
			<td><label>Статус:</label></td>
			<td><?=$statuses?></td>
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
<?}else{?>
	<div class="non-printable">
		<table class="table table-striped table-bordered">
			<?foreach($numbers_by_years as $year => $numbers){?>
			<thead>
				<tr>
					<th colspan="7" style="text-align: left">
						<?=$year?> - Количество: <?=count($numbers)?>
					</th>
				</tr>
				<tr>
					<th width="20%" style="text-align: center; vertical-align:  middle;">
						ФИО
					</th>
					<th width="10%" style="text-align: center; vertical-align:  middle;">
						Номер анализа
					</th>
					<th width="10%" style="text-align: center; vertical-align:  middle;">
						Исследования
					</th>
					<th width="30%" style="text-align: center; vertical-align:  middle;">
						Диагноз
					</th>
					<th width="10%" style="text-align: center; vertical-align:  middle;">
						История болезни
					</th>
					<th width="10%" style="text-align: center; vertical-align:  middle;">
						Статус гена
					</th>
					<th width="10%" style="text-align: center; vertical-align:  middle;">
						Дата приёма
					</th>
				</tr>
			</thead>
			<tbody>
				<?foreach($numbers as $number){?>
					<tr>
						<td>
							<?=Html::anchor('patient/data_patient/'.$number->patient->id, $number->patient->fio)?>
						</td>
						<td>
							<?=Html::anchor('patient/data_analysis/'.$number->id, $number->number_a)?>
						</td>
						<td>
							<?=$analises?>
						</td>
						<td>
							<?=$number->patient->diagnosis?>
						</td>
						<td>
							<?=$number->patient->history?>
						</td>
						<td>
							<?=$number->statuses->where('status.analysis_id', '=', $data['analysis_id'])->find()->status?>
						</td>
						<td>
							<?=date('d.m.Y', $number->date_add)?>
						</td>
					</tr>
				<?}?>
			</tbody>
			<?}?>
		</table>
		<br/>
	</div>
<?}?>



<?if($count > 0){?>
	<table class="table table-striped table-bordered printable">
		<?foreach($numbers_by_years as $year => $numbers){?>
			<tr>
				<th colspan="7" style="text-align: left">
					<?=$year?> - Количество: <?=count($numbers)?>
				</th>
			</tr>
			<tr>
				<th width="20%" style="text-align: center; vertical-align:  middle;">
					ФИО
				</th>
				<th width="10%" style="text-align: center; vertical-align:  middle;">
					Номер анализа
				</th>
				<th width="10%" style="text-align: center; vertical-align:  middle;">
					Исследования
				</th>
				<th width="30%" style="text-align: center; vertical-align:  middle;">
					Диагноз
				</th>
				<th width="10%" style="text-align: center; vertical-align:  middle;">
					История болезни
				</th>
				<th width="10%" style="text-align: center; vertical-align:  middle;">
					Статус гена
				</th>
				<th width="10%" style="text-align: center; vertical-align:  middle;">
					Дата приёма
				</th>
			</tr>
			<?foreach($numbers as $number){?>
				<tr>
					<td>
						<?=$number->patient->fio?>
					</td>
					<td>
						<?=$number->number_a?>
					</td>
					<td>
						<?=$analises?>
					</td>
					<td>
						<?=$number->patient->diagnosis?>
					</td>
					<td>
						<?=$number->patient->history?>
					</td>
					<td>
						<?=$number->statuses->where('status.analysis_id', '=', $data['analysis_id'])->find()->status?>
					</td>
					<td>
						<?=date('d.m.Y', $number->date_add)?>
					</td>
				</tr>
			<?}?>
		<?}?>
	</table>
<?}?>

<script>
	$('#statuses').change(function(){

	});
</script>