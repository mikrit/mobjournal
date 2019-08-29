<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="t-center">
    <div id="title" style="width: 350px;">Добавление исследования</div>

    <?=Form::open('data/add_analysis/', array('method'=>'post'));?>
        <table class="t_form">
            <?if(count($errors)){?>
                <?foreach ($errors as $error){?>
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
                    <div id="edit"><?=Html::anchor('data/list_analyzes', 'Назад')?></div>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Исследование:</label>
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
		$(this).disabled();
	});
</script>