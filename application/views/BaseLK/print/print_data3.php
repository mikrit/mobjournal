<?php defined('SYSPATH') or die('No direct script access.');?>

<table class="table_print">
	<tr>
		<td colspan="2">
			<div style="float: left; margin-right: 10px;">
				<?=HTML::image('media/img/logo_4.png', array('id' => 'print_img2'))?>
			</div>
			<div style="font-size: 18px; padding-bottom: 25px;">
				Молекулярно<br/>
				Биологичкская<br/>
				Лаборатория
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			г.Москва, Каширское шоссе д. 23, каб. 2193<br/><br/>
		</td>
	</tr>
	<tr>
		<td width="60%">
			Часы приема пациентов:<br/><br/>
			Пн.-Чт.: с 9.00 до 17.00<br/><br/>
			Пт.: с 9.00 до 16.00<br/>
		</td>
		<td width="40%">
			e-mail: info@molbiolab.ru<br/><br/>
			сайт: molbiolab.ru<br/><br/>
			тел.: <b>8(499) 324-11-54</b><br/>
		</td>
	</tr>
	<tr>
		<td>
			ФИО пациента: <b><?=$data->patient->fio?></b>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			Наименование исследования: <b>
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
	</tr>
	<tr>
		<td>
			№ исследования: <b><?=$data->number_a?></b>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			Принят материал: № <b><?=$data->material_number?></b><br/>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			Кол-во материала: <b><?=$data->material_count?></b>
		</td>
		<td>
			Дата: <b><?=date('d.m.Y', $data->date_add)?></b>
		</td>
	</tr>
	<tr>
		<td>
			Сумма: ________________________
		</td>
		<td>
		</td>
	</tr>
</table>

<table class="table_print" id="border">
	<tr>
		<td width="49%" id="border_right">
			<br/>
			<div style="float: left; margin-right: 10px;">
				<?=HTML::image('media/img/logo_4.png', array('id' => 'print_img_'))?>
			</div>

			ФИО пациента: <b><?=$data->patient->fio?></b><br/>
			№ исследования: <b><?=$data->number_a?></b><br/>
			№ материала: <?=$data->material_number?><br/>
			Кол-во материала: <?=$data->material_count?>

			<br/><br/>
			<b>Хранить гистологический материал при температуре от +10 до +25&#8451;, в сухом и темном месте.</b>

			<br/>
			<br/>
			<hr>

			Исследования: <b>
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

		</td>
		<td width="1%" style="border-left: 1px dashed;"></td>
		<td width="50%" align="left" rowspan="2" id="left_row">
			<br/>
			<div style="text-align: center;">ФГБУ «НМИЦ онкологии<br/>им. Н.Н. Блохина» Минздрава России</div>
			<br/>
			ФИО пациента: <b><?=$data->patient->fio?></b>
			<br/>
			<br/>

			Исследование: <b>
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

			<br/>
			Сумма: ___________________
			<br/>

			<br/>
			Код услуги: _______________
		</td>
	</tr>
</table>

<p class="more">
	<table class="table_print">
		<tr>
			<td>
				ФИО: <b><?=$data->patient->fio?></b>
			</td>
			<td>
				№ Исследования: <b><?=$data->number_a?></b>
			</td>
		</tr><tr>
			<td>
				Пол: <b><?=$data->patient->sex==0?'Mужской':'Женский'?></b>
			</td>
			<td>
				Исследования: <b>
					<?
					for($i=0; $i < $analizis_count-1; $i++)
					{
						echo $analizis[$i]->title.", ";
					}
					echo $analizis[$i]->title;
					?>
				</b>
			</td>
		</tr>
		<tr>
			<td>
				Год рождения: <b><?=$data->patient->year?></b>
			</td>
			<td>
				История болезни: <b><?=$data->patient->history?></b>
			</td>
		</tr>
		<tr>
			<td>
				Отделение: <b><?=$data->patient->department?></b>
			</td>
			<td>
				Диагноз: <b><?=$data->patient->diagnosis?></b>
			</td>
		</tr>
		<tr>
			<td>
				№ материала: <b><?=$data->material_number?></b>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td>
				Кол-во принятого материала: <b><?=$data->material_count?></b>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td>
				Контактный № телефона: <b style="font-size: 18px;"><?=$data->patient->phone?></b>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td>
				Электронная почта: _________________
			</td>
			<td>
			</td>
		</tr>
	</table>

	<table class="table_print" style="font-size: 19px;">
		<tr>
			<td style="text-align: justify;">
				Я, получив полные и всесторонние разъяснения, включая исчерпывающие ответы на заданные мной вопросы, касающиеся молекулярно-генетических исследований,
				согласен со сроками проведения исследований (2-3 недели с момента подачи заявления). Уведомлен о стоимости исследований.
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">
				Подпись____________________
			</td>
		</tr>
	</table>

	<table class="table_print" style="font-size: 19px;">
		<tr>
			<td>
				<b>Согласие на обработку персональных данных пациента</b>
			</td>
		</tr>
		<tr>
			<td style="text-align: justify;">
				Я, ____________________________________________________________ (пациент, законный представитель) в соответствии со статьей 9 Федерального закона от 27.07.2006 №152-Ф3
				«О персональных данных» даю свое согласие ФГБУ «НМИЦ онкологии им. Н.Н. Блохина» Минздрава России, на обработку автоматизированной и без
				использования автоматизации (в т.ч. по телефону) персональных данных, а именно: ФИО, дата рождения, № телефона, сведения о состоянии здоровья.<br/><br/>
				Настоящее согласие вступает в силу со дня его подписания до дня отзыва  в письменной форме.<br/><br/>
				ФИО заказчика:__________________________ подпись_______________ дата_______________
			</td>
		</tr>
		<tr>
			<td>
				<br/>
				<hr>
				<br/><br/>
				Материал забрал ФИО:____________________ подпись_______________ дата_______________
			</td>
		</tr>
	</table>
</p>

<script type="text/javascript">
	/*var is_chrome = function () {
		return Boolean(window.chrome);
	};

	if(is_chrome)
	{
		window.print();
		setTimeout(function(){
			window.close();
		}, 10000);
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