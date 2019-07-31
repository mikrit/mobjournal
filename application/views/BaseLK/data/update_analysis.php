<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="t-center">
	<div id="title" style="width: 350px;">Обновить вид анализа</div>
	
	<?=Form::open('data/update_analysis/'.$id, array('method'=>'post'));?>
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
				<div id="edit">
                    <?=Html::anchor('data/list_analyzes', 'Назад')?>
                </div>
			</td>
		</tr>
		<tr>
			<td>
                <label>Вид анализа:</label>
                <?=Form::input('title', $data['title'], array('class' => 'form-control'));?>
            </td>
		</tr>
		<tr>
			<td class="right">
                <?=Form::input('submit', 'Обновить', array('id' => 'button', 'type'=>'submit', 'class' => 'btn btn-primary'));?>
            </td>
		</tr>	
	</table>
	<?=Form::close();?>
</div>