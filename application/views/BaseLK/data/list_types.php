<?php defined('SYSPATH') or die('No direct script access.');?>

<div id="title">Типы анализов</div>

<table id="proj_task">
	<tr>
		<td class="right_t" colspan="8">
			<?=Html::anchor('data', 'Назад')?>
		</td>
	</tr>
	<tr id="head_tasks">
		<td>
			№
		</td>
		<td>
			Тип анализа
		</td>
		<td>
			Методы исследований
		</td>
	</tr>
	<?$i=1;?>
	<?foreach($data as $type){?>
		<?$class = ($i % 2 == 1) ? 'class="task_1"' : 'class="task_2"';?>
		<tr <?=$class?>>
			<td>
				<?=$i++?>
			</td>
			<td>
				<?=Html::anchor('data/update_types/'.$type->id, $type->title)?>
			</td>
			<td>
				<?foreach($type->methods->find_all() as $method){?>
					<?=$method->title?><br/>
				<?}?>
			</td>
		</tr>
	<?}?>
</table>