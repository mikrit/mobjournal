<?php defined('SYSPATH') or die('No direct script access.');?>

<style>
	.nav-tabs > li.active > a,
	.nav-tabs > li.active > a:focus,
	.nav-tabs > li.active > a:hover {
		font-weight: bold;
	}

	.nav-tabs {
		border-bottom: 0px solid #ddd;
	}

	.rub {
		line-height: 5px;
		width: 0.4em;
		border-bottom: 1px solid #000;
		display: inline-block;
	}
</style>

<div class="col-lg-6">
	<div id="title">Поиск</div>

	<?=Form::open('main', array('method'=>'get', 'class' => 'form-horizontal'));?>
	<table class="t_form">
		<tr>
			<td><label>Год анализа:</label></td>
			<td><?=Form::input('year', $data['year'], array('class' => 'form-control', 'type' => 'text'));?></td>
		</tr>
		<tr>
			<td><label>ФИО пациента:</label></td>
			<td><?=Form::input('fio', $data['fio'], array('class' => 'form-control', 'type' => 'text'));?></td>
		</tr>
		<tr>
			<td><label>Порядковый номер:</label></td>
			<td><?=Form::input('number_p', $data['number_p'], array('class' => 'form-control', 'type' => 'text'));?></td>
		</tr>
		<tr>
			<td><label>Номер анализа:</label></td>
			<td><?=Form::input('number_a', $data['number_a'], array('class' => 'form-control', 'type' => 'text'));?></td>
		</tr>
		<tr>
			<td><label>Номер материала:</label></td>
			<td><?=Form::input('material_number', $data['material_number'], array('class' => 'form-control', 'type' => 'text'));?></td>
		</tr>
		<tr>
			<td class="right" colspan="2">
				<?=Form::input('submit', 'Поиск', array('id' => 'button_search', 'type'=>'submit', 'class' => 'btn btn-primary'));?>
			</td>
		</tr>
	</table>
	<?=Form::close();?>
</div>

<div class="row col-lg-12">
	<ul class="nav nav-tabs">
		<li class="active">
			<a data-toggle="tab" href="#germ" aria-expanded="true">Герминогенные</a>
		</li>
		<li>
			<a data-toggle="tab" href="#somat" aria-expanded="false">Соматика</a>
		</li>
	</ul>

	<div class="tab-content">
		<div id="germ" class="tab-pane fade active in">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>
							№
						</th>
						<th>
							Статус
						</th>
						<th>
							№ анализа
						</th>
						<th>
							ФИО
						</th>
						<th>
							Год рож.
						</th>
						<th>
							Истор. бол.
						</th>
						<th>
							№ материала
						</th>
						<th>
							Кол-во материала
						</th>
						<th>
							Диагноз
						</th>
						<th>
							Дата приёма
						</th>
						<th>
							<span class="rub">Р</span>
						</th>
					</tr>
				</thead>
				<?$i=1;?>
				<?foreach($numbers as $number){?>
					<?$class = ($i % 2 == 1) ? 'class="task_1"' : 'class="task_2"';?>
					<tr>
						<th scope="row">
							<?=$number->number_p?>
						</th>
						<td class="text-center">
							<?="<a id='$number->id' href=javascript:change_status('$number->id')>".Html::image('media/img/'.$number->status.'.png', array('alt' => $statuses[$number->status], 'title' => $statuses[$number->status], 'width' => 32, 'height' => 32))."</a>" ?>
						</td>
						<td>
							<?=Html::anchor('patient/data_analysis/'.$number->id, $number->number_a)?>
						</td>
						<td>
							<?=Html::anchor('patient/data_patient/'.$number->pid, $number->fio)?>
						</td>
						<td>
							<?=$number->patient->year?>
						</td>
						<td>
							<?=$number->patient->history?>
						</td>
						<td>
							<?=$number->material_number?>
						</td>
						<td>
							<?=$number->material_count?>
						</td>
						<td>
							<?=$number->patient->diagnosis?>
						</td>
						<td>
							<?=date('d.m.Y', $number->date_add)?>
						</td>
						<td>
							<?if($number->payment == 1){?>
								<span class="rub">Р</span>
							<?}?>
						</td>
					</tr>
					<?$i++;?>
				<?}?>
			</table>

			<div id="pages" class="center"><?=$page_list?></div>
		</div>
		<div id="somat" class="tab-pane fade">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>
							№
						</th>
						<th>
							Статус
						</th>
						<th>
							№ анализа
						</th>
						<th>
							ФИО
						</th>
						<th>
							Год рож.
						</th>
						<th>
							Истор. бол.
						</th>
						<th>
							№ материала
						</th>
						<th>
							Кол-во материала
						</th>
						<th>
							Диагноз
						</th>
						<th>
							Дата приёма
						</th>
						<th>
							<span class="rub">Р</span>
						</th>
					</tr>
				</thead>
				<?$i=1;?>
				<?foreach($numbers2 as $number){?>
					<?$class = ($i % 2 == 1) ? 'class="task_1"' : 'class="task_2"';?>
					<tr>
						<th scope="row">
							<?=$number->number_p?>
						</th>
						<td class="text-center">
							<?="<a id='$number->id' href=javascript:change_status('$number->id')>".Html::image('media/img/'.$number->status.'.png', array('alt' => $statuses[$number->status], 'title' => $statuses[$number->status], 'width' => 32, 'height' => 32))."</a>" ?>
						</td>
						<td>
							<?=Html::anchor('patient/data_analysis/'.$number->id, $number->number_a)?>
						</td>
						<td>
							<?=Html::anchor('patient/data_patient/'.$number->pid, $number->fio)?>
						</td>
						<td>
							<?=$number->patient->year?>
						</td>
						<td>
							<?=$number->patient->history?>
						</td>
						<td>
							<?=$number->material_number?>
						</td>
						<td>
							<?=$number->material_count?>
						</td>
						<td>
							<?=$number->patient->diagnosis?>
						</td>
						<td>
							<?=date('d.m.Y', $number->date_add)?>
						</td>
						<td>
							<?if($number->payment == 1){?>
								<span class="rub">Р</span>
							<?}?>
						</td>
					</tr>
					<?$i++;?>
				<?}?>
			</table>

			<div id="pages" class="center"><?=$page_list2?></div>
		</div>
	</div>
</div>