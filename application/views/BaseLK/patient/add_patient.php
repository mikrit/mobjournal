<?php defined('SYSPATH') or die('No direct script access.');?>

<?=Html::script('media/js/bootstrap-formhelpers-phone.js')?>

<div class="t-center">
    <div id="title">Добавление пациента</div>

	<?=Form::open('patient/add_patient', array('method'=>'post'));?>
		<table class="t_form">
			<?php if(count($errors)):?>
				<?php foreach ($errors as $error):?>
					<tr>
						<td class="error" colspan="2"><?=$error?></td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>

			<tr><td colspan="2" style="color: green"><?=$message?></td></tr>
			<!--tr>
			<td class="right" colspan="2">
			<div id="edit"><?=Html::anchor('patient', 'Назад')?></div>
			</td>
			</tr-->
			<tr>
				<td>ФИО:</td>
				<td><?=Form::input('fio', $data['fio'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Пол:</td>
				<td><?=Form::select('sex', $sex, $data['sex'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Год рождения:</td>
				<td><?=Form::input('year', $data['year'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Телефон:</td>
				<td><?=Form::input('phone', $data['phone'], array('class' => 'form-control input-medium bfh-phone', 'data-format' => '+7 (ddd) ddd-dddd', 'required' => ''));?></td>
			</tr>
			<tr>
				<td>Контакты:</td>
				<td><?=Form::input('contacts', $data['contacts'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>История болезни:</td>
				<td><?=Form::input('history', $data['history'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Отделение:</td>
				<td><?=Form::input('department', $data['department'], array('class' => 'form-control'));?></td>
			</tr>
			<tr>
				<td>Диагноз:</td>
				<td><?=Form::textarea('diagnosis', $data['diagnosis'], array('class' => 'form-control', 'id' => 'notes'));?></td>
			</tr>
			<tr>
				<td class="right" colspan="2"><?=Form::input('submit', 'Добавить',array('class' => 'btn btn-primary', 'id' => 'button', 'type'=>'submit'));?></td>
			</tr>
		</table>
	<?=Form::close();?>
</div>