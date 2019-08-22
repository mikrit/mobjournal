<?php defined('SYSPATH') or die('No direct script access.');?>

<table id="table_print_top">
	<tr>
		<td width="15%">
			<?=HTML::image('media/img/logo_4.png', array('id' => 'print_img2'))?>
		</td>
		<td width="35%" style="text-align: left">
			Молекулярно<br/>
			Биологичкская<br/>
			Лаборатория
		</td>
		<td width="50%">
			г.Москва, Каширское шоссе д.23<br/>
			ФГБУ "НМИЦ онкологии им. Н.Н.Блохина", зона Б-5<br/>
			<b>Тел. 8(499) 324-11-54</b><br/>
			e-mail: info@molbiolab.ru
		</td>
	</tr>
</table>

<table class="table_print" style="border: 1px solid #000" border="0">
	<tr>
		<td>
			ФИО: <b><?=$data->patient->fio?></b>
		</td>
		<td>
			№ Исследования: <b><?=$data->number_a?></b>
		</td>
	</tr>
	<tr>
		<td>
			Пол: <b><?=$data->patient->sex==0?'Mужской':'Женский'?></b>
		</td>
		<td>
			Диагноз: <b><?=$data->patient->diagnosis?></b>
		</td>
	</tr>
	<tr>
		<td>
			Год рождения: <b><?=$data->patient->year?></b>
		</td>
		<td>
			Материал: <?=$data->material_count?>
		</td>
	</tr>
</table>

<table class="table_print">
	<tr>
		<td>
			Методы:
		</td>
		<td>
			<?foreach($data->methods->find_all() as $method){?>
				<b><?=$method->title?></b><br/>
			<?}?>
		</td>
	</tr>
</table>

<table class="table_print" style="border-collapse: collapse; border: 1px solid #000">
	<tr>
		<th width="50%" style="border: 1px solid #000;">Исследование</th>
		<th width="50%" style="border: 1px solid #000;">Статус</th>
	</tr>
	<?foreach($analizis as $analisis){?>
		<tr>
			<td style="border: 1px solid #000;"><?=$analisis->title?></td>
			<td style="border: 1px solid #000;"><?=$analisis->statuses->where('number_id', '=', $number_id)->find()->status?></td>
		</tr>
	<?}?>
</table>

<table class="table_print" style="border-collapse: collapse; border: 1px solid #000">
	<tr>
		<th style="text-align: left; border: 1px solid #000;">
			<b>Заключение исследования</b>
		</th>
	</tr>
	<tr>
		<td style="font-size: 14pt; border: 1px solid #000;">
			<?=$data->comment?>
		</td>
	</tr>
</table>

<table class="table_print" style="border-collapse: collapse; border: 1px solid #000">
	<tr>
		<th style="text-align: left; border: 1px solid #000;">
			<b>Комментарии к исследованию</b>
		</th>
	</tr>
	<tr>
		<td style="font-size: 14pt; border: 1px solid #000;">
			<?=$data->notes?>
		</td>
	</tr>
</table>

<table class="table_print2" border="0">
	<tr>
		<td>
			Дата выдачи заключения: <?=(isset($data->date_comment) ? date('d.m.Y', $data->date_comment) : date('d.m.Y')).' г.'?>
		</td>
	</tr>
	<?if($data->user1->name != NULL){?>
		<tr>
			<td>
				<?=$data->user1->position?> <?=$data->user1->name?>: ________________
			</td>
		</tr>
	<?}?>
	<?if($data->user2->name != NULL){?>
		<tr>
			<td>
				<?=$data->user2->position?> <?=$data->user2->name?>: ________________
			</td>
		</tr>
	<?}?>
	<?if($data->user3->name != NULL){?>
		<tr>
			<td>
				<?=$data->user3->position?> <?=$data->user3->name?>: ________________
			</td>
		</tr>
	<?}?>
</table>

<script type="text/javascript">
	/*var is_chrome = function () { return Boolean(window.chrome); }
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
	}*/
</script>