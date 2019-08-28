<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="t-center">
	<div id="title">Новый анализ для <?=$patient?></div>

	<?=Form::open('patient/add_analysis/'.$id, array('method'=>'post'));?>
		<table class="t_form">
			<?php if(count($errors)):?>
				<?php foreach ($errors as $error):?>
					<tr>
						<td class="error" colspan="2"><?=$error?></td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>
			<tr><td colspan="2" style="color: green"><?=$message?></td></tr>
			<tr>
				<td class="right" colspan="3">
					<div id="edit"><?=Html::anchor('patient/data_patient/'.$id, 'Назад')?></div>
				</td>
			</tr>
			<tr>
				<td>Тип анализа:</td>
				<td colspan="2"><?=Form::select('type_id', $types, $data['type_id'], array('id' => 'type_id', 'class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Номер анализа:</td>
				<td colspan="2"><?=Form::input('number_a', $data['number_a'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Номер материала:</td>
				<td colspan="2"><?=Form::input('material_number', $data['material_number'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Кол-во материала:</td>
				<td colspan="2"><?=Form::input('material_count', $data['material_count'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Метод исследования:</td>
				<td id="method_id" colspan="2">
					<?foreach($methods as $method_id => $method){?>
						<div class="checkbox">
							<label><?=Form::checkbox('method_'.$method_id, 1, $data['method_'.$method_id] == 0 ? false : true)." ".$method?></label>
						</div>
					<?}?>
				</td>
			</tr>
			<tr>
				<td>Оплата:</td>
				<td colspan="2"><?=Form::select('payment', array(0 => 'ОМС', 1 => 'Платно'), $data['payment'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td rowspan="<?=ceil(count($analyzes)/2)+1?>">Исследования:</td>
			</tr>
			<tr>
				<?$i=0;foreach($analyzes as $k => $v){?>
					<?$i++?>
					<td>
						<?=Form::checkbox('analysis_'.$k, 1, $data['analysis_'.$k] == 0 ? false : true)." ".$v?>
						<br/>
						<?
							$analysis = ORM::factory('analysis', $k);
							$orm = $analysis->statuses2->find_all();

							$statuses = array(0 => '-');
							foreach($orm as $status){
								$statuses[$status->id] = $status->status;
							}

							echo Form::select('status_'.$k, $statuses, $data['status_'.$k]);
						?>
					</td>
					<?if($i % 2 == 0){?>
						</tr>
						<tr>
					<?}?>
				<?}?>
			</tr>
			<tr>
				<td>Развёрнутый диагноз:</td>
				<td colspan="2"><?=Form::textarea('comment', $data['comment'], array('id' => 'comment', 'class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Примечания:</td>
				<td colspan="2"><?=Form::textarea('notes', $data['notes'], array('id' => 'notes', 'class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Сотрудник 1:</td>
				<td colspan="2"><?=Form::select('user1_id', $sings, $data['user1_id'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Сотрудник 2:</td>
				<td colspan="2"><?=Form::select('user2_id', $sings, $data['user2_id'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Сотрудник 3:</td>
				<td colspan="2"><?=Form::select('user3_id', $sings, $data['user3_id'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td class="right" colspan="3"><?=Form::input('submit', 'Добавить',array('id' => 'button', 'type'=>'submit', 'class' => 'btn btn-primary'));?></td>
			</tr>
		</table>
	<?=Form::close();?>
</div>

<script>
	$('#button').click(function(){
		$(this).disabled();
	});

	$('#type_id').change(function(){
		var type_id = $(this).val();

		$.ajax({
			type: "POST",
			url: '/ajax/change_type',
			dataType: "json",
			data: {
				type_id: type_id
			}
		}).done(function(data)
		{
			if(data.error == 1)
			{
				$('#answer_e').html(data.res);
				return false;
			}
			else
			{
				$('#method_id').html(data.methods);
			}
		});

		return false;
	});
</script>