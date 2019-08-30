<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="t-center">
	<div id="title" style="width: 350px;">Обновить тип исследования</div>

	<?=Form::open('data/update_types/'.$id, array('method' => 'post'));?>
		<table class="t_form">
			<?if(count($errors)){?>
				<?foreach($errors as $error){?>
					<tr>
						<td class="error"><?=$error?></td>
					</tr>
				<?}?>
			<?}?>
			<tr>
				<td style="color: green">
					<?=$message?>
				</td>
			</tr>
			<tr>
				<td class="right">
					<div id="edit">
						<?=Html::anchor('data/list_types', 'Назад')?>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label>Тип исследования:</label>
					<?=Form::input('title', $data['title'], array('class' => 'form-control'));?>
				</td>
			</tr>
			<tr>
				<td>
					<label>Методы исследования:</label><br/>
					<?if(count($methods) == 0){?>
						Нет ни одного "Метода исследования"
					<?}?>
					<?foreach($methods as $method_id => $method){?>
						<?=Form::checkbox('method_'.$method_id, 1, $data['method_'.$method_id] == 0 ? false : true)." ".$method?><br/>
					<?}?>
				</td>
			</tr>
			<tr>
				<td>
					<label>Исследования:</label><br/>
					<?if(count($analyzes) == 0){?>
						Нет ни одного "Исследования"
					<?}?>
					<?foreach($analyzes as $analysis_id => $analysis){?>
						<?=Form::checkbox('analysis_'.$analysis_id, 1, $data['analysis_'.$analysis_id] == 0 ? false : true)." ".$analysis?><br/>
					<?}?>
				</td>
			</tr>
			<tr>
				<td class="right">
					<?=Form::input('submit', 'Обновить',array('id' => 'button', 'type'=>'submit', 'class' => 'btn btn-primary'));?>
				</td>
			</tr>
		</table>
	<?=Form::close();?>
</div>