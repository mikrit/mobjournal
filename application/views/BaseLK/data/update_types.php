<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="t-center">
	<div id="title" style="width: 350px;">Обновить статус гена</div>

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
					<label>Статус гена:</label>
					<?=Form::input('title', $data['title'], array('class' => 'form-control'));?>
				</td>
			</tr>
			<tr>
				<td>
					<label>Исследование:</label><br/>
					<?foreach($methods as $method_id => $method){?>
						<?=Form::checkbox('method_'.$method_id, 1, $data['method_'.$method_id] == 0 ? false : true)." ".$method?><br/>
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