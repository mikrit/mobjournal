<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="t-center">
	<div id="title" style="width: 350px;">Добавление метода исследования</div>

	<?=Form::open('data/add_method/', array('method' => 'post'));?>
		<table class="t_form">
			<?php if(count($errors)){?>
				<?php foreach ($errors as $error){?>
					<tr>
						<td class="error" colspan="2"><?=$error?></td>
					</tr>
				<?}?>
			<?}?>
			<tr><td style="color: green"><?=$message?></td></tr>
			<tr>
				<td class="right">
					<div id="edit"><?=Html::anchor('data/list_methods', 'Назад')?></div>
				</td>
			</tr>
			<tr>
				<td>
					<label>Метод исследования:</label>
					<?=Form::input('title', $data['title'], array('class' => 'form-control'));?>
				</td>
			</tr>
			<tr>
				<td class="right">
					<?=Form::input('submit', 'Добавить', array('id' => 'button', 'type'=>'submit', 'class' => 'btn btn-primary'));?>
				</td>
			</tr>
		</table>
	<?=Form::close();?>
</div>

<script>
	$('#button').click(function(){
		$(this).prop('disabled', true);
	});
</script>