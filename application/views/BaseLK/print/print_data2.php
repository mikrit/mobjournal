<?php defined('SYSPATH') or die('No direct script access.');?>

<table class="table_print">
	<tr>
		<td width="50%">

		</td>
		<td width="50%">
			№ исследования: <b><?=$data->number_a?></b>
		</td>
	</tr>
</table>

<table class="table_print">
	<tr>
		<td width="50%">
			Наименование исследования:<b>
				<br/>
				<?
				for($i=0; $i < $analizis_count-1; $i++)
				{
					echo $analizis[$i]->title.", ";
				}

				if(isset($analizis[$i]))
				{
					echo $analizis[$i]->title;
				}
				?></b>
		</td>
		<td width="50%">
		</td>
	</tr>
	<tr>
		<td>
			ФИО: <b><?=$data->patient->fio?></b>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			Пол: <b><?=$data->patient->sex==0?'Mужской':'Женский'?></b>
		</td>
		<td>
			Год рождения: <b><?=$data->patient->year?></b>
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			Телефон: <b><?=$data->patient->phone?></b><br/>
			Контакты: <b><?=$data->patient->contacts?></b>
		</td>
	</tr>
	<tr>
		<td>
			№ истории болезни: <b><?=$data->patient->history?></b>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			Отделение: <b><?=$data->patient->department?></b>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			Диагноз: <b><?=$data->patient->diagnosis?></b>
			<br/>
		</td>
		<td>
			Материал забрал(а):
		</td>
	</tr>
	<tr>
		<td>
			Номер материала: <b><?=$data->material_number?></b><br/>
			<b><?=$data->material_count?></b>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			<div style="font-size: 11px;"><?=date('d.m.Y', $data->date_add)?></div>
		</td>
		<td>
		</td>
	</tr>
</table>

<table class="table_print" id="border">
	<tr>
		<td width="49%" align="center" id="border_right">
			<br/>
			<?=HTML::image('media/img/logo_4.png', array('id' => 'print_img'))?>
			<br/>
			ФИО: <b><?=$data->patient->fio?></b>
			<br/><br/>
			Наименование исследования: <b>
				<br/>
				<?
				for($i=0; $i < $analizis_count-1; $i++)
				{
					echo $analizis[$i]->title.", ";
				}
				if(isset($analizis[$i]))
				{
					echo $analizis[$i]->title;
				}
				?></b>
			<br/><br/>
			№ исследования: <b><?=$data->number_a?></b>
		</td>
		<td width="1%" style="border-left: 1px dashed;"></td>
		<td width="50%" align="left" rowspan="2" id="left_row">
			<br/>
			<div style="float: left; margin-right: 5px;">
				<?=HTML::image('media/img/logo_4.png', array('id' => 'print_img_'))?>
			</div>
			ООО «КОД-МЕД-БИО»<br/>
			Часы приема пациентов:<br/>
			Пн.-Чт.: с 10.00 до 16.00<br/>
			Пт.: с 10.00 до 15.00<br/>
			e-mail: labgenpat@mail.ru<br/>
			<b>Тел. 8(499) 324-17-49</b><br/>
			сайт: <b>labgenpat.ru</b><br/>
			<br/>

			Наименование исследования: <b>
				<br/>
				<?
				for($i=0; $i < $analizis_count-1; $i++)
				{
					echo $analizis[$i]->title.", ";
				}
				if(isset($analizis[$i]))
				{
					echo $analizis[$i]->title;
				}
				?></b>
			<br/><br/>

			№ исследования: <b><?=$data->number_a?></b>
			<br/>
			ФИО: <b><?=$data->patient->fio?></b>
			<br/>
			<br/>
			Сумма: ___________________
			<br/>
			<br/>
			<table style="float: left;border: 1px solid black;">
				<tr>
					<td style="padding-bottom: 0px!important;">
						<span>Био &#10003;</span>
					</td>
				</tr>
			</table>&nbsp;
			Код: _______________
		</td>
	</tr>
</table>

<script type="text/javascript">
	var is_chrome = function () {
		return Boolean(window.chrome);
	};

	if(is_chrome)
	{
		window.print();
		setTimeout(function(){
			window.close();}, 10000);
		//give them 10 seconds to print, then close
	}
	else
	{
		$(function(){
			window.print();
			self.close();
		});
	}
</script>