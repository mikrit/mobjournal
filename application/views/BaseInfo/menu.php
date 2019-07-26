<?php defined('SYSPATH') or die('No direct script access.')?>

<?$request = explode("/", Request::current()->uri());?>

<ul class="nav navbar-nav">
	<li <?if($request[0] == ''){echo 'class="active"';}?>>
		<?HTML::anchor('/', 'Анализы'); ?>
	</li>
	<li <?if($request[0] == 'about'){echo 'class="active"';}?>>
		<?HTML::anchor('about', 'О лаборатории'); ?>
	</li>
</ul>

<?if(Auth::instance()->logged_in()){?>
	<ul class="nav navbar-nav navbar-right">
		<li>
			<?=HTML::anchor('auth/logout', 'Выход');?>
		</li>
	</ul>
<?}?>