<?php defined('SYSPATH') or die('No direct script access.');?>

<div id="title">Исследования</div>

<div id="edit">
    <?=Html::anchor('data/add_analysis/', '+ Добавить новое исследование')?>
</div>
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
	        Исследования
        </td>
    </tr>
	<? $i=1;
	foreach($data as $analysis){
		$class = ($i % 2 == 1) ? 'class="task_1"' : 'class="task_2"';?>
		<tr <?=$class?>>
			<td>
				<?=$i++?>
			</td>
			<td>
				<?=Html::anchor('data/update_analysis/'.$analysis->id, $analysis->title)?>
			</td>
		</tr>
	<?}?>
</table>