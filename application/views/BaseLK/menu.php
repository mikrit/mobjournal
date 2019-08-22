<?php defined('SYSPATH') or die('No direct script access.');?>

<?$request = explode("/", Request::current()->uri());?>

<ul class="nav navbar-nav">
	<li <?if($request[0] == 'main'){echo 'class="active"';}?>>
		<?=HTML::anchor('main', 'Журнал'); ?>
	</li>
	<li <?if($request[0] == 'patient'){echo 'class="active"';}?>>
		<?=HTML::anchor('patient', 'Пациенты'); ?>
	</li>
	<li <?if($request[0] == 'data'){echo 'class="active"';}?>>
		<?=HTML::anchor('data', 'Добавление данных'); ?>
	</li>
	<li <?if($request[0] == 'reports'){echo 'class="active"';}?>>
		<?=HTML::anchor('reports', 'Отчёты'); ?>
	</li>
	<?php if($admin){?>
		<li <?if($request[0] == 'adminka'){echo 'class="active"';}?>>
			<?=HTML::anchor('adminka', 'Админка'); ?>
		</li>
	<?}else{?>
		<li <?if($request[0] == 'user'){echo 'class="active"';}?>>
			<?=HTML::anchor('user', 'Личный кабинет'); ?>
		</li>
	<?}?>
</ul>

<ul class="nav navbar-nav navbar-right">
	<li>
		<?=HTML::anchor('auth/logout', 'Выход');?>
	</li>
	<li>
		<!--div id="balance" style="display: block;padding-top: 30px;"><b>Баланс: <?=$balance?></b></div-->
	</li>
</ul>