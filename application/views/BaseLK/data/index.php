<?php defined('SYSPATH') or die('No direct script access.');?>

<div id="title">Редактирование данных системы</div>

<table id="user">
	<tr>
		<td>
			<?=Html::anchor('data/list_types', 'Типы исследований');?>
			<br/>
			<?=Html::anchor('data/list_methods', 'Методы исследования');?>
			<br/>
			<?=Html::anchor('data/list_analyzes', 'Исследования');?>
			<br/>
			<?=Html::anchor('data/list_statuses', 'Стутус гена');?>
			<br/>
		</td>
	</tr>
</table>