<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="t-center">
    <div id="title" style="width: 350px;">Добавление статуса гена</div>

    <?=Form::open('data/add_status/',array('method'=>'post'));?>
    <table class="t_form">
        <?php if(count($errors)){?>
            <?php foreach ($errors as $error){?>
                <tr>
                    <td class="error"><?=$error?></td>
                </tr>
            <?}?>
        <?}?>
        <tr><td style="color: green"><?=$message?></td></tr>
        <tr>
            <td class="right">
                <div id="edit"><?=Html::anchor('data/list_statuses', 'Назад')?></div>
            </td>
        </tr>
		<tr>
			<td>
                <label>Исследование:</label>
                <?=Form::select('analysis_id', $analyzes, $data['analysis_id'], array('class' => 'form-control'));?>
            </td>
		</tr>
        <tr>
            <td>
                <label>Статус гена:</label>
                <?=Form::input('status', $data['status'], array('class' => 'form-control'));?>
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